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
