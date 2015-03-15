<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

// Make sure this user is an administrator of... something.
// This is for when the admin is doing something that isn't really specific
// to one site, like setting a user's password.  They just have
// to be an administrator for one of those sites.

if (!isLoggedIn()) {
    $die_unauthorized("Sorry, you must be logged in to modify other users!");
}

$subsite_access = NULL;
// Find a site that this user has admin access for
foreach ($USER->site_permissions as $site_id => $site_info) {
    if ($USER->has_site_access($site_id, $AdminAccess)) {
        $subsite_access = $site_id;
        break;
    }
}

if (is_null($subsite_access)) {
    $die_unauthorized("You don't seem to be an administrator for any subsite!");
}
?>
