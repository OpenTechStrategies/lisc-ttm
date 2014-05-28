<?
/* edit the link information for participant-property (dates of link, primary or not, etc.) */
	$edit_link = "UPDATE Participants_Properties SET 
			Unit_Number='" . $_POST['unit'] . "',
			Rent_Own='" . $_POST['rent_own'] . "',
			Start_Date='" . $_POST['start'] . "',
			End_Date='" . $_POST['end'] . "',
                            Primary_Residence='".$_POST['primary']."',
			Start_Primary='" . $_POST['start_primary'] . "',
			End_Primary='" . $_POST['end_primary'] . "',
			Reason_End='" . $_POST['reason_end'] . "'
		WHERE Participant_Property_ID='" . $_POST['link_id'] . "'";
	
	echo $edit_link;
	include "../include/dbconnopen.php";
	mysqli_query($cnnSWOP, $edit_link);
	include "../include/dbconnclose.php";
	
?>