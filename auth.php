<?php
//require_once('ajax/session_test.php');
include $_SERVER['DOCUMENT_ROOT'] . "/ajax/session_test.php";
//is this person logged in?

if ($_SERVER['PHP_SELF'] != '/index.php'){
    session_id($_COOKIE['PHPSESSID']);
    session_start();
    $loggedin = $_SESSION['is_logged_in'];
    if (! $loggedin){
        header("Location: /index.php");
        exit;
    }
    else{
    }    
}



?>