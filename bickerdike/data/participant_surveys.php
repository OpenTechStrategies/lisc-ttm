<?php

include "../../header.php";
include "../header.php";
include "data_menu.php";
include "../include/datepicker.php";
?>

<!--This file is no longer relevant.  It isn't linked from anywhere.  I'm going to skip commenting it.
It simply reports on the survey responses.
-->

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
	});
</script>

<div class="content_wide" id="participant_survey_data">
<h3>Parent Participant Surveys -- Aggregate Results</h3>
<p align="center">
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
</p>
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
    
    //$limit=0;
    ?>
<!--        <a href="">Reset Aggregates</a>-->
    <tr>
        
        <th width="65%">Question</th>
        <th>Pre-Survey<br>(<?echo $num_pres?> surveys)</th>
        <th>Post-Survey<br>(<?echo $num_posts?> surveys)</th>
        <th>Three Months Later<br>(<?echo $num_laters?> surveys)</th>
    </tr>
    <?
    
    //call the routine for pre, post, and later
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
<p></p>
<strong><em>Click on a survey question below to view a chart of aggregate results.</em></strong><br/>

<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.dateAxisRenderer.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    var data = [<?echo $pre[0]?>, <?echo $post[0]?>, <?echo $later[0]?>];
    var data1 = [<?echo $pre[1]?>, <?echo $post[1]?>, <?echo $later[1]?>];
    var data2 = [<?echo $pre[2]?>, <?echo $post[2]?>, <?echo $later[2]?>];
    var data3 = [<?echo $pre[3]?>, <?echo $post[3]?>, <?echo $later[3]?>];
    var data4 = [<?echo $pre[4]?>, <?echo $post[4]?>, <?echo $later[4]?>];
    var data5 = [<?echo $pre[5]?>, <?echo $post[5]?>, <?echo $later[5]?>];
    var data6 = [<?echo $pre[6]?>, <?echo $post[6]?>, <?echo $later[6]?>];
    var data7 = [<?echo $pre[7]?>, <?echo $post[7]?>, <?echo $later[7]?>];
    var data8 = [<?echo $pre[8]?>, <?echo $post[8]?>, <?echo $later[8]?>];
    var data9 = [<?echo $pre[9]?>, <?echo $post[9]?>, <?echo $later[9]?>];
    var data10 = [<?echo $pre[10]?>, <?echo $post[10]?>, <?echo $later[10]?>];
    var data11= [<?echo $pre[11]?>, <?echo $post[11]?>, <?echo $later[11]?>];
    var data12= [<?echo $pre[12]?>, <?echo $post[12]?>, <?echo $later[12]?>];
    var data13 = [<?echo $pre[13]?>, <?echo $post[13]?>, <?echo $later[13]?>];
    document.getElementById('show_plot_point_array').innerHTML = data;
  var plot1 = $.jqplot('chart0',[data, data1, data2, data3, data4, data5, data6, data7, data8, data9, data10, data11, data12, data13],{
      //title: 'Change in Reported Importance of Diet and Nutrition'
  });
});

</script>
<a onclick="
	$('#chart0_parent').slideToggle('slow');
"><h4>Change in Reported Importance of Diet and Nutrition</h4></a>
<div id="chart0_parent"><div id="chart0" style="position: relative;" class="jqplot-target"></div></div>
<div id="show_plot_point_array"></div>

<script type="text/javascript">
$(document).ready(function(){
    var data = [<?echo $pre[0]?>, <?echo $post[0]?>, <?echo $later[0]?>];
    document.getElementById('show_plot_point_array').innerHTML = data;
  var plot1 = $.jqplot('chart1',[data],{
      //title: 'Change in Reported Importance of Diet and Nutrition'
  });
});

</script>

<a onclick="
	$('#chart1_parent').slideToggle('slow');
"><h4>Change in Reported Importance of Diet and Nutrition</h4></a>
<div id="chart1_parent"><div id="chart1" style="position: relative;" class="jqplot-target"></div></div>
<div id="show_plot_point_array"></div>

<script type="text/javascript">
$(document).ready(function(){
    var data = [<?echo $pre[1]?>, <?echo $post[1]?>, <?echo $later[1]?>];
    document.getElementById('show_plot_point_array').innerHTML = data;
  var plot1 = $.jqplot('chart2',[data],{
      //title: 'Servings of Fruits and Vegetables Reported Per Day'
  });
});

</script>

<a onclick="
	$('#chart2_parent').slideToggle('slow');
	"><h4>Servings of Fruits and Vegetables Reported Per Day</h4></a>
<div id="chart2_parent"><div id="chart2" style="position: relative;" class="jqplot-target"></div></div>
<div id="show_plot_point_array"></div>

<script type="text/javascript">
$(document).ready(function(){
    var data = [<?echo $pre[2]?>, <?echo $post[2]?>, <?echo $later[2]?>];
    document.getElementById('show_plot_point_array').innerHTML = data;
  var plot1 = $.jqplot('chart3',[data],{
      //title: 'Number of Days per Week with Strenuous Physical Activity'
  });
});
</script>

<a onclick="
	$('#chart3_parent').slideToggle('slow');
	"><h4>Number of Days per Week with Strenuous Physical Activity</h4></a>
<div id="chart3_parent"><div id="chart3" style="position: relative;" class="jqplot-target"></div></div>
<div id="show_plot_point_array"></div>

<script type="text/javascript">
$(document).ready(function(){
    var data = [<?echo $pre[3]?>, <?echo $post[3]?>, <?echo $later[3]?>];
    document.getElementById('show_plot_point_array').innerHTML = data;
  var plot1 = $.jqplot('chart4',[data],{
      //title: 'Minutes of Strenuous Activity on Above Days'
  });
  var data4 = [<?echo $pre[4]?>, <?echo $post[4]?>, <?echo $later[4]?>];
  var plot1 = $.jqplot('chart5',[data4],{
      //title: 'Number of Days per Week with Moderate Physical Activity'
  });
  var data5 = [<?echo $pre[5]?>, <?echo $post[5]?>, <?echo $later[5]?>];
  var plot1 = $.jqplot('chart6',[data5],{
      //title: 'Minutes of Moderate Activity on Above Days'
  });
//  var data6 = [<?echo $pre[6]?>, <?echo $post[6]?>, <?echo $later[6]?>];
//  var plot1 = $.jqplot('chart7',[data6],{
//      title: 'Child Fruit and Vegetable Servings'
//  });
  var data7 = [<?echo $pre[7]?>, <?echo $post[7]?>, <?echo $later[7]?>];
  var plot1 = $.jqplot('chart8',[data7],{
      //title: 'Child Fruit and Vegetable Servings'
  });
  var data8 = [<?echo $pre[8]?>, <?echo $post[8]?>, <?echo $later[8]?>];
  var plot1 = $.jqplot('chart9',[data8],{
      //title: 'Child Activity in Minutes'
  });
  var data9 = [<?echo $pre[9]?>, <?echo $post[9]?>, <?echo $later[9]?>];
  var plot1 = $.jqplot('chart10',[data9],{
      //title: 'Would Walk More if Community was Safer'
  });
  var data10 = [<?echo $pre[10]?>, <?echo $post[10]?>, <?echo $later[10]?>];
  var plot1 = $.jqplot('chart11',[data10],{
      //title: 'Feel Comfortable with Child Playing Outside'
  });
  var data11 = [<?echo $pre[11]?>, <?echo $post[11]?>, <?echo $later[11]?>];
  var plot1 = $.jqplot('chart12',[data11],{
      //title: 'Satisfied with Fruit and Vegetable Selection'
  });
  var data12 = [<?echo $pre[12]?>, <?echo $post[12]?>, <?echo $later[12]?>];
  var plot1 = $.jqplot('chart13',[data12],{
      //title: 'Flyer Sightings'
  });
  var data13 = [<?echo $pre[13]?>, <?echo $post[13]?>, <?echo $later[13]?>];
  var plot1 = $.jqplot('chart14',[data13],{
      //title: 'Free/Low-Cost Fitness Awareness'
  });
  var data14 = [<?echo $pre[14]?>, <?echo $post[14]?>, <?echo $later[14]?>];
  var plot1 = $.jqplot('chart15',[data14],{
      //title: 'Free/Low-Cost Nutrition Awareness'
  });
});

</script>
<a onclick="
	$('#chart4_parent').slideToggle('slow');
	"><h4>Minutes of Strenuous Activity on Above Days</h4></a>
<div id="chart4_parent"><div id="chart4" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart5_parent').slideToggle('slow');
	"><h4>Number of Days per Week with Moderate Physical Activity</h4></a>
<div id="chart5_parent"><div id="chart5" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart6_parent').slideToggle('slow');
	"><h4>Minutes of Moderate Activity on Above Days</h4></a>
<div id="chart6_parent"><div id="chart6" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart8_parent').slideToggle('slow');
	"><h4>Child Fruit and Vegetable Servings</h4></a>
<div id="chart8_parent"><div id="chart8" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart9_parent').slideToggle('slow');
	"><h4>Child Activity in Minutes</h4></a>
<div id="chart9_parent"><div id="chart9" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart10_parent').slideToggle('slow');
	"><h4>Would Walk More if Community was Safer</h4></a>
<div id="chart10_parent"><div id="chart10" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart11_parent').slideToggle('slow');
	"><h4>Feel Comfortable with Child Playing Outside</h4></a>
<div id="chart11_parent"><div id="chart11" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart12_parent').slideToggle('slow');
	"><h4>Satisfied with Fruit and Vegetable Selection</h4></a>
<div id="chart12_parent"><div id="chart12" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart13_parent').slideToggle('slow');
	"><h4>Flyer Sightings</h4></a>
<div id="chart13_parent"><div id="chart13" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart14_parent').slideToggle('slow');
	"><h4>Free/Low-Cost Fitness Awareness</h4></a>
<div id="chart14_parent"><div id="chart14" style="position: relative;" class="jqplot-target"></div></div>

<a onclick="
	$('#chart15_parent').slideToggle('slow');
	"><h4>Free/Low-Cost Nutrition Awareness</h4></a>
<div id="chart15_parent"><div id="chart15" style="position: relative;" class="jqplot-target"></div></div>


</div>

<? include "../../footer.php"; ?>