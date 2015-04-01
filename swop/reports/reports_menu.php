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