<?php

include "../../header.php";
include "../header.php";
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#participants_selector').addClass('selected');
	});
</script>

<h3>Teacher Pre-Survey</h3><hr/><br/>

<!--
Add a new teacher pre-survey
-->

<?
	//retrieve survey responses if editing an existing survey
	if (isset($_GET['survey'])) {
            /*if this survey is being edited, the existing responses will show up.*/
                $survey_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_GET['survey']);
		$get_responses = "SELECT * FROM PM_Teacher_Survey WHERE PM_Teacher_Survey_ID='" . $survey_sqlsafe . "'";
		include "../include/dbconnopen.php";
		$responses = mysqli_query($cnnLSNA, $get_responses);
		$response = mysqli_fetch_array($responses);
	}
?><h4><?
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
    <tr><td class="pm_survey question" width="65%">1. School Name</td>
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
        <td class="pm_survey response"><select id="class_language">
                <option value="">-----</option>
                <option value="1" <?echo($response['Classroom_Language']==1 ? "selected='selected'" : null);?>>Bilingual</option>
                <option value="2" <?echo($response['Classroom_Language']==2 ? "selected='selected'" : null);?>>Regular</option>
                <option value="3" <?echo($response['Classroom_Language']==3 ? "selected='selected'" : null);?>>Other</option>
            </select></td></tr>
    <tr><td class="pm_survey question">5.	How many years have you participated in the Parent Mentor Program? </td>
        <td class="pm_survey response"><select id="years_with_pm">
                <option value="">-----</option>
                <option value="1" <?echo($response['Years_In_Program']==1 ? "selected='selected'" : null);?>>1st Year</option>
                <option value="2" <?echo($response['Years_In_Program']==2 ? "selected='selected'" : null);?>>2nd Year</option>
                <option value="3" <?echo($response['Years_In_Program']==3 ? "selected='selected'" : null);?>>3rd Year+</option>
            </select></td></tr>
    <tr><td class="pm_survey question">6.	What languages do you speak?</td>
        <td class="pm_survey response"><select id="languages_spoken">
                <option value="">-----</option>
                <option value="1" <?echo($response['Languages']==1 ? "selected='selected'" : null);?>>English</option>
                <option value="2" <?echo($response['Languages']==2 ? "selected='selected'" : null);?>>Spanish</option>
                <option value="3" <?echo($response['Languages']==3 ? "selected='selected'" : null);?>>Other</option>
				<option value="4" <?echo($response['Languages']==4 ? "selected='selected'" : null);?>>Both English and Spanish</option>
            </select></td></tr>
    <tr><td class="pm_survey question">7.	How many years have you been a teacher?</td>
        <td class="pm_survey response"><select id="years_as_teacher">
                <option value="">-----</option>
                <option value="1" <?echo($response['Years_As_Teacher']==1 ? "selected='selected'" : null);?>>1-2 years</option>
                <option value="3" <?echo($response['Years_As_Teacher']==3 ? "selected='selected'" : null);?>>3-5 years</option>
                <option value="5" <?echo($response['Years_As_Teacher']==5 ? "selected='selected'" : null);?>>5-10 years</option>                
                <option value="10" <?echo($response['Years_As_Teacher']==10 ? "selected='selected'" : null);?>>10+ years</option>
            </select></td></tr>
    <tr><td class="pm_survey question">8.	How many years have you worked at this school?</td>
        <td class="pm_survey response"><select id="years_at_school">
                <option value="">-----</option>
                <option value="1" <?echo($response['Years_At_School']==1 ? "selected='selected'" : null);?>>1-2 years</option>
                <option value="3" <?echo($response['Years_At_School']==3 ? "selected='selected'" : null);?>>3-5 years</option>
                <option value="5" <?echo($response['Years_At_School']==5 ? "selected='selected'" : null);?>>5-10 years</option>                
                <option value="10" <?echo($response['Years_At_School']==10 ? "selected='selected'" : null);?>>10+ years</option>
            </select></td></tr>
    <tr><td class="pm_survey question">9.	How many students do you have in your classroom? </td>
        <td class="pm_survey response"><input type="text" id="students_in_class" value="<?echo $response['Num_Students'];?>"></td></tr>
    <tr><td class="pm_survey question">10.	How many of your students are English Language Learners?<br/><span class="helptext">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(N/A if you work with multiple classes)</span> </td>
        <td class="pm_survey response"><input type="text" id="num_ell" value="<?echo $response['Num_ELL_Students'];?>"></td></tr>

    <tr><td class="pm_survey question">11.	How many of your students have IEPs or special needs?<br/><span class="helptext">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(N/A if you work with multiple classes)</span></td>
        <td class="pm_survey response"><input type="text" id="num_iep" value="<?echo $response['Num_IEP_Students'];?>"></td></tr>
    <tr><td class="pm_survey question">12.	How many of your students started the year below grade level? <br/><span class="helptext">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(N/A if you work with multiple classes)</span></td>
        <td class="pm_survey response"><input type="text" id="num_below_grade" value="<?echo $response['Num_Students_Below_Grade_Level'];?>"></td></tr>
    <tr><td class="pm_survey question">13.	I would like my Parent Mentor to (please check ALL that apply):</td>
        <td class="pm_survey response">
            <input type="checkbox" id="grade_papers" <?echo($response['Task_1']==1 ? "checked='checked'": null);?>> grade papers.<br>
            <input type="checkbox" id="tutor_one" <?echo($response['Task_2']==1 ? "checked='checked'": null);?>> tutor students one on one.<br>
            <input type="checkbox" id="lead_half_class" <?echo($response['Task_3']==1 ? "checked='checked'": null);?>> lead part of the class in an activity.<br>
            <input type="checkbox" id="hallway" <?echo($response['Task_4']==1 ? "checked='checked'": null);?>> take children to the washroom, etc.<br>
            <input type="checkbox" id="discipline" <?echo($response['Task_5']==1 ? "checked='checked'": null);?>> help with discipline/disruptions.<br>
            <input type="checkbox" id="homework" <?echo($response['Task_6']==1 ? "checked='checked'": null);?>> check homework.<br>
            <input type="checkbox" id="small_groups" <?echo($response['Task_7']==1 ? "checked='checked'": null);?>> work with small groups of students.<br>
            <input type="checkbox" id="lead_whole_class" <?echo($response['Task_8']==1 ? "checked='checked'": null);?>> lead the whole class in an activity.<br>
            <input type="checkbox" id="organize" <?echo($response['Task_9']==1 ? "checked='checked'": null);?>> help organize the classroom.<br>
            <input type="checkbox" id="other" <?echo($response['Task_10']==1 ? "checked='checked'": null);?>> other (please specify) <input type="text" id="other_task_text" value="<?echo $response['Task_Other_Text'];?>"/><br>
        </td></tr>
    <tr><td class="pm_survey question">14. What kind of activities or training do you think would be most helpful for parent mentors?</td>
        <td class="pm_survey response"><textarea id="training_pms"><?echo $response['PM_Activities_Training'];?></textarea></td></tr>
    <tr><td class="pm_survey question">15. What kind of activities or training do you think would be helpful for teachers who host parent mentors?</td>
        <td class="pm_survey response"><textarea id="training_teachers"><?echo $response['Teacher_Activities_Training'];?></textarea></td></tr>
    
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
            </select></td></tr>
                <tr><td class="pm_survey question">D.	Have a conversation with a school parent about something besides their child’s progress or behavior?</td>
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
                    <tr><td class="pm_survey question">G.	How many of your students did YOU have time
                            to work with one-on-one for 10 minutes or more, during school hours?
                        (Not counting test administration)</td>
        <td class="pm_survey response"><select id="G">
                <option value="">-----</option>
                <option value="20" <?echo($response['Teacher_Involvement_G']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11" <?echo($response['Teacher_Involvement_G']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6" <?echo($response['Teacher_Involvement_G']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3" <?echo($response['Teacher_Involvement_G']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['Teacher_Involvement_G']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['Teacher_Involvement_G']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
                        <tr><td class="pm_survey question">H.	How many of your students did another adult (staff, volunteer or parent mentor) 
                                work with one-on-one for 10 minutes or more, during school hours? (Not counting test administration.)</td>
        <td class="pm_survey response"><select id="H">
                <option value="">-----</option>
                <option value="20" <?echo($response['Teacher_Involvement_H']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11" <?echo($response['Teacher_Involvement_H']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6" <?echo($response['Teacher_Involvement_H']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3" <?echo($response['Teacher_Involvement_H']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['Teacher_Involvement_H']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['Teacher_Involvement_H']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>    

         

    <tr><td class="pm_survey question">I.	How many school parents (parents of your students, parent mentors, volunteers) did you greet by name? </td>
        <td class="pm_survey response"><select id="K">
                <option value="">-----</option>
                <option value="20" <?echo($response['Teacher_Parent_Network_K']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11" <?echo($response['Teacher_Parent_Network_K']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6" <?echo($response['Teacher_Parent_Network_K']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3" <?echo($response['Teacher_Parent_Network_K']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['Teacher_Parent_Network_K']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['Teacher_Parent_Network_K']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">J.	How many school parents do you have phone numbers or emails for (besides a school directory)? </td>
        <td class="pm_survey response"><select id="L">
                <option value="">-----</option>
                <option value="20" <?echo($response['Teacher_Parent_Network_L']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11" <?echo($response['Teacher_Parent_Network_L']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6" <?echo($response['Teacher_Parent_Network_L']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3" <?echo($response['Teacher_Parent_Network_L']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['Teacher_Parent_Network_L']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['Teacher_Parent_Network_L']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
<?if (!isset($_GET['survey'])){
        $new_survey_status=1;
    } else {
        $survey_id=$_GET['survey'];
                }?>
    
    
    <tr><th colspan="2"><input type="button" value="Save Survey" onclick="
        if (document.getElementById('grade_papers').checked==true){ var grade=1; } else{ var grade=0;}
        if (document.getElementById('tutor_one').checked==true){ var tutor=1; } else{ var tutor=0;}
        if (document.getElementById('lead_half_class').checked==true){ var half_class=1; } else{ var half_class=0;}
        if (document.getElementById('hallway').checked==true){ var hallway=1; } else{ var hallway=0;}
        if (document.getElementById('discipline').checked==true){ var discipline=1; } else{ var discipline=0;}
        if (document.getElementById('homework').checked==true){ var homework=1; } else{ var homework=0;}
        if (document.getElementById('small_groups').checked==true){ var small_groups=1; } else{ var small_groups=0;}
        if (document.getElementById('lead_whole_class').checked==true){ var whole_class=1; } else{ var whole_class=0;}
        if (document.getElementById('organize').checked==true){ var organize=1; } else{ var organize=0;}
        if (document.getElementById('other').checked==true){ var other=1; } else{ var other=0;}
        
        $.post(
               '../ajax/save_new_teacher_survey.php',
               {
                   new_survey: '<?echo $new_survey_status;?>',
                   survey_id: '<?echo $survey_id;?>',
		   school: document.getElementById('new_school').value,
                   teacher: document.getElementById('new_teacher_name').value,
                   grade:  document.getElementById('new_grade').value,
                   class_lang: document.getElementById('class_language').options[document.getElementById('class_language').selectedIndex].value,
                   years_pm_program:  document.getElementById('years_with_pm').options[document.getElementById('years_with_pm').selectedIndex].value,
                   teacher_language: document.getElementById('languages_spoken').options[document.getElementById('languages_spoken').selectedIndex].value,
                   years_teacher: document.getElementById('years_as_teacher').options[document.getElementById('years_as_teacher').selectedIndex].value,
                   years_at_school: document.getElementById('years_at_school').options[document.getElementById('years_at_school').selectedIndex].value,
                   num_students: document.getElementById('students_in_class').value,
                   num_ell: document.getElementById('num_ell').value,
                   num_iep: document.getElementById('num_iep').value,
                   num_below_grade: document.getElementById('num_below_grade').value,
                   training_pms: document.getElementById('training_pms').value,
                   training_teachers: document.getElementById('training_teachers').value,
                   other_task_text: document.getElementById('other_task_text').value,
                   grade_checkbox: grade,
                   tutor_checkbox: tutor,
                   half_checkbox: half_class,
                   hallway_checkbox: hallway,
                   discipline_checkbox: discipline,
                   homework_checkbox: homework,
                   groups_checkbox: small_groups,
                   whole_checkbox: whole_class,
                   organize_checkbox: organize,
                   other_checkbox: other,
                   A: document.getElementById('A').options[document.getElementById('A').selectedIndex].value,
                   B: document.getElementById('B').options[document.getElementById('B').selectedIndex].value,
                   C: document.getElementById('C').options[document.getElementById('C').selectedIndex].value,
                   D: document.getElementById('D').options[document.getElementById('D').selectedIndex].value,
                   E: document.getElementById('E').options[document.getElementById('E').selectedIndex].value,
                   F: document.getElementById('F').options[document.getElementById('F').selectedIndex].value,
                   G: document.getElementById('G').options[document.getElementById('G').selectedIndex].value,
                   H: document.getElementById('H').options[document.getElementById('H').selectedIndex].value,
                  // I: document.getElementById('I').options[document.getElementById('I').selectedIndex].value,
                  // J: document.getElementById('J').options[document.getElementById('J').selectedIndex].value,
                   K: document.getElementById('K').options[document.getElementById('K').selectedIndex].value,
                   L: document.getElementById('L').options[document.getElementById('L').selectedIndex].value
               },
               function (response){
                  // document.write(response);
                   document.getElementById('show_survey_response').innerHTML = '<span style=color:#990000;font-weight:bold;font-size:.9em; padding-left: 25px;>Thank you for entering this survey!</span>';
               }
               )">
			   <div id="show_survey_response"></div></th></tr>
</table>

<br/><br/>
<?
include "../../footer.php";
?>