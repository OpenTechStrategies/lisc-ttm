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

user_enforce_has_access($Enlace_id, $DataEntryAccess);

/*
 * add new consent (by person and year)
 */
include "../include/dbconnopen.php";
$participant_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['participant']);
$year_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['year']);
$form_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['form']);
$insert_consent="INSERT INTO Participants_Consent (Participant_ID, School_Year, Consent_Given) VALUES (
    '".$participant_sqlsafe."', '".$year_sqlsafe."', '".$form_sqlsafe."')";

echo $insert_consent;

mysqli_query($cnnEnlace, $insert_consent);
include "../include/dbconnclose.php";
?>
