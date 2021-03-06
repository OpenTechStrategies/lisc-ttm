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

user_enforce_has_access($LSNA_id, $AdminAccess);

/* delete attendance from program or campaign. */
include "../include/dbconnopen.php";
$program_date_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['program_date_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['user_id']);

$remove_attendee_from_date = "DELETE FROM Subcategory_Attendance WHERE
                            Subcategory_Date='". $program_date_id_sqlsafe."'
                                AND
                            Participant_ID='". $user_id_sqlsafe."'";
mysqli_query($cnnLSNA, $remove_attendee_from_date);
include "../include/dbconnclose.php";

?>
