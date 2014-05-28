<?php
/*
 * Change user - first check the existing address and if it has changed then recalculate the block group
 */

include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
$get_existing_address="SELECT Address_Number, Address_Street_Direction, Address_Street_Name, Address_Street_Type, Block_Group
            FROM Users
           WHERE User_ID='" . $_POST['user_id'] . "'";
        include "../include/dbconnopen.php";
        $existing_address=mysqli_query($cnnBickerdike, $get_existing_address);
        $address_now=mysqli_fetch_row($existing_address);
        include "../include/dbconnclose.php";
        if ($address_now[0]!=$_POST['address_number'] || $address_now[1]!=$_POST['address_direction'] || $address_now[2]!=$_POST['address_street'] ||
                $address_now[3]!=$_POST['address_street_type']){
        $this_address=$_POST['address_number'] . " " .$_POST['address_direction'] . " " .$_POST['address_street'] . " " .$_POST['address_street_type'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);
        echo $block_group;
        }
        /*
         * If the address hasn't changed, then use the existing block group.
         */
        
        else{$block_group=$address_now[4]; echo "Same block group";}

        /*
         * Now update the user with new posted information.
         */
        
$edit_user_query = "UPDATE Users SET 
                            First_Name='" . $_POST['first_name'] . "',
                            Last_Name='" . $_POST['last_name'] . "',
                            Zipcode='" . $_POST['zipcode'] . "',
							Gender='" . $_POST['gender'] . "',
							Age='" . $_POST['age'] . "',
							Race='" . $_POST['race'] . "',
							Address_Street_Name='" . $_POST['address_street'] . "',
							Address_Number='" . $_POST['address_number'] . "',
							Address_Street_Direction='" . $_POST['address_direction'] . "',
							Address_Street_Type='" . $_POST['address_street_type'] . "',
                                                            Block_Group='$block_group',
							email_address='" . $_POST['email'] . "',
                            Notes='" . $_POST['note'] . "',
                            Phone='" . $_POST['phone'] . "'
                            WHERE User_ID='" . $_POST['user_id'] . "'";
//echo $edit_user_query;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $edit_user_query);
include "../include/dbconnclose.php";


?>
