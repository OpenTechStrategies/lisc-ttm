<?
/* Add a link between a parent and child, from the participant profile. */


	$add_family = "
		INSERT INTO Parents_Children (
			Parent_ID,
			Child_ID
		) VALUES (
			'" . $_POST['parent_id'] . "',
			'" . $_POST['child_id'] . "'
		)";
	include "../include/dbconnopen.php";
	mysqli_query($cnnTRP, $add_family);
	include "../dbconnclose.php";
?>
