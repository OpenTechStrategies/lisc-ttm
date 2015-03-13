<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($LSNA_id);
?>
<div id="parent_mentor_survey_pre_post">

    <!-- shows results for some questions from the parent mentor survey. -->

    <!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<!--<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>-->
    <script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
    <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.barRenderer.min.js"></script>
    <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pointLabels.min.js"></script>

    <h4>Parent Mentor Surveys - Aggregate Results (Pre, Mid, & Post Completed)</h4><br/>

    <form action="reports.php" method="post">
        <strong>Choose year and/or school to sort surveys.  Leave blank to view all.</strong>

        <select id="pre_post_year" name="pre_post_year">
            <option value="">-----</option>
            <option value="2011" <?php echo($_POST['pre_post_year'] == '2011' ? 'selected="selected"' : null ) ?>>2011-2012</option>
            <option value="2012" <?php echo($_POST['pre_post_year'] == '2012' ? 'selected="selected"' : null ) ?>>2012-2013</option>
            <option value="2013" <?php echo($_POST['pre_post_year'] == '2013' ? 'selected="selected"' : null ) ?>>2013-2014</option>
            <option value="2014" <?php echo($_POST['pre_post_year'] == '2014' ? 'selected="selected"' : null ) ?>>2014-2015</option>
            <option value="2015" <?php echo($_POST['pre_post_year'] == '2015' ? 'selected="selected"' : null ) ?>>2015-2016</option>
            <option value="2016" <?php echo($_POST['pre_post_year'] == '2016' ? 'selected="selected"' : null ) ?>>2016-2017</option>
        </select>


        <select id="pre_post_school_post" name="pre_post_school_post">
            <option value="">----------</option>
            <?php
            $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1'";
            include "../include/dbconnopen.php";
            $schools = mysqli_query($cnnLSNA, $get_schools);
            while ($school = mysqli_fetch_array($schools)) {
                ?>
                <option value="<?php echo $school['Institution_ID']; ?>" <?php echo($response['School'] == $school['Institution_ID'] ? "selected='selected'" : null); ?>><?php echo $school['Institution_Name']; ?></option>
                <?php
            }
            include "../include/dbconnclose.php";
            ?>
        </select>
        <input type="submit" value="Sort" >
    </form>

    <?php
    /* if results are sorted: */
    include "../include/dbconnopen.php";
    $pre_post_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['pre_post_year']);
    $pre_post_school_post_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['pre_post_school_post']);
    if (isset($_POST['pre_post_year']) && $_POST['pre_post_year'] != '') {
        $year_post = " AND ((YEAR(Date)='" . $pre_post_year_sqlsafe . "' AND MONTH(Date)>6 AND MONTH(Date)<=12) OR (YEAR(Date)='" .($pre_post_year_sqlsafe+1)."' AND MONTH(Date)<=6 ))";
    } else {
        $year_post = "";
    }
    if (isset($_POST['pre_post_school_post']) && $_POST['pre_post_school_post'] != '') {
        $school_post = " AND Parent_Mentor_Survey.School='" . $pre_post_school_post_sqlsafe . "' ";
    } else {
        $school_post = "";
    }

    /* create arrays with only the questions from the surveys.  This is much less useful now that only 
     * a few questions are shown in this report. */
    $get_pre_averages = "SELECT DISTINCT Parent_Mentor_Survey.Parent_Mentor_Survey_ID,
		Parent_Mentor_Survey.Participant_ID,
		Parent_Mentor_Survey.School,
		AVG(Student_Involvement_B), AVG(Student_Involvement_H),
		AVG(School_Network_I), AVG(School_Network_J),
		AVG(School_Involvement_M), AVG(School_Involvement_P),
		AVG(School_Involvement_Q), AVG(Self_Efficacy_S)
                FROM Parent_Mentor_Survey
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 2) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_1.School = Parent_Mentor_Survey.School
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 3) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_2.School = Parent_Mentor_Survey.School
                WHERE Pre_Post = 1 " . $year_post . $school_post;
    
    $pre_averages = mysqli_query($cnnLSNA, $get_pre_averages);
    $pre = mysqli_fetch_row($pre_averages);

    include "../include/dbconnclose.php";


    include "../include/dbconnopen.php";
    $get_mid_averages = "SELECT DISTINCT Parent_Mentor_Survey.Parent_Mentor_Survey_ID,
		Parent_Mentor_Survey.Participant_ID,
		Parent_Mentor_Survey.School,
		AVG(Student_Involvement_B), AVG(Student_Involvement_H),
		AVG(School_Network_I), AVG(School_Network_J),
		AVG(School_Involvement_M), AVG(School_Involvement_P),
		AVG(School_Involvement_Q), AVG(Self_Efficacy_S)
                FROM Parent_Mentor_Survey
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 1) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_1.School = Parent_Mentor_Survey.School
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 3) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_2.School = Parent_Mentor_Survey.School
                WHERE Pre_Post = 2 " . $year_post . $school_post;
        
    $mid_averages = mysqli_query($cnnLSNA, $get_mid_averages);
    $mid = mysqli_fetch_row($mid_averages);
    include "../include/dbconnclose.php";

    include "../include/dbconnopen.php";
    $get_post_averages = "SELECT DISTINCT Parent_Mentor_Survey.Parent_Mentor_Survey_ID,
		Parent_Mentor_Survey.Participant_ID,
		Parent_Mentor_Survey.School,
		AVG(Student_Involvement_B), AVG(Student_Involvement_H),
		AVG(School_Network_I), AVG(School_Network_J),
		AVG(School_Involvement_M), AVG(School_Involvement_P),
		AVG(School_Involvement_Q), AVG(Self_Efficacy_S)
                FROM Parent_Mentor_Survey
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 1) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_1.School = Parent_Mentor_Survey.School
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 2) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_2.School = Parent_Mentor_Survey.School
                WHERE Pre_Post = 3 " . $year_post . $school_post;
    
    $post_averages = mysqli_query($cnnLSNA, $get_post_averages);
    $post = mysqli_fetch_row($post_averages);
    include "../include/dbconnclose.php";


    include "../include/dbconnopen.php";
    //count the number of surveys entered for each step


    //$count_pres = "SELECT * FROM Parent_Mentor_Survey WHERE Pre_Post='1'" . $year_post . $school_post;
    $count_pres = "SELECT DISTINCT *
                FROM Parent_Mentor_Survey
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 2) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_1.School = Parent_Mentor_Survey.School
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 3) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_2.School = Parent_Mentor_Survey.School
                WHERE Pre_Post = 1 " . $year_post . $school_post;
    
    include "../include/dbconnopen.php";
    $pres = mysqli_query($cnnLSNA, $count_pres);
    $num_pres = mysqli_num_rows($pres);
    include "../include/dbconnclose.php";

    $count_posts = "SELECT DISTINCT *
                FROM Parent_Mentor_Survey
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 1) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_1.School = Parent_Mentor_Survey.School
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 3) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_2.School = Parent_Mentor_Survey.School
                WHERE Pre_Post = 2 " . $year_post . $school_post;
    
    include "../include/dbconnopen.php";
    $posts = mysqli_query($cnnLSNA, $count_posts);
    $num_posts = mysqli_num_rows($posts);
    include "../include/dbconnclose.php";

    $count_laters = "SELECT DISTINCT *
                FROM Parent_Mentor_Survey
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 1) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_1.School = Parent_Mentor_Survey.School
                JOIN (SELECT Participant_ID, School
                FROM
		Parent_Mentor_Survey
		WHERE Pre_Post = 2) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
			AND Other_2.School = Parent_Mentor_Survey.School
                WHERE Pre_Post = 3" . $year_post . $school_post;

    include "../include/dbconnopen.php";
    $laters = mysqli_query($cnnLSNA, $count_laters);
    $num_laters = mysqli_num_rows($laters);
    include "../include/dbconnclose.php";

    //$limit=0;
    ?>

    <!-- Table that holds the charts for each question reported on. -->
    <table style="font-size: .8em;
           padding: 7px;
           border: 2px solid #696969;
           border-collapse: collapse;
           width: 700px;
           margin-left:100px;">
        <tr>
            <td class="all_projects" colspan="4"><strong>Think about the last WEEK.  On how many <em>days</em> did you...</strong> </td>
        </tr>

        <?php
        /* this question array only includes those questions that they want to show up. */
        $question_array = array('Student_Involvement_B',
            'Student_Involvement_H',
            'School_Network_I',
            'School_Network_J',
            'School_Involvement_M',
            'School_Involvement_P',
            'School_Involvement_Q',
            'Self_Efficacy_Q');
        $text_array = array('B.	Talk with your child’s teacher?', 'H.	Read with your child at home?',
            'I.	How many other parents from the school did you greet by name?',
            'J.	How many teachers in the school did you greet by name?', 'M.	Attend parent committee meetings?',
            'P.	Attend a meeting or get involved in a community activity, outside of the school?',
            'Q.	Share information about the school or the community with other parents in the neighborhood?',
            'S. In general, I think that I can obtain outcomes that are important to me.');

        $question_count = 0;
        /* for each question: */
        foreach ($question_array as $question) {
            /* adds title rows in the appropriate places: */
            if ($question_count == 8) {
                ?><tr>
                    <td class="all_projects" colspan="4"><strong>Think about the last WEEK.</strong> </td>
                </tr>
                <?php
            }
            if ($question_count == 4) {
                ?><tr>
                    <td class="all_projects" colspan="4"><strong>Think about the last MONTH. On how many <em>days</em> did you...</strong> </td>
                </tr><?php
            }
            if ($question_count == 7) {
                ?><tr>
                    <td class="all_projects" colspan="4"><strong>Feelings about Yourself</strong> </td>
                </tr><?php
            }
            /* end title rows */
            ?><tr>
                <td class="all_projects" style="text-align:left;width:45%;padding:5px 10px;">
                    <?php
                    /* echoes the question text: */
                    echo $text_array[$question_count] . ": " . $question_count;
                    ?></td><?php
                /* loop through pre, mid, and post responses to this question: */
                for ($i = 1; $i < 4; $i++) {
                    /* this counter doesn't seem to do anything */
                    $counter_per_question = 0;
                    /* this counter checks whether we're at the end of the array or not.  If not, adds a comma. */
                    $array_lngth_counter = 0;
                    /* creates the empty string that will be filled with values below. */
                    $script_str = '';
                    /* get responses to this question from the pre, mid, or post surveys. */
                    $call_for_arrays = "";
                    if ($i == 1) {
                        $call_for_arrays = "SELECT $question, COUNT(*) AS count
                                            FROM Parent_Mentor_Survey
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 2) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_1.School = Parent_Mentor_Survey.School
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 3) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_2.School = Parent_Mentor_Survey.School
                                            WHERE Pre_Post = 1 " . $year_post . $school_post .
                                            " GROUP BY $question";
                        
                        if ($question=='School_Network_I' || $question==School_Network_J || $question==School_Involvement_M){
                            $call_for_arrays = "SELECT $question, COUNT(*) AS count
                                            FROM Parent_Mentor_Survey
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 2) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_1.School = Parent_Mentor_Survey.School
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 3) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_2.School = Parent_Mentor_Survey.School
                                            WHERE Pre_Post = 1 " . $year_post . $school_post .
                                            " GROUP BY ($question>=20), ($question>=11 AND $question<20),"
                                . "($question>=6 AND $question<11), ($question>=3 AND $question<6),  ($question<3 AND $question >0), $question=0;";
                           
                        }
                        
                    } elseif ($i == 2) {
                        $call_for_arrays = "SELECT $question, COUNT(*) AS count
                                            FROM Parent_Mentor_Survey
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 1) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_1.School = Parent_Mentor_Survey.School
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 3) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_2.School = Parent_Mentor_Survey.School
                                            WHERE Pre_Post = 2 " . $year_post . $school_post .
                                            " GROUP BY $question";
                                            if ($question=='School_Network_I' || $question==School_Network_J || $question==School_Involvement_M){
                            $call_for_arrays = "SELECT $question, COUNT(*) AS count
                                            FROM Parent_Mentor_Survey
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 1) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_1.School = Parent_Mentor_Survey.School
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 3) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_2.School = Parent_Mentor_Survey.School
                                            WHERE Pre_Post = 2 " . $year_post . $school_post .
                                            " GROUP BY ($question>=20), ($question>=11 AND $question<20),"
                                . "($question>=6 AND $question<11), ($question>=3 AND $question<6),  ($question<3 AND $question >0), $question=0;";
                           
                        }
                    } elseif ($i == 3) {
                        $call_for_arrays = "SELECT $question, COUNT(*) AS count
                                            FROM Parent_Mentor_Survey
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 1) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_1.School = Parent_Mentor_Survey.School
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 2) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_2.School = Parent_Mentor_Survey.School
                                            WHERE Pre_Post = 3 " . $year_post . $school_post .
                                            " GROUP BY $question";
                        if ($question=='School_Network_I' || $question==School_Network_J || $question==School_Involvement_M){
                            $call_for_arrays = "SELECT $question, COUNT(*) AS count
                                            FROM Parent_Mentor_Survey
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 1) AS Other_1 ON Other_1.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_1.School = Parent_Mentor_Survey.School
                                            JOIN (SELECT Participant_ID, School
                                            FROM
                                            Parent_Mentor_Survey
                                            WHERE Pre_Post = 2) AS Other_2 ON Other_2.Participant_ID = Parent_Mentor_Survey.Participant_ID
                                                    AND Other_2.School = Parent_Mentor_Survey.School
                                            WHERE Pre_Post = 3 " . $year_post . $school_post .
                                         " GROUP BY ($question>=20), ($question>=11 AND $question<20),"
                                . "($question>=6 AND $question<11), ($question>=3 AND $question<6),  ($question<3 AND $question >0), $question=0;";
                           
                        }
                    }
                    //$call_for_arrays = "SELECT $question, COUNT(*) AS count FROM Parent_Mentor_Survey WHERE Pre_Post='$i' " . $year_post . $school_post .
                    //        " GROUP BY $question";
                    //echo $call_for_arrays . "<br /><br />";
                    
                    //  $call_for_arrays="CALL get_count_pm_surveys(" . $i . ", '" .$question . "')";
                    // echo $call_for_arrays;
                    include "../include/dbconnopen.php";
                    $questions = mysqli_query($cnnLSNA, $call_for_arrays);
                    ?><td class="all_projects"><?php
                        $num_options = mysqli_num_rows($questions);
                        /* $check_order determines whether any values are missing.  Values need to be in order here
                         * so that they'll show up in the correct order in the chart below. */
                        $check_order = -1;
                        while ($survey = mysqli_fetch_row($questions)) {
                            foreach ($survey as $key => $value) {
                                if ($key == 0 && $value === null) {
                                    $value = 0;
                                }/* sets value to zero so that something will show up (so the chart doesn't 
                                  skip from 1 to 3 days) */


                          /*      backup:
                                //if a value is missing in the order of increasing values:
                                if ($key == 0 && $value != $check_order + 1 && $check_order < 3) {
                                    /* This has to do with the value of the response (key is 0, so we know this is the value of the response, not the 
                                     * count of people who chose that response).  Essentially we want to make sure that each response is represented
                                     * in the chart, even if no one chose that response.
                                     */
                               /*     $check_order++;
                                    $perc_numer_arr[] = 0;
                                    $script_str.='["' . ($check_order) . '",';

                                    $script_str.= '"' . 0 . '"], '; /* no one chose this response. */
                               /*     if ($value == $check_order) {
                                        $script_str.='["' . $value . '",';
                                    } elseif ($value != $check_order) {

                                        /* I added this in here so I wouldn't have to check all the way up to some large number.  
                                         * sends us back to "backup:" so that we can keep checking the values until we find one
                                         * that has responses attached to it (only up to 3, so we don't keep backing up forever).
                                         */
                                     /*   goto backup;
                                    }
                                } else {*/
                                    //creates the correct arrays for legends, below
                                    if ($question_count == 7) {
                                        /* if it's question seven, then the values correspond to these feelings, not numbers: */
                                        if ($key == 0) {
                                            if ($value == 1) {
                                                $script_str.= '["Strongly<br>Disagree", ';
                                            } elseif ($value == 2) {
                                                $script_str.= '["Disagree", ';
                                            } elseif ($value == 3) {
                                                $script_str.= '["Neither Agree<br>Nor Disagree", ';
                                            } elseif ($value == 4) {
                                                $script_str.= '["Agree", ';
                                            } elseif ($value == 5) {
                                                $script_str.= '["Strongly<br>Agree", ';
                                            } else {
                                                $script_str.= '["No<br>Response", ';
                                            }
                                        }
                                        /* add the number of people who chose each: */
                                        if ($key == 1) {
                                            $script_str.= '"' . $value . '"]';
                                            $perc_denom+=$value;
                                            $perc_numer_arr[] = $value;
                                        }
                                    }elseif ($question_count >=2 && $question_count<=4){
                                        if ($key == 0) {
                                            if ($value == 1) {
                                                $script_str.= '["1-2", ';
                                            } elseif ($value == 3) {
                                                $script_str.= '["3-5", ';
                                            } elseif ($value == 6) {
                                                $script_str.= '["6-10", ';
                                            } elseif ($value == 11) {
                                                $script_str.= '["11-20", ';
                                            } elseif ($value == 20) {
                                                $script_str.= '["20+", ';
                                            } else {
                                                $script_str.= '["No<br>Response", ';
                                            }
                                        }
                                        /* add the number of people who chose each: */
                                        if ($key == 1) {
                                            $script_str.= '"' . $value . '"]';
                                            $perc_denom+=$value;
                                            $perc_numer_arr[] = $value;
                                        }
                                    } else {
                                        /* all the other questions they decided to show are answered in number of days: */
                                        if ($key == 0) {
                                            $string.= '' . $value . ' days: ';
                                            $script_str.='["' . $value . ' days",';
                                        }
                                        if ($key == 1) {
                                            $string.= $value . ' <br>';
                                            $script_str.= '"' . $value . '"]';
                                            $perc_denom+=$value;
                                            $perc_numer_arr[] = $value;
                                        }
                                    }
                                    /* not sure what $string does. */
                                    $string = '';
                                    $counter_per_question++;
                              /*end the goto else  }*/
                                //end the foreach loop.
                            }
                            $check_order++;
                            $array_lngth_counter++;
                            if ($array_lngth_counter < $num_options && $key == 1) {
                                $script_str.=', ';
                            }
                        }
                        /* close bracket ends the responses to that question for pre, mid, or post. */
                        $perc_display = '';
                        /* we've been adding percentages to the percent array as we count the responses. */
                        foreach ($perc_numer_arr as $percent) {
                            $perc_display .= "'" . number_format(($percent / $perc_denom) * 100) . "%', ";
                        }
                        /* save the percent string as $perc_display_1 for pre, and so on. */
                        ${$perc_display . $i} = $perc_display;

                        $perc_denom = 0;
                        $perc_numer_arr = array();

                        /* name the strings according to pre, mid, and post.  Use these strings to make chart below. */
                        if ($i == 1) {
                            $pre_survey = $script_str;
                        }
                        if ($i == 2) {
                            $mid_survey = $script_str;
                        } elseif ($i == 3) {
                            $post_survey = $script_str;
                        }

                        if ($i == 1) {
                            echo "Pre-survey average: " . number_format($pre[$question_count + 3], 2);
                            $first_display = $perc_display;
                        }
                        if ($i == 2) {
                            echo "Mid-survey average: " . number_format($mid[$question_count + 3], 2);
                            $second_display = $perc_display;
                        }
                        if ($i == 3) {
                            echo "Post-survey average: " . number_format($post[$question_count + 3], 2);
                            $third_display = $perc_display;
                        }
                        ?></td><?php
                }
                /* end the loop through the pre, mid, post responses */
                ?>
            </tr>
            <tr>
                <td colspan="4">

                    <!--Actually create the chart: -->

                    <script type="text/javascript">
                        //alert(pmanswers1);
                        $(document).ready(function() {
                            var pmanswers1 = [<?php echo $pre_survey; ?>];
                            var pmanswers2 = [<?php echo $mid_survey; ?>];
                            var pmanswers3 = [<?php echo $post_survey; ?>];
                            var plot2 = $.jqplot('pm_survey_chart_pre_post_<?php $chart_number = $question_count + 1;
            echo $chart_number;
            ?>', [pmanswers1, pmanswers2, pmanswers3],
                                    {
                                        //title: 'How many days a week do you ask your child about school?',
                                        seriesDefaults: {
                                            renderer: $.jqplot.BarRenderer,
                                            rendererOptions: {
                                                barDirection: 'vertical',
                                                barMargin: 10,
                                                barWidth: 10
                                            }
                                        },
                                        series: [
                                            {label: 'Pre-Survey Responses', pointLabels: {show: true, edgeTolerance: -15, labels: [<?php echo $first_display; ?>]}},
                                            {label: 'Mid-Survey Responses', pointLabels: {show: true, edgeTolerance: -15, labels: [<?php echo $second_display; ?>]}},
                                            {label: 'Post-Survey Responses', pointLabels: {show: true, edgeTolerance: -15, labels: [<?php echo $third_display; ?>]}}
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
                    <div id="pm_survey_chart_pre_post_<?php
                         echo $chart_number;
                         ?>" style="height: 300px; width: 750px; position: relative; margin-left:auto; margin-right:auto;"></div><hr>
                </td>
            </tr>
            <?php
            $question_count++;
        }
        ?>

    </table>


    <!--<div id="pm_survey_chart2" style="height: 300px; width: 500px; position: relative; margin-left:auto; margin-right:auto;"></div><hr>-->

</div>