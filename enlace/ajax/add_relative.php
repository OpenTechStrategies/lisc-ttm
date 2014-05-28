<?php
/*add a child-parent connection */
$add_relative = "INSERT INTO Child_Parent (Parent_ID, Child_ID)
    VALUES ('" . $_POST['parent'] . "', '" . $_POST['child'] . "')";
echo $add_relative;
include "../include/dbconnopen.php";
mysqli_query($cnnEnlace, $add_relative);
include "../include/dbconnclose.php";
?>
