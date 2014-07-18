<?php

/*Checks so that a person doesn't have two pre surveys for the same program (for example).
 */

/*First checks whether the survey is pre, post, or later.*/
if ($_POST['type']==1){
    $type='Pre';
}
elseif ($_POST['type']==2){
    $type='Post';
}
elseif ($_POST['type']==3){
    $type='3 months later';
}

/*then gets the user so that it can use his/her name in the response.*/

include "../classes/user.php";
$user = new User();
$user->load_with_user_id($_POST['user']);

/*then gets the program so that it can use its name in the response.*/

include "../classes/program.php";
$program = new Program();
$program->load_with_program_id($_POST['program']);

/*finds surveys that match type, user, and program (if any)*/

include "../include/dbconnopen.php";
$user_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user']);
$program_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['program']);
$type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$check_duplicate_sqlsafe = "SELECT COUNT(Participant_Survey_ID) FROM Participant_Survey_Responses WHERE User_ID='" . $user_sqlsafe . "'
    AND Program_ID='" . $program_sqlsafe . "' AND Pre_Post_Late='" . $type_sqlsafe . "'";
$is_duplicate = mysqli_query($cnnBickerdike, $check_duplicate_sqlsafe);
$duplicate = mysqli_fetch_row($is_duplicate);

/*if surveys exist that meet those conditions, issue a warning:*/

if ($duplicate[0]>0){
    echo 'A ' . $type_sqlsafe . ' survey for ' . $user->full_name . ' in program ' . $program->program_name . ' already exists. 
        Are you sure you want to enter this survey?';
}
include "../include/dbconnclose.php";
?>
