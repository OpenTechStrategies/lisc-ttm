<?php
include "../include/dbconnopen.php";
$event_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['event_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user_id']);
$remove_attendee= "DELETE FROM Activities_Users WHERE
                            User_Established_Activity_ID='". $event_id_sqlsafe."'
                                AND
                            User_ID='". $user_id_sqlsafe."'";
echo $remove_attendee;
mysqli_query($cnnBickerdike, $remove_attendee);
include "../include/dbconnclose.php";

?>
