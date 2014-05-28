<?php
/* add or remove people from an event. */

if ($_POST['action']=='add'){
    $make_event="INSERT INTO Events_Participants (
                        Event_ID,
                        Participant_ID) VALUES(
                        '" . $_POST['event'] ."',
                        '" . $_POST['person'] ."'
                        )";
    //echo $make_event;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $make_event);
    $id=mysqli_insert_id($cnnTRP);
    include "../include/dbconnclose.php";
}

elseif($_POST['action']=='remove'){
    $make_event="DELETE FROM Events_Participants WHERE
                    Events_Participants_ID='" . $_POST['id'] ."'
                    ";
    //echo $make_event;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $make_event);
    $id=mysqli_insert_id($cnnTRP);
    include "../include/dbconnclose.php";
}
?>

