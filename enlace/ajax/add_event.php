<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, 2);

/*add new event, either to a campaign or to the Little Village-wide events*/

        include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");

/*find the block group for the entered address */
        $this_address=$_POST['address_num'] . " " .$_POST['address_dir'] . " " .$_POST['address_street']. " " .$_POST['address_suffix'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);
        echo $block_group;

 include "../include/dbconnopen.php";
 $event_name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['event_name']);
 $campaign_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['campaign_id']);
 $date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['date']);
 $address_num_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_num']);
 $address_dir_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_dir']);
 $address_street_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_street']);
 $address_suffix_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_suffix']);
 $event_type_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['event_type']);
 
$new_event = "INSERT INTO Campaigns_Events (Event_Name, Campaign_ID, Event_Date,
    Address_Num, Address_Dir, Address_Street, Address_Suffix, Block_Group, Type)
        VALUES ('".$event_name_sqlsafe."',
            '".$campaign_id_sqlsafe."',
                '".$date_sqlsafe."',
            '".$address_num_sqlsafe."',
            '".$address_dir_sqlsafe."',    
            '".$address_street_sqlsafe."',    
            '".$address_suffix_sqlsafe."',
                '$block_group',
            '".$event_type_sqlsafe."')";
echo $new_event;
    mysqli_query($cnnEnlace, $new_event);
    include "../include/dbconnclose.php";
?>
