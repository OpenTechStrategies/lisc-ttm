<?php
/* add a new date to a program (for attendance purposes) */
if ($_POST['action']=='new_date'){
include "../include/dbconnopen.php";
$format_date = explode('/', $_POST['date']);
$date_formatted_sqlsafe = mysqli_real_escape_string($cnnTRP, $format_date[2]) . '-' . mysqli_real_escape_string($cnnTRP, $format_date[0]) . '-' . mysqli_real_escape_string($cnnTRP, $format_date[1]);
$date_query_sqlsafe="INSERT INTO Program_Dates (Date, Program_ID) VALUES ('".$date_formatted_sqlsafe."', '" . mysqli_real_escape_string($cnnTRP, $_POST['program']) . "')";
mysqli_query($cnnTRP, $date_query_sqlsafe);
include "../include/dbconnclose.php";
}
/* add an attendee to a program date: */
elseif ($_POST['action']=='attendance'){
    include "../include/dbconnopen.php";
    $attendance_query_sqlsafe="INSERT INTO Program_Attendance (Date_ID, Participant_ID) VALUES (
        '" . mysqli_real_escape_string($cnnTRP, $_POST['date']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "')";
    echo $attendance_query_sqlsafe;
    mysqli_query($cnnTRP, $attendance_query_sqlsafe);
    include "../include/dbconnclose.php";
}
/* add a note to this program.  Not sure why this is in this file. */
elseif($_POST['action']=='note_text'){
    include "../include/dbconnopen.php";
    $create_note_sqlsafe="INSERT INTO Blog_Notes (Author, Note_Text, Program_ID, School) VALUES ('" . mysqli_real_escape_string($cnnTRP, $_COOKIE['user']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['note']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['program']) . "',
        '" . mysqli_real_escape_string($cnnTRP, $_POST['school']) . "')";
    echo $create_note_sqlsafe;
    mysqli_query($cnnTRP, $create_note_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
