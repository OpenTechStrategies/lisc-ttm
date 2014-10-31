<?php
require_once("../siteconfig.php");
?>
<?php
//get user's access
//
// *First determine the program that the logged-in user has access to.  Usually this will be a program ID number,
// *but sometimes it will be 'a' (all) or 'n' (none).
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
$user_sqlsafe=mysqli_real_escape_string($cnnLISC, $_COOKIE['user']);
$get_program_access = "SELECT Program_Access FROM Users_Privileges INNER JOIN Users ON Users.User_Id = Users_Privileges.User_ID
    WHERE User_Email = '" .$user_sqlsafe . "'";
$program_access = mysqli_query($cnnLISC, $get_program_access);
$prog_access = mysqli_fetch_row($program_access);
$access = $prog_access[0];
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>

<!--Div on reports page that shows the assessment responses:  -->
<h3>Assessments Report</h3>
<?php //print_r($_POST);?>
<!--First choose a program (or all programs) and a question (or all questions) from the intake and impact surveys: -->

<span class="helptext">Choose the program you would like to report on, then either export all results or see results by question:</span><br>
<form action="reports.php" method="post">
    Program:
    <!--<select id="all_programs" name="program_select">
        <option value="0">Show results for all programs</option>-->
    <a href="javascript:;" onclick="$('#program_list').toggle();">Show/hide programs</a>
    <div id="program_list"><?php
        //if not an administrator
        if ($access != 'a') {
            //get user's programs
            $get_all_programs = "SELECT Session_ID, Session_Name, Name FROM Session_Names INNER JOIN Programs 
                            ON Session_Names.Program_ID=Programs.Program_ID
                            WHERE Programs.Program_ID = " . $access . " ORDER BY Name";
        } else {
            $get_all_programs = "SELECT Session_ID, Session_Name, Name FROM Session_Names INNER JOIN Programs 
                            ON Session_Names.Program_ID=Programs.Program_ID ORDER BY Name";
        }

        include "../include/dbconnopen.php";
        $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
        $checkbox_count = 0;
        while ($program = mysqli_fetch_row($all_programs)) {
            $checkbox_count++;
            ?>
            <!--
            <option value="<?php echo $program[0]; ?>" <?php echo ($_POST['program_select'] == $program[0] ? 'selected=="selected"' : null) ?>><?php echo $program[2] . "--" . $program[1]; ?></option>
            -->
            <input type="checkbox" name="program_select[]" id="checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
            <?php
            if ($_POST['program_select[]']) {
                echo (in_array($program[0], $_POST['program_select[]']) ? 'checked="true"' : null);
            }
            ?>><?php
                   echo "<label for=\"checkbox_" . $checkbox_count . "\">" . $program[2] . "--" . $program[1] . "</label><br>";
               }
               include "../include/dbconnclose.php";
               ?>
    </div>
    <!--</select>-->
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
    <input type="submit" value="Show Results" name="submit_btn_assessments"
    <?php
    //if not an administrator
    if ($access != 'a') {
        //make sure a checkbox is checked
        ?>
               onclick="return test_program_select();"
               <?php
           }
           ?>>
           <?php
           //if not an administrator
           if ($access != 'a') {
               //make sure a checkbox is checked
               ?>
        <script>
            function test_program_select() {
                //alert($('[name="program_select[]"]:checked]').length);
                if ($('[name="program_select[]"]:checked').length < 1) {
                    alert('Please check at least one program.');
                    return false;
                }
            }
        </script>
        <?php
    }
    ?>
</form>

<?php
/* See results (after program and question have been chosen) */
if (isset($_POST['submit_btn_assessments'])) {
    // print_r($_POST);
    //remember we have to account for the "show all questions" possibility
    //here it is:
    if ($_POST['question_select'] == '0') {
        //get question text:
        $get_baseline_questions = "SELECT * FROM Baseline_Assessment_Questions ORDER BY In_Table";
        include "../include/dbconnopen.php";
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
                    $pre_post = "Pre_Post,";
                    $pre_post_denom = " GROUP BY Pre_Post";
                }

                //if no program selected, then certainly don't try to pull from the database based on the program:
                //if ($_POST['program_select']==0){
                if (!isset($_POST['program_select'])) {
                    $get_results = "SELECT COUNT(*) as count, " . $question[0] . ", $pre_post Response_Text FROM " . $table . "
                            INNER JOIN Assessment_Responses ON Response_Select=" . $question[0] . " 
                                WHERE Question_ID='" . $question[0] . "'
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
                    //  echo $program_string;
                    $get_results = "SELECT COUNT(*) as count, " . $question[0] . ", $pre_post Response_Text FROM " . $table . "
                            INNER JOIN Assessment_Responses ON Response_Select=" . $question[0] . " 
                                WHERE " . $program_string . " AND Question_ID='" . $question[0] . "'
                                    GROUP BY $pre_post " . $question[0] . "";
                    // echo $get_results;
                }
                //echo $get_results;
                $show_results = mysqli_query($cnnEnlace, $get_results);
                $current_question = "";
                $current_timing = "";
                while ($result = mysqli_fetch_row($show_results)) {
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
                                <tr><td class="all_projects" colspan="2"><i>Pre-test</i></td></tr>
                                <?php
                            } elseif ($current_timing == 2) {
                                ?>
                                <tr><td class="all_projects" colspan="2"><i>Post-test</i></td></tr>
                                <?php
                            }
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
                            //need to find the denominator based on pre/post and program (and whether those are applicable)
                            //so far so reasonably good, but it doesn't really work for the pre/post/null denominators.  need to differentiate those earlier.
                            //if ($_POST['program_select']==0){
                            $program_select_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program_select']);
                            if (!isset($_POST['program_select'])) {
                                if ($table != 'Participants_Baseline_Assessments') {
                                    $get_denom = "SELECT COUNT(*) FROM $table WHERE Pre_Post=" . $result[2];
                                } else {
                                    $get_denom = "SELECT COUNT(*) FROM $table";
                                }
                            } else {
                                if ($table != 'Participants_Baseline_Assessments') {
                                    $get_denom = "SELECT COUNT(*) FROM $table WHERE Program=" . $program_select_sqlsafe . " AND Pre_Post=" . $result[2];
                                    $get_denom = "SELECT COUNT(*) FROM $table WHERE " . $program_string . " AND Pre_Post=" . $result[2];
                                } else {
                                    $get_denom = "SELECT COUNT(*) FROM $table WHERE Program=" . $program_select_sqlsafe . "";
                                    $get_denom = "SELECT COUNT(*) FROM $table WHERE " . $program_string . "";
                                }
                            }
                            //echo $get_denom;
                            $denom_ct = mysqli_query($cnnEnlace, $get_denom);
                            $this_denom = mysqli_fetch_row($denom_ct);
                            $denom = $this_denom[0];
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

        //if no program selected, then certainly don't try to pull from the database based on the program:
        //if ($_POST['program_select']==0){
        if (!isset($_POST['program_select'])) {
            $get_results = "SELECT COUNT(*) as count, " . $question_select_sqlsafe . ", $pre_post Response_Text FROM " . $table . "
        INNER JOIN Assessment_Responses ON Response_Select=" . $question_select_sqlsafe . " 
            WHERE Question_ID='" . $question_select_sqlsafe . "'
                GROUP BY $pre_post " . $question_select_sqlsafe . "";
            $get_denom = "SELECT COUNT(*) FROM " . $table . " $pre_post_denom";
            //echo $get_denom;
            $denom_ct = mysqli_query($cnnEnlace, $get_denom);
            /* $this_denom=mysqli_fetch_row($denom_ct);
              $denom=$this_denom[0]; */
            // echo $table;
            if ($table == 'Participants_Baseline_Assessments') {
                $this_denom = mysqli_fetch_row($denom_ct);
                $denom = $this_denom[0];
            } else {
                //   echo 'not baseline';
                $get_denom = "SELECT COUNT(*), Pre_Post FROM $table  $pre_post_denom ";
                // echo $get_denom;
                $denom_ct = mysqli_query($cnnEnlace, $get_denom);
                while ($this_denom = mysqli_fetch_row($denom_ct)) {
                    if ($this_denom[1] == '1') {
                        $pre_denom = $this_denom[0];
                    } elseif ($this_denom[1] == '2') {
                        $post_denom = $this_denom[0];
                    }
                }
                //  echo $pre_denom . "<br>" . $post_denom;
            }
        }
        /* if a program is selected: */ else {
            $get_results = "SELECT COUNT(*) as count, " . $question_select_sqlsafe . ", $pre_post Response_Text FROM " . $table . "
        INNER JOIN Assessment_Responses ON Response_Select=" . $question_select_sqlsafe . " 
            WHERE Program=" . $program_select_sqlsafe . " AND Question_ID='" . $question_select_sqlsafe . "'
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
        INNER JOIN Assessment_Responses ON Response_Select=" . $question_select_sqlsafe . " 
            WHERE " . $program_string . " AND Question_ID='" . $question_select_sqlsafe . "'
                GROUP BY $pre_post " . $question_select_sqlsafe . "";

            /* get the denominator for these results (in order to show the percentage) */
            $get_denom = "SELECT COUNT(*) FROM $table WHERE Program=" . $program_select_sqlsafe . " $pre_post_denom ";
            $get_denom = "SELECT COUNT(*) FROM $table WHERE " . $program_string . " $pre_post_denom ";

            $denom_ct = mysqli_query($cnnEnlace, $get_denom);
            if ($table == 'Participants_Baseline_Assessments') {
                $this_denom = mysqli_fetch_row($denom_ct);
                $denom = $this_denom[0];
            } else {
                $get_denom = "SELECT COUNT(*), Pre_Post FROM $table WHERE Program=" . $program_select_sqlsafe . " $pre_post_denom ";
                $get_denom = "SELECT COUNT(*), Pre_Post FROM $table WHERE " . $program_string . " $pre_post_denom ";
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
                            <tr><td class="all_projects" colspan="2"><i>Pre-test</i></td></tr>
                            <?php
                        } elseif ($current_timing == 2) {
                            ?>
                            <tr><td class="all_projects" colspan="2"><i>Post-test</i></td></tr>
                            <?php
                        }
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
