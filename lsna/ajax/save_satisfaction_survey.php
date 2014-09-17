<?php
/* format date */
$date_reformat=explode('-', $_POST['date']);
        $save_date=$date_reformat[2] . '-'. $date_reformat[0] . '-'. $date_reformat[1];
/* add new survey: */
include "../include/dbconnopen.php";
$participant_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['participant_id']);
$program_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['program_id']);
$_1_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['1']);
$_2_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['2']);
$_3_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['3']);
$_4_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['4']);
$_5_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['5']);
$_6_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['6']);
$_7_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['7']);
$_8_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['8']);
$_9_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['9']);
$_10_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['10']);
$_11_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['11']);
$_12_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['12']);
$version_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['version']);
$survey_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['survey_id']);


if ($_POST['new_survey']==1){
$save_query = "INSERT INTO Satisfaction_Surveys (
                Participant_ID,
                Program_ID,
                Question_1,
                Question_2,
                Question_3,
                Question_4,
                Question_5,
                Question_6,
                Question_7,
                Question_8,
                Question_9,
                Question_10,
                Question_11,
                Question_12,
                Date,
		Version
                ) VALUES (
                '" . $participant_id_sqlsafe . "',
                '" . $program_id_sqlsafe . "',
                '" . $_1_sqlsafe . "',
                '" . $_2_sqlsafe . "',
                '" . $_3_sqlsafe . "',
                '" . $_4_sqlsafe . "',
                '" . $_5_sqlsafe . "',
                '" . $_6_sqlsafe . "',
                '" . $_7_sqlsafe . "',
                '" . $_8_sqlsafe . "',
                '" . $_9_sqlsafe . "',
                '" . $_10_sqlsafe . "',
                '" . $_11_sqlsafe . "',
                '" . $_12_sqlsafe . "',
                '". $save_date . "',
		'" . $version_sqlsafe . "'
                )";
}
/* save survey edits: */
else{
    $save_query="UPDATE Satisfaction_Surveys SET 
                Participant_ID='" . $participant_id_sqlsafe . "',
                Program_ID='" . $program_id_sqlsafe . "',
                Question_1='" . $_1_sqlsafe . "',
                Question_2='" . $_2_sqlsafe . "',
                Question_3= '" . $_3_sqlsafe . "',
                Question_4='" . $_4_sqlsafe . "',
                Question_5='" . $_5_sqlsafe . "',
                Question_6='" . $_6_sqlsafe . "',
                Question_7='" . $_7_sqlsafe . "',
                Question_8= '" . $_8_sqlsafe . "',
                Question_9='" . $_9_sqlsafe . "',
                Question_10= '" . $_10_sqlsafe . "',
                Question_11='" . $_11_sqlsafe . "',
                Question_12='" . $_12_sqlsafe . "',
                Date='". $save_date . "',
		Version='" . $version_sqlsafe . "'
                    WHERE Satisfaction_Survey_ID='".$survey_id_sqlsafe."'";
}
mysqli_query($cnnLSNA, $save_query);
include "../include/dbconnclose.php";
?>
