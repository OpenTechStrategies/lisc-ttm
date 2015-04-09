<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $AdminAccess);

/*
 * Remove the connection between a person and a program.  Their attendance will be unaffected on the back end and
 * they will continue to show up as attendees on dates when they attended.  They will not be eligible to be added
 * as an attendee again until/unless they are re-added as a participant.
 */
include "../include/dbconnopen.php";
$id_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['id']);
$remove_from_program_sqlsafe = "DELETE FROM Programs_Users WHERE Program_User_ID='" . $id_sqlsafe . "'";
mysqli_query($cnnBickerdike, $remove_from_program_sqlsafe);
include "../include/dbconnclose.php";
?>
