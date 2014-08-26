<?php
/*
 * add new consent (by person and year)
 */
include "../include/dbconnopen.php";
$participant_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['participant']);
$year_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['year']);
$form_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['form']);
$insert_consent="INSERT INTO Participants_Consent (Participant_ID, School_Year, Consent_Given) VALUES (
    '".$participant_sqlsafe."', '".$year_sqlsafe."', '".$form_sqlsafe."')";

echo $insert_consent;

mysqli_query($cnnEnlace, $insert_consent);
include "../include/dbconnclose.php";
?>
