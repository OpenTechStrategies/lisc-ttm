<?php
$delete_user_query = "DELETE FROM Programs WHERE Program_ID='" . $_POST['program_id'] . "'";
echo $delete_user_query;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $delete_user_query);
include "../include/dbconnclose.php";


?>
