<?php
require_once("../siteconfig.php");
?>
<?php
include "../../header.php";
include "../header.php";
/*
  <!--Reports menu. --> */

/* if this is the page reloading after the user chose assessment criteria, 
 * hide everything but the assessments page and show results: 
 */
if (isset($_POST['submit_btn_assessments'])) {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reports_selector').addClass('selected');
            $('#ajax_loader').hide();
            $('#add_new').hide();
            $('#programs_report').hide();
            $('#referrals_report').hide();
            $('#program_quality_report').hide();
            $('#exports').hide();
            $('#assessments_report').show();
            $('#program_list').hide();
        });

        $(document).ajaxStart(function() {
            $('#ajax_loader').fadeIn('slow');
        });

        $(document).ajaxStop(function() {
            $('#ajax_loader').fadeOut('slow');
        });
    </script><?php
}
/* Or if this is loading the results of program quality surveys, hide everything but program quality and show results: */ elseif (isset($_POST['submit_quality'])) {
    ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#reports_selector').addClass('selected');
            $('#ajax_loader').hide();
            $('#add_new').hide();
            $('#programs_report').hide();
            $('#referrals_report').hide();
            $('#program_quality_report').show();
            $('#exports').hide();
            $('#assessments_report').hide();
        });

        $(document).ajaxStart(function() {
            $('#ajax_loader').fadeIn('slow');
        });

        $(document).ajaxStop(function() {
            $('#ajax_loader').fadeOut('slow');
        });
    </script><?php
}
/* show results for program enrollment, hide everything else: */ elseif (isset($_POST['program_submitbtn'])) {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reports_selector').addClass('selected');
            $('#ajax_loader').hide();
            $('#add_new').hide();
            $('#programs_report').show();
            $('#referrals_report').hide();
            $('#program_quality_report').hide();
            $('#exports').hide();
            $('#assessments_report').hide();
        });

        $(document).ajaxStart(function() {
            $('#ajax_loader').fadeIn('slow');
        });

        $(document).ajaxStop(function() {
            $('#ajax_loader').fadeOut('slow');
        });
    </script><?php
}
/* if this isn't the result of any search, then show program enrollment with all the current
 * database information: 
 */ else {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reports_selector').addClass('selected');
            $('#ajax_loader').hide();
            $('#add_new').hide();
            $('#programs_report').show();
            $('#referrals_report').hide();
            $('#program_quality_report').hide();
            $('#exports').hide();
            $('#assessments_report').hide();
        });

        $(document).ajaxStart(function() {
            $('#ajax_loader').fadeIn('slow');
        });

        $(document).ajaxStop(function() {
            $('#ajax_loader').fadeOut('slow');
        });
    </script><?php
}
?>

<div class="content_block">
    <!--Show reports: -->
    <h3>Reports</h3><hr/><br/>
    <table class="all_participants" style="width:100%;"><tr><td>
                <a href="javascript:;" onclick="
                        $('#programs_report').show();
                        $('#referrals_report').hide();
                        $('#program_quality_report').hide();
                        $('#exports').hide();
                        $('#assessments_report').hide();
                   ">Programs</a>
            </td>
            <td>
                <a href="javascript:;" onclick="
                        $('#programs_report').hide();
                        $('#referrals_report').hide();
                        $('#program_quality_report').hide();
                        $('#exports').hide();
                        $('#assessments_report').show();
                   ">Assessments</a></td>

            <td><a href="javascript:;" onclick="
                    $('#programs_report').hide();
                    $('#referrals_report').hide();
                    $('#program_quality_report').show();
                    $('#exports').hide();
                    $('#assessments_report').hide();
                   ">Program Quality</a></td>
            <td><a href="javascript:;" onclick="
                    $('#programs_report').hide();
                    $('#referrals_report').hide();
                    $('#program_quality_report').hide();
                    $('#exports').show();
                    $('#assessments_report').hide();
                   ">Exports</a></td>
<!--  <td><a href="all_exports.php">Exports</a></td>-->
        </tr></table>
    <div id="programs_report"><?php include "num_programs.php"; ?></div>
    <div id="assessments_report"><?php include "assessments.php"; ?></div>
    <div id="referrals_report"><?php include "referrals.php"; ?></div>
    <div id="program_quality_report"><?php include "quality_surveys.php"; ?></div>
    <div id="exports"><?php include "production_exports.php"; ?></div>
    <br/><br/>	
</div>

<?php
include "../../footer.php";
?>