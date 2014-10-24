<?php

//is this person logged in?

if ($_SERVER['PHP_SELF'] != '/index.php'){
    require_once('ajax/session_test.php');
    $loggedin = isLoggedIn($_COOKIE['PHPSESSID']);
    if (! $loggedin){
        header("Location: /index.php");
        exit;
    }
    else{
//        echo "Authorized";
    }    
}

//where can they go from here?



?>