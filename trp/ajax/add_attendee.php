<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);


/* add or remove people from an event. */

if ($_POST['action']=='add'){
    include "../include/dbconnopen.php";
    $make_event_sqlsafe="INSERT INTO Events_Participants (
                        Event_ID,
                        Participant_ID) VALUES(
                        '" . mysqli_real_escape_string($cnnTRP, $_POST['event']) ."',
                        '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) ."'
                        )";
    //echo $make_event_sqlsafe;
    mysqli_query($cnnTRP, $make_event_sqlsafe);
    $id=mysqli_insert_id($cnnTRP);
    include "../include/dbconnclose.php";
}

elseif($_POST['action']=='remove'){
user_enforce_has_access($TRP_id, $AdminAccess);
    include "../include/dbconnopen.php";
    $make_event_sqlsafe="DELETE FROM Events_Participants WHERE
                    Events_Participants_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) ."'
                    ";
    //echo $make_event_sqlsafe;
    mysqli_query($cnnTRP, $make_event_sqlsafe);
    $id=mysqli_insert_id($cnnTRP);
    include "../include/dbconnclose.php";
}
?>

