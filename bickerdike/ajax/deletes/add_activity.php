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


//create random 3-digit ID to link all activity dates

include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['name']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$org_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['org']);
$type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$new_org_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['new_org']);
$new_type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['new_type']);

if (isset($new_org_sqlsafe) && isset($new_type_sqlsafe) && $new_org_sqlsafe !='' && $new_type_sqlsafe!=''){
    $make_org_sqlsafe="INSERT INTO Org_Partners (Partner_Name) VALUES ('" . $new_org_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_org_sqlsafe);
    $org_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $make_type_sqlsafe="INSERT INTO Program_Types (Program_Type_Name) VALUES ('" . $new_type_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_type_sqlsafe);
    $type_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
$new_activity_query_sqlsafe = "INSERT INTO User_Established_Activities (
                        Activity_Name,
                        Activity_Date,
                        Activity_Type,
                        Activity_Org) VALUES (
                        '". $name_sqlsafe."',
                        '". $date_sqlsafe."',
                        '". $type_id ."',
                        '". $org_id."')";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $new_activity_query_sqlsafe);
include "../include/dbconnclose.php";
}

elseif (isset($new_org_sqlsafe) && $new_org_sqlsafe!=''){
    $make_org_sqlsafe="INSERT INTO Org_Partners (Partner_Name) VALUES ('" . $new_org_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_org_sqlsafe);
    $org_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $new_activity_query_sqlsafe = "INSERT INTO User_Established_Activities (
                        Activity_Name,
                        Activity_Date,
                        Activity_Type,
                        Activity_Org) VALUES (
                        '". $name_sqlsafe."',
                        '". $date_sqlsafe."',
                        '". $type_sqlsafe ."',
                        '". $org_id."')";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $new_activity_query_sqlsafe);
include "../include/dbconnclose.php";
}

elseif (isset($new_type_sqlsafe) && $new_type_sqlsafe!=''){
    $make_type_sqlsafe="INSERT INTO Program_Types (Program_Type_Name) VALUES ('" . $new_type_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_type_sqlsafe);
    $type_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $new_activity_query_sqlsafe = "INSERT INTO User_Established_Activities (
                            Activity_Name,
                            Activity_Date,
                            Activity_Type,
                            Activity_Org) VALUES (
                            '". $name_sqlsafe."',
                            '". $date_sqlsafe."',
                            '". $type_id ."',
                            '". $org_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $new_activity_query_sqlsafe);
    include "../include/dbconnclose.php";
}

else{
    $new_activity_query_sqlsafe = "INSERT INTO User_Established_Activities (
                            Activity_Name,
                            Activity_Date,
                            Activity_Type,
                            Activity_Org) VALUES (
                            '". $name_sqlsafe."',
                            '". $date_sqlsafe."',
                            '". $type_sqlsafe ."',
                            '". $org_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $new_activity_query_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
