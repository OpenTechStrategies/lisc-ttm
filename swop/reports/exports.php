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
user_enforce_has_access($SWOP_id, $DataEntryAccess);

include "../../header.php";
include "../header.php";
include "reports_menu.php";
//include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
?>

<!-- export information from the database.  Will change once Taryn gets back to me with the compound exports she needs: -->

<h2>Export All</h2>

<table class="all_projects">
    <tr>
        <td>
            <h4>Export Everything </h4>
            <table class="inner_table">
                <tr><th>Deidentified</th><th>With identification</th></tr>
                <tr><td><br>All Campaigns
                    <a href="/include/generalized_download_script.php?download_name=swop_campaigns_deid">
                            Download the CSV file of all campaigns.</a><br><br></td>
                    <td><a href="/include/generalized_download_script.php?download_name=swop_campaigns_deid">
                            Download.</a><br></td></tr>

                <tr><td><br>All Campaign Events
                        <a href="/include/generalized_download_script.php?download_name=swop_events">
                            Download the CSV file of all events (includes locations - is that a problem?).
                        </a><br><br></td>
                    <td>
                        <a href="/include/generalized_download_script.php?download_name=swop_events">
                            Download.</a></td></tr>

                <tr><td><br>All Campaign-Institution Relationships
                        <a href="/include/generalized_download_script.php?download_name=swop_campaigns_institutions">
                            Download the CSV file of all campaign-institution relationships.
                        </a><br><br>
                    </td>
                    <td><a href="/include/generalized_download_script.php?download_name=swop_campaigns_institutions">
                            Download.</a>
                    </td></tr>

                <tr><td>Impossible to deidentify household names.</td><td>         
                        <br>All Households
                        <a href="/include/generalized_download_script.php?download_name=swop_households">
                            Download the CSV file of all households.</a><br>
                        <br>
                    </td></tr>

                <tr><td><a href="/include/generalized_download_script.php?download_name=swop_households_people_deid">
                            Download the CSV file of all links between people and households.
                        </a><br><br>
                    </td>
                    <td><br>Participants by Household
                        <a href="/include/generalized_download_script.php?download_name=swop_households_people">
                            Download the CSV file of households, formatted with their members.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Institutions
                        <a href="/include/generalized_download_script.php?download_name=swop_institutions_deid">
                            Download the CSV file of all institutions.
                        </a><br><br>
                    </td>
                    <td><br>All Institutions with point person details.
                        <a href="/include/generalized_download_script.php?download_name=swop_institutions">
                            Download the CSV file of all institutions.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Institution/Participant Relationships (this is 
                        all ID-based.  To see names, look at the right column)
                        <a href="/include/generalized_download_script.php?download_name=swop_institutions_people_deid">
                            Download the CSV file of all institutions/participants.
                        </a><br><br>
                    </td>
                    <td><br>
                        All Institution/Participant Relationships
                        <a href="/include/generalized_download_script.php?download_name=swop_institutions_people">
                            Download the CSV file of all institutions/participants.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Detailed Leadership Development Steps
                        <a href="/include/generalized_download_script.php?download_name=swop_leadership_development_deid">
                            Download the CSV file of the detailed leadership 
                            development of all participants.</a><br>
                        <br>
                    </td>
                    <td><br>All Detailed Leadership Development Steps
                        <a href="/include/generalized_download_script.php?download_name=swop_leadership_development">
                            Download the CSV file of the detailed leadership 
                            development of all participants.</a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Participants
                        <a href="/include/generalized_download_script.php?download_name=swop_participants_deid">
                            Download the CSV file of all participants, without their names.
                        </a><br><br>    
                    </td>
                    <td><br>All Participants
                        <a href="/include/generalized_download_script.php?download_name=swop_participants">
                            Download the CSV file of all participants, period.
                        </a><br>
                        <br>
                    </td></tr>

                <tr><td><br>All Participant Pool Status Changes
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_status_deid">
                            Download the CSV file of all participant pool status changes, without names.
                        </a><br><br>    
                    </td>
                    <td><br>All Participant Pool Status Changes
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_status">
                            Download the CSV file of all participant pool status changes.
                        </a><br><br>
                    </td></tr>
                
                <tr><td><br>All Participant Pool Movement / Benchmarks
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_movement_deid">
                            Download the CSV file of all participant pool movement
                            / benchmarks, without names.</a><br><br>    
                    </td>
                    <td><br>All Participant Pool Movement / Benchmarks
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_movement">
                            Download the CSV file of all participant pool movement
                            / benchmarks.</a><br><br>
                    </td></tr>
                
                <tr><td><br>
                        All Event Attendance
                        <a href="/include/generalized_download_script.php?download_name=swop_event_attendance_deid">
                            Download the CSV file of all event attendance.
                        </a><br><br>
                    </td>
                    <td><br>All Event Attendance
                        <a href="/include/generalized_download_script.php?download_name=swop_event_attendance">
                            Download the CSV file of all event attendance.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Leader Classifications
                        <a href="/include/generalized_download_script.php?download_name=swop_leader_deid">
                            Download the CSV file of all primary, secondary, 
                            and tertiary leaders.
                        </a><br><br>
                    </td>
                    <td><br>All Leader Classifications
                        <a href="/include/generalized_download_script.php?download_name=swop_leader">
                            Download the CSV file of all primary, secondary, 
                            and tertiary leaders.</a>
                        <br>
                        <br>
                    </td>
                </tr>

                <tr><td><br> All Pool Members<br>
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_members_deid">
                            Download the CSV file of all pool members, with type.
                        </a><br><br>
                    </td>
                    <td><br>All Pool Members
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_members">
                            Download the CSV file of all pool members, with type.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Participant-Property Relationships
                        <a href="/include/generalized_download_script.php?download_name=swop_people_properties_deid">
                            Download the CSV file of all properties linked to a 
                            participant.
                        </a><br><br>
                    </td>
                    <td><br>All Participant-Property Relationships
                        <a href="/include/generalized_download_script.php?download_name=swop_people_properties">
                            Download the CSV file of all properties linked to a 
                            participant.</a><br>
                        <br>
                    </td></tr>

                <tr><td><br>All Pool Member Employment
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_employment_deid">
                            Download the CSV file of all pool members' employment.
                        </a><br><br>
                    </td>
                    <td><br> All Pool Member Employment
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_employment">
                            Download the CSV file of all pool members' employment.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Pool Member Finances
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_finances_deid">
                            Download the CSV file of all pool member finances.
                        </a><br><br>
                    </td>
                    <td><br> All Pool Member Finances
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_finances">
                            Download the CSV file of all pool member finances.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Pool Member Outcomes
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_outcomes_deid">
                            Download the CSV file of all pool member outcomes.
                        </a><br> <br>
                    </td>
                    <td><br>All Pool Member Outcomes
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_outcomes">
                            Download the CSV file of all pool member outcomes.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Pool Member Progress
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_progress_deid">
                            Download the CSV file of all pool member progress.
                        </a><br><br>
                    </td>

                    <td><br>Participant Progress (for pool members, with primary organizers)
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_progress">
                            Download the CSV file of people progressing through 
                            various pool pipelines, shown with their primary 
                            organizer.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Pool Status Active/Inactive
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_activity_deid">
                            Download the CSV file of all pool status changes.
                        </a><br><br>
                    </td>
                    <td><br>All Pool Status Active/Inactive
                        <a href="/include/generalized_download_script.php?download_name=swop_pool_activity">
                            Download the CSV file of all pool status changes.
                        </a><br><br>
                    </td>
                </tr>

                <tr><td><br>All Properties
                        <a href="/include/generalized_download_script.php?download_name=swop_properties_deid">
                            Download the CSV file of all properties.
                        </a><br><br>
                    </td>
                    <td><br> All Properties
                        <a href="/include/generalized_download_script.php?download_name=swop_properties">
                            Download the CSV file of all properties.
                        </a><br><br>
                    </td></tr>

                <tr><td><br>Property Progress Over Time
                        <a href="/include/generalized_download_script.php?download_name=swop_property_progress_deid">
                            Download the CSV file of property rehab progress.
                        </a><br><br>
                    </td>
                    <td> <br>Property Progress Over Time
                        <a href="/include/generalized_download_script.php?download_name=swop_property_progress">
                            Download the CSV file of property rehab progress 
                            (with property address).
                        </a><br><br>
                    </td></tr>

            </table>
        </td>

    </tr>
</table>
<br/>

<?php include "../../footer.php"; ?>