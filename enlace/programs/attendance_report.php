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

include "../include/dbconnopen.php";

$session_id_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_GET["session_id"]);

$download_name = "enlace_attendance_report";

$program_date_sql = "SELECT DATE(Date_Listed) FROM Program_Dates WHERE Program_ID = '$session_id_sqlsafe' ORDER BY Date_Listed ASC";
$program_dates = mysqli_query($cnnEnlace, $program_date_sql);

$csv_header = Array("", "Database ID", "Date Dropped");
while($row = mysqli_fetch_row($program_dates)) {
    array_push($csv_header, $row[0]);
}

$attendance_data_sql = "SELECT Absences.Participant_ID, Absences.Program_Date, Absent " .
    "FROM Absences " .
    "LEFT JOIN Program_Dates ON Program_Dates.Program_Date_ID = Absences.Program_Date " .
    "WHERE Program_Dates.Program_ID = '$session_id_sqlsafe'";
$db_attendance_data = mysqli_query($cnnEnlace, $attendance_data_sql);

$attendance_data = Array();
while($row = mysqli_fetch_row($db_attendance_data)) {
    if($attendance_data[$row[0]] == NULL) {
        $attendance_data[$row[0]] == Array();
    }

    $attendance_data[$row[0]][$row[1]] = $row[2];
}

$program_date_ids_sql = "SELECT Program_Date_ID FROM Program_Dates WHERE Program_ID = '$session_id_sqlsafe' ORDER BY Date_Listed ASC"; 
$program_date_ids = mysqli_fetch_all(mysqli_query($cnnEnlace, $program_date_ids_sql), MYSQLI_ASSOC);

$participants_sql = "SELECT Participants.Participant_ID, Participants.Last_Name, Participants.First_Name, DATE(Participants_Programs.Date_Dropped) AS Date_Dropped " .
    "FROM Participants_Programs " .
    "LEFT JOIN Participants ON Participants.Participant_ID = Participants_Programs.Participant_ID " . 
    "WHERE Program_ID = '$session_id_sqlsafe' AND Participants.Participant_ID > 0 " .
    "ORDER BY Participants.Last_Name ASC"; 
$participants = mysqli_fetch_all(mysqli_query($cnnEnlace, $participants_sql), MYSQLI_ASSOC);

header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=$download_name.csv");

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

fputcsv($output, $csv_header);

foreach($participants as $participant) {
    $participant_row[0] = $participant["Last_Name"] . ", " . $participant["First_Name"];
    $participant_row[1] = $participant["Participant_ID"];
    $participant_row[2] = $participant["Date_Dropped"];

    $i = 3;
    foreach($program_date_ids as $program_date_id) {
        if($attendance_data[$participant["Participant_ID"]] != NULL) {
            $absent = $attendance_data[$participant["Participant_ID"]][$program_date_id['Program_Date_ID']];
            if($absent == '1') {
                $participant_row[$i] = 'A';
            } elseif ($absent == '0') {
                $participant_row[$i] = 'P';
            } else {
                $participant_row[$i] = '';
            }
        } else {
            $participant_row[$i] = '';
        }
        $i++;
    }
    fputcsv($output, $participant_row);
}

include "../include/dbconnclose.php";

?>
