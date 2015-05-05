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

user_enforce_has_access($Bickerdike_id);
?>
<div id="bickerdike_header">
    <script>
        $(document).ready(function() {
            $("td.menu_item").hover(function() {
                $(this).addClass("select");
            }, function() {
                $(this).removeClass("select");
            });
        });
        $(document).ready(function() {
            $('#ajax_loader').hide();
        });
        $(document).ajaxStart(function() {
            $('#ajax_loader').fadeIn('slow');
        });
        $(document).ajaxStop(function() {
            $('#ajax_loader').fadeOut('slow');
        });</script>
    <table width="100%">
        <tr>
            <td id="logo" rowspan="3"><a href="/bickerdike/index.php"><img src="/bickerdike/images/bickerdike-logo.jpg" /></a></td>
            <td colspan="4"><h3>Humboldt Park: Bickerdike Redevelopment Corporation</h3></td>
        </tr>
        <tr>
            <td class="menu_item"><a href="/bickerdike/users/all_users.php" id="participants_selector">Participants</a></td>
            <td class="menu_item"><a href="/bickerdike/activities/view_all_programs.php" id="program_selector">Programs</a></td>
            <!--<td class="menu_item"><a href="/bickerdike/activities/view_search_activities.php" id="events_selector">Events</a></td>-->
            <!--<td class="menu_item"><a href="/bickerdike/include/reports.php" id="reports_selector">Reports</a></td>-->
            <td class="menu_item" width="30%"><a href="/bickerdike/include/data.php" id="data_selector">Survey Data and Reports</a></td>
            <td class="menu_item"><a href="/index.php?action=logout">Log Out</a>
        </tr>
        <tr>
            <td colspan="6"><hr/></td>
        </tr>
    </table>	
</div>
