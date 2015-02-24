<?php
include "../../header.php";
include "../header.php";
?>
<!--Reports menu: -->
<?php
if (isset($_POST['satisfaction_program'])) {
    /* if the page is being reloaded because of a satisfaction survey report search: */
    ?><script type="text/javascript">
        $(document).ready(function() {
            $('#reports_selector').addClass('selected');
            $('#parent_mentor_survey').slideUp();
            $('#parent_mentor_survey_pre_post').slideUp();
            $('#teacher_surveys').slideUp();
            $('#teacher_surveys_pre_post').slideUp();
            $('#pm_attendance').hide();
            $('#satisfaction').slideUp();
            $('#pm_survey_tab').addClass('selected');
        });
    </script><?php
}
/* if it is being reloaded because of a parent mentor attendance search: */ elseif (isset($_POST['month'])) {
    ?><script type="text/javascript">
        $(document).ready(function() {
            //alert('month selected');
            $('#reports_selector').addClass('selected');
            $('#parent_mentor_survey').slideUp();
            $('#parent_mentor_survey_pre_post').slideUp();
            $('#teacher_surveys').slideUp();
            $('#teacher_surveys_pre_post').slideUp();
            $('#satisfaction').slideUp();
            $('#pm_attendance').show();
            $('#pm_survey_tab').addClass('selected');
        });
    </script>
    <?php
}
/* if it is being reloaded because of a parent mentor pre & post submission: */ elseif (isset($_POST['pre_post_year'])) {
    ?><script type="text/javascript">
        $(document).ready(function() {
            //alert('month selected');
            $('#reports_selector').addClass('selected');
            $('#parent_mentor_survey').slideUp();
            $('#parent_mentor_survey_pre_post').show();
            $('#teacher_surveys').slideUp();
            $('#teacher_surveys_pre_post').slideUp();
            $('#satisfaction').slideUp();
            $('#pm_attendance').hide();
            $('#pm_survey_pre_post_tab').addClass('selected');
        });
    </script>
    <?php
}
/* otherwise: */ else {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reports_selector').addClass('selected');
            $('#parent_mentor_survey').show();
            $('#parent_mentor_survey_pre_post').slideUp();
            $('#satisfaction').slideUp();
            $('#teacher_surveys').hide();
            $('#teacher_surveys_pre_post').hide();
            $('#pm_attendance').hide();
            $('#pm_survey_tab').addClass('selected');
        });
    </script>
    <?php
}
?>

<div class="content">
    <h3>Reports</h3><hr/><br/>
    <a href="query.php" class="report_tab">Participant Query Search</a>&nbsp;&nbsp; <a href="survey_query.php" class="report_tab">Survey Query Search</a>
    <br>
    <a class="report_tab" id="pm_survey_tab" href="javascript:;" onclick="
            $('#parent_mentor_survey').show();
            $('#parent_mentor_survey_pre_post').slideUp();
            $('#satisfaction').slideUp();
            $('#teacher_surveys').hide();
            $('#teacher_surveys_pre_post').hide();
            $('#pm_attendance').hide();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Parent Mentor Surveys</a>

    <a class="report_tab" id="involvement_tab" href="program_involvement.php">Program and Campaign Involvement</a>

    <a class="report_tab" id="roles_tab" href="participant_roles.php">Participant Roles</a>

    <a class="report_tab" id="teacher_survey_tab" href="javascript:;" onclick="
            $('#parent_mentor_survey').hide();
            $('#parent_mentor_survey_pre_post').hide();
            $('#teacher_surveys').show();
            $('#teacher_surveys_pre_post').hide();
            $('#satisfaction').slideUp();
            $('#pm_attendance').hide();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Teacher Surveys</a>
    
    <a class="report_tab" id="teacher_survey_tab" href="javascript:;" onclick="
            $('#parent_mentor_survey').hide();
            $('#parent_mentor_survey_pre_post').hide();
            $('#teacher_surveys').hide();
            $('#teacher_surveys_pre_post').show();
            $('#satisfaction').slideUp();
            $('#pm_attendance').hide();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Teacher Surveys (Pre&Post)</a>

    <a class="report_tab" id="teacher_survey_tab" href="javascript:;" onclick="
            $('#parent_mentor_survey').hide();
            $('#parent_mentor_survey_pre_post').hide();
            $('#teacher_surveys').hide();
            $('#teacher_surveys_pre_post').hide();
            $('#satisfaction').show();
            $('#pm_attendance').hide();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Satisfaction Surveys</a>


    <a class="report_tab no_view" id="teacher_survey_tab" href="export_all.php">Export Data</a>
    <a class="report_tab no_view" id="teacher_survey_tab" href="../include/import_sample.php">Import Data</a>

    <br/>
    <br/>


    <?php
    include "pm_survey_results.php";
    include "teacher_surveys.php";
    include "teacher_surveys_pre_post.php";
    include "satisfaction_surveys.php";
    include "pm_attendance.php";
    ?>

</div>
<br/><br/>
<?php include "../../footer.php"; ?>
