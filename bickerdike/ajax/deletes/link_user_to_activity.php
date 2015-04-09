<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

include "../include/dbconnopen.php";
$activity_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['activity_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);
$add_to_activity_users_sqlsafe = "INSERT INTO Activities_Users (
                            User_Established_Activity_ID,
                            User_ID)VALUES (
                            '". $activity_id_sqlsafe."',
                            '" . $user_id_sqlsafe."')";
mysqli_query($cnnBickerdike, $add_to_activity_users_sqlsafe);
include "../include/dbconnclose.php";

?>
