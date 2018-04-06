# Migrations Document

This document is to outline different migrations needed to update the database as changes are made.  It's an ad hoc solution, and provides more context than actual usefulness.  Migrations should be done in reverse order so the most recent is first, and should include:

* Issue Number
* Date
* Overview of change
* SQL/script statements needed for change

## Issue 192 - Enlace - Absent/Present within attendance - March 2018

Expands the ttm-enlace.Absence table to include an Absent flag so that Enlace can track attendance without a default of attending.  This requires not only a change to the table, but also creation of all rows in the past to explicitly mark as attending.

SQL Needed
```
USE ttm-enlace
ALTER TABLE `Absences` ADD COLUMN `Absent` int(11);
UPDATE `Absences` SET `Absent` = 1;
```

Backfill shell script needed - you'll want to put your password in here so you don't get asked a million times (takes about 15 minutes)
```
mysql -ss -u root -p ttm-enlace -e "SELECT Program_Date_ID, Program_ID FROM Program_Dates" | while read PROGRAM_DATE_ID PROGRAM_ID ; do
    mysql -ss -u root -p ttm-enlace -e "SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = $PROGRAM_ID" | while read PARTICIPANT_ID ; do
        if [[ -z $(mysql -ss -u root -p ttm-enlace -e "SELECT Absence_ID FROM Absences WHERE Participant_ID = $PARTICIPANT_ID AND Program_Date = $PROGRAM_DATE_ID") ]] ; then
            mysql -ss -u root -p ttm-enlace -e "INSERT INTO Absences(Participant_ID, Program_Date, Absent) VALUES ($PARTICIPANT_ID, $PROGRAM_DATE_ID, 0)"
        fi
    done
done

```
