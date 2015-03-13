<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($LSNA_id);
?>
<div id="lsna_header">
	<script>
		$(document).ready(function(){
			$("td.menu_item").hover(function(){
				$(this).addClass("select");
			}, function() {
				$(this).removeClass("select");
			});
		});
	</script>
	<table width="100%">
		<tr>
			<td id="logo"><!--- Link to LSNA home page --><a href="/lsna/index.php"><img src="/lsna/images/logo.gif" /></a></td>
                        <td class="menu_item"><!-- Link to participants page.  Sets search page cookie, unsets the profile and new cookies. -->
                            <a href="/lsna/participants/participants.php">Participants</a></td>
			<td class="menu_item"><!-- Link to programs/campaigns page.  Sets search page cookie, unsets the profile and new cookies. -->
                            <a href="/lsna/programs/programs.php">Issue Areas</a></td>
			<td class="menu_item">
                            <a href="/lsna/institutions/institutions.php">Institutions</a></td>
			<td class="menu_item"><a href="/lsna/reports/reports.php" id="reports_selector">Reports</a></td>
			<td class="menu_item"><a href="/index.php?action=logout">Log Out</a>
		</tr>
		<tr>
			<td colspan="6"><hr/></td>
		</tr>
	</table>	
</div>
