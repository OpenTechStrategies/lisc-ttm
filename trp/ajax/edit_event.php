<?php
/* change event goal/actual attendance and/or date. */

$date_formatted = explode('/', $_POST['date']);
$save_date_sqlsafe = mysqli_real_escape_string($date_formatted[2]) . "-" . mysqli_real_escape_string($date_formatted[0]) . "-" . mysqli_real_escape_string($date_formatted[1]);

$edit_event_sqlsafe="UPDATE Events SET
                    Event_Goal='" . mysqli_real_escape_string($_POST['goal']) ."',
                    Event_Actual='" . mysqli_real_escape_string($_POST['actual']) ."',
                    Event_Date='" . $save_date_sqlsafe ."'
                        
                        WHERE Event_ID='" . mysqli_real_escape_string($_POST['id']) . "'";
echo $edit_event_sqlsafe;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $edit_event_sqlsafe);
$id=mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>
