<?php

/* Begin redeclaration-protection wrapper:

   Nested includes seem to cause this file to be included multiple
   times from somewhere.  While we should trace that down, it may
   turn out to be unavoidable or at least very difficult to avoid,
   so we just protect against redeclaration with this wrapper.  
   See issue #34 and issue #35 for more details. */
if(!function_exists("calculate_dosage")) {

/* This function is referenced in enlace/programs/profile.php and in 
 * reports/production_exports.php.  It takes the session and participant
 * ID's and returns the number of days that this student attended the session,
 * the sum of hours this student spent in this program (if available), and
 * the dosage percentage. */
function calculate_dosage($session, $participant){
    include $_SERVER['DOCUMENT_ROOT'] . "/enlace/include/dbconnopen.php";
    $session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $session);
    $participant_sqlsafe=mysqli_real_escape_string($cnnEnlace, $participant);
    /* This select finds the number of days that the student attended this
     * program. */
    $num_days_attended = "SELECT COUNT(Program_Date_ID) FROM 
        Participants_Programs
        INNER JOIN Program_Dates ON Participants_Programs.Program_ID=Program_Dates.Program_ID
        INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID
        INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID
        INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID
        LEFT JOIN Absences ON ( Program_Date_ID = Program_Date AND Participants_Programs.Participant_ID=
        Absences.Participant_ID)
            WHERE Absence_ID IS NULL AND Participants_Programs.Participant_ID='$participant_sqlsafe'
            AND Session_ID='$session_sqlsafe';";
    $attended_days=mysqli_query($cnnEnlace, $num_days_attended);
    $num_attended=mysqli_fetch_row($attended_days);
    /* This select finds the total number of days that this program was 
     * offered. */
    $get_max_days = "SELECT COUNT(*) FROM Program_Dates WHERE Program_ID='$session_sqlsafe'";
    $max_days = mysqli_query($cnnEnlace, $get_max_days);
    $max = mysqli_fetch_row($max_days);
    /* Find the hours this person spent in the program. */
    /* Get daily hours: */
    $program_daily_hours="SELECT Start_Hour, Start_Suffix, End_Hour, End_Suffix,"
            . " Max_Hours FROM Programs INNER JOIN Session_Names "
            . " ON Session_Names.Program_ID=Programs.Program_ID WHERE Session_ID='$session_sqlsafe'";
    $program_hours_per_day = mysqli_query($cnnEnlace, $program_daily_hours);
    $program_hours = mysqli_fetch_array($program_hours_per_day);
 if ($program_hours['Start_Hour'] != '' && $program_hours['Start_Hour'] != 0  && $program_hours['End_Hour'] != '' && $program_hours['End_Hour'] != 0){
     if ($program_hours['End_Suffix'] == 'pm'){
         $program_hours['End_Hour'] += 12;
     }
     if ($program_hours['Start_Suffix'] == 'pm'){
         $program_hours['Start_Hour'] += 12;
     }
     $daily_hours = $program_hours['End_Hour'] - $program_hours['Start_Hour'];
 }
 elseif ($program_hours['Max_Hours'] != '' && $program_hours['Max_Hours'] != 0){
     $daily_hours = $program_hours['Max_Hours'];
 }
 else {
     // the default is two hours
     $daily_hours = 2;
 }

 //final test
 if ($daily_hours == 0 || $daily_hours == ''){
     $daily_hours = 2;
 }
 $sum_hours=$num_attended[0]*$daily_hours;
  
    include "dbconnclose.php";
    /* Calculate the dosage percentage based on days attended and total days: */
    if ($max[0] != 0) {
        $percentage = number_format(($num_attended[0] / $max[0]) * 100, 2) . '%';
    } else {
        $percentage = 'N/A';
    }
    return array($num_attended[0], $sum_hours, $percentage);
}

/* End redeclaration-protection wrapper: */
}
