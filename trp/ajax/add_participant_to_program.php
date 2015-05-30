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

/* add notes to the program-participant link.
 * 
 * add a new person to a program. */

if ($_POST['action']=='save_note'){
	include "../include/dbconnopen.php";
        $update_note_sqlsafe="UPDATE Participants_Programs SET Notes='" . mysqli_real_escape_string($cnnTRP, $_POST['note']) . "' WHERE Participant_Program_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
    mysqli_query($cnnTRP, $update_note_sqlsafe);
    include "../include/dbconnclose.php";
}
else{
    include "../include/dbconnopen.php";
	$add_participant_sqlsafe = "INSERT INTO Participants_Programs (
		Program_ID,
		Participant_ID
	) VALUES (
		'" . mysqli_real_escape_string($cnnTRP, $_POST['program_id']) . "',
		'" . mysqli_real_escape_string($cnnTRP, $_POST['participant']) . "'
	)";
    echo $add_participant_sqlsafe; //testing output
	mysqli_query($cnnTRP, $add_participant_sqlsafe);
	include "../include/dbconnclose.php";
}
?>