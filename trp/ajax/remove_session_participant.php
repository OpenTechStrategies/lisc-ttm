<?php

/* remove session participant. */
$remove_session_participant_sqlsafe = "DELETE FROM Participants_Program_Sessions
                                WHERE
                                    Session_ID = " . mysqli_real_escape_string($_POST['session_id']) . " AND
                                    Participant_ID = " . mysqli_real_escape_string($_POST['participant_id']) . ";";

include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $remove_session_participant_sqlsafe);
include "../include/dbconnclose.php";
?>