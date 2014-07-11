<?
/* Add a link between a parent and child, from the participant profile. */


	$add_family_sqlsafe = "
		INSERT INTO Parents_Children (
			Parent_ID,
			Child_ID
		) VALUES (
			'" . mysqli_real_escape_string($_POST['parent_id']) . "',
			'" . mysqli_real_escape_string($_POST['child_id']) . "'
		)";
	include "../include/dbconnopen.php";
	mysqli_query($cnnTRP, $add_family_sqlsafe);
	include "../dbconnclose.php";
?>
