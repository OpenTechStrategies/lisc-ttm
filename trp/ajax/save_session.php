<?php

include "../include/dbconnopen.php";

/* save session info. */
if (!isset($_POST['session_id'])) {
    $save_session_sqlsafe = "INSERT INTO Program_Sessions (
                        Program_ID, Session_Name, Start_Date, End_Date)
                    VALUES ('"
                        . mysqli_real_escape_string($cnnTRP, $_POST['program_id']) . "','"
                        . mysqli_real_escape_string($cnnTRP, $_POST['session_name']) . "','"
                        . mysqli_real_escape_string($cnnTRP, $_POST['session_start_date']) . "','"
                        . mysqli_real_escape_string($cnnTRP, $_POST['session_end_date']) . "')";
} else {
    $save_session_sqlsafe = "UPDATE Program_Sessions
                    SET
                        Session_Name = '" . mysqli_real_escape_string($cnnTRP, $_POST['session_name']) . "',
                        Start_Date = '" . mysqli_real_escape_string($cnnTRP, $_POST['session_start_date']) . "',
                        End_Date = '" . mysqli_real_escape_string($cnnTRP, $_POST['session_end_date']) . "'
                    WHERE
                        Session_ID = " . mysqli_real_escape_string($cnnTRP, $_POST['session_id']) . ";";
}

mysqli_query($cnnTRP, $save_session_sqlsafe);
include "../include/dbconnclose.php";
?>