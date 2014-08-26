<?php

/*
 * Change program name, org, or type.
 */
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['name']);
$org_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['org']);
$type_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['id']);
$edit_program = "UPDATE Programs SET
            Program_Name = '" . $name_sqlsafe . "',
            Program_Organization = '" . $org_sqlsafe . "',
            Program_Type = '" . $type_sqlsafe . "'
                WHERE Program_ID='" . $id_sqlsafe . "'";
mysqli_query($cnnBickerdike, $edit_program);
include "../include/dbconnclose.php";
?>
