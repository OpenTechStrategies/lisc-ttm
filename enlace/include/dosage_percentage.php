<?php

function calculate_dosage($session, $participant){
    include "dbconnopen.php";
    $num_days_attended = "SELECT COUNT(Program_Date_ID) FROM 
        Participants_Programs
        INNER JOIN Program_Dates ON Participants_Programs.Program_ID=Program_Dates.Program_ID
        INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID
        INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID
        INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID
        LEFT JOIN Absences ON ( Program_Date_ID = Program_Date AND Participants_Programs.Participant_ID=
        Absences.Participant_ID)
            WHERE Absence_ID IS NULL AND Participants_Programs.Participant_ID='$participant'
            GROUP BY Session_ID;";
    $attended_days=mysqli_query($cnnEnlace, $num_days_attended);
    $num_attended=mysqli_fetch_row($attended_days);
    $get_max_days = "SELECT COUNT(*) FROM Program_Dates WHERE Program_ID='$session'";
    $max_days = mysqli_query($cnnEnlace, $get_max_days);
    $max = mysqli_fetch_row($max_days);
    include "dbconnclose.php";
    if ($max[0] != 0) {
        $percentage = number_format(($num_attended / $max[0]) * 100, 2) . '%';
    } else {
        $percentage = 'N/A';
    }
    return array($percentage, $max);
}