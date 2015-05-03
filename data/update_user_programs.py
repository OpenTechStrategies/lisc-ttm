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


def copy_over_access_data(core_conn, enlace_conn, bickerdike_conn,
                          lsna_conn, swop_conn, trp_conn):
    print("Copying over data...")
    cur = core_conn.cursor()
    cur.execute("SELECT Users_Privileges_Id, Program_Access, Privilege_Id "
                "FROM Users_Privileges")
    # Privilege_Id really probably should be called "site id"?
    # Anyway, hence the mismatch with above.
    for user_priv_id, program_access, site_id in cur.fetchall():
        if program_access == "a":
            # TODO: Finish this!
            #  ... I need to find out what "all" the values are
            pass
        # TODO: cdonnelly, is this right?
        elif program_access in ("n", None, ""):
            # Nothing to do!
            pass
        else:
            # TODO: This won't work if site_id == "1" (ie, all)
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

