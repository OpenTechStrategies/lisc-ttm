<?php
/*
 * When a program is created, looks for already existing programs with an identical name.
 * If none exists, the new program can be created as is.  If one or more do exist, the 
 * system user is warned about the duplication.  They still have the option to 
 * create a duplicate program if they really want to.
 */
$get_duplicate_programs = "SELECT COUNT(Program_ID) FROM Programs WHERE Program_Name='" . $_POST['name'] . "'";
//echo $get_duplicate_programs;
include "../include/dbconnopen.php";
$is_duplicate = mysqli_query($cnnBickerdike, $get_duplicate_programs);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'A program named ' .  $_POST['name'] . ' is already in the database.  Are you sure you want to enter this program?';
}
include "../include/dbconnclose.php";

?>
