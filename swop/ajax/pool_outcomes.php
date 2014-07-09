<?php
print_r($_POST);
echo "<br>";

/* add a pool outcome for a person. */
    include "../include/dbconnopen.php";

$save_outcome_sqlsafe = "INSERT INTO Pool_Outcomes (Participant_ID, Outcome_ID, Outcome_Location, Activity_Type)
    VALUES ('". mysqli_real_escape_string($cnnSWOP, $_POST['person']) ."',
            '". mysqli_real_escape_string($cnnSWOP, $_POST['outcome']) ."',
            '". mysqli_real_escape_string($cnnSWOP, $_POST['location']) ."',
			'".mysqli_real_escape_string($cnnSWOP, $_POST['type'])."')";
echo $save_outcome_sqlsafe;
mysqli_query($cnnSWOP, $save_outcome_sqlsafe);
/* users can choose to keep this person active in the pool, but if they don't, then s/he will be deactivated: */
if ($_POST['active']!=true){
    $deactive_sqlsafe="INSERT INTO Pool_Status_Changes (Active, Participant_ID, Activity_Type) VALUES (0, '".mysqli_real_escape_string($cnnSWOP, $_POST['person'])."', 4)";
    echo $deactive;
    mysqli_query($cnnSWOP, $deactive_sqlsafe);
}

include "../include/dbconnclose.php";
?>
