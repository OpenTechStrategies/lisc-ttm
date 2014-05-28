<?php
/*add a new language to a participant.*/
if ($_POST['action']=='add'){
    $language_query = "INSERT INTO Participants_Languages (Participant_ID, Language_ID)
        VALUES ('". $_POST['user_id'] . "', '" . $_POST['language'] . "')";
}
?>
