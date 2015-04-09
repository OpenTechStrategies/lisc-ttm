<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

/*
 * Add new bike trail record (just an amount of bike trail miles recorded at a given date).
 */
include "../include/dbconnopen.php";
$miles_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['miles']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$add_bike_miles_sqlsafe = "INSERT INTO Bike_Trails (Miles_Bike_Lanes, Date) VALUES
                    ('" . $miles_sqlsafe ."',
                     '" . $date_sqlsafe . "')";
echo $add_bike_miles_sqlsafe;
mysqli_query($cnnBickerdike, $add_bike_miles_sqlsafe);
include "../include/dbconnclose.php";
?>
