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
user_enforce_has_access($SWOP_id, $DataEntryAccess);

/* save property benchmarks. */
include "../include/dbconnopen.php";

$save_markers_sqlsafe="INSERT INTO Property_Progress (Marker, Addtl_Info_1, Addtl_Info_2, Addtl_Info_3, Property_ID) VALUES ('".mysqli_real_escape_string($cnnSWOP, $_POST['marker'])."',
    '" .mysqli_real_escape_string($cnnSWOP, $_POST['value']) . "', '".mysqli_real_escape_string($cnnSWOP, $_POST['add_2'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['add_3'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."')";
echo $save_markers_sqlsafe;

if ($_POST['marker']==8 && $_POST['value']=='Vacant'){
$update_current_status_sqlsafe = "UPDATE Properties SET Is_Vacant=1 WHERE Property_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."'";}
elseif ($_POST['marker']==8 && $_POST['value']=='Not vacant'){
$update_current_status_sqlsafe = "UPDATE Properties SET Is_Vacant=0 WHERE Property_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."'";}
elseif ($_POST['marker']==9 && $_POST['add_2']!=''){
$update_current_status_sqlsafe = "UPDATE Properties SET Sale_Price='".mysqli_real_escape_string($cnnSWOP, $_POST['add_2'])."' WHERE Property_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."'";}


mysqli_query($cnnSWOP, $save_markers_sqlsafe);
if ($update_current_status_sqlsafe!=''){
mysqli_query($cnnSWOP, $update_current_status_sqlsafe);}
include "../include/dbconnclose.php";
?>
