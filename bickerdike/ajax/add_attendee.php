<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

//Check to see if attendee is already associated with date
include "../include/dbconnopen.php";
$program_date_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program_date_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);
$get_attendees_sqlsafe = "SELECT COUNT(User_ID) FROM Program_Dates_Users WHERE Program_Date_ID='" . $program_date_id_sqlsafe . "' AND User_ID='" . $user_id_sqlsafe . "'";
$is_duplicate = mysqli_query($cnnBickerdike, $get_attendees_sqlsafe);
$duplicate = mysqli_fetch_row($is_duplicate);
if (!$duplicate[0]>0){
//Add attendee to date

$add_attendee_to_date_sqlsafe = "INSERT INTO Program_Dates_Users (
                            Program_Date_ID,
                            User_ID) VALUES (
                            '". $program_date_id_sqlsafe."',
                            '". $user_id_sqlsafe."'
                            )";
echo $add_attendee_to_date_sqlsafe;
mysqli_query($cnnBickerdike, $add_attendee_to_date_sqlsafe);}
include "../include/dbconnclose.php";

?>
