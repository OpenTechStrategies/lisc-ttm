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
