<?php
$LSNA_id = 2;
$Bickerdike_id = 3;
$TRP_id = 4;
$SWOP_id = 5;
$Enlace_id = 6;

$AdminAccess = 1;
$DataEntryAccess = 2;
$ReadOnlyAccess = 3;


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

function getPermissionLevel($session_id, $site){
    $path =  $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
    include $path; //connection to core db
    $session_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $session_id);
    $find_permission_level_sqlsafe = "SELECT Site_Privilege_ID FROM Users_Privileges INNER JOIN User_Sessions ON User_Sessions.User_ID = Users_Privileges.User_ID WHERE PHP_Session = '" . $session_id_sqlsafe . "' AND Privilege_ID = '" . $site . "' AND Expire_Time != '0000-00-00 00:00:00'";
    $permission_result = mysqli_query($cnnLISC, $find_permission_level_sqlsafe);
    $num_permissions = mysqli_num_rows($permission_result);
    if ($num_permissions > 1){ //this should not happen, but just in case:
        //choose the permission level with greatest amount of access -- i.e. the smallest number
        $permission_level = 3; //read-only access
        while ($permission = mysqli_fetch_row($permission_result)){
            if ($permission[0] < $permission_level){
                $permission_level = $permission[0];
            }
        }
        $returned_permission = $permission_level;
    }
    else{
        $permission_level = mysqli_fetch_row($permission_result);
        $returned_permission = $permission_level[0];
    }
    
    return $returned_permission;
}

function getProgramAccess($session_id, $site){
    $path =  $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
    include $path; //connection to core db
    $session_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $session_id);
    $find_program_access_sqlsafe = "SELECT Program_Access FROM Users_Privileges INNER JOIN User_Sessions ON User_Sessions.User_ID = Users_Privileges.User_ID WHERE PHP_Session = '" . $session_id_sqlsafe . "' AND Privilege_ID = '" . $site . "' AND Expire_Time != '0000-00-00 00:00:00'";
    $program_access_result = mysqli_query($cnnLISC, $find_program_access_sqlsafe);
    $program_access_array = array();
    while ($program_access = mysqli_fetch_row($program_access_result)){
        $program_access_array[] = $program_access[0];
    }
    //note that if 'n' is in array, then the logged-in user has access
    //to no programs, and we delete the rest of the array.  The 'n'
    //takes precedence over any other entries.

    if (in_array('n', $program_access_array)){
        $program_access_array = array('n');
    }

    return $program_access_array;
}

?>