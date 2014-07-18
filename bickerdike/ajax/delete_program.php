<?php
/*
 * Deletes program.  In order to do that it needs to remove all the places where it shows
 * up as a foreign key, so we first delete the dates and users that are linked to the program.
 * (not, interestingly, the attendance.  I wonder what happens to that).
 */
include "../include/dbconnopen.php";
$id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['_id']);
$delete_dates_query_sqlsafe="DELETE FROM Program_Dates WHERE Program_ID='".$id_sqlsafe."'";
$delete_users_query_sqlsafe="DELETE FROM Programs_Users WHERE Program_ID='".$id_sqlsafe."'";
$delete_program_query_sqlsafe="DELETE FROM Programs WHERE Program_ID='".$id_sqlsafe."'";

mysqli_query($cnnBickerdike, $delete_dates_query_sqlsafe);
mysqli_query($cnnBickerdike, $delete_program_query_sqlsafe);
mysqli_query($cnnBickerdike, $delete_users_query_sqlsafe);
include "../include/dbconnclose.php";
?>
