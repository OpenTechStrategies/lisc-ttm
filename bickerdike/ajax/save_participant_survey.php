<?php

/*
 * Save the responses to a participant survey.  Note that it's "insert" not "update".
 * This refers to a new survey.
 */

$user_id =$_POST['user_id'];

/*
 * We save the minutes of activity, but it's entered as hours and minutes.  This does
 * the conversion:
 */
$eight_answer = ($_POST['eight_a']*60)+$_POST['eight_b'];
//$user_id = $_POST['old_or_new']; 
//echo "somehow got into the not new user thing";
$add_survey_answers = "INSERT INTO Participant_Survey_Responses (
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
                        '" . $_POST['user_id'] ."',
                        '" . $_POST['2'] ."',
                        '" . $_POST['3'] ."',
                        '" . $_POST['four_a'] ."',
                        '" . $_POST['four_b'] ."',
                        '" . $_POST['five_a'] ."',
                        '" . $_POST['five_b'] ."',
                        '" . $_POST['6'] . "',
                        '" . $_POST['7'] . "',
                        '" . $eight_answer . "',
                        '" . $_POST['nine_a'] ."',
                        '" . $_POST['nine_b'] ."',
                        '" . $_POST['11'] . "',
                        '" . $_POST['12'] . "',
                        '" . $_POST['13'] . "',
                        '" . $_POST['14'] . "',
                        '".$_POST['date'] . "',
                        '". $_POST['pre_post'] ."',
                        '" . $_POST['program'] ."',
                         '" . $_POST['survey_type'] ."',
                             '".$_POST['child']."')";
//echo $add_survey_answers;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $add_survey_answers);
include "../include/dbconnclose.php";

?>
