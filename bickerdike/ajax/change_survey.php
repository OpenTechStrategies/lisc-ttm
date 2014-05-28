<?php
/*
 * Survey responses are edited here (presumably in a case of data entry error).
 */

$edit_survey = "UPDATE Participant_Survey_Responses SET
                Question_2='" . $_POST['2'] . "',
                Question_3='" . $_POST['3'] . "',
                Question_4_A='" . $_POST['four_a'] . "',
                Question_4_B='" . $_POST['four_b'] . "',
                Question_5_A='" . $_POST['five_a'] . "',
                Question_5_B='" . $_POST['five_b'] . "',
                Question_6='" . $_POST['6'] . "',
                Question_7='" . $_POST['7'] . "',
                Question_8='" . $_POST['eight'] . "',
                Question_9_A='" . $_POST['nine_a'] . "',
                Question_9_B='" . $_POST['nine_b'] . "',
                Question_11='" . $_POST['11'] . "',
                Question_12='" . $_POST['12'] . "',
                Question_13='" . $_POST['13'] . "',
                Question_14='" . $_POST['14'] . "',
                Program_ID='" . $_POST['program'] ."'
                WHERE Participant_Survey_ID='" . $_POST['survey_id'] . "'";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $edit_survey);
include "../include/dbconnclose.php";
?>
