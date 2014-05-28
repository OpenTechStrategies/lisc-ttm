<?php
/* add parent mentor attendance.  This is a little tricky, because the attendance
 * is saved as days of the month attended versus days possible in that month.  There
 * are too many tables for this (in the DB).
 */

$check_on_update = "SELECT * FROM PM_Actual_Attendance WHERE Parent_Mentor_ID='" . $_POST['pm_id'] . "' 
    AND Possible_Attendance_ID='" . $_POST['possible_id'] ."'";
include "../include/dbconnopen.php";
$check = mysqli_query($cnnLSNA, $check_on_update);
$to_update=mysqli_num_rows($check);


if ($to_update<1){
$save_new_attendance = "INSERT INTO PM_Actual_Attendance (Parent_Mentor_ID,
    Possible_Attendance_ID,
    Num_Days_Attended)
    VALUES
    ('" . $_POST['pm_id'] . "',
    '" . $_POST['possible_id'] ."',
    '" . $_POST['days'] . "')";
}
else{
    $save_new_attendance="UPDATE PM_Actual_Attendance SET Num_Days_Attended='" . $_POST['days'] . "' WHERE
        Parent_Mentor_ID='" . $_POST['pm_id'] . "' AND Possible_Attendance_ID='" . $_POST['possible_id'] ."'";
}
echo $save_new_attendance;

mysqli_query($cnnLSNA, $save_new_attendance);
include "../include/dbconnclose.php";
?>
