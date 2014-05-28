<?php
/* delete attendance from program or campaign. */

$remove_attendee_from_date = "DELETE FROM Subcategory_Attendance WHERE
                            Subcategory_Date='". $_POST['program_date_id']."'
                                AND
                            Participant_ID='". $_POST['user_id']."'";
echo $remove_attendee_from_date;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $remove_attendee_from_date);
include "../include/dbconnclose.php";

?>
