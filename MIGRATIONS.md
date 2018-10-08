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

## Issue #243 - Clean up survey data - September 2018

The intake survey data was corrupted by the duplication process, for as long as the duplication has been a part of the codebase.  This is a php script to fix that.

### PHP needed to run

Run this script from the root directory of the project so that you use the connection information you've already set up.  It should dump out the number of rows that were added to make things work.

```php
<?php
$counts = [];

$_SERVER['DOCUMENT_ROOT'] = '.';
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/enlace/include/dbconnopen.php";

function mismatch($assessment_array, $related_table_array) {
    return
        (isset($related_table_array["Pre_Post"]) && $assessment_array["Pre_Post"] != $related_table_array["Pre_Post"]) ||
        $assessment_array["Session_ID"] != $related_table_array["Program"];
}

function deep_copy_or_create($assessment_array, $table_name, $table_primary_key, $original_id) {
    global $cnnEnlace, $counts;
    if(!isset($counts[$table_name])) {
        $counts[$table_name] = 0;
    }

    $date_logged = $assessment_array["Date_Logged"];
    $session_id = $assessment_array["Session_ID"];
    $participant_id = $assessment_array["Participant_ID"];
    $result = mysqli_query($cnnEnlace, "SELECT * FROM $table_name WHERE $table_primary_key = $original_id");
    if(mysqli_num_rows($result) == 0) {
        $counts[$table_name]++;
        $pre_post_name = '';
        $pre_post_value = '';
        if($table_name != "Participants_Baseline_Assessments") {
            $pre_post_name = ', Pre_Post';
            $pre_post_value = ', 1';
        }
        mysqli_query($cnnEnlace,
            "INSERT INTO $table_name " .
            " (Date_Logged, Program, Participant_ID $pre_post_name) " .
            " VALUES ('$date_logged', $session_id, $participant_id $pre_post_value)");

        $new_id = mysqli_insert_id($cnnEnlace);

        //This happened because the data is even more corrupted than you'd think.
        //There are links from assessments to rows that no longer exist
        if($new_id != 0) {
            $new_row = mysqli_fetch_array(
                mysqli_query($cnnEnlace, "SELECT * FROM $table_name WHERE $table_primary_key = $new_id"),
                MYSQLI_ASSOC);

            $sets = array();
            foreach ($new_row as $column_name => $column_value) {
                if($column_value != null) {
                    array_push($sets, "$column_name = 0");
                }
            }

            $sets_str = implode(", ", $sets);
            $insert_query_str = "UPDATE $table_name SET $sets_str WHERE $table_primary_key = $new_id";
            mysqli_query($cnnEnlace, $insert_query_str);
        }

        return $new_id;
    } else {
        $db_values = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if(mismatch($assessment_array, $db_values)) {
            $columns = array();
            $values = array();
            foreach ($db_values as $column_name => $column_value) {
                if($column_name != $table_primary_key) {
                    array_push($columns, $column_name);
                    if($column_name == "Date_Logged") {
                        array_push($values, "'$date_logged'");
                    } else if ($column_name == "Program") {
                        array_push($values, $session_id);
                    } else if ($column_name == "Pre_Post") {
                        array_push($values, '1');
                    } else {
                        $column_value_safe = mysqli_real_escape_string($cnnEnlace, $column_value);
                        array_push($values, "'$column_value_safe'");
                    }
                }
            }
            $column_str = implode(", ", $columns);
            $value_str = implode(", ", $values);
            $insert_query_str = "INSERT INTO $table_name ($column_str) VALUES ($value_str)";
            $counts[$table_name]++;
            mysqli_query($cnnEnlace, $insert_query_str);
            return mysqli_insert_id($cnnEnlace);
        }
    }
    return $original_id;
}

function update_assessment($assessment_array) {
    global $cnnEnlace;

    $assessment_id = $assessment_array["Assessment_ID"];
    $baseline_id = $assessment_array["Baseline_ID"];
    $caring_id = $assessment_array["Caring_ID"];
    $future_id = $assessment_array["Future_ID"];
    $violence_id = $assessment_array["Violence_ID"];

    $baseline_id = deep_copy_or_create($assessment_array, "Participants_Baseline_Assessments", "Baseline_Assessment_ID", $baseline_id);
    $caring_id = deep_copy_or_create($assessment_array, "Participants_Caring_Adults", "Caring_Adults_ID", $caring_id);
    $future_id = deep_copy_or_create($assessment_array, "Participants_Future_Expectations", "Future_Expectations_ID", $future_id);
    $violence_id = deep_copy_or_create($assessment_array, "Participants_Interpersonal_Violence", "Interpersonal_Violence_ID", $violence_id);

    $create_assessment = "UPDATE Assessments SET " .
        "     Baseline_ID = $baseline_id, " .
        "     Caring_ID = $caring_id, " . 
        "     Future_ID = $future_id, " .
        "     Violence_ID = $violence_id " .
        " WHERE Assessment_ID = $assessment_id";

    mysqli_query($cnnEnlace, $create_assessment);
}

// The only duplicated assessments were intakes
$assessment_result = mysqli_query($cnnEnlace, "SELECT * FROM Assessments WHERE Pre_Post = 1 AND Session_ID IS NOT NULL");
while($assessment_array = mysqli_fetch_array($assessment_result)) {
    update_assessment($assessment_array);
}

foreach ($counts as $name => $val) {
    echo"$name: $val\n";
}
?>
```
