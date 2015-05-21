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

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

/*
 * On the creation of a new user, checks for a user that already exists and has the same name
 */
include "../include/dbconnopen.php";
$first_name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['first_name']);
$last_name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['last_name']);
$get_duplicate_users_sqlsafe = "SELECT COUNT(User_ID) FROM Users WHERE First_Name='" . $first_name_sqlsafe . "' AND Last_Name='" . $last_name_sqlsafe . "'";
$is_duplicate = mysqli_query($cnnBickerdike, $get_duplicate_users_sqlsafe);
$duplicate = mysqli_fetch_row($is_duplicate);
/*
 * If someone with the same name does exist, issue a warning.  They have the option to proceed anyway.
 */

if ($duplicate[0]>0){
    echo 'A participant named ' . $first_name_sqlsafe . " " . $last_name_sqlsafe . ' is already in the database.  Are you sure you want to enter this user?';
}
include "../include/dbconnclose.php";

?>
