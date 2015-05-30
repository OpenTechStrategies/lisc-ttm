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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

/* the event status refers to whether or not the event shows up on the Community Engagement homepage.  This toggles the
 * active/inactive status. */
if ($_POST['action']=='add'){
    include "../include/dbconnopen.php";
    $activate_sqlsafe = "UPDATE Events SET Active='1' WHERE Event_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['event_id']) . "'";
    echo $activate_sqlsafe;
    mysqli_query($cnnTRP, $activate_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif ($_POST['action']=='remove'){
    include "../include/dbconnopen.php";
    $deactivate_sqlsafe = "UPDATE Events SET Active='0' WHERE Event_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['event_id']) . "'";
    echo $deactivate_sqlsafe;
    mysqli_query($cnnTRP, $deactivate_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
