<?php
/*new program survey*/

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
    VALUES ('".$_POST['program']."',
    '".$_POST['1']."',
        '".$_POST['2']."',
        '".$_POST['3']."',
        '".$_POST['4']."',
        '".$_POST['5']."',
        '".$_POST['6']."',
        '".$_POST['7']."',
        '".$_POST['8']."',
        '".$_POST['9']."',
        '".$_POST['10']."',
        '".$_POST['11']."',
        '".$_POST['12']."',
        '".$_POST['13']."',
        '".$_POST['14']."',
        '".$_POST['15']."',
        '".$_POST['16']."',
        '".$_POST['session']."')";
//echo $new_survey;
    include "../include/dbconnopen.php";
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