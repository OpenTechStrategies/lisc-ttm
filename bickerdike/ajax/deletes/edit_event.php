<?php
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['name']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$org_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['org']);
$note_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['note']);
$type_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$event_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['event_id']);
$edit_event_query = "UPDATE User_Established_Activities SET 
                            Activity_Name='" . $name_sqlsafe . "',
                            Activity_Date='" . $date_sqlsafe . "',
                            Activity_Type='" . $type_sqlsafe . "',
                            Notes='" . $note_sqlsafe . "',
                            Activity_Org='" . $org_sqlsafe ."'
                            WHERE User_Established_Activities_ID='" . $event_id_sqlsafe . "'";
echo $edit_event_query;
mysqli_query($cnnBickerdike, $edit_event_query);
include "../include/dbconnclose.php";


?>
