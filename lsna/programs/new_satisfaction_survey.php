<?php
//print_r($_POST);
include "../../header.php";
include "../header.php";
include "../classes/program.php";
$program = new Program();
$program->load_with_program_id($_COOKIE['program']);
include "../classes/participants.php";
$parti = new Participant();
$parti->load_with_participant_id($_COOKIE['participant']);
?>
<!--

-->
                <?include "../include/datepicker.php";?>
<script type="text/javascript">
    $(document).ready(function(){
                $('#programs_selector').addClass('selected');
				$('#young_children_satisfaction').hide();
                $('#older_children_satisfaction').hide();
                $('#save_survey').hide();
		});
</script>

<h3>Satisfaction Survey</h3><hr/><br/>
<!--To choose the program and participant, at least one of them must be set.  This happens because either
the survey is linked from the participant profile or from the program profile.  If both cookies are expired
or unset, though, the user will have trouble.
-->
<h4>Program: 
<?
	if (isset($_COOKIE['program'])) {echo $program->program_name;}
	else {
            /*find program based on programs linked to participant: */
?>
	<select id="set_program">
		<option value="">--------</option>
		<?
			$get_programs="SELECT * FROM Participants_Subcategories INNER JOIN Subcategories ON 
                            Participants_Subcategories.Subcategory_ID=Subcategories.Subcategory_ID 
                            WHERE Participants_Subcategories.Participant_ID='".$_COOKIE['participant']."'";
			include "../include/dbconnopen.php";
			$programs=mysqli_query($cnnLSNA, $get_programs);
			while($program=mysqli_fetch_array($programs)){
		?>
		<option value="<?echo $program['Subcategory_ID'];?>"><?echo $program['Subcategory_Name'];?></option>
		<?
			}
			include "../include/dbconnclose.php";
		?>
	</select><br/><span class="helptext">You must select a program or the survey will not save.</span>
<? } ?>
</h4>
<h4>Participant: 
<?
	if(isset($_COOKIE['participant'])) {echo $parti->participant_first_name . " " . $parti->participant_last_name;}
	else {
            /*find people based on program set: */
?>
	<select id="set_participant">
		<option value="">--------</option>
		<?
			$get_participants="SELECT * FROM Participants_Subcategories INNER JOIN Participants ON Participants_Subcategories.Participant_ID=Participants.Participant_ID WHERE Participants_Subcategories.Subcategory_ID='".$_COOKIE['program']."'";
			include "../include/dbconnopen.php";
			$participants=mysqli_query($cnnLSNA, $get_participants);
			while($participant=mysqli_fetch_array($participants)){
		?>
		<option value="<?echo $participant['Participant_ID'];?>"><?echo $participant['Name_First']." ".$participant['Name_Last'];?></option>
		<?
			}
			include "../include/dbconnclose.php";
		?>
	</select><br/><span class="helptext">You must select a participant or the survey will not save.</span>
<? } ?>
</h4>
<br/>


<?
	//retrieve survey responses if editing an existing survey
	if (isset($_GET['survey'])) {
		$get_responses = "SELECT * FROM Satisfaction_Surveys WHERE Satisfaction_Survey_ID='" . $_GET['survey'] . "'";
		include "../include/dbconnopen.php";
		$responses = mysqli_query($cnnLSNA, $get_responses);
		$response = mysqli_fetch_array($responses);
		$date_formatted = explode('-', $response['Date']);
		$date = $date_formatted[1] . '-'. $date_formatted[2] . '-'. $date_formatted[0];
	}
?>

<script type="text/javascript">
	$(document).ready(function() {
<?
	//show the appropriate survey if editing an existing survey
	if ($response['Version']==3) {
?>
		$('#young_children_satisfaction').show();
		$('#older_children_satisfaction').hide();
		$('#younger_survey').addClass('selected');
<?
	} else if ($response['Version']==4) {
?>
		$('#young_children_satisfaction').hide();
		$('#older_children_satisfaction').show();
		$('#older_survey').addClass('selected');
<?
	}
?>
	});
</script>

<!--If this is a new survey, choose its type.  The table of corresponding questions and responses will show up 
onclick. -->
<div id="survey_wrapper" style="text-align:center;">

        <strong style="font-size:.8em;">Select the survey type: </strong>
            <a class="add_new survey_select" href="javascript:;" id="younger_survey" onclick="
                     $('#young_children_satisfaction').show();
					 $(this).addClass('selected');
					 $('#older_survey').removeClass('selected');
                     $('#older_children_satisfaction').hide();
                     $('#save_survey').show();
                 ">Survey 3rd Grade and Younger</a>
            <a class="add_new survey_select" href="javascript:;" id="older_survey" onclick="
                     $('#young_children_satisfaction').hide();
					 $(this).addClass('selected');
					 $('#younger_survey').removeClass('selected');
                     $('#older_children_satisfaction').show();
                     $('#save_survey').show();
				">Survey 4th Grade and Older</a>
        </p></div>
        
        <!--Third grade and younger survey-->
		<table class="pm_survey" id="young_children_satisfaction">
            <tr><td class="pm_survey question" style="text-align:right;">Dates of Program:</td>
                <td class="pm_survey response"><input type="text" id="program_dates" class="hadDatepicker" value="<?echo $date;?>"></td>
            </tr>
            <tr>
                <td class="pm_survey question">1.  I attended this program all the time.</td>
                <td class="pm_survey response"><select id="question_1">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_1']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_1']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_1']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">2.  I like this program.</td>
                <td class="pm_survey response"><select id="question_2">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_2']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_2']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_2']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">3.  The teacher was helpful.</td>
                <td class="pm_survey response"><select id="question_3">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_3']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_3']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_3']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">4. This program helped me improve in math.</td>
                <td class="pm_survey response"><select id="question_4">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_4']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_4']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_4']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">5. This program helped me improve in reading.</td>
                <td class="pm_survey response"><select id="question_5">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_5']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_5']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_5']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">6. I will tell my friends about this program.</td>
                <td class="pm_survey response"><select id="question_6">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_6']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_6']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_6']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">7. I signed up because I thought the program would be fun.</td>
                <td class="pm_survey response"><select id="question_7">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_7']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_7']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_7']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">8. I signed up because my friends signed up.</td>
                <td class="pm_survey response"><select id="question_8">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_8']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_8']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_8']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">9. I signed up because my parents wanted me to.</td>
                <td class="pm_survey response"><select id="question_9">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_9']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_9']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_9']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">10. I signed up because my teacher wanted me to take it.</td>
                <td class="pm_survey response"><select id="question_10">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_10']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_10']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_10']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">11. I signed up because I wanted to.</td>
                <td class="pm_survey response"><select id="question_11">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_11']==1 ? "selected='selected'" : null);?>>Yes</option>
                        <option value="2" <?echo($response['Question_11']==2 ? "selected='selected'" : null);?>>Maybe</option>
                        <option value="3" <?echo($response['Question_11']==3 ? "selected='selected'" : null);?>>No</option>
                    </select></td>
            </tr>
            <?
            /*determines how this survey should be treated in the ajax file.  Insert or Update? (is it new or edited)*/
            if (!isset($_GET['survey'])){
        $new_survey_status=1;
    } else {
        $survey_id=$_GET['survey'];
                }?>
            <!--Save 3rd grade survey.-->
            <tr><th colspan="2"><input type="button" value="Save Survey" onclick="
                        var program = '<?echo $_COOKIE['program'];?>';
                        //program must be chosen
                        if (program==''){
                            var select_dropdown=document.getElementById('set_program');
                            if(select_dropdown != null){
                             //alert('yes!');
                                var program = document.getElementById('set_program').options[document.getElementById('set_program').selectedIndex].value;
                            }
                            else{
                                var program = '<?echo $_POST['program_search'];?>';
                                if (program==''){
                                    alert('Please choose a program.');
                                    return false;
                                }
                            }
                        }
			var parti = '<?echo $_COOKIE['participant'];?>';
                        //person must be chosen
                        if (parti==''){
                            var select_dropdown=document.getElementById('set_participant');
                            if(select_dropdown != null){
                             //alert('yes!');
                                var parti = document.getElementById('set_participant').options[document.getElementById('set_participant').selectedIndex].value;
                            }
                            else{
                                var parti = '<?echo $_POST['program_search'];?>';
                                if (parti==''){
                                    alert('Please choose a participant.');
                                    return false;
                                }
                            }
                        }
                        $.post(
                            '../ajax/save_satisfaction_survey.php',
                            {
                                new_survey: '<?echo $new_survey_status;?>',
                                survey_id: '<?echo $survey_id;?>',
                                program_id: program,
                                participant_id: parti,
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
                                date: document.getElementById('program_dates').value,
								version: '3'
                            },
                            function (response){
                                document.getElementById('show_survey_thanks_satisfaction').innerHTML = 'Thank you for adding this survey!';
                            }
                    )
                          "></th></tr>
        </table>
        
        
        <!--Fourth grade and older survey-->
        <table class="pm_survey" id="older_children_satisfaction">
            <tr><td class="pm_survey question" style="text-align:right;">Dates of Program:</td>
                <td class="pm_survey response"><input type="text" id="program_dates_older" class="hadDatepicker" value="<?echo $date;?>"></td>
            </tr>
            <tr>
                <td class="pm_survey question">1.  This program has helped me improve my grades.</td>
                <td class="pm_survey response"><select id="older_question_1">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_1']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_1']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_1']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">2.  I have made new friends through this program.</td>
                <td class="pm_survey response"><select id="older_question_2">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_2']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_2']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_2']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">3.  This program helped me improve my math skills.</td>
                <td class="pm_survey response"><select id="older_question_3">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_3']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_3']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_3']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">4. This program helped me improve my reading skills.</td>
                <td class="pm_survey response"><select id="older_question_4">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_4']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_4']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_4']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">5. I believe that this program could help kids stay out of trouble.</td>
                <td class="pm_survey response"><select id="older_question_5">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_5']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_5']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_5']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">6. I will tell my friends about this program.</td>
                <td class="pm_survey response"><select id="older_question_6">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_6']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_6']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_6']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">7. I had fun at this program.</td>
                <td class="pm_survey response"><select id="older_question_7">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_7']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_7']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_7']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">8. I signed up for this program because my teacher told me to take this program.</td>
                <td class="pm_survey response"><select id="older_question_8">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_8']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_8']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_8']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">9. I signed up for this program because my friends signed up.</td>
                <td class="pm_survey response"><select id="older_question_9">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_9']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_9']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_9']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">10. I signed up for this program because my parents told me to.</td>
                <td class="pm_survey response"><select id="older_question_10">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_10']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_10']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_10']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">11. I signed up for this program because I chose to.</td>
                <td class="pm_survey response"><select id="older_question_11">
                        <option value="">----</option>
                        <option value="1" <?echo($response['Question_11']==1 ? "selected='selected'" : null);?>>Agree</option>
                        <option value="2" <?echo($response['Question_11']==2 ? "selected='selected'" : null);?>>Somewhat Agree</option>
                        <option value="3" <?echo($response['Question_11']==3 ? "selected='selected'" : null);?>>Disagree</option>
                    </select></td>
            </tr>
            <tr>
                <td class="pm_survey question">12. What suggestions do you have for improving this program?</td>
                <td class="pm_survey response"><textarea id="older_question_12"><?echo $response['Question_12'];?></textarea></td>
            </tr>
            
            
            <tr><th colspan="2"><input type="button" value="Save Survey" onclick="
                         var program = '<?echo $_COOKIE['program'];?>';
                         //program must be chosen: 
                        if (program==''){
                            var select_dropdown=document.getElementById('set_program');
                            if(select_dropdown != null){
                             //alert('yes!');
                                var program = document.getElementById('set_program').options[document.getElementById('set_program').selectedIndex].value;
                            }
                            else{
                                var program = '<?echo $_POST['program_search'];?>';
                                if (program==''){
                                    alert('Please choose a program.');
                                    return false;
                                }
                            }
                        }
                        
                        var parti = '<?echo $_COOKIE['participant'];?>';
                        //person must be chosen: 
                        if (parti==''){
                            var select_dropdown=document.getElementById('set_participant');
                            if(select_dropdown != null){
                             //alert('yes!');
                                var parti = document.getElementById('set_participant').options[document.getElementById('set_participant').selectedIndex].value;
                            }
                            else{
                                var parti = '<?echo $_POST['program_search'];?>';
                                if (parti==''){
                                    alert('Please choose a participant.');
                                    return false;
                                }
                            }
                        }
                        //alert(program);
                         $.post(
                            '../ajax/save_satisfaction_survey.php',
                            {
                                new_survey: '<?echo $new_survey_status;?>',
                                survey_id: '<?echo $survey_id;?>',
                                program_id: program,
                                participant_id: parti,
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
                                date: document.getElementById('program_dates_older').value,
				version: '4'
                            },
                            function (response){
                                //document.write(response);
                                document.getElementById('show_survey_thanks_satisfaction').innerHTML = 'Thank you for adding this survey!';
                            }
                    )
                          "></th></tr>
        </table>
        <p></p>
        <div id="show_survey_thanks_satisfaction" style="font-weight:bold; color:red;"></div>
</div>
		<br/>
		<?// } 
			include "../../footer.php"; ?>
		