<?php

/* add session participant. */
$add_session_participant_sqlsafe = "INSERT INTO Participants_Program_Sessions
                                (Session_ID, Participant_ID)
                            VALUES
                                (" . mysqli_real_escape_string($_POST['session_id']) . ", " . mysqli_real_escape_string($_POST['participant_id']) . ")";

include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $add_session_participant_sqlsafe);
include "../include/dbconnclose.php";
?>