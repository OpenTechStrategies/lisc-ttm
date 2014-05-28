<?php
/* development connection*/
$cnnSWOP = mysqli_connect("DEV_SERVER", "DEV_SWOP_DB_USER", "DEV_SWOP_DB_PASS", "DEV_SWOP_DB")
	or die ("Error Connecting To The Database Because: " . mysqli_connect_error());


/*production connection
$cnnSWOP = mysqli_connect("PROD_SERVER", "PROD_SWOP_DB_USER", "PROD_SWOP_DB_PASS", "PROD_SWOP_DB")
	or die ("Error Connecting To The Database Because: " . mysqli_connect_error());
*/
?>