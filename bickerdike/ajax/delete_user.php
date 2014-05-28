<?php
//need to first take care of any possible foreign key constraints:
//activities_users, participant survey responses, program dates users, programs users, user health data
//
//Then finally delete the user him/herself.  This is probably going to be phased out once the merge 
//tool is in use.
//
$delete_activities_query = "DELETE FROM Activities_Users WHERE User_ID='" . $_POST['user_id'] . "'";
$delete_surveys_query = "DELETE FROM Participant_Survey_Responses WHERE User_ID='" . $_POST['user_id'] . "'";
$delete_attendance_query = "DELETE FROM Program_Dates_Users WHERE User_ID='" . $_POST['user_id'] . "'";
$delete_programs_query = "DELETE FROM Programs_Users WHERE User_ID='" . $_POST['user_id'] . "'";
$delete_health_query = "DELETE FROM User_Health_Data WHERE User_ID='" . $_POST['user_id'] . "'";
$delete_user_query = "DELETE FROM Users WHERE User_ID='" . $_POST['user_id'] . "'";
echo $delete_user_query;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $delete_activities_query);
mysqli_query($cnnBickerdike, $delete_surveys_query);
mysqli_query($cnnBickerdike, $delete_attendance_query);
mysqli_query($cnnBickerdike, $delete_programs_query);
mysqli_query($cnnBickerdike, $delete_health_query);
mysqli_query($cnnBickerdike, $delete_user_query);
include "../include/dbconnclose.php";


?>
