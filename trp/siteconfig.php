<?php
include $_SERVER['DOCUMENT_ROOT'] . "/auth.php";

//Are they authorized to be in this section of the site?

$sites_authorized = getSiteAccess($_COOKIE['PHPSESSID'], $TRP_id);

//kick them out if they can't be here

if (! $sites_authorized ) {
    header("Location: ../include/error.html");
    exit;
}
else {
    echo "You are authorized to view this page.";
}

$AccessLevelTRP = getPermissionLevel($_COOKIE['PHPSESSID'], $TRP_id);

if (($AccessLevelTRP != $AdminAccess) && ($AccessLevelTRP != $DataEntryAccess) 
&& ($AccessLevelTRP != $ReadOnlyAccess)) {
    //error!  Access level should have some other value.
    echo "Warning.  The system couldn't find level of access for you.  For now, you will have view-only access.  Please contact a data coordinator or other site administrator.";
    $Access_Level_TRP = $ReadOnlyAccess;
}


$program_access_list = getProgramAccess($_COOKIE['PHPSESSID'], $TRP_id);

?>