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

user_enforce_has_access($TRP_id);

include "../../header.php";
include "../header.php";
include "../include/datepicker_simple.php";
include "../include/dbconnopen.php";
/* the identity variable determines which of the NMMA surveys shows up: */
if ($_GET['type'] == 'identity') {
    $query_sqlsafe = "SELECT * FROM NMMA_Identity_Survey WHERE NMMA_Identity_Survey_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
} elseif ($_GET['type'] == 'traditions') {
    $query_sqlsafe = "SELECT * FROM NMMA_Traditions_Survey WHERE NMMA_Traditions_Survey_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
}
$get_info = mysqli_query($cnnTRP, $query_sqlsafe);
$info = mysqli_fetch_array($get_info);
include "../include/dbconnclose.php";

/* show mexican museum of art surveys, one at a time.  These surveys are linked from the participant profile. */
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#participants_selector').addClass('selected');
    });
</script>
<div class="content_block" id="nmma_survey">
    <h3>NMMA Artist-in-Residency Survey - <?php
        /* shows the person who took this survey: */
        include "../include/dbconnopen.php";
        $get_name_sqlsafe = "SELECT First_Name, Last_Name FROM Participants WHERE Participant_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['participant']) . "'";
        $name = mysqli_query($cnnTRP, $get_name_sqlsafe);
        $n = mysqli_fetch_row($name);
        echo $n[0] . " " . $n[1];
        include "../include/dbconnclose.php";
        ?></h3><hr/>
    <div style="text-align:center;">
        <a href="profile.php?id=<?php echo $_GET['participant']; ?>" class="helptext">Return to participant profile</a><br/><br/>

        <!-- start of survey info: -->
        <span><b>Date:</b> <?php echo $info['Date']; ?> 

            <b>Survey type:</b> <?php echo $info['Pre_Post']; ?>
        </span><br/><br/></div>

    <!-- show responses to identity survey: -->
    <?php if ($_GET['type'] == 'identity') { ?>
        <h4>Cultural Identity Survey</h4>
        <table class="survey_table">
            <?php
            $id_questions = array("Do you think you can explain what culture is?",
                "How much do you know about your home culture?",
                "Do you enjoy activities connected with your culture at home?",
                "Do you think you have a great understanding of your cultural background?",
                "Do you think that your family can support you when you need help?",
                "Do you think that your community can support you when you need help?",
                "Do you think of your culture as a source of strength when you need help?",
                "Do you think that you can make a difference in shaping your own future?",
                "Do you think that your cultural values help you make good decisions?",
                "Do you think that your cultural values will help you in the future?",
                "Do you think that you have great personal qualities?");
            for ($q = 0; $q <= 10; $q++) {
                $question_number = $q + 1;
                ?>
                <tr>
                    <td class="q">
                        <strong><?php echo $question_number; ?>: </strong> <?php echo $id_questions[$q]; ?>
                    </td>
                    <td>
                        <?php
                        if ($info[$question_number + 1] == 0) {
                            echo '(0) N/A';
                        } elseif ($info[$question_number + 1] == 1) {
                            echo '(1) Don\'t know';
                        } elseif ($info[$question_number + 1] == 2) {
                            echo '(2) Not much';
                        } elseif ($info[$question_number + 1] == 3) {
                            echo '(3) Very little';
                        } elseif ($info[$question_number + 1] == 4) {
                            echo '(4) Somewhat';
                        } elseif ($info[$question_number + 1] == 5) {
                            echo '(5) Quite a bit';
                        } elseif ($info[$question_number + 1] == 6) {
                            echo '(6) Very much';
                        }
                        ?>
                    </td>
                </tr>	
                <?php
            }
            ?>
        </table>
        <br/>
        <?php
    }
    /* show responses to traditions survey: */ elseif ($_GET['type'] == 'traditions') {
        ?>
        <h4>Cultural Traditions Survey</h4>
        <table class="survey_table">
            <?php
            $traditions_questions = array("What makes up a person's culture?",
                "What is your cultural traditions?",
                "What does art tell you about someone's culture?",
                "What is the importance of this type of art?",
                "Describe the kinds of tools and materials used when creating this type of art.",
                "Please explain any special techniques or safety requirements required when using the tools and materials listed above.",
                "Name at least one artist associated with the documentation of cultural traditions through his or her artwork.",
                "Please tell me in your own words how to document cultural traditions through art.");
            for ($q = 0; $q <= 7; $q++) {
                $question_number = $q + 1;
                ?>
                <tr>
                    <td class="q"><strong><?php echo $question_number; ?>: </strong> <?php echo $traditions_questions[$q]; ?></td>
                    <td>
                        <?php echo $info[$question_number + 1]; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <!-- I don't know why this is here...leftover? -->
            <tr>
                <td colspan="2" style="text-align:center;border:0;"><input type="button" value="Save" onclick="
                        $.post('../ajax/save_nmma_survey.php',
                                {
                                    participant: '<?php echo $_GET['participant']; ?>',
                                    date: document.getElementById('survey_date').value,
                                    school: document.getElementById('survey_school').value,
                                    type: document.getElementById('survey_type').value,
                                    identity_q1: document.getElementById('identity_q1').value,
                                    identity_q2: document.getElementById('identity_q2').value,
                                    identity_q3: document.getElementById('identity_q3').value,
                                    identity_q4: document.getElementById('identity_q4').value,
                                    identity_q5: document.getElementById('identity_q5').value,
                                    identity_q6: document.getElementById('identity_q6').value,
                                    identity_q7: document.getElementById('identity_q7').value,
                                    identity_q8: document.getElementById('identity_q8').value,
                                    identity_q9: document.getElementById('identity_q9').value,
                                    identity_q10: document.getElementById('identity_q10').value,
                                    identity_q11: document.getElementById('identity_q11').value,
                                    traditions_q1: document.getElementById('traditions_q1').value,
                                    traditions_q2: document.getElementById('traditions_q2').value,
                                    traditions_q3: document.getElementById('traditions_q3').value,
                                    traditions_q4: document.getElementById('traditions_q4').value,
                                    traditions_q5: document.getElementById('traditions_q5').value,
                                    traditions_q6: document.getElementById('traditions_q6').value,
                                    traditions_q7: document.getElementById('traditions_q7').value,
                                    traditions_q8: document.getElementById('traditions_q8').value
                                },
                        function(response) {
                            document.getElementById('traditions_survey_saved').innerHTML = response;
                        }
                        ).fail(failAlert);"/>
                    <div id="traditions_survey_saved"></div>
                </td>
            </tr>
        </table>
        <?php
    }
    ?>
</div>
<br/><br/>
<?php
include "../../footer.php";
?>
