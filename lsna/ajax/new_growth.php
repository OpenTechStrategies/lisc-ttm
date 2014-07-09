<?php
/* add adult education.  obsolete, since adult ed isn't included in the database
 *  for now.
 */
if ($_POST['adult_ed_year'] != ''){
    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);
    $adult_ed_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['adult_ed_year']);
    $start_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['start_level']);
    $end_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['end_level']);
    $ged_completion_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['ged_completion']);
    
    $add_growth = "INSERT INTO Participants_Growth (Participant_ID, Year, Start_Level, End_Level, GED_Completed) 
        VALUES ('" . $id_sqlsafe . "', '" . $adult_ed_year_sqlsafe . "', '" . $start_level_sqlsafe . "',
            '" . $end_level_sqlsafe . "', '" . $ged_completion_sqlsafe . "')";
    echo $add_growth;
    mysqli_query($cnnLSNA, $add_growth);
    include "../include/dbconnclose.php";
}
?>
