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
 * Adds a new corner store assessment.
 */


/*
 * If the store was selected from a dropdown, it already exists in the database.
 * In that case, the assessment can be entered directly.
 */
include "../include/dbconnopen.php";
$store_id_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['store_id']);
$produce_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['produce']);
$milk_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['milk']);
$promotions_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['promotions']);
$stock_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['stock']);
$date_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['date']);

if (isset($_POST['store_id']) && $_POST['store_id'] != ''){
    
    $corner_query_sqlsafe = "INSERT INTO Corner_Store_Assessment
        (Corner_Store_ID,
        2_plus_fresh_veg_options,
        Lowfat_Milk_Available,
        Health_Promotion_Signage,
        Healthy_Items_In_Front,
        Date_Evaluated)
        VALUES
        ('" . $store_id_sqlsafe ."',
        '" . $produce_sqlsafe . "',
        '" . $milk_sqlsafe ."',
        '" . $promotions_sqlsafe . "',
        '" . $stock_sqlsafe . "',
        '" . $date_sqlsafe . "')";
    mysqli_query($cnnBickerdike, $corner_query_sqlsafe);
    $this_id = mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
}

/*
 * If not, then the store must first be added to the system, and THEN the assessment
 * can be saved.
 */
else{
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['name']);
$address_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['address']);
$new_store_sqlsafe = "INSERT INTO Corner_Stores (Corner_Store_Name,
     Corner_Store_Address)
     VALUES
     ('" . $name_sqlsafe ."',
      '" . $address_sqlsafe . "')";
mysqli_query($cnnBickerdike, $new_store_sqlsafe);
$store_id = mysqli_insert_id($cnnBickerdike);
$corner_query_sqlsafe = "INSERT INTO Corner_Store_Assessment
    (Corner_Store_ID,
     2_plus_fresh_veg_options,
     Lowfat_Milk_Available,
     Health_Promotion_Signage,
     Healthy_Items_In_Front,
     Date_Evaluated)
     VALUES
     ('" . $store_id . "',
      '" . $produce_sqlsafe . "',
      '" . $milk_sqlsafe ."',
      '" . $promotions_sqlsafe . "',
      '" . $stock_sqlsafe . "',
      '" . $date_sqlsafe . "')";
mysqli_query($cnnBickerdike, $corner_query_sqlsafe);
include "../include/dbconnclose.php";
}

?>
