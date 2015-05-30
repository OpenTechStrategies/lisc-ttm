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
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id);

include "../header.php";
include "../bickerdike/header.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script>
	$(document).ready(function(){
			$("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});

		});
</script>

<div class="content_wide">

<h2>Welcome to the Humboldt Park Testing the Model Data Center!</h2>
<br/>
<table class="homescreen_table">
	<tr>
		<td width="50%">
<?php
    if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<a href="users/add_user.php" class="add_new " style="text-align:center;"><span class="add_new_button">Create New Participant</span></a><br/><br/>
<?php
    } //end access check
?>
				<h4>Search All Participants:</h4>
				<table class="search_table">
				    <tr><td class="all_projects"><strong>First Name:</strong></td>
        				<td class="all_projects"><input type="text" id="first_n"></td>
				        <td class="all_projects"><strong>Last Name:</strong></td>
        				<td class="all_projects"><input type="text" id="last_n"></td>
    				</tr>
    				<tr>
        				<td class="all_projects"><strong>Zipcode:</strong></td>
        				<td class="all_projects"><select id="zip">
                				<option value="">-----</option>
                				<?
                				$get_zips_sqlsafe = "SELECT Zipcode FROM Users WHERE Zipcode !=0 GROUP BY Zipcode";
                				include "include/dbconnopen.php";
                				$zips = mysqli_query($cnnBickerdike, $get_zips_sqlsafe);
                				while ($zip = mysqli_fetch_row($zips)){
                    				?>
                				<option value="<?echo $zip[0];?>"><?echo $zip[0];?></option>
                        				<?
                				}
                				include "include/dbconnclose.php";
                				?>
            				</select></td>
        				<td class="all_projects"><strong>Age:</strong></td>
        				<td class="all_projects"><select id="age">
                				<option value="">-----</option>
                				<option value="12">12-19</option>
                				<option value="20">20-34</option>
                				<option value="35">35-44</option>
                				<option value="45">45-59</option>
                				<option value="60">60 or over</option>
            				</select></td>
    				</tr>
    				<tr>
        				<td class="all_projects"><strong>Gender:</strong></td>
        				<td class="all_projects"><select id="user_gender">
                				<option value="">-----</option>
                				<option value="F">Female</option>
                				<option value="M">Male</option>
            				</select></td>
            				<td class="all_projects"><strong>Race/Ethnicity:</strong></td><td class="all_projects"><select id="user_race">
                				<option value="">-----</option>
                				<option value="b">African-American</option>
                				<option value="l">Latino</option>
                				<option value="a">Asian-American</option>
                				<option value="w">White</option>
                				<option value="o">Other</option>
            				</select></td>
    				</tr>
    				<tr><td class="all_projects">
            				<strong>Participant Type:</strong>
        				</td>
        				<td class="all_projects">
            				<select id="type">
                				<option value="">-----</option>
                				<option value="1">Adult</option>
                				<option value="2">Parent</option>
                				<option value="3">Youth</option>
            				</select>
        				</td>
						<td class="all_projects" colspan="2"></td>
    				</tr>
    				<tr>
        				<th colspan="4"><input type="button" value="Search" onclick="
                               $.post(
                                'ajax/search_users.php',
                                {
                                    first: document.getElementById('first_n').value,
                                    last: document.getElementById('last_n').value,
                                    zip: document.getElementById('zip').value,
                                    age: document.getElementById('age').value,
                                    gender: document.getElementById('user_gender').value,
                                    race: document.getElementById('user_race').value,
                                    type: document.getElementById('type').value
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_results').innerHTML = response;
                                }
                           ).fail(failAlert);"></th>
    				</tr>
				</table>

				<div id="show_results"></div>
		</td>
		<td >
<?php
                                                    if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<a href="activities/new_program.php"class="add_new "><span class="add_new_button">Create New Program</span></a><br/><br/>
<?php
                                                    } //end access check
?>
				<h4>Search All Programs:</h4>
				<table class="program_table">
 				   <tr><td class="all_projects"><strong>Program Name (or part of name):</strong></td>
     				   <td class="all_projects"><input type="text" id="name"></td></tr>
   				 <tr><td class="all_projects"><strong>Program Organization:</strong></td>
       				 <td class="all_projects"><select id="org">
         				       <option value="">-----</option>
				                <?
				                $program_query_sqlsafe = "SELECT * FROM Org_Partners";
				include "include/dbconnopen.php";
				$programs = mysqli_query($cnnBickerdike, $program_query_sqlsafe);
				while ($program = mysqli_fetch_array($programs)){
    				?>
        				<option value="<?echo $program['Partner_ID'];?>"><?
                                                echo $program['Partner_Name'];?></option>
        				<?
				}
				include "include/dbconnclose.php";
				                ?>
          				</select></td></tr>
   				 <tr><td class="all_projects"><strong>Program Type:</strong></td>
        				<td class="all_projects"><select id="program_type">
               				 <option value="">-----</option>
             				   <?
              				  $program_query_sqlsafe = "SELECT * FROM Program_Types";
								include "include/dbconnopen.php";
				$programs = mysqli_query($cnnBickerdike, $program_query_sqlsafe);
				while ($program = mysqli_fetch_array($programs)){
    				?>
        				<option value="<?echo $program['Program_Type_ID'];?>"><?echo $program['Program_Type_Name'];?></option>
      				  <?
				}
				include "include/dbconnclose.php";
                				?>
            				</select></td></tr>
    				<tr><th colspan="2"><input type="button" value="Search" onclick="
                               $.post(
                                'ajax/search_programs.php',
                                {
                                    name: document.getElementById('name').value,
                                    org: document.getElementById('org').value,
                                    type: document.getElementById('program_type').value
                                },
                                function (response){
                                    document.getElementById('show_program_results').innerHTML = response;
                                }
                           ).fail(failAlert);"></th></tr>
				</table><br/>
				<div id="show_program_results"></div>
		</td>
	</tr>
</table>

<br/><br/><br/>

</div>

<? include "../footer.php"; ?>