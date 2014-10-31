<?php
require_once("../siteconfig.php");
?>
<?php
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

