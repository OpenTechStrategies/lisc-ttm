<?php

/* Begin redeclaration-protection wrapper:

 */
if(!function_exists("calculate_dosage_sum")) {

/* This function is referenced in _________.  It takes the participant
 * ID and returns the sum of hours this student spent in all programs
 * and through all mentorship sessions. */
function calculate_dosage_sum($participant){
    include $_SERVER['DOCUMENT_ROOT'] . "/enlace/include/dbconnopen.php";
    $participant_sqlsafe = mysqli_real_escape_string($cnnEnlace, $participant);

    //find hours in programs
    //get the programs (not sessions) that the person is in
    $program_list_sqlsafe = "SELECT Programs.Program_ID FROM Participants_Programs LEFT JOIN Session_Names ON Session_Names.Session_ID = Participants_Programs.Program_ID LEFT JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID WHERE Participant_ID = " . $participant_sqlsafe;
    $program_list = mysqli_query($cnnEnlace, $program_list_sqlsafe);
    $total_program_hours = 0;
    while ($program_sqlsafe = mysqli_fetch_row($program_list)){
        //find dates of program
        $num_days_attended_sqlsafe = "SELECT COUNT(Program_Date_ID) FROM Program_Dates INNER JOIN
            Session_Names ON Program_Dates.Program_ID =
            Session_Names.Session_ID INNER JOIN Programs ON
            Session_Names.Program_ID = Programs.Program_ID LEFT JOIN
            Absences ON (Program_Date_ID = Program_Date AND
            Absences.Participant_ID = $participant_sqlsafe) WHERE
            Programs.Program_ID =" . $program_sqlsafe[0] . 
            " AND Absence_ID IS NULL";
        $num_days_attended = mysqli_query($cnnEnlace, $num_days_attended_sqlsafe);
        $num_days = mysqli_fetch_row($num_days_attended);
        
        //find daily hours
        $get_program_hour_info_sqlsafe = "SELECT Start_Hour, Start_Suffix, End_Hour, End_Suffix, Max_Hours FROM Programs WHERE Program_ID = " . $program_sqlsafe[0];
        $program_hour_info = mysqli_query($cnnEnlace, $get_program_hour_info_sqlsafe);
        $program_hours = mysqli_fetch_array($program_hour_info);
        if ($program_hours['Start_Hour'] != '' && $program_hours['End_Hour'] != ''){
            if ($program_hours['End_Suffix'] == 'pm'){
                $program_hours['End_Hour'] += 12;
            }
            if ($program_hours['Start_Suffix'] == 'pm'){
                $program_hours['Start_Hour'] += 12;
            }
            $daily_hours = $program_hours['End_Hour'] - $program_hours['End_Hour'];
        }
        elseif ($program_hours['Max_Hours'] != ''){
            $daily_hours = $program_hours['Max_Hours'];
        }
        else {
            // the default is two hours
            $daily_hours = 2;
        }
        
        // catch zero hours here
        if ($daily_hours == 0) { 
            $daily_hours = 2; 
        }
        $this_program_hours = ($num_days[0] * $daily_hours);
        $total_program_hours = ($total_program_hours + $this_program_hours);
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
// echo calculate_dosage_sum(2);
?>