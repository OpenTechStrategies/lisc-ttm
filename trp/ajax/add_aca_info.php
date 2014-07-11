<?php
/* save academic information about a person.  pulls from programs on the participant profile.  Academic information is 
 * collected for programs 2, 3, and 5. */
$add_aca_info_sqlsafe = "INSERT INTO Academic_Info (
		Participant_ID,
		Program_ID,
		School_Year,
		Quarter,
		GPA,
                ISAT_Math,
		ISAT_Reading,
		ISAT_Total,
		Grade_Level,
		Math_Grade,
		Lang_Grade,
                School
	) VALUES (
		'" . mysqli_real_escape_string($_POST['participant']) . "',
		'" . mysqli_real_escape_string($_POST['program']) . "',
		'" . mysqli_real_escape_string($_POST['year']) . "',
		'" . mysqli_real_escape_string($_POST['quarter']) . "',
		'" . mysqli_real_escape_string($_POST['gpa']) . "',
        '" . mysqli_real_escape_string($_POST['isat_math']) . "',
		'" . mysqli_real_escape_string($_POST['isat_lang']) . "',
		'" . mysqli_real_escape_string($_POST['isat']) . "',
		'" . mysqli_real_escape_string($_POST['grade']) . "',
		'" . mysqli_real_escape_string($_POST['math']) . "',
		'" . mysqli_real_escape_string($_POST['lang']) . "',
        '" . mysqli_real_escape_string($_POST['school']) . "'
	)";
echo $add_aca_info_sqlsafe;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $add_aca_info_sqlsafe);
include "../include/dbconnclose.php";
?>