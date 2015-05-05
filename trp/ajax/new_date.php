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

/* add a new date to a program (for attendance purposes) */
if ($_POST['action']=='new_date'){
include "../include/dbconnopen.php";
$format_date = explode('/', $_POST['date']);
$date_formatted_sqlsafe = mysqli_real_escape_string($cnnTRP, $format_date[2]) . '-' . mysqli_real_escape_string($cnnTRP, $format_date[0]) . '-' . mysqli_real_escape_string($cnnTRP, $format_date[1]);
$date_query_sqlsafe="INSERT INTO Program_Dates (Date, Program_ID) VALUES ('".$date_formatted_sqlsafe."', '" . mysqli_real_escape_string($cnnTRP, $_POST['program']) . "')";
mysqli_query($cnnTRP, $date_query_sqlsafe);
include "../include/dbconnclose.php";
}
/* add an attendee to a program date: */
elseif ($_POST['action']=='attendance'){
    include "../include/dbconnopen.php";
    $attendance_query_sqlsafe="INSERT INTO Program_Attendance (Date_ID, Participant_ID) VALUES (
        '" . mysqli_real_escape_string($cnnTRP, $_POST['date']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "')";
    echo $attendance_query_sqlsafe;
    mysqli_query($cnnTRP, $attendance_query_sqlsafe);
    include "../include/dbconnclose.php";
}
/* add a note to this program.  Not sure why this is in this file. */
elseif($_POST['action']=='note_text'){
    include "../include/dbconnopen.php";
    $create_note_sqlsafe="INSERT INTO Blog_Notes (Author, Note_Text, Program_ID, School) VALUES ('" . $USER->username . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['note']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['program']) . "',
        '" . mysqli_real_escape_string($cnnTRP, $_POST['school']) . "')";
    echo $create_note_sqlsafe;
    mysqli_query($cnnTRP, $create_note_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
