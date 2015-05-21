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

user_enforce_has_access($Enlace_id, $DataEntryAccess);

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
