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
 * Adding a new person to the database:
 * 
 * Instead of one "role" column, the Bickerdike participants table has three different checkbox-like
 * columns.  This first set of ifs deciphers what the person's role is and assigns a "1" to the
 * appropriate column.
 */

include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
if ($_POST['type']=='adult'){
    $adult=1;
    $child=0;
    $parent=0;
}
elseif ($_POST['type']=='parent'){
    $adult=0;
    $child=0;
    $parent=1;
}
elseif ($_POST['type']=='youth'){
    $adult=0;
    $child=1;
    $parent=0;
}

/*
 * Calculates the block group for this address:            (this should really take into account that sometimes the address isn't entered.
 * Chicago, IL is going to get a block group and it won't be the correct one.)
 */

$this_address=$_POST['address_number'] . " " .$_POST['address_direction'] . " " .$_POST['address_street'] . " " .$_POST['address_street_type'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);

        /*
         * Taking the calculations above, insert this information into the Users table.
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
$phone_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['phone']);
        
$create_new_user_query_sqlsafe = "INSERT INTO Users (
                           First_Name,
                    Last_Name,
                    Zipcode,
                    Gender,
                    Age,
                    Race,
                    Address_Street_Name,
                    Address_Number,
                    Address_Street_Direction,
                    Address_Street_Type,
                    Block_Group,
                    email_address,
                    Adult,
                    Parent,
                    Child,
                    Phone
                    ) VALUES (
                    '" . $first_name_sqlsafe . "',
                    '" . $last_name_sqlsafe . "',
                    '" . $zip_sqlsafe . "',
                    '" . $gender_sqlsafe . "',
                    '" . $age_sqlsafe . "',
                    '" . $race_sqlsafe . "',
                    '" . $address_street_sqlsafe . "',
                    '" . $address_number_sqlsafe . "',
					'" . $address_direction_sqlsafe . "',
					'" . $address_street_type_sqlsafe . "',
                                        '$block_group',
					'" . $email_sqlsafe . "',
					
                    '$adult',
                    '$parent',
                    '$child',
        '" . $phone_sqlsafe . "'
        )";
mysqli_query($cnnBickerdike, $create_new_user_query_sqlsafe);
$user_id = mysqli_insert_id($cnnBickerdike);
include "../include/dbconnclose.php";


?>
<!--
Response shown to the data enterer:
-->

<span style="color:#990000; font-weight:bold;">Thank you for adding  <?echo $_POST['first_name'] . " " . $_POST['last_name'];?> to the database.</span>  
<a href="../users/user_profile.php?id=<?echo $user_id;?>">View profile</a>
