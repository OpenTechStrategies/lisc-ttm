<?php
/* Save consent per person per year (for CPS).  May need to be expanded for program-specific consent. */

$insert_consent_sqlsafe="INSERT INTO Participants_Consent (Participant_ID, School_Year, Consent_Given) VALUES (
    '" . mysqli_real_escape_string($_POST['participant']) . "', '" . mysqli_real_escape_string($_POST['year']) . "', '" . mysqli_real_escape_string($_POST['form']) . "')";

echo $insert_consent_sqlsafe;

include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $insert_consent_sqlsafe);
include "../include/dbconnclose.php";
?>
