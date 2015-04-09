<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

/*
 * When a program is created, looks for already existing programs with an identical name.
 * If none exists, the new program can be created as is.  If one or more do exist, the 
 * system user is warned about the duplication.  They still have the option to 
 * create a duplicate program if they really want to.
 */
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['name']);
$get_duplicate_programs_sqlsafe = "SELECT COUNT(Program_ID) FROM Programs WHERE Program_Name='" . $name_sqlsafe . "'";
$is_duplicate = mysqli_query($cnnBickerdike, $get_duplicate_programs_sqlsafe);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'A program named ' .  $name_sqlsafe . ' is already in the database.  Are you sure you want to enter this program?';
}
include "../include/dbconnclose.php";

?>
