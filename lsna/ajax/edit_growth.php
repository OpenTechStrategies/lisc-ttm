<?php
/*This is obsolete for now.  They decided not to include the adult ed in the 
 * ultimate version of the database.  This will probably come back, though.
 */
if ($_POST['adult_ed_year'] != ''){
    $edit_growth = "UPDATE Participants_Growth SET
         Year='" . $_POST['adult_ed_year'] . "',
          Start_Level='" . $_POST['start_level'] . "',
          End_Level='" . $_POST['end_level'] . "',
          GED_Completed='" . $_POST['ged_completion'] . "'
         WHERE Participant_Growth_ID='" . $_POST['id'] ."'";
    
    echo $edit_growth;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $edit_growth);
    include "../include/dbconnclose.php";
}
?>
