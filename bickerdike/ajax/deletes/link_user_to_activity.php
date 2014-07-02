<?php
include "../include/dbconnopen.php";
$activity_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['activity_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);
$add_to_activity_users = "INSERT INTO Activities_Users (
                            User_Established_Activity_ID,
                            User_ID)VALUES (
                            '". $activity_id_sqlsafe."',
                            '" . $user_id_sqlsafe."')";
mysqli_query($cnnBickerdike, $add_to_activity_users);
include "../include/dbconnclose.php";

?>
