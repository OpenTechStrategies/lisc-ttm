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
    return $_SESSION['is_logged_in'];
}

function pleaseLogOut($session_id){
    session_unset();
    session_destroy();
    setcookie('PHPSESSID', '', time() - 3600, '/');
    foreach ($_SESSION as $key => $value){
        setcookie($key, '', time() - 3600, '/');
    }
    return true;
}

function getSiteAccess($session_id, $site){
    $access_return = false;
    if (array_key_exists($site, $_SESSION['site_access'])){
        $access_return = true;
    }
    return $access_return;
}

function getAllSiteAccess($user_id){
    $path =  $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
    include $path; //connection to core db
    $user_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $user_id);
    $find_site_access_sqlsafe = "SELECT Privilege_ID, Site_Privilege_ID, Program_Access FROM Users_Privileges WHERE User_ID =" . $user_id;
    $access_result = mysqli_query($cnnLISC, $find_site_access_sqlsafe);
    $access_return = array();
    while ($access = mysqli_fetch_row($access_result)){
        $access_return[$access[0]] = array($access[1], $access[2]);
    }
    return $access_return;
}

function getPermissionLevel($session_id, $site){
    session_start();
    if (session_id() == $session_id){
        if (array_key_exists($site, $_SESSION['site_access'])){
            return $_SESSION['site_access'][$site][0];
        }
    }
    else{
        return false;
    }
}

function getProgramAccess($session_id, $site){
    $program_access_array = array();
    session_start();
    if (session_id() == $session_id){
        //this needs to be updated to include the possibility of
        //access to multiple programs.
        $program_access_array[] = $_SESSION['site_access'][$site][1];
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