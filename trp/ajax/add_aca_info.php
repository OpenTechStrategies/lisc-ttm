<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

/* save academic information about a person.  pulls from programs on the participant profile.  Academic information is 
 * collected for programs 2, 3, and 5. */
include "../include/dbconnopen.php";
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
		'" . mysqli_real_escape_string($cnnTRP, $_POST['participant']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['program']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['year']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['quarter']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['gpa']) . "',
        '" . mysqli_real_escape_string($cnnTRP, $_POST['isat_math']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['isat_lang']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['isat']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['grade']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['math']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['lang']) . "',
        '" . mysqli_real_escape_string($cnnTRP, $_POST['school']) . "'
	)";
echo $add_aca_info_sqlsafe;
mysqli_query($cnnTRP, $add_aca_info_sqlsafe);
include "../include/dbconnclose.php";
?>