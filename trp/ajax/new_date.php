<?php
/* add a new date to a program (for attendance purposes) */
if ($_POST['action']=='new_date'){
$format_date = explode('/', $_POST['date']);
$date_formatted = $format_date[2].'-'.$format_date[0].'-'.$format_date[1];
$date_query="INSERT INTO Program_Dates (Date, Program_ID) VALUES ('".$date_formatted."', '".$_POST['program']."')";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $date_query);
include "../include/dbconnclose.php";
}
/* add an attendee to a program date: */
elseif ($_POST['action']=='attendance'){
    $attendance_query="INSERT INTO Program_Attendance (Date_ID, Participant_ID) VALUES (
        '".$_POST['date']."', '".$_POST['person']."')";
    echo $attendance_query;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $attendance_query);
    include "../include/dbconnclose.php";
}
/* add a note to this program.  Not sure why this is in this file. */
elseif($_POST['action']=='note_text'){
    $create_note="INSERT INTO Blog_Notes (Author, Note_Text, Program_ID, School) VALUES ('".$_COOKIE['user']."', '".$_POST['note']."', '".$_POST['program']."',
        '".$_POST['school']."')";
    echo $create_note;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $create_note);
    include "../include/dbconnclose.php";
}
?>
