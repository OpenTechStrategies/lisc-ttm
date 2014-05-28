<?php
/* Add attendance. */
$add_attendee_to_date = "INSERT INTO Subcategory_Attendance (
                            Subcategory_Date,
                            Participant_ID) VALUES (
                            '". $_POST['program_date_id']."',
                            '". $_POST['user_id']."'
                            )";
echo $add_attendee_to_date;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $add_attendee_to_date);
include "../include/dbconnclose.php";

?>
