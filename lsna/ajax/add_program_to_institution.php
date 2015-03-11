<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/* link institution to campaign or program */
include "../include/dbconnopen.php";
$inst_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['inst']);
$program_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['program']);
$link_query = "INSERT INTO Institutions_Subcategories (Institution_ID, Subcategory_ID)
    VALUES('" . $inst_sqlsafe . "', '" . $program_sqlsafe . "')";
//echo $link_query;
mysqli_query($cnnLSNA, $link_query);
include "../include/dbconnclose.php";

?>
