<?php
/* edit leadership details (these are pieces from the leadership rubric) and leadership levels (primary, secondary, tertiary) */
if ($_POST['action']=='details'){
    /* add new rubric checkmarks. */
    include "../include/dbconnopen.php";
    $add_details_sqlsafe="INSERT INTO Leadership_Development (Participant_ID, Detail_ID) VALUES (".mysqli_real_escape_string($cnnSWOP, $_POST['user_id']).", ". mysqli_real_escape_string($cnnSWOP, $_POST['detail_id']).")";
    echo $add_details_sqlsafe;
    mysqli_query($cnnSWOP, $add_details_sqlsafe);
    include "../include/dbconnclose.php";
}
else{
    /* add new leadership type */
 include "../include/dbconnopen.php";
$leader_edit_sqlsafe = "INSERT INTO Participants_Leaders (Participant_ID, Leader_Type, Activity_Type)
    VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['participant']) ."', '" . mysqli_real_escape_string($cnnSWOP, $_POST['leader']) ."', '" .mysqli_real_escape_string($cnnSWOP, $_POST['type'])."')";
//echo $leader_edit_sqlsafe;
mysqli_query($cnnSWOP, $leader_edit_sqlsafe);
            include "../include/dbconnclose.php";
}?>
