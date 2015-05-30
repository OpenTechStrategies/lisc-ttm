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

/*basic adding and removing of absences*/
    include "../include/dbconnopen.php";
    $user_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['user_id']);
    $date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['date']);

if ($_POST['action']=='add'){
    $new_absence="INSERT INTO Absences (Participant_ID, Program_Date) VALUES ('".$user_id_sqlsafe."', '".$date_sqlsafe."')";
    echo $new_absence;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $new_absence);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='remove'){
    user_enforce_has_access($Enlace_id, 1);
    $false_absence="DELETE FROM Absences WHERE Participant_ID='".$user_id_sqlsafe."' AND Program_Date='".$date_sqlsafe."'";
    echo $false_absence;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $false_absence);
    include "../include/dbconnclose.php";
}
?>
