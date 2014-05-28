<?php
include "../../header.php";
include "../header.php";
?>

<!--Search surveys. This returns the raw responses to the types of surveys sought. -->

<h4>Search All Surveys</h4>
<table class="search_table">
	<tr>
		<td class="all_projects"><strong>Survey Type: </strong>
                <!--This must be chosen, because it tells the query what table to pull from. --></td>
		<td class="all_projects"><select id="survey">
                        <option value="">-----</option>
                        <option value="1">Satisfaction Surveys</option>
                        <option value="2">Teacher Survey</option>
                        <option value="3">Parent Mentor Survey</option>
                    </select></td>
		<td class="all_projects"><strong>Survey Timing: </strong>
                <!--especially important for teacher surveys, which have different text for pre and post.
                Irrelevant for satisfaction surveys.  Teachers have no mid-surveys. --></td>
		<td class="all_projects"><select id="pre_post">
				<option value="">--------</option>
                                <option value="1">Pre</option>
                                <option value="2">Mid</option>
                                <option value="3">Post</option>
			</select>
		</td>
	</tr>
        <tr>
		<td class="all_projects"><strong>Grade Level: </strong><br>
                    <span class="helptext">(Satisfaction Surveys Only)</span>
                <!--Irrelevant to non-satisfaction surveys.--></td>
		<td class="all_projects"><select id="grade">
                        <option value="">-----</option>
                        <option value="3">3rd grade and younger</option>
                        <option value="4">4th grade and older</option>
                    </select></td>
		<td class="all_projects"><strong>Program: </strong><br>
                    <span class="helptext">(Satisfaction Surveys Only)</span>
                <!--The other surveys are only for the parent mentor program, so this is irrelevant for them -->
                </td>
		<td class="all_projects"><select id="program">
				<option value="">--------</option>
                                <?
                                //get all programs with entered Satisfaction surveys
                                $get_progs="SELECT DISTINCT Program_ID, Subcategory_Name FROM Satisfaction_Surveys LEFT JOIN
                                    Subcategories ON Program_ID=Subcategory_ID;";
                                echo $get_progs;
                                include "../include/dbconnopen.php";
                                $roles = mysqli_query($cnnLSNA, $get_progs);
					while ($role = mysqli_fetch_row($roles)) {
					?>
						<option value="<? echo $role[0]; ?>"><? echo $role[0] . ": " .$role[1]; ?></option>
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
		<td class="all_projects"><strong>School: </strong><br>
                    <span class="helptext">(Not for Satisfaction Surveys)</span></td>
		<td class="all_projects"><select id="school">
				<option value="">--------</option>
                                <?
                                //get all schools in system, regardless of their use in surveys
                                $get_progs="SELECT Institution_ID, Institution_Name FROM Institutions WHERE Institution_Type=1";
                                echo $get_progs;
                                include "../include/dbconnopen.php";
                                $roles = mysqli_query($cnnLSNA, $get_progs);
					while ($role = mysqli_fetch_row($roles)) {
					?>
						<option value="<? echo $role[0]; ?>"><? echo $role[0] . ": " .$role[1]; ?></option>
					<?}
                                include "../include/dbconnclose.php";
                                ?>
			</select>
		</td>
	</tr>
        <tr><td colspan="4" class="all_projects"><input type="button" value="Search" onclick="
                                   $.post(
                                    'survey_search.php',
                                    {
                                        type: document.getElementById('survey').value,
                                        time: document.getElementById('pre_post').value,
                                        grade: document.getElementById('grade').value,
                                        program: document.getElementById('program').value,
                                        year: document.getElementById('year').value,
                                        school: document.getElementById('school').value
                                    },
                                    function (response){
                                        document.getElementById('survey_response').innerHTML=response;
                                    }
                               )"></td></tr>
        </table>

<p></p>
<div id="survey_response"></div>


<?include "../../footer.php";?>