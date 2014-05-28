<?php
$delete_user_query = "DELETE FROM User_Established_Activities WHERE User_Established_Activities_ID='" . $_POST['program_id'] . "'";
echo $delete_user_query;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $delete_user_query);
include "../include/dbconnclose.php";


?>
