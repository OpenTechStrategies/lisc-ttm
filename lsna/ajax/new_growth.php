<?php
/* add adult education.  obsolete, since adult ed isn't included in the database
 *  for now.
 */
if ($_POST['adult_ed_year'] != ''){
    $add_growth = "INSERT INTO Participants_Growth (Participant_ID, Year, Start_Level, End_Level, GED_Completed) 
        VALUES ('" . $_POST['id'] . "', '" . $_POST['adult_ed_year'] . "', '" . $_POST['start_level'] . "',
            '" . $_POST['end_level'] . "', '" . $_POST['ged_completion'] . "')";
    echo $add_growth;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_growth);
    include "../include/dbconnclose.php";
}
?>
