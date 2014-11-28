<?php

/*
 * Save the responses to a participant survey.  Note that it's "insert" not "update".
 * This refers to a new survey.
 */

$user_id =$_POST['user_id'];
include "../include/dbconnopen.php";
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);
$eight_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['eight_a']);
$eight_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['eight_b']);
$two_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['2']);
$three_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['3']);
$four_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['four_a']);
$four_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['four_b']);
$five_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['five_a']);
$five_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['five_b']);
$six_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['6']);
$seven_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['7']);
$nine_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['nine_a']);
$nine_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['nine_b']);
$eleven_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['11']);
$twelve_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['12']);
$thirteen_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['13']);
$fourteen_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['14']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$pre_post_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['pre_post']);
$program_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program']);
$survey_type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['survey_type']);
$child_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['child']);


/*
 * We save the minutes of activity, but it's entered as hours and minutes.  This does
 * the conversion:
 */
$eight_answer = ($eight_a_sqlsafe*60)+$eight_b_sqlsafe;
$add_survey_answers_sqlsafe = "INSERT INTO Participant_Survey_Responses (
                        User_ID,
                        Question_2,
                        Question_3,
                        Question_4_A,
                        Question_4_B,
                        Question_5_A,
                        Question_5_B,
                        Question_6,
                        Question_7,
                        Question_8,
                        Question_9_A,
                        Question_9_B,
                        Question_11,
                        Question_12,
                        Question_13,
                        Question_14,
                        Date_Survey_Administered,
                        Pre_Post_Late,
                        Program_ID,
                        Participant_Type,
                        Child_ID
                        ) VALUES (
                        '" . $user_id_sqlsafe ."',
                        '" . $two_sqlsafe ."',
                        '" . $three_sqlsafe ."',
                        '" . $four_a_sqlsafe ."',
                        '" . $four_b_sqlsafe ."',
                        '" . $five_a_sqlsafe ."',
                        '" . $five_b_sqlsafe ."',
                        '" . $six_sqlsafe . "',
                        '" . $seven_sqlsafe . "',
                        '" . $eight_answer . "',
                        '" . $nine_a_sqlsafe ."',
                        '" . $nine_b_sqlsafe ."',
                        '" . $eleven_sqlsafe . "',
                        '" . $twelve_sqlsafe . "',
                        '" . $thirteen_sqlsafe . "',
                        '" . $fourteen_sqlsafe . "',
                        '".$date_sqlsafe . "',
                        '". $pre_post_sqlsafe ."',
                        '" . $program_sqlsafe ."',
                         '" . $survey_type_sqlsafe ."',
                             '".$child_sqlsafe."')";
mysqli_query($cnnBickerdike, $add_survey_answers_sqlsafe);
include "../include/dbconnclose.php";

?>
