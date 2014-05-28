<?php
/* Save gold scores, which are administered three times.  The reformat_dates below refer
 * to those survey dates. */

$reformat_date1_a=explode('/', $_POST['date1_a']);
//print_r($reformat_date1_a);
if ($reformat_date1_a[1]){
$date1_a=$reformat_date1_a[2] . '-' . $reformat_date1_a[0] . '-' . $reformat_date1_a[1];}
else{$date1_a=$_POST['date1_a'];}
$reformat_date1_b=explode('/', $_POST['date1_b']);
//print_r($reformat_date1_b);
if ($reformat_date1_b[1]){
$date1_b=$reformat_date1_b[2] . '-' . $reformat_date1_b[0] . '-' . $reformat_date1_b[1];}
else{$date1_b=$_POST['date1_b'];}
$reformat_date1_c=explode('/', $_POST['date1_c']);
//print_r($reformat_date1_c);
if ($reformat_date1_c[1]){
$date1_c=$reformat_date1_c[2] . '-' . $reformat_date1_c[0] . '-' . $reformat_date1_c[1];}
else{$date1_c=$_POST['date1_c'];}

$reformat_date2_a=explode('/', $_POST['date2_a']);
if ($reformat_date2_a[1]){
$date2_a=$reformat_date2_a[2] . '-' . $reformat_date2_a[0] . '-' . $reformat_date2_a[1];}
else{$date2_a=$_POST['date2_a'];}
$reformat_date2_b=explode('/', $_POST['date2_b']);
if ($reformat_date2_b[1]){
$date2_b=$reformat_date2_b[2] . '-' . $reformat_date2_b[0] . '-' . $reformat_date2_b[1];}
else{$date2_b=$_POST['date2_b'];}
$reformat_date2_c=explode('/', $_POST['date2_c']);
if ($reformat_date2_c[1]){
$date2_c=$reformat_date2_c[2] . '-' . $reformat_date2_c[0] . '-' . $reformat_date2_c[1];}
else{$date2_c=$_POST['date2_c'];}

$reformat_date3_a=explode('/', $_POST['date3_a']);
if ($reformat_date3_a[1]){
$date3_a=$reformat_date3_a[2] . '-' . $reformat_date3_a[0] . '-' . $reformat_date3_a[1];}
else{$date3_a=$_POST['date3_a'];}
$reformat_date3_b=explode('/', $_POST['date3_b']);
if ($reformat_date3_b[1]){
$date3_b=$reformat_date3_b[2] . '-' . $reformat_date3_b[0] . '-' . $reformat_date3_b[1];}
else{$date3_b=$_POST['date3_b'];}
$reformat_date3_c=explode('/', $_POST['date3_c']);
if ($reformat_date3_c[1]){
$date3_c=$reformat_date3_c[2] . '-' . $reformat_date3_c[0] . '-' . $reformat_date3_c[1];}
else{$date3_c=$_POST['date3_c'];}

/* I'm going to change the saving so that it updates on duplicate person, year, and test edition (pre, mid, or post) */

$get_existing_1_a="SELECT * FROM Gold_Score_Totals WHERE Participant='".$_POST['person']."' AND Year=1 AND Test_Time=1";
echo $get_existing_1_a;
include "../include/dbconnopen.php";
$exists_1a=mysqli_query($cnnTRP, $get_existing_1_a);
$numrows_1a=  mysqli_num_rows($exists_1a);
if ($numrows_1a>0){    $update_1a=1;}
else{    $update_1a=0;}
include "../include/dbconnclose.php";
$get_existing_1_b="SELECT * FROM Gold_Score_Totals WHERE Participant='".$_POST['person']."' AND Year=1 AND Test_Time=2";
include "../include/dbconnopen.php";
$exists_1b=mysqli_query($cnnTRP, $get_existing_1_b);
$numrows_1b=  mysqli_num_rows($exists_1b);
if ($numrows_1b>0){    $update_1b=1;}
else{    $update_1b=0;}
include "../include/dbconnclose.php";
$get_existing_1_c="SELECT * FROM Gold_Score_Totals WHERE Participant='".$_POST['person']."' AND Year=1 AND Test_Time=3";
include "../include/dbconnopen.php";
$exists_1c=mysqli_query($cnnTRP, $get_existing_1_c);
$numrows_1c=  mysqli_num_rows($exists_1c);
if ($numrows_1c>0){    $update_1c=1;}
else{    $update_1c=0;}
include "../include/dbconnclose.php";

$get_existing_2_a="SELECT * FROM Gold_Score_Totals WHERE Participant='".$_POST['person']."' AND Year=2 AND Test_Time=1";
include "../include/dbconnopen.php";
$exists_2a=mysqli_query($cnnTRP, $get_existing_2_a);
$numrows_2a=  mysqli_num_rows($exists_2a);
if ($numrows_2a>0){    $update_2a=1;}
else{    $update_2a=0;}
include "../include/dbconnclose.php";
$get_existing_2_b="SELECT * FROM Gold_Score_Totals WHERE Participant='".$_POST['person']."' AND Year=2 AND Test_Time=2";
include "../include/dbconnopen.php";
$exists_2b=mysqli_query($cnnTRP, $get_existing_2_b);
$numrows_2b=  mysqli_num_rows($exists_2b);
if ($numrows_2b>0){    $update_2b=1;}
else{    $update_2b=0;}
include "../include/dbconnclose.php";
$get_existing_2_c="SELECT * FROM Gold_Score_Totals WHERE Participant='".$_POST['person']."' AND Year=2 AND Test_Time=3";
include "../include/dbconnopen.php";
$exists_2c=mysqli_query($cnnTRP, $get_existing_2_c);
$numrows_2c=  mysqli_num_rows($exists_2c);
if ($numrows_2c>0){    $update_2c=1;}
else{    $update_2c=0;}
include "../include/dbconnclose.php";


$get_existing_3_a="SELECT * FROM Gold_Score_Totals WHERE Participant='".$_POST['person']."' AND Year=3 AND Test_Time=1";
include "../include/dbconnopen.php";
$exists_3a=mysqli_query($cnnTRP, $get_existing_3_a);
$numrows_3a=  mysqli_num_rows($exists_3a);
if ($numrows_3a>0){    $update_3a=1;}
else{    $update_3a=0;}
include "../include/dbconnclose.php";
$get_existing_3_b="SELECT * FROM Gold_Score_Totals WHERE Participant='".$_POST['person']."' AND Year=3 AND Test_Time=2";
include "../include/dbconnopen.php";
$exists_3b=mysqli_query($cnnTRP, $get_existing_3_b);
$numrows_3b=  mysqli_num_rows($exists_3b);
if ($numrows_3b>0){    $update_3b=1;}
else{    $update_3b=0;}
include "../include/dbconnclose.php";
$get_existing_3_c="SELECT * FROM Gold_Score_Totals WHERE Participant='".$_POST['person']."' AND Year=3 AND Test_Time=3";
include "../include/dbconnopen.php";
$exists_3c=mysqli_query($cnnTRP, $get_existing_3_c);
$numrows_3c=  mysqli_num_rows($exists_3c);
if ($numrows_3c>0){    $update_3c=1;}
else{    $update_3c=0;}
include "../include/dbconnclose.php";



/* save survey responses.  we're saving just the aggregate scores for each section. */
if ($update_1a==0){
$query_1_a="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '".$_POST['person']."', '".$_POST['social1_a']."', '".$_POST['physical1_a']."', '".$_POST['language1_a']."', 
        '".$_POST['cognitive1_a']."', '".$_POST['literacy1_a']."', '".$_POST['math1_a']."', '".$_POST['science1_a']."', 
'".$_POST['socstud1_a']."', '".$_POST['creative1_a']."', '".$_POST['english1_a']."', '".$date1_a."', 1, 1)";}
else{
    $query_1_a="UPDATE Gold_Score_Totals SET Social_Emotional='".$_POST['social1_a']."',"
            . "Physical='".$_POST['physical1_a']."', Language='".$_POST['language1_a']."',
            Cognitive='".$_POST['cognitive1_a']."', Literacy='".$_POST['literacy1_a']."',"
            . " Mathematics='".$_POST['math1_a']."', Science_Tech='".$_POST['science1_a']."',"
            . " Social_Studies='".$_POST['socstud1_a']."', Creative_Arts='".$_POST['creative1_a']."', "
            . "English='".$_POST['english1_a']."', Survey_Date='".$date1_a."'
             WHERE Participant='".$_POST['person']."' AND Year=1 AND Test_Time=1";
}
echo $query_1_a . "<br>";
if ($update_1b==0){
$query_1_b="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '".$_POST['person']."', '".$_POST['social1_b']."', '".$_POST['physical1_b']."', '".$_POST['language1_b']."', 
        '".$_POST['cognitive1_b']."', '".$_POST['literacy1_b']."', '".$_POST['math1_b']."', '".$_POST['science1_b']."', 
'".$_POST['socstud1_b']."', '".$_POST['creative1_b']."', '".$_POST['english1_b']."', '".$date1_b."', 1, 2)";}
else{
    $query_1_b="UPDATE Gold_Score_Totals SET Social_Emotional='".$_POST['social1_b']."',"
            . "Physical='".$_POST['physical1_b']."', Language='".$_POST['language1_b']."',
            Cognitive='".$_POST['cognitive1_b']."', Literacy='".$_POST['literacy1_b']."',"
            . " Mathematics='".$_POST['math1_b']."', Science_Tech='".$_POST['science1_b']."',"
            . " Social_Studies='".$_POST['socstud1_b']."', Creative_Arts='".$_POST['creative1_b']."', "
            . "English='".$_POST['english1_b']."', Survey_Date='".$date1_b."'
             WHERE Participant='".$_POST['person']."' AND Year=1 AND Test_Time=2";
}
echo $query_1_b . "<br>";
if ($update_1c==0){
$query_1_c="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '".$_POST['person']."', '".$_POST['social1_c']."', '".$_POST['physical1_c']."', '".$_POST['language1_c']."', 
        '".$_POST['cognitive1_c']."', '".$_POST['literacy1_c']."', '".$_POST['math1_c']."', '".$_POST['science1_c']."', 
'".$_POST['socstud1_c']."', '".$_POST['creative1_c']."', '".$_POST['english1_c']."', '".$date1_c."', 1, 3)";}
else{
    $query_1_c="UPDATE Gold_Score_Totals SET Social_Emotional='".$_POST['social1_c']."',"
            . "Physical='".$_POST['physical1_c']."', Language='".$_POST['language1_c']."',
            Cognitive='".$_POST['cognitive1_c']."', Literacy='".$_POST['literacy1_c']."',"
            . " Mathematics='".$_POST['math1_c']."', Science_Tech='".$_POST['science1_c']."',"
            . " Social_Studies='".$_POST['socstud1_c']."', Creative_Arts='".$_POST['creative1_c']."', "
            . "English='".$_POST['english1_c']."', Survey_Date='".$date1_c."'
             WHERE Participant='".$_POST['person']."' AND Year=1 AND Test_Time=3";
}
echo $query_1_c . "<br>";


if ($update_2a==0){
$query_2_a="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '".$_POST['person']."', '".$_POST['social2_a']."', '".$_POST['physical2_a']."', '".$_POST['language2_a']."', 
        '".$_POST['cognitive2_a']."', '".$_POST['literacy2_a']."', '".$_POST['math2_a']."', '".$_POST['science2_a']."', 
'".$_POST['socstud2_a']."', '".$_POST['creative2_a']."', '".$_POST['english2_a']."', '".$date2_a."', 2, 1)";}
else{
    $query_2_a="UPDATE Gold_Score_Totals SET Social_Emotional='".$_POST['social2_a']."',"
            . "Physical='".$_POST['physical2_a']."', Language='".$_POST['language2_a']."',
            Cognitive='".$_POST['cognitive2_a']."', Literacy='".$_POST['literacy2_a']."',"
            . " Mathematics='".$_POST['math2_a']."', Science_Tech='".$_POST['science2_a']."',"
            . " Social_Studies='".$_POST['socstud2_a']."', Creative_Arts='".$_POST['creative2_a']."', "
            . "English='".$_POST['english2_a']."', Survey_Date='".$date2_a."'
             WHERE Participant='".$_POST['person']."' AND Year=2 AND Test_Time=1";
}
echo $query_2_a . "<br>";
if ($update_2b==0){
$query_2_b="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '".$_POST['person']."', '".$_POST['social2_b']."', '".$_POST['physical2_b']."', '".$_POST['language2_b']."', 
        '".$_POST['cognitive2_b']."', '".$_POST['literacy2_b']."', '".$_POST['math2_b']."', '".$_POST['science2_b']."', 
'".$_POST['socstud2_b']."', '".$_POST['creative2_b']."', '".$_POST['english2_b']."', '".$date2_b."', 2, 2)";}
else{
    $query_2_b="UPDATE Gold_Score_Totals SET Social_Emotional='".$_POST['social2_b']."',"
            . "Physical='".$_POST['physical2_b']."', Language='".$_POST['language2_b']."',
            Cognitive='".$_POST['cognitive2_b']."', Literacy='".$_POST['literacy2_b']."',"
            . " Mathematics='".$_POST['math2_b']."', Science_Tech='".$_POST['science2_b']."',"
            . " Social_Studies='".$_POST['socstud2_b']."', Creative_Arts='".$_POST['creative2_b']."', "
            . "English='".$_POST['english2_b']."', Survey_Date='".$date2_b."'
             WHERE Participant='".$_POST['person']."' AND Year=2 AND Test_Time=2";
}
echo $query_2_b . "<br>";
if ($update_2c==0){
$query_2_c="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '".$_POST['person']."', '".$_POST['social2_c']."', '".$_POST['physical2_c']."', '".$_POST['language2_c']."', 
        '".$_POST['cognitive2_c']."', '".$_POST['literacy2_c']."', '".$_POST['math2_c']."', '".$_POST['science2_c']."', 
'".$_POST['socstud2_c']."', '".$_POST['creative2_c']."', '".$_POST['english2_c']."', '".$date2_c."', 2, 3)";}
else{
    $query_2_c="UPDATE Gold_Score_Totals SET Social_Emotional='".$_POST['social2_c']."',"
            . "Physical='".$_POST['physical2_c']."', Language='".$_POST['language2_c']."',
            Cognitive='".$_POST['cognitive2_c']."', Literacy='".$_POST['literacy2_c']."',"
            . " Mathematics='".$_POST['math2_c']."', Science_Tech='".$_POST['science2_c']."',"
            . " Social_Studies='".$_POST['socstud2_c']."', Creative_Arts='".$_POST['creative2_c']."', "
            . "English='".$_POST['english2_c']."', Survey_Date='".$date2_c."'
             WHERE Participant='".$_POST['person']."' AND Year=2 AND Test_Time=3";
}
echo $query_2_c . "<br>";


if ($update_3a==0){
$query_3_a="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '".$_POST['person']."', '".$_POST['social3_a']."', '".$_POST['physical3_a']."', '".$_POST['language3_a']."', 
        '".$_POST['cognitive3_a']."', '".$_POST['literacy3_a']."', '".$_POST['math3_a']."', '".$_POST['science3_a']."', 
'".$_POST['socstud3_a']."', '".$_POST['creative3_a']."', '".$_POST['english3_a']."', '".$date3_a."', 3, 1)";}
else{
    $query_3_a="UPDATE Gold_Score_Totals SET Social_Emotional='".$_POST['social3_a']."',"
            . "Physical='".$_POST['physical3_a']."', Language='".$_POST['language3_a']."',
            Cognitive='".$_POST['cognitive3_a']."', Literacy='".$_POST['literacy3_a']."',"
            . " Mathematics='".$_POST['math3_a']."', Science_Tech='".$_POST['science3_a']."',"
            . " Social_Studies='".$_POST['socstud3_a']."', Creative_Arts='".$_POST['creative3_a']."', "
            . "English='".$_POST['english3_a']."', Survey_Date='".$date3_a."'
             WHERE Participant='".$_POST['person']."' AND Year=3 AND Test_Time=1";
}
echo $query_3_a . "<br>";
if ($update_3b==0){
$query_3_b="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '".$_POST['person']."', '".$_POST['social3_b']."', '".$_POST['physical3_b']."', '".$_POST['language3_b']."', 
        '".$_POST['cognitive3_b']."', '".$_POST['literacy3_b']."', '".$_POST['math3_b']."', '".$_POST['science3_b']."', 
'".$_POST['socstud3_b']."', '".$_POST['creative3_b']."', '".$_POST['english3_b']."', '".$date3_b."', 3, 2)";}
else{
    $query_3_b="UPDATE Gold_Score_Totals SET Social_Emotional='".$_POST['social3_b']."',"
            . "Physical='".$_POST['physical3_b']."', Language='".$_POST['language3_b']."',
            Cognitive='".$_POST['cognitive3_b']."', Literacy='".$_POST['literacy3_b']."',"
            . " Mathematics='".$_POST['math3_b']."', Science_Tech='".$_POST['science3_b']."',"
            . " Social_Studies='".$_POST['socstud3_b']."', Creative_Arts='".$_POST['creative3_b']."', "
            . "English='".$_POST['english3_b']."', Survey_Date='".$date3_b."'
             WHERE Participant='".$_POST['person']."' AND Year=3 AND Test_Time=2";
}
echo $query_3_b . "<br>";
if ($update_3c==0){
$query_3_c="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '".$_POST['person']."', '".$_POST['social3_c']."', '".$_POST['physical3_c']."', '".$_POST['language3_c']."', 
        '".$_POST['cognitive3_c']."', '".$_POST['literacy3_c']."', '".$_POST['math3_c']."', '".$_POST['science3_c']."', 
'".$_POST['socstud3_c']."', '".$_POST['creative3_c']."', '".$_POST['english3_c']."', '".$date3_c."', 3, 3)";}
else{
    $query_3_c="UPDATE Gold_Score_Totals SET Social_Emotional='".$_POST['social3_c']."',"
            . "Physical='".$_POST['physical3_c']."', Language='".$_POST['language3_c']."',
            Cognitive='".$_POST['cognitive3_c']."', Literacy='".$_POST['literacy3_c']."',"
            . " Mathematics='".$_POST['math3_c']."', Science_Tech='".$_POST['science3_c']."',"
            . " Social_Studies='".$_POST['socstud3_c']."', Creative_Arts='".$_POST['creative3_c']."', "
            . "English='".$_POST['english3_c']."', Survey_Date='".$date3_c."'
             WHERE Participant='".$_POST['person']."' AND Year=3 AND Test_Time=3";
}
echo $query_3_c . "<br>";





/*
$query_2="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year) VALUES (
    '".$_POST['person']."', '".$_POST['social2']."', '".$_POST['physical2']."', '".$_POST['language2']."', 
        '".$_POST['cognitive2']."', '".$_POST['literacy2']."', '".$_POST['math2']."', '".$_POST['science2']."', 
        '".$_POST['socstud2']."', '".$_POST['creative2']."', '".$_POST['english2']."', '".$date2."',  2)";
echo $query_2. "<br>";

$query_3="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year) VALUES (
    '".$_POST['person']."', '".$_POST['social3']."', '".$_POST['physical3']."', '".$_POST['language3']."', 
        '".$_POST['cognitive3']."', '".$_POST['literacy3']."', '".$_POST['math3']."', '".$_POST['science3']."', 
        '".$_POST['socstud3']."', '".$_POST['creative3']."', '".$_POST['english3']."', '".$date3."',  3)";
echo $query_3. "<br>";*/


include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $query_1_a);
mysqli_query($cnnTRP, $query_1_b);
mysqli_query($cnnTRP, $query_1_c);
mysqli_query($cnnTRP, $query_2_a);
mysqli_query($cnnTRP, $query_2_b);
mysqli_query($cnnTRP, $query_2_c);
mysqli_query($cnnTRP, $query_3_a);
mysqli_query($cnnTRP, $query_3_b);
mysqli_query($cnnTRP, $query_3_c);
include "../include/dbconnclose.php";
?>
