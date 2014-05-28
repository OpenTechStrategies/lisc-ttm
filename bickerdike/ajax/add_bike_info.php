<?php
/*
 * Add new bike trail record (just an amount of bike trail miles recorded at a given date).
 */

$add_bike_miles = "INSERT INTO Bike_Trails (Miles_Bike_Lanes, Date) VALUES
                    ('" . $_POST['miles'] ."',
                     '" . $_POST['date'] . "')";
echo $add_bike_miles;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $add_bike_miles);
include "../include/dbconnclose.php";
?>
