<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);


/*
 * Change program name, org, or type.
 */
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['name']);
$org_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['org']);
$type_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['id']);
$edit_program_sqlsafe = "UPDATE Programs SET
            Program_Name = '" . $name_sqlsafe . "',
            Program_Organization = '" . $org_sqlsafe . "',
            Program_Type = '" . $type_sqlsafe . "'
                WHERE Program_ID='" . $id_sqlsafe . "'";
mysqli_query($cnnBickerdike, $edit_program_sqlsafe);
include "../include/dbconnclose.php";
?>
