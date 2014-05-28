<?php
/*
 * add new consent (by person and year)
 */
$insert_consent="INSERT INTO Participants_Consent (Participant_ID, School_Year, Consent_Given) VALUES (
    '".$_POST['participant']."', '".$_POST['year']."', '".$_POST['form']."')";

echo $insert_consent;

include "../include/dbconnopen.php";
mysqli_query($cnnEnlace, $insert_consent);
include "../include/dbconnclose.php";
?>
