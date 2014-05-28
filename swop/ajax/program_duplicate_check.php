<?php
/* check when adding a new campaign that there isn't already one with that name */
if ($_POST['action']=='campaign'){
$get_duplicate_campaigns = "SELECT COUNT(Campaign_Name) FROM Campaigns
    WHERE Campaign_Name='" . $_POST['name'] . "'";
//echo $get_duplicate_campaigns;
include "../include/dbconnopen.php";
$is_duplicate = mysqli_query($cnnSWOP, $get_duplicate_campaigns);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'A campaign named ' .  $_POST['name'] . ' is already in the database.  Are you sure you want to enter this campaign?';
}
include "../include/dbconnclose.php";
}
/* check the database for a same-named person when creating a new profile. */
elseif($_POST['action']=='person'){
    $get_duplicate_people="SELECT COUNT(*) FROM Participants WHERE Name_First='".$_POST['first_name']."' AND Name_Last='".$_POST['last_name']."'";
    include "../include/dbconnopen.php";
    $is_duplicate = mysqli_query($cnnSWOP, $get_duplicate_people);
    $duplicate = mysqli_fetch_row($is_duplicate);
    if ($duplicate[0]>0){
        echo 'A person named ' . $_POST['first_name']." ".$_POST['last_name'].' is already in the database.  Are you sure you want to enter this person?';
    }
    include "../include/dbconnclose.php";
}

elseif($_POST['action']=='property'){
    if ($_POST['pin']!=''){
    $get_duplicate_people="SELECT COUNT(*) FROM Properties WHERE (Address_Street_Num='".$_POST['street_number']."' AND Address_Street_Name='".$_POST['street_name']."')"
            . "OR PIN='". $_POST['pin'] ."'";
    }
    else{
        $get_duplicate_people="SELECT COUNT(*) FROM Properties WHERE (Address_Street_Num='".$_POST['street_number']."' AND Address_Street_Name='".$_POST['street_name']."')";
    }
    //echo $get_duplicate_people;
    include "../include/dbconnopen.php";
    $is_duplicate = mysqli_query($cnnSWOP, $get_duplicate_people);
    $duplicate = mysqli_fetch_row($is_duplicate);
    if ($duplicate[0]>0){
        echo 'A property at this street number and street name, or with a matching PIN, is already in the database.  Are you sure you want to enter this property?';
    }
    include "../include/dbconnclose.php";
}

?>
