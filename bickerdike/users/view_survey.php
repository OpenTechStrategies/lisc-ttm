<?php
include "../../header.php";
include "../header.php";

/*
 * This file is obsolete.  It was intended to allow users to view entered surveys, but I believe they use the "Edit survey"
 * file for both viewing and editing.
 */

include "../include/dbconnopen.php";
$survey_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_GET['survey']);
$get_survey_answers_sqlsafe = "SELECT * FROM Participant_Survey_Responses WHERE Participant_Survey_ID='" . $survey_sqlsafe . "'";
//echo $get_survey_answers_sqlsafe;
$answers = mysqli_query($cnnBickerdike, $get_survey_answers_sqlsafe);
while ($response = mysqli_fetch_array($answers)) {
    if ($response['Participant_Type'] == 'adult' || $response['Participant_Type'] == 'parent') {
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#participants_selector').addClass('selected');
                $('#bickerdike_survey_new_youth').hide();
            });
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#participants_selector').addClass('selected');
                $('#bickerdike_survey_new_adult').hide();
            });
        </script>
        <?php
    }
    ?>

    <div class="content_wide">
        <h3>View Survey Information</h3>

        <table class="survey_input" id="bickerdike_survey_new_adult">
            <tr>
                <td class="question"><strong>1:</strong> How important is diet and nutrition to you personally?</td>
                <td class="response"><strong><?php
    if ($response['Question_2'] == 4) {
        echo "Not at all important";
    } elseif ($response['Question_2'] == 3) {
        echo "Not too important";
    } elseif ($response['Question_2'] == 2) {
        echo "Somewhat important";
    } elseif ($response['Question_2'] == 1) {
        echo "Very important";
    }
    ?>
                    </strong></td>
            </tr>
            <tr>
                <td class="question"><strong>2:</strong> How many servings of fruits and vegetables do you eat in an average day?</td>
                <td class="response"><strong><?php echo $response['Question_3']; ?></strong> servings</td>
            </tr>
            <tr>
                <td class="question"><strong>3:</strong> How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</td>
                <td class="response"><strong><?php echo $response['Question_4_A']; ?></strong>  days<br/>
                    How many minutes on those days? <strong><?php echo $response['Question_4_B']; ?></strong>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>4:</strong> How many days per week do you do light to moderate physical activity for at least 10 minutes at a time?</td>
                <td class="response"><strong><?php echo $response['Question_5_A']; ?></strong> days<br/>
                    How many minutes on those days? <strong><?php echo $response['Question_5_B']; ?></strong>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>5:</strong> Do you have at least one child between the ages of  0-18 that lives with you at least 3 days per week?</td>
                <td class="response"><strong><?php echo $response['Question_6']; ?></strong></td>
            </tr>
            <tr><td colspan="2">[If this participant has children:]</td></tr>
            <tr>
                <td class="question"><strong>6:</strong> Yesterday, how many servings of fruits and vegetables did your child have?</td>
                <td class="response"><strong><?php echo $response['Question_7']; ?></strong> servings</td>
            </tr>
            <tr>
                <td class="question"><strong>7:</strong> On an average day, how many hours and minutes does your child spend in active play?</td>
                <td class="response"><strong><?php echo $response['Question_8']; ?></strong> minutes</td>
            </tr>
            <tr>
                <td colspan="2"><em>Please indicate your agreement with the following statements:</em></td>
            </tr>
            <tr>
                <td class="question"><strong>8(a):</strong> I would walk more often if I felt safer in my community.</td>
                <td class="response"><strong>
    <?php
    if ($response['Question_9_A'] == 4) {
        echo "Strongly Disagree";
    } elseif ($response['Question_9_A'] == 3) {
        echo "Disagree";
    } elseif ($response['Question_9_A'] == 2) {
        echo "Agree";
    } elseif ($response['Question_9_A'] == 1) {
        echo "Strongly Agree";
    }
    ?></strong>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>8(b):</strong> I feel comfortable with my child playing outside in my community.</td>
                <td class="response"><strong>
                        <?php
                        if ($response['Question_9_B'] == 4) {
                            echo "Strongly Disagree";
                        } elseif ($response['Question_9_B'] == 3) {
                            echo "Disagree";
                        } elseif ($response['Question_9_B'] == 2) {
                            echo "Agree";
                        } elseif ($response['Question_9_B'] == 1) {
                            echo "Strongly Agree";
                        }
                        ?>
                    </strong></td>
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
            </tr>
        </table>
        <p></p>
        <table class="survey_input" id="bickerdike_survey_new_youth">
            <tr>
                <td class="question"><strong>2:</strong> How important is diet and nutrition to you personally?</td>
                <td class="response"><strong><?php
                        if ($response['Question_2'] == 1) {
                            echo "Not at all important";
                        } elseif ($response['Question_2'] == 2) {
                            echo "Not too important";
                        } elseif ($response['Question_2'] == 3) {
                            echo "Somewhat important";
                        } elseif ($response['Question_2'] == 4) {
                            echo "Very important";
                        }
                        ?>
                    </strong></td>
            </tr>
            <tr>
                <td class="question"><strong>3:</strong> How many servings of fruits and vegetables do you eat in an average day?</td>
                <td class="response"><strong><?php echo $response['Question_3']; ?></strong> servings</td>
            </tr>
            <tr>
                <td class="question"><strong>4:</strong> How many days per week do you do strenuous physical activity for at least 10 minutes at a time?</td>
                <td class="response"><strong><?php echo $response['Question_4_A']; ?></strong>  days<br/>
                    How many minutes on those days? <strong><?php echo $response['Question_4_B']; ?></strong>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>5:</strong> How many days per week do you do light to moderate physical activity for at least 10 minutes at a time?</td>
                <td class="response"><strong><?php echo $response['Question_5_A']; ?></strong> days<br/>
                    How many minutes on those days? <strong><?php echo $response['Question_5_B']; ?></strong>
                </td>
            </tr>
            <tr>
                <td colspan="2"><em>Please indicate your agreement with the following statements:</em></td>
            </tr>
            <tr>
                <td class="question"><strong>6(a):</strong> I would walk more often if I felt safer in my community.</td>
                <td class="response"><strong>
    <?php
    if ($response['Question_9_A'] == 1) {
        echo "Strongly Disagree";
    } elseif ($response['Question_9_A'] == 2) {
        echo "Disagree";
    } elseif ($response['Question_9_A'] == 3) {
        echo "Agree";
    } elseif ($response['Question_9_A'] == 4) {
        echo "Strongly Agree";
    }
    ?></strong>
                </td>
            </tr>
            <tr>
                <td class="question"><strong>6(b):</strong> I feel comfortable child playing outside in my community.</td>
                <td class="response"><strong>
    <?php
    if ($response['Question_9_B'] == 1) {
        echo "Strongly Disagree";
    } elseif ($response['Question_9_B'] == 2) {
        echo "Disagree";
    } elseif ($response['Question_9_B'] == 3) {
        echo "Agree";
    } elseif ($response['Question_9_B'] == 4) {
        echo "Strongly Agree";
    }
    ?>
                    </strong></td>
            </tr>
            <tr>
                <td class="question"><strong>7:</strong> How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?</td>
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
            </tr>
            <tr>
                <td class="question"><strong>8:</strong> Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?</td>
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
            </tr>
            <tr>
                <td class="question"><strong>9:</strong> Are you aware of free or low-cost fitness opportunities in Humboldt Park?</td>
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
            </tr>
            <tr>
                <td class="question"><strong>10:</strong> Are you aware of free or low-cost nutrition opportunities in Humboldt Park?</td>
                <td class="response"><strong>
    <?php
    if ($response['Question_13'] == 1) {
        echo "Yes";
    } elseif ($response['Question_13'] == 0) {
        echo "No";
    }
    ?>
                    </strong></td>
            </tr>

        </table>



    </div>
    <?php
}
include "../include/dbconnclose.php";
include "../../footer.php";
?>