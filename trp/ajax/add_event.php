<?php
/* Create a new event, either linked to a campaign or not. */

$date_formatted = explode('/', $_POST['date']);
include "../include/dbconnopen.php";
$save_date_sqlsafe = mysqli_real_escape_string($cnnTRP, $date_formatted[2]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[0]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[1]);
$make_event_sqlsafe="INSERT INTO Events (
                    Event_Name,
                    Event_Goal,
                    Event_Date,
                    Active) VALUES(
                    '" . mysqli_real_escape_string($cnnTRP, $_POST['name']) ."',
                    '" . mysqli_real_escape_string($cnnTRP, $_POST['goal']) ."',
                    '" . $save_date_sqlsafe ."',
                        1
                    )";
mysqli_query($cnnTRP, $make_event_sqlsafe);
$id=mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>
<span style="color:#990000; font-weight:bold;">Thank you for adding  <?echo $_POST['name'];?> to the database.</span><br/>
