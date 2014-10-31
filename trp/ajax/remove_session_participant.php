<?php
require_once("../siteconfig.php");
?>
<?php

/* remove session participant. */
include "../include/dbconnopen.php";
$remove_session_participant_sqlsafe = "DELETE FROM Participants_Program_Sessions
                                WHERE
                                    Session_ID = " . mysqli_real_escape_string($cnnTRP, $_POST['session_id']) . " AND
                                    Participant_ID = " . mysqli_real_escape_string($cnnTRP, $_POST['participant_id']) . ";";

mysqli_query($cnnTRP, $remove_session_participant_sqlsafe);
include "../include/dbconnclose.php";
?>