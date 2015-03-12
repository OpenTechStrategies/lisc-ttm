<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($LSNA_id);

include "../../header.php";
include "../header.php";
?>
<!--Page for new parent mentor survey.  Linked from participant profile, which gives it the value of the 
participant id.-->

<script type="text/javascript">
	$(document).ready(function() {
		$('#participants_selector').addClass('selected');
                $("#save_btn").one('click', function() {  });
                $('#pre_post').change(function(){
                    if($(this).val() != '1'){ 
                      $('.pre_only').hide();
                    }
                    else{
                      $('.pre_only').show();
                    }
                  });
	});
</script>

<h3>Parent Mentor Survey</h3>

<?php
/* in the case where a user got here from somewhere other than a participant profile, or if the participant cookie had
 * expired, they can choose the parent mentor from search results:
 */
if (!isset($_COOKIE['participant'])) { ?>
Select parent mentor from search results:<br><span class="helptext">You must select a parent mentor or the survey will not save.</span>
<table class="search_table">
	<tr>
		<td class="all_projects"><strong>First Name: </strong></td>
		<td class="all_projects"><input type="text" id="first_name_relative" /></td>
		<td class="all_projects"><strong>Role: </strong></td>
		<td class="all_projects"><select id="role_relative">
				<option value="">--------</option>
				<?
					$get_roles = "SELECT * FROM Roles";
					include "../include/dbconnopen.php";
					$roles = mysqli_query($cnnLSNA, $get_roles);
					while ($role = mysqli_fetch_array($roles)) {
					?>
						<option value="<? echo $role['Role_ID']; ?>"><? echo $role['Role_Title']; ?></option>
					<?}
					include "../include/dbconnclose.php";
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="all_projects"><strong>Last Name: </strong></td>
		<td class="all_projects"><input type="text" id="last_name_relative" /></td>
		<td class="all_projects"><strong>Gender: </strong></td>
		<td class="all_projects"><select id="gender_relative">
				<option value="">--------</option>
				<option value="m">Male</option>
				<option value="f">Female</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="all_projects"><strong>Date of Birth: </strong></td>
		<td class="all_projects"><input type="text" id="dob_relative" class="hasDatepicker" /></td>
		<td class="all_projects"><strong>Grade Level: </strong></td>
		<td class="all_projects"><select id="grade_relative">
				<option value="">--------</option>
				<option value="k">Kindergarten</option>
				<option value="1">1st Grade</option>
				<option value="2">2nd Grade</option>
				<option value="3">3rd Grade</option>
				<option value="4">4th Grade</option>
				<option value="5">5th Grade</option>
				<option value="6">6th Grade</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="all_projects" colspan="4">
			<input type="button" value="Search" onclick="
                            $.post(
                                '../ajax/search_participants.php',
                                {
                                    result: 'dropdown',
                                    first: document.getElementById('first_name_relative').value,
                                    last: document.getElementById('last_name_relative').value,
                                    dob: document.getElementById('dob_relative').value,
                                    grade: document.getElementById('grade_relative').value,
                                    gender: document.getElementById('gender_relative').options[document.getElementById('gender_relative').selectedIndex].value,
                                    role: document.getElementById('role_relative').options[document.getElementById('role_relative').selectedIndex].value
                                },
                                function (response){
                                    document.getElementById('show_results_profile').innerHTML = response;
                                    $('#add_buttons').show();
                                }
                                ).fail(failAlert);
                     "/>
		</td></tr></table>
        <div id="show_results_profile"></div>

        <!--If the parent mentor isn't in the database yet, here's a link to add him/her: -->
        
Or, <a href="javascript:;" onclick="
                   $.post(
                        '../ajax/set_participant_id.php',
                        {
                            page: 'new'
                        },
                        function (response){
                            if (response!='1'){
                                document.getElementById('show_error').innerHTML = response;
                            }
                            window.location='participants.php';
                       }
           ).fail(failAlert);
		">add new parent mentor profile</a> (and then return here).
<? } ?>


<h4><?
	if (!isset($_GET['survey'])) {
            /* if survey is set, then this is an edited survey, not a new one, so "New" wouldn't show up. */
?>New <?}?>Survey
<? if (isset($_COOKIE['participant'])) {
	include "../classes/participants.php";
	$parti = new Participant();
	$parti->load_with_participant_id($_COOKIE['participant']);
	echo " - " . $parti->full_name;
}?>
</h4>

<?
	//retrieve survey responses if editing an existing survey
	if (isset($_GET['survey'])) {
                $survey_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_GET['survey']);
		$get_responses = "SELECT * FROM Parent_Mentor_Survey WHERE Parent_Mentor_Survey_ID='" . $survey_sqlsafe . "'";
		include "../include/dbconnopen.php";
		$responses = mysqli_query($cnnLSNA, $get_responses);
		$response = mysqli_fetch_array($responses);
                
	}
?>
<div style="text-align:center;"><span class="helptext">This is a: </span><select id="pre_post" >
											<option value="">-----</option>
											<option value="1" <?php echo($response['Pre_Post']=='1' ? "selected='selected'" :null);?>>Pre-program survey</option>
                                                                                        <option value="2" <?php echo($response['Pre_Post']=='2' ? "selected='selected'" :null);?>>Mid-program survey</option>
											<option value="3" <?php echo($response['Pre_Post']=='3' ? "selected='selected'" :null);?>>Post-program survey</option>
										</select></div>
<table class="pm_survey">
    
    <tr class="pre_only"><td class="pm_survey question">Date</td>
        <td class="pm_survey response"><input type="text" class="hadDatepicker" id="new_survey_date" value="<?php echo $response['Date'];?>"></td></tr>
    <tr class="pre_only"><td class="pm_survey question">School</td>
        <td class="pm_survey response"><select id="new_school">
										<option value="">----------</option>
										<?$get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1'";
										include "../include/dbconnopen.php";
										$schools = mysqli_query($cnnLSNA, $get_schools);
										while ($school = mysqli_fetch_array($schools)) { ?>
											<option value="<? echo $school['Institution_ID']; ?>" <?echo($response['School']==$school['Institution_ID'] ? "selected='selected'" : null);?>><? echo $school['Institution_Name']; ?></option>
										<?}
										include "../include/dbconnclose.php";
										?>
									</select>	
		</td></tr>
    <tr class="pre_only"><td class="pm_survey question">Grade</td>
        <td class="pm_survey response"><input type="text" id="new_grade" value="<?echo $response['Grade'];?>"></td></tr>
    <tr class="pre_only"><td class="pm_survey question">Room Number</td>
        <td class="pm_survey response"><input type="text" id="room_number" value="<?echo $response['Room_Number'];?>"></td></tr>
    <tr class="pre_only"><td class="pm_survey question">1.	Is this your first year as a parent mentor? </td>
        <td class="pm_survey response"><select id="first_year_pm">
                <option value="">-----</option>
                <option value="1" <?echo($response['First_Year_PM']==1 ? "selected='selected'" : null);?>>Yes</option>
                <option value="0" <?echo($response['First_Year_PM']==0 ? "selected='selected'" : null);?>>No</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">2.	Number of children </td>
        <td class="pm_survey response"><select id="num_children">
                <option value="">-----</option>
                <option value="1" <?echo($response['Number_Children']==1 ? "selected='selected'" : null);?>>1</option>
                <option value="2" <?echo($response['Number_Children']==2 ? "selected='selected'" : null);?>>2</option>
                <option value="3" <?echo($response['Number_Children']==3 ? "selected='selected'" : null);?>>3</option>
                <option value="4" <?echo($response['Number_Children']==4 ? "selected='selected'" : null);?>>4</option>
                <option value="5" <?echo($response['Number_Children']==5 ? "selected='selected'" : null);?>>5</option>
                <option value="6" <?echo($response['Number_Children']==6 ? "selected='selected'" : null);?>>6</option>
                <option value="7" <?echo($response['Number_Children']==7 ? "selected='selected'" : null);?>>7</option>
                <option value="8" <?echo($response['Number_Children']==8 ? "selected='selected'" : null);?>>8</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">3.	Marital status </td>
        <td class="pm_survey response"><select id="marital_status">
                <option value="">-----</option>
                <option value="single" <?echo($response['Marital_Status']=='single' ? "selected='selected'" : null);?>>Single</option>
                <option value="partnered" <?echo($response['Marital_Status']=='partnered' ? "selected='selected'" : null);?>>Married or With Partner</option>
                <option value="divorced" <?echo($response['Marital_Status']=='divorced' ? "selected='selected'" : null);?>>Divorced</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">4.	Place of birth</td>
        <td class="pm_survey response"><select id="place_birth">
                <option value="">-----</option>
                <option value="USA" <?echo($response['Place_Birth']=='USA' ? "selected='selected'" : null);?>>USA</option>
                <option value="Mexico" <?echo($response['Place_Birth']=='Mexico' ? "selected='selected'" : null);?>>Mexico</option>
                <option value="PR" <?echo($response['Place_Birth']=='PR' ? "selected='selected'" : null);?>>Puerto Rico</option>
                <option value="Ecuador" <?echo($response['Place_Birth']=='Ecuador' ? "selected='selected'" : null);?>>Ecuador</option>
                <option value="Other" <?echo($response['Place_Birth']=='Other' ? "selected='selected'" : null);?>>Other</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">5.	Ethnicity</td>
        <td class="pm_survey response"><select id="ethnicity">
                <option value="">-----</option>
                <option value="Latino" <?echo($response['Ethnicity']=='Latino' ? "selected='selected'" : null);?>>Latino</option>
                <option value="African-American" <?echo($response['Ethnicity']=='African-American' ? "selected='selected'" : null);?>>African-American</option>
                <option value="White" <?echo($response['Ethnicity']=='White' ? "selected='selected'" : null);?>>White</option>
                <option value="Other" <?echo($response['Ethnicity']=='Other' ? "selected='selected'" : null);?>>Other</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">6.	Gender </td>
        <td class="pm_survey response"><select id="gender">
                <option value="">-----</option>
                <option value="F">Female</option>
                <option value="M">Male</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">7.	Language</td>
        <td class="pm_survey response"><select id="language">
                <option value="">-----</option>
                <option value="2">Only Spanish</option>
                <option value="1">Only English</option>
                <option value="both">Bilingual</option>
                <option value="other">Other</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">8.	Years in Illinois </td>
        <td class="pm_survey response"><select id="years_in_il">
                <option value="">-----</option>
                <option value="1" <?echo($response['Years_In_IL']==1 ? "selected='selected'" : null);?>>1-5 years</option>
                <option value="6" <?echo($response['Years_In_IL']==6 ? "selected='selected'" : null);?>>6-10 years</option>
                <option value="11" <?echo($response['Years_In_IL']==11 ? "selected='selected'" : null);?>>11-15 years</option>
                <option value="15" <?echo($response['Years_In_IL']==15 ? "selected='selected'" : null);?>>15+ years</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">9.	Education (completed)  </td>
        <td class="pm_survey response"><select id="ed_completed">
                <option value="">-----</option>
                <option value="el">Elementary</option>
                <option value="ms">Middle School</option>
                <option value="hs">High School</option>
                <option value="some_col">Some College</option>
                <option value="ba">Bachelor's</option>
                <option value="other">Other</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">10.      Classes you are taking now </td>
        <td class="pm_survey response"><select id="current_classes">
                <option value="">-----</option>
                <option value="English" <?echo($response['Classes_Taking']=='English' ? "selected='selected'" : null);?>>English</option>
                <option value="GED" <?echo($response['Classes_Taking']=='GED' ? "selected='selected'" : null);?>>GED</option>
                <option value="College" <?echo($response['Classes_Taking']=='College' ? "selected='selected'" : null);?>>College</option>
                <option value="Technical" <?echo($response['Classes_Taking']=='Technical' ? "selected='selected'" : null);?>>Technical</option>
                <option value="None" <?echo($response['Classes_Taking']=='None' ? "selected='selected'" : null);?>>None</option>
                <option value="Other" <?echo($response['Classes_Taking']=='Other' ? "selected='selected'" : null);?>>Other</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">11.	Are you currently working?</td>
        <td class="pm_survey response"><select id="currently_working">
                <option value="">-----</option>
                <option value="1" <?echo($response['Currently_Working']==1 ? "selected='selected'" : null);?>>Yes</option>
                <option value="0" <?echo($response['Currently_Working']==0 ? "selected='selected'" : null);?>>No</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">11b.     What type of job?</td>
        <td class="pm_survey response"><input type="text" id="current_job" value="<?echo $response['Current_Job'];?>"></td></tr>
    <tr class="pre_only"><td class="pm_survey question">12.	Your family’s average monthly income (estimate)</td>
        <td class="pm_survey response"><select id="monthly_income">
                <option value="">-----</option>
                <option value="<1000" <?echo($response['Monthly_Income']=='<1000' ? "selected='selected'" : null);?>>Less than $1000</option>
                <option value="1000" <?echo($response['Monthly_Income']==1000 ? "selected='selected'" : null);?>>$1000-$1500</option>
                <option value="1500" <?echo($response['Monthly_Income']==1500 ? "selected='selected'" : null);?>>$1500-$2000</option>
                <option value="2000" <?echo($response['Monthly_Income']==2000 ? "selected='selected'" : null);?>>$2000-$2500</option>
                <option value=">2500" <?echo($response['Monthly_Income']=='>2500' ? "selected='selected'" : null);?>>More than $2500</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">13.	Does your family receive food stamps? </td>
        <td class="pm_survey response"><select id="on_food_stamps">
                <option value="">-----</option>
                <option value="1" <?echo($response['On_Food_Stamps']==1 ? "selected='selected'" : null);?>>Yes</option>
                <option value="0" <?echo($response['On_Food_Stamps']==0 ? "selected='selected'" : null);?>>No</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">14.	Do you rent or own?</td>
        <td class="pm_survey response"><select id="rent_own">
                <option value="">-----</option>
                <option value="Rent" <?echo($response['Rent_Own']=='Rent' ? "selected='selected'" : null);?>>Rent</option>
                <option value="Own" <?echo($response['Rent_Own']=='Own' ? "selected='selected'" : null);?>>Own</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">15.	What is your monthly rent or mortgage payment?</td>
        <td class="pm_survey response"><select id="rent_payment">
                <option value="">-----</option>
                <option value="<500" <?echo($response['Rent_Payment']=='<500' ? "selected='selected'" : null);?>>Less than $500</option>
                <option value="500" <?echo($response['Rent_Payment']==500 ? "selected='selected'" : null);?>>$500-$699</option>
                <option value="700" <?echo($response['Rent_Payment']==700 ? "selected='selected'" : null);?>>$700-$899</option>
                <option value="900" <?echo($response['Rent_Payment']==900 ? "selected='selected'" : null);?>>$900-$1,050</option>
                <option value="1051" <?echo($response['Rent_Payment']==1051 ? "selected='selected'" : null);?>>$1,051-$1,250</option>
                <option value="1251" <?echo($response['Rent_Payment']==1251 ? "selected='selected'" : null);?>>$1,251+</option>
            </select></td></tr>
    <tr class="pre_only"><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr> <!-- ends the section of the table that only shows up in pre tests. -->
    <tr><th colspan="2">Think about the last WEEK.  On how many <em>days</em> did you...</th></tr>
    <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><td class="pm_survey question">A.   Ask your child about school?</td>
        <td class="pm_survey response"><select id="A">
                <option value="">-----</option>
                <option value="5" <?echo($response['Student_Involvement_A']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Student_Involvement_A']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Student_Involvement_A']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Student_Involvement_A']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Student_Involvement_A']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Student_Involvement_A']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
        <tr><td class="pm_survey question">B.   Communicate with your child's teacher?</td>
        <td class="pm_survey response"><select id="B">
                <option value="">-----</option>
                <option value="5" <?echo($response['Student_Involvement_B']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Student_Involvement_B']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Student_Involvement_B']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Student_Involvement_B']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Student_Involvement_B']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Student_Involvement_B']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
            <tr><td class="pm_survey question">C.   Communicate with the school principal?</td>
        <td class="pm_survey response"><select id="C">
                <option value="">-----</option>
                <option value="5" <?echo($response['Student_Involvement_C']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Student_Involvement_C']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Student_Involvement_C']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Student_Involvement_C']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Student_Involvement_C']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Student_Involvement_C']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
                <tr><td class="pm_survey question">D.   Talk with other parents from the school?</td>
        <td class="pm_survey response"><select id="D">
                <option value="">-----</option>
                <option value="5" <?echo($response['Student_Involvement_D']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Student_Involvement_D']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Student_Involvement_D']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Student_Involvement_D']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Student_Involvement_D']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Student_Involvement_D']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
                    <tr><td class="pm_survey question">E.   Spend time inside the school building?</td>
        <td class="pm_survey response"><select id="E">
                <option value="">-----</option>
                <option value="5" <?echo($response['Student_Involvement_E']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Student_Involvement_E']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Student_Involvement_E']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Student_Involvement_E']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Student_Involvement_E']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Student_Involvement_E']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
                        <tr><td class="pm_survey question">F.   Spend time inside a classroom with students?</td>
        <td class="pm_survey response"><select id="F">
                <option value="">-----</option>
                <option value="5" <?echo($response['Student_Involvement_F']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Student_Involvement_F']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Student_Involvement_F']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Student_Involvement_F']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Student_Involvement_F']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Student_Involvement_F']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>    
        <tr><td class="pm_survey question">G.   Help your child with schoolwork at home?</td>
        <td class="pm_survey response"><select id="G">
                <option value="">-----</option>
                <option value="5" <?echo($response['Student_Involvement_G']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Student_Involvement_G']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Student_Involvement_G']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Student_Involvement_G']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Student_Involvement_G']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Student_Involvement_G']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
            <tr><td class="pm_survey question">H.   Read with your child at home?</td>
        <td class="pm_survey response"><select id="H">
                <option value="">-----</option>
                <option value="5" <?echo($response['Student_Involvement_H']==5 ? "selected='selected'" : null);?>>5 days</option>
                <option value="4" <?echo($response['Student_Involvement_H']==4 ? "selected='selected'" : null);?>>4 days</option>                
                <option value="3" <?echo($response['Student_Involvement_H']==3 ? "selected='selected'" : null);?>>3 days</option>
                <option value="2" <?echo($response['Student_Involvement_H']==2 ? "selected='selected'" : null);?>>2 days</option>
                <option value="1" <?echo($response['Student_Involvement_H']==1 ? "selected='selected'" : null);?>>1 day</option>
                <option value="0" <?echo($response['Student_Involvement_H']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
        <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><th colspan="2">Your School Network<br>In the past WEEK...</th></tr>
    <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><td class="pm_survey question">I.	How many other parents from the school did you greet by name? </td>
        <td class="pm_survey response"><select id="I">
                <option value="">-----</option>
                <option value="20" <?echo($response['School_Network_I']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11" <?echo($response['School_Network_I']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6" <?echo($response['School_Network_I']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3" <?echo($response['School_Network_I']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Network_I']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Network_I']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">J.	How many teachers in the school did you greet? </td>
        <td class="pm_survey response"><select id="J">
                <option value="">-----</option>
                <option value="20" <?echo($response['School_Network_J']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11" <?echo($response['School_Network_J']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6" <?echo($response['School_Network_J']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3" <?echo($response['School_Network_J']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Network_J']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Network_J']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">K.	How many school parents do you have phone numbers or emails for? </td>
        <td class="pm_survey response"><select id="K">
                <option value="">-----</option>
                <option value="20" <?echo($response['School_Network_K']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11" <?echo($response['School_Network_K']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6" <?echo($response['School_Network_K']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3" <?echo($response['School_Network_K']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Network_K']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Network_K']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">L.	How many teachers do you have phone numbers or emails for? </td>
        <td class="pm_survey response"><select id="L">
                <option value="">-----</option>
                <option value="20" <?echo($response['School_Network_L']==20 ? "selected='selected'" : null);?>>20+</option>
                <option value="11" <?echo($response['School_Network_L']==11 ? "selected='selected'" : null);?>>11-20</option>
                <option value="6" <?echo($response['School_Network_L']==6 ? "selected='selected'" : null);?>>6-10</option>
                <option value="3" <?echo($response['School_Network_L']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Network_L']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Network_L']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><th colspan="2">Your School Network<br>Think about the last MONTH.  On how many <em>days</em> did you...</th></tr>
    <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><td class="pm_survey question">M.	Attend school parent committee meetings?</td>
        <td class="pm_survey response"><select id="M">
                <option value="">-----</option>
                <option value="10" <?echo($response['School_Involvement_M']==10 ? "selected='selected'" : null);?>>10+</option>
                <option value="5" <?echo($response['School_Involvement_M']==5 ? "selected='selected'" : null);?>>5-10</option>
                <option value="3" <?echo($response['School_Involvement_M']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Involvement_M']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Involvement_M']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">N.	Help lead or plan a school committee?</td>
        <td class="pm_survey response"><select id="N">
                <option value="">-----</option>
                <option value="10" <?echo($response['School_Involvement_N']==10 ? "selected='selected'" : null);?>>10+</option>
                <option value="5" <?echo($response['School_Involvement_N']==5 ? "selected='selected'" : null);?>>5-10</option>
                <option value="3" <?echo($response['School_Involvement_N']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Involvement_N']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Involvement_N']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">O.	Help plan school events, activities or initiatives?</td>
        <td class="pm_survey response"><select id="O">
                <option value="">-----</option>
                <option value="10" <?echo($response['School_Involvement_O']==10 ? "selected='selected'" : null);?>>10+</option>
                <option value="5" <?echo($response['School_Involvement_O']==5 ? "selected='selected'" : null);?>>5-10</option>
                <option value="3" <?echo($response['School_Involvement_O']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Involvement_O']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Involvement_O']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">P.	Attend a meeting or get involved in a community activity, outside of the school?</td>
        <td class="pm_survey response"><select id="P">
                <option value="">-----</option>
                <option value="10" <?echo($response['School_Involvement_P']==10 ? "selected='selected'" : null);?>>10+</option>
                <option value="5" <?echo($response['School_Involvement_P']==5 ? "selected='selected'" : null);?>>5-10</option>
                <option value="3" <?echo($response['School_Involvement_P']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Involvement_P']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Involvement_P']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">Q.	Share information about the school or the community with other parents in the neighborhood? </td>
        <td class="pm_survey response"><select id="Q">
                <option value="">-----</option>
                <option value="10" <?echo($response['School_Involvement_Q']==10 ? "selected='selected'" : null);?>>10+</option>
                <option value="5" <?echo($response['School_Involvement_Q']==5 ? "selected='selected'" : null);?>>5-10</option>
                <option value="3" <?echo($response['School_Involvement_Q']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Involvement_Q']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Involvement_Q']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
    <tr><td class="pm_survey question">R.	Attend a class for yourself?</td>
        <td class="pm_survey response"><select id="R">
                <option value="">-----</option>
                <option value="10" <?echo($response['School_Involvement_R']==10 ? "selected='selected'" : null);?>>10+</option>
                <option value="5" <?echo($response['School_Involvement_R']==5 ? "selected='selected'" : null);?>>5-10</option>
                <option value="3" <?echo($response['School_Involvement_R']==3 ? "selected='selected'" : null);?>>3-5</option>
                <option value="1" <?echo($response['School_Involvement_R']==1 ? "selected='selected'" : null);?>>1-2</option>
                <option value="0" <?echo($response['School_Involvement_R']==0 ? "selected='selected'" : null);?>>None</option>
            </select></td></tr>
	<tr><th colspan="2">Feelings About Yourself</th></tr>
    <tr><td class="pm_survey question">---</td>
        <td class="pm_survey response"></td></tr>
    <tr><td class="pm_survey question">S.	I will be able to achieve most of the goals that I have set for myself.</td>
        <td class="pm_survey response"><select id="Q1">
                <option value="">-----</option>
                <option value="5" <?echo($response['Self_Efficacy_Q']==5 ? "selected='selected'" : null);?>>Strongly Agree</option>
                <option value="4" <?echo($response['Self_Efficacy_Q']==4 ? "selected='selected'" : null);?>>Agree</option>
                <option value="3" <?echo($response['Self_Efficacy_Q']==3 ? "selected='selected'" : null);?>>Neither Agree nor Disagree</option>
                <option value="2" <?echo($response['Self_Efficacy_Q']==2 ? "selected='selected'" :null);?>>Disagree</option>
				<option value="1" <?echo($response['Self_Efficacy_Q']==1 ? "selected='selected'" : null);?>>Strongly Disagree</option>
            </select></td>
	</tr>
    <tr><td class="pm_survey question">T.	When facing difficult tasks, I am certain that I will accomplish them.</td>
        <td class="pm_survey response"><select id="R1">
                <option value="">-----</option>
                <option value="5" <?echo($response['Self_Efficacy_R']==5 ? "selected='selected'" : null);?>>Strongly Agree</option>
                <option value="4" <?echo($response['Self_Efficacy_R']==4 ? "selected='selected'" : null);?>>Agree</option>
                <option value="3" <?echo($response['Self_Efficacy_R']==3 ? "selected='selected'" : null);?>>Neither Agree nor Disagree</option>
                <option value="2" <?echo($response['Self_Efficacy_R']==2 ? "selected='selected'" :null);?>>Disagree</option>
				<option value="1" <?echo($response['Self_Efficacy_R']==1 ? "selected='selected'" : null);?>>Strongly Disagree</option>
            </select></td>
	</tr>
	<tr><td class="pm_survey question">U.	In general, I think that I can obtain outcomes that are important to me.</td>
        <td class="pm_survey response"><select id="S">
                <option value="">-----</option>
                <option value="5" <?echo($response['Self_Efficacy_S']==5 ? "selected='selected'" : null);?>>Strongly Agree</option>
                <option value="4" <?echo($response['Self_Efficacy_S']==4 ? "selected='selected'" : null);?>>Agree</option>
                <option value="3" <?echo($response['Self_Efficacy_S']==3 ? "selected='selected'" : null);?>>Neither Agree nor Disagree</option>
                <option value="2" <?echo($response['Self_Efficacy_S']==2 ? "selected='selected'" :null);?>>Disagree</option>
				<option value="1" <?echo($response['Self_Efficacy_S']==1 ? "selected='selected'" : null);?>>Strongly Disagree</option>
            </select></td>
	</tr>
	<tr><td class="pm_survey question">V.	I believe I can succeed at most any endeavor to which I set my mind.</td>
        <td class="pm_survey response"><select id="T">
                <option value="">-----</option>
                <option value="5" <?echo($response['Self_Efficacy_T']==5 ? "selected='selected'" : null);?>>Strongly Agree</option>
                <option value="4" <?echo($response['Self_Efficacy_T']==4 ? "selected='selected'" : null);?>>Agree</option>
                <option value="3" <?echo($response['Self_Efficacy_T']==3 ? "selected='selected'" : null);?>>Neither Agree nor Disagree</option>
                <option value="2" <?echo($response['Self_Efficacy_T']==2 ? "selected='selected'" :null);?>>Disagree</option>
				<option value="1" <?echo($response['Self_Efficacy_T']==1 ? "selected='selected'" : null);?>>Strongly Disagree</option>
            </select></td>
	</tr>
	<tr><td class="pm_survey question">W.	I will be able to successfully overcome many challenges.</td>
        <td class="pm_survey response"><select id="U">
                <option value="">-----</option>
                <option value="5" <?echo($response['Self_Efficacy_U']==5 ? "selected='selected'" : null);?>>Strongly Agree</option>
                <option value="4" <?echo($response['Self_Efficacy_U']==4 ? "selected='selected'" : null);?>>Agree</option>
                <option value="3" <?echo($response['Self_Efficacy_U']==3 ? "selected='selected'" : null);?>>Neither Agree nor Disagree</option>
                <option value="2" <?echo($response['Self_Efficacy_U']==2 ? "selected='selected'" :null);?>>Disagree</option>
				<option value="1" <?echo($response['Self_Efficacy_U']==1 ? "selected='selected'" : null);?>>Strongly Disagree</option>
            </select></td>
	</tr>
	<tr><td class="pm_survey question">X.	I am confident that I can perform effectively on many different tasks.</td>
        <td class="pm_survey response"><select id="V">
                <option value="">-----</option>
                <option value="5" <?echo($response['Self_Efficacy_V']==5 ? "selected='selected'" : null);?>>Strongly Agree</option>
                <option value="4" <?echo($response['Self_Efficacy_V']==4 ? "selected='selected'" : null);?>>Agree</option>
                <option value="3" <?echo($response['Self_Efficacy_V']==3 ? "selected='selected'" : null);?>>Neither Agree nor Disagree</option>
                <option value="2" <?echo($response['Self_Efficacy_V']==2 ? "selected='selected'" :null);?>>Disagree</option>
				<option value="1" <?echo($response['Self_Efficacy_V']==1 ? "selected='selected'" : null);?>>Strongly Disagree</option>
            </select></td>
	</tr>
	<tr><td class="pm_survey question">Y.	Compared to other people, I can do most tasks very well.</td>
        <td class="pm_survey response"><select id="W">
                <option value="">-----</option>
                <option value="5" <?echo($response['Self_Efficacy_W']==5 ? "selected='selected'" : null);?>>Strongly Agree</option>
                <option value="4" <?echo($response['Self_Efficacy_W']==4 ? "selected='selected'" : null);?>>Agree</option>
                <option value="3" <?echo($response['Self_Efficacy_W']==3 ? "selected='selected'" : null);?>>Neither Agree nor Disagree</option>
                <option value="2" <?echo($response['Self_Efficacy_W']==2 ? "selected='selected'" :null);?>>Disagree</option>
				<option value="1" <?echo($response['Self_Efficacy_W']==1 ? "selected='selected'" : null);?>>Strongly Disagree</option>
            </select></td>
	</tr>
	<tr><td class="pm_survey question">Z.	Even when things are tough, I can perform quite well.</td>
        <td class="pm_survey response"><select id="X">
                <option value="">-----</option>
                <option value="5" <?echo($response['Self_Efficacy_X']==5 ? "selected='selected'" : null);?>>Strongly Agree</option>
                <option value="4" <?echo($response['Self_Efficacy_X']==4 ? "selected='selected'" : null);?>>Agree</option>
                <option value="3" <?echo($response['Self_Efficacy_X']==3 ? "selected='selected'" : null);?>>Neither Agree nor Disagree</option>
                <option value="2" <?echo($response['Self_Efficacy_X']==2 ? "selected='selected'" :null);?>>Disagree</option>
				<option value="1" <?echo($response['Self_Efficacy_X']==1 ? "selected='selected'" : null);?>>Strongly Disagree</option>
            </select></td>
	</tr>
    <?
    /* Determines whether or not this is a new survey.  This value changes the 
     * queries in the ajax file (i.e. insert versus update).
     */
    if (!isset($_GET['survey'])) {
        $new_survey_status='1';
		$survey_id='';
    } else {
        $survey_id=$_GET['survey'];
                }?>
	
	<tr><th colspan="2"><input type="button" id="save_btn" value="Save Survey" onclick="
                    var participant = '<?echo $_COOKIE['participant'];?>';
        if (participant==''){
            var select_dropdown=document.getElementById('relative_search');
            if(select_dropdown != null){
               // alert('yes!');
                var participant = document.getElementById('relative_search').options[document.getElementById('relative_search').selectedIndex].value;
            }
            else{
                alert('Please choose a participant.');
                return false;
            }
            
        }
       //required field.
        var school= document.getElementById('new_school').value;
        if (school==''){
            alert('Please choose a school.');
            return false;
        }
       /* if (typeof survey_status=='undefined'){
        var survey_status='<?echo $new_survey_status;?>';}*/
        
        $('#save_btn').hide();
        $.post(
               '../ajax/save_new_survey.php',
               {
                   new_survey: <?echo $new_survey_status;?>,
                   survey_id: '<?echo $survey_id;?>',
                   participant: participant,
                   date: document.getElementById('new_survey_date').value,
                   school: document.getElementById('new_school').value,
                   grade:  document.getElementById('new_grade').value,
                   room: document.getElementById('room_number').value,
                   first_pm_year:  document.getElementById('first_year_pm').options[document.getElementById('first_year_pm').selectedIndex].value,
                   num_children: document.getElementById('num_children').options[document.getElementById('num_children').selectedIndex].value,
                   marital_status: document.getElementById('marital_status').options[document.getElementById('marital_status').selectedIndex].value,
                   place_birth: document.getElementById('place_birth').options[document.getElementById('place_birth').selectedIndex].value,
                   ethnicity: document.getElementById('ethnicity').options[document.getElementById('ethnicity').selectedIndex].value,
                   gender: document.getElementById('gender').options[document.getElementById('gender').selectedIndex].value,
                   language: document.getElementById('language').options[document.getElementById('language').selectedIndex].value,
                   years_in_il: document.getElementById('years_in_il').options[document.getElementById('years_in_il').selectedIndex].value,
                   education: document.getElementById('ed_completed').options[document.getElementById('ed_completed').selectedIndex].value,
                   current_classes: document.getElementById('current_classes').options[document.getElementById('current_classes').selectedIndex].value,
                   currently_working: document.getElementById('currently_working').options[document.getElementById('currently_working').selectedIndex].value,
                   current_job: document.getElementById('current_job').value,
                   monthly_income: document.getElementById('monthly_income').options[document.getElementById('monthly_income').selectedIndex].value,
                   food_stamps: document.getElementById('on_food_stamps').options[document.getElementById('on_food_stamps').selectedIndex].value,
                   rent_own: document.getElementById('rent_own').options[document.getElementById('rent_own').selectedIndex].value,
                   rent_payment: document.getElementById('rent_payment').options[document.getElementById('rent_payment').selectedIndex].value,
                   A: document.getElementById('A').options[document.getElementById('A').selectedIndex].value,
                   B: document.getElementById('B').options[document.getElementById('B').selectedIndex].value,
                   C: document.getElementById('C').options[document.getElementById('C').selectedIndex].value,
                   D: document.getElementById('D').options[document.getElementById('D').selectedIndex].value,
                   E: document.getElementById('E').options[document.getElementById('E').selectedIndex].value,
                   F: document.getElementById('F').options[document.getElementById('F').selectedIndex].value,
                   G: document.getElementById('G').options[document.getElementById('G').selectedIndex].value,
                   H: document.getElementById('H').options[document.getElementById('H').selectedIndex].value,
                   I: document.getElementById('I').options[document.getElementById('I').selectedIndex].value,
                   J: document.getElementById('J').options[document.getElementById('J').selectedIndex].value,
                   K: document.getElementById('K').options[document.getElementById('K').selectedIndex].value,
                   L: document.getElementById('L').options[document.getElementById('L').selectedIndex].value,
                   M: document.getElementById('M').options[document.getElementById('M').selectedIndex].value,
                   N: document.getElementById('N').options[document.getElementById('N').selectedIndex].value,
                   O: document.getElementById('O').options[document.getElementById('O').selectedIndex].value,
                   P: document.getElementById('P').options[document.getElementById('P').selectedIndex].value,
                   Q: document.getElementById('Q').options[document.getElementById('Q').selectedIndex].value,
                   R: document.getElementById('R').options[document.getElementById('R').selectedIndex].value,
				   Q1: document.getElementById('Q1').options[document.getElementById('Q1').selectedIndex].value,
                   R1: document.getElementById('R1').options[document.getElementById('R1').selectedIndex].value,
				   S: document.getElementById('S').options[document.getElementById('S').selectedIndex].value,
				   T: document.getElementById('T').options[document.getElementById('T').selectedIndex].value,
				   U: document.getElementById('U').options[document.getElementById('U').selectedIndex].value,
				   V: document.getElementById('V').options[document.getElementById('V').selectedIndex].value,
				   W: document.getElementById('W').options[document.getElementById('W').selectedIndex].value,
				   X: document.getElementById('X').options[document.getElementById('X').selectedIndex].value,
				   pre_post: document.getElementById('pre_post').options[document.getElementById('pre_post').selectedIndex].value
               },
               function (response){
                  // alert(response);
                   document.getElementById('show_survey_response').innerHTML = 
                       '<span style=color:#990000;font-weight:bold;font-size:.9em; padding-left: 25px;>Thank you for entering this survey!</span>';
               }
               ).fail(failAlert);
                   //survey_status='2';
                  // $('input[type=submit]', this).attr('disabled', 'disabled');
                "></th></tr>
</table>
<div id="show_survey_response"></div>
<br/><br/>
<?
include "../../footer.php";
?>