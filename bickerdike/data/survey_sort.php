<?php
include "../../header.php";
include "../header.php";
?>


<h4>Search All Surveys</h4>
<table class="search_table">
	<tr>
		
		<td class="all_projects"><strong>Survey Timing: </strong>
                </td>
		<td class="all_projects"><select id="pre_post">
				<option value="">--------</option>
                                <option value="1">Pre</option>
                                <option value="2">Post</option>
                                <option value="3">Followup</option>
			</select>
		</td>
                <td class="all_projects"></td>
                <td class="all_projects"></td>
	</tr>
        <tr>
		<td class="all_projects"><strong>Participant Type: </strong><br>
                    </td>
		<td class="all_projects"><select id="person_type">
                        <option value="">-----</option>
                        <option value="parent">Parent</option>
                        <option value="adult">Adult</option>
                        <option value="youth">Youth</option>
                    </select></td>
		<td class="all_projects"><strong>Program: </strong><br>
                    <span class="helptext">(Satisfaction Surveys Only)</span>
                <!--The other surveys are only for the parent mentor program, so this is irrelevant for them -->
                </td>
		<td class="all_projects"><select id="program">
				<option value="">--------</option>
                                <?
                                //get all programs with related surveys
                                $get_progs_sqlsafe="SELECT DISTINCT Participant_Survey_Responses.Program_ID, Program_Name FROM Participant_Survey_Responses LEFT JOIN
                                    Programs ON Participant_Survey_Responses.Program_ID=Programs.Program_ID
                                    ORDER BY Program_Name;";
                                include "../include/dbconnopen.php";
                                $roles = mysqli_query($cnnBickerdike, $get_progs_sqlsafe);
					while ($role = mysqli_fetch_row($roles)) {
					?>
						<option value="<? echo $role[0]; ?>"><?echo $role[1]; ?></option>
					<?}
                                include "../include/dbconnclose.php";
                                ?>
			</select>
		</td>
	</tr>
        <tr>
		<td class="all_projects"><strong>Year: </strong></td>
		<td class="all_projects"><select id="year">
                        <option value="">-----</option>
                        <option value="2011">2011</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                    </select></td>
                    <td class="all_projects"></td>
                    <td class="all_projects"></td>
	</tr>
        <tr><td colspan="4" class="all_projects"><input type="button" value="Search" onclick="
                                   $.post(
                                    '../ajax/survey_search.php',
                                    {
                                        time: document.getElementById('pre_post').value,
                                        type: document.getElementById('person_type').value,
                                        program: document.getElementById('program').value,
                                        year: document.getElementById('year').value
                                    },
                                    function (response){
                                        document.getElementById('survey_response').innerHTML=response;
                                    }
                               )"></td></tr>
        </table>

<p></p>
<div id="survey_response"></div>
<?


include "../../footer.php";
?>
