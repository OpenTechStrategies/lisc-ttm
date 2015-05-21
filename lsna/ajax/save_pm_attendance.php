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
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/* add parent mentor attendance.  This is a little tricky, because the attendance
 * is saved as days of the month attended versus days possible in that month.  There
 * are too many tables for this (in the DB).
 */
include "../include/dbconnopen.php";
$possible_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['possible_id']);
$pm_id_sqlsafe=  mysqli_real_escape_string($cnnLSNA, $_POST['pm_id']);
$days_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['days']);

$check_on_update = "SELECT * FROM PM_Actual_Attendance WHERE Parent_Mentor_ID='" . $pm_id_sqlsafe . "' 
    AND Possible_Attendance_ID='" . $possible_id_sqlsafe ."'";
$check = mysqli_query($cnnLSNA, $check_on_update);
$to_update=mysqli_num_rows($check);


if ($to_update<1){
$save_new_attendance = "INSERT INTO PM_Actual_Attendance (Parent_Mentor_ID,
    Possible_Attendance_ID,
    Num_Days_Attended)
    VALUES
    ('" . $pm_id_sqlsafe . "',
    '" . $possible_id_sqlsafe ."',
    '" . $days_sqlsafe . "')";
}
else{
    $save_new_attendance="UPDATE PM_Actual_Attendance SET Num_Days_Attended='" . $days_sqlsafe . "' WHERE
        Parent_Mentor_ID='" . $pm_id_sqlsafe . "' AND Possible_Attendance_ID='" . $possible_id_sqlsafe ."'";
}
echo $save_new_attendance;

mysqli_query($cnnLSNA, $save_new_attendance);
include "../include/dbconnclose.php";
?>
