<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

/* add session participant. */
include "../include/dbconnopen.php";
$add_session_participant_sqlsafe = "INSERT INTO Participants_Program_Sessions
                                (Session_ID, Participant_ID)
                            VALUES
                                (" . mysqli_real_escape_string($cnnTRP, $_POST['session_id']) . ", " . mysqli_real_escape_string($cnnTRP, $_POST['participant_id']) . ")";

mysqli_query($cnnTRP, $add_session_participant_sqlsafe);
include "../include/dbconnclose.php";
?>