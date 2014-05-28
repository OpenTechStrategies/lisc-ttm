<?php
if ($_POST['action'] == 'user') {
    /* delete a person from the database.  have to get rid of their institutional connections first: */
    $delete_institutions = "DELETE FROM Institutions_Participants WHERE Participant_ID='" . $_POST['id'] . "'";
    $delete_from_pool = "DELETE FROM Participants_Pool WHERE Participant_ID='" . $_POST['id'] . "'";
    $delete_from_pool_progress = "DELETE FROM Pool_Progress WHERE Participant_ID='" . $_POST['id'] . "'";
    $delete_user = "DELETE FROM Participants WHERE Participant_ID='" . $_POST['id'] . "'";
    // echo $delete_user;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $delete_institutions);
    mysqli_query($cnnSWOP, $delete_from_pool);
    mysqli_query($cnnSWOP, $delete_from_pool_progress);
    mysqli_query($cnnSWOP, $delete_user);
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'property') {
    /* delete a property from the database: */
    $delete_property = "DELETE FROM Properties WHERE Property_ID='" . $_POST['id'] . "'";
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $delete_property);
    include "../include/dbconnclose.php";
}
?>
