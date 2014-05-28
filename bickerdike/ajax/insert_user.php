<?php

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
        
$create_new_user_query = "INSERT INTO Users (
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
                    '" . $_POST['first_name'] . "',
                    '" . $_POST['last_name'] . "',
                    '" . $_POST['zip'] . "',
                    '" . $_POST['gender'] . "',
                    '" . $_POST['age'] . "',
                    '" . $_POST['race'] . "',
                    '" . $_POST['address_street'] . "',
                    '" . $_POST['address_number'] . "',
					'" . $_POST['address_direction'] . "',
					'" . $_POST['address_street_type'] . "',
                                        '$block_group',
					'" . $_POST['email'] . "',
					
                    '$adult',
                    '$parent',
                    '$child',
        '" . $_POST['phone'] . "'
        )";
//echo $create_new_user_query;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $create_new_user_query);
$user_id = mysqli_insert_id($cnnBickerdike);
include "../include/dbconnclose.php";


?>
<!--
Response shown to the data enterer:
-->

<span style="color:#990000; font-weight:bold;">Thank you for adding  <?echo $_POST['first_name'] . " " . $_POST['last_name'];?> to the database.</span>  
<a href="../users/user_profile.php?id=<?echo $user_id;?>">View profile</a>