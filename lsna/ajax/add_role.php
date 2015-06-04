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
<?
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/* add role - people can have more than one */
include "../include/dbconnopen.php";
$user_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['user_id']);
$role_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['role']);
if ($_POST['action']=='add'){
    $add_role = "INSERT INTO Participants_Roles (Participant_ID, Role_ID) VALUES ('" . $user_id_sqlsafe . "', '" . $role_sqlsafe . "')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_role);
    include "../include/dbconnclose.php";
}
/* remove participant role */
elseif ($_POST['action']=='remove'){
    $remove_role = "DELETE FROM Participants_Roles WHERE Participant_ID='" . $user_id_sqlsafe . "' AND Role_ID='" . $role_sqlsafe . "'";
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $remove_role);
    include "../include/dbconnclose.php";
}
?>
