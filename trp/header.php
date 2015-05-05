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
<div id="trp_header">
    <script>
        $(document).ready(function() {

            $("td.menu_item").hover(function() {
                $(this).addClass("select");
            }, function() {
                $(this).removeClass("select");
            });
        });
    </script>
    <table width="100%">
        <tr>
            <td rowspan="2" id="logo" width="20%"><a href="/trp/index.php"><img src="/trp/images/logo-trp.png" width="80%"/></a></td>
            <td colspan="5"><h2>Pilsen: The Resurrection Project</h2></td>
        </tr>
        <tr>
            <td class="menu_item"><a href="/trp/participants/participants.php" id="participants_selector">Participants</a></td>
            <td class="menu_item"><a href="/trp/programs/programs.php" id="programs_selector">Programs</a></td>
            <td class="menu_item"><a href="/trp/engagement/engagement.php" id="engagement_selector">Community Engagement</a></td>

            <td class="menu_item"><a href="/trp/reports/reports.php" id="reports_selector">Reports</a></td>
            <td class="menu_item"><a href="/index.php?action=logout">Log Out</a>
        </tr>
        <tr>
            <td colspan="6"><hr/></td>
        </tr>
    </table>
</div>