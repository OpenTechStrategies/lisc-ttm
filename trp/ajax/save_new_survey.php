<?php
/* add a parent survey.  It's not clear how much this will be used, since Gads Hill
 * didn't implement ETO in time to fully integrate them into this system.
 *  */
include "../include/dbconnopen.php";
	$date_formatted=explode('/', $_POST['date']);
    $date_sqlsafe = mysqli_real_escape_string($cnnTRP, $date_formatted[2]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[0]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[1]);
$save_survey_answers_sqlsafe = "INSERT INTO Gads_Hill_Parent_Survey (
    Child_ID,
    Child_Grade,
    Date_Surveyed,
    First_Part_1,
    First_Part_2,
    First_Part_3,
    First_Part_4,
    First_Part_5,
    First_Part_6,
    First_Part_7,
    First_Part_8,
    First_Part_9,
    Second_Part_1,
    Second_Part_2,
    Second_Part_3,
    Second_Part_4)
    VALUES (
    
    '" . mysqli_real_escape_string($cnnTRP, $_POST['child']) . "',
                   '" . mysqli_real_escape_string($cnnTRP, $_POST['grade']) . "',
                   '" . $date_sqlsafe . "',
                       
                   '" . mysqli_real_escape_string($cnnTRP, $_POST['first_1']) . "',
                   '" . mysqli_real_escape_string($cnnTRP, $_POST['first_2']) . "',
                   '" . mysqli_real_escape_string($cnnTRP, $_POST['first_3']) . "',
                   '" . mysqli_real_escape_string($cnnTRP, $_POST['first_4']) . "',
                    '" . mysqli_real_escape_string($cnnTRP, $_POST['first_5']) . "',
                    '" . mysqli_real_escape_string($cnnTRP, $_POST['first_6']) . "',
                    '" . mysqli_real_escape_string($cnnTRP, $_POST['first_7']) . "',
                    '" . mysqli_real_escape_string($cnnTRP, $_POST['first_8']) . "',
                    '" . mysqli_real_escape_string($cnnTRP, $_POST['first_9']) . "',
                       
                   '" . mysqli_real_escape_string($cnnTRP, $_POST['second_1']) . "',
                   '" . mysqli_real_escape_string($cnnTRP, $_POST['second_2']) . "',
                   '" . mysqli_real_escape_string($cnnTRP, $_POST['second_3']) . "',
                   '" . mysqli_real_escape_string($cnnTRP, $_POST['second_4']) . "')";
mysqli_query($cnnTRP, $save_survey_answers_sqlsafe);
include "../include/dbconnclose.php";
?>
