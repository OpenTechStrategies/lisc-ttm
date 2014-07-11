<?php
/* save information having to do with the middle school to high school transition program. */

/* save new explore scores. */
if($_POST['action']=='explore'){
    $add_explore_sqlsafe="INSERT INTO Explore_Scores (Participant_ID, Explore_Score_Pre, Explore_Score_Mid, Explore_Score_Post,
        Explore_Score_Fall, Reading_ISAT, Math_ISAT, Program_ID, School, School_Year) 
        VALUES ('" . mysqli_real_escape_string($_POST['person']) . "', '" . mysqli_real_escape_string($_POST['pre']) . "',
            '" . mysqli_real_escape_string($_POST['mid']) . "',
            '" . mysqli_real_escape_string($_POST['post']) . "',
            '" . mysqli_real_escape_string($_POST['fall']) . "',
            '" . mysqli_real_escape_string($_POST['reading']) . "',
            '" . mysqli_real_escape_string($_POST['math']) . "', '" . mysqli_real_escape_string($_POST['program']) . "',
            '" . mysqli_real_escape_string($_POST['school']) . "', '" . mysqli_real_escape_string($_POST['school_year']) . "'  ) ON DUPLICATE KEY UPDATE Explore_Score_Pre='" . mysqli_real_escape_string($_POST['pre']) . "',
                Explore_Score_Mid='" . mysqli_real_escape_string($_POST['mid']) . "',
                Explore_Score_Post='" . mysqli_real_escape_string($_POST['post']) . "',
                Explore_Score_Fall='" . mysqli_real_escape_string($_POST['fall']) . "',
                Reading_ISAT='" . mysqli_real_escape_string($_POST['reading']) . "',
                Math_ISAT='" . mysqli_real_escape_string($_POST['math']) . "',
                    Program_ID='" . mysqli_real_escape_string($_POST['program']) . "',
                        School='" . mysqli_real_escape_string($_POST['school']) . "',
                            School_Year='" . mysqli_real_escape_string($_POST['school_year']) . "'";
    echo $add_explore_sqlsafe;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $add_explore_sqlsafe);
    include "../include/dbconnclose.php";
}
/* save new discipline info. */
elseif($_POST['action']=='discipline'){
    $record_discipline_sqlsafe="INSERT INTO MS_to_HS_Over_Time (Participant_ID, School_Tardies, School_Absences_Excused,
        School_Absences_Unexcused, In_School_Suspensions, Out_School_Suspensions, Discipline_Referrals,
        Quarter, Grade, School_Year, Program_ID, School_ID) VALUES ('" . mysqli_real_escape_string($_POST['participant']) . "',
            '" . mysqli_real_escape_string($_POST['tardy']) . "',
            '" . mysqli_real_escape_string($_POST['excused']) . "',
            '" . mysqli_real_escape_string($_POST['unexcused']) . "',
            '" . mysqli_real_escape_string($_POST['in_sus']) . "',
            '" . mysqli_real_escape_string($_POST['out_sus']) . "',
            '" . mysqli_real_escape_string($_POST['referrals']) . "',
            '" . mysqli_real_escape_string($_POST['quarter']) . "',
            '" . mysqli_real_escape_string($_POST['grade']) . "',
            '" . mysqli_real_escape_string($_POST['year']) . "',
            '" . mysqli_real_escape_string($_POST['program']) . "',
            '" . mysqli_real_escape_string($_POST['school']) . "'
            )";
    echo $record_discipline_sqlsafe;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $record_discipline_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='room'){
    print_r($_POST);
    $record_room_sqlsafe="INSERT INTO Teacher_Exchange_Rooms (Participant_ID, Classroom, Home_Teacher, Exchange_Teacher) VALUES"
      . "('" . mysqli_real_escape_string($_POST['student']) . "', '" . mysqli_real_escape_string($_POST['classroom']) . "', '" . mysqli_real_escape_string($_POST['teacher'])
      . "', '" . mysqli_real_escape_string($_POST['exchange_teacher']) . "')"
      . "ON DUPLICATE KEY UPDATE Classroom='" . mysqli_real_escape_string($_POST['classroom']) . "', "
      . "Home_Teacher='" . mysqli_real_escape_string($_POST['teacher']) ."', Exchange_Teacher='" . mysqli_real_escape_string($_POST['exchange_teacher']) . "'";
    echo $record_room_sqlsafe;
     include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $record_room_sqlsafe);
    include "../include/dbconnclose.php";
            
}
?>
