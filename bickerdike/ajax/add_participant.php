<?php
/*
 * Add new participant to a program.
 */

include "../include/dbconnopen.php";
$program_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program_id']);
$user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $user_id_sqlsafe);
$add_participant_to_program = "INSERT INTO Programs_Users (
                                Program_ID,
                                User_ID) VALUES (
                                '" . $program_id_sqlsafe."',
                                '" . $user_id_sqlsafe ."'
                                )";
mysqli_query($cnnBickerdike, $add_participant_to_program);
include "../include/dbconnclose.php";

/*
 * Create response -- get the newly added participant's name so that it will show up on the program profile 
 * in a "Thank you for adding ____" space.
 */

$get_participant_name = "SELECT First_Name, Last_Name FROM Users WHERE User_ID='" . $user_id_sqlsafe . "'";
include "../include/dbconnopen.php";
$participant = mysqli_query($cnnBickerdike, $get_participant_name);
include "../include/dbconnclose.php";
while ($name = mysqli_fetch_row($participant)){
    echo $name[0] . " " . $name[1];
}
?>
