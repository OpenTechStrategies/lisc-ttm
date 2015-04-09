<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id);

$type=$_POST['type'];
$start=$_POST['start'];
$end=$_POST['end'];
$type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $type);
$start_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $start);
$end_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $end);
?>
<!--
Gets surveys within the date range specified and according to type specified (either parent, adult, or youth).
Returns a table of average responses for each question.
-->
<table class="all_projects">
    <tr>
        <th></th>
        <th colspan="3">Average Responses</th> <!-- would it make sense to do median/mode? -->
    </tr>
    <?
    //count the number of surveys entered for each step
    $count_pres_sqlsafe ="SELECT * FROM Participant_Survey_Responses WHERE Participant_Type='" . $type_sqlsafe . "' AND Pre_Post_Late='1'
    AND Date_Survey_Administered >= '$start_sqlsafe'
    AND Date_Survey_Administered <= '$end_sqlsafe'";
    include "../include/dbconnopen.php";
    $pres = mysqli_query($cnnBickerdike, $count_pres_sqlsafe);
    $num_pres = mysqli_num_rows($pres);
    include "../include/dbconnclose.php";
    
    $count_posts_sqlsafe ="SELECT * FROM Participant_Survey_Responses WHERE Participant_Type='" . $type_sqlsafe . "' AND Pre_Post_Late='2' AND Date_Survey_Administered >= '$start_sqlsafe'
    AND Date_Survey_Administered <= '$end_sqlsafe'";
    include "../include/dbconnopen.php";
    $posts = mysqli_query($cnnBickerdike, $count_posts_sqlsafe);
    $num_posts = mysqli_num_rows($posts);
    include "../include/dbconnclose.php";
    
    $count_laters_sqlsafe ="SELECT * FROM Participant_Survey_Responses WHERE Participant_Type='" . $type_sqlsafe . "' AND Pre_Post_Late='3' AND Date_Survey_Administered >= '$start_sqlsafe'
    AND Date_Survey_Administered <= '$end_sqlsafe'";
    include "../include/dbconnopen.php";
    $laters = mysqli_query($cnnBickerdike, $count_laters_sqlsafe);
    $num_laters = mysqli_num_rows($laters);
    include "../include/dbconnclose.php";
    
    ?>
    <tr>
        
        <th width="65%">Question</th>
        <th>Pre-Survey<br>(<?echo $num_pres?> surveys)</th>
        <th>Post-Survey<br>(<?echo $num_posts?> surveys)</th>
        <th>Three Months Later<br>(<?echo $num_laters?> surveys)</th>
    </tr>
    <?
    
    //call the routine for pre, post, and later
    include "../include/dbconnopen.php";
    if ($get_pre_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results_with_dates('" . $type_sqlsafe . "', 1, '" . $start_sqlsafe ."', '" . $end_sqlsafe . "')")){
    $pre = array();
    while ($pre_averages = mysqli_fetch_array($get_pre_averages)){
        $pre[0] = $pre_averages['AVG(Question_2)'];
        $pre[1] = $pre_averages['AVG(Question_3)'];
        $pre[2] = $pre_averages['AVG(Question_4_A)'];
        $pre[3] = $pre_averages['AVG(Question_4_B)'];
        $pre[4] = $pre_averages['AVG(Question_5_A)'];
        $pre[5] = $pre_averages['AVG(Question_5_B)'];
        
        $pre[6] = $pre_averages['AVG(Question_6)'];
        $pre[7] = $pre_averages['AVG(Question_7)'];
        $pre[8] = $pre_averages['AVG(Question_8)'];
        $pre[9] = $pre_averages['AVG(Question_9_A)'];
        $pre[10] = $pre_averages['AVG(Question_9_B)'];
        $pre[11] = $pre_averages['AVG(Question_14)'];
        
        $pre[12] = $pre_averages['AVG(Question_11)'];
        $pre[13] = $pre_averages['AVG(Question_12)'];
        $pre[14] = $pre_averages['AVG(Question_13)'];
        
    }
    include "../include/dbconnclose.php";
    }
    include "../include/dbconnopen.php";
    if($get_post_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results_with_dates('" . $type_sqlsafe . "', 2" . $start_sqlsafe ."', '" . $end_sqlsafe . "')")){
    $post = array();
    while ($post_averages = mysqli_fetch_array($get_post_averages)){
        $post[0] = $post_averages['AVG(Question_2)'];
        $post[1] = $post_averages['AVG(Question_3)'];
        $post[2] = $post_averages['AVG(Question_4_A)'];
        $post[3] = $post_averages['AVG(Question_4_B)'];
        $post[4] = $post_averages['AVG(Question_5_A)'];
        $post[5] = $post_averages['AVG(Question_5_B)'];
        
        $post[6] = $post_averages['AVG(Question_6)'];
        $post[7] = $post_averages['AVG(Question_7)'];
        $post[8] = $post_averages['AVG(Question_8)'];
        $post[9] = $post_averages['AVG(Question_9_A)'];
        $post[10] = $post_averages['AVG(Question_9_B)'];
        $post[11] = $post_averages['AVG(Question_14)'];
        
        $post[12] = $post_averages['AVG(Question_11)'];
        $post[13] = $post_averages['AVG(Question_12)'];
        $post[14] = $post_averages['AVG(Question_13)'];
        
    }
    }
    include "../include/dbconnopen.php";
    if ($get_later_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results_with_dates('" . $type_sqlsafe . "', 3" . $start_sqlsafe ."', '" . $end_sqlsafe . "')")){
    $later = array();
    while ($later_averages = mysqli_fetch_array($get_later_averages)){
        $later[0] = $later_averages['AVG(Question_2)'];
        $later[1] = $later_averages['AVG(Question_3)'];
        $later[2] = $later_averages['AVG(Question_4_A)'];
        $later[3] = $later_averages['AVG(Question_4_B)'];
        $later[4] = $later_averages['AVG(Question_5_A)'];
        $later[5] = $later_averages['AVG(Question_5_B)'];
        
        $later[6] = $later_averages['AVG(Question_6)'];
        $later[7] = $later_averages['AVG(Question_7)'];
        $later[8] = $later_averages['AVG(Question_8)'];
        $later[9] = $later_averages['AVG(Question_9_A)'];
        $later[10] = $later_averages['AVG(Question_9_B)'];
        $later[11] = $later_averages['AVG(Question_14)'];
        
        $later[12] = $later_averages['AVG(Question_11)'];
        $later[13] = $later_averages['AVG(Question_12)'];
        $later[14] = $later_averages['AVG(Question_13)'];
        
    }
    include "../include/dbconnclose.php";
    }
    ?>
    <tr>
         <td class="all_projects">Question 1: How important is diet and nutrition to you personally?</td>
         <td class="all_projects"><?echo $pre[0]?></td>
         <td class="all_projects"><?echo $post[0];?></td>
         <td class="all_projects"><?echo $later[0];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 2: How many servings of fruits and vegetables do you eat in an average day?</td>
         <td class="all_projects"><?echo $pre[1]?></td>
         <td class="all_projects"><?echo $post[1];?></td>
         <td class="all_projects"><?echo $later[1];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 3a: How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</td>
         <td class="all_projects"><?echo $pre[2]?></td>
         <td class="all_projects"><?echo $post[2];?></td>
         <td class="all_projects"><?echo $later[2];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 3b: How many minutes on those days?</td>
         <td class="all_projects"><?echo $pre[3]?></td>
         <td class="all_projects"><?echo $post[3];?></td>
         <td class="all_projects"><?echo $later[3];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 4a: How many days per week do you do light or moderate physical activity for at least 10 minutes?</td>
         <td class="all_projects"><?echo $pre[4]?></td>
         <td class="all_projects"><?echo $post[4];?></td>
         <td class="all_projects"><?echo $later[4];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 4b: How many minutes on those moderate activity days?</td>
         <td class="all_projects"><?echo $pre[5]?></td>
         <td class="all_projects"><?echo $post[5];?></td>
         <td class="all_projects"><?echo $later[5];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 5: Do you have at least one child between the ages of 0-18 that lives with you at least 3 days per week?</td>
         <td class="all_projects"><?echo $pre[6]?></td>
         <td class="all_projects"><?echo $post[6];?></td>
         <td class="all_projects"><?echo $later[6];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 6: Yesterday, how many servings of fruits and vegetables did your child have?</td>
         <td class="all_projects"><?echo $pre[7]?></td>
         <td class="all_projects"><?echo $post[7];?></td>
         <td class="all_projects"><?echo $later[7];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 7: On an average day, how many hours and minutes does your child spend in active play?</td>
         <td class="all_projects"><?echo $pre[8]?></td>
         <td class="all_projects"><?echo $post[8];?></td>
         <td class="all_projects"><?echo $later[8];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 8a: Do you agree? I would walk more often if I felt safer in my community.</td>
         <td class="all_projects"><?echo $pre[10]?></td>
         <td class="all_projects"><?echo $post[10];?></td>
         <td class="all_projects"><?echo $later[10];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 8b: Do you agree? I feel comfortable with my child playing outside in my community.</td>
         <td class="all_projects"><?echo $pre[9]?></td>
         <td class="all_projects"><?echo $post[9];?></td>
         <td class="all_projects"><?echo $later[9];?></td>
    </tr>
    
    <tr>
         <td class="all_projects">Question 9: How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?</td>
         <td class="all_projects"><?echo $pre[11]?></td>
         <td class="all_projects"><?echo $post[11];?></td>
         <td class="all_projects"><?echo $later[11];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 10: Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?</td>
         <td class="all_projects"><?echo $pre[12]?></td>
         <td class="all_projects"><?echo $post[12];?></td>
         <td class="all_projects"><?echo $later[12];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 11: Are you aware of free or low-cost fitness opportunities in Humboldt Park?</td>
         <td class="all_projects"><?echo $pre[13]?></td>
         <td class="all_projects"><?echo $post[13];?></td>
         <td class="all_projects"><?echo $later[13];?></td>
    </tr>
    <tr>
         <td class="all_projects">Question 12: Are you aware of free or low-cost nutrition opportunities in Humboldt Park?</td>
         <td class="all_projects"><?echo $pre[14]?></td>
         <td class="all_projects"><?echo $post[14];?></td>
         <td class="all_projects"><?echo $later[14];?></td>
    </tr>
    <tr>
        <?php
$infile="downloads/survey_aggregate.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_info = array('Question', 'Pre-Survey', 'Post-Survey', '3 Months Later');
fputcsv ($fp, $title_info);
$questions = array(
    'How important is diet and nutrition to you personally?',
    'How many servings of fruits and vegetables do you eat in an average day?',
    'How many days per week do you do strenuous physical activity for at least 10 minutes at a time?',
    'How many minutes on those days?',
    'How many days per week do you do light or moderate physical activity for at least 10 minutes?',
    'How many minutes on those moderate activity days?',
    'Do you have at least child between the ages of 0-18 that lives with you at least 3 days per week?',
    'Yesterday, how many servings of fruits and vegetables did your child have?',
    'On an average day, how many hours and minutes does your child spend in active play?',
    'Do you agree? I would walk more often if I felt safer in my community.',
    'Do you agree? I feel comfortable with my child playing outside in my community.',
    'How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?',
    'Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?',
    'Are you aware of free or low-cost fitness opportunities in Humboldt Park?',
    'Are you aware of free or low-cost nutrition opportunities in Humboldt Park?'
);
for ($i=0; $i<count($later); $i++){
    if ($i==6){
        $put_array = array('Do you have at least child between the ages of 0-18 that lives with you at least 3 days per week?');
        fputcsv ($fp, $put_array);
    }
    else{
        $put_array = array($questions[$i], $pre[$i], $post[$i], $later[$i]);
        fputcsv ($fp, $put_array);
    }
    }
fclose($fp);

?>
         <td class="all_projects" colspan="4">    <a href="<?echo $infile;?>">Download the CSV file of aggregate survey results.</a></td> 
   
    </tr>
    
    
</table>