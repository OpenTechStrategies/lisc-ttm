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
 * Save new walkability assessment.
 */
include "../include/dbconnopen.php";
$date_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$stop_signs_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['stop_signs']);
$speed_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['speed']);
$sidewalk_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['sidewalk']);
$intersection_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['intersection']);
$crosswalks_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['crosswalks']);

$walk_query_sqlsafe = "INSERT INTO Walkability_Assessment
    (Date_Evaluated,
     Cars_Stop,
     Speed_Limit_Obeyed,
     No_Gaps_In_Sidewalk,
     Intersection_Assessed,
     Crosswalk_Painted)
     VALUES
     ('" . $date_sqlsafe ."',
      '" . $stop_signs_sqlsafe . "',
      '" . $speed_sqlsafe . "',
      '" . $sidewalk_sqlsafe ."',
      '" . $intersection_sqlsafe . "',
      '" . $crosswalks_sqlsafe ."')";
mysqli_query($cnnBickerdike, $walk_query_sqlsafe);
include "../include/dbconnclose.php";
?>
