<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/* Change role for campaign event attendee */
include "../include/dbconnopen.php";
$role_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['role']);
$attendee_date_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['attendee_date']);

$change_role = "UPDATE Subcategory_Attendance SET Type_of_Participation='" . $role_sqlsafe . "' WHERE Subcategory_Attendance_ID='" . $attendee_date_sqlsafe . "'";
echo $change_role;
mysqli_query($cnnLSNA, $change_role);
include "../include/dbconnclose.php";
?>
