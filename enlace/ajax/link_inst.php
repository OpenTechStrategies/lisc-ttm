<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, 2);

/* link institution to campaign*/
if ($_POST['type']=='campaign'){
    include "../include/dbconnopen.php";
    $campaign_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['campaign']);
    $inst_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['inst']);
    $camp_link="INSERT INTO Campaigns_Institutions (Campaign_ID, Institution_ID)
        VALUES ('".$campaign_sqlsafe."', '".$inst_sqlsafe."')";
    echo $camp_link;
    mysqli_query($cnnEnlace, $camp_link);
    include "../include/dbconnclose.php";
}
/*or to participant.*/
elseif ($_POST['type']=='participant'){
    include "../include/dbconnopen.php";
    $inst_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['inst']);
    $person_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['person']);
    $camp_link="INSERT INTO Institutions_Participants (Institution_ID, Participant_ID)
        VALUES ('".$inst_sqlsafe."', '".$person_sqlsafe."')";
    echo $camp_link;
    mysqli_query($cnnEnlace, $camp_link);
    include "../include/dbconnclose.php";
}
?>
