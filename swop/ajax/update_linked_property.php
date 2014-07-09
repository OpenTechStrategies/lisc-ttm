<?
/* edit the link information for participant-property (dates of link, primary or not, etc.) */
	include "../include/dbconnopen.php";
	$edit_link_sqlsafe = "UPDATE Participants_Properties SET 
			Unit_Number='" . mysqli_real_escape_string($cnnSWOP, $_POST['unit']). "',
			Rent_Own='" . mysqli_real_escape_string($cnnSWOP, $_POST['rent_own']). "',
			Start_Date='" . mysqli_real_escape_string($cnnSWOP, $_POST['start']). "',
			End_Date='" . mysqli_real_escape_string($cnnSWOP, $_POST['end']). "',
                            Primary_Residence='".mysqli_real_escape_string($cnnSWOP, $_POST['primary'])."',
			Start_Primary='" . mysqli_real_escape_string($cnnSWOP, $_POST['start_primary']). "',
			End_Primary='" . mysqli_real_escape_string($cnnSWOP, $_POST['end_primary']). "',
			Reason_End='" . mysqli_real_escape_string($cnnSWOP, $_POST['reason_end']) . "'
		WHERE Participant_Property_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['link_id']) . "'";
	
	echo $edit_link_sqlsafe;
	mysqli_query($cnnSWOP, $edit_link_sqlsafe);
	include "../include/dbconnclose.php";
	
?>