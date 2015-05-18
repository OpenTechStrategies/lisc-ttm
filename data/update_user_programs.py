#!/usr/bin/env python

from __future__ import print_function

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


def create_table(cur):
    print("Creating new table...")
    cur.execute(CREATE_TABLE_SQL)
    print("...done.")


INSERT_DATA_TEMPLATE = """
INSERT INTO Users_Program_Access (Users_Privileges_Id, Program_Access)
VALUES (%s, %s)"""


def get_all_programs_on_site(cur, table_name="Programs",
                             column_name="Program_ID"):
    """
    For users with "all" access, we need all the program ids for a site

    This is stored in usually the "Programs" table, unless you're
    LSNA, in which case it's "Subcategories"
    """
    import pdb
    pdb.set_trace()
    cur.execute("select %s from %s" % (column_name, table_name))
    return [row[0] for row in cur.fetchall()]


def copy_over_access_data(core_cur, enlace_cur, bickerdike_cur,
                          lsna_cur, swop_cur, trp_cur):
    conn_map = {
        2: lsna_cur,
        3: bickerdike_cur,
        4: trp_cur,
        5: swop_cur,
        6: enlace_cur,
    }

    print("Copying over data...")
    # cur = core_cur.cursor()
    core_cur.execute("SELECT Users_Privileges_Id, Program_Access, Privilege_Id "
                "FROM Users_Privileges")
    # Privilege_Id really probably should be called "site id"?
    # Anyway, hence the mismatch with above.
    for user_priv_id, program_access, site_id in core_cur.fetchall():
        # Not great code, overly nesty, but it's a one-off script :p
        if program_access == "a":
            table_name = "Programs"
            column_name = "Program_ID"
            # LSNA has a different name for that table...
            if site_id == 2:
                table_name = "Subcategories"
                column_name = "Subcategory_ID"

            programs = get_all_programs_on_site(
                conn_map[int(site_id)], table_name, column_name)
            for program in programs:
                core_cur.execute(
                    INSERT_DATA_TEMPLATE, (
                        user_priv_id,
                        program))
        elif program_access in ("n", None, ""):
            # Nothing to do!
            pass
        else:
            core_cur.execute(
                INSERT_DATA_TEMPLATE,
                (user_priv_id,
                 program_access))
        
    print("...done.")


def drop_old_column(cur):
    print("Dropping column from the old table...")
    # cur = cur.cursor()
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

    with load_connection(**auth_info['core']) as core_conn, \
         load_connection(**auth_info['enlace']) as enlace_conn, \
         load_connection(**auth_info['bickerdike']) as bickerdike_conn, \
         load_connection(**auth_info['lsna']) as lsna_conn, \
         load_connection(**auth_info['swop']) as swop_conn, \
         load_connection(**auth_info['trp']) as trp_conn:
        create_table(core_conn)
        copy_over_access_data(core_conn, enlace_conn, bickerdike_conn,
                              lsna_conn, swop_conn, trp_conn)
        drop_old_column(core_conn)


if __name__ == "__main__":
    main()

