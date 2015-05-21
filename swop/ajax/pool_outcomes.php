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

echo "<br>";

/* add a pool outcome for a person. */
    include "../include/dbconnopen.php";

$save_outcome_sqlsafe = "INSERT INTO Pool_Outcomes (Participant_ID, Outcome_ID, Outcome_Location, Activity_Type)
    VALUES ('". mysqli_real_escape_string($cnnSWOP, $_POST['person']) ."',
            '". mysqli_real_escape_string($cnnSWOP, $_POST['outcome']) ."',
            '". mysqli_real_escape_string($cnnSWOP, $_POST['location']) ."',
			'".mysqli_real_escape_string($cnnSWOP, $_POST['type'])."')";
echo $save_outcome_sqlsafe;
mysqli_query($cnnSWOP, $save_outcome_sqlsafe);
/* users can choose to keep this person active in the pool, but if they don't, then s/he will be deactivated: */
if ($_POST['active']!=true){
    $deactive_sqlsafe="INSERT INTO Pool_Status_Changes (Active, Participant_ID, Activity_Type) VALUES (0, '".mysqli_real_escape_string($cnnSWOP, $_POST['person'])."', 4)";
    echo $deactive;
    mysqli_query($cnnSWOP, $deactive_sqlsafe);
}

include "../include/dbconnclose.php";
?>
