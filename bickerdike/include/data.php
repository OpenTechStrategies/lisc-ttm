<?php
include "../../header.php";
include "../header.php";
?>

<!--
Menu of all reports and some data entry too (corner store and walkability assessments).
-->


<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
               // $('.hide_on_view').hide();
	});
</script>


<div class="content_wide">
<table id="reports_and_data">
	<tr>
		<td><h2>Data</h2>

<ul>
    <li><a href="../data/participant_surveys_total.php">Participant Survey, Aggregate</a></li>
    <li><a href="../data/participant_surveys_individual_total.php">Participant (Individual) Survey, Aggregate</a></li>
<!--    <li>Partner Program Attendance Rates</li>-->
<!--    <li><a href="../data/partner_programs.php">Partner Program Records</a></li>-->
    <li><a href="../data/bickerdike_programs.php">Bickerdike Records: Contextual Data</a></li>
    <li><a href="../data/health_calendar.php">Health Calendar</a></li>
    <li>Corner Store Assessment -- <a href="../reports/add_corner_store.php" class="hide_on_view">Add Data</a> -- <a href="../reports/corner_store_report.php">View Cumulative Report</a></li>
    <li>Walkability Assessment -- <a href="../reports/add_walkability.php" class="hide_on_view">Add Data</a> -- <a href="../reports/walkability_report.php">View Cumulative Report</a></li>
    <li><a href="../data/new_cws.php" class="hide_on_view">Add Community Wellness Survey Results</a></li>
    <li><a href="../data/export.php">Export All Data</a></li>
</ul></td>
		<td><h2>Reports</h2>


    <ul>
        <li><a href="../reports/knowledge.php">Obesity Knowledge Over Time</a></li>
        <li><a href="../reports/attitude.php">Obesity Attitude Over Time</a></li>
        <li><a href="../reports/behavior.php">Obesity Behavior Over Time</a></li>
        <li><a href="../reports/health_report.php">Physical Change Over Time</a></li>
        <li><a href="../data/survey_sort.php">Sort and export surveys</a></li>
        <li><a href="../reports/custom_query.php">Custom Query</a></li>
<!--        <li>Attendance Over Time</li>
        <li>Physical Environment Measures</li>-->
    </ul></td>
	</tr>
</table>


</div>
<? include "../../footer.php"; ?>
