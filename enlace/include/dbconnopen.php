<?php
/* development version:*/
$cnnEnlace = mysqli_connect("DEV_SERVER", "DEV_ENLACE_DB_USER", "DEV_ENLACE_DB_PASS", "DEV_ENLACE_DB")
	or die ("Error Connecting To The Database Because: " . mysqli_connect_error());


/*production version:

$cnnEnlace = mysqli_connect("PROD_SERVER", "PROD_ENLACE_DB_USER", "PROD_ENLACE_DB_PASS", "PROD_ENLACE_DB")
	or die ("Error Connecting To The Database Because: " . mysqli_connect_error());
*/
?>
