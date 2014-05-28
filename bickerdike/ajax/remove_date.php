<?php
/*
 * Deletes a date from a program.  Presumably the attendance is left intact, but with nowhere
 * to be displayed.  Problematic that the attendance isn't deleted, though, for export purposes.
 */
$remove_date = "DELETE FROM Program_Dates WHERE
                            Program_Date_ID='". $_POST['program_date_id']."'";
echo $remove_date;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $remove_date);
include "../include/dbconnclose.php";

?>
