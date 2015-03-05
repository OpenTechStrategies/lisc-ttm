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
            <td class="menu_item"><a href="../index.php?action=logout">Log Out</a>
        </tr>
        <tr>
            <td colspan="6"><hr/></td>
        </tr>
    </table>
</div>