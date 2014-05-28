<?php
/* link institution to campaign or program */
$link_query = "INSERT INTO Institutions_Subcategories (Institution_ID, Subcategory_ID)
    VALUES('" . $_POST['inst'] . "', '" . $_POST['program'] . "')";
//echo $link_query;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $link_query);
include "../include/dbconnclose.php";

?>
