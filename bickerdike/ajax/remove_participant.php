<?php
/*
 * Remove the connection between a person and a program.  Their attendance will be unaffected on the back end and
 * they will continue to show up as attendees on dates when they attended.  They will not be eligible to be added
 * as an attendee again until/unless they are re-added as a participant.
 */

$remove_from_program = "DELETE FROM Programs_Users WHERE Program_User_ID='" . $_POST['id'] . "'";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $remove_from_program);
include "../include/dbconnclose.php";
?>
