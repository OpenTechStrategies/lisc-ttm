<?php
//require_once('ajax/session_test.php');
include $_SERVER['DOCUMENT_ROOT'] . "/ajax/session_test.php";
//is this person logged in?

if ($_SERVER['PHP_SELF'] != '/index.php'){
    $loggedin = isLoggedIn($_COOKIE['PHPSESSID']);
    if (! $loggedin){
        header("Location: /index.php");
        exit;
    }
    else{
        echo "Authenticated";
    }    
}



?>