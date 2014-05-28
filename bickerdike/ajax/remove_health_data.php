<?php

/*
 * Delete user health data (one set of height/weight/bmi).  Usually in the case of data entry error.
 */

$delete_health_data_query = "DELETE FROM User_Health_Data WHERE User_Health_Data_ID='" . $_POST['id'] . "'";
echo $delete_health_data_query;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $delete_health_data_query);
include "../include/dbconnclose.php";


?>
