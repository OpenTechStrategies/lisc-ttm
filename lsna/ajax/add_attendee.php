<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/* Add attendance. */
include "../include/dbconnopen.php";
$program_date_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['program_date_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['user_id']);
$add_attendee_to_date = "INSERT INTO Subcategory_Attendance (
                            Subcategory_Date,
                            Participant_ID) VALUES (
                            '". $program_date_id_sqlsafe."',
                            '". $user_id_sqlsafe."'
                            )";
echo $add_attendee_to_date;
mysqli_query($cnnLSNA, $add_attendee_to_date);
include "../include/dbconnclose.php";

?>
