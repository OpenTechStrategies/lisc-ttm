<?php
/*
 * Site privileges are the level of access (admin, data entry, viewer).  Program access
 * is only relevant to some organizations (Enlace and TRP), but has to do with the 
 * program(s) that each user is allowed to view.
 * 
 * Privilege_ID refers to the site that is editing the user's information.
 */
include "../include/dbconnopen.php";

$user_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['user']);
$site_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['site']);
$privilege_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['privilege']);
$program_sqlsafe=  mysqli_real_escape_string($cnnLISC, $_POST['program']);

$edit_privilege_level = "UPDATE Users_Privileges SET Site_Privilege_ID='" . $privilege_sqlsafe . "', Program_Access='".$program_sqlsafe."' WHERE
    User_ID='" . $user_sqlsafe . "' AND Privilege_Id='" . $site_sqlsafe . "'";
echo $edit_privilege_level;
mysqli_query($cnnLISC, $edit_privilege_level);
include "../include/dbconnclose.php";
?>
