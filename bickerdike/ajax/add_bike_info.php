<?php
/*
 * Add new bike trail record (just an amount of bike trail miles recorded at a given date).
 */
$miles_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['miles']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$add_bike_miles = "INSERT INTO Bike_Trails (Miles_Bike_Lanes, Date) VALUES
                    ('" . $miles_sqlsafe ."',
                     '" . $date_sqlsafe . "')";
echo $add_bike_miles;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $add_bike_miles);
include "../include/dbconnclose.php";
?>
