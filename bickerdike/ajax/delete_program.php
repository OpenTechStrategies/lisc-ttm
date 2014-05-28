<?php
/*
 * Deletes program.  In order to do that it needs to remove all the places where it shows
 * up as a foreign key, so we first delete the dates and users that are linked to the program.
 * (not, interestingly, the attendance.  I wonder what happens to that).
 */
$delete_dates_query="DELETE FROM Program_Dates WHERE Program_ID='".$_POST['id']."'";
$delete_users_query="DELETE FROM Programs_Users WHERE Program_ID='".$_POST['id']."'";
$delete_program_query="DELETE FROM Programs WHERE Program_ID='".$_POST['id']."'";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $delete_dates_query);
mysqli_query($cnnBickerdike, $delete_program_query);
mysqli_query($cnnBickerdike, $delete_users_query);
include "../include/dbconnclose.php";
?>
