<?php

/*add a referral*/
if ($_POST['action']=='new'){
$new_referral="INSERT INTO Referrals (Participant_ID, Referrer_Person, Referrer_Program, Referrer_Institution, Program_Referred) 
    VALUES (
    '".$_POST['participant']."',
    '".$_POST['person_referrer']."',
    '".$_POST['program_referrer']."',
    '".$_POST['inst_referrer']."',
    '".$_POST['program_referred']."'
        )";
echo $new_referral;
include "../include/dbconnopen.php";
mysqli_query($cnnEnlace, $new_referral);
include "../include/dbconnclose.php";
}
?>
