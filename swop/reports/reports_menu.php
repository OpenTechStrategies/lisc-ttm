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
user_enforce_has_access($SWOP_id);

?>
<div class="content_block">
    
    <!-- menu of reports, visible on all these pages: -->
	<h3>Reports</h3><hr/><br/>
	<table width="100%">
		<tr>
			<td><a href="reports.php">Reports Home</a></td>
			<td><a href="leaders_by_institution.php">Leaders by Institution</a></td>
			<td><a href="pool_activity.php">Pool Activity</a></td>
			<td><a href="num_insts.php">Number of Institutions</a></td>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>			<td><a href="exports.php">Exports</a></td>
<?php
}
?>
                        <td><a href="property_report.php">Properties Custom Report</a></td>
                        <td><a href="leadership_report.php">Leadership Report</a></td>
		</tr>
	</table>
        <br/>
        
</div>
<?php
close_all_dbconn();
?>