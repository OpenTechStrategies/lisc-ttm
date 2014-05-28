<?php
/* change participant information. */

/* check whether the address changed, and update the block group if it did */
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
$get_existing_address="SELECT Address_Street_Num, Address_Street_Direction, Address_Street_Name, Address_Street_Type, Address_city, 
    Address_State, Address_Zipcode, Block_Group
            FROM Participants
           WHERE Participant_ID='" . $_POST['id'] . "'";
        include "../include/dbconnopen.php";
        $existing_address=mysqli_query($cnnTRP, $get_existing_address);
        $address_now=mysqli_fetch_row($existing_address);
        include "../include/dbconnclose.php";
         if ($address_now[0]!=$_POST['address_num'] || $address_now[1]!=$_POST['address_dir'] || $address_now[2]!=$_POST['address_name'] ||
                $address_now[3]!=$_POST['address_type'] || $address_now[4]!=$_POST['city'] || $address_now[5]!=$_POST['state'] || 
                $address_now[6]!=$_POST['zip']){
        $this_address=$_POST['address_num'] . " " .$_POST['address_dir'] . " " .$_POST['address_name'] . " " .$_POST['address_type'] . 
                " " .$_POST['city'] . " " .$_POST['state'] . " " .$_POST['zip'];
        $block_group=do_it_all($this_address, $map);
        echo $block_group;
        }
        else{$block_group=$address_now[7]; echo "Same block group";}
$date_formatted=explode('/', $_POST['dob']);
$DOB = $date_formatted[2]."-".$date_formatted[0]."-".$date_formatted[1];

/* save the updated info. */
$edit_participant_query = "UPDATE Participants SET
                                    First_Name='" . $_POST['name'] . "',
                                    Last_Name='" . $_POST['surname'] . "',
                                    Address_Street_Name='" . $_POST['address_name'] . "',
                                    Address_Street_Num='" . $_POST['address_num'] . "',
                                    Address_Street_Direction='" . $_POST['address_dir'] . "',
                                    Address_Street_Type='" . $_POST['address_type'] . "',
                                    Address_City='" . $_POST['city'] . "',
                                    Address_State='" . $_POST['state'] . "',
                                    Address_Zipcode= '" . $_POST['zip'] . "',
                                        Block_Group='$block_group',
                                    Phone='" . $_POST['phone'] . "',
                                    Email='" . $_POST['email'] . "',
                                    Gender='" . $_POST['gender'] . "',
                                    DOB='" . $DOB . "',
									CPS_ID='" . $_POST['cps_id'] . "'
                                        WHERE Participant_ID='" . $_POST['id'] . "'";
echo $edit_participant_query;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $edit_participant_query);
//$id = mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>
