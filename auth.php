<?php
require_once('ajax/session_test.php');

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

//Are they authorized to be in this section of the site?


//where can they go from here?

//find out where they are allowed
$sites_authorized = getSiteAccess($_COOKIE['PHPSESSID']);

//find out where we are

//kick them out if they can't be here

?>