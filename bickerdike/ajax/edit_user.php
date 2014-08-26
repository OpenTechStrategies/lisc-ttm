<?php
/*
 * Change user - first check the existing address and if it has changed then recalculate the block group
 */

include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
include "../include/dbconnopen.php";
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);        
$get_existing_address="SELECT Address_Number, Address_Street_Direction, Address_Street_Name, Address_Street_Type, Block_Group
            FROM Users
           WHERE User_ID='" . $user_id_sqlsafe . "'";
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
$first_name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['first_name']);
$last_name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['last_name']);
$zip_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['zip']);
$gender_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['gender']);
$age_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['age']);
$race_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['race']);
$address_street_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['address_street']);
$address_number_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['address_number']);
$address_direction_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['address_direction']);
$address_street_type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['address_street_type']);
$email_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['email']);
$note_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_post['note']);
$phone_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['phone']);
        
$edit_user_query = "UPDATE Users SET 
                            First_Name='" . $first_name_sqlsafe . "',
                            Last_Name='" . $last_name_sqlsafe . "',
                            Zipcode='" . $zipcode_sqlsafe . "',
							Gender='" . $gender_sqlsafe . "',
							Age='" . $age_sqlsafe . "',
							Race='" . $race_sqlsafe . "',
							Address_Street_Name='" . $address_street_sqlsafe . "',
							Address_Number='" . $address_number_sqlsafe . "',
							Address_Street_Direction='" . $address_direction_sqlsafe . "',
							Address_Street_Type='" . $address_street_type_sqlsafe . "',
                                                            Block_Group='$block_group',
							email_address='" . $email_sqlsafe . "',
                            Notes='" . $note_sqlsafe . "',
                            Phone='" . $phone_sqlsafe . "'
                            WHERE User_ID='" . $user_id_sqlsafe . "'";
//echo $edit_user_query;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $edit_user_query);
include "../include/dbconnclose.php";


?>
