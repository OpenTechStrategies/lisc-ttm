<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);
?>
<?php
//This updates the Grade_Level (to [Grade_Level + 1]) of the Academic_Info
//table that are not NULL. This should run on July 1 of every year.
//The log file (./update_grade_levels.log) keeps track of the last year it
//was run.
date_default_timezone_set('America/Chicago');
$today = getdate();

//read the first line of the log file
$f = fopen("./update_grade_levels.log", 'r');
$first_line = fgets($f);
echo "Last Run In: " . $first_line . "<br /><br />";
fclose($f);

//if the first line is the same year, 
if ($today['year'] == $first_line) {
    echo "This can only be run once per year.";
    return;
} else {
    if ($_GET['update'] == "grade_levels") {
        $today = getdate();
        //if today is July 1, then run the query
        if (($today['mon'] == 1) && ($today['mday'] == 2)) {
            $update_grade_level_sqlsafe = "UPDATE Academic_Info
                                    SET Grade_Level = (Grade_Level - 1)
                                    WHERE Grade_Level > 0 AND
                                        Grade_Level IS NOT NULL";
            include "../include/dbconnopen.php";
            if (mysqli_query($cnnTRP, $update_grade_level_sqlsafe)) {
                echo "Success: Updated all grade levels.";
                
                //update log file
                $f = fopen("./update_grade_levels.log", 'w');
                fwrite($f, $today['year']);
                fclose($f);
            } else {
                echo "Failed: Grade levels not updated.";
            }
            include "../include/dbconnclose.php";
        } else {
            echo "Today is not the correct date to run this. This should only be "
                . "run on July 1 of every year.";
        }
    } else {
        echo "Incorrect query string. <br /><br />To go forward and actually update"
            . " all grade levels, add '?update=grade_levels' to the URL.";
    }
}
?>