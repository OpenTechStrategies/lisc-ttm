<?php
/*development*/
$cnnLSNA = mysqli_connect("DEV_SERVER", "DEV_LSNA_DB_USER", "DEV_LSNA_DB_PASS", "DEV_LSNA_DB")
	or die ("Error Connecting To The Database Because: " . mysqli_connect_error());

/*production*/
//$cnnLSNA = mysqli_connect("PROD_SERVER", "PROD_LSNA_DB_USER", "PROD_LSNA_DB_PASS", "PROD_LSNA_DB")
//	or die ("Error Connecting To The Database Because: " . mysqli_connect_error());



?>
