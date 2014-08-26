<?php
/* edit campaigns or programs (only names and categories): */
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['name']);
$id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);
$type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['type']);
$issue_type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue_type']);
$edit_program = "UPDATE Subcategories SET
            Subcategory_Name = '" . $name_sqlsafe . "'
                WHERE Subcategory_ID='" . $id_sqlsafe . "'";
$add_category = "INSERT INTO Category_Subcategory_Links (Category_ID, Subcategory_ID, Campaign_or_Program)
                VALUES 
                ('" . $type_sqlsafe . "',
                 '" . $id_sqlsafe ."'),
				 '" . $issue_type_sqlsafe . "'";
echo $edit_program;
echo $add_category;
mysqli_query($cnnLSNA, $edit_program);
mysqli_query($cnnLSNA, $add_category);
include "../include/dbconnclose.php";
?>