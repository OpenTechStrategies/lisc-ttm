<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

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