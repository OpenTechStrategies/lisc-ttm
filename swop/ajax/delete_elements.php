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
user_enforce_has_access($SWOP_id, $AdminAccess);

if ($_POST['action'] == 'user') {
    /* delete a person from the database.  have to get rid of their institutional connections first: */
    include "../include/dbconnopen.php";
    $delete_institutions_sqlsafe = "DELETE FROM Institutions_Participants WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    $delete_from_pool_sqlsafe = "DELETE FROM Participants_Pool WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    $delete_from_pool_progress_sqlsafe = "DELETE FROM Pool_Progress WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    $delete_user_sqlsafe = "DELETE FROM Participants WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    // echo $delete_user;
    mysqli_query($cnnSWOP, $delete_institutions_sqlsafe);
    mysqli_query($cnnSWOP, $delete_from_pool_sqlsafe);
    mysqli_query($cnnSWOP, $delete_from_pool_progress_sqlsafe);
    mysqli_query($cnnSWOP, $delete_user_sqlsafe);
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'property') {
    /* delete a property from the database: */
    include "../include/dbconnopen.php";
    $delete_property_sqlsafe = "DELETE FROM Properties WHERE Property_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    mysqli_query($cnnSWOP, $delete_property_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
