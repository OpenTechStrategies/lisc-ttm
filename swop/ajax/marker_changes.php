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

/* obsolete. we now use progress activity. */

if ($_POST['marker']=='vacant') {
	$marker_field = "Is_Vacant";
}


/*$add_new_marker = "INSERT INTO Property_Markers (Is_Vacant,
    Is_Secured_Boarded,
    Is_Unsecured,
    Is_Open,
    Code_Violations,
    For_Sale,
    Price,
    Owner_Occupied,
    Absentee_Landlord,
    Property_Condition,
    Financial_Institution,
    Second_Mortgage,
    Owner,
    Type,
    Property_ID) VALUES (
    '". $_POST['vacant'] ."',
    '". $_POST['secured'] ."',
    '". $_POST['unsecured'] ."',
    '". $_POST['open'] ."',
    '". $_POST['code'] ."',
    '". $_POST['sale'] ."',
    '". $_POST['price'] ."',
    '". $_POST['owner_occ'] ."',
    '". $_POST['absentee'] ."',
   '". $_POST['condition'] ."',
   '". $_POST['bank'] ."',
   '". $_POST['second'] ."',
   '". $_POST['owner'] ."',
   '". $_POST['type'] ."',
   '". $_POST['id'] ."'
    )";
echo $add_new_marker;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $add_new_marker);
include "../include/dbconnclose.php";*/
?>
