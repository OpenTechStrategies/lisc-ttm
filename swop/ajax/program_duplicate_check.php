<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);

/* check when adding a new campaign that there isn't already one with that name */
if ($_POST['action']=='campaign'){
include "../include/dbconnopen.php";
$get_duplicate_campaigns_sqlsafe = "SELECT COUNT(Campaign_Name) FROM Campaigns
    WHERE Campaign_Name='" . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . "'";
//echo $get_duplicate_campaigns;
$is_duplicate = mysqli_query($cnnSWOP, $get_duplicate_campaigns_sqlsafe);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'A campaign named ' .  $_POST['name'] . ' is already in the database.  Are you sure you want to enter this campaign?';
}
include "../include/dbconnclose.php";
}
/* check the database for a same-named person when creating a new profile. */
elseif($_POST['action']=='person'){
    include "../include/dbconnopen.php";
    $get_duplicate_people_sqlsafe="SELECT COUNT(*) FROM Participants WHERE Name_First='".mysqli_real_escape_string($cnnSWOP, $_POST['first_name'])."' AND Name_Last='".mysqli_real_escape_string($cnnSWOP, $_POST['last_name'])."'";
    $is_duplicate = mysqli_query($cnnSWOP, $get_duplicate_people_sqlsafe);
    $duplicate = mysqli_fetch_row($is_duplicate);
    if ($duplicate[0]>0){
        echo 'A person named ' . $_POST['first_name']." ".$_POST['last_name'].' is already in the database.  Are you sure you want to enter this person?';
    }
    include "../include/dbconnclose.php";
}

elseif($_POST['action']=='property'){
    if ($_POST['pin']!=''){
    include "../include/dbconnopen.php";
    $get_duplicate_people_sqlsafe="SELECT COUNT(*) FROM Properties WHERE (Address_Street_Num='".mysqli_real_escape_string($cnnSWOP, $_POST['street_number'])."' AND Address_Street_Name='".mysqli_real_escape_string($cnnSWOP, $_POST['street_name'])."')"
            . "OR PIN='". mysqli_real_escape_string($cnnSWOP, $_POST['pin']) ."'";
    }
    else{
        $get_duplicate_people_sqlsafe="SELECT COUNT(*) FROM Properties WHERE (Address_Street_Num='".mysqli_real_escape_string($cnnSWOP, $_POST['street_number'])."' AND Address_Street_Name='".mysqli_real_escape_string($cnnSWOP, $_POST['street_name'])."')";
    }
    //echo $get_duplicate_people;
    $is_duplicate = mysqli_query($cnnSWOP, $get_duplicate_people_sqlsafe);
    $duplicate = mysqli_fetch_row($is_duplicate);
    if ($duplicate[0]>0){
        echo 'A property at this street number and street name, or with a matching PIN, is already in the database.  Are you sure you want to enter this property?';
    }
    include "../include/dbconnclose.php";
}

?>
