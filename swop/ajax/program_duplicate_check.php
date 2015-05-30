<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
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
