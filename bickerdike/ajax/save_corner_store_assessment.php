<?php

/*
 * Adds a new corner store assessment.
 */


/*
 * If the store was selected from a dropdown, it already exists in the database.
 * In that case, the assessment can be entered directly.
 */
if (isset($_POST['store_id']) && $_POST['store_id'] != ''){
    include "../include/dbconnopen.php";
    $corner_query = "INSERT INTO Corner_Store_Assessment
        (Corner_Store_ID,
        2_plus_fresh_veg_options,
        Lowfat_Milk_Available,
        Health_Promotion_Signage,
        Healthy_Items_In_Front,
        Date_Evaluated)
        VALUES
        ('" . $_POST['store_id'] ."',
        '" . $_POST['produce'] . "',
        '" . $_POST['milk'] ."',
        '" . $_POST['promotions'] . "',
        '" . $_POST['stock'] . "',
        '" . $_POST['date'] . "')";
    echo $corner_query;
    mysqli_query($cnnBickerdike, $corner_query);
    $this_id = mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
}

/*
 * If not, then the store must first be added to the system, and THEN the assessment
 * can be saved.
 */
else{
include "../include/dbconnopen.php";
$new_store = "INSERT INTO Corner_Stores (Corner_Store_Name,
     Corner_Store_Address)
     VALUES
     ('" . $_POST['name'] ."',
      '" . $_POST['address'] . "')";
mysqli_query($cnnBickerdike, $new_store);
$store_id = mysqli_insert_id($cnnBickerdike);
$corner_query = "INSERT INTO Corner_Store_Assessment
    (Corner_Store_ID,
     2_plus_fresh_veg_options,
     Lowfat_Milk_Available,
     Health_Promotion_Signage,
     Healthy_Items_In_Front,
     Date_Evaluated)
     VALUES
     ('" . $store_id . "',
      '" . $_POST['produce'] . "',
      '" . $_POST['milk'] ."',
      '" . $_POST['promotions'] . "',
      '" . $_POST['stock'] . "',
      '" . $_POST['date'] . "')";
echo $corner_query;
mysqli_query($cnnBickerdike, $corner_query);
include "../include/dbconnclose.php";
}

?>
