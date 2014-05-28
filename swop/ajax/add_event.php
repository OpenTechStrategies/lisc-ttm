<?php
if ($_POST['action'] == 'edit') {
    /* edit event name, date, subcampaign, and/or location */
    $edit_event = "UPDATE Campaigns_Events SET 
    		Event_Name = '" . addslashes($_POST['name']) . "',
    		Event_Date = '" . $_POST['date'] . "', 
    		Subcampaign = '" . addslashes($_POST['subcampaign']) . "',
    		Location = '" . addslashes($_POST['location']) . "'
    		WHERE Campaign_Event_ID = '" . $_POST['id'] . "'";
    echo $edit_event;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $edit_event);
    include "../include/dbconnclose.php";
} else {
    /* add a new event to a campaign (may also create a new subcampaign and/or location) */
    $new_event = "INSERT INTO Campaigns_Events (Event_Name, Campaign_ID, Event_Date, Subcampaign, Location)
        VALUES ('" . addslashes($_POST['event_name']) . "','"
            . $_POST['campaign_id'] . "','"
            . $_POST['date'] . "','"
            . addslashes($_POST['subcampaign']) . "','"
            . addslashes($_POST['location']) . "')";
    echo $new_event;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $new_event);
    include "../include/dbconnclose.php";
}
?>
