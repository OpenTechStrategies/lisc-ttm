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

/* Add or remove a development goal.  These are notes to track participant
 *  progress.
 */
include "../include/dbconnopen.php";
$person_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['person']);
$notes_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['notes']);
$id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);

if ($_POST['action']=='new'){
    $date_reformat=explode('-', $_POST['date']);
$save_date=$date_reformat[2] . '-'. $date_reformat[0] . '-'. $date_reformat[1];
    $add_dev="INSERT INTO Goals_Development (Participant_ID, Development_Date, Notes) VALUES ('".$person_sqlsafe."',
        '".$save_date."',
            '".$notes_sqlsafe."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_dev);
    include "../include/dbconnclose.php";
    echo 'Thank you for adding this meeting.';
}
elseif($_POST['action']=='delete'){
    user_enforce_has_access($LSNA_id, $AdminAccess);
    $delete_goal="DELETE FROM Goals_Development WHERE Goals_Development_ID='" . $id_sqlsafe . "'";
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $delete_goal);
    include "../include/dbconnclose.php";
}
?>
