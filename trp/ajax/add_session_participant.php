<?php

/* add session participant. */
$add_session_participant = "INSERT INTO Participants_Program_Sessions
                                (Session_ID, Participant_ID)
                            VALUES
                                (" . $_POST['session_id'] . ", " . $_POST['participant_id'] . ")";

include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $add_session_participant);
include "../include/dbconnclose.php";
?>