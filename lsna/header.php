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
                            <a href="/lsna/institutions/institutions.php">Institutions/Funders</a></td>
			<td class="menu_item"><a href="/lsna/reports/reports.php" id="reports_selector">Reports</a></td>
			<td class="menu_item"><a href="/index.php?action=logout">Log Out</a>
		</tr>
		<tr>
			<td colspan="6"><hr/></td>
		</tr>
	</table>	
</div>
