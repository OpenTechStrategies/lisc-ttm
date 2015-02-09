<?php
include "../../header.php";
include "../header.php";
?>
<script type="text/javascript">
        $(document).ready(function() {
            $('#show_campaign_checkboxes').hide();
            $('#show_program_checkboxes').hide();
            $('#show_event_checkboxes').hide();
            $('#program_select_all').click(function () {
                $('.program_checkbox').prop('checked', this.checked);
            });
            $('#campaign_select_all').click(function () {
                $('.campaign_checkbox').prop('checked', this.checked);
            });
            $('#event_select_all').click(function () {
                $('.event_checkbox').prop('checked', this.checked);
            });
        });
</script>
<!--Query search for participants, modeled on SWOP's query report. -->
<h4>Search All Participants</h4>
<table class="search_table">
	<tr>
            <!--Search terms: -->
		<td class="all_projects"><strong>First Name: </strong></td>
		<td class="all_projects"><input type="text" id="first_name" /></td>
		<td class="all_projects"><strong>Role: </strong></td>
		<td class="all_projects"><select id="role">
				<option value="">--------</option>
				<?php
					$get_roles = "SELECT * FROM Roles";
					include "../include/dbconnopen.php";
					$roles = mysqli_query($cnnLSNA, $get_roles);
					while ($role = mysqli_fetch_array($roles)) {
					?>
						<option value="<? echo $role['Role_ID']; ?>"><? echo $role['Role_Title']; ?></option>
					<?php
                                        
                                        }
					include "../include/dbconnclose.php";
				?>
			</select>
		</td>
	</tr>
        
	<tr>
		<td class="all_projects"><strong>Last Name: </strong></td>
		<td class="all_projects"><input type="text" id="last_name" /></td>
		<td class="all_projects"><strong>Gender: </strong></td>
		<td class="all_projects"><select id="gender">
				<option value="">--------</option>
				<option value="m">Male</option>
				<option value="f">Female</option>
			</select>
		</td>
	</tr>
        <tr>
            <td class="all_projects"><strong>Language:</strong></td>
            <td class="all_projects"><select id="language_search">
				<option value="">--------</option>
				<?php
					$get_roles = "SELECT * FROM Languages";
					include "../include/dbconnopen.php";
					$roles = mysqli_query($cnnLSNA, $get_roles);
					while ($role = mysqli_fetch_array($roles)) {
					?>
						<option value="<? echo $role['Language_ID']; ?>"><? echo $role['Language']; ?></option>
					<?php }
					include "../include/dbconnclose.php";
				?></select></td>
            <td class="all_projects"><strong>Zipcode:</strong></td>
            <td class="all_projects"><select id="zipcode_search">
				<option value="">--------</option>
				<?php
					$get_roles = "SELECT DISTINCT Address_Zip FROM Participants ORDER BY Address_Zip;";
					include "../include/dbconnopen.php";
					$roles = mysqli_query($cnnLSNA, $get_roles);
					while ($role = mysqli_fetch_row($roles)) {
					?>
						<option value="<? echo $role[0]; ?>"><? echo $role[0]; ?></option>
					<?php }
					include "../include/dbconnclose.php";
				?></select></td>
        </tr>
        <tr>
            <td class="all_projects"><strong>Ward:</strong></td>
            <td class="all_projects"><select id="ward_search">
				<option value="">--------</option>
				<?php
					$get_roles = "SELECT DISTINCT Ward FROM Participants ORDER BY Ward;";
					include "../include/dbconnopen.php";
					$roles = mysqli_query($cnnLSNA, $get_roles);
					while ($role = mysqli_fetch_row($roles)) {
					?>
						<option value="<? echo $role[0]; ?>"><? echo $role[0]; ?></option>
					<?php }
					include "../include/dbconnclose.php";
				?></select></td>
            <td class="all_projects"><strong></strong></td>
            <td class="all_projects"></td>
        </tr>
        <tr>
            <td class="all_projects"><strong>Phone:</strong><br><span class="helptext">This works best if you enter only digits.</span></td>
            <td class="all_projects"><input type="text" id="phone_search"></td>
            <td class="all_projects"><strong>Parent Mentor School:</strong></td>
            <td class="all_projects"><select id="school_search"><option value="">------</option>
    <?php
    $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1' ORDER BY Institution_Name";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnLSNA, $get_schools);
    while ($program = mysqli_fetch_array($programs)){
        ?>
    <option value="<?php echo $program['Institution_ID'];?>"><?php echo $program['Institution_Name'];?></option>
            <?php
    }
    include "../include/dbconnclose.php";
    ?>
    
</select></td>
        </tr>
	<tr>
		<td class="all_projects"><strong>Date of Birth: </strong></td>
		<td class="all_projects"><input type="text" id="dob" class="hadDatepicker" /></td>
		<td class="all_projects"><strong>Grade Level: </strong></td>
		<td class="all_projects"><select id="grade">
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
            <td class="all_projects"><strong>Program Involved In:</strong></td>
            <td class="all_projects">
    <?php
    $get_schools = "SELECT * FROM Subcategories WHERE Campaign_or_Program='Program' ORDER BY Subcategory_Name";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnLSNA, $get_schools);
?>
<a href="javascript:;" onclick = "$('#show_program_checkboxes').toggle();">Show programs</a>
<table id = "show_program_checkboxes">
<tr>
<td>
<label for="program_list">Select all:</label>
</td>
<td>
<input type="checkbox"  id="program_select_all"  />
</td>
</tr>
<?php
    while ($program = mysqli_fetch_array($programs)){
        ?>
<tr>
<td>
<label for="program_list"><?php echo $program['Subcategory_Name'];?>:</label>
</td>
<td>
<input type="checkbox" name = "programs[]"  id="program_list" class = "program_checkbox" value="<?php echo $program['Subcategory_ID'];?>" />
</td>
</tr>
<?php
}
?>
</table>
</td>
            <td class="all_projects"><strong>Campaign Involved In:</strong></td>
            <td class="all_projects">
<a href="javascript:;" onclick = "$('#show_campaign_checkboxes').toggle();">Show campaigns</a>
<table id = "show_campaign_checkboxes">
<tr>
<td>
<label for="campaign_list">Select all:</label>
</td>
<td>
<input type="checkbox"  id="campaign_select_all"  />
</td>
</tr>
    <?php
    $get_schools = "SELECT * FROM Subcategories WHERE Campaign_or_Program='Campaign' ORDER BY Subcategory_Name";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnLSNA, $get_schools);
    while ($program = mysqli_fetch_array($programs)){
?>
<tr>
<td>
<label for="campaign_list"><?php echo $program['Subcategory_Name'];?>:</label>
</td>
<td>
<input type="checkbox" name = "campaigns[]"  id="campaign_list" class = "campaign_checkbox" value="<?php echo $program['Subcategory_ID'];?>" />
</td>
</tr>
<?php
}
?>
</table>
</td>
        </tr>
        <tr>
            <td class="all_projects"><strong>Affiliated Institution:</strong></td>
            <td class="all_projects"><select id="inst_search"><option value="">------</option>
    <?php
    $get_schools = "SELECT * FROM Institutions ORDER BY Institution_Name";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnLSNA, $get_schools);
    while ($program = mysqli_fetch_array($programs)){
        ?>
    <option value="<?php echo $program['Institution_ID'];?>"><?php echo $program['Institution_Name'];?></option>
            <?php
    }
    include "../include/dbconnclose.php";
    ?>
</td>
            <td class="all_projects"><strong>Event Attended:</strong></td>
            <td class="all_projects">
    <?php
    $get_schools = "SELECT * FROM Subcategory_Dates INNER JOIN Subcategories ON Subcategory_Dates.Subcategory_ID=
Subcategories.Subcategory_ID
WHERE Subcategories.Campaign_or_Program='Campaign';";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnLSNA, $get_schools);
?>
<a href="javascript:;" onclick = "$('#show_event_checkboxes').toggle();">Show events</a>
<table id = "show_event_checkboxes">
<tr>
<td>
<label for="event_list">Select all:</label>
</td>
<td>
<input type="checkbox"  id="event_select_all"  />
</td>
</tr>
<?php
    while ($program = mysqli_fetch_array($programs)){
        ?>
<tr>
<td>
<label for="event_list"><?php echo $program['Date'] . ": " . $program['Activity_Name'] . " (" .
$program['Subcategory_Name'] . ")";?></label>
</td>
<td>
<input type="checkbox" name = "events[]"  id="event_list" class = "event_checkbox" value="<?php echo $program['Subcategory_ID'];?>" />
</td>
</tr>
            <?php
    }
    include "../include/dbconnclose.php";
    ?>
    </table>
</td>
        </tr>
        <tr><td class="all_projects"><strong>Is Parent Mentor:</strong></td><td class="all_projects"><select id="pm_check"><option value="">-----</option>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                </select></td>
                <td  class="all_projects"><strong>Parent Mentor Year:</strong>
                <!-- If this is chosen, then only parent mentors will be returned (is equivalent to choosing "Is Parent Mentor  - yes" and a year from
                this dropdown). --></td>
                <td class="all_projects"><select id="search_year"><option value="">------</option>
    
    <option value="1011">2010-11</option>
    <option value="1112">2011-12</option>
    <option value="1213">2012-13</option>
    <option value="1314">2013-14</option>
    <option value="1415">2014-15</option>
    <option value="1516">2015-16</option>
    <option value="1617">2016-17</option>
</select></td>
        </tr>
        <tr><td class="all_projects"><strong>2013-2014 Consent On File?</strong></td>
            <td class="all_projects">
                <select id="consent_2013_14">
                    <option value="">-----</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
            <td class="all_projects"><strong>2014-2015 Consent On File?</strong></td>
            <td class="all_projects">
                <select id="consent_2014_15">
                    <option value="">-----</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
        </tr>
        <tr><td class="all_projects"><strong>2015-2016 Consent On File?</strong></td>
            <td class="all_projects">
                <select id="consent_2015_16">
                    <option value="">-----</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
            <td class="all_projects">
                <!--
                <strong>2014-2015 Consent On File?</strong></td>
            <td class="all_projects">
                <select id="consent_2014_15">
                    <option value="">-----</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                -->
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <h4>Information To Include:</h4>
                <table style="text-align: right;">
                    <tr>
                        <td>
                            <label for="include_address">Address:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_address" />
                        </td>
                        <td>
                            <label for="include_ward">Ward:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_ward" />
                        </td>
                        <td>
                            <label for="include_daytime_phone">Daytime Phone:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_daytime_phone" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="include_evening_phone">Evening Phone:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_evening_phone" />
                        </td>
                        <td>
                            <label for="include_languages_spoken">Languages Spoken:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_languages_spoken" />
                        </td>
                        <td>
                            <label for="include_email">E-mail Address:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_email" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
		<td class="all_projects" colspan="4">
			<input type="button" value="Search" onclick="
                            if (document.getElementById('include_address').checked==true){ var include_address=1; } else{ var include_address=0;}
                            if (document.getElementById('include_ward').checked==true){ var include_ward=1; } else{ var include_ward=0;}
                            if (document.getElementById('include_daytime_phone').checked==true){ var include_daytime_phone=1; } else{ var include_daytime_phone=0;}
                            if (document.getElementById('include_evening_phone').checked==true){ var include_evening_phone=1; } else{ var include_evening_phone=0;}
                            if (document.getElementById('include_languages_spoken').checked==true){ var include_languages_spoken=1; } else{ var include_languages_spoken=0;}
                            if (document.getElementById('include_email').checked==true){ var include_email=1; } else{ var include_email=0;}
var programs = document.getElementsByName('programs[]');
var program_array = new Array();
var program_array_key = 0;
for (var k = 0; k < programs.length; k++) {
    if (programs[k].checked == true) {
        program_array[program_array_key] = programs[k].value;
        program_array_key++;
    }
}
var campaigns = document.getElementsByName('campaigns[]');
var campaign_array = new Array();
var campaign_array_key = 0;
for (var k = 0; k < campaigns.length; k++) {
if (campaigns[k].checked == true) {
campaign_array[campaign_array_key] = campaigns[k].value;
campaign_array_key++;
}
}
var events = document.getElementsByName('events[]');
var event_array = new Array();
var event_array_key = 0;
for (var k = 0; k < events.length; k++) {
if (events[k].checked == true) {
event_array[event_array_key] = events[k].value;
event_array_key++;
}
}
                          $.post(
                                '/lsna/reports/individual_search.php',
                                {
                                    first: document.getElementById('first_name').value,
                                    role: document.getElementById('role').options[document.getElementById('role').selectedIndex].value,
                                    last: document.getElementById('last_name').value,
                                    gender: document.getElementById('gender').options[document.getElementById('gender').selectedIndex].value,
                                    language: document.getElementById('language_search').value,
                                    zip:  document.getElementById('zipcode_search').value,
                                    ward:  document.getElementById('ward_search').value,
                                    phone:  document.getElementById('phone_search').value,
                                    school: document.getElementById('school_search').value,
                                    dob: document.getElementById('dob').value,
                                    grade: document.getElementById('grade').value,
                                    program: program_array,
                                    campaign: campaign_array,
                                    institution: document.getElementById('inst_search').value,
                                    event: event_array,
                                    pm: document.getElementById('pm_check').value,
                                    year: document.getElementById('search_year').value,
                                    consent_2013_14: document.getElementById('consent_2013_14').value,
                                    consent_2014_15: document.getElementById('consent_2014_15').value,
                                    consent_2015_16: document.getElementById('consent_2015_16').value,
                                    include_address: include_address,
                                    include_ward: include_ward,
                                    include_daytime_phone: include_daytime_phone,
                                    include_evening_phone: include_evening_phone,
                                    include_languages_spoken: include_languages_spoken,
                                    include_email: include_email
                                },
                                function (response){
                                    document.getElementById('show_results').innerHTML = response;
                                }
                                );
                     "/>
		</td>
	</tr>
</table>
<div id="show_results"></div>
<br><br/><br/>

<?php include "../../footer.php";?>