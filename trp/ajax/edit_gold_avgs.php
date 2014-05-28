<?php

if ($_POST['action']=='new'){
    print_r($_POST);
    $add_avg="INSERT INTO Class_Avg_Gold_Scores (Classroom_ID, Test_Year, Test_Time, Class_Avg, Question_ID) "
            . "VALUES ('". $_POST['classroom'] ."', '". $_POST['test_year'] ."',"
            . "'". $_POST['test_time'] ."', '". $_POST['class_avg'] ."', '". $_POST['question'] ."')";
    echo $add_avg;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $add_avg);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='link_student'){
    $add_avg="INSERT INTO Gold_Classrooms (Classroom_ID, Student_ID) "
            . "VALUES ('". $_POST['classroom'] ."', '". $_POST['student'] ."')"
            . " ON DUPLICATE KEY UPDATE Classroom_ID='". $_POST['classroom'] ."'";
    echo $add_avg;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $add_avg);
    include "../include/dbconnclose.php";
}

?>