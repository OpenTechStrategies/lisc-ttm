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

header("Content-type:application/json");

include "../include/dbconnopen.php";
$session_id_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['id']);

if($session_id_sqlsafe != '') {
    $session_info_sql = "SELECT * FROM Session_Names WHERE Session_ID = '$session_id_sqlsafe'";
    $session_info = mysqli_fetch_array(mysqli_query($cnnEnlace, $session_info_sql));
    
    echo json_encode(array(
      'name' => $session_info['Session_Name'],
      'start_hour' => $session_info['Start_Hour'],
      'start_suffix' => $session_info['Start_Suffix'],
      'end_hour' => $session_info['End_Hour'],
      'end_suffix' => $session_info['End_Suffix'],
      'monday' => $session_info['Monday'],
      'tuesday' => $session_info['Tuesday'],
      'wednesday' => $session_info['Wednesday'],
      'thursday' => $session_info['Thursday'],
      'friday' => $session_info['Friday'],
      'saturday' => $session_info['Saturday'],
      'sunday' => $session_info['Sunday'],
      'class_act' => $session_info['Activity_Class'],
      'mental' => $session_info['Activity_Clinic'],
      'referrals' => $session_info['Activity_Referrals'],
      'community' => $session_info['Activity_Community'],
      'counseling' => $session_info['Activity_Counseling'],
      'sport' => $session_info['Activity_Sports'],
      'mentors' => $session_info['Activity_Mentor'],
      'service' => $session_info['Activity_Service']
    ));
}
?>
