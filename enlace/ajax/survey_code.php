<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015, 2018  Local Initiatives Support Corporation (lisc.org)
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
include "../include/survey_entry_point.php";

user_enforce_has_access($Enlace_id, $DataEntryAccess);

header("Content-type:application/json");

include "../include/dbconnopen.php";
$session_id_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['session_id']);
$participant_id_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['participant_id']);
$pre_post_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['pre_post']);

if($session_id_sqlsafe != '') {
    echo json_encode(array(
      'code' => generate_survey_entry_code($participant_id_sqlsafe, $session_id_sqlsafe, $pre_post_sqlsafe)
    ));
}
?>

