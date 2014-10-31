<?php
require_once("../siteconfig.php");
?>
<?
/* duplicate function to add_attendee.php.  Only used in search_users.php. */

	include "../include/dbconnopen.php";
	$add_attendance_sqlsafe = "INSERT INTO Events_Participants (
		Event_ID,
		Participant_ID
	) VALUES (
		'" . mysqli_real_escape_string($cnnTRP, $_POST['event_id']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['participant_id']) . "'
	)";
	mysqli_query($cnnTRP, $add_attendance_sqlsafe);
	include "../include/dbconnclose.php";
?>