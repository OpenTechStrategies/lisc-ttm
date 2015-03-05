<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);


if ($_POST['action']=='new'){
    include "../include/dbconnopen.php";
    $add_avg_sqlsafe="INSERT INTO Class_Avg_Gold_Scores (Classroom_ID, Test_Year, Test_Time, Class_Avg, Question_ID) "
            . "VALUES ('". mysqli_real_escape_string($cnnTRP, $_POST['classroom']) ."', '". mysqli_real_escape_string($cnnTRP, $_POST['test_year']) ."',"
            . "'". mysqli_real_escape_string($cnnTRP, $_POST['test_time']) ."', '". mysqli_real_escape_string($cnnTRP, $_POST['class_avg']) ."', '". mysqli_real_escape_string($cnnTRP, $_POST['question']) ."')";
    echo $add_avg_sqlsafe;
    mysqli_query($cnnTRP, $add_avg_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='link_student'){
    include "../include/dbconnopen.php";
    $add_avg_sqlsafe="INSERT INTO Gold_Classrooms (Classroom_ID, Student_ID) "
            . "VALUES ('". mysqli_real_escape_string($cnnTRP, $_POST['classroom']) ."', '". mysqli_real_escape_string($cnnTRP, $_POST['student']) ."')"
            . " ON DUPLICATE KEY UPDATE Classroom_ID='". mysqli_real_escape_string($cnnTRP, $_POST['classroom']) ."'";
    echo $add_avg_sqlsafe;
    mysqli_query($cnnTRP, $add_avg_sqlsafe);
    include "../include/dbconnclose.php";
}

?>