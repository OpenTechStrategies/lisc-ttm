<?php

/*
 * Add new aldermanic record (just an amount of money added at a given date).
 */

include "../include/dbconnopen.php";
$money_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['money']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);

$add_bike_miles_sqlsafe = "INSERT INTO Aldermanic_Records (Environmental_Improvement_Money, Date) VALUES
                    ('" . $money_sqlsafe ."',
                     '" . $date_sqlsafe . "')";
echo $add_bike_miles_sqlsafe;
mysqli_query($cnnBickerdike, $add_bike_miles_sqlsafe);
include "../include/dbconnclose.php";
?>
