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

include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['name']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$org_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['org']);
$note_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['note']);
$type_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$event_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['event_id']);
$edit_event_query_sqlsafe = "UPDATE User_Established_Activities SET 
                            Activity_Name='" . $name_sqlsafe . "',
                            Activity_Date='" . $date_sqlsafe . "',
                            Activity_Type='" . $type_sqlsafe . "',
                            Notes='" . $note_sqlsafe . "',
                            Activity_Org='" . $org_sqlsafe ."'
                            WHERE User_Established_Activities_ID='" . $event_id_sqlsafe . "'";
echo $edit_event_query_sqlsafe;
mysqli_query($cnnBickerdike, $edit_event_query_sqlsafe);
include "../include/dbconnclose.php";


?>
