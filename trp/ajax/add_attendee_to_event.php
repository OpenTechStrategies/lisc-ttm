<?
/* duplicate function to add_attendee.php.  Only used in search_users.php. */

	$add_attendance = "INSERT INTO Events_Participants (
		Event_ID,
		Participant_ID
	) VALUES (
		'" . $_POST['event_id'] . "',
		'" . $_POST['participant_id'] . "'
	)";
	include "../include/dbconnopen.php";
	mysqli_query($cnnTRP, $add_attendance);
	include "../include/dbconnclose.php";
?>