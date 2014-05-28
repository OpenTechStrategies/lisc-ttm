<?php //include "../../header.php";  ?>
<div id="satisfaction">
    <!--Set up similarly to the parent mentor surveys, but less complicated. -->
    <?php
    if (isset($_POST['satisfaction_program']) || isset($_POST['start_date'])) {
        /* if a program or dates were chosen: */
        ?><h4>Satisfaction Surveys: <?php
            $get_program_name = "SELECT Subcategory_Name FROM Subcategories WHERE Subcategory_ID=" . $_POST['satisfaction_program'];
            include "../include/dbconnopen.php";
            if ($program_name = mysqli_query($cnnLSNA, $get_program_name)) {
                $name = mysqli_fetch_row($program_name);
                $this_program = $name[0];
            }
            include "../include/dbconnclose.php";
            echo $this_program . " " . $_POST['start_date'] . " -- " . $_POST['end_date'];
            ?></h4><?php
    } else {
        /* if program and dates weren't chosen (esp. when the report is first loaded): */
        ?>
        <h4>All Satisfaction Surveys</h4>
        <?php
    }
    ?>
    <div style="margin-left:auto;margin-right:auto;width:800px;">
        <form action="reports.php" method="post">
            Program: <select name="satisfaction_program">
                <option value="">-----</option>
                <?php
                $get_all_programs_with_satisfaction_surveys = "SELECT DISTINCT(Program_ID), Subcategory_Name FROM Satisfaction_Surveys 
            INNER JOIN Subcategories ON Satisfaction_Surveys.Program_ID=Subcategories.Subcategory_ID;";
                include "../include/dbconnopen.php";
                $get_all_programs = mysqli_query($cnnLSNA, $get_all_programs_with_satisfaction_surveys);
                while ($all_progs = mysqli_fetch_row($get_all_programs)) {
                    ?><option value="<?php echo $all_progs[0]; ?>"><?php echo $all_progs[1]; ?></option><?php
                }
                include "../include/dbconnclose.php";
                ?>
            </select><br>

            Start: <input type="text" class="hadDatepicker" name="start_date"><br>
            End: <input type="text" class="hadDatepicker" name="end_date"><br>
            <input type="submit" value="Sort by Program">
        </form>

        <?php
        $chosen_program = $_POST['satisfaction_program'];
//echo $chosen_program;
        ?>
        <!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<!--<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>-->
        <script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
        <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.barRenderer.min.js"></script>
        <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pointLabels.min.js"></script>

        <!-- This is the table that contains the real elements, and makes them slide next to each other. -->

        <!--This is the report table, with all the numbers-->
        <table style="font-size: .8em;
               padding: 7px;
               border: 2px solid #696969;
               border-collapse: collapse;
               width:100%;">
            <tr>
                <th>Question</th>
                <th>Number of each response</th>
                <th> Average response</th>
            </tr>
            <?php
//this array holds all the names of the columns I want to pull
            $question_array = array('Question_1',
                'Question_2',
                'Question_3',
                'Question_4',
                'Question_5',
                'Question_6',
                'Question_7',
                'Question_8',
                'Question_9',
                'Question_10',
                'Question_11');
            //This array holds the names of those columns as they should be shown (different for 3rd/4th graders).
            $text_array_grade_3 = array('I attended this program all the time.',
                'I liked this program.',
                'The teacher was helpful.',
                'This program helped me improve in math.',
                'This program helped me improve in reading.',
                'I will tell my friends about this program.',
                'I signed up because I thought the program would be fun.',
                'I signed up because my friends signed up.',
                'I signed up because my parents wanted me to.', 'I signed up because my teacher wanted me to take it.',
                'I signed up because I wanted to.');
            $text_array_grade_4 = array('This program has helped me improve my grades.',
                'I have made new friends through this program',
                'This program helped my improve my math skills.',
                'This program helped me improve my reading skills.',
                'I believe that this program could help kids stay out of trouble.',
                'I will tell my friends about this program.',
                'I had fun at this program.',
                'I signed up for this program beause my teacher told me to take this program.',
                'I signed up for this program because my friends signed up.',
                'I signed up for this program because my parents told me to.',
                'I signed up for this program because I chose to.');
            //the question_count keeps track of where we are in the arrays above.
            $question_count = 0;

            //this loop traverses the columns above
            foreach ($question_array as $question) {
                ?><tr>
                    <td class="all_projects"  style="text-align:left;width:200px"><?php
                        /* determines which version is shown (though where does the $version come from?! I think I never set that up.) */
                        if ($version == 4) {
                            echo $text_array_grade_4[$question_count];
                        } else {
                            echo $text_array_grade_3[$question_count];
                        }
                        ?></td><?php
                    /* for either set of questions: */
                    /* counter that determines whether or not we're at the end of the question array */
                    $array_lngth_counter = 0;
                    /* empty string which will be filled with values: */
                    $script_str = '';
                    /* reformat start and end dates: */
                    $date_reformat = explode('-', $_POST['start_date']);
                    $start_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
                    $date_reformat = explode('-', $_POST['end_date']);
                    $end_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
                    if (isset($_POST['satisfaction_program']) && $_POST['satisfaction_program'] != '') {
                        /* if a program is set: */
                        $call_for_arrays = "CALL get_count_satisfaction_surveys_by_program('" . $question . "', 
                    '" . $chosen_program . "', '" . $start_date . "', '" . $end_date . "')";
                    } else {
                        /* if not program was chosen: */
                        $call_for_arrays = "CALL get_count_satisfaction_surveys('" . $question . "', '" . $start_date . "', '" . $end_date . "')";
                    }
                    //echo $call_for_arrays;
                    include "../include/dbconnopen.php";
                    $questions = mysqli_query($cnnLSNA, $call_for_arrays);
                    ?><td class="all_projects" style="text-align:left;"><?php
                        $num_options = mysqli_num_rows($questions);
                        /* loop through the list of questions: */
                        while ($survey = mysqli_fetch_row($questions)) {
                            /* loop through the responses to each question: */
                            foreach ($survey as $key => $value) {
                                //creates the correct arrays for legends, below
                                if ($key == 0) {
                                    if ($value == 1) {
                                        $string.= "Agree: ";
                                        $script_str.='["Agree",';
                                    }
                                    if ($value == 0) {
                                        $string.= "N/A: ";
                                        $script_str.='["N/A",';
                                    }
                                    if ($value == 2) {
                                        $string.= "Somewhat Agree: ";
                                        $script_str.='["Somewhat Agree",';
                                    }
                                    if ($value == 3) {
                                        $string.= "Disagree: ";
                                        $script_str.='["Disagree",';
                                    }
                                }
                                if ($key == 1) {
                                    $string.= $value . "<br>";
                                    $script_str.= '"' . $value . '"]';
                                }

                                echo $string;
                                $string = '';
                            }
                            $array_lngth_counter++;
                            if ($array_lngth_counter < $num_options && $key == 1) {
                                $script_str.=', ';
                            }
                        }
                        ${$question . '_' . $i} = $script_str;
                        if ($i == 1) {
                            echo "<br>average: " . number_format($pre[$question_count], 2);
                        }
                        if ($i == 2) {
                            echo "<br>average: " . number_format($post[$question_count], 2);
                        }
                        ?>

                        <!--Builds the actual chart: -->
                        <script type="text/javascript">
                            $(document).ready(function() {
                                var satisfactionanswers1 = [<?php echo $script_str ?>];
                                //alert(teacheranswers1);
                                var plot2 = $.jqplot('satisfaction_survey_chart<?php echo $question_count; ?>', [satisfactionanswers1],
                                        {
                                            title: '<?php
                        if ($version == 4) {
                            echo $text_array_grade_4[$question_count];
                        } else {
                            echo $text_array_grade_3[$question_count];
                        }
                        ?>',
                                            seriesDefaults: {
                                                renderer: $.jqplot.BarRenderer,
                                                pointLabels: {show: true, edgeTolerance: -15},
                                                rendererOptions: {
                                                    barDirection: 'vertical',
                                                    barMargin: 10,
                                                    barWidth: 10
                                                }
                                            },
                                            series: [
                                                {label: 'Pre-Survey'}
                                            ],
                                            legend: {
                                                show: true,
                                                placement: 'outsideGrid'
                                            },
                                            axes: {
                                                yaxis: {
                                                    min: 0,
                                                    max: 20
                                                },
                                                xaxis: {
                                                    renderer: $.jqplot.CategoryAxisRenderer
                                                }
                                            }
                                        });
                            });
                        </script>
    <?php //echo "question count: " . $question_count; ?>
                    </td>
                    <td class="all_projects"></td> 
                </tr>
                <tr>
                    <td colspan="3">
                        <div id="satisfaction_survey_chart<?php echo $question_count; ?>" style="height: 300px; width: 500px; position: relative; margin-left:auto; margin-right:auto;"></div>
                    </td>
                    </td>
                    <?php
                    $question_count++;
                }
                ?>
        </table>
    </div>
</div>
