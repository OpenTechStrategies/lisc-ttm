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

/* change event goal/actual attendance and/or date. */

$date_formatted = explode('/', $_POST['date']);
include "../include/dbconnopen.php";
$save_date_sqlsafe = mysqli_real_escape_string($cnnTRP, $date_formatted[2]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[0]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[1]);

$edit_event_sqlsafe="UPDATE Events SET
                    Event_Goal='" . mysqli_real_escape_string($cnnTRP, $_POST['goal']) ."',
                    Event_Actual='" . mysqli_real_escape_string($cnnTRP, $_POST['actual']) ."',
                    Event_Date='" . $save_date_sqlsafe ."'
                        
                        WHERE Event_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
mysqli_query($cnnTRP, $edit_event_sqlsafe);
$id=mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>
