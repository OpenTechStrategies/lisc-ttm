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

/* edit leadership details (these are pieces from the leadership rubric) and leadership levels (primary, secondary, tertiary) */
if ($_POST['action']=='details'){
    /* add new rubric checkmarks. */
    include "../include/dbconnopen.php";
    $add_details_sqlsafe="INSERT INTO Leadership_Development (Participant_ID, Detail_ID) VALUES (".mysqli_real_escape_string($cnnSWOP, $_POST['user_id']).", ". mysqli_real_escape_string($cnnSWOP, $_POST['detail_id']).")";
    echo $add_details_sqlsafe;
    mysqli_query($cnnSWOP, $add_details_sqlsafe);
    include "../include/dbconnclose.php";
}
else{
    /* add new leadership type */
 include "../include/dbconnopen.php";
$leader_edit_sqlsafe = "INSERT INTO Participants_Leaders (Participant_ID, Leader_Type, Activity_Type)
    VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['participant']) ."', '" . mysqli_real_escape_string($cnnSWOP, $_POST['leader']) ."', '" .mysqli_real_escape_string($cnnSWOP, $_POST['type'])."')";
//echo $leader_edit_sqlsafe;
mysqli_query($cnnSWOP, $leader_edit_sqlsafe);
            include "../include/dbconnclose.php";
}?>
