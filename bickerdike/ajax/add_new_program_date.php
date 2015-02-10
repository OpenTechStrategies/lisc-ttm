<?php
/*
 * Add new program date (attendance for this date is added separately).
 */

include "../include/datepicker.php";
include "../include/dbconnopen.php";
$program_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program_id']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$add_date_to_program_sqlsafe = "INSERT INTO Program_Dates (
                            Program_ID,
                            Program_Date) VALUES (
                            '". $program_id_sqlsafe."',
                            '". $date_sqlsafe."'
                            )";
echo $add_date_to_program_sqlsafe;
mysqli_query($cnnBickerdike, $add_date_to_program_sqlsafe);
include "../include/dbconnclose.php";
?>
