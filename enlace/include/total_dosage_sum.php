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
/* Begin redeclaration-protection wrapper:

 */
if(!function_exists("calculate_dosage_sum")) {

/* This function is referenced in
 * /include/generalized_download_script.php.  It takes the participant
 * ID and returns the sum of hours this student spent in all programs
 * and through all mentorship sessions. 
*/
function calculate_dosage_sum($participant){
    include $_SERVER['DOCUMENT_ROOT'] . "/enlace/include/dbconnopen.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/enlace/include/dosage_percentage.php";
    $participant_sqlsafe = mysqli_real_escape_string($cnnEnlace, $participant);
    //find hours in programs
    //get the programs (not sessions) that the person is in
    $session_list_sqlsafe = "SELECT Program_ID FROM Participants_Programs WHERE Participant_ID = " . $participant_sqlsafe;
    $session_list = mysqli_query($cnnEnlace, $session_list_sqlsafe);
    
    $total_program_hours = 0;
    while ($session = mysqli_fetch_row($session_list)){
        $dosage_array = calculate_dosage($session[0], $participant_sqlsafe, null, null, false);
        $total_program_hours += $dosage_array[1];
    }
    // find hours in mentorship
    $sum_mentorship_hours_query_sqlsafe = "SELECT SUM(Mentorship_Hours_Logged) FROM Participants_Mentorship WHERE Mentee_ID = " . $participant_sqlsafe;
    $sum_mentorship_hours = mysqli_query($cnnEnlace, $sum_mentorship_hours_query_sqlsafe);
    $mentorship_hours = mysqli_fetch_row($sum_mentorship_hours);
    // add the two
    $total_hours = $total_program_hours + $mentorship_hours[0];
    // return total
    return $total_hours;
}

// end redeclaration wrapper
}

// example calculation
//  echo calculate_dosage_sum(6);
?>