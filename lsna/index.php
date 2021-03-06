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

user_enforce_has_access($LSNA_id);

include "../header.php";
include "header.php";
include "include/datepicker.php";
?>
<div class="content">
<h2 id="lsna_welcome">Welcome to the Logan Square Testing the Model Data Center!</h2><hr/><br/>
<div style="text-align:center;">
    <!-- Count all people included in the system. -->
	<?php
		$get_participants = "SELECT * FROM Participants";
		include "include/dbconnopen.php";
		$participants = mysqli_query($cnnLSNA, $get_participants);
		$num_participants = mysqli_num_rows($participants);
		include "include/dbconnclose.php";
	?>
	There are currently <strong><?php echo $num_participants;?></strong> participants in the system.
</div>
<br/><br/>
<!--Link to quickly add a new campaign event.-->
<?php
                     if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<h4 >Quick Add New Campaign Event</h4>
<table style="margin-left:auto;margin-right:auto;font-size:.9em;" >
	<tr>
		<td><strong>Event Name: </strong></td>
		<td><input type="text" id="new_event_name" /></td>
	</tr>
	<tr>
		<td><strong>Campaign: </strong></td>
		<td>
			<select id="new_event_campaign">
				<option value="">----------</option>
			<?php
				$get_campaigns = "SELECT * FROM Subcategories WHERE Campaign_or_Program='Campaign' ORDER BY Subcategory_Name";
				include "include/dbconnopen.php";
				$campaigns = mysqli_query($cnnLSNA, $get_campaigns);
				while ($campaign = mysqli_fetch_array($campaigns)) {
			?>
				<option value="<?php echo $campaign['Subcategory_ID'];?>"><?php echo $campaign['Subcategory_Name'];?></option>
			<?php
				}
				include "include/dbconnclose.php";
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><strong>Date: </strong></td>
		<td><input type="text" id="new_event_date" class="hadDatepicker" /></td>
	</tr>
	<tr>
		<td><strong>Event Type: </strong></td>
		<td>
			<select id="new_event_type">
                        <option value="">-----</option>
                        <option value="1">Leadership Meeting</option>
                        <option value="2">Board Meeting</option>
                        <option value="3">Rally/March</option>
                        <option value="4">Press Conference</option>
                        <option value="5">Doorknocking</option>
                        <option value="6">Aldermanic Meeting</option>
                        <option value="7">City Council Meeting</option>
                        <option value="8">Legislative Meeting</option>
                        <option value="9">Petitions/Postcards</option>
                        <option value="10">Other</option>
            </select></td>
	</tr>
	<tr>
		<td colspan="2"><input type="button" value="Save" onclick="
                    var campaign_id=document.getElementById('new_event_campaign').value;
                    if (campaign_id==''){
                        alert('Please choose a campaign.');
                        return false;
                    }
                    
		$.post(
            'ajax/program_duplicate_check.php',
            {
                date: document.getElementById('new_event_date').value,
                subcategory: document.getElementById('new_event_campaign').value
            },
            function (response){
                /*check to make sure that the campaign doesn't already have an event with this name/date.*/
                if (response != ''){
                    var deduplicate = confirm(response);
                    if (deduplicate){
                        $.post(
                            'ajax/add_new_program_date.php',
			{
				quick_add: '1',
				program_id: document.getElementById('new_event_campaign').value,
				date: document.getElementById('new_event_date').value,
                name: document.getElementById('new_event_name').value,
                type: document.getElementById('new_event_type').options[document.getElementById('new_event_type').selectedIndex].value
			},
			function (response){
				document.getElementById('confirmation').innerHTML = response;
			}
                        );
                        }
                }
                else{
                    $.post(
                            'ajax/add_new_program_date.php',
			{
				quick_add: '1',
				program_id: document.getElementById('new_event_campaign').value,
				date: document.getElementById('new_event_date').value,
                name: document.getElementById('new_event_name').value,
                type: document.getElementById('new_event_type').options[document.getElementById('new_event_type').selectedIndex].value
			},
			function (response){
				document.getElementById('confirmation').innerHTML = response;
			}
                        );
                }
            }
          );
            " />
			<div id="confirmation"></div>
			</td>
	</tr>
</table>
<?php
                     } //end access check
?>

<br/><br/>
</div>

<?php include "../footer.php"; ?>