<?php
echo "note: Siteconfig has been included <br>";
include $_SERVER['DOCUMENT_ROOT'] . "/auth.php";

//Are they authorized to be in this section of the site?

$sites_authorized = getSiteAccess($_COOKIE['PHPSESSID'], $TRP_id);

//kick them out if they can't be here

if (! $sites_authorized ){
    header("Location: ../include/error.html");
    exit;
}
else{
    echo "You are authorized to view this page.";
}

?>