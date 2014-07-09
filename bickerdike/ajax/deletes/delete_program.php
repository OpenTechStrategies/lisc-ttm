<?php
include "../include/dbconnopen.php";
$program_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program_id']);
$delete_user_query = "DELETE FROM Programs WHERE Program_ID='" . $program_id_sqlsafe . "'";
echo $delete_user_query;
mysqli_query($cnnBickerdike, $delete_user_query);
include "../include/dbconnclose.php";


?>
