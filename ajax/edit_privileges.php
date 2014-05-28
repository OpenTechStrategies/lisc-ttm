<?php
/*
 * Site privileges are the level of access (admin, data entry, viewer).  Program access
 * is only relevant to some organizations (Enlace and TRP), but has to do with the 
 * program(s) that each user is allowed to view.
 * 
 * Privilege_ID refers to the site that is editing the user's information.
 */
$edit_privilege_level = "UPDATE Users_Privileges SET Site_Privilege_ID='" . $_POST['privilege'] . "', Program_Access='".$_POST['program']."' WHERE
    User_ID='" . $_POST['user'] . "' AND Privilege_Id='" . $_POST['site'] . "'";
echo $edit_privilege_level;
include "../include/dbconnopen.php";
mysqli_query($cnnLISC, $edit_privilege_level);
include "../include/dbconnclose.php";
?>
