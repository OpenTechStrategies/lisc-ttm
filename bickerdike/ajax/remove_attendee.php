<?php
/*
 * Remove a person from a specific date of a program.  The person will still
 * be a program participant, but they will not have attended this date.
 */

$remove_attendee_from_date = "DELETE FROM Program_Dates_Users WHERE
                            Program_Date_ID='". $_POST['program_date_id']."'
                                AND
                            User_ID='". $_POST['user_id']."'";
echo $remove_attendee_from_date;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $remove_attendee_from_date);
include "../include/dbconnclose.php";

?>
