<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

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
mysqli_query($cnnLSNA, $edit_program);
mysqli_query($cnnLSNA, $add_category);
include "../include/dbconnclose.php";
?>
