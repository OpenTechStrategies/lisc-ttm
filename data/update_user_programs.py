#!/bin/env python3

import MySQLdb as mdb
import sys

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

DROP_COLUMN_SQL = "ALTER TABLE Users_Privileges DROP COLUMN Program_Access;"


def create_table(conn):
    print("Creating new table...")
    cur = conn.cursor()
    cur.execute(CREATE_TABLE_SQL)
    print("...done.")


INSERT_DATA_TEMPLATE = """
INSERT INTO Users_Program_Access (Users_Privileges_Id, Program_Access)
VALUES (%s, %s)"""

# TODO
def copy_over_access_data(conn):
    print("Copying over data...")
    cur = conn.cursor()
    cur.execute("SELECT Users_Privileges_Id, Program_Access FROM Users_Privileges")
    for user_priv_id, program_access in cur.fetchall():
        if program_access == "a":
            # TODO: Finish this!
            #  ... I need to find out what "all" the values are
            pass
        # TODO: cdonnelly, is this right?
        elif program_access in ("n", None, ""):
            # Nothing to do!
            pass
        else:
            cur.execute(
                INSERT_DATA_TEMPLATE % (
                    conn.escape_string(user_priv_id),
                    conn.escape_string(program_access)))
        
    print("...done.")


def drop_old_column(conn):
    print("Dropping column from the old table...")
    cur = conn.cursor()
    cur.execute(DROP_COLUMN_SQL)
    print("...done.")


def main():
    if len(sys.argv) != 5:
        print("Call this like:\n"
              "  ./update_user_programs.py SERVER USERNAME PASSWD DBNAME")
        sys.exit(1)

    server, user, passwd, dbname = sys.argv[1:5]

    with mdb.connect(server, user, passwd, dbname) as conn:
        create_table(conn)
        copy_over_access_data(conn)
        drop_old_column(conn)


if __name__ == "__main__":
    main()

