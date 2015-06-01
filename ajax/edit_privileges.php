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
/*
 * Site privileges are the level of access (admin, data entry, viewer).  Program access
 * is only relevant to some organizations (Enlace and TRP), but has to do with the 
 * program(s) that each user is allowed to view.
 * 
 * Privilege_ID refers to the site for which we are editing a user's information.
 */
include "../include/dbconnopen.php";
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/tools/auth.php");
// Make sure the user performing this action
// really is an admin.
$USER->enforce_has_access($_POST['site'], $AdminAccess);

$site_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['site']);
$user_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['user']);
$privilege_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['privilege']);

$edit_privilege_level_sqlsafe = "UPDATE Users_Privileges SET Site_Privilege_ID='" . $privilege_sqlsafe . "' WHERE
    User_ID='" . $user_sqlsafe . "' AND Privilege_Id='" . $site_sqlsafe . "'";

mysqli_query($cnnLISC, $edit_privilege_level_sqlsafe);

$get_user_privilege_id = "SELECT Users_Privileges_ID FROM Users_Privileges WHERE User_ID='" . $user_sqlsafe . "' AND Privilege_Id='" . $site_sqlsafe . "'";
$user_privilege_result = mysqli_query($cnnLISC, $get_user_privilege_id);
$user_privilege_row = mysqli_fetch_row($user_privilege_result);
$user_privilege_id = $user_privilege_row[0];

$program_access_query_sqlsafe = createProgramQuery($_POST['program'], $user_privilege_id);
mysqli_query($cnnLISC, $program_access_query_sqlsafe);


include "../include/dbconnclose.php";
?>
