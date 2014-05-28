<?php

//development
$cnnBickerdike = mysqli_connect("DEV_SERVER", "DEV_BICKERDIKE_DB_USER", "DEV_BICKERDIKE_DB_PASS", "DEV_BICKERDIKE_DB")
	or die ("Error Connecting To The Database Because: " . mysqli_connect_error());

/*
//production
$cnnBickerdike = mysqli_connect("PROD_SERVER", "PROD_BICKERDIKE_DB_USER", "PROD_BICKERDIKE_DB_PASS", "PROD_BICKERDIKE_DB")
	or die ("Error Connecting To The Database Because: " . mysqli_connect_error());
*/
?>
