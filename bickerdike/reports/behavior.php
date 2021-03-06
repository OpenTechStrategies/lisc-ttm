<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id);

include "../../header.php";
include "../header.php";

include "reports_menu.php";
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
		$('#adults_behavior_selector').addClass('selected');
	});
</script>

<!--
choose the baseline year and result type here.  The results show up below.
-->

<div class="content_wide">
<h3>Report on Obesity Behavior</h3><br/><br/>

<form action="behavior.php" method="post">
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







<!--
results from the choices at the top of the page:
-->


<?
//first, check if something has been posted.  If not, none of this is visible.
if (isset($_POST['year'])){
include "../include/dbconnopen.php";
//get average results from the behavior-related questions, and place them into an array.
    $get_pre_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('" . mysqli_real_escape_string($cnnBickerdike, $_POST['type']) . "', 1)");
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
    $get_post_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('" . mysqli_real_escape_string($cnnBickerdike, $_POST['type']) . "', 2)");
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
    $get_later_averages = mysqli_query($cnnBickerdike, "CALL get_aggregate_survey_results('" . mysqli_real_escape_string($cnnBickerdike, $_POST['type']) . "', 3)");
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
        //account for the chosen year (if one is chosen)
        if ($_POST['year'] != 'avg'){
        $query_sqlsafe = "SELECT Question_20_CWS, Question_21_CWS, Question_24_CWS,
            Question_29_CWS, Question_30_CWS, Question_31_CWS, 
            Question_32_CWS, Question_69_CWS, Question_72_CWS,
            Question_91_CWS FROM Community_Wellness_Survey_Aggregates WHERE Community_Wellness_Survey_ID='" . mysqli_real_escape_string($cnnBickerdike, $_POST['year']). "'";
            $get_baseline_averages = mysqli_query($cnnBickerdike, $query_sqlsafe);
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
        }
        //if a baseline year is not chosen, use the average of all entered baseline surveys
        else{
            $query_sqlsafe = "SELECT AVG(Question_20_CWS), AVG(Question_21_CWS), AVG(Question_24_CWS),
            AVG(Question_29_CWS), AVG(Question_30_CWS), AVG(Question_31_CWS), 
            AVG(Question_32_CWS), AVG(Question_69_CWS), AVG(Question_72_CWS),
            AVG(Question_91_CWS) FROM Community_Wellness_Survey_Aggregates";
            $get_baseline_averages = mysqli_query($cnnBickerdike, $query_sqlsafe);
            $baseline = array();
            while ($baseline_averages = mysqli_fetch_array($get_baseline_averages)){
                $baseline[0] =$baseline_averages['AVG(Question_20_CWS)']+$baseline_averages['AVG(Question_21_CWS)']+$baseline_averages['AVG(Question_24_CWS)'];
                $baseline[1] = $baseline_averages['AVG(Question_29_CWS)'];
                $baseline[2] = 30*($baseline_averages['AVG(Question_30_CWS)']);
                $baseline[3] = $baseline_averages['AVG(Question_31_CWS)'];
                $baseline[4] = 30*$baseline_averages['AVG(Question_32_CWS)'];
                $baseline[5] =$baseline_averages['AVG(Question_69_CWS)']+$baseline_averages['AVG(Question_72_CWS)'];
                $baseline[6] = $baseline_averages['AVG(Question_91_CWS)'];
            }
        }
    
    include "../include/dbconnclose.php";
?>
<h4><?
//this is the creation of the title.  shows the baseline (either aggregate or a year)
//and then the type of participant shown (adult, parent, youth)
if ($_POST['year']=='avg'){
    echo "Aggregate Baseline";
}
else{
include "../include/dbconnopen.php";
$get_year_sqlsafe = "SELECT Date_Administered FROM Community_Wellness_Survey_Aggregates WHERE Community_Wellness_Survey_ID='" . mysqli_real_escape_string($cnnBickerdike, $_POST['year']) . "'";
//echo $get_year_sqlsafe;
$year = mysqli_query($cnnBickerdike, $get_year_sqlsafe);
$yr = mysqli_fetch_row($year);
echo $yr[0];
include "../include/dbconnclose.php";
}
?>: <?if ($_POST['type']=='adult'){echo 'Adults';}elseif($_POST['type']=='parent'){echo 'Parents';} elseif($_POST['type']=='youth'){echo 'Youth';}?></h4>

<!--
Now show the actual table of results
-->
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

<!--Put results in a file for download
-->

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

<!--
Create the line graphs that show the change over time in average responses to these
questions.
The graphs use the arrays that were created above.
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
<?}?>


<? include "../../footer.php"; ?>