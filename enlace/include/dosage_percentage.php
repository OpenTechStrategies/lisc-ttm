<?php

/* This function is referenced in enlace/programs/profile.php and in 
 * reports/production_exports.php.  It takes the session and participant
 * ID's and returns the number of days that this student attended the session,
 * the sum of hours this student spent in this program (if available), and
 * the dosage percentage. */
function calculate_dosage($session, $participant){
    include "dbconnopen.php";
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
            WHERE Absence_ID IS NULL AND Participants_Programs.Participant_ID='$participant'
            AND Session_ID='$session';";
    $attended_days=mysqli_query($cnnEnlace, $num_days_attended);
    $num_attended=mysqli_fetch_row($attended_days);
    /* This select finds the total number of days that this program was 
     * offered. */
    $get_max_days = "SELECT COUNT(*) FROM Program_Dates WHERE Program_ID='$session'";
    $max_days = mysqli_query($cnnEnlace, $get_max_days);
    $max = mysqli_fetch_row($max_days);
    /* Find the hours this person spent in the program. */
    /* Get daily hours: */
    $program_daily_hours="SELECT Start_Hour, Start_Suffix, End_Hour, End_Suffix,"
            . " Max_Hours FROM Programs INNER JOIN Session_Names "
            . " ON Session_Names.Program_ID=Programs.Program_ID WHERE Session_ID='$session'";
    $daily_hours = mysqli_query($cnnEnlace, $program_daily_hours);
    $hours = mysqli_fetch_row($daily_hours);
    /*if max hours not specified for program, use start and end times:*/
    if ($hours[4]=='' || $hours[4] == NULL){
        if ($hours[3]=='pm'){
            $hours[2]=$hours[2]+12;
        }
        if ($hours[1]=='pm'){
            $hours[0]=$hours[0]+12;
        }
        $max_daily_hours_calc=$hours[2]-$hours[0];
        $sum_hours=$num_attended[0]*$max_daily_hours_calc;
    }
    else{
        $sum_hours=$num_attended[0]*$hours[4];
    }
    include "dbconnclose.php";
    /* Calculate the dosage percentage based on days attended and total days: */
    if ($max[0] != 0) {
        $percentage = number_format(($num_attended[0] / $max[0]) * 100, 2) . '%';
    } else {
        $percentage = 'N/A';
    }
    return array($num_attended[0], $sum_hours, $percentage);
}