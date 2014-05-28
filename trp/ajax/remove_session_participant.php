<?php

/* remove session participant. */
$remove_session_participant = "DELETE FROM Participants_Program_Sessions
                                WHERE
                                    Session_ID = " . $_POST['session_id'] . " AND
                                    Participant_ID = " . $_POST['participant_id'] . ";";

include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $remove_session_participant);
include "../include/dbconnclose.php";
?>