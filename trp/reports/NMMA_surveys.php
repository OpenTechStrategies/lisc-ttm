<?php
include "../../header.php";
include "../header.php";
include "report_menu.php";

/* this report shows the pre and post average responses to the identity survey.  Again, the traditions survey
 * is short-answer format, so doesn't lend itself to easy summary. */
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#reports_selector').addClass('selected');
    });
</script>
<h3>Cultural Identity Surveys</h3>

<!--This is the report table, with all the numbers-->
<table style="font-size: .8em;
       padding: 7px;
       border: 2px solid #696969;
       border-collapse: collapse;
       width:100%;">
    <tr>
        <th>Question</th>
        <th>Pre-Survey</th>
        <th>Post-Survey</th>
    </tr>
    <?php
//this array holds all the names of the columns I want to pull
    $question_array = array('Q1',
        'Q2',
        'Q3',
        'Q4',
        'Q5',
        'Q6',
        'Q7',
        'Q8',
        'Q9',
        'Q10',
        'Q11');
    //This array holds the names of those columns as they should be shown.
    $text_array_grade_3 = array('Do you think you can explain what culture is?',
        'How much do you know about your home culture?',
        'Do you enjoy activities connected with your culture at home?',
        'Do you think you have a great understanding of your cultural background?',
        'Do you think that your family can support you when you need help?',
        'Do you think that your community can support you when you need help?',
        'Do you think of your culture as a source of strength when you need help?',
        'Do you think that you can make a difference in shaping your own future?',
        'Do you think that your cultural values help you make good decisions?',
        'Do you think that your cultural values will help you in the future?',
        'Do you think that you have great personal qualities?');


    //the question_count keeps track of where we are in the arrays above.
    $question_count = 0;

    //this loop traverses the columns above and builds a table row for each of the questions.
    foreach ($question_array as $question) {
        ?>
        <tr>
            <td class="all_projects"  style="text-align:left;width:200px">
                <?php
                /* echo question text */
                echo $text_array_grade_3[$question_count];
                ?></td>

            <?php
            $array_lngth_counter = 0;
            $script_str = '';
            /* I'm not sure where the start and end date are meant to come from: */
            $date_reformat = explode('-', $_POST['start_date']);
            $start_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
            $date_reformat = explode('-', $_POST['end_date']);
            $end_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];

            include "../include/dbconnopen.php";
            $call_for_arrays_sqlsafe = "CALL Survey__Cultural_Identity('" . $question . "', '" . mysqli_real_escape_string($cnnTRP, $start_date) . "', '" . mysqli_real_escape_string($cnnTRP, $end_date) . "', 'pre')";

            $questions = mysqli_query($cnnTRP, $call_for_arrays_sqlsafe);
            ?><td class="all_projects" style="text-align:left;"><?php
            $num_options = mysqli_num_rows($questions);
            $avg_numer = 0;
            while ($survey = mysqli_fetch_row($questions)) {
                /* while we loop through the responses to this question */
                foreach ($survey as $key => $value) {
                    //creates the correct text for the table
                    if ($key == 0) {
                        if ($value == 0) {
                            $string.= "(0) N/A: ";
                        }
                        if ($value == 1) {
                            $string.= "(1) Don't Know: ";
                        }
                        if ($value == 2) {
                            $string.= "(2) Not much: ";
                        }
                        if ($value == 3) {
                            $string.= "(3) Very little: ";
                        }
                        if ($value == 4) {
                            $string.= "(4) Somewhat: ";
                        }
                        if ($value == 5) {
                            $string.= "(5) Quite a bit: ";
                        }
                        if ($value == 6) {
                            $string.="(6) Very much: ";
                        }
                        $avg_numer+=$value;
                    }
                    if ($key == 1) {
                        $string.= $value . "<br>";
                    }
                    echo $string;
                    $string = '';
                }
                $array_lngth_counter++;
            }
            echo "<br><strong>Average:</strong> ";
            if ($num_options == 0) {
                echo "0.0";
            } else {
                try {
                    echo number_format($avg_numer / $num_options, 1);
                } catch (Exception $e) {}
            }
            ?>

            </td>
            <td class="all_projects" style="text-align:left;">
                <?php
                /* same thing but for post surveys: */
                $array_lngth_counter = 0;
                $script_str = '';
                $date_reformat = explode('-', $_POST['start_date']);
                $start_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
                $date_reformat = explode('-', $_POST['end_date']);
                $end_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];

                include "../include/dbconnopen.php";
                $call_for_arrays_sqlsafe = "CALL Survey__Cultural_Identity('" . $question . "', '" . mysqli_real_escape_string($cnnTRP, $start_date) . "', '" . mysqli_real_escape_string($cnnTRP, $end_date) . "', 'post')";

                $questions = mysqli_query($cnnTRP, $call_for_arrays_sqlsafe);
                ?><?php
                $num_options = mysqli_num_rows($questions);
                $avg_numer = 0;
                while ($survey = mysqli_fetch_row($questions)) {
                    foreach ($survey as $key => $value) {
                        //creates the correct arrays for legends, below
                        if ($key == 0) {
                            if ($value == 0) {
                                $string.= "(0) N/A: ";
                            }
                            if ($value == 1) {
                                $string.= "(1) Don't Know: ";
                            }
                            if ($value == 2) {
                                $string.= "(2) Not much: ";
                            }
                            if ($value == 3) {
                                $string.= "(3) Very little: ";
                            }
                            if ($value == 4) {
                                $string.= "(4) Somewhat: ";
                            }
                            if ($value == 5) {
                                $string.= "(5) Quite a bit: ";
                            }
                            if ($value == 6) {
                                $string.="(6) Very much: ";
                            }
                            $avg_numer+=$value;
                        }
                        if ($key == 1) {
                            $string.= $value . "<br>";
                        }
                        echo $string;
                        $string = '';
                    }
                    $array_lngth_counter++;
                }
                echo "<br><strong>Average:</strong> ";
                if ($num_options == 0) {
                    echo "0.0";
                } else {
                    try {
                        echo number_format($avg_numer / $num_options, 1);
                    } catch (Exception $e) {}
                } 
                ?>
            </td> 
        </tr>
        <?php
        $question_count++;
    }
    ?>
</table>
<br />
<br />

<?php include "../../footer.php"; ?>
