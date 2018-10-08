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

user_enforce_has_access($Enlace_id);

//get user's access
$access_array = $USER->program_access($Enlace_id);

$has_all_programs = in_array('a', $access_array);

function generate_date_inner_join($table, $start_date_sqlsafe, $end_date_sqlsafe) {
    if($end_date_sqlsafe != '' || $start_date_sqlsafe != '') {
        $column_of_interest = '';
        switch ($table) {
            case 'Participants_Baseline_Assessments':
                $assessment_column_of_interest = 'Baseline_ID';
                $table_column_of_interest = 'Baseline_Assessment_ID';
                break;
            case 'Participants_Caring_Adults':
                $assessment_column_of_interest = 'Caring_ID';
                $table_column_of_interest = 'Caring_Adults_ID';
                break;
            case 'Participants_Interpersonal_Violence':
                $assessment_column_of_interest = 'Violence_ID';
                $table_column_of_interest = 'Interpersonal_Violence_ID';
                break;
            case 'Participants_Future_Expectations':
                $assessment_column_of_interest = 'Future_ID';
                $table_column_of_interest = 'Future_Expectations_ID';
                break;
        }

        if($table == 'Participants_Baseline_Assessments') {
           return " INNER JOIN Assessments ON Assessments.$assessment_column_of_interest = $table.$table_column_of_interest ";
        }
        else {
           return " INNER JOIN Assessments ON
             (Assessments.$assessment_column_of_interest = $table.$table_column_of_interest AND
              Assessments.Pre_Post = $table.Pre_Post)";
        }
    }
    else {
        return '';
    }
}

function generate_date_where_clause($table, $start_date_sqlsafe, $end_date_sqlsafe) {
    // This date subselect depends on the fact that all the assessment question subtables
    // have a column called Date_Logged.  If you add a new assessment question where there is no Date_Logged,
    // then this may not work as one would think (or at all).  In the case that new assessment question
    // category/tables are created, they must continue to have a Date_Logged, or please refactor to
    // update Baseline_Assessment_Questions to have a Date_Logged_Column next to In_Table
    $date_where_clause = '';
    if($end_date_sqlsafe != '' && $start_date_sqlsafe != '') {
      $date_where_clause = " AND cast($table.Date_Logged as date) BETWEEN '$start_date_sqlsafe' AND '$end_date_sqlsafe'";
    }
    else if($start_date_sqlsafe != ''){
      $date_where_clause = " AND cast($table.Date_Logged as date) >= '$start_date_sqlsafe'";
    }
    else if($end_date_sqlsafe != ''){
      $date_where_clause = " AND cast($table.Date_Logged as date) <= '$end_date_sqlsafe'";
    }
    return $date_where_clause;
}

?>

<script type="text/javascript">
  function update_assessment_num_selected() {
    $(".numassessmentselected").each(function (idx, span) {
      span.innerHTML = $(".recent_assessment_program_checkbox:checked").length + $(".old_assessment_program_checkbox:checked").length;
    });
  }

  $(document).ready(function() {
    $(".popupcontainer .popupclose").each(function(idx, closer) {
      $(closer).on("click", function() {
          $(closer).closest(".popupcontainer").addClass("popupcontainer-hidden");
          return false;
      });
    });

    $(".popupcontainer .popupdisplay").each(
      function(idx, display) {
        $(display).on("click", function() {
          $(display).closest(".popupcontainer").removeClass("popupcontainer-hidden");
          return false;
        });
        });

    $('.recent_assessment_program_checkbox').on('click', update_assessment_num_selected);
    $('.old_assessment_program_checkbox').on('click', update_assessment_num_selected);

    $('#select_all_recent_assessment_program_checkboxes').on('click', function () {
        if ($('#select_all_recent_assessment_program_checkboxes').attr('checked')) {
            $('.recent_assessment_program_checkbox').each( function () {
                $(this).attr('checked', true);
            });
        }
        else {
            $('.recent_assessment_program_checkbox').each( function () {
                $(this).attr('checked', false);
            });
        }
        update_assessment_num_selected();
    });

    $('#select_all_old_assessment_program_checkboxes').on('click', function () {
        if ($('#select_all_old_assessment_program_checkboxes').attr('checked')) {
            $('.old_assessment_program_checkbox').each( function () {
                $(this).attr('checked', true);
            });
        }
        else {
            $('.old_assessment_program_checkbox').each( function () {
                $(this).attr('checked', false);
            });
        }
        update_assessment_num_selected();
    });
  });
</script>


<!--Div on reports page that shows the assessment responses:  -->
<h3>Assessments Report</h3>
<!--First choose a program (or all programs) and a question (or all questions) from the intake and impact surveys: -->

<span class="helptext">Choose the program you would like to report on, then either export all results or see results by question:</span><br>
<form action="reports.php" method="post">

    <?php
        $num_selected = isset($_POST['program_select']) ? count($_POST['program_select']) : 0;
    ?>
    <div class="popupcontainer popupcontainer-hidden programspopupcontainer">
    <button class="popupdisplay">Select Programs (<span class="numassessmentselected"><?php echo $num_selected; ?></span> Selected)</button>
    <div class="popupinner programspopup">
      <div class="programspopupheader">
        <div class="popupclose x-closer">X</div>
        <button class="popupclose">Select Programs (<span class="numassessmentselected"><?php echo $num_selected; ?></span> Selected)</button>
      </div>
      <div>

    <input type="checkbox" id="select_all_recent_assessment_program_checkboxes"> <b>Select All Recent</b><br>
<?php
    $program_string = " WHERE (Programs.Program_ID = " . $access_array[0];
    foreach ($access_array as $program){
        $program_string .= " OR Programs.Program_ID = " . $program;
    }
    $program_string .= ")";
    $old_date = date("Y-m-d", strtotime("-$num_days_hidden days"));
    $get_all_programs_recent = "SELECT Session_ID, Session_Name, Name, Session_Names.End_Date FROM Session_Names INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID " . $program_string . " AND Session_Names.End_Date > '$old_date' ORDER BY Name";

    include "../include/dbconnopen.php";
    $all_programs = mysqli_query($cnnEnlace, $get_all_programs_recent);
    $checkbox_count = 0;
    while ($program = mysqli_fetch_row($all_programs)) {
        $checkbox_count++;
        ?>

        <input type="checkbox" name="program_select[]" class="recent_assessment_program_checkbox" id="program_checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
        <?php
        if ($_POST['program_select'] && in_array($program[0], $_POST['program_select'])) {
            echo 'checked="true"';
        }
        ?>><?php
               echo "<label for=\"program_checkbox_" . $checkbox_count . "\">" . $program[2] . "--" . $program[1] . "</label><br>";
           }
           include "../include/dbconnclose.php";

    ?>
    <hr>
    <input type="checkbox" id="select_all_old_assessment_program_checkboxes"> <b>Select All Old</b><br>
    <?php
    $get_all_programs_old = "SELECT Session_ID, Session_Name, Name, Session_Names.End_Date FROM Session_Names INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID " . $program_string . " AND Session_Names.End_Date <= '$old_date' ORDER BY Name";

    include "../include/dbconnopen.php";
    $all_programs = mysqli_query($cnnEnlace, $get_all_programs_old);
    while ($program = mysqli_fetch_row($all_programs)) {
        $checkbox_count++;
        ?>

        <input type="checkbox" name="program_select[]" class="old_assessment_program_checkbox" id="program_checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
        <?php
        if ($_POST['program_select'] && in_array($program[0], $_POST['program_select'])) {
            echo 'checked="true"';
        }
        ?>><?php
               echo "<label for=\"program_checkbox_" . $checkbox_count . "\">" . $program[2] . "--" . $program[1] . "</label><br>";
           }
           include "../include/dbconnclose.php";
           ?>

    </div>
    </div>
    </div>

    <!--</select>-->
    <br>
    Start Date: <input type="text" class="addDP" name="assessments_start_date" id="start_3" value="<?php echo $_POST['assessments_start_date']; ?>"></td>
    End Date: <input type="text" class="addDP" name="assessments_end_date" id="end_3" value="<?php echo $_POST['assessments_end_date']; ?>">
    <br>
    Question:
    <select id="assessment_questions" style="width:500px;" name="question_select">
        <option value="0"><b>Show results for all questions</b></option>
        <?php
        $get_baseline_questions = "SELECT * FROM Baseline_Assessment_Questions ORDER BY In_Table";
        include "../include/dbconnopen.php";
        $all_questions = mysqli_query($cnnEnlace, $get_baseline_questions);
        $current_table = "";
        while ($question = mysqli_fetch_row($all_questions)) {
            if ($current_table != $question[2]) {
                $current_table = $question[2];
                ?>
                <option value="0" style="font-weight: bold; background:#b1d1e3;"><b><?php echo $current_table; ?></b></option>
                <?php
            }
            ?>
            <option value="<?php echo $question[0]; ?>" <?php echo ($_POST['question_select'] == $question[0] ? 'selected=="selected"' : null) ?>><?php echo $question[1]; ?></option>
            <?php
        }
        include "../include/dbconnclose.php";
        ?>
    </select>
    <input type="submit" value="Show Results" name="submit_btn_assessments" onclick="return test_program_select();">
        <script>
            function test_program_select() {
                if ($('[name="program_select[]"]:checked').length < 1) {
                    alert('Please check at least one program.');
                    return false;
                }
            }
        </script>
</form>

<?php
/* See results (after program and question have been chosen) */
if (isset($_POST['submit_btn_assessments'])) {
    //remember we have to account for the "show all questions" possibility
    //here it is:
    if ($_POST['question_select'] == '0') {
        include "../include/dbconnopen.php";
        $start_date_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['assessments_start_date']);
        $end_date_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['assessments_end_date']);

        //get question text:
        $get_baseline_questions = "SELECT * FROM Baseline_Assessment_Questions ORDER BY In_Table";
        $all_questions = mysqli_query($cnnEnlace, $get_baseline_questions);
        ?>
        <!--Show results in a table: -->
        <table class="all_projects">
            <tr><th style="width:45%">Question</th>
                <th>Question Response</th><th>Number of youth per response</th><th>Percent of responses<br><span class="helptext">
                        (a percentage of responses to each question in either the pre condition or the post condition)
                    </span></th></tr>
            <?php
            $table = '';
            //go through all the questions:
            while ($question = mysqli_fetch_row($all_questions)) {
                $get_table = "SELECT In_Table FROM Baseline_Assessment_Questions WHERE Baseline_Assessment_Question_ID='" . $question[0] . "'";

                include "../include/dbconnopen.php";
                $table_name = mysqli_query($cnnEnlace, $get_table);
                $this_table = mysqli_fetch_row($table_name);
                ?><!--<tr><td colspan=5><?php echo $this_table[0]; ?></td></tr>--><?php
                        /* if the table has changed, add a row showing the table name: */
                        if ($table != $this_table[0]) {
                            $table = $this_table[0];
                            ?><tr><th colspan="5" class="all_projects"><?php echo $table; ?><hr></th></tr><?php
                }
                if ($table == 'Participants_Baseline_Assessments') {
                    $pre_post = "";
                    $pre_post_denom = "";
                } else {
                    $pre_post = "$table.Pre_Post,";
                    $pre_post_denom = " GROUP BY $table.Pre_Post";
                }

                $date_inner_join = generate_date_inner_join($table, $start_date_sqlsafe, $end_date_sqlsafe);
                $date_where_clause = generate_date_where_clause($table, $start_date_sqlsafe, $end_date_sqlsafe);

                //if no program selected, then certainly don't try to pull from the database based on the program:
                //if ($_POST['program_select']==0){
                if (!isset($_POST['program_select'])) {
                    $get_results = "SELECT COUNT(*) as count, " . $question[0] . ", $pre_post Response_Text FROM " . $table . "
                            INNER JOIN Assessment_Responses ON Response_Select=" . $question[0] .
                            $date_inner_join . "
                                WHERE Question_ID='" . $question[0] . "'" . $date_where_clause . "
                                    GROUP BY $pre_post " . $question[0] . "";
                }
                /* if program selected, pull only assessments from people in that program: */ else {
                /* in order to allow for possibly more than one program chosen, let's loop through program_select POST, since
                     * if it's checkboxes it'll come in an array: */
                    $program_string = "(Program=";
                    $counter = 0;
                    foreach ($_POST['program_select'] as $program) {
                        $program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $program);
                        $counter++;
                        $program_string.= " " . $program_sqlsafe . " ";
                        if ($counter < count($_POST['program_select'])) {
                            $program_string.= "OR Program=";
                        } else {
                            $program_string.=")";
                        }
                    }
                    $get_results = "SELECT COUNT(*) as count, " . $question[0] . ", $pre_post Response_Text FROM " . $table . "
                            INNER JOIN Assessment_Responses ON Response_Select=" . $question[0] .
                            $date_inner_join . "
                                WHERE " . $program_string . $date_where_clause . " AND Question_ID='" . $question[0] . "'
                                    GROUP BY $pre_post " . $question[0] . "";
                }
                $show_results = mysqli_query($cnnEnlace, $get_results);
                $current_question = "";
                $current_timing = "";
                while ($result = mysqli_fetch_row($show_results)) {
                    //need to find the denominator based on pre/post and program (and whether those are applicable)
                    //so far so reasonably good, but it doesn't really work for the pre/post/null denominators.  need to differentiate those earlier.
                    //if ($_POST['program_select']==0){
                    if (!isset($_POST['program_select'])) {
                        if ($table != 'Participants_Baseline_Assessments') {
                            $get_denom = "SELECT COUNT(*) FROM $table WHERE Pre_Post=" . $result[2] . $date_where_clause;
                        } else {
                            $get_denom = "SELECT COUNT(*) FROM $table" . str_replace("AND", "WHERE", $date_where_clause);
                        }
                    } else {
                        if ($table != 'Participants_Baseline_Assessments') {
                            $get_denom = "SELECT COUNT(*) FROM $table WHERE " . $program_string . " AND Pre_Post=" . $result[2] . $date_where_clause;
                        } else {
                            $get_denom = "SELECT COUNT(*) FROM $table WHERE " . $program_string . $date_where_clause;
                        }
                    }
                    $denom_ct = mysqli_query($cnnEnlace, $get_denom);
                    $this_denom = mysqli_fetch_row($denom_ct);
                    $denom = $this_denom[0];
                    ?><tr>
                        <td class="all_projects"><?php
                            /* If question has changed, show new question */
                            if ($current_question != $question[1]) {
                                echo $question[1];
                                $current_question = $question[1];
                            }
                            ?></td>
                        <?php
                        if ($table != 'Participants_Baseline_Assessments') {
                            if ($current_timing != $result[2]) {
                                /* if pre has become post, or vice versa, echo the new type of survey: */
                                $current_timing = $result[2];
                                if ($current_timing == 1) {
                                    ?>
                                <tr><td class="all_projects" colspan="2"><i>Pre-test (total: <?php echo $denom ?>)</i></td></tr>
                                <?php
                                } elseif ($current_timing == 2) {
                                    ?>
                                    <tr><td class="all_projects" colspan="2"><i>Post-test (total: <?php echo $denom ?>)</i></td></tr>
                                    <?php
                                }
                            }
                        } else {
                            if ($current_timing == "") {
                                $current_timing = "Baseline";
                                ?>
                                    <tr><td class="all_projects" colspan="2"><i>Baseline (total: <?php echo $denom ?>)</i></td></tr>
                                <?php
                            }
                        }
                    ?><tr><td class="all_projects"></td>
                        <td class="all_projects"><?php
                            /* show pre/post, unless still in baseline assessment, which is only pre */
                            if ($table != 'Participants_Baseline_Assessments') {
                                echo $result[3];
                            } else {
                                echo $result[2];
                            }
                            ?></td>
                        <td class="all_projects"><?php echo $result[0]; ?></td>
                        <td class="all_projects"><?php
                            if ($denom != 0) {
                                echo number_format(($result[0] / $denom) * 100) . "%";
                            } else {
                                echo 'N/A';
                            }
                            ?></td>
                    </tr><?php
                }
            }
            ?>
        </table>
        <?php
        //end all questions case
    }
    /* if a question is selected: */ else {
        include "../include/dbconnopen.php";
        $question_select_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['question_select']);
        $get_table = "SELECT In_Table FROM Baseline_Assessment_Questions WHERE Baseline_Assessment_Question_ID='" . $question_select_sqlsafe . "'";
        $table_name = mysqli_query($cnnEnlace, $get_table);
        $this_table = mysqli_fetch_row($table_name);
        $table = $this_table[0];

        /* only get the pre_post variable for tables that aren't the baseline assessment.  that is only "pre" */
        if ($table == 'Participants_Baseline_Assessments') {
            $pre_post = "";
            $pre_post_denom = "";
        } else {
            $pre_post = "Pre_Post,";
            $pre_post_denom = " GROUP BY Pre_Post";
        }
        $date_where_clause = generate_date_where_clause($table, $start_date_sqlsafe, $end_date_sqlsafe);

        //if no program selected, then certainly don't try to pull from the database based on the program:
        //if ($_POST['program_select']==0){
        if (!isset($_POST['program_select'])) {
            $get_results = "SELECT COUNT(*) as count, " . $question_select_sqlsafe . ", $pre_post Response_Text FROM " . $table . "
        INNER JOIN Assessment_Responses ON Response_Select=" . $question_select_sqlsafe .
        $date_inner_join . "
            WHERE Question_ID='" . $question_select_sqlsafe . "'" . $date_where_clause . "
                GROUP BY $pre_post " . $question_select_sqlsafe . "";
            $get_denom = "SELECT COUNT(*) FROM $table " . str_replace("AND", "WHERE", $date_where_clause) . " $pre_post_denom";
            $denom_ct = mysqli_query($cnnEnlace, $get_denom);
            /* $this_denom=mysqli_fetch_row($denom_ct);
              $denom=$this_denom[0]; */
            if ($table == 'Participants_Baseline_Assessments') {
                $this_denom = mysqli_fetch_row($denom_ct);
                $denom = $this_denom[0];
            } else {
                $get_denom = "SELECT COUNT(*), Pre_Post FROM $table " . $date_inner_join .
                            str_replace("AND", "WHERE", $date_where_clause) . " $pre_post_denom";
                $denom_ct = mysqli_query($cnnEnlace, $get_denom);
                while ($this_denom = mysqli_fetch_row($denom_ct)) {
                    if ($this_denom[1] == '1') {
                        $pre_denom = $this_denom[0];
                    } elseif ($this_denom[1] == '2') {
                        $post_denom = $this_denom[0];
                    }
                }
            }
        }
        /* if a program is selected: */ else {
            $get_results = "SELECT COUNT(*) as count, " . $question_select_sqlsafe . ", $pre_post Response_Text FROM " . $table . "
        INNER JOIN Assessment_Responses ON Response_Select=" . $question_select_sqlsafe .
        $date_inner_join . "
            WHERE Program=" . $program_select_sqlsafe . $date_where_clause . " AND Question_ID='" . $question_select_sqlsafe . "'
                GROUP BY $pre_post " . $question_select_sqlsafe . "";
            $program_string = "(Program=";
            $counter = 0;
            foreach ($_POST['program_select'] as $program) {
                $counter++;
                $program_string.= " " . $program . " ";
                if ($counter < count($_POST['program_select'])) {
                    $program_string.= "OR Program=";
                } else {
                    $program_string.=")";
                }
            }
            $get_results = "SELECT COUNT(*) as count, " . $question_select_sqlsafe . ", $pre_post Response_Text FROM " . $table . "
        INNER JOIN Assessment_Responses ON Response_Select=" . $question_select_sqlsafe .
        $date_inner_join . "
            WHERE " . $program_string . $date_where_clause . " AND Question_ID='" . $question_select_sqlsafe . "'
                GROUP BY $pre_post " . $question_select_sqlsafe . "";

            /* get the denominator for these results (in order to show the percentage) */
            $get_denom = "SELECT COUNT(*) FROM $table $date_inner_join WHERE Program=" . $program_select_sqlsafe . $date_where_clause . " $pre_post_denom ";
            $get_denom = "SELECT COUNT(*) FROM $table $date_inner_join WHERE " . $program_string . $date_where_clause . " $pre_post_denom ";

            $denom_ct = mysqli_query($cnnEnlace, $get_denom);
            if ($table == 'Participants_Baseline_Assessments') {
                $this_denom = mysqli_fetch_row($denom_ct);
                $denom = $this_denom[0];
            } else {
                $get_denom = "SELECT COUNT(*), Pre_Post FROM $table $date_inner_join WHERE Program=" . $program_select_sqlsafe . $date_where_clause . " $pre_post_denom ";
                $get_denom = "SELECT COUNT(*), Pre_Post FROM $table $date_inner_join WHERE " . $program_string . $date_where_clause .  " $pre_post_denom ";
                $denom_ct = mysqli_query($cnnEnlace, $get_denom);
                while ($this_denom = mysqli_fetch_row($denom_ct)) {
                    if ($this_denom[1] == '1') {
                        $pre_denom = $this_denom[0];
                    } elseif ($this_denom[1] == '2') {
                        $post_denom = $this_denom[0];
                    }
                }
            }
        }

        $show_results = mysqli_query($cnnEnlace, $get_results);
        ?><p></p>
        <table class="all_projects">
            <caption><?php
                $get_question = "SELECT Question FROM Baseline_Assessment_Questions WHERE Baseline_Assessment_Question_ID='" . $question_select_sqlsafe . "'";
                $this_question = mysqli_query($cnnEnlace, $get_question);
                $quest = mysqli_fetch_row($this_question);
                echo $quest[0];
                ?></caption>
            <tr>
                <?php //if ($table!='Participants_Baseline_Assessments'){    ?><!--<th>Pre or Post</th>--><?php //}   ?>
                <th>Question Response</th><th>Number of youth per response</th><th>Percent of responses<br><span class="helptext">
                        (a percentage of responses to each question in either the pre condition or the post condition)
                    </span></th></tr>
            <?php
            $current_timing = "";
            while ($result = mysqli_fetch_row($show_results)) {
                if ($table != 'Participants_Baseline_Assessments') {
                    ?>
                    <!--
                    <td class="all_projects">
                    <?php
                    if ($result[2] == 1) {
                        echo 'Pre';
                    } elseif ($result[2] == 2) {
                        echo 'Post';
                    }
                    ?></td>-->
                    <?php
                    /* show pre/post if not in the baseline assessment, which is only "pre" */
                    if ($current_timing != $result[2]) {
                        $current_timing = $result[2];
                        if ($current_timing == 1) {
                            ?>
                            <tr><td class="all_projects" colspan="2"><i>Pre-test (total: <?php echo $pre_denom ?>)</i></td></tr>
                            <?php
                        } elseif ($current_timing == 2) {
                            ?>
                            <tr><td class="all_projects" colspan="2"><i>Post-test (total: <?php echo $post_denom ?>)</i></td></tr>
                            <?php
                        }
                    }
                } else {
                    if ($current_timing == "") {
                        $current_timing = "Baseline";
                        ?>
                            <tr><td class="all_projects" colspan="2"><i>Baseline (total: <?php echo $denom ?>)</i></td></tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td class="all_projects"><?php
                        if ($table != 'Participants_Baseline_Assessments') {
                            echo $result[3];
                        } else {
                            echo $result[2];
                        }
                        ?></td>
                    <td class="all_projects"><?php echo $result[0]; ?></td>
                    <td class="all_projects"><?php
                        //need to find the denominator based on pre/post and program (and whether those are applicable)
                        //so far so reasonably good, but it doesn't really work for the pre/post/null denominators.  need to differentiate those earlier.

                        if ($table == 'Participants_Baseline_Assessments') {
                            echo number_format(($result[0] / $denom) * 100) . "%";
                        } else {
                            if ($current_timing == 1) {
                                echo number_format(($result[0] / $pre_denom) * 100) . "%";
                            } elseif ($current_timing == 2) {
                                echo number_format(($result[0] / $post_denom) * 100) . "%";
                            }
                        }
                        ?></td>
                </tr>
                <?php
            }
            ?>
        </table><?php
    }
//end specific question case
}
?>
