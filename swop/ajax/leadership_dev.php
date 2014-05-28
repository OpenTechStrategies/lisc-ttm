<?php
/* edit leadership details (these are pieces from the leadership rubric) and leadership levels (primary, secondary, tertiary) */
if ($_POST['action']=='details'){
    /* add new rubric checkmarks. */
    $add_details="INSERT INTO Leadership_Development (Participant_ID, Detail_ID) VALUES (".$_POST['user_id'].", ". $_POST['detail_id'].")";
    echo $add_details;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $add_details);
    include "../include/dbconnclose.php";
}
else{
    /* add new leadership type */
$leader_edit = "INSERT INTO Participants_Leaders (Participant_ID, Leader_Type, Activity_Type)
    VALUES ('" . $_POST['participant'] ."', '" . $_POST['leader'] ."', '" .$_POST['type']."')";
//echo $leader_edit;
 include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $leader_edit);
            include "../include/dbconnclose.php";
}?>
