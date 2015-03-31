<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $AdminAccess);

if ($_POST['action'] == 'user') {
    /* delete a person from the database.  have to get rid of their institutional connections first: */
    include "../include/dbconnopen.php";
    $delete_institutions_sqlsafe = "DELETE FROM Institutions_Participants WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    $delete_from_pool_sqlsafe = "DELETE FROM Participants_Pool WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    $delete_from_pool_progress_sqlsafe = "DELETE FROM Pool_Progress WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    $delete_user_sqlsafe = "DELETE FROM Participants WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    // echo $delete_user;
    mysqli_query($cnnSWOP, $delete_institutions_sqlsafe);
    mysqli_query($cnnSWOP, $delete_from_pool_sqlsafe);
    mysqli_query($cnnSWOP, $delete_from_pool_progress_sqlsafe);
    mysqli_query($cnnSWOP, $delete_user_sqlsafe);
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'property') {
    /* delete a property from the database: */
    include "../include/dbconnopen.php";
    $delete_property_sqlsafe = "DELETE FROM Properties WHERE Property_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
    mysqli_query($cnnSWOP, $delete_property_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
