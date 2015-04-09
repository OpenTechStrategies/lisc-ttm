<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $AdminAccess);

/*
 * Deletes a date from a program.  Presumably the attendance is left intact, but with nowhere
 * to be displayed.  Problematic that the attendance isn't deleted, though, for export purposes.
 */
include "../include/dbconnopen.php";
$program_date_id_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['program_date_id']);
$remove_date_sqlsafe = "DELETE FROM Program_Dates WHERE
                            Program_Date_ID='". $program_date_id_sqlsafe."'";
echo $remove_date_sqlsafe;
mysqli_query($cnnBickerdike, $remove_date_sqlsafe);
include "../include/dbconnclose.php";

?>
