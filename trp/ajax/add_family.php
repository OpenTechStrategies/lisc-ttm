<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

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
