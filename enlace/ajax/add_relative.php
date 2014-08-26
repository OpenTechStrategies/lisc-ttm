<?php
/*add a child-parent connection */
include "../include/dbconnopen.php";
$parent_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['parent']);
$child_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['child']);
$add_relative = "INSERT INTO Child_Parent (Parent_ID, Child_ID)
    VALUES ('" . $parent_sqlsafe . "', '" . $child_sqlsafe . "')";
echo $add_relative;
mysqli_query($cnnEnlace, $add_relative);
include "../include/dbconnclose.php";
?>
