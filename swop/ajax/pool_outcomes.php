<?php
print_r($_POST);
echo "<br>";

/* add a pool outcome for a person. */

$save_outcome = "INSERT INTO Pool_Outcomes (Participant_ID, Outcome_ID, Outcome_Location, Activity_Type)
    VALUES ('". $_POST['person'] ."',
            '". $_POST['outcome'] ."',
            '". $_POST['location'] ."',
			'".$_POST['type']."')";
echo $save_outcome;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $save_outcome);
/* users can choose to keep this person active in the pool, but if they don't, then s/he will be deactivated: */
if ($_POST['active']!=true){
    $deactive="INSERT INTO Pool_Status_Changes (Active, Participant_ID, Activity_Type) VALUES (0, '".$_POST['person']."', 4)";
    echo $deactive;
    mysqli_query($cnnSWOP, $deactive);
}

include "../include/dbconnclose.php";
?>
