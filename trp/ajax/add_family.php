<?php
require_once("../siteconfig.php");
?>
<?
/* Add a link between a parent and child, from the participant profile. */


	include "../include/dbconnopen.php";
	$add_family_sqlsafe = "
		INSERT INTO Parents_Children (
			Parent_ID,
			Child_ID
		) VALUES (
			'" . mysqli_real_escape_string($cnnTRP, $_POST['parent_id']) . "',
			'" . mysqli_real_escape_string($cnnTRP, $_POST['child_id']) . "'
		)";
	mysqli_query($cnnTRP, $add_family_sqlsafe);
	include "../dbconnclose.php";
?>
