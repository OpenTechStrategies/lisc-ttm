<?php
/*This is obsolete for now.  They decided not to include the adult ed in the 
 * ultimate version of the database.  This will probably come back, though.
 */
if ($_POST['adult_ed_year'] != ''){
    include "../include/dbconnopen.php";
    $adult_ed_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['adult_ed_year']);
    $start_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['start_level']);
    $end_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['end_level']);
    $ged_completion_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['ged_completion']);
    $id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);
    $edit_growth = "UPDATE Participants_Growth SET
         Year='" . $adult_ed_year_sqlsafe . "',
          Start_Level='" . $start_level_sqlsafe . "',
          End_Level='" . $end_level_sqlsafe . "',
          GED_Completed='" . $ged_completion_sqlsafe . "'
         WHERE Participant_Growth_ID='" . $id_sqlsafe ."'";

    mysqli_query($cnnLSNA, $edit_growth);
    include "../include/dbconnclose.php";
}
?>
