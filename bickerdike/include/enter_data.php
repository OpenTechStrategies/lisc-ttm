<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($Bickerdike_id);

include "../../header.php";
include "../header.php";
include "../include/datepicker.php";
$_GET['user'];
include "../classes/user.php";
$user = new Bickerdike_User();
$user->load_with_user_id($_GET['user']);
?>

<!--Add a new survey!-->

<script type="text/javascript">
    $(document).ready(function() {
        $('#parent_survey').hide();
        $('#adult_survey').hide();
        $('#youth_survey').hide();
        $('#participants_selector').addClass('selected');
    });

</script>

<div class="content_wide">
    <!--Linked from participant profile, so the "Get" yields the user id, which is then used to get the other user information.-->
    <h3>Enter Survey Data for <?php echo $user->user_first_name . " " . $user->user_last_name; ?></h3><hr/><br/>


    <?php
    $programs = $user->get_programs();
    ?>
    Program in which survey was filled out: 

    <!--Selects from all programs, though in other systems we\'ve selected only from those
    programs that the given participant is already linked to.-->
    <select id="program_id">
        <option value="">-----</option>
        <?php
        while ($program = mysqli_fetch_array($programs)) {
            ?>
            <option value="<?php echo $program['Program_ID']; ?>"><?php echo $program['Program_Name']; ?></option>
            <?php
        }
        ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <span><strong>Survey Date: <input type="text" id="survey_date"></strong></span><br>
    <span>Is this a pre, post, or 3-months-later survey?<select id="pre_post">
            <option value="">----</option>
            <option value="1">Pre</option>
            <option value="2">Post</option>
            <option value="3">3 months later</option>
        </select></span>
    <br/><br/><strong>Survey type: </strong>

    <!--Checks that this person has not already filled out the chosen type of survey for the 
    selected program.   Alerts if s/he has done so.
    Then shows the correct survey questions based on the type of survey selected (parent, adult, youth)
    -->
    <span class="survey_type" id="parent_selector"><a onclick="
        $.post(
                '../ajax/survey_duplicate_check.php',
                {
                    user: '<?php echo $_GET['user'] ?>',
                    program: document.getElementById('program_id').options[document.getElementById('program_id').selectedIndex].value,
                    type: document.getElementById('pre_post').options[document.getElementById('pre_post').selectedIndex].value
                },
        function(response) {
            if (response != '') {
                alert(response);
            }
        });
        $('#parent_survey').show();
        $('#adult_survey').hide();
        $('#youth_survey').hide();
        $('#parent_selector').addClass('selected');
        $('#adult_selector').removeClass('selected');
        $('#youth_selector').removeClass('selected');
                                                      ">Parent</a></span>
    <span class="survey_type" id="adult_selector"><a onclick="
        $.post(
                '../ajax/survey_duplicate_check.php',
                {
                    user: '<?php echo $_GET['user'] ?>',
                    program: document.getElementById('program_id').options[document.getElementById('program_id').selectedIndex].value,
                    type: document.getElementById('pre_post').options[document.getElementById('pre_post').selectedIndex].value
                },
        function(response) {
            if (response != '') {
                alert(response);
            }
        }
        );
        $('#parent_survey').hide();
        $('#adult_survey').show();
        $('#youth_survey').hide();
        $('#parent_selector').removeClass('selected');
        $('#adult_selector').addClass('selected');
        $('#youth_selector').removeClass('selected');
                                                     ">Adult</a></span>
    <span class="survey_type" id="youth_selector"><a onclick="
        $.post(
                '../ajax/survey_duplicate_check.php',
                {
                    user: '<?php echo $_GET['user'] ?>',
                    program: document.getElementById('program_id').options[document.getElementById('program_id').selectedIndex].value,
                    type: document.getElementById('pre_post').options[document.getElementById('pre_post').selectedIndex].value
                },
        function(response) {
            if (response != '') {
                alert(response);
            }
        });
        $('#parent_survey').hide();
        $('#adult_survey').hide();
        $('#youth_survey').show();
        $('#parent_selector').removeClass('selected');
        $('#adult_selector').removeClass('selected');
        $('#youth_selector').addClass('selected');
                                                     ">Youth</a></span><br/>


    <!--Now the survey questions, divided by survey type.  Obviously a more efficient way to do this
    would have been for individual questions to show or hide based on survey type, but that's not how it works.
    Rather, all the questions for the parent survey show up, with a parent survey specific Save.  Then the adults and youth 
    do the same thing.
    -->

    <div id="parent_survey">
        <table class="survey_input" id="bickerdike_survey_new">
            <tr>

                <!--The child must be searched for so that s/he can be linked by database ID.-->

                <td>Search for the child discussed in this survey:</td>
                <td><table class="search_table">
                        <tr><td class="all_projects"><strong>First Name:</strong></td>
                            <td class="all_projects"><input type="text" id="first_n"></td>
                            <td class="all_projects"><strong>Last Name:</strong></td>
                            <td class="all_projects"><input type="text" id="last_n"></td>
                        </tr>
                        <tr>
                            <td class="all_projects"><strong>Zipcode:</strong></td>
                            <td class="all_projects"><select id="zip">
                                    <option value="">-----</option>
                                    <?php
                                    $get_zips_sqlsafe = "SELECT Zipcode FROM Users WHERE Zipcode !=0 GROUP BY Zipcode";
                                    include "../include/dbconnopen.php";
                                    $zips = mysqli_query($cnnBickerdike, $get_zips_sqlsafe);
                                    while ($zip = mysqli_fetch_row($zips)) {
                                        ?>
                                        <option value="<?php echo $zip[0]; ?>"><?php echo $zip[0]; ?></option>
                                        <?php
                                    }
                                    include "../include/dbconnclose.php";
                                    ?>
                                </select></td>
                            <td class="all_projects"><strong>Age:</strong></td>
                            <td class="all_projects"><select id="age">
                                    <option value="">-----</option>
                                    <option value="12">10-19</option>
                                    <option value="20">20-34</option>
                                    <option value="35">35-44</option>
                                    <option value="45">45-59</option>
                                    <option value="60">60 or over</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="all_projects"><strong>Gender:</strong></td>
                            <td class="all_projects"><select id="user_gender">
                                    <option value="">-----</option>
                                    <option value="F">Female</option>
                                    <option value="M">Male</option>
                                </select></td>
                            <td class="all_projects"><strong>Race/Ethnicity:</strong></td><td class="all_projects"><select id="user_race">
                                    <option value="">-----</option>
                                    <option value="b">Black</option>
                                    <option value="l">Latino</option>
                                    <option value="a">Asian</option>
                                    <option value="w">White</option>
                                    <option value="o">Other</option>
                                </select></td>
                        </tr>
                        <tr><td class="all_projects">
                                <strong>Participant Type:</strong>
                            </td>
                            <td class="all_projects">
                                <select id="type">
                                    <option value="">-----</option>
                                    <option value="1">Adult</option>
                                    <option value="2">Parent</option>
                                    <option value="3">Youth</option>
                                </select>
                            </td>
                            <td class="all_projects" colspan="2"></td>
                        </tr>
                        <tr>
                            <th colspan="4"><input type="button" value="Search" onclick="
                $.post(
                        '../ajax/search_users.php',
                        {
                            first: document.getElementById('first_n').value,
                            last: document.getElementById('last_n').value,
                            zip: document.getElementById('zip').value,
                            age: document.getElementById('age').value,
                            gender: document.getElementById('user_gender').value,
                            race: document.getElementById('user_race').value,
                            type: document.getElementById('type').value,
                            dropdown: 'yes'
                        },
                function(response) {
                    document.getElementById('show_results').innerHTML = response;
                }
                ).fail(failAlert);"></th>
                        </tr>
                    </table>

                    <div id="show_results"></div></td></tr>
            <td class="question"><strong>2:</strong> How important is diet and nutrition to you personally?</td>
            <td class="response">	
                <select name="diet_importance" id="2_parent">
                    <option value="">----</option>
                    <option value="4">Not at all important</option>
                    <option value="3">Not too important</option>
                    <option value="2">Somewhat important</option>
                    <option value="1">Very important</option>
                </select>
            </td>
            </tr>
            <tr>
                <td class="question"><strong>3:</strong> How many servings of fruits and vegetables do you eat in an average day?</td>
                <td class="response"><input type="text" name="fruit_veg_servings" id="3_parent" /> servings</td>
            </tr>
            <tr>
                <td class="question"><strong>4:</strong> How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</td>
                <td class="response"><input type="text" name="weekly_days_of_exercise" id="4a_parent"> days<br/>
                    How many minutes on those days? <input type="text" name="exercise_mins_per_day" id="4b_parent">
                </td>
            </tr>
            <tr>
                <td class="question"><strong>5:</strong> How many days per week do you do light to moderate physical activity for at least 10 minutes at a time?</td>
                <td class="response"><input type="text" name="weekly_days_of_exercise" id="5a_parent"> days<br/>
                    How many minutes on those days? <input type="text" name="exercise_mins_per_day" id="5b_parent">
                </td>
            </tr>
            <tr><td colspan="2"><em>[We will ask you some questions about your child who is participating in this program. If you have more than one child participating, please think of the child whose birthday is closest to today. For the remainder of this survey please answer for this child only.]</em></td></tr>
            <tr>
                <td class="question"><strong>6:</strong> On an average day, how many servings of fruits and vegetables does your child eat?</td>
                <td class="response"><input type="text" name="child_fruit_veg_servings" id="7_parent"> servings</td>
            </tr>
            <tr>
                <td class="question"><strong>7:</strong> On an average day, how many hours and minutes does your child spend in active play?</td>
                <td class="response"><input type="text" name="child_play_hours" id="8a_parent"> hours and <input type="text" name="child_play_minutes" id="8b_parent"> minutes</td>
            </tr>
            <tr>
                <td colspan="2"><em>Please indicate your agreement with the following statements:</em></td>
            </tr>
            <tr>
                <td class="question"><strong>8(a):</strong> I would walk more often if I felt safer in my community.</td>
                <td class="response">
                    <select name="safety_walking" id="9a_parent">
                        <option value="">----</option>
                        <option value="4">Strongly Disagree</option>
                        <option value="3">Disagree</option>
                        <option value="2">Agree</option>
                        <option value="1">Strongly Agree</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>8(b):</strong> I feel comfortable with my child playing outside in my community.</td>
                <td class="response">
                    <select name="safety_playing" id="9b_parent">
                        <option value="">----</option>
                        <option value="4">Strongly Disagree</option>
                        <option value="3">Disagree</option>
                        <option value="2">Agree</option>
                        <option value="1">Strongly Agree</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>9:</strong> How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?</td>
                <td class="response">
                    <select name="fruit_veg_selection" id="14_parent">
                        <option value="">----</option>
                        <option value="1">Not at all satisfied</option>
                        <option value="2">Not too satisfied</option>
                        <option value="3">Somewhat satisfied</option>
                        <option value="4">Very satisfied</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>10:</strong> Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?</td>
                <td class="response">
                    <select id="11_parent">
                        <option value="">-----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td class="question"><strong>11:</strong> Are you aware of free or low-cost fitness opportunities in Humboldt Park?</td>
                <td class="response"><select id="12_parent">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="question"><strong>12:</strong> Are you aware of free or low-cost nutrition opportunities in Humboldt Park?</td>
                <td class="response"><select id="13_parent">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></td>
            </tr>
            <tr>
                <td colspan="2"><input type="button" value="Submit" onclick="
                        $.post(
                                '../ajax/save_participant_survey.php',
                                {
                                    save_type: 'save_survey',
                                    user_id: '<?php echo $_GET['user']; ?>',
                                    program: document.getElementById('program_id').options[document.getElementById('program_id').selectedIndex].value,
                                    2: document.getElementById('2_parent').options[document.getElementById('2_parent').selectedIndex].value,
                                    3: document.getElementById('3_parent').value,
                                    four_a: document.getElementById('4a_parent').value,
                                    four_b: document.getElementById('4b_parent').value,
                                    five_a: document.getElementById('5a_parent').value,
                                    five_b: document.getElementById('5b_parent').value,
                                    7: document.getElementById('7_parent').value,
                                    eight_a: document.getElementById('8a_parent').value,
                                    eight_b: document.getElementById('8b_parent').value,
                                    nine_a: document.getElementById('9a_parent').options[document.getElementById('9a_parent').selectedIndex].value,
                                    nine_b: document.getElementById('9b_parent').options[document.getElementById('9b_parent').selectedIndex].value,
                                    14: document.getElementById('14_parent').options[document.getElementById('14_parent').selectedIndex].value,
                                    11: document.getElementById('11_parent').options[document.getElementById('11_parent').selectedIndex].value,
                                    12: document.getElementById('12_parent').options[document.getElementById('12_parent').selectedIndex].value,
                                    13: document.getElementById('13_parent').options[document.getElementById('13_parent').selectedIndex].value,
                                    pre_post: document.getElementById('pre_post').options[document.getElementById('pre_post').selectedIndex].value,
                                    survey_type: 'parent',
                                    date: document.getElementById('survey_date').value,
                                    child: document.getElementById('child_to_link').options[document.getElementById('child_to_link').selectedIndex].value

                                },
                        function(response) {
                            document.getElementById('show_survey_response').innerHTML = '<span style=' + 'color:#990000; font-weight:bold;' + '><strong>Thank you for entering this survey! </strong></span>';
                        }
                        ).fail(failAlert);">
                    <em><a href="../users/user_profile.php?id=<? echo $user->user_id; ?>">Return to participant profile</a></em>
                </td>
            </tr>
        </table>
        <div id="show_survey_response"></div>
    </div>

    <!--End parent survey, begin adult survey.-->


    <div id="adult_survey">
        <table class="survey_input" id="bickerdike_survey_new">
            <tr>
                <td class="question"><strong>2:</strong> How important is diet and nutrition to you personally?</td>
                <td class="response">	
                    <select name="diet_importance" id="2_adult">
                        <option value="">----</option>
                        <option value="1">Not at all important</option>
                        <option value="2">Not too important</option>
                        <option value="3">Somewhat important</option>
                        <option value="4">Very important</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>3:</strong> How many servings of fruits and vegetables do you eat in an average day?</td>
                <td class="response"><input type="text" name="fruit_veg_servings" id="3_adult" /> servings</td>
            </tr>
            <tr>
                <td class="question"><strong>4:</strong> How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</td>
                <td class="response"><input type="text" name="weekly_days_of_exercise" id="4a_adult"> days<br/>
                    How many minutes on those days? <input type="text" name="exercise_mins_per_day" id="4b_adult">
                </td>
            </tr>
            <tr>
                <td class="question"><strong>5:</strong> How many days per week do you do light to moderate physical activity for at least 10 minutes at a time?</td>
                <td class="response"><input type="text" name="weekly_days_of_exercise" id="5a_adult"> days<br/>
                    How many minutes on those days? <input type="text" name="exercise_mins_per_day" id="5b_adult">
                </td>
            </tr>
            <tr>
                <td class="question"><strong>6:</strong> Do you have at least one child between the ages of  0-18 that lives with you at least 3 days per week? <em>If no, skip to Question 9.</em></td>
                <td class="response"><select id="6_adult">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></td>
            </tr>
            <tr><td colspan="2">[We will ask you some questions about your child. If you have more than one child 
                    please think of the child whose birthday is closest to today. For the remainder of this survey please answer for this child only.]</td></tr>
            <tr>
                <td class="question"><strong>7:</strong> On an average day, how many servings of fruits and vegetables does your child eat?</td>
                <td class="response"><input type="text" name="child_fruit_veg_servings" id="7_adult"> servings (or leave blank if not applicable)</td>
            </tr>
            <tr>
                <td class="question"><strong>8:</strong> On an average day, how many hours and minutes does your child spend in active play?</td>
                <td class="response"><input type="text" name="child_play_hours" id="8a_adult"> hours and <input type="text" name="child_play_minutes" id="8b_adult"> minutes (or leave blank if not applicable)</td>
            </tr>
            <tr>
                <td colspan="2"><em>Please indicate your agreement with the following statements:</em></td>
            </tr>
            <tr>
                <td class="question"><strong>9(a):</strong> I would walk more often if I felt safer in my community.</td>
                <td class="response">
                    <select name="safety_walking" id="9a_adult">
                        <option value="">----</option>
                        <option value="">Not Applicable</option>
                        <option value="1">Strongly Disagree</option>
                        <option value="2">Disagree</option>
                        <option value="3">Agree</option>
                        <option value="4">Strongly Agree</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>9(b):</strong> I feel comfortable with my child playing outside in my community.</td>
                <td class="response">
                    <select name="safety_playing" id="9b_adult">
                        <option value="">----</option>
                        <option value="">Not Applicable</option>
                        <option value="1">Strongly Disagree</option>
                        <option value="2">Disagree</option>
                        <option value="3">Agree</option>
                        <option value="4">Strongly Agree</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>10:</strong> How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?</td>
                <td class="response">
                    <select name="fruit_veg_selection" id="14_adult">
                        <option value="">----</option>
                        <option value="1">Not at all satisfied</option>
                        <option value="2">Not too satisfied</option>
                        <option value="3">Somewhat satisfied</option>
                        <option value="4">Very satisfied</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>11:</strong> Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?</td>
                <td class="response">
                    <select id="11_adult">
                        <option value="">-----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td class="question"><strong>12:</strong> Are you aware of free or low-cost fitness opportunities in Humboldt Park?</td>
                <td class="response"><select id="12_adult">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="question"><strong>13:</strong> Are you aware of free or low-cost nutrition opportunities in Humboldt Park?</td>
                <td class="response"><select id="13_adult">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></td>
            </tr>
            <tr>
                <td colspan="2"><input type="button" value="Submit" onclick="
                        $.post(
                                '../ajax/save_participant_survey.php',
                                {
                                    save_type: 'save_survey',
                                    user_id: '<?php echo $_GET['user']; ?>',
                                    program: document.getElementById('program_id').options[document.getElementById('program_id').selectedIndex].value,
                                    2: document.getElementById('2_adult').options[document.getElementById('2_adult').selectedIndex].value,
                                    3: document.getElementById('3_adult').value,
                                    four_a: document.getElementById('4a_adult').value,
                                    four_b: document.getElementById('4b_adult').value,
                                    five_a: document.getElementById('5a_adult').value,
                                    five_b: document.getElementById('5b_adult').value,
                                    6: document.getElementById('6_adult').value,
                                    7: document.getElementById('7_adult').value,
                                    eight_a: document.getElementById('8a_adult').value,
                                    eight_b: document.getElementById('8b_adult').value,
                                    nine_a: document.getElementById('9a_adult').options[document.getElementById('9a_adult').selectedIndex].value,
                                    nine_b: document.getElementById('9b_adult').options[document.getElementById('9b_adult').selectedIndex].value,
                                    14: document.getElementById('14_adult').options[document.getElementById('14_adult').selectedIndex].value,
                                    11: document.getElementById('11_adult').options[document.getElementById('11_adult').selectedIndex].value,
                                    12: document.getElementById('12_adult').options[document.getElementById('12_adult').selectedIndex].value,
                                    13: document.getElementById('13_adult').options[document.getElementById('13_adult').selectedIndex].value,
                                    pre_post: document.getElementById('pre_post').options[document.getElementById('pre_post').selectedIndex].value,
                                    survey_type: 'adult',
                                    date: document.getElementById('survey_date').value
                                },
                        function(response) {
                            document.getElementById('show_survey_response_adult').innerHTML = '<span style=color:#990000;font-weight:bold;font-size:.9em; padding-left: 25px;>Thank you for entering this survey!</span>';
                        }
                        ).fail(failAlert);">
                    <em><a href="../users/user_profile.php?id=<? echo $user->user_id; ?>">Return to user profile</a></em>
                </td>
            </tr>
        </table>
        <div id="show_survey_response_adult"></div>
    </div>

    <!--End adult survey, begin youth survey.-->

    <div id="youth_survey">
        <table class="survey_input" id="bickerdike_survey_new">
            <tr>
                <td class="question"><strong>2:</strong> How important is diet and nutrition to you personally?</td>
                <td class="response">	
                    <select name="diet_importance" id="2_youth">
                        <option value="">----</option>
                        <option value="1">Not at all important</option>
                        <option value="2">Not too important</option>
                        <option value="3">Somewhat important</option>
                        <option value="4">Very important</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>3:</strong> How many servings of fruits and vegetables do you eat in an average day?</td>
                <td class="response"><input type="text" name="fruit_veg_servings" id="3_youth" /> servings</td>
            </tr>
            <tr>
                <td class="question"><strong>4:</strong> How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</td>
                <td class="response"><input type="text" name="weekly_days_of_exercise" id="4a_youth"> days<br/>
                    How many minutes on those days? <input type="text" name="exercise_mins_per_day" id="4b_youth">
                </td>
            </tr>
            <tr>
                <td class="question"><strong>5:</strong> How many days per week do you do light to moderate physical activity for at least 10 minutes at a time?</td>
                <td class="response"><input type="text" name="weekly_days_of_exercise" id="5a_youth"> days<br/>
                    How many minutes on those days? <input type="text" name="exercise_mins_per_day" id="5b_youth">
                </td>
            </tr>
            <tr>
                <td colspan="2"><em>Please indicate your agreement with the following statements:</em></td>
            </tr>
            <tr>
                <td class="question"><strong>6(a):</strong> I would walk more often if I felt safer in my community.</td>
                <td class="response">
                    <select name="safety_walking" id="9a_youth">
                        <option value="">----</option>
                        <option value="4">Strongly Disagree</option>
                        <option value="3">Disagree</option>
                        <option value="2">Agree</option>
                        <option value="1">Strongly Agree</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>6(b):</strong> I feel comfortable playing outside in my community.</td>
                <td class="response">
                    <select name="safety_playing" id="9b_youth">
                        <option value="">----</option>
                        <option value="4">Strongly Disagree</option>
                        <option value="3">Disagree</option>
                        <option value="2">Agree</option>
                        <option value="1">Strongly Agree</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>7:</strong> If you help with the food shopping for your family, 
                    how satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?</td>
                <td class="response">
                    <select name="fruit_veg_selection" id="14_youth">
                        <option value="">----</option>
                        <option value="1">Not at all satisfied</option>
                        <option value="2">Not too satisfied</option>
                        <option value="3">Somewhat satisfied</option>
                        <option value="4">Very satisfied</option>
                        <option value="5">I don't help with the shopping</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>8:</strong> Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?</td>
                <td class="response">
                    <select id="11_youth">
                        <option value="">-----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td class="question"><strong>9:</strong> Are you aware of free or low-cost fitness opportunities in Humboldt Park?</td>
                <td class="response"><select id="12_youth">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="question"><strong>10:</strong> Are you aware of free or low-cost nutrition opportunities in Humboldt Park?</td>
                <td class="response"><select id="13_youth">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></td>
            </tr>

            <tr>
                <td colspan="2"><input type="button" value="Submit" onclick="
                        $.post(
                                '../ajax/save_participant_survey.php',
                                {
                                    save_type: 'save_survey',
                                    user_id: '<?php echo $_GET['user']; ?>',
                                    program: document.getElementById('program_id').options[document.getElementById('program_id').selectedIndex].value,
                                    2: document.getElementById('2_youth').options[document.getElementById('2_youth').selectedIndex].value,
                                    3: document.getElementById('3_youth').value,
                                    four_a: document.getElementById('4a_youth').value,
                                    four_b: document.getElementById('4b_youth').value,
                                    five_a: document.getElementById('5a_youth').value,
                                    five_b: document.getElementById('5b_youth').value,
                                    nine_a: document.getElementById('9a_youth').options[document.getElementById('9a_youth').selectedIndex].value,
                                    nine_b: document.getElementById('9b_youth').options[document.getElementById('9b_youth').selectedIndex].value,
                                    14: document.getElementById('14_youth').options[document.getElementById('14_youth').selectedIndex].value,
                                    11: document.getElementById('11_youth').options[document.getElementById('11_youth').selectedIndex].value,
                                    12: document.getElementById('12_youth').options[document.getElementById('12_youth').selectedIndex].value,
                                    13: document.getElementById('13_youth').options[document.getElementById('13_youth').selectedIndex].value,
                                    pre_post: document.getElementById('pre_post').options[document.getElementById('pre_post').selectedIndex].value,
                                    survey_type: 'youth',
                                    date: document.getElementById('survey_date').value
                                },
                        function(response) {
                            document.getElementById('show_survey_response_youth').innerHTML = 'Thank you for entering this survey! ';
                        }
                        ).fail(failAlert);">
                    <em><a href="../users/user_profile.php?id=<? echo $user->user_id; ?>">Return to user profile</a></em>
                </td>
            </tr>
        </table>
        <div id="show_survey_response_youth" style="color:#990000; font-weight:bold;"></div>
    </div>
</div>
<?php include "../../footer.php"; ?>
