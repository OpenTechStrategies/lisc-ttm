<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *   Copyright (C) 2018 Open Tech Strategies, LLC
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

user_enforce_has_access($Enlace_id, $AdminAccess);

$warnings = Array();
if(!$_FILES["file"]) {
    $warnings[] = "File required";
} else if("csv" != end(explode(".", $_FILES["file"]["name"]))) {
    $warnings[] = "CSV file required";
} else if ($_FILES["file"]["size"] > 1000000) {
    $warnings[] = "File too large";
} else {
    include "../include/dbconnopen.php";
    date_default_timezone_set('America/Chicago');
    $session_id_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['session_id']);

    $tmpName = $_FILES['file']['tmp_name'];
    $file_open_temp = fopen($tmpName, 'r');

    $beginning_found = false;
    $program_date_ids = Array();
    while($row = fgetcsv($file_open_temp)) {
        if($row[1] == 'Database ID') {
            $beginning_found = true;

            foreach(array_slice($row, 3) as $date_str) {
                $date = strtotime($date_str);

                if(!$date) {
                    $program_date_ids[] = -1;

                    $warnings[] = "'$date_str' is not a valid date, skipping";
                } else {
                    $date_str_safe = date('Y-m-d', $date);
                    $check_date_exists = "SELECT Program_Date_ID FROM Program_Dates " .
                        "WHERE Date_Listed = '$date_str_safe' " . 
                        "    AND Program_ID = '$session_id_sqlsafe' ";

                    $check_date_exists_result = mysqli_query($cnnEnlace, $check_date_exists);

                    if(mysqli_num_rows($check_date_exists_result) == 0) {
                        mysqli_query($cnnEnlace,
                            "INSERT INTO Program_Dates(Program_ID, Date_Listed) " .
                            "VALUES ('$session_id_sqlsafe',  '$date_str_safe') "); 

                        $program_date_id = mysqli_insert_id($cnnEnlace);
                    } else {
                        $program_date_id = mysqli_fetch_row($check_date_exists_result)[0];
                    }

                    $program_date_ids[] = $program_date_id;
                }
            }
            break;
        }
    }

    $attendance_data = Array();
    $drop_data = Array();
    if($beginning_found) {
        // So we only warn once
        $warned_about_attendance_marker = false;
        while($row = fgetcsv($file_open_temp)) {
            if(! is_numeric($row[1])) {
                // The sample spreadsheets had some extra inforamtion in the first rows after the header
                // So we just kind of skip those rows
                continue;
            }
            $participant_id_sqlsafe = mysqli_real_escape_string($cnnEnlace, $row[1]);

            if(0 == mysqli_num_rows(mysqli_query($cnnEnlace, "SELECT * FROM Participants_Programs " .
                "WHERE Participant_ID = '$participant_id_sqlsafe' " .
                "    AND Program_ID = '$session_id_sqlsafe'"))) {
                $warnings[] = "Couldn't find participant with ID '" . $row[1] . "' in session.";
                break;
            }

            if($attendance_data[$participant_id_sqlsafe] == NULL) {
                $attendance_data[$participant_id_sqlsafe] == Array();
            }
            $drop_data[$participant_id_sqlsafe] = strtotime($row[2]);

            $idx = 0;
            foreach (array_slice($row, 3) as $present_str) {
                if ($present_str == 'A') {
                    $attendance_data[$participant_id_sqlsafe][$idx] = '1';
                } elseif ($present_str == 'P') {
                    $attendance_data[$participant_id_sqlsafe][$idx] = '0';
                } elseif ($present_str == '') {
                    $attendance_data[$participant_id_sqlsafe][$idx] = '';
                } else {
                    $attendance_data[$participant_id_sqlsafe][$idx] = 'NA';
                    if(!$warned_about_attendance_marker) {
                        $warnings[] = "$present_str is not a valid attendance marker, expected P or A";
                        $warned_about_attendance_market = true;
                    }
                }
                $idx++;
            }
        }
        fclose($file_open_temp);

        foreach ($attendance_data as $participant_id => $attendances) {
            foreach ($program_date_ids as $idx => $program_date_id) {
                $attendance_datum = $attendances[$idx];

                if($attendance_datum == '') {
                    $delete_sql = "DELETE FROM Absences " .
                        "WHERE Program_Date = '$program_date_id' " .
                        "    AND Absences.Participant_ID = '$participant_id'";
                    mysqli_query($cnnEnlace, $delete_sql);
                } else if($attendance_datum != 'NA') {
                    $update_sql = "UPDATE Absences SET Absent = '$attendance_datum' " .
                        "WHERE Program_Date = '$program_date_id' " .
                        "    AND Absences.Participant_ID = '$participant_id'";

                    mysqli_query($cnnEnlace, $update_sql);
                    if(mysqli_affected_rows($cnnEnlace) == 0) {
                        mysqli_query($cnnEnlace, 
                            "INSERT INTO Absences(Program_Date, Participant_ID, Absent) " . 
                            "VALUES('$program_date_id', '$participant_id', '$attendace_datum')");
                    }
                }
            }
        }

        foreach($drop_data as $participant_id => $drop_date) {
            $drop_date_str = $drop_date ? "'" . date('Y-m-d', $drop_date) . "'" : 'NULL';

            $change_drop_date = "UPDATE Participants_Programs " .
                "SET Date_Dropped = $drop_date_str " .
                "WHERE Participant_ID = '$participant_id' " .
                "    AND Program_ID = '$session_id_sqlsafe'";

            mysqli_query($cnnEnlace, $change_drop_date);

            $drop_attendance_dates = "DELETE Absences FROM Absences " .
                "INNER JOIN Program_Dates ON Absences.Program_Date = Program_Dates.Program_Date_ID " .
                "INNER JOIN Participants_Programs ON " .
                "    (Absences.Participant_ID = Participants_Programs.Participant_ID AND " .
                "     Participants_Programs.Program_ID = Program_Dates.Program_ID) " .
                "WHERE Participants_Programs.Date_Dropped IS NOT NULL " .
                "    AND Absences.Participant_ID = '$participant_id' " .
                "    AND Participants_Programs.Date_Dropped < Program_Dates.Date_Listed " .
                "    AND Participants_Programs.Program_ID = '$session_id_sqlsafe'";

            mysqli_query($cnnEnlace, $drop_attendance_dates);
        }
    } else {
        $warnings[] = "Couldn't find beginning of table, where 'Database ID' is the second column";
    }
    include "../include/dbconnclose.php";
}

header("Content-type:application/json");
echo json_encode(Array("warnings" => $warnings));
