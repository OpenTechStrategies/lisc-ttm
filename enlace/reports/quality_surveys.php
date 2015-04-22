<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($Enlace_id);

//get user's access
//
// *First determine the program that the logged-in user has access to.  Usually this will be a program ID number,
// *but sometimes it will be 'a' (all) or 'n' (none).
$access_array = $USER->program_access($Enlace_id);

$has_all_programs = in_array('a', $access_array);

?>

<h3>Program Quality Report</h3>

<form action="reports.php" method="post">
    Program:
    <select id="all_programs" name="program_select">
        <?php
        //if not an administrator
    if ( $has_all_programs) {
            ?>
            <option value="0">Show results for all programs</option>
            <?php
            $get_all_programs = "SELECT Session_ID, Session_Name, Name FROM Session_Names
                        INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID
                        ORDER BY Name";
    }
    else{
            //get user's programs
            $get_all_programs = "SELECT Session_ID, Session_Name, Name FROM Session_Names
                        INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID
                        AND Programs.Program_ID = " . $access_array[0] . "
                        ORDER BY Name";
    }

        include "../include/dbconnopen.php";
        $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
        while ($program = mysqli_fetch_row($all_programs)) {
            ?>
            <option value="<?php echo $program[0]; ?>" <?php echo ($_POST['program_select'] == $program[0] ? 'selected=="selected"' : null) ?>>
                <?php echo $program[2] . ': ' . $program[1]; ?></option>
            <?php
        }
        include "../include/dbconnclose.php";
        ?>
    </select>

    <?php
    /* associate text with column names. */
    $question_text_array = array("Question_1" => "I get chances to do things with other people my age.",
        "Question_2" => "I feel safe.",
        "Question_3" => "I feel respected by program staff.",
        "Question_4" => "I have to do what's planned, no matter what.",
        "Question_5" => "I'm usually bored.",
        "Question_6" => "I get to decide what activities I'm going to do here.",
        "Question_7" => "I feel like I belong here.",
        "Question_8" => "I have a chance to learn how to do new things here.",
        "Question_9" => "I wish I didn't have to attend this program.",
        "Question_10" => "The staff here challenges me to do my best.",
        "Question_11" => "I feel like my ideas count.",
        "Question_12" => "The staff know me well.",
        "Question_13" => "I have the chance to develop skills.",
        "Question_14" => "I have the chance to develop friendships with other students.",
        "Question_15" => " If I didn't show up, someone would notice that I'm not here.",
        "Question_16" => "I feel like I matter.");
    $question_id_array = array("Question_1", "Question_2", "Question_3", "Question_4", "Question_6", "Question_7", "Question_8", "Question_9",
        "Question_10", "Question_11", "Question_12", "Question_13", "Question_14", "Question_15", "Question_16");
    ?>
    <select name="question_select">
        <option value="0">Show results for all questions</option>
        <option value="0">At this program...</option>
        <option value="0"></option>
        <?php
//$counter=0;
        foreach ($question_text_array as $key => $question) {
            ?>
            <option value="<?php echo $key ?>" <?php echo ($_POST['question_select'] == $key ? 'selected=="selected"' : null) ?>>
                <?php echo $question; ?></option>
            <?php
            $counter++;
        }
        ?>
    </select>
    <input type="submit" value="Search" name="submit_quality">
</form>
<br />
<br />
<br />


<!--Show results here: -->

<?php
if (isset($_POST['submit_quality'])) {
    $program_select_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program_select']);
    $question_select_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['question_select']);
    /* show results with no question selected (i.e. show all questions) */
    if ($_POST['question_select'] == '0') {
        ?>

        <table class="all_projects">
            <tr><th>Question Text</th><th>Question Responses</th><th>Number of each response</th><th>Percent of respondents</th></tr>
            <?php
            /* get denominator for percentages: */
            $get_denom = "SELECT COUNT(*) FROM Program_Surveys";
            if ($_POST['program_select'] != 0) {
                $get_denom = "SELECT COUNT(*) FROM Program_Surveys WHERE Session_ID='" . $program_select_sqlsafe . "'";
            }

            include "../include/dbconnopen.php";
            $denoms = mysqli_query($cnnEnlace, $get_denom);
            $denom = mysqli_fetch_row($denoms);
            $denominator = $denom[0];
            $current_question = "";
            foreach ($question_text_array as $key => $question) {
                $get_responses = "SELECT COUNT(*) as count, " . $key . " FROM Program_Surveys GROUP BY " . $key;
                if ($_POST['program_select'] != 0) {
                    $get_responses = "SELECT COUNT(*) as count, " . $key . " FROM Program_Surveys 
                    WHERE Session_ID='" . $program_select_sqlsafe . "' GROUP BY " . $key;
                }
                // echo $get_responses . "<br>";
                $responses = mysqli_query($cnnEnlace, $get_responses);
                while ($resp = mysqli_fetch_row($responses)) {
                    ?>
                    <tr><td class="all_projects"><?php
                            /* if the question has changed, then show the new question. */
                            if ($current_question != $question) {
                                $current_question = $question;
                                echo "<strong>" . $current_question . "</strong>";
                            }
                            ?></td>
                        <td class="all_projects"><?php
                            if ($resp[1] == 0) {
                                echo 'N/A';
                            } elseif ($resp[1] == 1) {
                                echo 'Strongly disagree';
                            } elseif ($resp[1] == 2) {
                                echo 'Disagree';
                            } elseif ($resp[1] == 3) {
                                echo 'Agree';
                            } elseif ($resp[1] == 4) {
                                echo 'Strongly agree';
                            }
                            ?></td><td class="all_projects"><?php echo $resp[0]; ?></td>
                        <td class="all_projects"><?php echo number_format(($resp[0] / $denominator) * 100) . '%'; ?></td></tr>
                    <?php
                }
            }
            ?></table>
            <?php
            include "../include/dbconnclose.php";
        } else {

            //if a question is selected but a program isn't selected: 
            if ($_POST['program_select'] == 0) {
                ?>

            <table class="all_projects">
                <caption><?php echo $question_text_array[$_POST['question_select']] ?></caption>
                <tr><th>Question Responses</th><th>Number of each response</th><th>Percent of respondents</th></tr>

                <?php
                /* get answers to the selected question, group count by the answer to the question. */
                $get_responses = "SELECT COUNT(*) as count, " . $question_select_sqlsafe . " FROM Program_Surveys 
        GROUP BY " . $question_select_sqlsafe;
                /* get denominator for percentages: */
                $get_denom = "SELECT COUNT(*) FROM Program_Surveys";

                include "../include/dbconnopen.php";
                $responses = mysqli_query($cnnEnlace, $get_responses);
                $denoms = mysqli_query($cnnEnlace, $get_denom);
                $denom = mysqli_fetch_row($denoms);
                $denominator = $denom[0];
                while ($resp = mysqli_fetch_row($responses)) {
                    ?>
                    <tr><td class="all_projects"><?php
                            //for no answers, show n/a
                            if ($resp[1] == 0) {
                                echo 'N/A';
                            } elseif ($resp[1] == 1) {
                                echo 'Strongly disagree';
                            } elseif ($resp[1] == 2) {
                                echo 'Disagree';
                            } elseif ($resp[1] == 3) {
                                echo 'Agree';
                            } elseif ($resp[1] == 4) {
                                echo 'Strongly agree';
                            }
                            ?></td><td class="all_projects"><?php echo $resp[0]; ?></td>
                        <td class="all_projects"><?php echo number_format(($resp[0] / $denominator) * 100, 2) . '%'; ?></td></tr>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?>
            </table>
            <?php
        } else {
            //if a program is selected AND a question is selected:
            ?>
            <table class="all_projects">
                <caption><?php echo $question_text_array[$_POST['question_select']]; ?></caption>
                <tr>
                    <th>
                        Question Responses
                    </th>
                    <th>
                        Number of each response
                    </th>
                    <th>
                        Percent of respondents
                    </th>
                </tr>
                <?php
                //get responses to this question for this program.
                $get_responses = "SELECT COUNT(*) as count, " . $question_select_sqlsafe . " FROM Program_Surveys 
        WHERE Session_ID='" . $program_select_sqlsafe . "' GROUP BY " . $question_select_sqlsafe;
                $get_denom = "SELECT COUNT(*) FROM Program_Surveys WHERE Session_ID='" . $program_select_sqlsafe . "'";

                include "../include/dbconnopen.php";
                $responses = mysqli_query($cnnEnlace, $get_responses);
                $denoms = mysqli_query($cnnEnlace, $get_denom);
                $denom = mysqli_fetch_row($denoms);
                $denominator = $denom[0];
                while ($resp = mysqli_fetch_row($responses)) {
                    ?>
                    <tr>
                        <td class="all_projects"><?php
                            if ($resp[1] == 0) {
                                echo 'N/A';
                            } elseif ($resp[1] == 1) {
                                echo 'Strongly disagree';
                            } elseif ($resp[1] == 2) {
                                echo 'Disagree';
                            } elseif ($resp[1] == 3) {
                                echo 'Agree';
                            } elseif ($resp[1] == 4) {
                                echo 'Strongly agree';
                            }
                            ?></td>
                        <td class="all_projects">
                            <?php echo $resp[0]; ?>
                        </td>
                        <td class="all_projects">
                            <?php echo number_format(($resp[0] / $denominator) * 100, 2) . '%'; ?>
                        </td>
                    </tr>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
            </table>
            <?php
        }
    }
}
?>
<br />
<br />
<br />