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

## Issue 218 - Enlace - Hiding past data - September 2018

Adds a settings table for the enlace subsystem.  This is a generic placeholder for any settings that can be updated by administrators that affect how the application works.  The relevant page is system/settings.php

### SQL for Table Creation
```
USE ttm-enlace
CREATE TABLE `System_Settings` (
    `Setting_Name` varchar(255) NOT NULL UNIQUE,
    `Setting_Type` enum('integer', 'string') NOT NULL,
    `Setting_Value` varchar(255)
);
```

### num_days_hidden setting
This setting affects what programs/sessions are visible in different pages.  If a program has no sessions more recent than num_days_hidden ago, it will be hidden from lists.  This also affects session displays on certain pages.
```
USE ttm-enlace
INSERT INTO System_Settings VALUES ('num_days_hidden', 'integer', '365');
```

## Issue 221 - Enlace - Add survey entry point link - create table with codes for assessments.

Adds a table for storing unique codes that allow a user to bypass authentication to take a distinct survey.

### SQL for Assessments_Codes

```
USE ttm-enlace
CREATE TABLE `Assessments_Codes` (
  `Assessment_Code_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Participant_ID` int NOT NULL,
  `Session_ID` int NOT NULL,
  `Pre_Post` int NOT NULL,
  `Code` char(8) NOT NULL,
  PRIMARY KEY (`Assessment_Code_ID`));
```


## Issue 221 - Enlace - Add survey entry point link - Add survey_entry_point_salt - September 2018

Adds a setting for the entry_point_salt, which is used to generate a hash for a way to enter surveys without a login.  This should not be used for anything truly secure (like passwords), but is useful for the purpose

### SQL for survey_entry_point_salt setting
```
USE ttm-enlace
INSERT INTO System_Settings VALUES ('survey_entry_point_salt', 'string', 'defaultsalt');
```

# Issue 222 - Enlace - Sessions have their own Days of week and Daily Start and End hours - September 2018

Adds days of week, start, and end times to the Session_Names table, so that there's greater flexibility in the application for how different sessions in different times of the year.  This will affect how session dates get populated, and how the dosage calculations work.  We keep the Programs values around in order provide defaults.

### SQL for column additions
```
USE ttm-enlace
ALTER TABLE `Session_Names`
    ADD COLUMN `Start_Hour` int(11),
    ADD COLUMN `Start_Suffix` varchar(45),
    ADD COLUMN `End_Hour` int(11),
    ADD COLUMN `End_Suffix` varchar(45),
    ADD COLUMN `Monday` int(11),
    ADD COLUMN `Tuesday` int(11),
    ADD COLUMN `Wednesday` int(11),
    ADD COLUMN `Thursday` int(11),
    ADD COLUMN `Friday` int(11),
    ADD COLUMN `Saturday` int(11),
    ADD COLUMN `Sunday` int(11);
```

### SQL for backfilling old sessions
```
USE ttm-enlace
UPDATE `Session_Names` SET `Start_Hour` = (SELECT `Start_Hour` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `Start_Suffix` = (SELECT `Start_Suffix` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `End_Hour` = (SELECT `End_Hour` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `End_Suffix` = (SELECT `End_Suffix` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `Monday` = (SELECT `Monday` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `Tuesday` = (SELECT `Tuesday` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `Wednesday` = (SELECT `Wednesday` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `Thursday` = (SELECT `Thursday` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `Friday` = (SELECT `Friday` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `Saturday` = (SELECT `Saturday` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
UPDATE `Session_Names` SET `Sunday` = (SELECT `Sunday` FROM `Programs` WHERE `Programs`.`Program_ID` = `Session_Names`.`Program_ID`);
```

# Issue 226 - Enlace - Add Save as Draft to Assessments - September 2018

Adds a column for saving as draft.

### SQL 
```
USE ttm-enlace
ALTER TABLE Assessments ADD COLUMN Draft int(11) NOT NULL DEFAULT 0;
```

## Issue 245 - Add new demographic information - September 2018

Two new demographics, related to youth recruitment, and the justice system, were needed to keep in line with recent additions to the surveys.

### SQL needed to add columns
```
USE ttm-enlace
ALTER TABLE `Participants`
    ADD COLUMN `Recruitment` int(11) DEFAULT 0,
    ADD COLUMN `Justice_System` int(11) DEFAULT 0;
```
