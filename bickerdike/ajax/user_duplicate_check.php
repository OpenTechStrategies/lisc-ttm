<?php
/*
 * On the creation of a new user, checks for a user that already exists and has the same name
 */
include "../include/dbconnopen.php";
$first_name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['first_name']);
$last_name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['last_name']);
$get_duplicate_users_sqlsafe = "SELECT COUNT(User_ID) FROM Users WHERE First_Name='" . $first_name_sqlsafe . "' AND Last_Name='" . $last_name_sqlsafe . "'";
//echo $get_duplicate_users_sqlsafe;
$is_duplicate = mysqli_query($cnnBickerdike, $get_duplicate_users_sqlsafe);
$duplicate = mysqli_fetch_row($is_duplicate);
/*
 * If someone with the same name does exist, issue a warning.  They have the option to proceed anyway.
 */

if ($duplicate[0]>0){
    echo 'A participant named ' . $first_name_sqlsafe . " " . $last_name_sqlsafe . ' is already in the database.  Are you sure you want to enter this user?';
}
include "../include/dbconnclose.php";

?>
