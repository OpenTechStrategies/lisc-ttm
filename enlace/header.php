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
            <td colspan="7"><h2>Little Village: Enlace Chicago</h2></td>
        </tr>
        <tr>
            <td class="menu_item"><a href="/enlace/participants/participants.php" id="participants_selector">Participants</a></td>
            <td class="menu_item"><a href="/enlace/programs/programs.php" id="programs_selector">Programs</a></td>
            <td class="menu_item"><a href="/enlace/institutions/institutions.php" id="institutions_selector">Institutions</a></td>
            <td class="menu_item"><a href="/enlace/campaigns/campaigns.php" id="campaigns_selector">Campaigns</a></td>
            <td class="menu_item"><a href="/enlace/events/events.php" id="events_selector">Events</a></td>
            <td class="menu_item"><a href="/enlace/reports/reports.php" id="reports_selector">Reports</a></td>
            <td class="menu_item"><a href="/index.php?action=logout">Log Out</a>
        </tr>
        <tr>
            <td colspan="8"><hr/></td>
        </tr>
    </table>	
</div>