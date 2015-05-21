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

include "../../header.php";
include "../header.php";
include "report_menu.php";
//include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
?>

<!-- as with all the other exports, this will be changing once Taryn lets us know her requirements. -->

<script type="text/javascript">
	$(document).ready(function(){
		$('#reports_selector').addClass('selected');
	});
</script>
<h3>Export Everything</h3>
<span class="helptext">Some tables have no identifying information, and will always be in the far right column.  Others include identifying information,
which has been removed for the use of researchers and partners in the version in the far right column.</span>
<table class="all_projects">
    <tr><th>Export Tables</th><th>Including names and more</th><th>Excluding all potentially identifiable information</th></tr>
    <tr><td class="all_projects">Export Academic Info</td>
        <td class="all_projects">
            <a
	    href="/include/generalized_download_script.php?download_name=trp_academic_info">With
	    identifying information</a>  
        </td>
        <td class="all_projects">
            <a
            href="/include/generalized_download_script.php?download_name=trp_academic_info_deid">  
            Without identifying information</a>
        </td></tr> 
    
        <tr><td class="all_projects">Export Events</td><td
            class="all_projects"></td><td class="all_projects"> 
            <a
            href="/include/generalized_download_script.php?download_name=trp_events_deid">Without
            identifying information</a>
        </td></tr> 
        
            <tr><td class="all_projects">Export Event Attendees</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_event_attendance">
                     With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_event_attendance_deid">
                    Without identifying information</a>
                </td></tr>
            <tr><td class="all_projects">School Records, Non-Academic</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_school_records">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_school_records_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Explore and ISAT Scores</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_explore_scores">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_explore_scores_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Community Engagement Outcomes by Month</td>
                <td class="all_projects">
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_community_outcomes">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Parent-Child Relationships</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_families">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_families_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">All Participants</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_participants">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_participants_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Participants by Program</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_participants_programs">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_participants_programs_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">All Programs</td>
                <td class="all_projects">
                     
                </td><td class="all_projects">
                <a
                href="/include/generalized_download_script.php?download_name=trp_programs">
                    Without identifying information</a></td></tr> 
            
            <tr><td class="all_projects">GOLD Scores</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_gold_scores">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_gold_scores_deid">
                    Without identifying information</a></td></tr>
            
             <tr><td class="all_projects">Teacher Exchange Classrooms</td>
                <td class="all_projects">
                 <a
                href="/include/generalized_download_script.php?download_name=trp_teacher_exchange">
                    With identifying information</a>
                </td><td class="all_projects">
                <a
                href="/include/generalized_download_script.php?download_name=trp_teacher_exchange_deid">
                    Without identifying information</a></td></tr>
    
            
</table>

<h2> La Casa Information</h2>
<table class="all_projects">

       <tr><td class="all_projects">Constant La Casa Data</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_lc_constant_data">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_lc_constant_data_deid">
                    Without identifying information</a></td></tr>

       <tr><td class="all_projects">La Casa Data by term</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_lc_by_term">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_lc_by_term_deid">
                    Without identifying information</a></td></tr>

       <tr><td class="all_projects">La Casa Colleges</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_lc_colleges">
                    With identifying information</a>
                </td><td class="all_projects">
</td></tr>
     
</table>

<br/></br>

<?php
	include "../../footer.php";
?>
