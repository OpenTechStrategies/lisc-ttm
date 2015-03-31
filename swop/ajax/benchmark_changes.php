<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);

if ($_POST['action']=='delete'){
user_enforce_has_access($SWOP_id, $AdminAccess);
    //figure out what table the activity is saved in, and delete accordingly
    include "../include/dbconnopen.php";
    if ($_POST['activity_type']==1){
    $remove_progress_sqlsafe="DELETE FROM Pool_Progress WHERE Pool_Progress_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";}
    elseif($_POST['activity_type']==2){
    $remove_progress_sqlsafe="DELETE FROM Participants_Leaders WHERE Participants_Leader_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";}
    elseif($_POST['activity_type']==3){
    $remove_progress_sqlsafe="DELETE FROM Pool_Outcomes WHERE Pool_Outcome_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";}
    elseif($_POST['activity_type']==4 || $_POST['activity_type']==5) {
    $remove_progress_sqlsafe="DELETE FROM Pool_Status_Changes WHERE Pool_Status_Change_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";}
    elseif($_POST['activity_type']==6){
    $remove_progress_sqlsafe="DELETE FROM Institutions_Participants WHERE Institutions_Participants_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";}
    
    echo $remove_progress_sqlsafe;
    mysqli_query($cnnSWOP, $remove_progress_sqlsafe);
    include "../include/dbconnclose.php";
}




else if ($_POST['action']=='set_date_complete') {
    /* indicate that progress step has been completed: */
    //first, find out if the date completed has been changed from zero to not zero (i.e., did it start as zero?)
    include "../include/dbconnopen.php";
    $answer_zero_sqlsafe="SELECT Date_Completed FROM Pool_Progress WHERE Pool_Progress_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['benchmark'])."'";
    
	$set_date_complete_sqlsafe = "UPDATE Pool_Progress SET 
				Date_Completed='".mysqli_real_escape_string($cnnSWOP, $_POST['date_complete'])."'
		WHERE Pool_Progress_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['benchmark'])."'";
        echo "new date: " .$set_date_complete_sqlsafe . "<br>";
        date_default_timezone_set('America/Chicago');
        $date_breakup=explode('-', $_POST['date_complete']);
$expected_date=mktime(0, 0, 0, $date_breakup[1], $date_breakup[2]+30, $date_breakup[0]);
$enter_expected_date_sqlsafe=date('Y-m-d', $expected_date);
echo "expected date: " .$enter_expected_date_sqlsafe . "<br>";
//get next benchmark (to add it with an expected date)
$get_next_benchmark_sqlsafe="SELECT Pool_Benchmark_ID FROM Pool_Benchmarks WHERE Pipeline_Type=(SELECT Pipeline_Type FROM Pool_Progress INNER JOIN Pool_Benchmarks 
ON Benchmark_Completed=Pool_Benchmark_ID
WHERE Pool_Progress_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['benchmark'])."') AND Step_Number>
    (SELECT Step_Number FROM Pool_Progress INNER JOIN Pool_Benchmarks 
ON Benchmark_Completed=Pool_Benchmark_ID
WHERE Pool_Progress_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['benchmark'])."') ORDER BY Step_Number LIMIT 1";
echo "find next benchmark: " . $get_next_benchmark_sqlsafe . "<br>";
include "../include/dbconnopen.php";
$benchmark_next=mysqli_query($cnnSWOP, $get_next_benchmark_sqlsafe);
$bench_next=mysqli_fetch_row($benchmark_next);
$next_benchmark=$bench_next[0];
echo "next benchmark: " . $next_benchmark . "<br>";
include "../include/dbconnclose.php";
/* add next progress step */
include "../include/dbconnopen.php";
$next_progress_sqlsafe="INSERT INTO Pool_Progress(Participant_ID, Benchmark_Completed, Date_Completed, Activity_Type, Expected_Date) VALUES 
    ('".mysqli_real_escape_string($cnnSWOP, $_POST['person'])."', mysqli_real_escape_string($cnnSWOP, $next_benchmark), '0000-00-00', 1, '".mysqli_real_escape_string($cnnSWOP, $enter_expected_date) . "')";
echo "add progress: " . $next_progress_sqlsafe . "<br>";
        $zeroed=mysqli_query($cnnSWOP, $answer_zero_sqlsafe);
    mysqli_query($cnnSWOP, $set_date_complete_sqlsafe);
    $zeroq=mysqli_fetch_row($zeroed);
    if ($zeroq[0]=='0000-00-00 00:00:00'){
    mysqli_query($cnnSWOP, $next_progress_sqlsafe);}
    include "../include/dbconnclose.php";
}




else if ($_POST['action']=='set_expected_date') {
       /* change the expected date of a pool progress item. */
        include "../include/dbconnopen.php";
	$set_expected_date_sqlsafe = "UPDATE Pool_Progress SET 
				Expected_Date='".mysqli_real_escape_string($cnnSWOP, $_POST['expected_date'])."'
		WHERE Pool_Progress_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['benchmark'])."'";
        echo "new date: " .$set_expected_date_sqlsafe . "<br>";
        mysqli_query($cnnSWOP, $set_expected_date_sqlsafe);
        include "../include/dbconnclose.php";
}




elseif($_POST['action']=='add_organizer'){
    /* add the organizer to the one-on-one */
    include "../include/dbconnopen.php";
    $org_add_sqlsafe="UPDATE Pool_Progress SET More_Info='".mysqli_real_escape_string($cnnSWOP, $_POST['organizer'])."' WHERE Pool_Progress_Id='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";
    echo $org_add_sqlsafe;
    mysqli_query($cnnSWOP, $org_add_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='barrier_notes'){
    /* add notes to an identified barrier, either individual or structural */
    $org_add_sqlsafe="UPDATE Pool_Progress SET Barrier_Notes='".mysqli_real_escape_string($cnnSWOP, $_POST['notes'])."' WHERE Pool_Progress_Id='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";
    echo $org_add_sqlsafe;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $org_add_sqlsafe);
    include "../include/dbconnclose.php";
}
else{
    /* add a new progress benchmark to the pool profile: */
include "../include/dbconnopen.php";
$add_progress_sqlsafe="INSERT INTO Pool_Progress (Participant_ID, Benchmark_Completed, Activity_Type) 
    VALUES ('".mysqli_real_escape_string($cnnSWOP, $_POST['person'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['benchmark'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['type'])."')";
echo $add_progress_sqlsafe;
//then account for adding the next benchmark
    date_default_timezone_set('America/Chicago');
$expected_date=mktime(0, 0, 0, date("m"), date("d")+30,   date("Y"));
$enter_expected_date_sqlsafe=date('Y-m-d', $expected_date);
//get next benchmark
$get_next_benchmark_sqlsafe="SELECT Pool_Benchmark_ID FROM Pool_Benchmarks WHERE Pipeline_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['pipeline']) . "' AND Step_Number>
    (SELECT Step_Number FROM Pool_Benchmarks WHERE Pool_Benchmark_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['benchmark'])."') ORDER BY Step_Number LIMIT 1";
//echo $get_next_benchmark;
$benchmark_next=mysqli_query($cnnSWOP, $get_next_benchmark_sqlsafe);
$bench_next=mysqli_fetch_row($benchmark_next);
$next_benchmark=$bench_next[0];
include "../include/dbconnclose.php";
/* add next benchmark with expected date: (only valid for benchmarks, not activities, so will not work with activities) */
$next_progress_sqlsafe="INSERT INTO Pool_Progress(Participant_ID, Benchmark_Completed, Date_Completed, Activity_Type, Expected_Date) VALUES 
    ('".mysqli_real_escape_string($cnnSWOP, $_POST['person'])."', $next_benchmark, '0000-00-00', '".mysqli_real_escape_string($cnnSWOP, $_POST['type'])."', '". $enter_expected_date_sqlsafe . "')";
echo $next_progress_sqlsafe;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $add_progress_sqlsafe);
if ($next_benchmark!==null && $next_benchmark!='' && $next_benchmark!=0){
mysqli_query($cnnSWOP, $next_progress_sqlsafe);}
include "../include/dbconnclose.php";
}
?>
