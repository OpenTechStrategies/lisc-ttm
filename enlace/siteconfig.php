<?php
include $_SERVER['DOCUMENT_ROOT'] . "/auth.php";

//Are they authorized to be in this section of the site?

$sites_authorized = getSiteAccess($_COOKIE['PHPSESSID'], $Enlace_id);

//send to "Not Authorized" page if $sites_authorized is false

if (! $sites_authorized ){
    header("Location: ../include/error.html");
    exit;
}
else{
    echo "You are authorized to view this page.";
}

?>