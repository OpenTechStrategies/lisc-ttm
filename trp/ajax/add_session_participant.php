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

/* add session participant. */
include "../include/dbconnopen.php";
$add_session_participant_sqlsafe = "INSERT INTO Participants_Program_Sessions
                                (Session_ID, Participant_ID)
                            VALUES
                                (" . mysqli_real_escape_string($cnnTRP, $_POST['session_id']) . ", " . mysqli_real_escape_string($cnnTRP, $_POST['participant_id']) . ")";

mysqli_query($cnnTRP, $add_session_participant_sqlsafe);
include "../include/dbconnclose.php";
?>