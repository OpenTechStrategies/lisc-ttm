<?php
/* change event goal/actual attendance and/or date. */

$date_formatted = explode('/', $_POST['date']);
$save_date = $date_formatted[2]."-".$date_formatted[0]."-".$date_formatted[1];

$edit_event="UPDATE Events SET
                    Event_Goal='" . $_POST['goal'] ."',
                    Event_Actual='" . $_POST['actual'] ."',
                    Event_Date='" . $save_date ."'
                        
                        WHERE Event_ID='" . $_POST['id'] . "'";
echo $edit_event;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $edit_event);
$id=mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>
