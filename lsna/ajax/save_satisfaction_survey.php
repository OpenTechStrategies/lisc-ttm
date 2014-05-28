<?php
/* format date */
$date_reformat=explode('-', $_POST['date']);
        $save_date=$date_reformat[2] . '-'. $date_reformat[0] . '-'. $date_reformat[1];
/* add new survey: */
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
                '" . $_POST['participant_id'] . "',
                '" . $_POST['program_id'] . "',
                '" . $_POST['1'] . "',
                '" . $_POST['2'] . "',
                '" . $_POST['3'] . "',
                '" . $_POST['4'] . "',
                '" . $_POST['5'] . "',
                '" . $_POST['6'] . "',
                '" . $_POST['7'] . "',
                '" . $_POST['8'] . "',
                '" . $_POST['9'] . "',
                '" . $_POST['10'] . "',
                '" . $_POST['11'] . "',
                '" . $_POST['12'] . "',
                '". $save_date . "',
		'" . $_POST['version'] . "'
                )";
}
/* save survey edits: */
else{
    $save_query="UPDATE Satisfaction_Surveys SET 
                Participant_ID='" . $_POST['participant_id'] . "',
                Program_ID='" . $_POST['program_id'] . "',
                Question_1='" . $_POST['1'] . "',
                Question_2='" . $_POST['2'] . "',
                Question_3= '" . $_POST['3'] . "',
                Question_4='" . $_POST['4'] . "',
                Question_5='" . $_POST['5'] . "',
                Question_6='" . $_POST['6'] . "',
                Question_7='" . $_POST['7'] . "',
                Question_8= '" . $_POST['8'] . "',
                Question_9='" . $_POST['9'] . "',
                Question_10= '" . $_POST['10'] . "',
                Question_11='" . $_POST['11'] . "',
                Question_12='" . $_POST['12'] . "',
                Date='". $save_date . "',
		Version='" . $_POST['version'] . "'
                    WHERE Satisfaction_Survey_ID='".$_POST['survey_id']."'";
}
echo $save_query;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $save_query);
include "../include/dbconnclose.php";
?>
