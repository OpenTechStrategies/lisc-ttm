<?php
/* save information having to do with the middle school to high school transition program. */

/* save new explore scores. */
if($_POST['action']=='explore'){
    $add_explore="INSERT INTO Explore_Scores (Participant_ID, Explore_Score_Pre, Explore_Score_Mid, Explore_Score_Post,
        Explore_Score_Fall, Reading_ISAT, Math_ISAT, Program_ID, School, School_Year) 
        VALUES ('".$_POST['person']."', '".$_POST['pre']."',
            '".$_POST['mid']."',
            '".$_POST['post']."',
            '".$_POST['fall']."',
            '".$_POST['reading']."',
            '".$_POST['math']."', '".$_POST['program']."',
              '".$_POST['school']."', '".$_POST['school_year']."'  ) ON DUPLICATE KEY UPDATE Explore_Score_Pre='".$_POST['pre']."',
                Explore_Score_Mid='".$_POST['mid']."',
                Explore_Score_Post='".$_POST['post']."',
                Explore_Score_Fall='".$_POST['fall']."',
                Reading_ISAT='".$_POST['reading']."',
                Math_ISAT='".$_POST['math']."',
                    Program_ID='".$_POST['program']."',
                        School='".$_POST['school']."',
                            School_Year='".$_POST['school_year']."'";
    echo $add_explore;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $add_explore);
    include "../include/dbconnclose.php";
}
/* save new discipline info. */
elseif($_POST['action']=='discipline'){
    $record_discipline="INSERT INTO MS_to_HS_Over_Time (Participant_ID, School_Tardies, School_Absences_Excused,
        School_Absences_Unexcused, In_School_Suspensions, Out_School_Suspensions, Discipline_Referrals,
        Quarter, Grade, School_Year, Program_ID, School_ID) VALUES ('".$_POST['participant']."',
            '".$_POST['tardy']."',
            '".$_POST['excused']."',
            '".$_POST['unexcused']."',
            '".$_POST['in_sus']."',
            '".$_POST['out_sus']."',
            '".$_POST['referrals']."',
            '".$_POST['quarter']."',
            '".$_POST['grade']."',
            '".$_POST['year']."',
            '".$_POST['program']."',
            '".$_POST['school']."'
            )";
    echo $record_discipline;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $record_discipline);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='room'){
    print_r($_POST);
    $record_room="INSERT INTO Teacher_Exchange_Rooms (Participant_ID, Classroom, Home_Teacher, Exchange_Teacher) VALUES"
            . "('" . $_POST['student'] . "', '" . $_POST['classroom'] . "', '" . $_POST['teacher']
            . "', '" . $_POST['exchange_teacher'] . "')"
            . "ON DUPLICATE KEY UPDATE Classroom='" . $_POST['classroom'] . "', "
            . "Home_Teacher='" . $_POST['teacher'] ."', Exchange_Teacher='" . $_POST['exchange_teacher'] . "'";
    echo $record_room;
     include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $record_room);
    include "../include/dbconnclose.php";
            
}
?>
