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

/* Create a new event, either linked to a campaign or not. */

$date_formatted = explode('/', $_POST['date']);
include "../include/dbconnopen.php";
$save_date_sqlsafe = mysqli_real_escape_string($cnnTRP, $date_formatted[2]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[0]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[1]);
$make_event_sqlsafe="INSERT INTO Events (
                    Event_Name,
                    Event_Goal,
                    Event_Date,
                    Active) VALUES(
                    '" . mysqli_real_escape_string($cnnTRP, $_POST['name']) ."',
                    '" . mysqli_real_escape_string($cnnTRP, $_POST['goal']) ."',
                    '" . $save_date_sqlsafe ."',
                        1
                    )";
mysqli_query($cnnTRP, $make_event_sqlsafe);
$id=mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>
<span style="color:#990000; font-weight:bold;">Thank you for adding  <?echo $_POST['name'];?> to the database.</span><br/>
