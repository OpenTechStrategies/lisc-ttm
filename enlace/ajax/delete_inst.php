<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, $AdminAccess);


/*delete institution.  doesn't remove links to people or campaigns, but those aren't
 * crucial for anything.
 */
	include "../include/dbconnopen.php";
        $inst_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['inst']);
	$delete_inst = "DELETE FROM Institutions WHERE Inst_ID='".$inst_sqlsafe."'";
	mysqli_query($cnnEnlace, $delete_inst);
	include "../include/dbconnclose.php";
?>