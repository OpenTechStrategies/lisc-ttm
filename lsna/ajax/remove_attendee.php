<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $AdminAccess);

/* delete attendance from program or campaign. */
include "../include/dbconnopen.php";
$program_date_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['program_date_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['user_id']);

$remove_attendee_from_date = "DELETE FROM Subcategory_Attendance WHERE
                            Subcategory_Date='". $program_date_id_sqlsafe."'
                                AND
                            Participant_ID='". $user_id_sqlsafe."'";
echo $remove_attendee_from_date;
mysqli_query($cnnLSNA, $remove_attendee_from_date);
include "../include/dbconnclose.php";

?>
