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

user_enforce_has_access($Bickerdike_id, $AdminAccess);

/*
 * Deletes program.  In order to do that it needs to remove all the places where it shows
 * up as a foreign key, so we first delete the dates and users that are linked to the program.
 * (not, interestingly, the attendance.  I wonder what happens to that).
 */
include "../include/dbconnopen.php";
$id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['_id']);
$delete_dates_query_sqlsafe="DELETE FROM Program_Dates WHERE Program_ID='".$id_sqlsafe."'";
$delete_users_query_sqlsafe="DELETE FROM Programs_Users WHERE Program_ID='".$id_sqlsafe."'";
$delete_program_query_sqlsafe="DELETE FROM Programs WHERE Program_ID='".$id_sqlsafe."'";

mysqli_query($cnnBickerdike, $delete_dates_query_sqlsafe);
mysqli_query($cnnBickerdike, $delete_program_query_sqlsafe);
mysqli_query($cnnBickerdike, $delete_users_query_sqlsafe);
include "../include/dbconnclose.php";
?>
