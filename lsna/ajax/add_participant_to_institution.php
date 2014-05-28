<?php
/*after a participant already exists, adding them to another institution (or vice versa) */
$link_query = "INSERT INTO Institutions_Participants (Institution_ID, Participant_ID)
    VALUES('" . $_POST['inst'] . "', '" . $_POST['parti'] . "')";
//echo $link_query;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $link_query);
include "../include/dbconnclose.php";

?>
