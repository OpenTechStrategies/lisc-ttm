<?php
/* link properties */
if ($_POST['link_from_event']==1){
    /* if this link originated at an event, this query: */
	$link_prop = "INSERT INTO Participants_Properties (Participant_ID, Property_ID, Primary_Residence)
		VALUES ('".$_POST['person']."', '".$_POST['property']."', '1')";
} else {
    /* otherwise, just link them (not primary) */
	$link_prop = "INSERT INTO Participants_Properties (Participant_ID, Property_ID)
		VALUES ('".$_POST['person']."', '".$_POST['property']."')";}
echo $link_prop;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $link_prop);
include "../include/dbconnclose.php";
?>
