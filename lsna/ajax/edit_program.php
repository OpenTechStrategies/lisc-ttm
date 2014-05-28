<?php
/* edit campaigns or programs (only names and categories): */
$edit_program = "UPDATE Subcategories SET
            Subcategory_Name = '" . $_POST['name'] . "'
                WHERE Subcategory_ID='" . $_POST['id'] . "'";
$add_category = "INSERT INTO Category_Subcategory_Links (Category_ID, Subcategory_ID, Campaign_or_Program)
                VALUES 
                ('" . $_POST['type'] . "',
                 '" . $_POST['id'] ."'),
				 '" . $_POST['issue_type'] . "'";
echo $edit_program;
echo $add_category;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $edit_program);
mysqli_query($cnnLSNA, $add_category);
include "../include/dbconnclose.php";
?>