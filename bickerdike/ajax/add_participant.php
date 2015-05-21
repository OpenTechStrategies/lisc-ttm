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
 * Add new participant to a program.
 */

include "../include/dbconnopen.php";
$program_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);
$add_participant_to_program_sqlsafe = "INSERT INTO Programs_Users (
                                Program_ID,
                                User_ID) VALUES (
                                '" . $program_id_sqlsafe."',
                                '" . $user_id_sqlsafe ."'
                                )";
mysqli_query($cnnBickerdike, $add_participant_to_program_sqlsafe);
include "../include/dbconnclose.php";

/*
 * Create response -- get the newly added participant's name so that it will show up on the program profile 
 * in a "Thank you for adding ____" space.
 */

$get_participant_name_sqlsafe = "SELECT First_Name, Last_Name FROM Users WHERE User_ID='" . $user_id_sqlsafe . "'";
include "../include/dbconnopen.php";
$participant = mysqli_query($cnnBickerdike, $get_participant_name_sqlsafe);
include "../include/dbconnclose.php";
while ($name = mysqli_fetch_row($participant)){
    echo $name[0] . " " . $name[1];
}
?>
