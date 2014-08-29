<?php
include "../include/dbconnopen.php";
$program_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program_id']);
$delete_user_query_sqlsafe = "DELETE FROM User_Established_Activities WHERE User_Established_Activities_ID='" . $program_id_sqlsafe . "'";
echo $delete_user_query_sqlsafe;
mysqli_query($cnnBickerdike, $delete_user_query_sqlsafe);
include "../include/dbconnclose.php";


?>
