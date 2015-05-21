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

/*This is obsolete for now.  They decided not to include the adult ed in the 
 * ultimate version of the database.  This will probably come back, though.
 */
if ($_POST['adult_ed_year'] != ''){
    include "../include/dbconnopen.php";
    $adult_ed_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['adult_ed_year']);
    $start_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['start_level']);
    $end_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['end_level']);
    $ged_completion_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['ged_completion']);
    $id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);
    $edit_growth = "UPDATE Participants_Growth SET
         Year='" . $adult_ed_year_sqlsafe . "',
          Start_Level='" . $start_level_sqlsafe . "',
          End_Level='" . $end_level_sqlsafe . "',
          GED_Completed='" . $ged_completion_sqlsafe . "'
         WHERE Participant_Growth_ID='" . $id_sqlsafe ."'";
    
    echo $edit_growth;
    mysqli_query($cnnLSNA, $edit_growth);
    include "../include/dbconnclose.php";
}
?>
