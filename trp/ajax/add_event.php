<?php
/* Create a new event, either linked to a campaign or not. */

$date_formatted = explode('/', $_POST['date']);
$save_date = $date_formatted[2]."-".$date_formatted[0]."-".$date_formatted[1];
$make_event="INSERT INTO Events (
                    Event_Name,
                    Event_Goal,
                    Event_Date,
                    Active) VALUES(
                    '" . $_POST['name'] ."',
                    '" . $_POST['goal'] ."',
                    '" . $save_date ."',
                        1
                    )";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $make_event);
$id=mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>
<span style="color:#990000; font-weight:bold;">Thank you for adding  <?echo $_POST['name'];?> to the database.</span><br/>
