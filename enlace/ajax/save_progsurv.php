<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, 2);

/*new program survey*/

include "../include/dbconnopen.php";
$program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program']);
$_1_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['1']);
$_2_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['2']);
$_3_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['3']);
$_4_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['4']);
$_5_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['5']);
$_6_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['6']);
$_7_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['7']);
$_8_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['8']);
$_9_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['9']);
$_10_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['10']);
$_11_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['11']);
$_12_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['12']);
$_13_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['13']);
$_14_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['14']);
$_15_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['15']);
$_16_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['16']);
$session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['session']);

$new_survey="INSERT INTO Program_Surveys (Program_ID, Question_1,
    Question_2,
    Question_3,
    Question_4,
    Question_5,
    Question_6,
    Question_7,
    Question_8,
    Question_9,
    Question_10,
    Question_11,
    Question_12,
    Question_13,
    Question_14,
    Question_15,
    Question_16,
        Session_ID)
    VALUES ('".$program_sqlsafe."',
    '".$_1_sqlsafe."',
        '".$_2_sqlsafe."',
        '".$_3_sqlsafe."',
        '".$_4_sqlsafe."',
        '".$_5_sqlsafe."',
        '".$_6_sqlsafe."',
        '".$_7_sqlsafe."',
        '".$_8_sqlsafe."',
        '".$_9_sqlsafe."',
        '".$_10_sqlsafe."',
        '".$_11_sqlsafe."',
        '".$_12_sqlsafe."',
        '".$_13_sqlsafe."',
        '".$_14_sqlsafe."',
        '".$_15_sqlsafe."',
        '".$_16_sqlsafe."',
        '".$session_sqlsafe."')";
//echo $new_survey;
    mysqli_query($cnnEnlace, $new_survey);
    include "../include/dbconnclose.php";
?>
Thank you for entering this survey. 
    <a href='javascript:;' onclick="$.post(
                '../ajax/set_program_id.php',
                {
                    page: 'profile',
                    id: '<?echo $_POST['program'];?>'
                },
                function (response){
                    window.location='profile.php';
                }
            )">Click here to return to program profile.</a>