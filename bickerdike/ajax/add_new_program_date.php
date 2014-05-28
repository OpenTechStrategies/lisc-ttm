<?php
/*
 * Add new program date (attendance for this date is added separately).
 */

include "../include/datepicker.php";
$add_date_to_program = "INSERT INTO Program_Dates (
                            Program_ID,
                            Program_Date) VALUES (
                            '". $_POST['program_id']."',
                            '". $_POST['date']."'
                            )";
echo $add_date_to_program;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $add_date_to_program);
include "../include/dbconnclose.php";
?>
