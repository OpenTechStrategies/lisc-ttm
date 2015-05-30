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
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--
Shows results from the corner store evaluations.  The results are first shown in the 
table (the "number" refers to the number that yes, do the action in the question), then
represented by pie charts below.
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
<h3>Corner Store Report</h3><hr/><br/>
<div id="corner_store_stats">
<?
$num_stores_sqlsafe = "SELECT * FROM Corner_Store_Assessment";
include "../include/dbconnopen.php";
$stores = mysqli_query($cnnBickerdike, $num_stores_sqlsafe);
$num_evaled = mysqli_num_rows($stores);
include "../include/dbconnclose.php";
?>
<strong>Number of stores evaluated: <?echo $num_evaled;?></strong>
<a class="add_new" href="add_corner_store.php" style="float:right; font-size:.8em;"><span class="add_new_button">Add a new Corner Store Assessment</span></a>
<br/>
<table>
    <tr>
        <th>Measure</th>
        <th>Number</th>
        <th>Percent</th>
    </tr>
    <tr>
        <td>At least 2 fresh vegetable and 2 fresh fruit options</td>
        <td>
            <?
$num_stores_sqlsafe = "SELECT * FROM Corner_Store_Assessment WHERE 2_plus_fresh_veg_options='1'";
include "../include/dbconnopen.php";
$stores = mysqli_query($cnnBickerdike, $num_stores_sqlsafe);
$num_produce = mysqli_num_rows($stores);
include "../include/dbconnclose.php";
echo $num_produce
?>
        </td>
        <td>
            <?$pct_produce = $num_produce/$num_evaled;
            echo round($pct_produce*100) . "%";?>
        </td>
    </tr>
    <tr>
        <td>Offering low-fat milk</td>
                <td>
            <?
$num_stores_sqlsafe = "SELECT * FROM Corner_Store_Assessment WHERE Lowfat_Milk_Available='1'";
include "../include/dbconnopen.php";
$stores = mysqli_query($cnnBickerdike, $num_stores_sqlsafe);
$num_milk = mysqli_num_rows($stores);
include "../include/dbconnclose.php";
echo $num_milk
?>
        </td>
        <td>
            <?$pct_milk = $num_milk/$num_evaled;
            echo round($pct_milk*100) . "%";?>
        </td>
    </tr>
    <tr>
        <td>Display health promotion signage (excluding advertisements)</td>
                <td>
            <?
$num_stores_sqlsafe = "SELECT * FROM Corner_Store_Assessment WHERE Health_Promotion_Signage='1'";
include "../include/dbconnopen.php";
$stores = mysqli_query($cnnBickerdike, $num_stores_sqlsafe);
$num_signage = mysqli_num_rows($stores);
include "../include/dbconnclose.php";
echo $num_signage
?>
        </td>
        <td>
            <?$pct_signage = $num_signage/$num_evaled;
            echo round($pct_signage*100) . "%";?>
        </td>
    </tr>
    <tr>
        <td>Healthy items stocked in the front of the store or in high traffic areas</td>
                <td>
            <?
$num_stores_sqlsafe = "SELECT * FROM Corner_Store_Assessment WHERE Healthy_Items_In_Front='1'";
include "../include/dbconnopen.php";
$stores = mysqli_query($cnnBickerdike, $num_stores_sqlsafe);
$num_stocked = mysqli_num_rows($stores);
include "../include/dbconnclose.php";
echo $num_stocked
?>
        </td>
        <td>
            <?$pct_stocked = $num_stocked/$num_evaled;
            echo round($pct_stocked*100) . "%";?>
        </td>
    </tr>
    
    <!--
    Creates a file to be downloaded of these results.
    -->
    
<?
$infile="../data/downloads/corner_store_report.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Measure", "Number", "Percent");
fputcsv($fp, $title_array);
$fruit = array('At least 2 fresh vegetable and 2 fresh fruit options', $num_produce, round($pct_produce*100));
$milk = array('Offering low-fat milk', $num_milk, round($pct_milk*100));
$signs=array('Display health promotion signage (excluding advertisements)', $num_signage, round($pct_signage*100));
$stock=array('Healthy items stocked in the front of the store or in high traffic areas', $num_stocked, round($pct_stocked*100));
fputcsv ($fp, $fruit);
fputcsv($fp, $milk);
fputcsv($fp, $signs);
fputcsv($fp, $stock);
fclose($fp);
?>
    <br>
       <tr> <td>    <br/><a class="download" href="<?echo $infile;?>">Download the CSV file of the corner store report.</a></td>    </tr>
</table><br/></div>
</div>
<p></p>

<!--
Creates pie charts individually, without creating arrays.  There are so few questions
that arrays and loops seemed unnecessary, especially since each of them is a y/n.
-->


<!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pieRenderer.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  var data = [
    ['At least 2 fresh vegetable and 2 fresh fruit options', <?echo round($pct_produce*100)?>], ['Fewer than 2 fresh vegetable and 2 fresh fruit options', (<?echo 100-round($pct_produce*100)?>)]
  ];
  var data2 = [
    ['Offer low-fat milk', <?echo round($pct_milk*100)?>], ['No low-fat milk', (<?echo 100-round($pct_milk*100)?>)]
  ];
  var data3 = [
    ['Health Promotion Signage', <?echo round($pct_signage*100)?>], ['No Health Promotion Signage', (<?echo 100-round($pct_signage*100)?>)]
  ];
  var data4 = [
    ['Healthy Items Stocked in the front of the store', <?echo round($pct_stocked*100)?>], ['Healthy Items Not Stocked in the front of the store', (<?echo 100-round($pct_stocked*100)?>)]
  ];
  var plot1 = jQuery.jqplot ('chart1', [data], 
    { 
        title: 'At least 2 fresh vegetable and 2 fresh fruit options',
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
        title: 'Offer low-fat milk',
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
        title: 'Health Promotion Signage',
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
        title: 'Healthy Items Stocked in the front of the store',
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
<div id="chart1" style="height: 300px; width: 800px; position: relative;"></div>
<div id="chart2" style="height: 300px; width: 800px; position: relative;"></div>
<div id="chart3" style="height: 300px; width: 800px; position: relative;"></div>
<div id="chart4" style="height: 300px; width: 800px; position: relative;"></div>



<? include "../../footer.php"; ?>