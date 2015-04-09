<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);


include "../../header.php";
include "../header.php";
include "../reports/reports_menu.php";
?>

<!--
Weirdly, this is the attitude report that shows up here: http://dev.lisc.chapinhall.org/bickerdike/reports/attitude.php
Not sure what it (or a copy of it) is doing in /ajax/.  I'll leave it for now.

-->


<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
		$('#adults_attitude_selector').addClass('selected');
	});
</script>

<div class="content_wide">
<h3>Report on Obesity Attitude</h3><br/><br/>
<form action="../ajax/attitude_report.php" method="post">
Choose baseline year:
<select name="year" id="baseline_year">
    <option value="">-----</option>
    <?
    include "../include/dbconnopen.php";
    $get_baseline_averages = mysqli_query($cnnBickerdike, "SELECT * FROM Community_Wellness_Survey_Aggregates");
    while ($baseline_averages = mysqli_fetch_array($get_baseline_averages)){
        ?><option value="<?echo $baseline_averages['Community_Wellness_Survey_ID'];?>"><?echo $baseline_averages['Date_Administered'];?></option><?
    }
    ?>
        <option value="avg">Aggregate Baseline</option>
</select><br>
Choose adult, parent, or youth results:
<select name="type" id="select_type">
    <option value="">-----</option>
    <option value="adult">Adults</option>
    <option value="parent">Parents</option>
    <option value="youth">Youth</option>
</select><br>
<input type="submit" value="OK">
</form>
<?

include "../include/dbconnopen.php";
$type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
    $get_pre_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('" . $type_sqlsafe . "', 1)");
    $pre = array();
    while ($pre_averages = mysqli_fetch_array($get_pre_averages)){
        $pre[0] =$pre_averages['AVG(Question_2)'];
        $pre[1] = $pre_averages['AVG(Question_9_A)'];
        $pre[2] = $pre_averages['AVG(Question_9_B)'];
    }
    include "../include/dbconnclose.php";
    include "../include/dbconnopen.php";
    $get_post_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('" . $type_sqlsafe ."', 2)");
    $post = array();
    while ($post_averages = mysqli_fetch_array($get_post_averages)){
        $post[0]  = $post_averages['AVG(Question_2)'];
        $post[1] = $post_averages['AVG(Question_9_A)'];
        $post[2] = $post_averages['AVG(Question_9_B)'];
    }
    include "../include/dbconnopen.php";
    $get_later_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('" . $type_sqlsafe ."', 3)");
    $later = array();
    while ($later_averages = mysqli_fetch_array($get_later_averages)){
        $later[0] = $later_averages['AVG(Question_2)'];
        $later[1] = $later_averages['AVG(Question_9_A)'];
        $later[2] = $later_averages['AVG(Question_9_B)'];
    }
    include "../include/dbconnclose.php";
        include "../include/dbconnopen.php";
        $year_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['year']);
        if ($_POST['year'] != 'avg'){
        $query_sqlsafe = "SELECT Question_15_CWS, Question_41_a_CWS, Question_41_b_CWS FROM Community_Wellness_Survey_Aggregates WHERE Community_Wellness_Survey_ID='" . $year_sqlsafe. "'";
        }
        else{
            $query_sqlsafe = "SELECT AVG(Question_15_CWS), AVG(Question_41_a_CWS), AVG(Question_41_b_CWS) FROM Community_Wellness_Survey_Aggregates";
        }
    $get_baseline_averages = mysqli_query($cnnBickerdike, $query_sqlsafe);
    $baseline = array();
    while ($baseline_averages = mysqli_fetch_row($get_baseline_averages)){
        $baseline[0] =$baseline_averages[0];
        $baseline[1] = $baseline_averages[1];
        $baseline[2] = $baseline_averages[2];
    }
    include "../include/dbconnclose.php";
?>
<h4><?
if ($_POST['year']=='avg'){
    echo "Aggregate Baseline";
}
else{
$get_year_sqlsafe = "SELECT Date_Administered FROM Community_Wellness_Survey_Aggregates WHERE Community_Wellness_Survey_ID='" . $year_sqlsafe . "'";
include "../include/dbconnopen.php";
$year = mysqli_query($cnnBickerdike, $get_year_sqlsafe);
$yr = mysqli_fetch_row($year);
echo $yr[0];
include "../include/dbconnclose.php";
}
?>: <?if ($_POST['type']=='adult'){echo 'Adults';}elseif($_POST['type']=='parent'){echo 'Parents';} elseif($_POST['type']=='youth'){echo 'Youth';}?></h4>


<table class="all_projects">
    <tr>
        <th></th>
        <th colspan="4">Average Responses</th> <!-- would it make sense to do median/mode? -->
    </tr>
        <tr>
        <th>Question</th>
        <th>Pre-Survey<br></th>
        <th>Post-Survey<br></th>
        <th>Three Months Later<br></th>
        <th>Baseline Result (CWS)</th>
    </tr>
    <tr>
         <td class="all_projects">How important is diet and nutrition to you personally?</td>
         <td class="all_projects"><?echo $pre[0]?></td>
         <td class="all_projects"><?echo $post[0];?></td>
         <td class="all_projects"><?echo $later[0];?></td>
         <td class="all_projects"><?echo $baseline[0];?></td>
    </tr>
    <tr>
         <td class="all_projects">Do you agree? I would walk more often if I felt safer in my community.</td>
         <td class="all_projects"><?echo $pre[1]?></td>
         <td class="all_projects"><?echo $post[1];?></td>
         <td class="all_projects"><?echo $later[1];?></td>
         <td class="all_projects"><?echo $baseline[1];?></td>
    </tr>
    <tr>
         <td class="all_projects">Do you agree? I feel comfortable with my child playing outside in my community.</td>
         <td class="all_projects"><?echo $pre[2]?></td>
         <td class="all_projects"><?echo $post[2];?></td>
         <td class="all_projects"><?echo $later[2];?></td>
         <td class="all_projects"><?echo $baseline[2];?></td>
    </tr>
</table>

<br>
        <?php
$infile="../data/downloads/obesity_attitude.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_info = array('Question', 'Pre-Survey', 'Post-Survey', '3 Months Later');
fputcsv ($fp, $title_info);
$questions = array(
    'How important is diet and nutrition to you personally?',
    'Do you agree? I would walk more often if I felt safer in my community.',
    'Do you agree? I feel comfortable with my child playing outside in my community.'
);
for ($i=0; $i<count($later); $i++){
    
        $put_array = array($questions[$i], $pre[$i], $post[$i], $later[$i]);
        fputcsv ($fp, $put_array);
    
    }
fclose($fp);

?>
<a class="download" href="<?echo $infile;?>">Download Obesity Attitude Report</a>
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
      title: 'Diet and Nutrition Importance',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Very Important(1) to Not At All Important(4)"
        }
        }
  });
   var data = [<?echo $pre[1]?>, <?echo $post[1]?>, <?echo $later[1]?>];
  var baseline1 = [<?echo $baseline[1];?>, <?echo $baseline[1];?>, <?echo $baseline[1];?>];
  var plot1 = $.jqplot('chart1',[data, baseline1],{
      title: 'Perception of Personal Safety',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Strongly Agree(1) to Strongly Disagree(4)"
        }
        }
  });

  var data4 = [<?echo $pre[2]?>, <?echo $post[2]?>, <?echo $later[2]?>];
  var baseline2 = [<?echo $baseline[2];?>, <?echo $baseline[2];?>, <?echo $baseline[2];?>];
  var plot1 = $.jqplot('chart2',[data4, baseline2],{
      title: 'Perception of Child\'s Safety',
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Strongly Agree(1) to Strongly Disagree(4)"
        }
        }
});
});
</script>
<div id="chart0" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart1" style="height: 300px; width: 800px; position: relative;"></div><br>
<div id="chart2" style="height: 300px; width: 800px; position: relative;"></div>

