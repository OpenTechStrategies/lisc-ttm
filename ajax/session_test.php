<?php

$LSNA_id = 2;
$Bickerdike_id = 3;
$TRP_id = 4;
$SWOP_id = 5;
$Enlace_id = 6;

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
    $session_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $session_id);
    $end_session_sqlsafe = "DELETE FROM User_Sessions WHERE PHP_Session = '" . $session_id_sqlsafe . "'";
    $session_ended = mysqli_query($cnnLISC, $end_session_sqlsafe);
    if ($session_ended){
        return true;
    }
    else{
        return false;
    }
}

function getSiteAccess($session_id, $site){
    $path =  $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
    include $path; //connection to core db
    $session_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $session_id);
    $find_site_access_sqlsafe = "SELECT Site_Privilege_ID FROM Users_Privileges INNER JOIN User_Sessions ON User_Sessions.User_ID = Users_Privileges.User_ID WHERE PHP_Session = '" . $session_id_sqlsafe . "' AND Privilege_ID = '" . $site . "' AND Expire_Time != '0000-00-00 00:00:00'";
    $access_result = mysqli_query($cnnLISC, $find_site_access_sqlsafe);
    $has_access = mysqli_num_rows($access_result);
    if ($has_access >= 1){
        $access_return = 1;
    }
    else{
        $access_return = 0;
    }

    return $access_return;
}


?>