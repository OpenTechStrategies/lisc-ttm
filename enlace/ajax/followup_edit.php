<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, $DataEntryAccess);

/*add a new followup.  these are basically just notes.*/
if ($_POST['action']=='new'){
    include "../include/dbconnopen.php";
    $person_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['person']);
    $note_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['note']);
    $new_followup="INSERT INTO Followups (Participant, Note) VALUES ('".$person_sqlsafe."', '".$note_sqlsafe."')";
    mysqli_query($cnnEnlace, $new_followup);
    include "../include/dbconnclose.php";
}
?>
