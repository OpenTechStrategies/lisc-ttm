<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id);

?>
<?php
include "../../header.php";
include "../header.php";
include "../include/datepicker_simple.php";
include "../include/dbconnopen.php";
$participant_query_sqlsafe = "SELECT * FROM Participants WHERE Participant_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['participant']) . "'";
$get_participant = mysqli_query($cnnTRP, $participant_query_sqlsafe);
$parti = mysqli_fetch_array($get_participant);
include "../include/dbconnclose.php";
if (isset($_GET['survey'])) {
    $survey_type = "old";
} else {
    $survey_type = "new";
}
/* new survey for mexican museum of art participants:
 * 
 * no required fields. */
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#participants_selector').addClass('selected');
    });
</script>
<div class="content_block" id="nmma_survey">
    <h3>NMMA Artist-in-Residency Survey - <?php echo $parti['First_Name'] . " " . $parti['Last_Name']; ?></h3><hr/>
    <div style="text-align:center;">
        <a href="profile.php?id=<?php echo $parti['Participant_ID']; ?>" class="helptext">Return to participant profile</a><br/><br/>
        <span>Date: <input type="text" id="survey_date" class="hasDatepickers" style="width:80px;"/>  
            School: <select id="survey_school">
                <option value=""></option>
                <option value="0">-----</option>
                <?php
                $select_schools_sqlsafe = "SELECT * FROM Schools ORDER BY School_Name";
                include "../include/dbconnopen.php";
                $schools = mysqli_query($cnnTRP, $select_schools_sqlsafe);
                while ($school = mysqli_fetch_row($schools)) {
                    ?>
                    <option value="<?php echo $school[0]; ?>"><?php echo $school[1]; ?></option>
                    <?php
                }
                ?>
            </select>  
            Survey type: <select id="survey_type">
                <option value="">
                <option value="pre">Pre-program</option>
                <option value="post">Post-program</option>
            </select>
        </span><br/><br/></div>
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
                    <select id="identity_q<?php echo $question_number; ?>">
                        <option value="">-------</option>
                        <option value="1">(1) Don't know</option>
                        <option value="2">(2) Not much</option>
                        <option value="3">(3) Very little</option>
                        <option value="4">(4) Somewhat</option>
                        <option value="5">(5) Quite a bit</option>
                        <option value="6">(6) Very much</option>
                    </select>
                </td>
            </tr>	
            <?php
        }
        ?>
    </table>
    <br/>
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
                    <textarea id="traditions_q<?php echo $question_number; ?>"></textarea>
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="2" style="text-align:center;border:0;"><input type="button" value="Save" onclick="
                    $.post(
'../ajax/save_nmma_survey.php',
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
</div>
<br/><br/>
<?php include "../../footer.php"; ?>