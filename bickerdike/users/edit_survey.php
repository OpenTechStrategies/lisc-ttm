<?php
include "../../header.php";
include "../header.php";

/*
 * Displays and makes editable survey responses, based on a Get of the survey ID. 
 */

$get_survey_answers = "SELECT * FROM Participant_Survey_Responses WHERE Participant_Survey_ID='" . $_GET['id'] . "'";
//echo $get_survey_answers;
include "../include/dbconnopen.php";
$answers = mysqli_query($cnnBickerdike, $get_survey_answers);
while ($response = mysqli_fetch_array($answers)) {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#participants_selector').addClass('selected');
        });
    </script>

    <div class="content_wide">
        <h3>Edit Survey Information</h3><hr/><br/>

        <?php
        /*
         * Get all programs the user was involved with, in case the program was entered incorrectly:
         */

        include "../classes/user.php";
        $user = new User();
        $user->load_with_user_id($response['User_ID']);
        $programs = $user->get_programs();
        //print_r($programs);
        ?>
        <a href="user_profile.php?id=<? echo $response['User_ID']; ?>">Return to user profile</a><br/>
        Program in which survey was filled out: <select id="program_id">
            <option value="">-----</option>
            <?php
            //list of all programs the surveyed person has been listed as a participant in:
            while ($program = mysqli_fetch_array($programs)) {
                ?>
                <option value="<?php echo $program['Program_ID']; ?>" <?php echo ($response['Program_ID'] == $program['Program_ID'] ? "selected='selected'" : null) ?>><?php echo $program['Program_Name']; ?></option>
                <?php
            }
            ?>
        </select>
        <br/><br/>
        <!--Displays the existing answers in bold, with edit boxes next to them.-->

        <table class="survey_input" id="bickerdike_survey_new">
            <tr>
                <td class="question"><strong>1:</strong> How important is diet and nutrition to you personally?</td>
                <td class="response"><strong><?php
                        if ($response['Question_2'] == 4) {
                            echo "Very important";
                        } elseif ($response['Question_2'] == 3) {
                            echo "Somewhat important";
                        } elseif ($response['Question_2'] == 2) {
                            echo "Not too important";
                        } elseif ($response['Question_2'] == 1) {
                            echo "Not at all important";
                        }
                        ?>
                    </strong></td>
                <td>
                    <select name="diet_importance" id="2">
                        <option value="" <?php echo ($response['Question_2'] == '' ? "selected='selected'" : null); ?>>----</option>
                        <option value="1" <?php echo ($response['Question_2'] == '1' ? "selected='selected'" : null); ?>>Not at all important</option>
                        <option value="2" <?php echo ($response['Question_2'] == '2' ? "selected='selected'" : null); ?>>Not too important</option>
                        <option value="3" <?php echo ($response['Question_2'] == '3' ? "selected='selected'" : null); ?>>Somewhat important</option>
                        <option value="4" <?php echo ($response['Question_2'] == '4' ? "selected='selected'" : null); ?>>Very important</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>2:</strong> How many servings of fruits and vegetables do you eat in an average day?</td>
                <td class="response"><strong><?php echo $response['Question_3']; ?></strong> servings</td>
                <td>
                    <input type="text" value="<?php echo $response['Question_3']; ?>" id="3">
                </td>
            </tr>
            <tr>
                <td class="question"><strong>3:</strong> How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</td>
                <td class="response"><strong><?php echo $response['Question_4_A']; ?></strong>  days<br/>
                    How many minutes on those days? <strong><?php echo $response['Question_4_B']; ?></strong>
                </td>
                <td>
                    <input type="text" value="<?php echo $response['Question_4_A']; ?>" id="4a">
                    <input type="text" value="<?php echo $response['Question_4_B']; ?>" id="4b">
                </td>
            </tr>
            <tr>
                <td class="question"><strong>4:</strong> How many days per week do you do light to moderate physical activity for at least 10 minutes at a time?</td>
                <td class="response"><strong><?php echo $response['Question_5_A']; ?></strong> days<br/>
                    How many minutes on those days? <strong><?php echo $response['Question_5_B']; ?></strong>
                </td>
                <td>
                    <input type="text" value="<?php echo $response['Question_5_A']; ?>" id="5a">
                    <input type="text" value="<?php echo $response['Question_5_B']; ?>" id="5b">
                </td>
            </tr>
            <tr>
                <td class="question"><strong>5:</strong> Do you have at least one child between the ages of  0-18 that lives with you at least 3 days per week?</td>
                <td class="response"><strong>
                        <?php
                        if ($response['Question_6'] == 1) {
                            echo "Yes";
                        } elseif ($response['Question_6'] == 0) {
                            echo "No";
                        }
                        ?>
                    </strong></td>
                <td>
                    <select name="has_child" id="6">
                        <option value="" <?php echo ($response['Question_6'] == '' ? "selected='selected'" : null); ?>>----</option>
                        <option value="1" <?php echo ($response['Question_6'] == 1 ? "selected='selected'" : null); ?>>Yes</option>
                        <option value="0" <?php echo ($response['Question_6'] == 0 ? "selected='selected'" : null); ?>>No</option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="3">[If this participant has children:]</td></tr>
            <tr>
                <td class="question"><strong>6:</strong> Yesterday, how many servings of fruits and vegetables did your child have?</td>
                <td class="response"><strong><?php echo $response['Question_7']; ?></strong> servings</td>
                <td>
                    <input type="text" value="<?php echo $response['Question_7']; ?>" id="7">
                </td>
            </tr>
            <tr>
                <td class="question"><strong>7:</strong> On an average day, how many hours and minutes does your child spend in active play?</td>
                <td class="response"><strong><?php echo $response['Question_8']; ?></strong> minutes</td>
                <td>
                    <input type="text" value="<?php echo $response['Question_8']; ?>" id="8">
                </td>
            </tr>
            <tr>
                <td colspan="3"><em>Please indicate your agreement with the following statements:</em></td>
            </tr>
            <tr>
                <td class="question"><strong>8(a):</strong> I would walk more often if I felt safer in my community.</td>
                <td class="response"><strong>
                        <?php
                        if ($response['Question_9_A'] == 4) {
                            echo "Strongly Agree";
                        } elseif ($response['Question_9_A'] == 3) {
                            echo "Agree";
                        } elseif ($response['Question_9_A'] == 2) {
                            echo "Disagree";
                        } elseif ($response['Question_9_A'] == 1) {
                            echo "Strongly Disagree";
                        }
                        ?></strong>
                </td>
                <td>
                    <select name="safety_walking" id="9a">
                        <option value="" <?php echo ($response['Question_9_A'] == '' ? "selected='selected'" : null); ?>>----</option>
                        <option value="1" <?php echo ($response['Question_9_A'] == '1' ? "selected='selected'" : null); ?>>Strongly Disagree</option>
                        <option value="2" <?php echo ($response['Question_9_A'] == '2' ? "selected='selected'" : null); ?>>Disagree</option>
                        <option value="3" <?php echo ($response['Question_9_A'] == '3' ? "selected='selected'" : null); ?>>Agree</option>
                        <option value="4" <?php echo ($response['Question_9_A'] == '4' ? "selected='selected'" : null); ?>>Strongly Agree</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>8(b):</strong> I feel comfortable with my child playing outside in my community.</td>
                <td class="response"><strong>
                        <?php
                        if ($response['Question_9_B'] == 4) {
                            echo "Strongly Agree";
                        } elseif ($response['Question_9_B'] == 3) {
                            echo "Agree";
                        } elseif ($response['Question_9_B'] == 2) {
                            echo "Disagree";
                        } elseif ($response['Question_9_B'] == 1) {
                            echo "Strongly Disagree";
                        }
                        ?>
                    </strong></td>
                <td>
                    <select name="safety_walking" id="9b">
                        <option value="" <?php echo ($response['Question_9_B'] == '' ? "selected='selected'" : null); ?>>----</option>
                        <option value="1" <?php echo ($response['Question_9_B'] == '1' ? "selected='selected'" : null); ?>>Strongly Disagree</option>
                        <option value="2" <?php echo ($response['Question_9_B'] == '2' ? "selected='selected'" : null); ?>>Disagree</option>
                        <option value="3" <?php echo ($response['Question_9_B'] == '3' ? "selected='selected'" : null); ?>>Agree</option>
                        <option value="4" <?php echo ($response['Question_9_B'] == '4' ? "selected='selected'" : null); ?>>Strongly Agree</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>9:</strong> How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?</td>
                <td class="response"><strong>
                        <?php
                        if ($response['Question_14'] == 1) {
                            echo "Not at all satisfied";
                        } elseif ($response['Question_14'] == 2) {
                            echo "Not too satisfied";
                        } elseif ($response['Question_14'] == 3) {
                            echo "Somewhat satisfied";
                        } elseif ($response['Question_14'] == 4) {
                            echo "Very satisfied";
                        }
                        ?>
                    </strong>
                </td>
                <td class="response">
                    <select name="fruit_veg_selection" id="14">
                        <option value="" <?php echo ($response['Question_14'] == '' ? "selected='selected" : null); ?>>----</option>
                        <option value="1" <?php echo ($response['Question_14'] == '1' ? "selected='selected'" : null); ?>>Not at all satisfied</option>
                        <option value="2" <?php echo ($response['Question_14'] == '2' ? "selected='selected'" : null); ?>>Not too satisfied</option>
                        <option value="3" <?php echo ($response['Question_14'] == '3' ? "selected='selected'" : null); ?>>Somewhat satisfied</option>
                        <option value="4" <?php echo ($response['Question_14'] == '4' ? "selected='selected'" : null); ?>>Very satisfied</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>10:</strong> Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?</td>
                <td class="response"><strong>
                        <?php
                        if ($response['Question_11'] == 1) {
                            echo "Yes";
                        } elseif ($response['Question_11'] == 0) {
                            echo "No";
                        }
                        ?>
                    </strong>
                </td>
                <td>
                    <select id="11">
                        <option value="">-----</option>
                        <option value="1" <?php echo ($response['Question_11'] == '1' ? "selected='selected'" : null); ?>>Yes</option>
                        <option value="0" <?php echo ($response['Question_11'] == '0' ? "selected='selected'" : null); ?>>No</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>11:</strong> Are you aware of free or low-cost fitness opportunities in Humboldt Park?</td>
                <td class="response">
                    <strong>
                        <?php
                        if ($response['Question_12'] == 1) {
                            echo "Yes";
                        } elseif ($response['Question_12'] == 0) {
                            echo "No";
                        }
                        ?>
                    </strong></td>
                <td>
                    <select id="12">
                        <option value="">-----</option>
                        <option value="1" <?php echo ($response['Question_12'] == '1' ? "selected='selected'" : null); ?>>Yes</option>
                        <option value="0" <?php echo ($response['Question_12'] == '0' ? "selected='selected'" : null); ?>>No</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>12:</strong> Are you aware of free or low-cost nutrition opportunities in Humboldt Park?</td>
                <td class="response"><strong>
                        <?php
                        if ($response['Question_13'] == 1) {
                            echo "Yes";
                        } elseif ($response['Question_13'] == 0) {
                            echo "No";
                        }
                        ?>
                    </strong></td>
                <td>
                    <select id="13">
                        <option value="">-----</option>
                        <option value="1" <?php echo ($response['Question_13'] == '1' ? "selected='selected'" : null); ?>>Yes</option>
                        <option value="0" <?php echo ($response['Question_13'] == '0' ? "selected='selected'" : null); ?>>No</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="blank">
                    <input type="button" value="Save Changes" onclick="$.post(
                                        '../ajax/change_survey.php',
                                        {
                                            save_type: 'edit_survey',
                                            survey_id: '<?php echo $_GET['id']; ?>',
                                            program: document.getElementById('program_id').options[document.getElementById('program_id').selectedIndex].value,
                                            2: document.getElementById('2').options[document.getElementById('2').selectedIndex].value,
                                            3: document.getElementById('3').value,
                                            four_a: document.getElementById('4a').value,
                                            four_b: document.getElementById('4b').value,
                                            five_a: document.getElementById('5a').value,
                                            five_b: document.getElementById('5b').value,
                                            6: document.getElementById('6').value,
                                            7: document.getElementById('7').value,
                                            eight: document.getElementById('8').value,
                                            nine_a: document.getElementById('9a').options[document.getElementById('9a').selectedIndex].value,
                                            nine_b: document.getElementById('9b').options[document.getElementById('9b').selectedIndex].value,
                                            14: document.getElementById('14').options[document.getElementById('14').selectedIndex].value,
                                            11: document.getElementById('11').options[document.getElementById('11').selectedIndex].value,
                                            12: document.getElementById('12').options[document.getElementById('12').selectedIndex].value,
                                            13: document.getElementById('13').options[document.getElementById('13').selectedIndex].value
                                        },
                                function(response) {
                                    window.location = 'edit_survey.php?id=<?php echo $_GET['id']; ?>'
                                }
                                );">
                </td>
            </tr>
        </table>
    </div>
    <?php
}
include "../include/dbconnclose.php";
include "../../footer.php";
?>