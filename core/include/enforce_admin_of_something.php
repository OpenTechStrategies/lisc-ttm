<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
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
