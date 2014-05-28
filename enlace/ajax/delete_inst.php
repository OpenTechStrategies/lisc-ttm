<?
/*delete institution.  doesn't remove links to people or campaigns, but those aren't
 * crucial for anything.
 */
	$delete_inst = "DELETE FROM Institutions WHERE Inst_ID='".$_POST['inst']."'";
	include "../include/dbconnopen.php";
	mysqli_query($cnnEnlace, $delete_inst);
	include "../include/dbconnclose.php";
?>