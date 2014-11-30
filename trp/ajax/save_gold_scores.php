<?php
require_once("../siteconfig.php");
?>
<?php
/* Save gold scores, which are administered three times.  The reformat_dates below refer
 * to those survey dates. */

$reformat_date1_a=explode('/', $_POST['date1_a']);
include "../include/dbconnopen.php";
if ($reformat_date1_a[1]){
$date1_a_sqlsafe=mysqli_real_escape_string($cnnTRP, $reformat_date1_a[2]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date1_a[0]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date1_a[1]);}
else{$date1_a_sqlsafe=mysqli_real_escape_string($cnnTRP, $_POST['date1_a']);}
$reformat_date1_b=explode('/', $_POST['date1_b']);
if ($reformat_date1_b[1]){
$date1_b_sqlsafe=mysqli_real_escape_string($cnnTRP, $reformat_date1_b[2]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date1_b[0]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date1_b[1]);}
else{$date1_b_sqlsafe=mysqli_real_escape_string($cnnTRP, $_POST['date1_b']);}
$reformat_date1_c=explode('/', $_POST['date1_c']);
if ($reformat_date1_c[1]){
$date1_c_sqlsafe=mysqli_real_escape_string($cnnTRP, $reformat_date1_c[2]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date1_c[0]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date1_c[1]);}
else{$date1_c_sqlsafe=mysqli_real_escape_string($cnnTRP, $_POST['date1_c']);}

$reformat_date2_a=explode('/', $_POST['date2_a']);
if ($reformat_date2_a[1]){
$date2_a_sqlsafe=mysqli_real_escape_string($cnnTRP, $reformat_date2_a[2]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date2_a[0]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date2_a[1]);}
else{$date2_a_sqlsafe=mysqli_real_escape_string($cnnTRP, $_POST['date2_a']);}
$reformat_date2_b=explode('/', $_POST['date2_b']);
if ($reformat_date2_b[1]){
$date2_b_sqlsafe=mysqli_real_escape_string($cnnTRP, $reformat_date2_b[2]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date2_b[0]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date2_b[1]);}
else{$date2_b_sqlsafe=mysqli_real_escape_string($cnnTRP, $_POST['date2_b']);}
$reformat_date2_c=explode('/', $_POST['date2_c']);
if ($reformat_date2_c[1]){
$date2_c_sqlsafe=mysqli_real_escape_string($cnnTRP, $reformat_date2_c[2]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date2_c[0]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date2_c[1]);}
else{$date2_c_sqlsafe=mysqli_real_escape_string($cnnTRP, $_POST['date2_c']);}

$reformat_date3_a=explode('/', $_POST['date3_a']);
if ($reformat_date3_a[1]){
$date3_a_sqlsafe=mysqli_real_escape_string($cnnTRP, $reformat_date3_a[2]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date3_a[0]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date3_a[1]);}
else{$date3_a_sqlsafe=mysqli_real_escape_string($cnnTRP, $_POST['date3_a']);}
$reformat_date3_b=explode('/', $_POST['date3_b']);
if ($reformat_date3_b[1]){
$date3_b_sqlsafe=mysqli_real_escape_string($cnnTRP, $reformat_date3_b[2]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date3_b[0]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date3_b[1]);}
else{$date3_b_sqlsafe=mysqli_real_escape_string($cnnTRP, $_POST['date3_b']);}
$reformat_date3_c=explode('/', $_POST['date3_c']);
if ($reformat_date3_c[1]){
$date3_c_sqlsafe=mysqli_real_escape_string($cnnTRP, $reformat_date3_c[2]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date3_c[0]) . '-' . mysqli_real_escape_string($cnnTRP, $reformat_date3_c[1]);}
else{$date3_c_sqlsafe=mysqli_real_escape_string($cnnTRP, $_POST['date3_c']);}

/* I'm going to change the saving so that it updates on duplicate person, year, and test edition (pre, mid, or post) */

$get_existing_1_a_sqlsafe="SELECT * FROM Gold_Score_Totals WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=1 AND Test_Time=1";
echo $get_existing_1_a_sqlsafe;
$exists_1a=mysqli_query($cnnTRP, $get_existing_1_a_sqlsafe);
$numrows_1a=  mysqli_num_rows($exists_1a);
if ($numrows_1a>0){    $update_1a=1;}
else{    $update_1a=0;}
$get_existing_1_b_sqlsafe="SELECT * FROM Gold_Score_Totals WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=1 AND Test_Time=2";
$exists_1b=mysqli_query($cnnTRP, $get_existing_1_b_sqlsafe);
$numrows_1b=  mysqli_num_rows($exists_1b);
if ($numrows_1b>0){    $update_1b=1;}
else{    $update_1b=0;}
$get_existing_1_c_sqlsafe="SELECT * FROM Gold_Score_Totals WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=1 AND Test_Time=3";
$exists_1c=mysqli_query($cnnTRP, $get_existing_1_c_sqlsafe);
$numrows_1c=  mysqli_num_rows($exists_1c);
if ($numrows_1c>0){    $update_1c=1;}
else{    $update_1c=0;}

$get_existing_2_a_sqlsafe="SELECT * FROM Gold_Score_Totals WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=2 AND Test_Time=1";
$exists_2a=mysqli_query($cnnTRP, $get_existing_2_a_sqlsafe);
$numrows_2a=  mysqli_num_rows($exists_2a);
if ($numrows_2a>0){    $update_2a=1;}
else{    $update_2a=0;}
$get_existing_2_b_sqlsafe="SELECT * FROM Gold_Score_Totals WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=2 AND Test_Time=2";
$exists_2b=mysqli_query($cnnTRP, $get_existing_2_b_sqlsafe);
$numrows_2b=  mysqli_num_rows($exists_2b);
if ($numrows_2b>0){    $update_2b=1;}
else{    $update_2b=0;}
$get_existing_2_c_sqlsafe="SELECT * FROM Gold_Score_Totals WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=2 AND Test_Time=3";
$exists_2c=mysqli_query($cnnTRP, $get_existing_2_c_sqlsafe);
$numrows_2c=  mysqli_num_rows($exists_2c);
if ($numrows_2c>0){    $update_2c=1;}
else{    $update_2c=0;}


$get_existing_3_a_sqlsafe="SELECT * FROM Gold_Score_Totals WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=3 AND Test_Time=1";
$exists_3a=mysqli_query($cnnTRP, $get_existing_3_a_sqlsafe);
$numrows_3a=  mysqli_num_rows($exists_3a);
if ($numrows_3a>0){    $update_3a=1;}
else{    $update_3a=0;}
$get_existing_3_b_sqlsafe="SELECT * FROM Gold_Score_Totals WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=3 AND Test_Time=2";
$exists_3b=mysqli_query($cnnTRP, $get_existing_3_b_sqlsafe);
$numrows_3b=  mysqli_num_rows($exists_3b);
if ($numrows_3b>0){    $update_3b=1;}
else{    $update_3b=0;}
$get_existing_3_c_sqlsafe="SELECT * FROM Gold_Score_Totals WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=3 AND Test_Time=3";
$exists_3c=mysqli_query($cnnTRP, $get_existing_3_c_sqlsafe);
$numrows_3c=  mysqli_num_rows($exists_3c);
if ($numrows_3c>0){    $update_3c=1;}
else{    $update_3c=0;}



/* save survey responses.  we're saving just the aggregate scores for each section. */
if ($update_1a==0){
$query_1_a_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social1_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical1_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language1_a']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive1_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy1_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math1_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science1_a']) . "', 
'" . mysqli_real_escape_string($cnnTRP, $_POST['socstud1_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative1_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english1_a']) . "', '".$date1_a_sqlsafe."', 1, 1)";}
else{
  $query_1_a_sqlsafe="UPDATE Gold_Score_Totals SET Social_Emotional='" . mysqli_real_escape_string($cnnTRP, $_POST['social1_a']) . "',"
    . "Physical='" . mysqli_real_escape_string($cnnTRP, $_POST['physical1_a']) . "', Language='" . mysqli_real_escape_string($cnnTRP, $_POST['language1_a']) . "',
            Cognitive='" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive1_a']) . "', Literacy='" . mysqli_real_escape_string($cnnTRP, $_POST['literacy1_a']) . "',"
    . " Mathematics='" . mysqli_real_escape_string($cnnTRP, $_POST['math1_a']) . "', Science_Tech='" . mysqli_real_escape_string($cnnTRP, $_POST['science1_a']) . "',"
    . " Social_Studies='" . mysqli_real_escape_string($cnnTRP, $_POST['socstud1_a']) . "', Creative_Arts='" . mysqli_real_escape_string($cnnTRP, $_POST['creative1_a']) . "', "
    . "English='" . mysqli_real_escape_string($cnnTRP, $_POST['english1_a']) . "', Survey_Date='".$date1_a_sqlsafe."'
             WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=1 AND Test_Time=1";
}
echo $query_1_a_sqlsafe . "<br>";
if ($update_1b==0){
$query_1_b_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social1_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical1_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language1_b']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive1_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy1_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math1_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science1_b']) . "', 
'" . mysqli_real_escape_string($cnnTRP, $_POST['socstud1_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative1_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english1_b']) . "', '".$date1_b_sqlsafe."', 1, 2)";}
else{
  $query_1_b_sqlsafe="UPDATE Gold_Score_Totals SET Social_Emotional='" . mysqli_real_escape_string($cnnTRP, $_POST['social1_b']) . "',"
    . "Physical='" . mysqli_real_escape_string($cnnTRP, $_POST['physical1_b']) . "', Language='" . mysqli_real_escape_string($cnnTRP, $_POST['language1_b']) . "',
            Cognitive='" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive1_b']) . "', Literacy='" . mysqli_real_escape_string($cnnTRP, $_POST['literacy1_b']) . "',"
    . " Mathematics='" . mysqli_real_escape_string($cnnTRP, $_POST['math1_b']) . "', Science_Tech='" . mysqli_real_escape_string($cnnTRP, $_POST['science1_b']) . "',"
    . " Social_Studies='" . mysqli_real_escape_string($cnnTRP, $_POST['socstud1_b']) . "', Creative_Arts='" . mysqli_real_escape_string($cnnTRP, $_POST['creative1_b']) . "', "
    . "English='" . mysqli_real_escape_string($cnnTRP, $_POST['english1_b']) . "', Survey_Date='".$date1_b_sqlsafe."'
             WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=1 AND Test_Time=2";
}
echo $query_1_b_sqlsafe . "<br>";
if ($update_1c==0){
$query_1_c_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social1_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical1_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language1_c']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive1_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy1_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math1_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science1_c']) . "', 
'" . mysqli_real_escape_string($cnnTRP, $_POST['socstud1_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative1_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english1_c']) . "', '".$date1_c_sqlsafe."', 1, 3)";}
else{
  $query_1_c_sqlsafe="UPDATE Gold_Score_Totals SET Social_Emotional='" . mysqli_real_escape_string($cnnTRP, $_POST['social1_c']) . "',"
    . "Physical='" . mysqli_real_escape_string($cnnTRP, $_POST['physical1_c']) . "', Language='" . mysqli_real_escape_string($cnnTRP, $_POST['language1_c']) . "',
            Cognitive='" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive1_c']) . "', Literacy='" . mysqli_real_escape_string($cnnTRP, $_POST['literacy1_c']) . "',"
    . " Mathematics='" . mysqli_real_escape_string($cnnTRP, $_POST['math1_c']) . "', Science_Tech='" . mysqli_real_escape_string($cnnTRP, $_POST['science1_c']) . "',"
    . " Social_Studies='" . mysqli_real_escape_string($cnnTRP, $_POST['socstud1_c']) . "', Creative_Arts='" . mysqli_real_escape_string($cnnTRP, $_POST['creative1_c']) . "', "
    . "English='" . mysqli_real_escape_string($cnnTRP, $_POST['english1_c']) . "', Survey_Date='".$date1_c_sqlsafe."'
             WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=1 AND Test_Time=3";
}
echo $query_1_c_sqlsafe . "<br>";


if ($update_2a==0){
$query_2_a_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social2_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical2_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language2_a']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive2_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy2_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math2_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science2_a']) . "', 
'" . mysqli_real_escape_string($cnnTRP, $_POST['socstud2_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative2_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english2_a']) . "', '".$date2_a_sqlsafe."', 2, 1)";}
else{
  $query_2_a_sqlsafe="UPDATE Gold_Score_Totals SET Social_Emotional='" . mysqli_real_escape_string($cnnTRP, $_POST['social2_a']) . "',"
    . "Physical='" . mysqli_real_escape_string($cnnTRP, $_POST['physical2_a']) . "', Language='" . mysqli_real_escape_string($cnnTRP, $_POST['language2_a']) . "',
            Cognitive='" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive2_a']) . "', Literacy='" . mysqli_real_escape_string($cnnTRP, $_POST['literacy2_a']) . "',"
    . " Mathematics='" . mysqli_real_escape_string($cnnTRP, $_POST['math2_a']) . "', Science_Tech='" . mysqli_real_escape_string($cnnTRP, $_POST['science2_a']) . "',"
    . " Social_Studies='" . mysqli_real_escape_string($cnnTRP, $_POST['socstud2_a']) . "', Creative_Arts='" . mysqli_real_escape_string($cnnTRP, $_POST['creative2_a']) . "', "
    . "English='" . mysqli_real_escape_string($cnnTRP, $_POST['english2_a']) . "', Survey_Date='".$date2_a_sqlsafe."'
             WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=2 AND Test_Time=1";
}
echo $query_2_a_sqlsafe . "<br>";
if ($update_2b==0){
$query_2_b_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social2_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical2_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language2_b']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive2_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy2_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math2_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science2_b']) . "', 
'" . mysqli_real_escape_string($cnnTRP, $_POST['socstud2_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative2_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english2_b']) . "', '".$date2_b_sqlsafe."', 2, 2)";}
else{
  $query_2_b_sqlsafe="UPDATE Gold_Score_Totals SET Social_Emotional='" . mysqli_real_escape_string($cnnTRP, $_POST['social2_b']) . "',"
    . "Physical='" . mysqli_real_escape_string($cnnTRP, $_POST['physical2_b']) . "', Language='" . mysqli_real_escape_string($cnnTRP, $_POST['language2_b']) . "',
            Cognitive='" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive2_b']) . "', Literacy='" . mysqli_real_escape_string($cnnTRP, $_POST['literacy2_b']) . "',"
    . " Mathematics='" . mysqli_real_escape_string($cnnTRP, $_POST['math2_b']) . "', Science_Tech='" . mysqli_real_escape_string($cnnTRP, $_POST['science2_b']) . "',"
    . " Social_Studies='" . mysqli_real_escape_string($cnnTRP, $_POST['socstud2_b']) . "', Creative_Arts='" . mysqli_real_escape_string($cnnTRP, $_POST['creative2_b']) . "', "
    . "English='" . mysqli_real_escape_string($cnnTRP, $_POST['english2_b']) . "', Survey_Date='".$date2_b_sqlsafe."'
             WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=2 AND Test_Time=2";
}
echo $query_2_b_sqlsafe . "<br>";
if ($update_2c==0){
$query_2_c_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social2_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical2_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language2_c']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive2_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy2_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math2_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science2_c']) . "', 
'" . mysqli_real_escape_string($cnnTRP, $_POST['socstud2_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative2_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english2_c']) . "', '".$date2_c_sqlsafe."', 2, 3)";}
else{
  $query_2_c_sqlsafe="UPDATE Gold_Score_Totals SET Social_Emotional='" . mysqli_real_escape_string($cnnTRP, $_POST['social2_c']) . "',"
    . "Physical='" . mysqli_real_escape_string($cnnTRP, $_POST['physical2_c']) . "', Language='" . mysqli_real_escape_string($cnnTRP, $_POST['language2_c']) . "',
            Cognitive='" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive2_c']) . "', Literacy='" . mysqli_real_escape_string($cnnTRP, $_POST['literacy2_c']) . "',"
    . " Mathematics='" . mysqli_real_escape_string($cnnTRP, $_POST['math2_c']) . "', Science_Tech='" . mysqli_real_escape_string($cnnTRP, $_POST['science2_c']) . "',"
    . " Social_Studies='" . mysqli_real_escape_string($cnnTRP, $_POST['socstud2_c']) . "', Creative_Arts='" . mysqli_real_escape_string($cnnTRP, $_POST['creative2_c']) . "', "
    . "English='" . mysqli_real_escape_string($cnnTRP, $_POST['english2_c']) . "', Survey_Date='".$date2_c_sqlsafe."'
             WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=2 AND Test_Time=3";
}
echo $query_2_c_sqlsafe . "<br>";


if ($update_3a==0){
$query_3_a_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social3_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical3_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language3_a']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive3_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy3_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math3_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science3_a']) . "', 
'" . mysqli_real_escape_string($cnnTRP, $_POST['socstud3_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative3_a']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english3_a']) . "', '".$date3_a_sqlsafe."', 3, 1)";}
else{
  $query_3_a_sqlsafe="UPDATE Gold_Score_Totals SET Social_Emotional='" . mysqli_real_escape_string($cnnTRP, $_POST['social3_a']) . "',"
    . "Physical='" . mysqli_real_escape_string($cnnTRP, $_POST['physical3_a']) . "', Language='" . mysqli_real_escape_string($cnnTRP, $_POST['language3_a']) . "',
            Cognitive='" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive3_a']) . "', Literacy='" . mysqli_real_escape_string($cnnTRP, $_POST['literacy3_a']) . "',"
    . " Mathematics='" . mysqli_real_escape_string($cnnTRP, $_POST['math3_a']) . "', Science_Tech='" . mysqli_real_escape_string($cnnTRP, $_POST['science3_a']) . "',"
    . " Social_Studies='" . mysqli_real_escape_string($cnnTRP, $_POST['socstud3_a']) . "', Creative_Arts='" . mysqli_real_escape_string($cnnTRP, $_POST['creative3_a']) . "', "
    . "English='" . mysqli_real_escape_string($cnnTRP, $_POST['english3_a']) . "', Survey_Date='".$date3_a_sqlsafe."'
             WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=3 AND Test_Time=1";
}
echo $query_3_a_sqlsafe . "<br>";
if ($update_3b==0){
$query_3_b_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social3_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical3_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language3_b']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive3_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy3_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math3_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science3_b']) . "', 
'" . mysqli_real_escape_string($cnnTRP, $_POST['socstud3_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative3_b']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english3_b']) . "', '".$date3_b_sqlsafe."', 3, 2)";}
else{
  $query_3_b_sqlsafe="UPDATE Gold_Score_Totals SET Social_Emotional='" . mysqli_real_escape_string($cnnTRP, $_POST['social3_b']) . "',"
    . "Physical='" . mysqli_real_escape_string($cnnTRP, $_POST['physical3_b']) . "', Language='" . mysqli_real_escape_string($cnnTRP, $_POST['language3_b']) . "',
            Cognitive='" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive3_b']) . "', Literacy='" . mysqli_real_escape_string($cnnTRP, $_POST['literacy3_b']) . "',"
    . " Mathematics='" . mysqli_real_escape_string($cnnTRP, $_POST['math3_b']) . "', Science_Tech='" . mysqli_real_escape_string($cnnTRP, $_POST['science3_b']) . "',"
    . " Social_Studies='" . mysqli_real_escape_string($cnnTRP, $_POST['socstud3_b']) . "', Creative_Arts='" . mysqli_real_escape_string($cnnTRP, $_POST['creative3_b']) . "', "
    . "English='" . mysqli_real_escape_string($cnnTRP, $_POST['english3_b']) . "', Survey_Date='".$date3_b_sqlsafe."'
             WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=3 AND Test_Time=2";
}
echo $query_3_b_sqlsafe . "<br>";
if ($update_3c==0){
$query_3_c_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year, Test_Time) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social3_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical3_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language3_c']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive3_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy3_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math3_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science3_c']) . "', 
'" . mysqli_real_escape_string($cnnTRP, $_POST['socstud3_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative3_c']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english3_c']) . "', '".$date3_c_sqlsafe."', 3, 3)";}
else{
  $query_3_c_sqlsafe="UPDATE Gold_Score_Totals SET Social_Emotional='" . mysqli_real_escape_string($cnnTRP, $_POST['social3_c']) . "',"
    . "Physical='" . mysqli_real_escape_string($cnnTRP, $_POST['physical3_c']) . "', Language='" . mysqli_real_escape_string($cnnTRP, $_POST['language3_c']) . "',
            Cognitive='" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive3_c']) . "', Literacy='" . mysqli_real_escape_string($cnnTRP, $_POST['literacy3_c']) . "',"
    . " Mathematics='" . mysqli_real_escape_string($cnnTRP, $_POST['math3_c']) . "', Science_Tech='" . mysqli_real_escape_string($cnnTRP, $_POST['science3_c']) . "',"
    . " Social_Studies='" . mysqli_real_escape_string($cnnTRP, $_POST['socstud3_c']) . "', Creative_Arts='" . mysqli_real_escape_string($cnnTRP, $_POST['creative3_c']) . "', "
    . "English='" . mysqli_real_escape_string($cnnTRP, $_POST['english3_c']) . "', Survey_Date='".$date3_c_sqlsafe."'
             WHERE Participant='" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "' AND Year=3 AND Test_Time=3";
}
echo $query_3_c_sqlsafe . "<br>";





/*
$query_2_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social2']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical2']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language2']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive2']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy2']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math2']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science2']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['socstud2']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative2']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english2']) . "', '".$date2."',  2)";
echo $query_2_sqlsafe. "<br>";

$query_3_sqlsafe="INSERT INTO Gold_Score_Totals (Participant, Social_Emotional, Physical, Language,
    Cognitive, Literacy, Mathematics, Science_Tech, Social_Studies, Creative_Arts, English, Survey_Date, Year) VALUES (
    '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['social3']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['physical3']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['language3']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['cognitive3']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['literacy3']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['math3']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['science3']) . "', 
        '" . mysqli_real_escape_string($cnnTRP, $_POST['socstud3']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['creative3']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['english3']) . "', '".$date3."',  3)";
echo $query_3_sqlsafe. "<br>";*/


mysqli_query($cnnTRP, $query_1_a_sqlsafe);
mysqli_query($cnnTRP, $query_1_b_sqlsafe);
mysqli_query($cnnTRP, $query_1_c_sqlsafe);
mysqli_query($cnnTRP, $query_2_a_sqlsafe);
mysqli_query($cnnTRP, $query_2_b_sqlsafe);
mysqli_query($cnnTRP, $query_2_c_sqlsafe);
mysqli_query($cnnTRP, $query_3_a_sqlsafe);
mysqli_query($cnnTRP, $query_3_b_sqlsafe);
mysqli_query($cnnTRP, $query_3_c_sqlsafe);
include "../include/dbconnclose.php";
?>
