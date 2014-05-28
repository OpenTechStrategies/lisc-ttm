<?php
/*add new event, either to a campaign or to the Little Village-wide events*/

        include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");

/*find the block group for the entered address */
        $this_address=$_POST['address_num'] . " " .$_POST['address_dir'] . " " .$_POST['address_street']. " " .$_POST['address_suffix'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);
        echo $block_group;

$new_event = "INSERT INTO Campaigns_Events (Event_Name, Campaign_ID, Event_Date,
    Address_Num, Address_Dir, Address_Street, Address_Suffix, Block_Group, Type)
        VALUES ('".$_POST['event_name']."',
            '".$_POST['campaign_id']."',
                '".$_POST['date']."',
            '".$_POST['address_num']."',
            '".$_POST['address_dir']."',    
            '".$_POST['address_street']."',    
            '".$_POST['address_suffix']."',
                '$block_group',
            '".$_POST['event_type']."')";
echo $new_event;
 include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $new_event);
    include "../include/dbconnclose.php";
?>
