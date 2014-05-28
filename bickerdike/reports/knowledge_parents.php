<?php

include "../../header.php";
include "../header.php";
include "reports_menu.php";
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
		$('#parents_knowledge_selector').addClass('selected');
	});
</script>

<!--
Shows the average responses to questions about obesity knowledge from surveys
filled out by parents of participants.
-->

<div class="content_wide">
<h3>Report on Obesity Knowledge (Parents)</h3><br/><br/>


<?
/*
 * Get averages for the knowledge questions: pre, post, and later.  We'll use these
 * arrays in the table and to make the line graphs below.
 */
include "../include/dbconnopen.php";
    $get_pre_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('parent', 1)");
    $pre = array();
    while ($pre_averages = mysqli_fetch_array($get_pre_averages)){
        $pre[0] =$pre_averages['AVG(Question_11)'];
        $pre[1] = $pre_averages['AVG(Question_12)'];
        $pre[2] = $pre_averages['AVG(Question_13)'];
    }
    include "../include/dbconnclose.php";
    include "../include/dbconnopen.php";
    $get_post_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('parent', 2)");
    $post = array();
    while ($post_averages = mysqli_fetch_array($get_post_averages)){
        $post[0]  = $post_averages['AVG(Question_11)'];
        $post[1] = $post_averages['AVG(Question_12)'];
        $post[2] = $post_averages['AVG(Question_13)'];
    }
    include "../include/dbconnopen.php";
    $get_later_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('parent', 3)");
    $later = array();
    while ($later_averages = mysqli_fetch_array($get_later_averages)){
        $later[0] = $later_averages['AVG(Question_11)'];
        $later[1] = $later_averages['AVG(Question_12)'];
        $later[2] = $later_averages['AVG(Question_13)'];
    }
    include "../include/dbconnclose.php";
    
?>


<!--
Table of average responses by question
-->


<table class="all_projects">
    <tr>
        <th></th>
        <th colspan="3">Average Responses</th> <!-- would it make sense to do median/mode? -->
    </tr>
        <tr>
        <th>Question</th>
        <th>Pre-Survey<br></th>
        <th>Post-Survey<br></th>
        <th>Three Months Later<br></th>
        
    </tr>
    <tr>
        <td class="all_projects">Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?</td>
        <td class="all_projects"><?echo $pre[0]?></td>
        <td class="all_projects"><?echo $post[0];?></td>
        <td class="all_projects"><?echo $later[0];?></td>
    </tr>
    <tr>
        <td class="all_projects">Are you aware of free or low-cost fitness opportunities in Humboldt Park?</td>
        <td class="all_projects"><?echo $pre[1]?></td>
        <td class="all_projects"><?echo $post[1];?></td>
        <td class="all_projects"><?echo $later[1];?></td>
    </tr>
    <tr>
        <td class="all_projects">Are you aware of free or low-cost nutrition opportunities in Humboldt Park?</td>
        <td class="all_projects"><?echo $pre[2]?></td>
        <td class="all_projects"><?echo $post[2];?></td>
        <td class="all_projects"><?echo $later[2];?></td>
    </tr>
</table>
<br>
        <?php
        
        /*
         * Making the file for downloading this table:
         */
$infile="../data/downloads/obesity_knowledge.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_info = array('Question', 'Pre-Survey', 'Post-Survey', '3 Months Later');
fputcsv ($fp, $title_info);
$questions = array(
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
<a class="download" href="<?echo $infile;?>">Download Obesity Knowledge Report</a>
</div>
<!--
Line graphs use the arrays created above for pre, post, and later responses.
-->

<!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.dateAxisRenderer.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  var data0 = [<?echo $pre[0]?>, <?echo $post[0]?>, <?echo $later[0]?>];
  var plot1 = $.jqplot('chart0',[data0],{
      title: 'Fliers Seen In Community',
        axes: {
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Have Seen Health-advertising Fliers: Yes(1) or No(0)"
        }
        }
  });
   var data = [<?echo $pre[1]?>, <?echo $post[1]?>, <?echo $later[1]?>];
  var plot1 = $.jqplot('chart1',[data],{
      title: 'Aware of Fitness Opportunities',
        axes: {
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Aware of Low-Cost Fitness Opportunities: Yes(1) or No(0)"
        }
        }
  });

  var data4 = [<?echo $pre[2]?>, <?echo $post[2]?>, <?echo $later[2]?>];
  var plot1 = $.jqplot('chart2',[data4],{
      title: 'Aware of Nutrition Opportunities',
        axes: {
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Aware of Low-Cost Nutrition Opportunities: Yes(1) or No(0)"
        }
        }
  });

});
</script>
<div id="chart0" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart1" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart2" style="height: 300px; width: 800px; position: relative;"></div>

<? include "../../footer.php"; ?>