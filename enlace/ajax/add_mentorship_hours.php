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

/*add or remove mentorship hours from a participant*/

if ($_POST['action']=='delete'){
    user_enforce_has_access($Enlace_id, 1);
    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
    $delete_mentorship="DELETE FROM Participants_Mentorship WHERE Mentorship_Time_Id='".$id_sqlsafe."'";
    mysqli_query($cnnEnlace, $delete_mentorship);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='edit'){
    include "../include/dbconnopen.php";
    $date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['date']);
    $hours_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['hours']);
    $session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['session']);
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
    $update_mentorship = "UPDATE Participants_Mentorship SET Mentorship_Date='".$date_sqlsafe."', Mentorship_Hours_Logged='".$hours_sqlsafe."',"
            . "Mentorship_Program='".$session_sqlsafe."' WHERE Mentorship_Time_ID='".$id_sqlsafe."'";
    mysqli_query($cnnEnlace, $update_mentorship);
    include "../include/dbconnclose.php";
}
else{
include "../include/dbconnopen.php";
$date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['date']);
$hours_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['hours']);
$person_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['person']);
$program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program']);
$new_mentorship_hours_query="INSERT INTO Participants_Mentorship (Mentee_ID, Mentorship_Date, Mentorship_Hours_Logged,
    Mentorship_Program) VALUES ('".$person_sqlsafe."',
        '".$date_sqlsafe."',
        '".$hours_sqlsafe."',
        '".$program_sqlsafe."')";
mysqli_query($cnnEnlace, $new_mentorship_hours_query);
include "../include/dbconnclose.php";
}
?>
