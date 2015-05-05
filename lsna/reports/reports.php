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

user_enforce_has_access($LSNA_id);

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
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').slideUp();
            $('#participant_roles').slideUp();
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
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').slideUp();
            $('#participant_roles').slideUp();
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
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').slideUp();
            $('#participant_roles').slideUp();
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
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').slideUp();
            $('#participant_roles').hide();
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
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').slideUp();
            $('#participant_roles').hide();
            $('#satisfaction').slideUp();
            $('#teacher_surveys').hide();
            $('#teacher_surveys_pre_post').hide();
            $('#pm_attendance').hide();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Parent Mentor Surveys</a>

<!--<a class="report_tab" id="pm_survey_pre_post_tab" href="javascript:;" onclick="
            $('#parent_mentor_survey').slideUp();
            $('#parent_mentor_survey_pre_post').show();
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').slideUp();
            $('#participant_roles').hide();
            $('#satisfaction').slideUp();
            $('#teacher_surveys').hide();
            $('#teacher_surveys_pre_post').hide();
            $('#pm_attendance').hide();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Parent Mentor Surveys (Pre,Mid,&Post)</a>-->

    <a class="report_tab" id="involvement_tab" href="javascript:;" onclick="
            $('#program_involvement').show();
            $('#parent_mentor_survey').hide();
            $('#parent_mentor_survey_pre_post').hide();
            $('#participant_roles').hide();
            $('#program_involvement_sorted').hide();
            $('#satisfaction').slideUp();
            $('#teacher_surveys').hide();
            $('#teacher_surveys_pre_post').hide();
            $('#pm_attendance').hide();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Program and Campaign Involvement</a>
    <!--<a class="report_tab" id="involvement_sorted_tab" href="javascript:;" onclick="
        
  $('#parent_mentor_survey').hide();
  $('#program_involvement').hide();
  $('#participant_roles').hide();
  $('#program_involvement_sorted').show();
      $('#satisfaction').slideUp();
  $('#teacher_surveys').hide();
      $('.report_tab').removeClass('selected');
      $(this).addClass('selected');
 ">Program Involvement by Program</a>-->

    <a class="report_tab" id="roles_tab" href="javascript:;" onclick="
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').hide();
            $('#participant_roles').show();
            $('#parent_mentor_survey').hide();
            $('#parent_mentor_survey_pre_post').hide();
            $('#satisfaction').slideUp();
            $('#teacher_surveys').hide();
            $('#teacher_surveys_pre_post').hide();
            $('#pm_attendance').hide();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Participant Roles</a>

    <a class="report_tab" id="teacher_survey_tab" href="javascript:;" onclick="
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').hide();
            $('#participant_roles').hide();
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
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').hide();
            $('#participant_roles').hide();
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
            $('#program_involvement').slideUp();
            $('#program_involvement_sorted').hide();
            $('#participant_roles').hide();
            $('#parent_mentor_survey').hide();
            $('#parent_mentor_survey_pre_post').hide();
            $('#teacher_surveys').hide();
            $('#teacher_surveys_pre_post').hide();
            $('#satisfaction').show();
            $('#pm_attendance').hide();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Satisfaction Surveys</a>

    <!--            <a class="report_tab" id="teacher_survey_tab" href="javascript:;" onclick="
        $('#program_involvement').slideUp();
        $('#program_involvement_sorted').hide();
        $('#participant_roles').hide();
        $('#parent_mentor_survey').hide();
        $('#teacher_surveys').hide();
        $('#satisfaction').slideUp();
        $('#pm_attendance').show();
            $('.report_tab').removeClass('selected');
            $(this).addClass('selected');
       ">Parent Mentor Attendance</a>-->
<?php
    if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
    <a class="report_tab" id="teacher_survey_tab" href="export_all.php">Export Data</a>
    <a class="report_tab" id="teacher_survey_tab" href="../include/import_sample.php">Import Data</a>
<?php
    } //end access check
?>
    <br/>
    <br/>


    <?php
    include "pm_survey_results.php";
    include "teacher_surveys.php";
    include "teacher_surveys_pre_post.php";
    include "satisfaction_surveys.php";
    ?><?php include "program_involvement.php"; ?><?php
    include "participant_roles.php";
    include "pm_attendance.php";
    ?>

</div>
<br/><br/>
<?php include "../../footer.php"; ?>
