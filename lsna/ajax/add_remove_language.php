<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/*add a new language to a participant.*/
if ($_POST['action']=='add'){
    $language_query = "INSERT INTO Participants_Languages (Participant_ID, Language_ID)
        VALUES ('". $_POST['user_id'] . "', '" . $_POST['language'] . "')";
}
?>
