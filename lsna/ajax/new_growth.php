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

/* add adult education.  obsolete, since adult ed isn't included in the database
 *  for now.
 */
if ($_POST['adult_ed_year'] != ''){
    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);
    $adult_ed_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['adult_ed_year']);
    $start_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['start_level']);
    $end_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['end_level']);
    $ged_completion_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['ged_completion']);
    
    $add_growth = "INSERT INTO Participants_Growth (Participant_ID, Year, Start_Level, End_Level, GED_Completed) 
        VALUES ('" . $id_sqlsafe . "', '" . $adult_ed_year_sqlsafe . "', '" . $start_level_sqlsafe . "',
            '" . $end_level_sqlsafe . "', '" . $ged_completion_sqlsafe . "')";
    echo $add_growth;
    mysqli_query($cnnLSNA, $add_growth);
    include "../include/dbconnclose.php";
}
?>
