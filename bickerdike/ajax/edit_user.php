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

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

/*
 * Change user - first check the existing address and if it has changed then recalculate the block group
 */

include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
include "../include/dbconnopen.php";
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);        
$get_existing_address_sqlsafe="SELECT Address_Number, Address_Street_Direction, Address_Street_Name, Address_Street_Type, Block_Group
            FROM Users
           WHERE User_ID='" . $user_id_sqlsafe . "'";
        $existing_address=mysqli_query($cnnBickerdike, $get_existing_address_sqlsafe);
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
include "../include/dbconnopen.php";
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
        
$edit_user_query_sqlsafe = "UPDATE Users SET 
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
mysqli_query($cnnBickerdike, $edit_user_query_sqlsafe);
include "../include/dbconnclose.php";


?>
