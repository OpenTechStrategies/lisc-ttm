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

/* make a new program: */
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['name']);
$host_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['host']);
$create_program = "INSERT INTO Programs (Name, Host) VALUES ('" . $name_sqlsafe . "', '" . $host_sqlsafe . "')";
mysqli_query($cnnEnlace, $create_program);
$id = mysqli_insert_id($cnnEnlace);

date_default_timezone_set('America/Chicago');
$end_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['end']);
$session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['session']);
$session_year_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['session_year']);
$session_type_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['session_type']);
$session_name =
    ($session_year_sqlsafe != '' ? "FY$session_year_sqlsafe-" : "") .
    ($session_type_sqlsafe != '' ? "$session_type_sqlsafe-" : "") .
    $session_sqlsafe;
$start_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['start']);
$end_session = new DateTime($_POST['end']);
$survey_date = $end_session->sub(new DateInterval('P7D'));
$survey_date = $survey_date->format('Y-m-d');

/* make a new session, because every program has to have a session. */
$create_session = "INSERT INTO Session_Names (Session_Name, Program_ID, Start_Date, End_Date, Survey_Due) VALUES ('" . $session_name . "',
            $id, '" . $start_sqlsafe . "', '" . $end_sqlsafe . "', '" . $survey_date . "' )";
mysqli_query($cnnEnlace, $create_session);

/* grant admin users access to this program */
$get_enlace_admins = "SELECT Users_Privileges_ID FROM Users_Privileges WHERE Site_Privilege_ID = 1 AND Privilege_ID = 6;";
$enlace_admins = mysqli_query($cnnLISC, $get_enlace_admins);
while ($admins = mysqli_fetch_array($enlace_admins)) {
    $grant_program_access = "INSERT INTO Users_Program_Access (Users_Program_Access.Users_Privileges_ID, Users_Program_Access.Program_Access) VALUES (" . $admins[0] . ", $id);";
    mysqli_query($cnnLISC, $grant_program_access);
}

include "../include/dbconnclose.php";
?>

<br/>
<span style="color:#990000; font-weight:bold;">Thank you for adding <?php echo $_POST['name']; ?> to the database.</span><br/>
<a href="javascript:;" onclick="$.post(
                '../ajax/set_program_id.php',
                {
                    page: 'profile',
                    id: '<?php echo $id;?>'
                },
        function(response) {
            window.location = 'profile.php';
        }
        )" class="helptext">View profile</a>
