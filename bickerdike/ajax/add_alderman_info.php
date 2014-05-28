<?php

/*
 * Add new aldermanic record (just an amount of money added at a given date).
 */

$add_bike_miles = "INSERT INTO Aldermanic_Records (Environmental_Improvement_Money, Date) VALUES
                    ('" . $_POST['money'] ."',
                     '" . $_POST['date'] . "')";
echo $add_bike_miles;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $add_bike_miles);
include "../include/dbconnclose.php";
?>
