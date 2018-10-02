<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *   Copyright (C) 2018 Open Tech Strategies, LLC
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
else if ($_POST['action']=='generate'){
    include "../include/dbconnopen.php";
    $session_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['session_id']);
    $session_query = "SELECT * FROM Session_Names WHERE Session_ID='$session_id_sqlsafe'";
    $session_info = mysqli_fetch_array(mysqli_query($cnnEnlace, $session_query));
    if($session_info !== FALSE && $session_info[3] != '0000-00-00' && $session_info[4] != '0000-00-00' &&
       $session_info[3] < $session_info[4]) {
        date_default_timezone_set('America/Chicago');
        $session_start = new DateTime($session_info[3]);
        $session_end = new DateTime($session_info[4]);
        $date_to_add = $session_start;
        $interval = new DateInterval('P1D');
        while($date_to_add <= $session_end) {
            // These match the database exactly, matching a format output from DateTime->format is coincedental and didn't
            // want to count on it.
            $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

            if($session_info[$days[$date_to_add->format('w')]] == 1) {
                $new_date="INSERT INTO Program_Dates (Program_ID, Date_Listed) VALUES
                    ('".$session_id_sqlsafe."', '".$date_to_add->format('Y-m-d')."')";
                mysqli_query($cnnEnlace, $new_date);
            }
            $date_to_add = $date_to_add->add($interval);
        }
    }
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
