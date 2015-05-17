#!/usr/bin/env python

import MySQLdb as mdb
import sys
import csv

CREATE_TABLE_SQL = """
  CREATE TABLE `Users_Program_Access`(
         `Program_Access_Id` int(11) NOT NULL AUTO_INCREMENT,
         PRIMARY KEY (`Program_Access_Id`),
         `Users_Privileges_Id` int(11),
         FOREIGN KEY (`Users_Privileges_Id`) REFERENCES `Users_Privileges`
                 (`Users_Privileges_Id`)
                 ON DELETE CASCADE
                 ON UPDATE CASCADE,
         `Program_Access` int(1)
  ) ENGINE=InnoDB;
"""

# @@: Should we also drop Privilege_Id?  I think so?
DROP_COLUMN_SQL = "ALTER TABLE Users_Privileges DROP COLUMN Program_Access;"


def create_table(conn):
    print("Creating new table...")
    cur = conn.cursor()
    cur.execute(CREATE_TABLE_SQL)
    print("...done.")


INSERT_DATA_TEMPLATE = """
INSERT INTO Users_Program_Access (Users_Privileges_Id, Program_Access)
VALUES (%s, %s)"""


def get_all_programs_on_site(conn, table_name="Programs"):
    """
    For users with "all" access, we need all the program ids for a site

    This is stored in usually the "Programs" table, unless you're
    LSNA, in which case it's "Subcategories"
    """
    cur = conn.cursor()
    cur.execute("select Program_ID from %s" % conn.escape_string(table_name))
    return [row[0] for row in cur.fetchall()]


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
            programs = get_all_programs_on_site(site_id)
            for program in programs:
                cur.execute(
                    INSERT_DATA_TEMPLATE % (
                        core_conn.escape_string(user_priv_id),
                        core_conn.escape_string(program)))
        elif program_access in ("n", None, ""):
            # Nothing to do!
            pass
        else:
            cur.execute(
                INSERT_DATA_TEMPLATE % (
                    core_conn.escape_string(user_priv_id),
                    core_conn.escape_string(program_access)))
        
    print("...done.")


def drop_old_column(conn):
    print("Dropping column from the old table...")
    cur = conn.cursor()
    cur.execute(DROP_COLUMN_SQL)
    print("...done.")


def load_connection(server, user, passwd, dbname, **kwargs):
    return mdb.connect(server, user, passwd, dbname)


def main():
    if len(sys.argv) != 2:
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

