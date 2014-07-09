<?php
/* link properties */
include "../include/dbconnopen.php";
if ($_POST['link_from_event']==1){
    /* if this link originated at an event, this query: */
	$link_prop_sqlsafe = "INSERT INTO Participants_Properties (Participant_ID, Property_ID, Primary_Residence)
		VALUES ('".mysqli_real_escape_string($cnnSWOP, $_POST['person'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."', '1')";
} else {
    /* otherwise, just link them (not primary) */
	$link_prop_sqlsafe = "INSERT INTO Participants_Properties (Participant_ID, Property_ID)
		VALUES ('".mysqli_real_escape_string($cnnSWOP, $_POST['person'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."')";}
echo $link_prop_sqlsafe;
mysqli_query($cnnSWOP, $link_prop_sqlsafe);
include "../include/dbconnclose.php";
?>
