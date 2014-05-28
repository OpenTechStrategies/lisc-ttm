<?php
/* save academic information about a person.  pulls from programs on the participant profile.  Academic information is 
 * collected for programs 2, 3, and 5. */
$add_aca_info = "INSERT INTO Academic_Info (
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
		'" . $_POST['participant'] . "',
		'" . $_POST['program'] . "',
		'" . $_POST['year'] . "',
		'" . $_POST['quarter'] . "',
		'" . $_POST['gpa'] . "',
                '" . $_POST['isat_math'] . "',
		'" . $_POST['isat_lang'] . "',
		'" . $_POST['isat'] . "',
		'" . $_POST['grade'] . "',
		'" . $_POST['math'] . "',
		'" . $_POST['lang'] . "',
                    '" . $_POST['school'] . "'
	)";
echo $add_aca_info;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $add_aca_info);
include "../include/dbconnclose.php";
?>