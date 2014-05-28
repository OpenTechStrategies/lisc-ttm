<?
/* add notes to the program-participant link.
 * 
 * add a new person to a program. */

if ($_POST['action']=='save_note'){
    $update_note="UPDATE Participants_Programs SET Notes='".$_POST['note']."' WHERE Participant_Program_ID='".$_POST['id']."'";
    echo $update_note;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $update_note);
    include "../include/dbconnclose.php";
}
else{
	$add_participant = "INSERT INTO Participants_Programs (
		Program_ID,
		Participant_ID
	) VALUES (
		'" . $_POST['program_id'] . "',
		'" . $_POST['participant'] . "'
	)";
	include "../include/dbconnopen.php";
	mysqli_query($cnnTRP, $add_participant);
	include "../include/dbconnclose.php";
}
?>