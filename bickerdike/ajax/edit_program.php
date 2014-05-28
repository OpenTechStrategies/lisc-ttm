<?php

/*
 * Change program name, org, or type.
 */

$edit_program = "UPDATE Programs SET
            Program_Name = '" . $_POST['name'] . "',
            Program_Organization = '" . $_POST['org'] . "',
            Program_Type = '" . $_POST['type'] . "'
                WHERE Program_ID='" . $_POST['id'] . "'";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $edit_program);
include "../include/dbconnclose.php";
?>
