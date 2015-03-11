<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/* add notes to a program or campaign */
    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);
    $note_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['note']);
if ($_POST['type']=='program'){
    $query = "UPDATE Subcategories SET Notes='" . $note_sqlsafe . "' WHERE Subcategory_ID='" . $id_sqlsafe . "'";
    echo $query;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $query);
    include "../include/dbconnclose.php";
}

/* add or edit notes for a participant */
if ($_POST['type']=='participant'){
    $query = "UPDATE Participants SET Notes='" . $note_sqlsafe . "' WHERE Participant_ID='" . $id_sqlsafe . "'";
    echo $query;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $query);
    include "../include/dbconnclose.php";
}


?>
