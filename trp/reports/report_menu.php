<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id);
?>
<div class="content_block" style="text-align:center;">
<!--        <span class="trp_report"><a href="/trp/reports/reports.php">Reports Home</a> ||</span>-->
       <span class="trp_report"> <a href="/trp/reports/scores_reports.php">GPA and Explore Scores</a> ||</span>
       <span class="trp_report "> <a href="/trp/reports/NMMA_surveys.php">NMMA Surveys</a> ||</span>

<!--        <a href="/trp/include/import_grades.php">Import Grades</a> ||
        <a href="/trp/reports/import_demographics.php">Import Demographics</a> ||-->
<?php
    if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>
       <span class="trp_report"> <a href="/trp/reports/import_event_attendance.php">Import Event Attendance</a> ||</span>
      <span class="trp_report">  <a href="/trp/reports/import_cps.php">Import CPS File</a> ||</span>

      <span class="trp_report">  <a href="export_all.php">Export everything</a></span>
<?php
} // end access level check
?>        
</div><br/>
