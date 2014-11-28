<div id="bickerdike_header">
    <script>
        $(document).ready(function() {
            $("td.menu_item").hover(function() {
                $(this).addClass("select");
            }, function() {
                $(this).removeClass("select");
            });
        });
<?php
if (!isset($_COOKIE['user'])) {
    ?>
            window.location = '/index.php';
    <?php
}
?>
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
<?php
if ($_COOKIE['sites']) {
    if (in_array('3', $_COOKIE['sites'])) {
//then they have permission to view the bickerdike stuff
//now we check to see if they have editing privileges or not:
        if ($_COOKIE['view_restricted']) {
            ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('.hide_on_view').hide();
                });</script>
            <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                //$('#main_wrapper').hide();
                window.location = '/index.php';
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
        <?php
    }
} else {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#main_wrapper').hide();
            window.location = '/index.php';
        });
        $(document).ready(function() {
            $('#ajax_loader').hide();
        });
        $(document).ajaxStart(function() {
            $('#ajax_loader').fadeIn('slow');
        });
        $(document).ajaxStop(function() {
            $('#ajax_loader').fadeOut('slow');
        });
    </script>
    <?php
}
?>