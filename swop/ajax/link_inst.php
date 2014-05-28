<?php
/* link institution to campaign and participant */
if ($_POST['type']=='campaign'){
    $camp_link="INSERT INTO Campaigns_Institutions (Campaign_ID, Institution_ID)
        VALUES ('".$_POST['campaign']."', '".$_POST['inst']."')";
    echo $camp_link;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $camp_link);
    include "../include/dbconnclose.php";
}
elseif ($_POST['type']=='participant'){
    $camp_link="INSERT INTO Institutions_Participants (Institution_ID, Participant_ID)
        VALUES ('".$_POST['inst']."', '".$_POST['person']."')";
    echo $camp_link;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $camp_link);
    include "../include/dbconnclose.php";
}
?>
