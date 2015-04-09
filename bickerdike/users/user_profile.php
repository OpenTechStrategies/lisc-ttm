<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($Bickerdike_id);

include "../../header.php";
include "../header.php";
include "../classes/user.php";
$user = new Bickerdike_User();
$user->load_with_user_id($_GET['id']);
?>

<!--
Shows basic info, programs participated in, health data, surveys, and a graph of survey results.
-->


<script type="text/javascript">
    $(document).ready(function() {
        $('#participants_selector').addClass('selected');
        $('.edit_space').hide();
        $("a.add_new").hover(function() {
            $(this).addClass("selected");
        }, function() {
            $(this).removeClass("selected");
        });
        $('.prog_1').hide();
        $('.prog_2').hide();
        $('.prog_3').hide();
        $('.prog_4').hide();
        $('.prog_5').hide();
    });
</script>

<div class="content_wide">
    <h3>Participant Profile: <?php echo $user->user_first_name . " " . $user->user_last_name; ?></h3><hr/>

    <table class="profile_table">
        <tr>
            <td width="50%">
                <table class="inner_table" style="border: 2px solid #696969;">
                    <tr><td width="40%"><strong>Name:</strong></td><td><span class="displayed_info">
                                <?php echo $user->user_first_name . " " . $user->user_last_name; ?></span>
                            <input type="text" id="user_first_name" class="edit_space" value="<?php echo $user->user_first_name; ?>">
                            <input type="text" class="edit_space" id="user_last_name" value="<?php echo $user->user_last_name; ?>"></td></tr>
                    <tr><td><strong>Gender:</strong></td><td>
                            <span class="displayed_info"><?php
                                if ($user->gender == "F") {
                                    echo "Female";
                                } else if ($user->gender == "M") {
                                    echo "Male";
                                }
                                ?>
                            </span>
                            <select class="edit_space" id="user_gender">
                                <option value="">-----</option>
                                <option value="F" <?php echo($user->gender == 'F' ? 'selected="selected"' : null); ?>>Female</option>
                                <option value="M" <?php echo($user->gender == 'M' ? 'selected="selected"' : null); ?>>Male</option>
                            </select></td></tr>
                    <tr><td><strong>Age:</strong></td><td><span class="displayed_info"><?php
                                // Saved the age ranges as the youngest point in the range
                                if ($user->age == '12') {
                                    echo "10-19";
                                } else if ($user->age == '20') {
                                    echo "20-34";
                                } else if ($user->age == '35') {
                                    echo "35-44";
                                } else if ($user->age == '45') {
                                    echo "45-59";
                                } else if ($user->age == '60') {
                                    echo "60 or over";
                                }
                                ?></span>
                            <select class="edit_space" id="user_age">
                                <option value="">-----</option>
                                <option value="12" <?php echo($user->age == '12' ? 'selected="selected"' : null); ?>>12-19</option>
                                <option value="20" <?php echo($user->age == '20' ? 'selected="selected"' : null); ?>>20-34</option>
                                <option value="35" <?php echo($user->age == '35' ? 'selected="selected"' : null); ?>>35-44</option>
                                <option value="45" <?php echo($user->age == '45' ? 'selected="selected"' : null); ?>>45-59</option>
                                <option value="60" <?php echo($user->age == '60' ? 'selected="selected"' : null); ?>>60 or over</option>
                            </select></td></tr>
                    <tr><td><strong>Race/Ethnicity:</strong></td><td><span class="displayed_info"><?php
                                if ($user->race == 'b') {
                                    echo "Black";
                                } else if ($user->race == 'l') {
                                    echo "Latino";
                                } else if ($user->race == 'a') {
                                    echo "Asian";
                                } else if ($user->race == 'w') {
                                    echo "White";
                                } else if ($user->race == 'o') {
                                    echo "Other";
                                }
                                ?></span>
                            <select class="edit_space" id="user_race">
                                <option>-----</option>
                                <option value="b" <?php echo($user->race == 'b' ? 'selected="selected"' : null); ?>>Black</option>
                                <option value="l" <?php echo($user->race == 'l' ? 'selected="selected"' : null); ?>>Latino</option>
                                <option value="a" <?php echo($user->race == 'a' ? 'selected="selected"' : null); ?>>Asian</option>
                                <option value="w" <?php echo($user->race == 'w' ? 'selected="selected"' : null); ?>>White</option>
                                <option value="o" <?php echo($user->race == 'o' ? 'selected="selected"' : null); ?>>Other</option>
                            </select></td></tr>
                    <tr><td><strong>Zipcode:</strong></td><td><span class="displayed_info"><?php echo $user->user_zipcode; ?></span><input type="text" id="user_zipcode" value="<?php echo $user->user_zipcode; ?>" class="edit_space"></td></tr>
                    <tr><td><strong>Street Address:</strong></td>
                        <td><span class="displayed_info"><?php echo $user->address_number . " " . $user->address_direction . " " . $user->address_street . " " . $user->address_street_type; ?></span>
                            <input type="text" class="edit_space" id="new_user_address_number" value="<?php echo $user->address_number; ?>"> <input type="text" class="edit_space" id="new_user_address_direction" value="<?php echo $user->address_direction; ?>"> <input type="text" class="edit_space" id="new_user_address_street" value="<?php echo $user->address_street; ?>"> <input type="text" class="edit_space" id="new_user_address_street_type" value="<?php echo $user->address_street_type; ?>"><br/><span class="edit_space helptext">e.g. 2550 W North Ave</span></td></tr>

                    <tr><td><strong>Email Address:</strong></td><td><span class="displayed_info"><?php echo $user->email; ?></span><input type="text" id="user_email" value="<?php echo $user->email; ?>" class="edit_space"></td></tr>
                    <tr><td><strong>Phone Number:</strong></td><td><span class="displayed_info"><?php echo $user->phone; ?></span><input type="text" id="user_phone" value="<?php echo $user->phone; ?>" class="edit_space"></td></tr>
                    <tr><td><strong>Database ID</strong></td><td><?php echo $_GET['id']; ?></td></tr>
                    <tr>
                        <td><strong>Notes:</strong><p class="helptext">(only 400 characters will be saved in the database)</p></td>
                        <td>
<?php
    if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<textarea id="user_notes"><?php echo $user->notes; ?></textarea>
<?php
    } //end access check
?>
</td>
                    </tr>
                    <tr><td class="blank">
<?php
    if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<input type="button" value="Edit" onclick="
                            $('.edit_space').toggle();
                            $('.displayed_info').toggle();
                                                 ">
<?php
    } //end access check
?>
<input type="button" class="edit_space" value="Save" onclick="
                                                         $.post(
                                                                 '../ajax/edit_user.php',
                                                                 {
                                                                     user_id: '<?php echo $_GET['id']; ?>',
                                                                     first_name: document.getElementById('user_first_name').value,
                                                                     last_name: document.getElementById('user_last_name').value,
                                                                     gender: document.getElementById('user_gender').value,
                                                                     age: document.getElementById('user_age').value,
                                                                     race: document.getElementById('user_race').value,
                                                                     note: document.getElementById('user_notes').value,
                                                                     zipcode: document.getElementById('user_zipcode').value,
                                                                     address_street: document.getElementById('new_user_address_street').value,
                                                                     address_number: document.getElementById('new_user_address_number').value,
                                                                     address_direction: document.getElementById('new_user_address_direction').value,
                                                                     address_street_type: document.getElementById('new_user_address_street_type').value,
                                                                     email: document.getElementById('user_email').value,
                                                                     phone: document.getElementById('user_phone').value
                                                                 },
                                                         function(response) {
                                                             window.location = 'user_profile.php?id=<?php echo $_GET['id']; ?>';
                                                         }
                                                         ).fail(failAlert);
                                                 "></td><td class="blank"></td></tr>
                </table>	
            </td>	

            <td rowspan="3">
                <h4>Programs Participated In:</h4>
                <!--
                List of all programs that the person participated in:
                -->

                <table class="inner_table">
                    <?php
                    $gram = $user->get_programs();
                    $count = 0;
                    while ($program = mysqli_fetch_array($gram)) {
                        $count = $count + 1;
                        ?>
                        <tr>
                            <th colspan="3"><a style="font-size:1.1em;" href="../activities/program_profile.php?program=<?php echo $program['Program_ID']; ?>"><?php echo $program['Program_Name']; ?></a><br/>
                                &nbsp;&nbsp;&nbsp;<a onclick="
                                            $('.prog_<?php echo $count ?>').slideToggle();
                                                     " class="helptext">Show/hide program dates</a>
                            </th>
                        </tr>
                        <tr class="prog_<?php echo $count ?>">
                            <td></td>
                            <td><strong>Date</strong></td>
                            <td><strong>Attended?</strong></td>
                        </tr>
                        <?php
                        //select the dates that have been entered for this program
                        $get_all_dates_sqlsafe = "SELECT * FROM Program_Dates WHERE Program_ID='" . $program['Program_ID'] . "'";
                        include "../include/dbconnopen.php";
                        $dates = mysqli_query($cnnBickerdike, $get_all_dates_sqlsafe);
                        $i = 0;
                        while ($date = mysqli_fetch_array($dates)) {
                            ?>
                            <tr class="prog_<?php echo $count ?>">
                                <td></td>
                                <td><?php
                                    date_default_timezone_set('America/Chicago');
                                    $datetime = new DateTime($date['Program_Date']);
                                    echo date_format($datetime, 'M d, Y');
                                    ?></td>
                                <!--Show existing attendance and add or remove attendance as necessary (with onchange)-->
                                <td><input type="checkbox" id="program_date_<?php echo $program['Program_ID'] ?>_<?php echo $i ?>" 
                                    <?php
                                    $did_attend_sqlsafe = "SELECT * FROM Program_Dates_Users WHERE Program_Date_ID='" . $date['Program_Date_ID'] . "' AND User_ID='" . $user->user_id . "'";
                                    $attended = mysqli_query($cnnBickerdike, $did_attend_sqlsafe);
                                    if (mysqli_num_rows($attended) > 0) {
                                        echo 'checked';
                                    }
                                    ?> onchange="handleChange(this, '<?php echo $date['Program_Date_ID']; ?>')"></td>
                            </tr>
                            <script text="javascript">

                                function handleChange(cb, date) {
                                    if (cb.checked == true) {
                                        $.post(
                                                '../ajax/add_attendee.php',
                                                {
                                                    user_id: '<?php echo $user->user_id; ?>',
                                                    program_date_id: date
                                                },
                                        function(response) {
                                            window.location = "user_profile.php?id=<?php echo $user->user_id; ?>";
                                        }
                                        ).fail(failAlert);
                                    }
                                    else if (cb.checked == false) {
                                        $.post(
                                                '../ajax/remove_attendee.php',
                                                {
                                                    user_id: '<?php echo $user->user_id; ?>',
                                                    program_date_id: date
                                                },
                                        function(response) {
                                            window.location = "user_profile.php?id=<?php echo $user->user_id; ?>";
                                        }
                                        ).fail(failAlert);
                                    }
                                }
                            </script>

                            <?php
                            $i = $i + 1;
                        }
                        ?>

                        <?php
                    }
                    ?>

                    <!--Create file for downloading attendance-->

                    <?php
                    $infile = "../data/downloads/attendance_" . $user->user_id . ".csv";
                    $fp = fopen($infile, "w") or die('can\'t open file');
                    $query_sqlsafe = "Call User__Download_Attendance('" . $user->user_id . "')";
                    include "../include/dbconnopen.php";
                    if ($result = mysqli_query($cnnBickerdike, $query_sqlsafe)) {
                        while ($row = mysqli_fetch_array($result)) {
                            $put_array = array($user->user_first_name, $user->user_last_name, $row[User_ID], $row[Program_Date], $row[Program_Name]);
                            fputcsv($fp, $put_array);
                        }
                    }
                    fclose($fp);
                    include "../include/dbconnclose.php";
                    ?>
                </table>
                <br/>
                <!--Add to new program.-->

                
<?php
                    if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<span><strong>Add to Program:</strong>
                    <select id="choose_from_all_programs">
                        <option value="">------</option>
                        <?php
                        $get_all_programs_sqlsafe = "SELECT * FROM Programs ORDER BY Program_Name";
                        include "../include/dbconnopen.php";
                        $programs = mysqli_query($cnnBickerdike, $get_all_programs_sqlsafe);
                        while ($program = mysqli_fetch_array($programs)) {
                            ?>
                            <option value="<?php echo $program['Program_ID']; ?>"><?php echo $program['Program_Name']; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
                    </select><br/>

                    <input type="button" class="hide_on_view" value="Add to Program" onclick="
                                $.post(
                                        '../ajax/add_participant.php',
                                        {
                                            program_id: document.getElementById('choose_from_all_programs').options[document.getElementById('choose_from_all_programs').selectedIndex].value,
                                            user_id: '<?php echo $_GET['id']; ?>'
                                        },
                                function(response) {
                                    window.location = 'user_profile.php?id=<?php echo $_GET['id']; ?>';
                                }
                                ).fail(failAlert);"></span>
<?php
                    } //end access check
?>

                <!--Link to creating a new program entirely-->

                
<?php
                    if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<p class="helptext ">Can't find the program you're looking for?  <a href="../activities/new_program.php?origin=<?php echo $user->user_id; ?>">Create a new one!</a>
<?php
                    } //end access check
?>
</p>
                <br/><br/>

                <!--The actual link to download the file that was created above.-->
                <a class="download" href="<?php echo $infile; ?>">Download the CSV file of all attendance records.</a>
            </td>
        </tr>
        <tr>
            <td>
                <!--Show all health data (over time)-->
                <h4>Health Data</h4>
                <table class="inner_table" style="width:80%; margin-left:auto; margin-right:auto;">
                    <tr><th>Date</th>
                        <th>Height</th>
                        <th>Weight</th>
                        <th>BMI</th></tr>
                    <?php
                    $health_data = $user->get_health_data();
                    while ($health = mysqli_fetch_array($health_data)) {
                        ?>
                        <tr>
                            <td><?php echo $health['Date']; ?></td>
                            <td><?php echo $health['Height_Feet'] . "' " . $health['Height_Inches'] . "''"; ?></td>
                            <td><?php echo $health['Weight']; ?></td>
                            <td><?php echo $health['BMI']; ?>
                                
<?php
                        if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<input type="button" value="Remove" onclick="
                                                $.post(
                                                        '../ajax/remove_health_data.php',
                                                        {
                                                            id: '<?php echo $health['User_Health_Data_ID']; ?>'
                                                        },
                                                function(response) {
                                                    window.location = 'user_profile.php?id=<?php echo $_GET['id']; ?>';
                                                }
                                                ).fail(failAlert);">
<?php
                                        } //end access check
?>
</td>
                        </tr>
                        <?php
                    }
                    ?>

                    
<?php
if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<tr>
                        <td><?php
                            date_default_timezone_set('America/Chicago');
                            $today = time();
                            echo date('M d, Y', $today);
                            ?></td>
                        <td><input type="text" id="height" class="health_metric">
                        </td>
                        <td><input type="text" id="weight" class="health_metric"></td>
                        <td><input type="text" id="bmi"  class="health_metric">
                            <input type="button" value="Add Data" onclick="
                                        $.post(
                                                '../ajax/add_health_data.php',
                                                {
                                                    date: '<?php echo date('Y-m-d', $today); ?>',
                                                    height: document.getElementById('height').value,
                                                    weight: document.getElementById('weight').value,
                                                    user: '<?php echo $user->user_id; ?>',
                                                    bmi: document.getElementById('bmi').value
                                                },
                                        function(response) {
                                            window.location = 'user_profile.php?id=<?php echo $user->user_id; ?>';
                                        }
                                        ).fail(failAlert);"></td>
                    </tr>
<?php
} //end access check
?>
                    
<?php
if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<tr>
                        <td colspan="4" class="blank"><p class="helptext">Enter height in inches and weight in pounds.  You may add height and weight or BMI.</p><br/></td>
                    </tr>
<?php
} //end access check
?>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; padding-left:225px; padding-right:225px;" colspan="2">
                <h4>View Surveys</h4>
                <table class="inner_table">
                    <tr><th>Survey</th><th>Type</th><th>Program</th><th>Edit</th></tr>

                    <?php
                    $surveys = $user->get_surveys();
                    $survey_responses_1 = array();
                    $survey_responses_2 = array();
                    $survey_responses_3 = array();
                    $count = 1;
                    ?>

                    <?php
                    while ($survey = mysqli_fetch_array($surveys)) {
                        //Shows surveys both in the table and pushes them into other arrays for use in the bar graph below
                        // Not a good pre/post system in creating the bar graph arrays.  Wouldn't work properly if a person hadn't
                        // completed all the surveys in the correct order.
                        ?>
                        <a href="view_survey.php?survey=<?php echo $survey['Participant_Survey_ID']; ?>">
                            <tr><td><?php echo "Date: " . $survey['Date_Survey_Administered']; ?></a></td>
                <td><?php
                    if ($survey['Pre_Post_Late'] == 1) {
                        echo "Pre-program";
                    } else if ($survey['Pre_Post_Late'] == 2) {
                        echo "Post-program";
                    } else if ($survey['Pre_Post_Late'] == 3) {
                        echo "3 months later";
                    }
                        ?></td>
                <td> <?php echo $survey['Program_Name']; ?>  </td><td>    
<?php
if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>(<a href="edit_survey.php?id=
<?php echo $survey['Participant_Survey_ID']; ?>" class="">Edit</a>)
<?php
} //end access check
?>
</td></tr>

            <?php
            if ($count == 1) {
                $survey_responses_1[0] = $survey['Question_2'];
                $survey_responses_1[1] = $survey['Question_3'];
                $survey_responses_1[2] = $survey['Question_4_A'];
                $survey_responses_1[3] = round(($survey['Question_4_B'] / 60), 2);
                $survey_responses_1[4] = $survey['Question_5_A'];
                $survey_responses_1[5] = round(($survey['Question_5_B'] / 60), 2);
                $survey_responses_1[6] = $survey['Question_6'];
                $survey_responses_1[7] = $survey['Question_7'];
                $survey_responses_1[8] = round(($survey['Question_8'] / 60), 2);
                $survey_responses_1[9] = $survey['Question_9_A'];
                $survey_responses_1[10] = $survey['Question_9_B'];
                $survey_responses_1[11] = $survey['Question_11'];
                $survey_responses_1[12] = $survey['Question_12'];
                $survey_responses_1[13] = $survey['Question_13'];
                $survey_responses_1[14] = $survey['Question_14'];
            } elseif ($count == 2) {
                $survey_responses_2[0] = $survey['Question_2'];
                $survey_responses_2[1] = $survey['Question_3'];
                $survey_responses_2[2] = $survey['Question_4_A'];
                $survey_responses_2[3] = round(($survey['Question_4_B'] / 60), 2);
                $survey_responses_2[4] = $survey['Question_5_A'];
                $survey_responses_2[5] = round(($survey['Question_5_B'] / 60), 2);
                $survey_responses_2[6] = $survey['Question_6'];
                $survey_responses_2[7] = $survey['Question_7'];
                $survey_responses_2[8] = round(($survey['Question_8'] / 60), 2);
                $survey_responses_2[9] = $survey['Question_9_A'];
                $survey_responses_2[10] = $survey['Question_9_B'];
                $survey_responses_2[11] = $survey['Question_11'];
                $survey_responses_2[12] = $survey['Question_12'];
                $survey_responses_2[13] = $survey['Question_13'];
                $survey_responses_2[14] = $survey['Question_14'];
            } elseif ($count == 3) {
                $survey_responses_3[0] = $survey['Question_2'];
                $survey_responses_3[1] = $survey['Question_3'];
                $survey_responses_3[2] = $survey['Question_4_A'];
                $survey_responses_3[3] = round(($survey['Question_4_B'] / 60), 2);
                $survey_responses_3[4] = $survey['Question_5_A'];
                $survey_responses_3[5] = round(($survey['Question_5_B'] / 60), 2);
                $survey_responses_3[6] = $survey['Question_6'];
                $survey_responses_3[7] = $survey['Question_7'];
                $survey_responses_3[8] = round(($survey['Question_8'] / 60), 2);
                $survey_responses_3[9] = $survey['Question_9_A'];
                $survey_responses_3[10] = $survey['Question_9_B'];
                $survey_responses_3[11] = $survey['Question_11'];
                $survey_responses_3[12] = $survey['Question_12'];
                $survey_responses_3[13] = $survey['Question_13'];
                $survey_responses_3[14] = $survey['Question_14'];
            }
            $count = $count + 1;
        }
        ?>

    </table>
    <?php
    //Encoding the survey response arrays as json for their use in the bar graph

    $answers_to_json_1 = json_encode((array) $survey_responses_1);
    $answers_to_json_2 = json_encode((array) $survey_responses_2);
    $answers_to_json_3 = json_encode((array) $survey_responses_3);
    ?>

    <br/>
<?php
if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
   <a href="../include/enter_data.php?user=<?php echo $user->user_id; ?>" class="add_new "><span class="add_new_button">Add a survey for this user</span></a><br/><br/>
<?php
} //end access check
?>


    <!--
    Created the questions array in order to make a file of survey results over time to be downloaded
    -->
    <?php
    $questions = array(
        'How important is diet and nutrition to you personally?',
        'How many servings of fruits and vegetables do you eat in an average day?',
        'How many days per week do you do strenuous physical activity for at least 10 minutes at a time?',
        'How many hours on those days?',
        'How many days per week do you do light or moderate physical activity for at least 10 minutes?',
        'How many hours on those moderate activity days?',
        'Do you have at least child between the ages of 0-18 that lives with you at least 3 days per week?',
        'Yesterday, how many servings of fruits and vegetables did your child have?',
        'On an average day, how many hours and minutes does your child spend in active play?',
        'Do you agree? I would walk more often if I felt safer in my community.',
        'Do you agree? I feel comfortable with my child playing outside in my community.',
        'How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?',
        'Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?',
        'Are you aware of free or low-cost fitness opportunities in Humboldt Park?',
        'Are you aware of free or low-cost nutrition opportunities in Humboldt Park?'
    );
    $infile2 = "../data/downloads/surveys_for_" . $user->user_id . ".csv";
    $fp = fopen($infile2, "w") or die('can\'t open file');
    for ($i = 0; $i < count($survey_responses_1); $i++) {
        $put_array = array($questions[$i], $survey_responses_1[$i], $survey_responses_2[$i], $survey_responses_3[$i]);
    }
    fputcsv($fp, $questions);
    fputcsv($fp, $survey_responses_1);
    fputcsv($fp, $survey_responses_2);
    fputcsv($fp, $survey_responses_3);
    fclose($fp);
    ?>
    <a class="download" href="<?php echo $infile2; ?>">Download the CSV file of all survey records.</a>
</td>
</tr>
</table>

</div>

<!--
The json-encoded arrays of survey responses that we created above are here entered into the bar graph.
-->


<h4>Chart of survey results:</h4>
<!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pointLabels.min.js"></script>

<script type="text/javascript">
                                var answers1 = <?php echo $answers_to_json_1; ?>;
                                var answers2 = <?php echo $answers_to_json_2; ?>;
                                //var answers2 = [3, 3, 1, 5, .5, 1, 4, .67, 3, 1, 0, 1, 1, 1];
                                var answers3 = <?php echo $answers_to_json_3; ?>;
                                var ticks = ['Diet/Nutrition <br>Importance', 'Veg<br> Servings', 'Strenuous<br> Activity<br> Days', 'Strenuous <br>Activity<br> Hours',
                                    'Moderate <br>Activity<br> Days',
                                    'Moderate<br> Activity<br> Hours', 'Child <br>Fruit/Veg', 'Child<br> Active Time', 'Safety', 'Child<br> Safety', 'Store <br>Satisfaction',
                                    'Signs', 'Fitness<br>Awareness',
                                    'Nutrition<Br> Awareness']
                                //alert(answers);[1,4], [2,5], [3,4], [4,90], [5,7], [6,60], [7,1], [8,5], [9,60], [10,3], [11,1], [12,0], [13,1], [14,1], [15,1]
                                $(document).ready(function() {
                                    // alert(answers1);
                                    var plot2 = $.jqplot('chart2', [answers1, answers2, answers3],
                                            {
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
                                                    {label: 'Pre-Program'},
                                                    {label: 'Post-Program'},
                                                    {label: '3 Months Later'}
                                                ],
                                                // Show the legend and put it outside the grid, but inside the
                                                // plot container, shrinking the grid to accomodate the legend.
                                                // A value of "outside" would not shrink the grid and allow
                                                // the legend to overflow the container.
                                                legend: {
                                                    show: true,
                                                    placement: 'outsideGrid'
                                                },
                                                axes: {
                                                    yaxis: {
                                                        min: 0,
                                                        max: 10
                                                    },
                                                    xaxis: {
                                                        renderer: $.jqplot.CategoryAxisRenderer,
                                                        ticks: ticks,
                                                        min: 0,
                                                        max: 16
                                                    }
                                                }
                                            });
                                });

</script>
<div id="chart2" style="height: 300px; width: 1000px; position: relative; margin-left:auto; margin-right:auto;"></div>
<div id="show_json_answers"></div>

<br/><br/>
<?php include "../../footer.php"; ?>
