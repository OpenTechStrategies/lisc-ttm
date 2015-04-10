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
        $dosage_array = calculate_dosage($session[0], $participant_sqlsafe);
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