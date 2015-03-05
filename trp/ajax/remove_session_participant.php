<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $AdminAccess);


/* remove session participant. */
include "../include/dbconnopen.php";
$remove_session_participant_sqlsafe = "DELETE FROM Participants_Program_Sessions
                                WHERE
                                    Session_ID = " . mysqli_real_escape_string($cnnTRP, $_POST['session_id']) . " AND
                                    Participant_ID = " . mysqli_real_escape_string($cnnTRP, $_POST['participant_id']) . ";";

mysqli_query($cnnTRP, $remove_session_participant_sqlsafe);
include "../include/dbconnclose.php";
?>