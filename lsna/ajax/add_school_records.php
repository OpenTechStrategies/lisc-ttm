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
<?
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/*add academic info.  not just for parent mentor children, but for anyone with the child/youth role. */
	include "../include/dbconnopen.php";
        $participant_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['participant']);
        $quarter_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['quarter']);
        $reading_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['reading']);
        $math_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['math']);
        $suspensions_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['suspensions']);
        $referrals_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['referrals']);
        $days_absent_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['days_absent']);
        $school_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['school_year']);
	$add_records = "INSERT INTO PM_Children_Info (
					Child_ID,
					Quarter,
					Reading_Grade,
					Math_Grade,
					Num_Suspensions,
					Num_Office_Referrals,
					Days_Absent,
					School_Year) VALUES (
					'" . $participant_sqlsafe . "',
					'" . $quarter_sqlsafe . "',
					'" . $reading_sqlsafe . "',
					'" . $math_sqlsafe . "',
					'" . $suspensions_sqlsafe . "',
					'" . $referrals_sqlsafe . "',
					'" . $days_absent_sqlsafe . "',
					'" . $school_year_sqlsafe . "'
					)";
	
	mysqli_query($cnnLSNA, $add_records);
	include "../include/dbconnclose.php";

?>