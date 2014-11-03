<?php
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

$DATA_ENTRY = 0;
$VIEW_ONLY = 0;

$permission_level = getPermissionLevel($_COOKIE['PHPSESSID'], $TRP_id);

if ($permission_level == 2){
    $DATA_ENTRY = 1;
}
elseif ($permission_level == 3){
    $VIEW_ONLY = 1;
}
echo $DATA_ENTRY;
echo $VIEW_ONLY;
?>