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

user_enforce_has_access($Enlace_id, $DataEntryAccess);

/*add a referral*/
if ($_POST['action']=='new'){
include "../include/dbconnopen.php";
$participant_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['participant']);
$person_referrer_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['person_referrer']);
$program_referrer_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program_referrer']);
$inst_referrer_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['inst_referrer']);
$program_referred_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program_referred']);
$new_referral="INSERT INTO Referrals (Participant_ID, Referrer_Person, Referrer_Program, Referrer_Institution, Program_Referred) 
    VALUES (
    '".$participant_sqlsafe."',
    '".$person_referrer_sqlsafe."',
    '".$program_referrer_sqlsafe."',
    '".$inst_referrer_sqlsafe."',
    '".$program_referred_sqlsafe."'
        )";
mysqli_query($cnnEnlace, $new_referral);
include "../include/dbconnclose.php";
}
?>
