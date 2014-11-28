<?php

include "../../header.php";
include "../header.php";
include "data_menu.php";
?>
<!--This reports on parent surveys. It shows average responses, then includes pie charts for the results.

Note that the live site still has line graphs, not these pie charts yet.  A lot of these Bickerdike reports
are going to change rather drastically.  They asked us to make these pie charts and then never really approved them
going on the live site.
-->


<!--Hide all charts. (again, obviously I didn't understand classes when I built this)-->

<script type="text/javascript">
	$(document).ready(function(){
		$('#chart0_parent').slideUp();
		$('#chart1_parent').slideUp();
		$('#chart2_parent').slideUp();
		$('#chart3_parent').slideUp();
		$('#chart4_parent').slideUp();
		$('#chart5_parent').slideUp();
		$('#chart6_parent').slideUp();
		$('#chart7_parent').slideUp();
		$('#chart8_parent').slideUp();
		$('#chart9_parent').slideUp();
		$('#chart10_parent').slideUp();
		$('#chart11_parent').slideUp();
		$('#chart12_parent').slideUp();
		$('#chart13_parent').slideUp();
        $('#chart14_parent').slideUp();
		$('#chart15_parent').slideUp();
		$('#parents_selector').addClass('selected');
		$('#data_selector').addClass('selected');
	});
</script>

<div class="content_wide" id="participant_survey_data">
<h3>Parent Participant Surveys -- Aggregate Results</h3>
<p align="center">    
    <!--Sort surveys by date.  Sends them off to surveys_sorted_by_dates.php, but only 
    returns the table of averages, no line/pie charts.-->
    
    <?include "../include/datepicker.php";?>
    Filter surveys by date:<br>
    Start date (YYYY-MM-DD): <input type="text" id="start">
    End date (YYYY-MM-DD): <input type="text" id="end"><br>
    <input type="button" value="Submit" onclick="
           $.post(
           'surveys_sorted_by_dates.php',
           {
               start: document.getElementById('start').value,
               end: document.getElementById('end').value,
               type: 'parent'
           },
           function (response){
               document.getElementById('show_search_results').innerHTML = response;
           }
       )">
</p><!--Shows the table of averages here.  The table of averages over all time
    still shows up below.-->
<div id="show_search_results"></div>
<p>
<hr>
</p>
<table class="all_projects">
    <tr>
        <th></th>
        <th colspan="3">Average Responses</th> <!-- would it make sense to do median/mode? -->
    </tr>
    <?
    //count the number of surveys entered for each step
    $count_pres_sqlsafe ="SELECT * FROM Participant_Survey_Responses WHERE Participant_Type='parent' AND Pre_Post_Late='1'";
    include "../include/dbconnopen.php";
    $pres = mysqli_query($cnnBickerdike, $count_pres_sqlsafe);
    $num_pres = mysqli_num_rows($pres);
    include "../include/dbconnclose.php";
    
    $count_posts_sqlsafe ="SELECT * FROM Participant_Survey_Responses WHERE Participant_Type='parent' AND Pre_Post_Late='2'";
    include "../include/dbconnopen.php";
    $posts = mysqli_query($cnnBickerdike, $count_posts_sqlsafe);
    $num_posts = mysqli_num_rows($posts);
    include "../include/dbconnclose.php";
    
    $count_laters_sqlsafe ="SELECT * FROM Participant_Survey_Responses WHERE Participant_Type='parent' AND Pre_Post_Late='3'";
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
    /*the routine gets the average response for each question, as you can see.
    I put the results into a different array because I apparently didn't understand
    mysqli_fetch_array works.  Sigh.*/
    include "../include/dbconnopen.php";
    $get_pre_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('parent', 1)");
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
    include "../include/dbconnopen.php";
    $get_post_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('parent', 2)");
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
    include "../include/dbconnopen.php";
    $get_later_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('parent', 3)");
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
    ?>
    <!-- Begin the table of averages. -->
    <tr>
         <td class="all_projects" style="text-align:left;">Question 1: How important is diet and nutrition to you personally?</td>
         <td class="all_projects"><?echo $pre[0]?></td>
         <td class="all_projects"><?echo $post[0];?></td>
         <td class="all_projects"><?echo $later[0];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 2: How many servings of fruits and vegetables do you eat in an average day?</td>
         <td class="all_projects"><?echo $pre[1]?></td>
         <td class="all_projects"><?echo $post[1];?></td>
         <td class="all_projects"><?echo $later[1];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 3a: How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</td>
         <td class="all_projects"><?echo $pre[2]?></td>
         <td class="all_projects"><?echo $post[2];?></td>
         <td class="all_projects"><?echo $later[2];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 3b: How many minutes on those days?</td>
         <td class="all_projects"><?echo $pre[3]?></td>
         <td class="all_projects"><?echo $post[3];?></td>
         <td class="all_projects"><?echo $later[3];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 4a: How many days per week do you do light or moderate physical activity for at least 10 minutes?</td>
         <td class="all_projects"><?echo $pre[4]?></td>
         <td class="all_projects"><?echo $post[4];?></td>
         <td class="all_projects"><?echo $later[4];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 4b: How many minutes on those moderate activity days?</td>
         <td class="all_projects"><?echo $pre[5]?></td>
         <td class="all_projects"><?echo $post[5];?></td>
         <td class="all_projects"><?echo $later[5];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 6: Yesterday, how many servings of fruits and vegetables did your child have?</td>
         <td class="all_projects"><?echo $pre[7]?></td>
         <td class="all_projects"><?echo $post[7];?></td>
         <td class="all_projects"><?echo $later[7];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 7: On an average day, how many hours and minutes does your child spend in active play?</td>
         <td class="all_projects"><?echo $pre[8]?></td>
         <td class="all_projects"><?echo $post[8];?></td>
         <td class="all_projects"><?echo $later[8];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 8a: Do you agree? I would walk more often if I felt safer in my community.</td>
         <td class="all_projects"><?echo $pre[10]?></td>
         <td class="all_projects"><?echo $post[10];?></td>
         <td class="all_projects"><?echo $later[10];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 8b: Do you agree? I feel comfortable with my child playing outside in my community.</td>
         <td class="all_projects"><?echo $pre[9]?></td>
         <td class="all_projects"><?echo $post[9];?></td>
         <td class="all_projects"><?echo $later[9];?></td>
    </tr>
    
    <tr>
         <td class="all_projects" style="text-align:left;">Question 9: How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?</td>
         <td class="all_projects"><?echo $pre[11]?></td>
         <td class="all_projects"><?echo $post[11];?></td>
         <td class="all_projects"><?echo $later[11];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 10: Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?</td>
         <td class="all_projects"><?echo $pre[12]?></td>
         <td class="all_projects"><?echo $post[12];?></td>
         <td class="all_projects"><?echo $later[12];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 11: Are you aware of free or low-cost fitness opportunities in Humboldt Park?</td>
         <td class="all_projects"><?echo $pre[13]?></td>
         <td class="all_projects"><?echo $post[13];?></td>
         <td class="all_projects"><?echo $later[13];?></td>
    </tr>
    <tr>
         <td class="all_projects" style="text-align:left;">Question 12: Are you aware of free or low-cost nutrition opportunities in Humboldt Park?</td>
         <td class="all_projects"><?echo $pre[14]?></td>
         <td class="all_projects"><?echo $post[14];?></td>
         <td class="all_projects"><?echo $later[14];?></td>
    </tr>
    <!---Now, create the file for download. -->
    
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
</div>
<p></p>
<?
//experimental creations for pie charts:
$question_array=array('Question_2', 'Question_3', 'Question_4_A', 'Question_4_B', 'Question_5_A',
        'Question_5_B', 'Question_6', 'Question_7', 'Question_8', 'Question_9_A', 'Question_9_B',
        'Question_11', 'Question_12', 'Question_13', 'Question_14');
$type_array=array('parent', 'adult', 'youth', 'all');
$assignment_arr=array();
$q2_legend_array=array('No Answer', 'Not at all important', 'Not too important', 'Somewhat important', 'Very important');
$q9_legend_array=array('No Answer', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree');
$q14_legend_array=array('No Answer', 'Not at all satisfied', 'Not too satisfied', 'Somewhat satisfied', 'Very satisfied');
$yn_legend_array=array('No', 'Yes');
$chart_id_array=array('chart1', 'chart1_b', 'chart1_c', 'chart2', 'chart2_b', 'chart2_c', 'chart3', 'chart3_b', 'chart3_c',
        'chart4', 'chart4_b', 'chart4_c', 'chart5', 'chart5_b', 'chart5_c', 'chart6', 'chart6_b', 'chart6_c',
    'chart8', 'chart8_b', 'chart8_c', 'chart9', 'chart9_b', 'chart9_c',
    'chart10', 'chart10_b', 'chart10_c', 'chart11', 'chart11_b', 'chart11_c', 'chart12', 'chart12_b', 'chart12_c',
    'chart13', 'chart13_b', 'chart13_c', 'chart14', 'chart14_b', 'chart14_c', 'chart15', 'chart15_b', 'chart15_c');

        $chart_counter=0;
foreach($question_array as $question_sqlsafe){
        for ($i=1; $i<4; $i++){
            $script_str='';
            /*
             * this routine gets the number of times each response to the question was made.
             * The $question_sqlsafe variable refers to the column of the question being called (so each question
             * will be called in order for us to get each chart below).  Each question is called, 
             * the routine returns the number of times each response was made - so, we have the information
             * for each pie chart.  
             */
               
                $call_for_arrays_sqlsafe="CALL pie_chart_arrays('parent', " . $i . ", '" .$question_sqlsafe . "')";
            include "../include/dbconnopen.php";
          $questions=mysqli_query($cnnBickerdike, $call_for_arrays_sqlsafe);
           /*
           * Now we have to go through some gymnastics to get the returned information into an acceptable
           * form for the jqplot creation.
           */
          
            if (mysqli_num_rows($questions)>0){
            while ($two = mysqli_fetch_row($questions)){
                if($question_sqlsafe!='Question_4_B'&&$question_sqlsafe!='Question_5_B'){
                    /*This is trying to get the assignment array to have the values in order
                     * and not skip any.  Say the answers to the question were 2, 4, and 6 - we
                     * can't have the other possibilities missing from the array, because that
                     * would mess up the x-axis of the chart and would make it hard
                     * for users to interpret.
                     * (this is for the non-minute response questions)
                     */
                    if ($two[1]==0){
                    $assignment_arr[0]=$two[0];
                }
                elseif($two[1]==1){
                    $assignment_arr[1]=$two[0];
                }
                elseif($two[1]==2){
                    $assignment_arr[2]=$two[0];
                }
                elseif($two[1]==3){
                    $assignment_arr[3]=$two[0];
                }
                elseif($two[1]==4){
                    $assignment_arr[4]=$two[0];
                }
                elseif($two[1]==5){
                    $assignment_arr[5]=$two[0];
                }
                elseif($two[1]==6){
                    $assignment_arr[6]=$two[0];
                }
                elseif($two[1]==7){
                    $assignment_arr[7]=$two[0];
                }
                else{
                    $assignment_arr[]=$two[0];
                }}
                else{
                    /*(for number of minutes responses)
                     * Here, we're combining the minutes into quarter-hour increments.
                     * Someone may have said that they exercised 32 minutes per day, but
                     * we're adding that to the count of the 30-45 minute window.
                     */
                    if ($two[1]<=15 && $two[1]!=null){
                        $assignment_arr[0]+=$two[0];
                    }
                    elseif ($two[1]>15 && $two[1]<=30){
                        $assignment_arr[1]+=$two[0];
                    }
                    elseif ($two[1]>30 && $two[1]<=45){
                        $assignment_arr[2]+=$two[0];
                    }
                    elseif ($two[1]>45 && $two[1]<=60){
                        $assignment_arr[3]+=$two[0];
                    }
                    elseif ($two[1]>60 && $two[1]!=null){
                        $assignment_arr[4]+=$two[0];
                    }
                }
            }
             $count_check=0;
             /*
              * we use the assignment array we just created to make strings for the creation of charts.
              */
            foreach($assignment_arr as $key => $value)
                {
               //creates the correct arrays for legends, below
                /*the labels are different for different questions, which is why there is a different
                action for many questions.*/
                    if ($question_sqlsafe=='Question_2'){
                        $script_str.='["' .$key.'-' . $q2_legend_array[$key] .'",'. $value . ']';
                    }
                    elseif($question_sqlsafe=='Question_4_A'||$question_sqlsafe=='Question_5_A'){
                        $script_str.='["' .$key. ' days",'. $value . ']';
                    }
                    elseif($question_sqlsafe=='Question_3'||$question_sqlsafe=='Question_7'){
                        $script_str.='["' .$key. ' servings",'. $value . ']';
                    }
                    elseif($question_sqlsafe=='Question_9_A'||$question_sqlsafe=='Question_9_B'){
                        $script_str.='["' .$key.'-' . $q9_legend_array[$key] .'",'. $value . ']';
                    }
                    elseif($question_sqlsafe=='Question_14'){
                        $script_str.='["' .$key.'-' . $q14_legend_array[$key] .'",'. $value . ']';
                    }
                    elseif($question_sqlsafe=='Question_11'||$question_sqlsafe=='Question_12'|| $question_sqlsafe=='Question_13'||$question_sqlsafe=='Question_6'){
                        $script_str.='["' .$key.'-' . $yn_legend_array[$key] .'",'. $value . ']';
                    }
                    elseif($question_sqlsafe=='Question_4_B'||$question_sqlsafe=='Question_5_B'){
                        if ($key==0){
                            $script_str.='["0-15 minutes",'. $value . ']';
                        }
                        elseif ($key==1){
                            $script_str.='["16-30 minutes",'. $value . ']';
                        }
                        elseif ($key==2){
                            $script_str.='["31-45 minutes",'. $value . ']';
                        }
                        elseif ($key==3){
                            $script_str.='["46-60 minutes",'. $value . ']';
                        }
                        elseif ($key==4){
                            $script_str.='["More than 60 minutes",'. $value . ']';
                        }
                    }
                    else{
                        $script_str.='[' .$key.",". $value . ']';
                    }
                
                    //adds a comma or doesn't  (depending on whether it's the end of the array)
                    if ($count_check==(count($assignment_arr)-1)){
                        $script_str.='';
                    }
                    else{
                        $script_str.= ',';}
                    
                    $count_check++;
                }
                if ($i==1){
                    $time_title='Pre Surveys';
                }
                if ($i==2){
                    $time_title='Post Surveys';
                }
                if ($i==3){
                    $time_title='Follow-up Surveys';
                }
                
                ${$question_sqlsafe.$type.$i}=$script_str;
            $assignment_arr=array();?>
    
<!--Now, the string(s) created by the if/elses above are used to build a chart.
$chart_id_array[$chart_counter] makes sure that the correct information is entered into 
the correct chart.
The $script_str is created by the arrays above.  It's the values and labels that will
go on the chart.
-->
        <script type="text/javascript">
    $(document).ready(function(){
         var plot1 = $.jqplot('<?echo $chart_id_array[$chart_counter];?>',[[<?echo $script_str;?>]],{
      title: '<?echo $time_title;?>',
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      }, 
      series:[
            {label:'(1) Very Important to <br>(4) Not at all Important'}
        ],
        legend: {
            show: true
        }
  });
    })
</script>
    <?$chart_counter++;
                }
        
                else{
                    $chart_counter++;
                }
                 
    }
      
}

?>


<!--All the divs and so on for displaying the pie charts.
-->



<strong><em>Click on a survey question below to view a chart of aggregate results.</em></strong><br/>
<!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<!--<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>-->
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />

<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.jqplot.barRenderer.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pointLabels.min.js"></script>



<!--<a onclick="
	$('#chart0_parent').slideToggle('slow');
"><h4>Change in Reported Importance of Diet and Nutrition</h4></a>
<div id="chart0_parent"><div id="chart0" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div></div>-->

<a onclick="
	$('#chart1_parent').slideToggle('slow');
"><h4>How important is diet and nutrition to you personally?</h4></a>
<div id="chart1_parent"><div id="chart1" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart1_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart1_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>

<a onclick="
	$('#chart2_parent').slideToggle('slow');
	"><h4>How many servings of fruits and vegetables do you eat in an average day?</h4></a>
<div id="chart2_parent"><div id="chart2" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart2_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart2_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div></div>
	
<a onclick="
	$('#chart3_parent').slideToggle('slow');
	"><h4> How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</h4></a>
<div id="chart3_parent"><div id="chart3" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart3_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart3_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	

<a onclick="
	$('#chart4_parent').slideToggle('slow');
	"><h4> How many minutes on those strenuous activity days?s</h4></a>
<div id="chart4_parent"><div id="chart4" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart4_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart4_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	
<a onclick="
	$('#chart5_parent').slideToggle('slow');
	"><h4>How many days per week do you do light or moderate physical activity for at least 10 minutes?</h4></a>
<div id="chart5_parent"><div id="chart5" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart5_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart5_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	
<a onclick="
	$('#chart6_parent').slideToggle('slow');
	"><h4>How many minutes on those moderate activity days?</h4></a>
<div id="chart6_parent"><div id="chart6" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart6_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart6_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	
<a onclick="
	$('#chart8_parent').slideToggle('slow');
	"><h4>Yesterday, how many servings of fruits and vegetables did your child have?</h4></a>
<div id="chart8_parent"><div id="chart8" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart8_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart8_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	
<a onclick="
	$('#chart9_parent').slideToggle('slow');
	"><h4> On an average day, how many hours and minutes does your child spend in active play?</h4></a>
<div id="chart9_parent"><div id="chart9" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart9_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart9_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	
<a onclick="
	$('#chart10_parent').slideToggle('slow');
	"><h4>Do you agree? I would walk more often if I felt safer in my community.</h4></a>
<div id="chart10_parent"><div id="chart10" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
    <div id="chart10_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
    <div id="chart10_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
</div>
	
<a onclick="
	$('#chart11_parent').slideToggle('slow');
	"><h4> Do you agree? I feel comfortable with my child playing outside in my community.</h4></a>
<div id="chart11_parent"><div id="chart11" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart11_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart11_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	
<a onclick="
	$('#chart12_parent').slideToggle('slow');
	"><h4>How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?</h4></a>
<div id="chart12_parent"><div id="chart12" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart12_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart12_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	
<a onclick="
	$('#chart13_parent').slideToggle('slow');
	"><h4>Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?</h4></a>
<div id="chart13_parent"><div id="chart13" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart13_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart13_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	
<a onclick="
	$('#chart14_parent').slideToggle('slow');
	"><h4>Are you aware of free or low-cost fitness opportunities in Humboldt Park?</h4></a>
<div id="chart14_parent"><div id="chart14" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart14_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart14_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>
	
<a onclick="
	$('#chart15_parent').slideToggle('slow');
	"><h4> Are you aware of free or low-cost nutrition opportunities in Humboldt Park?</h4></a>
<div id="chart15_parent"><div id="chart15" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart15_b" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/>
<div id="chart15_c" class="jqplot-target" style="height: 300px; width: 800px; position: relative;"></div><br/></div>




<? include "../../footer.php"; ?>