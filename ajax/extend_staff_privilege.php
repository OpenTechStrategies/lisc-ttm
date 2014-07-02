<?php
include "../include/dbconnopen.php";

$username_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['username']);
$password_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['password']);

//add staff to login in lisc database as a whole
$lisc_query = "INSERT INTO Users (User_Email, User_Password)
    VALUES ('" . $username_sqlsafe . "', '" . $password_sqlsafe . "')";


//echo $lisc_query;
mysqli_query($cnnLISC, $lisc_query);
$user_id = mysqli_insert_id($cnnLISC);
include "../include/dbconnopen.php";

/*
 * Give new user privileges by site.
 */

$site_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['site']);
$level_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['level']);
$program_sqlsafe=  mysqli_real_escape_string($cnnLISC, $_POST['program']);

$privileges_query = "INSERT INTO Users_Privileges (User_ID, Privilege_ID, Site_Privilege_ID, Program_Access)
    VALUES ('" . $user_id . "', '" . $_POST['site'] . "', '" . $_POST['level'] . "', '" . $_POST['program'] . "')";
//echo $privileges_query;
include "../include/dbconnopen.php";
mysqli_query($cnnLISC, $privileges_query);
include "../include/dbconnopen.php";



?>
<span style="color:#990000; font-weight:bold;">Thank you for adding  <?echo $_POST['username'];?> to the database.</span>  