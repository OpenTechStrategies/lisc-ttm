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

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/* add notes to a program or campaign */
    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);
    $note_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['note']);
if ($_POST['type']=='program'){
    $query = "UPDATE Subcategories SET Notes='" . $note_sqlsafe . "' WHERE Subcategory_ID='" . $id_sqlsafe . "'";
    echo $query;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $query);
    include "../include/dbconnclose.php";
}

/* add or edit notes for a participant */
if ($_POST['type']=='participant'){
    $query = "UPDATE Participants SET Notes='" . $note_sqlsafe . "' WHERE Participant_ID='" . $id_sqlsafe . "'";
    echo $query;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $query);
    include "../include/dbconnclose.php";
}


?>
