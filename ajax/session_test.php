<?php

function isLoggedIn($session_id){
    $path =  $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
    include $path; //connection to core db
    $current_time = date('Y-m-d H:i:s');
    $session_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $session_id);
    $find_session_sqlsafe = "SELECT * FROM User_Sessions WHERE PHP_Session = '" . $session_id_sqlsafe . "' AND Expire_Time > '" . $current_time . "'";
    $session_active = mysqli_query($cnnLISC, $find_session_sqlsafe);
    $is_active = mysqli_num_rows($session_active);
    if ($is_active > 0){
        //this session id has been created in the last two hours with valid authentication
        return true;
    }
    else{
        return false;
    }

}

function pleaseLogOut($session_id){
    $path =  $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
    include $path; //connection to core db
    echo $path;
    $session_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $session_id);
    $end_session_sqlsafe = "DELETE FROM User_Sessions WHERE PHP_Session = '" . $session_id_sqlsafe . "'";
    echo $end_session_sqlsafe;
    $session_ended = mysqli_query($cnnLISC, $end_session_sqlsafe);
    if ($session_ended){
        return true;
    }
    else{
        return false;
    }
}


?>