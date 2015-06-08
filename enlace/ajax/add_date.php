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

if ($_POST['action']=='delete'){
    user_enforce_has_access($Enlace_id, 1);
    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
    /* delete a session date: */
    $delete_attendance="DELETE FROM Absences WHERE Program_Date='" .$id_sqlsafe. "'";
    $delete_date="DELETE FROM Program_Dates WHERE Program_Date_ID='" .$id_sqlsafe. "'";
    mysqli_query($cnnEnlace, $delete_attendance);
    mysqli_query($cnnEnlace, $delete_date);
    include "../include/dbconnclose.php";
}
else{
/*add new program date.*/
include "../include/dbconnopen.php";
$program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program']);
$date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['date']);
$new_date="INSERT INTO Program_Dates (Program_ID, Date_Listed) VALUES 
    ('".$program_sqlsafe."', '".$date_sqlsafe."')";
echo $new_date;

mysqli_query($cnnEnlace, $new_date);
include "../include/dbconnclose.php";
}
?>
