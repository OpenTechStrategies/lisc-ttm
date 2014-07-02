<?php
/*
 * Survey responses are edited here (presumably in a case of data entry error).
 */
include "../include/dbconnopen.php";

$two_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['2']);
$three_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['3']);
$four_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['four_a']);
$four_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['four_b']);
$five_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['five_a']);
$five_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['five_b']);
$six_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['6']);
$seven_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['7']);
$eight_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['eight']);
$nine_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['nine_a']);
$nine_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['nine_b']);
$eleven_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['11']);
$twelve_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['12']);
$thirteen_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['13']);
$fourteen_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['14']);
$program_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program']);
$survey_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['survey_id']);

$edit_survey = "UPDATE Participant_Survey_Responses SET
                Question_2='" . $two_sqlsafe . "',
                Question_3='" . $three_sqlsafe . "',
                Question_4_A='" . $four_a_sqlsafe . "',
                Question_4_B='" . $four_b_sqlsafe . "',
                Question_5_A='" . $five_a_sqlsafe . "',
                Question_5_B='" . $five_b_sqlsafe . "',
                Question_6='" . $six_sqlsafe . "',
                Question_7='" . $seven_sqlsafe . "',
                Question_8='" . $eight_sqlsafe . "',
                Question_9_A='" . $nine_a_sqlsafe . "',
                Question_9_B='" . $nine_b_sqlsafe . "',
                Question_11='" . $eleven_sqlsafe . "',
                Question_12='" . $twelve_sqlsafe . "',
                Question_13='" . $thirteen_sqlsafe . "',
                Question_14='" . $fourteen_sqlsafe . "',
                Program_ID='" . $program_sqlsafe ."'
                WHERE Participant_Survey_ID='" . $survey_id_sqlsafe . "'";
mysqli_query($cnnBickerdike, $edit_survey);
include "../include/dbconnclose.php";
?>
