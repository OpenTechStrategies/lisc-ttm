<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, 2);

/*add a referral*/
if ($_POST['action']=='new'){
include "../include/dbconnopen.php";
$participant_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['participant']);
$person_referrer_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['person_referrer']);
$program_referrer_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program_referrer']);
$inst_referrer_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['inst_referrer']);
$program_referred_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program_referred']);
$new_referral="INSERT INTO Referrals (Participant_ID, Referrer_Person, Referrer_Program, Referrer_Institution, Program_Referred) 
    VALUES (
    '".$participant_sqlsafe."',
    '".$person_referrer_sqlsafe."',
    '".$program_referrer_sqlsafe."',
    '".$inst_referrer_sqlsafe."',
    '".$program_referred_sqlsafe."'
        )";
echo $new_referral;
mysqli_query($cnnEnlace, $new_referral);
include "../include/dbconnclose.php";
}
?>
