<?php
/*
 * Add new store information (sorry about the misleading variable names).
 * Add sales data and a date for a certain corner store (uses corner store ID, which is
 * dependent on another table).
 */

$add_bike_miles = "INSERT INTO Funded_Organization_Records_Stores (Store_ID, Date, Sales_Data) VALUES
                    ('" . $_POST['store'] ."',
                     '" . $_POST['date'] . "',
                     '" . $_POST['money'] . "')";
echo $add_bike_miles;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $add_bike_miles);
include "../include/dbconnclose.php";
?>
