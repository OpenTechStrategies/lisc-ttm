<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

/* change event goal/actual attendance and/or date. */

$date_formatted = explode('/', $_POST['date']);
include "../include/dbconnopen.php";
$save_date_sqlsafe = mysqli_real_escape_string($cnnTRP, $date_formatted[2]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[0]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[1]);

$edit_event_sqlsafe="UPDATE Events SET
                    Event_Goal='" . mysqli_real_escape_string($cnnTRP, $_POST['goal']) ."',
                    Event_Actual='" . mysqli_real_escape_string($cnnTRP, $_POST['actual']) ."',
                    Event_Date='" . $save_date_sqlsafe ."'
                        
                        WHERE Event_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
echo $edit_event_sqlsafe;
mysqli_query($cnnTRP, $edit_event_sqlsafe);
$id=mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>
