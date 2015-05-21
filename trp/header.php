<div id="trp_header">
    <script>
        $(document).ready(function() {
<?php
if (!isset($_COOKIE['user'])) {
    /* if this person isn't signed in or their login information has expired, send them back to the homepage. */
    ?>
                window.location = '/index.php';
    <?php
}
?>
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
            <td class="menu_item"><a href="/trp/programs/lc_dashboard.php" id="dashboard_selector">La Casa Dashboard</a></td>
            <td class="menu_item"><a href="/trp/programs/programs.php" id="programs_selector">Programs</a></td>
            <td class="menu_item"><a href="/trp/engagement/engagement.php" id="engagement_selector">Community Engagement</a></td>

            <td class="menu_item"><a href="/trp/reports/reports.php" id="reports_selector">Reports</a></td>
            <td class="menu_item"><a href="/trp/index.php?action=logout">Log Out</a>
        </tr>
        <tr>
            <td colspan="6"><hr/></td>
        </tr>
    </table>
    <?php
    if ($_COOKIE['sites']) {
        if (in_array('4', $_COOKIE['sites'])) {
            /* then the logged in user has access to TRP */
            if (isset($_COOKIE['view_restricted'])) {
                /* then the user isn't an administrator and some buttons should be hidden (often delete buttons) */
                ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.hide_on_view').hide();
                    });
                </script>
                <?php
            }
            if (isset($_COOKIE['view_only'])) {
                /* then the user is not allowed to edit any information. */
                ?> 
                <style type="text/css">.no_view {display:none}</style><?php
            }
        } else {
            ?>

            <script type="text/javascript">
                $(document).ready(function() {
                    //$('#main_wrapper').hide();
                    window.location = '/index.php';
                });
            </script>
        <?php
    }
} else {
    ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#main_wrapper').hide();
                window.location = '/index.php';
            });
        </script>
    <?php
}
?>
</div>