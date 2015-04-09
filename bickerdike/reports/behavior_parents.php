<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id);

include "../../header.php";
include "../header.php";

include "reports_menu.php";
?>

<!--
Since results for all kinds of people are now shown in behavior.php, I believe that this file is irrelevant
and obsolete.
-->

<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
		$('#parents_behavior_selector').addClass('selected');
	});
</script>

<div class="content_wide">
<h3>Report on Obesity Behavior (Parents)</h3><br/><br/>


<?
include "../include/dbconnopen.php";
    $get_pre_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('parent', 1)");
    $pre = array();
    while ($pre_averages = mysqli_fetch_array($get_pre_averages)){
        $pre[0] =$pre_averages['AVG(Question_3)'];
        $pre[1] = $pre_averages['AVG(Question_4_A)'];
        $pre[2] = $pre_averages['AVG(Question_4_B)'];
        $pre[3] = $pre_averages['AVG(Question_5_A)'];
        $pre[4] = $pre_averages['AVG(Question_5_B)'];
        $pre[5] =$pre_averages['AVG(Question_7)'];
        $pre[6] = $pre_averages['AVG(Question_8)'];
    }
    include "../include/dbconnclose.php";
    include "../include/dbconnopen.php";
    $get_post_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('parent', 2)");
    $post = array();
    while ($post_averages = mysqli_fetch_array($get_post_averages)){
        $post[0] =$post_averages['AVG(Question_3)'];
        $post[1] = $post_averages['AVG(Question_4_A)'];
        $post[2] = $post_averages['AVG(Question_4_B)'];
        $post[3] = $post_averages['AVG(Question_5_A)'];
        $post[4] = $post_averages['AVG(Question_5_B)'];
        $post[5] =$post_averages['AVG(Question_7)'];
        $post[6] = $post_averages['AVG(Question_8)'];
    }
    include "../include/dbconnopen.php";
    $get_later_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('parent', 3)");
    $later = array();
    while ($later_averages = mysqli_fetch_array($get_later_averages)){
        $later[0] =$later_averages['AVG(Question_3)'];
        $later[1] = $later_averages['AVG(Question_4_A)'];
        $later[2] = $later_averages['AVG(Question_4_B)'];
        $later[3] = $later_averages['AVG(Question_5_A)'];
        $later[4] = $later_averages['AVG(Question_5_B)'];
        $later[5] =$later_averages['AVG(Question_7)'];
        $later[6] = $later_averages['AVG(Question_8)'];
    }
    include "../include/dbconnclose.php";
        include "../include/dbconnopen.php";
    $get_baseline_averages = mysqli_query($cnnBickerdike, "SELECT * FROM Community_Wellness_Survey_Aggregates");
    $baseline = array();
    while ($baseline_averages = mysqli_fetch_array($get_baseline_averages)){
        $baseline[0] =$baseline_averages['Question_20_CWS']+$baseline_averages['Question_21_CWS']+$baseline_averages['Question_24_CWS'];
        $baseline[1] = $baseline_averages['Question_29_CWS'];
        $baseline[2] = 30*($baseline_averages['Question_30_CWS']);
        $baseline[3] = $baseline_averages['Question_31_CWS'];
        $baseline[4] = 30*$baseline_averages['Question_32_CWS'];
        $baseline[5] =$baseline_averages['Question_69_CWS']+$baseline_averages['Question_72_CWS'];
        $baseline[6] = $baseline_averages['Question_91_CWS'];
    }
    include "../include/dbconnclose.php";
?>


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
        <th>Baseline Result (CWS)</th>
    </tr>
    <tr>
         <td class="all_projects">How many servings of fruits and vegetables do you eat in an average day?</td>
         <td class="all_projects"><?echo $pre[0]?></td>
         <td class="all_projects"><?echo $post[0];?></td>
         <td class="all_projects"><?echo $later[0];?></td>
         <td class="all_projects"><?echo $baseline[0];?></td>
    </tr>
    <tr>
         <td class="all_projects">How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</td>
         <td class="all_projects"><?echo $pre[1]?></td>
         <td class="all_projects"><?echo $post[1];?></td>
         <td class="all_projects"><?echo $later[1];?></td>
         <td class="all_projects"><?echo $baseline[1];?></td>
    </tr>
    <tr>
         <td class="all_projects">How many minutes on those days?</td>
         <td class="all_projects"><?echo $pre[2]?></td>
         <td class="all_projects"><?echo $post[2];?></td>
         <td class="all_projects"><?echo $later[2];?></td>
         <td class="all_projects"><?echo $baseline[2];?></td>
    </tr>
    <tr>
         <td class="all_projects">How many days per week do you do light or moderate physical activity for at least 10 minutes?</td>
         <td class="all_projects"><?echo $pre[3]?></td>
         <td class="all_projects"><?echo $post[3];?></td>
         <td class="all_projects"><?echo $later[3];?></td>
         <td class="all_projects"><?echo $baseline[3];?></td>
    </tr>
    <tr>
         <td class="all_projects">How many minutes on those moderate activity days?</td>
         <td class="all_projects"><?echo $pre[4]?></td>
         <td class="all_projects"><?echo $post[4];?></td>
         <td class="all_projects"><?echo $later[4];?></td>
         <td class="all_projects"><?echo $baseline[4];?></td>
    </tr>
    <tr>
         <td class="all_projects">Yesterday, how many servings of fruits and vegetables did your child have?</td>
         <td class="all_projects"><?echo $pre[5]?></td>
         <td class="all_projects"><?echo $post[5];?></td>
         <td class="all_projects"><?echo $later[5];?></td>
         <td class="all_projects"><?echo $baseline[5];?></td>
    </tr>
    <tr>
         <td class="all_projects">On an average day, how many hours and minutes does your child spend in active play?</td>
         <td class="all_projects"><?echo $pre[6]?></td>
         <td class="all_projects"><?echo $post[6];?></td>
         <td class="all_projects"><?echo $later[6];?></td>
         <td class="all_projects"><?echo $baseline[6];?></td>
    </tr>
</table>
<br>

        <?php
$infile="../data/downloads/behavior_report.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_info = array('Question', 'Pre-Survey', 'Post-Survey', '3 Months Later', 'Baseline (CWS)');
fputcsv ($fp, $title_info);
$questions = array(
    'How many servings of fruits and vegetables do you eat in an average day?',
    'How many days per week do you do strenuous physical activity for at least 10 minutes at a time?',
    'How many minutes on those days?',
    'How many days per week do you do light or moderate physical activity for at least 10 minutes?',
    'How many minutes on those moderate activity days?',
    'Yesterday, how many servings of fruits and vegetables did your child have?',
    'On an average day, how many hours and minutes does your child spend in active play?'
);
for ($i=0; $i<count($later); $i++){
    
        $put_array = array($questions[$i], $pre[$i], $post[$i], $later[$i], $baseline[$i]);
        fputcsv ($fp, $put_array);
    
    }
fclose($fp);

?>
<a class="download" href="<?echo $infile;?>">Download Obesity Behavior Report</a>
</div>
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
  var baseline0 = [<?echo $baseline[0];?>, <?echo $baseline[0];?>, <?echo $baseline[0];?>];
  var plot1 = $.jqplot('chart0',[data0, baseline0],{
      title: 'Servings of Fruits and Vegetables Reported Per Day',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Servings of Fruits and Vegetables Reported"
        }
        }
  });
   var data = [<?echo $pre[1]?>, <?echo $post[1]?>, <?echo $later[1]?>];
  var baseline1 = [<?echo $baseline[1];?>, <?echo $baseline[1];?>, <?echo $baseline[1];?>];
  var plot1 = $.jqplot('chart1',[data, baseline1],{
      title: 'Strenuous Activity, Days Per Week',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Days of the Week with Reported Strenuous Activity"
        }
        }
  });

  var data4 = [<?echo $pre[2]?>, <?echo $post[2]?>, <?echo $later[2]?>];
  var baseline2 = [<?echo $baseline[2];?>, <?echo $baseline[2];?>, <?echo $baseline[2];?>];
  var plot1 = $.jqplot('chart2',[data4, baseline2],{
      title: 'Strenuous Activity, Minutes Per Day',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Minutes Reported of Strenuous Activity (on above days)"
        }
        }
  });
  var data3 = [<?echo $pre[3]?>, <?echo $post[3]?>, <?echo $later[3]?>];
  var baseline3 = [<?echo $baseline[3];?>, <?echo $baseline[3];?>, <?echo $baseline[3];?>];
  var plot1 = $.jqplot('chart3',[data3, baseline3],{
      title: 'Moderate Activity, Days Per Week',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Days of the Week with Reported Moderate Activity"
        }
        }
  });
  var data6 = [<?echo $pre[4]?>, <?echo $post[4]?>, <?echo $later[4]?>];
  var baseline4 = [<?echo $baseline[4];?>, <?echo $baseline[4];?>, <?echo $baseline[4];?>];
  var plot1 = $.jqplot('chart4',[data6, baseline4],{
      title: 'Moderate Activity, Minutes Per Week',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Minutes of Reported Moderate Activity (on above days)"
        }
        }
  });
  var data5 = [<?echo $pre[5]?>, <?echo $post[5]?>, <?echo $later[5]?>];
  var baseline5 = [<?echo $baseline[5];?>, <?echo $baseline[5];?>, <?echo $baseline[5];?>];
  var plot1 = $.jqplot('chart5',[data5, baseline5],{
      title: 'Child Fruit and Vegetable Servings',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Reported Servings of Fruit and Vegetables, for Child"
        }
        }
});
  var data7 = [<?echo $pre[6]?>, <?echo $post[6]?>, <?echo $later[6]?>];
  var baseline6 = [<?echo $baseline[6];?>, <?echo $baseline[6];?>, <?echo $baseline[6];?>];
  var plot1 = $.jqplot('chart6',[data7, baseline6],{
      title: 'Child Time, Active Play',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Child's Active Play: Average Minutes per Day"
        }
        }
});
});
</script>
<div id="chart0" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart1" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart2" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart3" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart4" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart5" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart6" style="height: 300px; width: 800px; position: relative;"></div><br>

<? include "../../footer.php"; ?>