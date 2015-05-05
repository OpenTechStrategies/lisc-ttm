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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($Bickerdike_id);

include "../../header.php";
include "../header.php";
?>

<!--
Much like the corner store report, this shows a table of responses and then those 
responses in pie charts.
Again, the "Number" is the number of intersections assessed where the statement is true.
-->		

<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
		$("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});
	});

</script>


<div class="content_wide">
<h3>Walkability Report</h3><hr/><br/>
<div id="corner_store_stats">
<?
$count_walks_sqlsafe = "SELECT * FROM Walkability_Assessment";
include "../include/dbconnopen.php";
$count = mysqli_query($cnnBickerdike, $count_walks_sqlsafe);
$num_walks = mysqli_num_rows($count);
include "../include/dbconnclose.php";
?>

<strong>Number of intersections evaluated: <?echo $num_walks;?></strong>
<a class="add_new" href="add_walkability.php" style="float:right; font-size:.8em;"><span class="add_new_button">Add a new Walkability Assessment</span></a>
<br/>

<table>
    <tr>
        <th>Measure</th>
        <th>Number</th>
        <th>Percent</th>
    </tr>
    <tr>
        <td>Cars stop at stop signs</td>
        <td>
            <?
$count_walks_sqlsafe = "SELECT * FROM Walkability_Assessment WHERE Cars_Stop='1'";
include "../include/dbconnopen.php";
$count = mysqli_query($cnnBickerdike, $count_walks_sqlsafe);
$num_stops = mysqli_num_rows($count);
include "../include/dbconnclose.php";
echo $num_stops;
?>
        </td>
        <td>
            <?$pct_stops = $num_stops/$num_walks;
            echo round($pct_stops*100) . "%";?>
        </td>
    </tr>
    <tr>
        <td>Crosswalks are painted and clearly visible</td>
        <td>
            <?
$count_walks_sqlsafe = "SELECT * FROM Walkability_Assessment WHERE Crosswalk_Painted='1'";
include "../include/dbconnopen.php";
$count = mysqli_query($cnnBickerdike, $count_walks_sqlsafe);
$num_crosswalks = mysqli_num_rows($count);
include "../include/dbconnclose.php";
echo $num_crosswalks;
?>
        </td>
        <td>
            <?$pct_crosswalks = $num_crosswalks/$num_walks;
            echo round($pct_crosswalks*100) . "%";?>
        </td>
    </tr>
    <tr>
        <td>Cars are perceived to be obeying posted speed limits</td>
        <td>
            <?
$count_walks_sqlsafe = "SELECT * FROM Walkability_Assessment WHERE Speed_Limit_Obeyed='1'";
include "../include/dbconnopen.php";
$count = mysqli_query($cnnBickerdike, $count_walks_sqlsafe);
$num_speed = mysqli_num_rows($count);
include "../include/dbconnclose.php";
echo $num_speed;
?>
        </td>
        <td>
            <?$pct_speed = $num_speed/$num_walks;
            echo round($pct_speed*100) . "%";?>
        </td>
    </tr>
    <tr>
        <td>Sidewalk continues all the way down the block without gaps</td>
        <td>
            <?
$count_walks_sqlsafe = "SELECT * FROM Walkability_Assessment WHERE No_Gaps_In_Sidewalk='1'";
include "../include/dbconnopen.php";
$count = mysqli_query($cnnBickerdike, $count_walks_sqlsafe);
$num_no_gaps = mysqli_num_rows($count);
include "../include/dbconnclose.php";
echo $num_no_gaps;
?>
        </td>
        <td>
            <?$pct_no_gaps = $num_no_gaps/$num_walks;
            echo round($pct_no_gaps*100) . "%";?>
        </td>
    </tr>
    
    <!--
    Creating the download file
    -->
    
    <?
$infile="../data/downloads/walkability_report.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Measure", "Number", "Percent");
fputcsv($fp, $title_array);
$fruit = array('Cars stop at stop signs', $num_stops, round($pct_stops*100));
$milk = array('Crosswalks are painted and clearly visible', $num_crosswalks, round($pct_crosswalks*100));
$signs=array('Cars are perceived to be obeying posted speed limits', $num_speed, round($pct_speed*100));
$stock=array('Sidewalk continues all the way down the block without gaps', $num_no_gaps, round($pct_no_gaps*100));
fputcsv ($fp, $fruit);
fputcsv($fp, $milk);
fputcsv($fp, $signs);
fputcsv($fp, $stock);
fclose($fp);
?>
    <br>
       <tr> <td>   <br/> <a class="download" href="<?echo $infile;?>">Download the CSV file of this walkability report.</a></td>    </tr>
</table><br/>
</div>
</div>

<!--
Creating pie charts, much like the corner store assessment reports.

See jqplot docs for more detailed information.
-->


<!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pieRenderer.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){
    var data0=[[1, 2], [3, 4]]
  var data = [
    ['Cars Stop at Stop Signs', <?echo round($pct_stops*100)?>], ['Cars Run Stop Signs', (<?echo 100-round($pct_stops*100)?>)]
  ];
  var data2 = [
    ['Crosswalks are Painted', <?echo round($pct_crosswalks*100)?>], ['Crosswalks are Not Painted', (<?echo 100-round($pct_crosswalks*100)?>)]
  ];
  var data3 = [
    ['Cars Obey the Speed Limit', <?echo round($pct_speed*100)?>], ['Cars Do Not Obey the Speed Limit', (<?echo 100-round($pct_speed*100)?>)]
  ];
  var data4 = [
    ['Sidewalks Continue Without Gaps', <?echo round($pct_no_gaps*100)?>], ['Sidewalks Have Gaps', (<?echo 100-round($pct_no_gaps*100)?>)]
  ];

var plot1 = jQuery.jqplot ('chart1', [data], 
    { 
        title: 'Cars Stop at Stop Signs',
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
  var plot2 = jQuery.jqplot ('chart2', [data2], 
    { 
        title: 'Crosswalks are Painted',
      seriesDefaults: {
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          showDataLabels: true
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
  var plot3 = jQuery.jqplot ('chart3', [data3], 
    { 
        title: 'Cars Obey the Speed Limit',
      seriesDefaults: {
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          showDataLabels: true
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
  var plot4 = jQuery.jqplot ('chart4', [data4], 
    { 
        title: 'Sidewalks Continue Without Gaps',
      seriesDefaults: {
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          showDataLabels: true
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
});
</script>

<div id="chart1" class="jqplot-target"  style="height: 300px; width: 800px; position: relative;"></div>
<div id="chart2" class="jqplot-target"  style="height: 300px; width: 800px; position: relative;"></div>
<div id="chart3" class="jqplot-target"  style="height: 300px; width: 800px; position: relative;"></div>
<div id="chart4" class="jqplot-target"  style="height: 300px; width: 800px; position: relative;"></div>


<? include "../../footer.php"; ?>