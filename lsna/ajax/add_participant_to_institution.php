<?php
/*after a participant already exists, adding them to another institution (or vice versa) */
include "../include/dbconnopen.php";
$inst_sqlsafe=  mysqli_real_escape_string($cnnLSNA, $_POST['inst']);
$parti_sqlsafe=  mysqli_real_escape_string($cnnLSNA, $_POST['parti']);
$link_query = "INSERT INTO Institutions_Participants (Institution_ID, Participant_ID)
    VALUES('" . $inst_sqlsafe . "', '" . $parti_sqlsafe . "')";
//echo $link_query;
mysqli_query($cnnLSNA, $link_query);
include "../include/dbconnclose.php";

?>
