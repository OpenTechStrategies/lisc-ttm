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
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);

/* edit the link information for participant-property (dates of link, primary or not, etc.) */
	include "../include/dbconnopen.php";
	$edit_link_sqlsafe = "UPDATE Participants_Properties SET 
			Unit_Number='" . mysqli_real_escape_string($cnnSWOP, $_POST['unit']). "',
			Rent_Own='" . mysqli_real_escape_string($cnnSWOP, $_POST['rent_own']). "',
			Start_Date='" . mysqli_real_escape_string($cnnSWOP, $_POST['start']). "',
			End_Date='" . mysqli_real_escape_string($cnnSWOP, $_POST['end']). "',
                            Primary_Residence='".mysqli_real_escape_string($cnnSWOP, $_POST['primary'])."',
			Start_Primary='" . mysqli_real_escape_string($cnnSWOP, $_POST['start_primary']). "',
			End_Primary='" . mysqli_real_escape_string($cnnSWOP, $_POST['end_primary']). "',
			Reason_End='" . mysqli_real_escape_string($cnnSWOP, $_POST['reason_end']) . "'
		WHERE Participant_Property_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['link_id']) . "'";
	
	echo $edit_link_sqlsafe;
	mysqli_query($cnnSWOP, $edit_link_sqlsafe);
	include "../include/dbconnclose.php";
	
?>