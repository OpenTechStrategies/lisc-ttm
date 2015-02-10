<?php
/* link institution to campaign and participant */
if ($_POST['type']=='campaign'){
    include "../include/dbconnopen.php";
    $camp_link_sqlsafe="INSERT INTO Campaigns_Institutions (Campaign_ID, Institution_ID)
        VALUES ('".mysqli_real_escape_string($cnnSWOP, $_POST['campaign'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['inst'])."')";
    echo $camp_link_sqlsafe;
    mysqli_query($cnnSWOP, $camp_link_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif ($_POST['type']=='participant'){
    include "../include/dbconnopen.php";
    $camp_link_sqlsafe="INSERT INTO Institutions_Participants (Institution_ID, Participant_ID)
        VALUES ('".mysqli_real_escape_string($cnnSWOP, $_POST['inst'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['person'])."')";
    echo $camp_link_sqlsafe;
    mysqli_query($cnnSWOP, $camp_link_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
