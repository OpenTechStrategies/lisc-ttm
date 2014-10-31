<?php
require_once("../siteconfig.php");
?>
<?php
/* save new mexican museum of art survey.  There are actually 2 surveys that participants take in this
 * program, and I have them both saving here and being filled in on the same page. */
$date_formatted = explode('/', $_POST['date']);
include "../include/dbconnopen.php";
$date_sqlsafe = mysqli_real_escape_string($cnnTRP, $date_formatted[2]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[0]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[1]);
$save_id_survey_sqlsafe = "INSERT INTO NMMA_Identity_Survey (Participant_ID, Q1, Q2, Q3, Q4, Q5, Q6, Q7, Q8, Q9, Q10, Q11, Pre_Post, Date) 
						VALUES ('" . mysqli_real_escape_string($cnnTRP, $_POST['participant']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q1']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q2']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q3']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q4']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q5']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q6']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q7']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q8']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q9']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q10']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['identity_q11']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['type']) . "', '" . $date_sqlsafe . "')";
//echo $save_id_survey_sqlsafe;
mysqli_query($cnnTRP, $save_id_survey_sqlsafe);

$save_trad_survey_sqlsafe = "INSERT INTO NMMA_Traditions_Survey (Participant_ID, Q1, Q2, Q3, Q4, Q5, Q6, Q7, Q8, Pre_Post, Date) 
						VALUES ('" . mysqli_real_escape_string($cnnTRP, $_POST['participant']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['traditions_q1']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['traditions_q2']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['traditions_q3']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['traditions_q4']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['traditions_q5']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['traditions_q6']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['traditions_q7']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['traditions_q8']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['type']) . "', '" . $date_sqlsafe . "')";
//echo $save_trad_survey_sqlsafe;
mysqli_query($cnnTRP, $save_trad_survey_sqlsafe);
include "../include/dbconnclose.php";
?>

<span style="color:#990000; font-weight:bold;">Thank you for adding this survey to the database.</span>