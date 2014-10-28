<?php
require_once('ajax/session_test.php');

//Are they authorized to be in this section of the site?

$sites_authorized = getSiteAccess($_COOKIE['PHPSESSID'], 6);

//kick them out if they can't be here

if (! $sites_authorized ){
    header("Location: ../include/error.html");
    exit;
}
else{
    echo "You are authorized to view this page.";
}

?>