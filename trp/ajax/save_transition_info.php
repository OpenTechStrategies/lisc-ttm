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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

/* save information having to do with the middle school to high school transition program. */

/* save new explore scores. */
if($_POST['action']=='explore'){
    include "../include/dbconnopen.php";
    $add_explore_sqlsafe="INSERT INTO Explore_Scores (Participant_ID, Explore_Score_Pre, Explore_Score_Mid, Explore_Score_Post,
        Explore_Score_Fall, Reading_ISAT, Math_ISAT, Program_ID, School, School_Year) 
        VALUES ('" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['pre']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['mid']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['post']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['fall']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['reading']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['math']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['program']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['school']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "'  ) ON DUPLICATE KEY UPDATE Explore_Score_Pre='" . mysqli_real_escape_string($cnnTRP, $_POST['pre']) . "',
                Explore_Score_Mid='" . mysqli_real_escape_string($cnnTRP, $_POST['mid']) . "',
                Explore_Score_Post='" . mysqli_real_escape_string($cnnTRP, $_POST['post']) . "',
                Explore_Score_Fall='" . mysqli_real_escape_string($cnnTRP, $_POST['fall']) . "',
                Reading_ISAT='" . mysqli_real_escape_string($cnnTRP, $_POST['reading']) . "',
                Math_ISAT='" . mysqli_real_escape_string($cnnTRP, $_POST['math']) . "',
                    Program_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['program']) . "',
                        School='" . mysqli_real_escape_string($cnnTRP, $_POST['school']) . "',
                            School_Year='" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "'";
    mysqli_query($cnnTRP, $add_explore_sqlsafe);
    include "../include/dbconnclose.php";
}
/* save new discipline info. */
elseif($_POST['action']=='discipline'){
    include "../include/dbconnopen.php";
    $record_discipline_sqlsafe="INSERT INTO MS_to_HS_Over_Time (Participant_ID, School_Tardies, School_Absences_Excused,
        School_Absences_Unexcused, In_School_Suspensions, Out_School_Suspensions, Discipline_Referrals,
        Quarter, Grade, School_Year, Program_ID, School_ID) VALUES ('" . mysqli_real_escape_string($cnnTRP, $_POST['participant']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['tardy']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['excused']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['unexcused']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['in_sus']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['out_sus']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['referrals']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['quarter']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['grade']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['year']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['program']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['school']) . "'
            )";
    mysqli_query($cnnTRP, $record_discipline_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='room'){
    include "../include/dbconnopen.php";
    $record_room_sqlsafe="INSERT INTO Teacher_Exchange_Rooms (Participant_ID, Classroom, Home_Teacher, Exchange_Teacher) VALUES"
      . "('" . mysqli_real_escape_string($cnnTRP, $_POST['student']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['classroom']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['teacher'])
      . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['exchange_teacher']) . "')"
      . "ON DUPLICATE KEY UPDATE Classroom='" . mysqli_real_escape_string($cnnTRP, $_POST['classroom']) . "', "
      . "Home_Teacher='" . mysqli_real_escape_string($cnnTRP, $_POST['teacher']) ."', Exchange_Teacher='" . mysqli_real_escape_string($cnnTRP, $_POST['exchange_teacher']) . "'";
    mysqli_query($cnnTRP, $record_room_sqlsafe);
    include "../include/dbconnclose.php";
            
}
?>
