<?php
/*add a new followup.  these are basically just notes.*/
if ($_POST['action']=='new'){
    $new_followup="INSERT INTO Followups (Participant, Note) VALUES ('".$_POST['person']."', '".$_POST['note']."')";
    echo $new_followup;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $new_followup);
    include "../include/dbconnclose.php";
}
?>
