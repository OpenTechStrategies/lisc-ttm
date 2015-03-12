<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id);

include "../../header.php";
include "../header.php";
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#participants_selector').addClass('selected');
	});
</script>
<h3>Teacher Post-Survey</h3><hr/><br/>

<!--
Add a new teacher pre-survey
-->

<?
	//retrieve survey responses if editing an existing survey
	if (isset($_GET['survey'])) {
            /*if this survey is being edited, the existing responses will show up.*/
		include "../include/dbconnopen.php";
                $survey_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_GET['survey']);
		$get_responses = "SELECT * FROM PM_Teacher_Survey_Post WHERE Post_Teacher_Survey_ID='" . $survey_sqlsafe . "'";
		$responses = mysqli_query($cnnLSNA, $get_responses);
		$response = mysqli_fetch_array($responses);
	}
?>


<h4><?
/*if this is a new survey, get[survey] will not be set, and "new" will appear: */
	if (!isset($_GET['survey'])) {
	?>New <?}?> Survey<?
	if (isset($_COOKIE['participant'])) {
		include "../classes/participants.php";
		$parti = new Participant();
		$parti->load_with_participant_id($_COOKIE['participant']);
		echo " - " . $parti->full_name;
	}
?></h4>

<table class="pm_survey">
    <tr><td class="pm_survey question" width="65%">1. School Name <br><span class="helptext">If you do not choose a school, the survey will
            save but will not display on the participant profile.</span></td>
        <td class="pm_survey response"><select id="new_school">
            <option value="">----------</option>
            <?$get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1'";
            include "../include/dbconnopen.php";
            $schools = mysqli_query($cnnLSNA, $get_schools);
            while ($school = mysqli_fetch_array($schools)) { ?>
                    <option value="<? echo $school['Institution_ID']; ?>" <?echo($response['School_Name']==$school['Institution_ID'] ? "selected='selected'" : null);?>><? echo $school['Institution_Name']; ?></option>
            <?}
            include "../include/dbconnclose.php";
            ?>
            </select></td></tr>
        <tr><td class="pm_survey question">2. Teacher Name</td>
        <td class="pm_survey response">
			<select id="new_teacher_name">
				<option value="">---------</option>
				<?
                                //this is meant to force them to add teachers to the system, but I imagine it's a bit opaque to end users.
                                //they have to add teachers to the system and then add "teacher" to their roles in order for them to show up here.
					$get_teachers = "SELECT * FROM Participants INNER JOIN Participants_Roles ON Participants.Participant_ID=Participants_Roles.Participant_ID WHERE Participants_Roles.Role_ID=6 ORDER BY Participants.Name_Last";
					include "../include/dbconnopen.php";
					$teachers=mysqli_query($cnnLSNA, $get_teachers);
					while($teacher=mysqli_fetch_array($teachers)) {
				?>
				<option value="<?echo $teacher['Participant_ID'];?>" <?echo($teacher['Participant_ID']==$response['Teacher_Name'] ? "selected='selected'": null);?>><?echo $teacher['Name_First']." ".$teacher['Name_Last'];?></option>
				<?
					}
					include "../include/dbconnclose.php";
				?>
			</select>
        </td></tr>
     
   
    <tr><td class="pm_survey question">3. Grade</td>
        <td class="pm_survey response"><input type="text" id="new_grade" value="<?echo $response['Grade'];?>"></td></tr>
        <tr><td class="pm_survey question">4.	Classroom Language</td>
        <td class="pm_survey response">
			<select id="class_language">
                <option value="">-----</option>
                <option value="1" <?echo($response['Classroom_Language']==1 ? "selected='selected'" : null);?>>Bilingual</option>
                <option value="2" <?echo($response['Classroom_Language']==2 ? "selected='selected'" : null);?>>Regular</option>
                <option value="3" <?echo($response['Classroom_Language']==3 ? "selected='selected'" : null);?>>Other</option>
            </select></td></tr>
    <tr><td class="pm_survey question">5.	My Parent Mentor... </td>
        <td class="pm_survey response"><select id="pm_attendance">
                <option value="">-----</option>
                <option value="1" <?echo($response['Attendance']==1 ? "selected='selected'" : null);?>>...never missed a day of work.</option>
                <option value="2" <?echo($response['Attendance']==2 ? "selected='selected'" : null);?>>...missed occasionally but always found a way to communicate with me.</option>
                <option value="3" <?echo($response['Attendance']==3 ? "selected='selected'" : null);?>>...missed occasionally without notice or explanation.</option>
				<option value="4" <?echo($response['Attendance']==4 ? "selected='selected'" : null);?>>...had irregular attendance and made it difficult for me to count on him or her.</option>
				<option value="5" <?echo($response['Attendance']==5 ? "selected='selected'" : null);?>>...left mid-semester without notice and I have not heard from her/him since.</option>
            </select></td></tr>
    <tr><td class="pm_survey question">6.	My Parent Mentor spent his or her time:</td>
        <td class="pm_survey response">
			<input type="checkbox" name="pm_activity" value="homework" id="homework" <?echo($response['Task_1']==1 ? "checked='checked'" : null);?>>Checking homework<br/>
			<input type="checkbox" name="pm_activity" value="tutoring" id="tutoring" <?echo($response['Task_2']==1 ? "checked='checked'" : null);?>>Tutoring students one-on-one<br/>
			<input type="checkbox" name="pm_activity" value="class_activity" id="class_activity" <?echo($response['Task_3']==1 ? "checked='checked'" : null);?>>Leading part of the class in an activity<br/>
			<input type="checkbox" name="pm_activity" value="organize" id="organize" <?echo($response['Task_4']==1 ? "checked='checked'" : null);?>>Helping organize the classroom<br/>
			<input type="checkbox" name="pm_activity" value="discipline" id="discipline" <?echo($response['Task_5']==1 ? "checked='checked'" : null);?>>Helping with discipline/disruptions<br/>
			<input type="checkbox" name="pm_activity" value="small_groups" id="small_groups" <?echo($response['Task_6']==1 ? "checked='checked'" : null);?>>Working with small groups of students<br/>
			<input type="checkbox" name="pm_activity" value="whole_class_activity" id="whole_class_activity" <?echo($response['Task_7']==1 ? "checked='checked'" : null);?>>Leading the whole class in an activity<br/>
			<input type="checkbox" name="pm_activity" value="other" id="other" <?echo($response['Task_8']==1 ? "checked='checked'" : null);?>> Other - please specify: <input type="text" id="other_activity" value="<?echo $response['Task_Other_Text'];?>"/>
		</td></tr>
    <tr><td class="pm_survey question">7.	My Parent Mentor spent the majority of his or her time:</td>
        <td class="pm_survey response"><input type="text" id="pm_time_spent" value="<?echo $response['Majority_Task'];?>"></td></tr>
    <tr><td class="pm_survey question">8.	Having the support of a Parent Mentor helps me achieve or maintain good <b>classroom management</b>.</td>
        <td class="pm_survey response">
			<input type="radio" name="classroom_mgmt" value="5" <?echo($response['Classroom_Benefits_8']==5 ? "checked='checked'" : null);?>>Strongly agree<br/>
			<input type="radio" name="classroom_mgmt" value="4" <?echo($response['Classroom_Benefits_8']==4 ? "checked='checked'" : null);?>>Agree<br/>
			<input type="radio" name="classroom_mgmt" value="3" <?echo($response['Classroom_Benefits_8']==3 ? "checked='checked'" : null);?>>Neutral<br/>
			<input type="radio" name="classroom_mgmt" value="2" <?echo($response['Classroom_Benefits_8']==2 ? "checked='checked'" : null);?>>Disagree<br/>
			<input type="radio" name="classroom_mgmt" value="1" <?echo($response['Classroom_Benefits_8']==1 ? "checked='checked'" : null);?>>Strongly disagree<br/>
			<input type="radio" name="classroom_mgmt" value="0" <?echo($response['Classroom_Benefits_8']==0 ? "checked='checked'" : null);?>>N/A<br/>
		Explain: <textarea rows="5" cols="30" id="classroom_mgmt_explain"><?echo $response['Explain_8'];?></textarea>
		</td></tr>
    <tr><td class="pm_survey question">9.	Having the support of a Parent Mentor helps me improve <b>homework</b> completion and helps me maintain a high expectation for homework in my classroom. </td>
        <td class="pm_survey response">
			<input type="radio" name="hw_completion" value="5" <?echo($response['Classroom_Benefits_9']==5 ? "checked='checked'" : null);?>>Strongly agree<br/>
			<input type="radio" name="hw_completion" value="4" <?echo($response['Classroom_Benefits_9']==4 ? "checked='checked'" : null);?>>Agree<br/>
			<input type="radio" name="hw_completion" value="3" <?echo($response['Classroom_Benefits_9']==3 ? "checked='checked'" : null);?>>Neutral<br/>
			<input type="radio" name="hw_completion" value="2" <?echo($response['Classroom_Benefits_9']==2 ? "checked='checked'" : null);?>>Disagree<br/>
			<input type="radio" name="hw_completion" value="1" <?echo($response['Classroom_Benefits_9']==1 ? "checked='checked'" : null);?>>Strongly disagree<br/>
			<input type="radio" name="hw_completion" value="0" <?echo($response['Classroom_Benefits_9']==0 ? "checked='checked'" : null);?>>N/A<br/>
		Explain: <textarea rows="5" cols="30" id="hw_completion_explain"><?echo $response['Explain_9'];?></textarea></td></tr>
    <tr><td class="pm_survey question">10.	Having the support of a parent mentor helps me improve students in <b>reading and/or math</b>.</td>
        <td class="pm_survey response">
		<input type="radio" name="reading_math" value="5" <?echo($response['Classroom_Benefits_10']==5 ? "checked='checked'" : null);?>>Strongly agree<br/>
		<input type="radio" name="reading_math" value="4" <?echo($response['Classroom_Benefits_10']==4 ? "checked='checked'" : null);?>>Agree<br/>
		<input type="radio" name="reading_math" value="3" <?echo($response['Classroom_Benefits_10']==3 ? "checked='checked'" : null);?>>Neutral<br/>
		<input type="radio" name="reading_math" value="2" <?echo($response['Classroom_Benefits_10']==2 ? "checked='checked'" : null);?>>Disagree<br/>
		<input type="radio" name="reading_math" value="1" <?echo($response['Classroom_Benefits_10']==1 ? "checked='checked'" : null);?>>Strongly disagree<br/>
		<input type="radio" name="reading_math" value="0" <?echo($response['Classroom_Benefits_10']==0 ? "checked='checked'" : null);?>>N/A<br/>
		Explain: <textarea rows="5" cols="30" id="reading_math_explain"><?echo $response['Explain_10'];?></textarea></td></tr>

    <tr><td class="pm_survey question">11.	Having a Parent Mentor strengthens my <b>understanding of or connection to the community</b>.</td>
        <td class="pm_survey response">
		<input type="radio" name="comm_connect" value="5" <?echo($response['Classroom_Benefits_11']==5 ? "checked='checked'" : null);?>>Strongly agree<br/>
		<input type="radio" name="comm_connect" value="4" <?echo($response['Classroom_Benefits_11']==4 ? "checked='checked'" : null);?>>Agree<br/>
		<input type="radio" name="comm_connect" value="3" <?echo($response['Classroom_Benefits_11']==3 ? "checked='checked'" : null);?>>Neutral<br/>
		<input type="radio" name="comm_connect" value="2" <?echo($response['Classroom_Benefits_11']==2 ? "checked='checked'" : null);?>>Disagree<br/>
		<input type="radio" name="comm_connect" value="1" <?echo($response['Classroom_Benefits_11']==1 ? "checked='checked'" : null);?>>Strongly disagree<br/>
		<input type="radio" name="comm_connect" value="0" <?echo($response['Classroom_Benefits_11']==0 ? "checked='checked'" : null);?>>N/A<br/>
		Explain: <textarea rows="5" cols="30" id="comm_connect_explain"><?echo $response['Explain_11'];?></textarea></td></tr>
    <tr><td class="pm_survey question">12.	Having a parent mentor strengthens student <b>social-emotional development</b>.</td>
        <td class="pm_survey response">
		<input type="radio" name="se_dev" value="5" <?echo($response['Classroom_Benefits_12']==5 ? "checked='checked'" : null);?>>Strongly agree<br/>
		<input type="radio" name="se_dev" value="4" <?echo($response['Classroom_Benefits_12']==4 ? "checked='checked'" : null);?>>Agree<br/>
		<input type="radio" name="se_dev" value="3" <?echo($response['Classroom_Benefits_12']==3 ? "checked='checked'" : null);?>>Neutral<br/>
		<input type="radio" name="se_dev" value="2" <?echo($response['Classroom_Benefits_12']==2 ? "checked='checked'" : null);?>>Disagree<br/>
		<input type="radio" name="se_dev" value="1" <?echo($response['Classroom_Benefits_12']==1 ? "checked='checked'" : null);?>>Strongly disagree<br/>
		<input type="radio" name="se_dev" value="0" <?echo($response['Classroom_Benefits_12']==0 ? "checked='checked'" : null);?>>N/A<br/>
		Explain: <input type="textarea" rows="5" cols="30" id="se_dev_explain"><?echo $response['Explain_12'];?></textarea></td></tr>
    <tr><td class="pm_survey question">13.	The Parent Mentors Program helps our school create a <b>welcoming and communicative environment for all parents</b>.</td>
        <td class="pm_survey response">
            <input type="radio" name="parent_environment" value="5" <?echo($response['School_Benefits_13']==5 ? "checked='checked'" : null);?>>Strongly agree<br/>
			<input type="radio" name="parent_environment" value="4" <?echo($response['School_Benefits_13']==4 ? "checked='checked'" : null);?>>Agree<br/>
			<input type="radio" name="parent_environment" value="3" <?echo($response['School_Benefits_13']==3 ? "checked='checked'" : null);?>>Neutral<br/>
			<input type="radio" name="parent_environment" value="2" <?echo($response['School_Benefits_13']==2 ? "checked='checked'" : null);?>>Disagree<br/>
			<input type="radio" name="parent_environment" value="1" <?echo($response['School_Benefits_13']==1 ? "checked='checked'" : null);?>>Strongly disagree<br/>
			<input type="radio" name="parent_environment" value="0" <?echo($response['School_Benefits_13']==0 ? "checked='checked'" : null);?>>N/A<br/>
		Explain: <textarea rows="5" cols="30" id="parent_environment_explain"><?echo $response['Explain_13'];?></textarea>
        </td></tr>
    <tr><td class="pm_survey question">14. The Parent Mentor Program helps our school build <b>parent-teacher trust</b>.</td>
        <td class="pm_survey response">
		<input type="radio" name="trust" value="5" <?echo($response['School_Benefits_14']==5 ? "checked='checked'" : null);?>>Strongly agree<br/>
		<input type="radio" name="trust" value="4" <?echo($response['School_Benefits_14']==4 ? "checked='checked'" : null);?>>Agree<br/>
		<input type="radio" name="trust" value="3" <?echo($response['School_Benefits_14']==3 ? "checked='checked'" : null);?>>Neutral<br/>
		<input type="radio" name="trust" value="2" <?echo($response['School_Benefits_14']==2 ? "checked='checked'" : null);?>>Disagree<br/>
		<input type="radio" name="trust" value="1" <?echo($response['School_Benefits_14']==1 ? "checked='checked'" : null);?>>Strongly disagree<br/>
		<input type="radio" name="trust" value="0" <?echo($response['School_Benefits_14']==0 ? "checked='checked'" : null);?>>N/A<br/>
		Explain: <textarea rows="5" cols="30" id="trust_explain"><?echo $response['Explain_14'];?></textarea></td></tr>
    <tr><td class="pm_survey question">15. The Parent Mentor Program helps teachers and parents to think of each other as <b>partners in educating children</b>.</td>
        <td class="pm_survey response">
		<input type="radio" name="partners" value="5" <?echo($response['School_Benefits_15']==5 ? "checked='checked'" : null);?>>Strongly agree<br/>
		<input type="radio" name="partners" value="4" <?echo($response['School_Benefits_15']==4 ? "checked='checked'" : null);?>>Agree<br/>
		<input type="radio" name="partners" value="3" <?echo($response['School_Benefits_15']==3 ? "checked='checked'" : null);?>>Neutral<br/>
		<input type="radio" name="partners" value="2" <?echo($response['School_Benefits_15']==2 ? "checked='checked'" : null);?>>Disagree<br/>
		<input type="radio" name="partners" value="1" <?echo($response['School_Benefits_15']==1 ? "checked='checked'" : null);?>>Strongly disagree<br/>
		<input type="radio" name="partners" value="0" <?echo($response['School_Benefits_15']==0 ? "checked='checked'" : null);?>>N/A<br/>
		Explain: <textarea rows="5" cols="30" id="partners_explain"><?echo $response['Explain_15'];?></textarea></td></tr>
	<tr><td class="pm_survey question">16. What kind of activities or training do you think would be most helpful <b>for Parent Mentors</b>?</td>
		<td class="pm_survey response"><textarea rows="5" cols="30" id="pm_training"><?echo $response['Recommendations_16'];?></textarea><br/><br/></td></tr>
	<tr><td class="pm_survey question">17. What kind of activities or training do you think would be most helpful <b>for teachers who host Parent Mentors</b>?</td>
		<td class="pm_survey response"><textarea rows="5" cols="30" id="teacher_training"><?echo $response['Recommendations_17'];?></textarea><br/><br/></td></tr>
	<tr><td class="pm_survey question">18. Overall comments and suggestions for the Parent Mentor Program:</td>
		<td class="pm_survey response"><textarea rows="5" cols="30" id="suggestions"><?echo $response['Recommendations_18'];?></textarea><br/><br/></td></tr>
    
	
    <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><th colspan="2">Think about the last WEEK.  On how many <em>days</em> did you...</th></tr>
    <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><td class="pm_survey question">A.  Have another teacher or paraprofessional working with you in your classroom?</td>
        <td class="pm_survey response"><select id="A">
                <option value="">-----</option>
                <option value="5" <?echo($response['Teacher_Involvement_A']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Teacher_Involvement_A']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Teacher_Involvement_A']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Teacher_Involvement_A']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Teacher_Involvement_A']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Teacher_Involvement_A']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
        <tr><td class="pm_survey question">B.	Have a parent volunteer or parent mentor in your classroom, working with students?</td>
        <td class="pm_survey response"><select id="B">
                <option value="">-----</option>
                <option value="5" <?echo($response['Teacher_Involvement_B']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Teacher_Involvement_B']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Teacher_Involvement_B']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Teacher_Involvement_B']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Teacher_Involvement_B']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Teacher_Involvement_B']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
            <tr><td class="pm_survey question">C.	Talk with at least one school parent face-to-face?</td>
        <td class="pm_survey response"><select id="C">
                <option value="">-----</option>
                <option value="5" <?echo($response['Teacher_Involvement_C']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Teacher_Involvement_C']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Teacher_Involvement_C']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Teacher_Involvement_C']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Teacher_Involvement_C']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Teacher_Involvement_C']==0 ? "selected='selected'" : null);?>>None</option>
                <option value="0">None</option>
            </select></td></tr>
                <tr><td class="pm_survey question">D.	Have a conversation with a school parent about something besides their child&apos;s progress or behavior?</td>
        <td class="pm_survey response"><select id="D">
                <option value="">-----</option>
                <option value="5" <?echo($response['Teacher_Involvement_D']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Teacher_Involvement_D']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Teacher_Involvement_D']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Teacher_Involvement_D']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Teacher_Involvement_D']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Teacher_Involvement_D']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
                             <tr><td class="pm_survey question">E.	Learn something new about the community in which your school is located?</td>
        <td class="pm_survey response"><select id="E">
                <option value="">-----</option>
                <option value="5" <?echo($response['Teacher_Involvement_E']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Teacher_Involvement_E']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Teacher_Involvement_E']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Teacher_Involvement_E']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Teacher_Involvement_E']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Teacher_Involvement_E']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
                                    <tr><td class="pm_survey question">F.	Ask a school parent for advice?</td>
        <td class="pm_survey response"><select id="F">
                <option value="">-----</option>
                <option value="5" <?echo($response['Teacher_Involvement_F']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Teacher_Involvement_F']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Teacher_Involvement_F']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Teacher_Involvement_F']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Teacher_Involvement_F']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Teacher_Involvement_F']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
                   <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><th colspan="2">Answer the questions below thinking about the last WEEK.</th></tr>
    <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><td class="pm_survey question">G.	How many of your students did YOU have time to work with 
                            one-on-one for 10 minutes or more, during school hours? (Not counting test administration.)
        <?echo $response['Teacher_Involvement_G'];?></td>
        <td class="pm_survey response"><select id="G">
                <option value="">-----</option>
                <option value="20"<?echo($response['Teacher_Involvement_G']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11"<?echo($response['Teacher_Involvement_G']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6"<?echo($response['Teacher_Involvement_G']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3"<?echo($response['Teacher_Involvement_G']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1"<?echo($response['Teacher_Involvement_G']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0"<?echo($response['Teacher_Involvement_G']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
                        <tr><td class="pm_survey question">H.	How many of your students did another adult (volunteer or staff) work with one-on-one for 10 minutes or more during school hours?</td>
        <td class="pm_survey response"><select id="H">
                <option value="">-----</option>
                <option value="20"<?echo($response['Teacher_Involvement_H']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11"<?echo($response['Teacher_Involvement_H']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6"<?echo($response['Teacher_Involvement_H']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3"<?echo($response['Teacher_Involvement_H']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1"<?echo($response['Teacher_Involvement_H']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0"<?echo($response['Teacher_Involvement_H']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>    
        
           
        
    <tr><td class="pm_survey question">I.	How many school parents did you greet by name? </td>
        <td class="pm_survey response"><select id="K">
                <option value="">-----</option>
                <option value="20"<?echo($response['Teacher_Parent_Network_K']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11"<?echo($response['Teacher_Parent_Network_K']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6"<?echo($response['Teacher_Parent_Network_K']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3"<?echo($response['Teacher_Parent_Network_K']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1"<?echo($response['Teacher_Parent_Network_K']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0"<?echo($response['Teacher_Parent_Network_K']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">J.	How many school parents do you have phone numbers or emails for, besides a school directory? </td>
        <td class="pm_survey response"><select id="L">
                <option value="">-----</option>
                <option value="20"<?echo($response['Teacher_Parent_Network_L']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11"<?echo($response['Teacher_Parent_Network_L']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6"<?echo($response['Teacher_Parent_Network_L']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3"<?echo($response['Teacher_Parent_Network_L']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1"<?echo($response['Teacher_Parent_Network_L']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0"<?echo($response['Teacher_Parent_Network_L']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>

<?if (!isset($_GET['survey'])){
        $new_survey_status=1;
    } else {
        $survey_id=$_GET['survey'];
                }?>
			
    <tr><th colspan="2"><input type="button" value="Save Survey" onclick="
        if (document.getElementById('homework').checked==true){ var grade=1; } else{ var grade=0;}
        if (document.getElementById('tutoring').checked==true){ var tutor=1; } else{ var tutor=0;}
        if (document.getElementById('class_activity').checked==true){ var class_activity=1; } else{ var class_activity=0;}
        if (document.getElementById('organize').checked==true){ var organize=1; } else{ var organize=0;}
        if (document.getElementById('discipline').checked==true){ var discipline=1; } else{ var discipline=0;}
        if (document.getElementById('small_groups').checked==true){ var small_groups=1; } else{ var small_groups=0;}
        if (document.getElementById('whole_class_activity').checked==true){ var whole_class=1; } else{ var whole_class=0;}
        if (document.getElementById('other').checked==true){ var other=1; } else{ var other=0;}
        
        var class_mgmt=document.getElementsByName('classroom_mgmt');
        var classroom_mgmt=0;
        for (var i=0; i<class_mgmt.length; i++){if (class_mgmt[i].checked==true){classroom_mgmt=class_mgmt[i].value;}}
        var hw_complete=document.getElementsByName('hw_completion');
        var hw_completion=0;
        for (var i=0; i<hw_complete.length; i++){if (hw_complete[i].checked==true){hw_completion=hw_complete[i].value;}}
        var read_math=document.getElementsByName('reading_math');
        var reading_math=0;
        for (var i=0; i<read_math.length; i++){if (read_math[i].checked==true){reading_math=read_math[i].value;}}
        var comm_conn=document.getElementsByName('comm_connect');
        var comm_connect=0;
        for (var i=0; i<comm_conn.length; i++){if (comm_conn[i].checked==true){comm_connect=comm_conn[i].value;}}
        var social_dev=document.getElementsByName('se_dev');
        var se_dev=0;
        for (var i=0; i<social_dev.length; i++){if (social_dev[i].checked==true){se_dev=social_dev[i].value;}}
        var parent_env=document.getElementsByName('parent_environment');
        var parent_environment=0;
        for (var i=0; i<parent_env.length; i++){if (parent_env[i].checked==true){parent_environment=parent_env[i].value;}}
        var pt_trust=document.getElementsByName('trust');
        var trust=0;
        for (var i=0; i<pt_trust.length; i++){if (pt_trust[i].checked==true){trust=pt_trust[i].value;}}
        var ed_partners=document.getElementsByName('partners');
        var partners=0;
        for (var i=0; i<ed_partners.length; i++){if (ed_partners[i].checked==true){partners=ed_partners[i].value;}}
        
        //alert('just before post');
        $.post(
               '../ajax/save_new_teacher_post_survey.php',
               {
                   new_survey: '<?echo $new_survey_status;?>',
		   school: document.getElementById('new_school').value,
                   teacher: document.getElementById('new_teacher_name').value,
                   grade:  document.getElementById('new_grade').value,
                   class_lang: document.getElementById('class_language').options[document.getElementById('class_language').selectedIndex].value,
                   pm_attendance: document.getElementById('pm_attendance').options[document.getElementById('pm_attendance').selectedIndex].value,
                   other_task_text: document.getElementById('other_activity').value,
                   grade_checkbox: grade,
                   tutor_checkbox: tutor,
                   class_activity_checkbox: class_activity,
                   organize_checkbox: organize,
                   discipline_checkbox: discipline,
                   small_groups_checkbox: small_groups,
                   groups_checkbox: small_groups,
                   whole_checkbox: whole_class,
                   organize_checkbox: organize,
                   other_checkbox: other,
		   pm_time_spent: document.getElementById('pm_time_spent').value,
		   8: classroom_mgmt,
		   exp_8: document.getElementById('classroom_mgmt_explain').value,
		   9: hw_completion,
		   exp_9: document.getElementById('hw_completion_explain').value,
		   10: reading_math,
		   exp_10: document.getElementById('reading_math_explain').value,
        	   11: comm_connect,
		   exp_11: document.getElementById('comm_connect_explain').value,
		   12: se_dev,
		   exp_12: document.getElementById('se_dev_explain').value,
		   13: parent_environment,
        	   exp_13: document.getElementById('parent_environment_explain').value,
		   14: trust,
		   exp_14: document.getElementById('trust_explain').value,
		   15: partners,
		   exp_15: document.getElementById('partners_explain').value,
		   pm_training: document.getElementById('pm_training').value,
                   teacher_training: document.getElementById('teacher_training').value,
                   suggestions: document.getElementById('suggestions').value,
                   A: document.getElementById('A').options[document.getElementById('A').selectedIndex].value,
                   B: document.getElementById('B').options[document.getElementById('B').selectedIndex].value,
                   C: document.getElementById('C').options[document.getElementById('C').selectedIndex].value,
                   D: document.getElementById('D').options[document.getElementById('D').selectedIndex].value,
                   E: document.getElementById('E').options[document.getElementById('E').selectedIndex].value,
                   F: document.getElementById('F').options[document.getElementById('F').selectedIndex].value,
                   G: document.getElementById('G').options[document.getElementById('G').selectedIndex].value,
                   H: document.getElementById('H').options[document.getElementById('H').selectedIndex].value,
                   //I: document.getElementById('I').options[document.getElementById('I').selectedIndex].value,
                   //J: document.getElementById('J').options[document.getElementById('J').selectedIndex].value,
                   K: document.getElementById('K').options[document.getElementById('K').selectedIndex].value,
                   L: document.getElementById('L').options[document.getElementById('L').selectedIndex].value
               },
               function (response){
                  // document.write(response);
                   document.getElementById('show_survey_response').innerHTML = '<span style=color:#990000;font-weight:bold;font-size:.9em; padding-left: 25px;>Thank you for entering this survey!</span>';
               }
               ).fail(failAlert);">
			   <div id="show_survey_response"></div></th></tr>
</table>

<br/><br/>
<?
include "../../footer.php";
?>