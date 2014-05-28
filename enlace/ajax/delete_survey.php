<?php
/*delete a survey.  somewhat complicated because all the pieces must be deleted.
 * 
 */
if ($_POST['action']=='personal'){
    $get_surveys="SELECT * FROM Assessments WHERE Assessment_ID='".$_POST['assessment']."'";
    include "../include/dbconnopen.php";
    $surveys=mysqli_query($cnnEnlace, $get_surveys);
    $surv=mysqli_fetch_row($surveys);
    $delete_caring="DELETE FROM Participants_Caring_Adults WHERE Caring_Adults_Id=$surv[3]";
    $delete_baseline="DELETE FROM Participants_Baseline_Assessments WHERE Baseline_Assessment_ID=$surv[2]";
    $delete_future="DELETE FROM Participants_Future_Expectations WHERE Future_Expectations_ID=$surv[4]";
    $delete_violence="DELETE FROM Participants_Interpersonal_Violence WHERE Interpersonal_Violence_ID=$surv[5]";
    $delete_query="DELETE FROM Assessments WHERE Assessment_ID='" . $_POST['assessment'] . "'";
    echo $delete_query;  
    mysqli_query($cnnEnlace, $delete_caring);
    mysqli_query($cnnEnlace, $delete_baseline);
    mysqli_query($cnnEnlace, $delete_future);
    mysqli_query($cnnEnlace, $delete_violence);
    mysqli_query($cnnEnlace, $delete_query);
    include "../include/dbconnclose.php";
}
/*not complicated to delete a program survey: */
else{
$delete_query="DELETE FROM Program_Surveys WHERE Program_Survey_ID='" . $_POST['id'] . "'";
echo $delete_query;

include "../include/dbconnopen.php";
mysqli_query($cnnEnlace, $delete_query);
include "../include/dbconnclose.php";}
?>
