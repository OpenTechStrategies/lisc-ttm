<?php
/*check for duplicate person (warn before creating two people with the same name or CPS ID)*/
include "../include/dbconnopen.php";
if ($_POST['cps_id']!=''){
$get_duplicate_campaigns_sqlsafe = "SELECT COUNT(Participant_ID) FROM Participants
WHERE (First_Name='" . mysqli_real_escape_string($cnnTRP, $_POST['name']) . "' AND Last_Name='". mysqli_real_escape_string($cnnTRP, $_POST['surname']) ."') OR CPS_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['cps_id']) . "'";}
else{
    $get_duplicate_campaigns_sqlsafe = "SELECT COUNT(Participant_ID) FROM Participants
WHERE (First_Name='" . mysqli_real_escape_string($cnnTRP, $_POST['name']) . "' AND Last_Name='" . mysqli_real_escape_string($cnnTRP, $_POST['surname']) . "')";
}
$is_duplicate = mysqli_query($cnnTRP, $get_duplicate_campaigns_sqlsafe);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'A person named ' .  $_POST['name'] . ' '. $_POST['surname']. ' or with this CPS ID is already in the database.  Are you sure you want to enter this person?';
}
include "../include/dbconnclose.php";

?>
