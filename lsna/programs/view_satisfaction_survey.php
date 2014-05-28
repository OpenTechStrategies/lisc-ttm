<?php

include "../../header.php";
include "../header.php";
$survey = $_GET['satisfaction_id'];
?>

<!--Obsolete.  Surveys are now created, viewed, and edited on the new_satisfaction_survey page.-->

<script type="text/javascript">
    $(document).ready(function(){
                $('#young_children_satisfaction').hide();
                $('#older_children_satisfaction').hide();
                $('#save_survey').hide();
		});
</script>
<h3>Satisfaction Survey</h3>


<h4>View Survey</h4>

Program:
Participant:


        <p></p>
        <p align="center">
            <a class="add_new" href="javascript:;" onclick="
                     $('#young_children_satisfaction').show();
                     $('#older_children_satisfaction').hide();
                     $('#save_survey').show();
                 "><span class="add_new_button">Survey 3rd Grade and Younger</span></a>
            <a class="add_new" href="javascript:;" onclick="
                     $('#young_children_satisfaction').hide();
                     $('#older_children_satisfaction').show();
                     $('#save_survey').show();
     "><span class="add_new_button">Survey 4th Grade and Older</span></a>
        </p>
        
        <table class="pm_survey" id="young_children_satisfaction">
            <tr><td class="pm_survey question">Dates of Program:</td>
                <td class="pm_survey response"><input type="text" id="program_dates"></td>
            </tr>
            <tr>
                <td class="pm_survey question">1.  I attended this program all the time.</td>
                <td class="pm_survey response"><select id="question_1">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">2.  I like this program.</td>
                <td class="pm_survey response"><select id="question_2">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">3.  The teacher was helpful.</td>
                <td class="pm_survey response"><select id="question_3">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">4. This program helped me improve in math.</td>
                <td class="pm_survey response"><select id="question_4">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">5. This program helped me improve in reading.</td>
                <td class="pm_survey response"><select id="question_5">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">6. I will tell my friends about this program.</td>
                <td class="pm_survey response"><select id="question_6">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">7. I signed up because 1 thought the program would be fun.</td>
                <td class="pm_survey response"><select id="question_7">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">8. I signed up because my friends signed up.</td>
                <td class="pm_survey response"><select id="question_8">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">9. I signed up because my parents wanted me to.</td>
                <td class="pm_survey response"><select id="question_9">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">10. I signed up because my teacher wanted me to take it.</td>
                <td class="pm_survey response"><select id="question_10">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">11. I signed up because 1 wanted to.</td>
                <td class="pm_survey response"><select id="question_11">
                        <option value="">----</option>
                        <option value="1">Yes</option>
                        <option value="2">Maybe</option>
                        <option value="3">No</option>
                    </select></td>
            </tr>
            <tr><th colspan="2"><input type="button" value="Save Survey" onclick="
                        $.post(
                            '../ajax/save_satisfaction_survey.php',
                            {
                                program_id: document.getElementById('program_search').options[document.getElementById('program_search').selectedIndex].value,
                                participant_id: document.getElementById('relative_search').options[document.getElementById('relative_search').selectedIndex].value,
                                1: document.getElementById('question_1').options[document.getElementById('question_1').selectedIndex].value,
                                2: document.getElementById('question_2').options[document.getElementById('question_2').selectedIndex].value,
                                3: document.getElementById('question_3').options[document.getElementById('question_3').selectedIndex].value,
                                4: document.getElementById('question_4').options[document.getElementById('question_4').selectedIndex].value,
                                5: document.getElementById('question_5').options[document.getElementById('question_5').selectedIndex].value,
                                6: document.getElementById('question_6').options[document.getElementById('question_6').selectedIndex].value,
                                7: document.getElementById('question_7').options[document.getElementById('question_7').selectedIndex].value,
                                8: document.getElementById('question_8').options[document.getElementById('question_8').selectedIndex].value,
                                9: document.getElementById('question_9').options[document.getElementById('question_9').selectedIndex].value,
                                10: document.getElementById('question_10').options[document.getElementById('question_10').selectedIndex].value,
                                11: document.getElementById('question_11').options[document.getElementById('question_11').selectedIndex].value,
                                12: '',
                                date: document.getElementById('program_dates').value
                            },
                            function (response){
                                document.getElementById('show_survey_thanks_satisfaction').innerHTML = response;
                            }
                    )
                          "></th></tr>
        </table>
        
        
        
        <table class="pm_survey" id="older_children_satisfaction">
            <tr><td class="pm_survey question">Dates of Program:</td>
                <td class="pm_survey response"><input type="text" id="program_dates_older"></td>
            </tr>
            <tr>
                <td class="pm_survey question">1.  This program has helped me improve my grades.</td>
                <td class="pm_survey response"><select id="older_question_1">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">2.  I have made new friends through this program.</td>
                <td class="pm_survey response"><select id="older_question_2">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">3.  This program helped me improve my math skills.</td>
                <td class="pm_survey response"><select id="older_question_3">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">4. This program helped me improve my reading skills.</td>
                <td class="pm_survey response"><select id="older_question_4">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">5. I believe that this program could help kids stay out of trouble.</td>
                <td class="pm_survey response"><select id="older_question_5">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">6. I will tell my friends about this program.</td>
                <td class="pm_survey response"><select id="older_question_6">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">7. I had fun at this program.</td>
                <td class="pm_survey response"><select id="older_question_7">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">8. I signed up for this program because my teacher told me to take this program.</td>
                <td class="pm_survey response"><select id="older_question_8">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">9. I signed up for this program because my friends signed up.</td>
                <td class="pm_survey response"><select id="older_question_9">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">10. I signed up for this program because my parents told me to.</td>
                <td class="pm_survey response"><select id="older_question_10">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">11. I signed up for this program because I chose to.</td>
                <td class="pm_survey response"><select id="older_question_11">
                        <option value="">----</option>
                        <option value="1">Agree</option>
                        <option value="2">Somewhat Agree</option>
                        <option value="3">Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">12. What suggestions do you have for improving this program?</td>
                <td class="pm_survey response"><textarea id="older_question_12"></textarea></td>
            </tr>
            <tr><th colspan="2"><input type="button" value="Save Survey" onclick="
                         $.post(
                            '../ajax/save_satisfaction_survey.php',
                            {
                                program_id: document.getElementById('program_search').options[document.getElementById('program_search').selectedIndex].value,
                                participant_id: document.getElementById('relative_search').options[document.getElementById('relative_search').selectedIndex].value,
                                1: document.getElementById('older_question_1').options[document.getElementById('older_question_1').selectedIndex].value,
                                2: document.getElementById('older_question_2').options[document.getElementById('older_question_2').selectedIndex].value,
                                3: document.getElementById('older_question_3').options[document.getElementById('older_question_3').selectedIndex].value,
                                4: document.getElementById('older_question_4').options[document.getElementById('older_question_4').selectedIndex].value,
                                5: document.getElementById('older_question_5').options[document.getElementById('older_question_5').selectedIndex].value,
                                6: document.getElementById('older_question_6').options[document.getElementById('older_question_6').selectedIndex].value,
                                7: document.getElementById('older_question_7').options[document.getElementById('older_question_7').selectedIndex].value,
                                8: document.getElementById('older_question_8').options[document.getElementById('older_question_8').selectedIndex].value,
                                9: document.getElementById('older_question_9').options[document.getElementById('older_question_9').selectedIndex].value,
                                10: document.getElementById('older_question_10').options[document.getElementById('older_question_10').selectedIndex].value,
                                11: document.getElementById('older_question_11').options[document.getElementById('older_question_11').selectedIndex].value,
                                12: document.getElementById('older_question_12').value,
                                date: document.getElementById('program_dates_older').value
                            },
                            function (response){
                                document.getElementById('show_survey_thanks_satisfaction').innerHTML = 'Thank you for adding this survey!';
                            }
                    )
                          "></th></tr>
        </table>
        <p></p>
        <div id="show_survey_thanks_satisfaction" style="font-weight:bold; font-color:red;"></div>