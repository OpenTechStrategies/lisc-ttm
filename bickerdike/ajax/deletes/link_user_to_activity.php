<?php
//something
$add_to_activity_users = "INSERT INTO Activities_Users (
                            User_Established_Activity_ID,
                            User_ID)VALUES (
                            '". $_POST['activity_id']."',
                            '" . $_POST['user_id']."')";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $add_to_activity_users);
include "../include/dbconnclose.php";

?>
