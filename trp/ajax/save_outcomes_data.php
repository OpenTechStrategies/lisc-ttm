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

/* save outcomes data from the Community Engagement page. */
include "../include/dbconnopen.php";
$new_outcomes_data_sqlsafe = "INSERT INTO Outcomes_Months (
				Outcome_ID,
				Month,
				Year,
				Goal_Outcome,
				Actual_Outcome
				) VALUES (
				'" . mysqli_real_escape_string($cnnTRP, $_POST['outcome_id']) . "',
				'" . mysqli_real_escape_string($cnnTRP, $_POST['outcome_month']) . "',
				'" . mysqli_real_escape_string($cnnTRP, $_POST['outcome_year']) . "',
				'" . mysqli_real_escape_string($cnnTRP, $_POST['outcome_goal']) . "',
				'" . mysqli_real_escape_string($cnnTRP, $_POST['outcome_actual']) . "')";
mysqli_query($cnnTRP, $new_outcomes_data_sqlsafe);
include "../include/dbconnclose.php";

?>
