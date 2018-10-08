<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *   Copyright (C) 2018 Open Tech Strategies, LLC
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
<div id="enlace_header">
    <script>
        $(document).ready(function() {
            $("td.menu_item").hover(function() {
                $(this).addClass("select");
            }, function() {
                $(this).removeClass("select");
            });
        });
    </script>
    <!--Menu: -->

    <table width="100%">
        <tr>
            <td rowspan="2" id="logo" width="13%"><a href="/enlace/index.php"><img src="/enlace/images/logo-enlace.png" /></a></td>
            <td colspan="8"><h2>Little Village: Enlace Chicago</h2></td>
        </tr>
        <tr>
            <td class="menu_item"><a href="/enlace/participants/participants.php" id="participants_selector">Participants</a></td>
            <td class="menu_item"><a href="/enlace/programs/programs.php" id="programs_selector">Program Site/Orgs</a></td>
            <td class="menu_item"><a href="/enlace/institutions/institutions.php" id="institutions_selector">Organizations</a></td>
            <td class="menu_item"><a href="/enlace/campaigns/campaigns.php" id="campaigns_selector">Campaigns</a></td>
            <td class="menu_item"><a href="/enlace/events/events.php" id="events_selector">Events</a></td>
            <td class="menu_item"><a href="/enlace/reports/reports.php" id="reports_selector">Reports</a></td>
            <?php if ($USER && $USER->has_site_access($Enlace_id, $AdminAccess)) { ?>
                <td class="menu_item"><a href="/enlace/system/settings.php" id="settings_selector">Settings</a>
            <?php } ?>
            <td class="menu_item"><a href="/index.php?action=logout">Log Out</a>
        </tr>
        <tr>
            <td colspan="9"><hr/></td>
        </tr>
    </table>	
</div>