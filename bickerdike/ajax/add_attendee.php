<?php
//Check to see if attendee is already associated with date

$get_attendees = "SELECT COUNT(User_ID) FROM Program_Dates_Users WHERE Program_Date_ID='" . $_POST['program_date_id'] . "' AND User_ID='" . $_POST['user_id'] . "'";
include "../include/dbconnopen.php";
$is_duplicate = mysqli_query($cnnBickerdike, $get_attendees);
$duplicate = mysqli_fetch_row($is_duplicate);
if (!$duplicate[0]>0){
//Add attendee to date

$add_attendee_to_date = "INSERT INTO Program_Dates_Users (
                            Program_Date_ID,
                            User_ID) VALUES (
                            '". $_POST['program_date_id']."',
                            '". $_POST['user_id']."'
                            )";
echo $add_attendee_to_date;
mysqli_query($cnnBickerdike, $add_attendee_to_date);}
include "../include/dbconnclose.php";

?>
