<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $AdminAccess);

/*
 * Remove a person from a specific date of a program.  The person will still
 * be a program participant, but they will not have attended this date.
 */
include "../include/dbconnopen.php";

$user_id_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);
$program_date_id_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['program_date_id']);
$remove_attendee_from_date_sqlsafe = "DELETE FROM Program_Dates_Users WHERE
                            Program_Date_ID='". $program_date_id_sqlsafe."'
                                AND
                            User_ID='". $user_id_sqlsafe."'";
echo $remove_attendee_from_date_sqlsafe;
mysqli_query($cnnBickerdike, $remove_attendee_from_date_sqlsafe);
include "../include/dbconnclose.php";

?>
