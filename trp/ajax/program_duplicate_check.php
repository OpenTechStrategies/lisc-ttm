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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

/*check for duplicate person (warn before creating two people with the same name or CPS ID)*/
include "../include/dbconnopen.php";
if ($_POST['cps_id']!=''){
    $get_duplicate_campaigns_sqlsafe = "SELECT COUNT(Participant_ID) FROM Participants
WHERE (First_Name='" . mysqli_real_escape_string($cnnTRP, $_POST['name']) . "' AND Last_Name='". mysqli_real_escape_string($cnnTRP, $_POST['surname']) ."') OR CPS_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['cps_id']) . "'";}
else{
    $get_duplicate_campaigns_sqlsafe = "SELECT COUNT(Participant_ID) FROM Participants
WHERE (First_Name='" . mysqli_real_escape_string($cnnTRP, $_POST['name']) . "' AND Last_Name='" . mysqli_real_escape_string($cnnTRP, $_POST['surname']) . "')";
}
$is_duplicate = mysqli_query($cnnTRP, $get_duplicate_campaigns_sqlsafe);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'A person named ' .  $_POST['name'] . ' '. $_POST['surname']. ' or with this CPS ID is already in the database.  Are you sure you want to enter this person?';
}
include "../include/dbconnclose.php";

?>
