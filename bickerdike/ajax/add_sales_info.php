<?php
/*
 * Add new store information.
 * Add sales data and a date for a certain corner store (uses corner store ID, which is
 * dependent on another table).
 */
include "../include/dbconnopen.php";
$store_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['store']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$money_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['money']);

$add_sales_data = "INSERT INTO Funded_Organization_Records_Stores (Store_ID, Date, Sales_Data) VALUES
                    ('" . $store_sqlsafe ."',
                     '" . $date_sqlsafe . "',
                     '" . $money_sqlsafe . "')";
echo $add_sales_data;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $add_sales_data);
include "../include/dbconnclose.php";
?>
