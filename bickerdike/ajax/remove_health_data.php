<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $AdminAccess);


/*
 * Delete user health data (one set of height/weight/bmi).  Usually in the case of data entry error.
 */
include "../include/dbconnopen.php";
$id_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['id']);
$delete_health_data_query_sqlsafe = "DELETE FROM User_Health_Data WHERE User_Health_Data_ID='" . $id_sqlsafe . "'";
echo $delete_health_data_query_sqlsafe;
mysqli_query($cnnBickerdike, $delete_health_data_query_sqlsafe);
include "../include/dbconnclose.php";


?>
