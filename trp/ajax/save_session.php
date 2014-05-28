<?php

/* save session info. */
if (!isset($_POST['session_id'])) {
    $save_session = "INSERT INTO Program_Sessions (
                        Program_ID, Session_Name, Start_Date, End_Date)
                    VALUES ('"
                        . $_POST['program_id'] . "','"
                        . addslashes($_POST['session_name']) . "','"
                        . $_POST['session_start_date'] . "','"
                        . $_POST['session_end_date'] . "')";
} else {
    $save_session = "UPDATE Program_Sessions
                    SET
                        Session_Name = '" . addslashes($_POST['session_name']) . "',
                        Start_Date = '" . $_POST['session_start_date'] . "',
                        End_Date = '" . $_POST['session_end_date'] . "'
                    WHERE
                        Session_ID = " . $_POST['session_id'] . ";";
}

include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $save_session);
include "../include/dbconnclose.php";
?>