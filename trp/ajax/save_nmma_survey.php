<?php
/* save new mexican museum of art survey.  There are actually 2 surveys that participants take in this
 * program, and I have them both saving here and being filled in on the same page. */
$date_formatted = explode('/', $_POST['date']);
$date = $date_formatted[2] . "-" . $date_formatted[0] . "-" . $date_formatted[1];
$save_id_survey = "INSERT INTO NMMA_Identity_Survey (Participant_ID, Q1, Q2, Q3, Q4, Q5, Q6, Q7, Q8, Q9, Q10, Q11, Pre_Post, Date) 
						VALUES ('" . $_POST['participant'] . "', '" . $_POST['identity_q1'] . "', '" . $_POST['identity_q2'] . "', '" . $_POST['identity_q3'] . "', '" . $_POST['identity_q4'] . "', '" . $_POST['identity_q5'] . "', '" . $_POST['identity_q6'] . "', '" . $_POST['identity_q7'] . "', '" . $_POST['identity_q8'] . "', '" . $_POST['identity_q9'] . "', '" . $_POST['identity_q10'] . "', '" . $_POST['identity_q11'] . "', '" . $_POST['type'] . "', '" . $date . "')";
//echo $save_id_survey;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $save_id_survey);

$save_trad_survey = "INSERT INTO NMMA_Traditions_Survey (Participant_ID, Q1, Q2, Q3, Q4, Q5, Q6, Q7, Q8, Pre_Post, Date) 
						VALUES ('" . $_POST['participant'] . "', '" . $_POST['traditions_q1'] . "', '" . $_POST['traditions_q2'] . "', '" . $_POST['traditions_q3'] . "', '" . $_POST['traditions_q4'] . "', '" . $_POST['traditions_q5'] . "', '" . $_POST['traditions_q6'] . "', '" . $_POST['traditions_q7'] . "', '" . $_POST['traditions_q8'] . "', '" . $_POST['type'] . "', '" . $date . "')";
//echo $save_trad_survey;
mysqli_query($cnnTRP, $save_trad_survey);
include "../include/dbconnclose.php";
?>

<span style="color:#990000; font-weight:bold;">Thank you for adding this survey to the database.</span>