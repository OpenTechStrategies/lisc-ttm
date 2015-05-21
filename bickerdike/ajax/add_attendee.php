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

//Check to see if attendee is already associated with date
include "../include/dbconnopen.php";
$program_date_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program_date_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);
$get_attendees_sqlsafe = "SELECT COUNT(User_ID) FROM Program_Dates_Users WHERE Program_Date_ID='" . $program_date_id_sqlsafe . "' AND User_ID='" . $user_id_sqlsafe . "'";
$is_duplicate = mysqli_query($cnnBickerdike, $get_attendees_sqlsafe);
$duplicate = mysqli_fetch_row($is_duplicate);
if (!$duplicate[0]>0){
//Add attendee to date

$add_attendee_to_date_sqlsafe = "INSERT INTO Program_Dates_Users (
                            Program_Date_ID,
                            User_ID) VALUES (
                            '". $program_date_id_sqlsafe."',
                            '". $user_id_sqlsafe."'
                            )";
echo $add_attendee_to_date_sqlsafe;
mysqli_query($cnnBickerdike, $add_attendee_to_date_sqlsafe);}
include "../include/dbconnclose.php";

?>
