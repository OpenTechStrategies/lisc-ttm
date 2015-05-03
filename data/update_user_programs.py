#!/bin/env python3

import MySQLdb as mdb
import sys
import csv

#### @@: Should we rename Privilege_Id to Site_ID?  What's clearer?

CREATE_TABLE_SQL = """
  CREATE TABLE `Users_Program_Access`(
         `Program_Access_Id` int(11) NOT NULL AUTO_INCREMENT,
         PRIMARY KEY (`Program_Access_Id`),
         `Users_Privileges_Id` int(11),
         FOREIGN KEY (`Users_Privileges_Id`) REFERENCES `Users_Privileges`
                 (`Users_Privileges_Id`)
                 ON DELETE CASCADE
                 ON UPDATE CASCADE,
         FOREIGN KEY (`Privilege_Id`) REFERENCES `Privileges`
                 (`Privilege_Id`)
                 ON DELETE CASCADE
                 ON UPDATE CASCADE,
         `Program_Access` int(1)
  ) ENGINE=InnoDB;
"""

DROP_COLUMN_SQL = "ALTER TABLE Users_Privileges DROP COLUMN Program_Access;"


def create_table(conn):
    print("Creating new table...")
    cur = conn.cursor()
    cur.execute(CREATE_TABLE_SQL)
    print("...done.")


INSERT_DATA_TEMPLATE = """
INSERT INTO Users_Program_Access (Users_Privileges_Id,
                                  Program_Access, Privilege_Id)
VALUES (%s, %s, %s)"""


def get_all_programs_on_site(conn, table_name="Programs"):
    """
    For users with "all" access, we need all the program ids for a site

    This is stored in usually the "Programs" table, unless you're
    LSNA, in which case it's "Subcategories"
    """
    cur = conn.cursor()
    cur.execute("select Program_ID from %s" % conn.escape_string(table_name))
    return [row[0] for row in cur.fetchall()]


SITE_ALL_ID = 1
SITE_LSNA_ID = 2
SITE_BICKERDIKE_ID = 3
SITE_TRP_ID = 4
SITE_SWOP_ID = 5
SITE_ENLACE_ID = 6

SITES_WITH_PROGRAMS = (SITE_LSNA_ID, SITE_BICKERDIKE_ID,
                       SITE_TRP_ID, SITE_ENLACE_ID)

def copy_over_access_data(core_conn, enlace_conn, bickerdike_conn,
                          lsna_conn, swop_conn, trp_conn):
    print("Copying over data...")
    cur = core_conn.cursor()
    cur.execute("SELECT Users_Privileges_Id, Program_Access, Privilege_Id "
                "FROM Users_Privileges")
    # Privilege_Id really probably should be called "site id"?
    # Anyway, hence the mismatch with above.
    for user_priv_id, program_access, site_id in cur.fetchall():
        # Not great code, overly nesty, but it's a one-off script :p
        if program_access == "a":
            if site_id == "1":
                for this_site_id in SITES_WITH_PROGRAMS:
                    # LSNA calls theirs
                    if this_site_id == SITE_LSNA_ID:
                        table_name = "Subcategories"
                    else:
                        table_name = "Programs"

                    programs = get_all_programs_on_site(
                        this_site_id, table_name)
                    for program in programs:
                        cur.execute(
                            INSERT_DATA_TEMPLATE % (
                                core_conn.escape_string(user_priv_id),
                                core_conn.escape_string(program),
                                core_conn.escape_string(this_site_id)))
            else:
                programs = get_all_programs_on_site(site_id)
                for program in programs:
                    cur.execute(
                        INSERT_DATA_TEMPLATE % (
                            core_conn.escape_string(user_priv_id),
                            core_conn.escape_string(program),
                            core_conn.escape_string(site_id)))
        elif program_access in ("n", None, ""):
            # Nothing to do!
            pass
        else:
            if site_id == "1":
                # Gotta insert this for all relevant sites...
                # We'll just have to assume that such a program id
                # exists in each.  Better hope that's true!
                for this_site_id in SITES_WITH_PROGRAMS:
                    cur.execute(
                        INSERT_DATA_TEMPLATE % (
                            core_conn.escape_string(user_priv_id),
                            core_conn.escape_string(program_access),
                            core_conn.escape_string(this_site_id)))

            else:
                cur.execute(
                    INSERT_DATA_TEMPLATE % (
                        core_conn.escape_string(user_priv_id),
                        core_conn.escape_string(program_access),
                        core_conn.escape_string(site_id)))
        
    print("...done.")


def drop_old_column(conn):
    print("Dropping column from the old table...")
    cur = conn.cursor()
    cur.execute(DROP_COLUMN_SQL)
    print("...done.")


def load_connection(server, user, passwd, dbname, **kwargs):
    return mdb.connect(server, user, passwd, dbname)


def main():
    if len(sys.argv) != 1:
        print("Call this like:\n"
              "  ./update_user_programs.py CONNECTIONS_CSV")
        sys.exit(1)

    connections_csv = sys.argv[1]
    dr = csv.DictReader(file(connections_csv, "r"))
    auth_info = dict([(row['servername'], row) for row in dr])

    with load_connection(auth_info['core']) as core_conn, \
         load_connection(auth_info['enlace']) as enlace_conn, \
         load_connection(auth_info['bickerdike']) as bickerdike_conn, \
         load_connection(auth_info['lsna']) as lsna_conn, \
         load_connection(auth_info['swop']) as swop_conn, \
         load_connection(auth_info['trp']) as trp_conn:
        create_table(core_conn)
        copy_over_access_data(core_conn, enlace_conn, bickerdike_conn,
                              lsna_conn, swop_conn, trp_conn)
        drop_old_column(core_conn)


if __name__ == "__main__":
    main()

