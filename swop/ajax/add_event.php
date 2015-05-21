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
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);

if ($_POST['action'] == 'edit') {
    /* edit event name, date, subcampaign, and/or location */
    include "../include/dbconnopen.php";
    $edit_event_sqlsafe = "UPDATE Campaigns_Events SET 
    		Event_Name = '" . addslashes(mysqli_real_escape_string($cnnSWOP, $_POST['name'])). "',
    		Event_Date = '" . mysqli_real_escape_string($cnnSWOP, $_POST['date']). "', 
    		Subcampaign = '" . addslashes(mysqli_real_escape_string($cnnSWOP, $_POST['subcampaign'])). "',
    		Location = '" . addslashes(mysqli_real_escape_string($cnnSWOP, $_POST['location'])) . "'
    		WHERE Campaign_Event_ID = '" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    echo $edit_event_sqlsafe;
    mysqli_query($cnnSWOP, $edit_event_sqlsafe);
    include "../include/dbconnclose.php";
} else {
    /* add a new event to a campaign (may also create a new subcampaign and/or location) */
    include "../include/dbconnopen.php";
    $new_event_sqlsafe = "INSERT INTO Campaigns_Events (Event_Name, Campaign_ID, Event_Date, Subcampaign, Location)
        VALUES ('" . addslashes(mysqli_real_escape_string($cnnSWOP, $_POST['event_name'])) . "','"
            . mysqli_real_escape_string($cnnSWOP, $_POST['campaign_id']) . "','"
            . mysqli_real_escape_string($cnnSWOP, $_POST['date']) . "','"
            . addslashes(mysqli_real_escape_string($cnnSWOP, $_POST['subcampaign'])) . "','"
            . addslashes(mysqli_real_escape_string($cnnSWOP, $_POST['location'])) . "')";
    echo $new_event_sqlsafe;
    mysqli_query($cnnSWOP, $new_event_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
