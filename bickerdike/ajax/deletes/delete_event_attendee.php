<?php


$remove_attendee= "DELETE FROM Activities_Users WHERE
                            User_Established_Activity_ID='". $_POST['event_id']."'
                                AND
                            User_ID='". $_POST['user_id']."'";
echo $remove_attendee;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $remove_attendee);
include "../include/dbconnclose.php";

?>
