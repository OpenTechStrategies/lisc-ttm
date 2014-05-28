<?php
$edit_event_query = "UPDATE User_Established_Activities SET 
                            Activity_Name='" . $_POST['name'] . "',
                            Activity_Date='" . $_POST['date'] . "',
                            Activity_Type='" . $_POST['type'] . "',
                            Notes='" . $_POST['note'] . "',
                            Activity_Org='" . $_POST['org'] ."'
                            WHERE User_Established_Activities_ID='" . $_POST['event_id'] . "'";
echo $edit_event_query;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $edit_event_query);
include "../include/dbconnclose.php";


?>
