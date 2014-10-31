<?php
require_once("../siteconfig.php");
?>
<?php
/*add a new followup.  these are basically just notes.*/
if ($_POST['action']=='new'){
    include "../include/dbconnopen.php";
    $person_sqlsafe=mysqli_real_escape_string($cnnEnlance, $_POST['person']);
    $note_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['note']);
    $new_followup="INSERT INTO Followups (Participant, Note) VALUES ('".$person_sqlsafe."', '".$note_sqlsafe."')";
    echo $new_followup;
    mysqli_query($cnnEnlace, $new_followup);
    include "../include/dbconnclose.php";
}
?>
