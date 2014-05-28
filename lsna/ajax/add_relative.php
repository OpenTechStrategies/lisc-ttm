<?php

if (isset($_POST['parent'])){
/*add parent-child link between two people who are already in the database. */

$add_relative = "INSERT INTO Parent_Mentor_Children (Parent_ID, Child_ID)
    VALUES ('" . $_POST['parent'] . "', '" . $_POST['child'] . "')";
}
else{
    $add_relative = "INSERT INTO Parent_Mentor_Children (Parent_ID, Spouse_ID) VALUES ('" . $_POST['person'] . "', '" . $_POST['spouse'] . "')";
}
echo $add_relative;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $add_relative);
include "../include/dbconnclose.php";

?>
