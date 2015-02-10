<?php
//need to first take care of any possible foreign key constraints:
//activities_users, participant survey responses, program dates users, programs users, user health data
//
//Then finally delete the user him/herself.  This is probably going to be phased out once the merge 
//tool is in use.
//
include "../include/dbconnopen.php";
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);
$delete_activities_query_sqlsafe = "DELETE FROM Activities_Users WHERE User_ID='" . $user_id_sqlsafe . "'";
$delete_surveys_query_sqlsafe = "DELETE FROM Participant_Survey_Responses WHERE User_ID='" . $user_id_sqlsafe . "'";
$delete_attendance_query_sqlsafe = "DELETE FROM Program_Dates_Users WHERE User_ID='" . $user_id_sqlsafe . "'";
$delete_programs_query_sqlsafe = "DELETE FROM Programs_Users WHERE User_ID='" . $user_id_sqlsafe . "'";
$delete_health_query_sqlsafe = "DELETE FROM User_Health_Data WHERE User_ID='" . $user_id_sqlsafe . "'";
$delete_user_query_sqlsafe = "DELETE FROM Users WHERE User_ID='" . $user_id_sqlsafe . "'";
echo $delete_user_query_sqlsafe;
mysqli_query($cnnBickerdike, $delete_activities_query_sqlsafe);
mysqli_query($cnnBickerdike, $delete_surveys_query_sqlsafe);
mysqli_query($cnnBickerdike, $delete_attendance_query_sqlsafe);
mysqli_query($cnnBickerdike, $delete_programs_query_sqlsafe);
mysqli_query($cnnBickerdike, $delete_health_query_sqlsafe);
mysqli_query($cnnBickerdike, $delete_user_query_sqlsafe);
include "../include/dbconnclose.php";


?>
