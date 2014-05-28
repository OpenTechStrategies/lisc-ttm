<?php
/* Change role for campaign event attendee */

$change_role = "UPDATE Subcategory_Attendance SET Type_of_Participation='" . $_POST['role'] . "' WHERE Subcategory_Attendance_ID='" . $_POST['attendee_date'] . "'";
echo $change_role;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $change_role);
include "../include/dbconnclose.php";
?>
