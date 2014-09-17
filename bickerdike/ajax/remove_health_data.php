<?php

/*
 * Delete user health data (one set of height/weight/bmi).  Usually in the case of data entry error.
 */
include "../include/dbconnopen.php";
$id_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['id']);
$delete_health_data_query_sqlsafe = "DELETE FROM User_Health_Data WHERE User_Health_Data_ID='" . $id_sqlsafe . "'";
mysqli_query($cnnBickerdike, $delete_health_data_query_sqlsafe);
include "../include/dbconnclose.php";


?>
