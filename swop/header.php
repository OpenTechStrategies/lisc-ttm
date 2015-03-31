<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

?>
<div id="swop_header">
	<script>
		$(document).ready(function(){
			$("td.menu_item").hover(function(){
				$(this).addClass("select");
			}, function() {
				$(this).removeClass("select");
			});
		});
	</script>
        <!-- menu of options: -->
	<table width="100%">
		<tr>
			<td rowspan="2" id="logo" width="23%"><a href="/swop/index.php"><img width="250px;" src="/swop/images/logo-swop.jpg" /></a></td>
			<td colspan="6"><h2>Chicago Lawn: Southwest Organizing Project</h2></td>
		</tr>
		<tr>
			<td class="menu_item"><a href="/swop/participants/participants.php" id="participants_selector">Participants</a></td>
			<td class="menu_item"><a href="/swop/properties/properties.php" id="properties_selector">Properties</a></td>
			<td class="menu_item"><a href="/swop/campaigns/campaigns.php" id="programs_selector">Campaigns</a></td>
			<td class="menu_item"><a href="/swop/institutions/institutions.php" id="institutions_selector">Institutions</a></td>
			<td class="menu_item"><a href="/swop/reports/reports.php" id="reports_selector">Reports</a></td>
			<td class="menu_item"><a href="/index.php?action=logout">Log Out</a>
		</tr>
		<tr>
			<td colspan="7"><hr/></td>
		</tr>
	</table>	

</div>