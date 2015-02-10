<?php
include "../include/dbconnopen.php";
$parent_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['parent']);
$child_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['child']);
$person_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['person']);
$spouse_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['spouse']);

if (isset($_POST['parent'])){
/*add parent-child link between two people who are already in the database. */

$add_relative = "INSERT INTO Parent_Mentor_Children (Parent_ID, Child_ID)
    VALUES ('" . $parent_sqlsafe . "', '" . $child_sqlsafe . "')";
}
else{
    $add_relative = "INSERT INTO Parent_Mentor_Children (Parent_ID, Spouse_ID) VALUES ('" . $person_sqlsafe . "', '" . $spouse_sqlsafe . "')";
}
echo $add_relative;
mysqli_query($cnnLSNA, $add_relative);
include "../include/dbconnclose.php";

?>
