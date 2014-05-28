<?
	include "../../header.php";
	include "../header.php";
	include "../include/datepicker_wtw.php";
?>

<!--
Page that shows Little Village events that aren't connected to a campaign.
-->

<script type="text/javascript">
	$(document).ready(function() {
		$('#events_selector').addClass('selected');
		$('#ajax_loader').hide();
		$('#add_new').hide();
		$('#add_date').hide();
		$('#add_participant_button').hide();
                $('.hide_old_events').hide();
	<?
	if (isset ($_GET['event'])) {
?>
		$('#event_<?echo $_GET['event'];?>_details').show();
<?
	}
?>
	});
	
	$(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });
            
    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<div class="content_block">
<h3>Little Village Events</h3><hr/><br/>
<table class="profile_table">
	<tr>
            
            <!--Add new event here. -->
            
	<td><h4>Add Event</h4>
		<table class="inner_table">
			<tr><td style="vertical-align:middle;"><strong>Event Name: </strong></td><td><input type="text" id="new_event" ></td></tr>
			<tr><td style="vertical-align:middle;"><strong>Date: </strong></td><td><input class="addDP" id="new_date" type="text" /></td></tr>
			<tr><td style="vertical-align:middle;"><strong>Address: </strong></td><td><input id="st_num_new" style="width:40px;"/> 
									<input id="st_dir_new" style="width:20px;"/> 
									<input id="st_name_new"  style="width:100px;"/> 
        							<input id="st_type_new" style="width:35px;"/></td></tr>
			<tr><td style="vertical-align:middle;"><strong>Type: </strong></td><td><select id="new_event_type">
    <option value="">-----</option>
    <?
    $all_events="SELECT * FROM Event_Types ORDER BY Type";
    include "../include/dbconnopen.php";
    $events=mysqli_query($cnnEnlace, $all_events);
    while ($type=mysqli_fetch_row($events)){
        ?><option value="<?echo $type[0]?>"><?echo $type[1];?></option><?
    }
    include "../include/dbconnclose.php";
    ?>
<!--    <option value="1">Leadership Meeting</option>
    <option value="2">Board Meeting</option>
    <option value="3">Rally/March</option>
    <option value="4">Press Conference</option>
    <option value="5">Doorknocking</option>
    <option value="6">Aldermanic Meeting</option>
    <option value="7">City Council Meeting</option>
    <option value="8">Legislative Meeting</option>
    <option value="11">Meeting/Assembly</option>
    <option value="9">Petitions/Postcards</option>
    <option value="12">Working Group</option>
    <option value="10">Other</option>-->
</select></td></tr>
			<tr><td colspan="2"><input type="button" value="Save" onclick="$.post(
                '../ajax/add_event.php',
                {
                    campaign_id: '0',
                    date: document.getElementById('new_date').value,
                    event_name: document.getElementById('new_event').value,
                    address_num: document.getElementById('st_num_new').value,
                    address_dir: document.getElementById('st_dir_new').value,
                    address_street: document.getElementById('st_name_new').value,
                    address_suffix: document.getElementById('st_type_new').value,
                    event_type: document.getElementById('new_event_type').value
                },
                function (response){
                    //document.write(response);
                    window.location='events.php';
                }
            );">&nbsp;&nbsp;&nbsp;<span class="helptext">Dates must be entered in the format YYYY-MM-DD.</span></td></tr>
		</table>
	</td>
	<td>
            
            <!--List of already added events.-->
            
	<ul id="events_list">
<?
	$get_events = "SELECT * FROM Campaigns_Events WHERE Campaign_ID='0' ORDER BY Event_Date DESC";
	include "../include/dbconnopen.php";
	$events = mysqli_query($cnnEnlace, $get_events);
        $count_events=0;
	while ($event = mysqli_fetch_array($events)) {
            $count_events++;
	$date_formatted = explode('-', $event['Event_Date']);
	$date = $date_formatted[1]."/".$date_formatted[2]."/".$date_formatted[0];
?>
            <!--
            Hide the older events - shows only the five most recent.
            -->
            
	<li <?if ($count_events>5){echo 'class="hide_old_events"';}?>><h4 onclick="$('#event_<?echo $event['Campaign_Event_ID'];?>_details').slideToggle();"><?echo $date." - ".$event['Event_Name'];?></h4>
		<div class="event_info" style="display:none;" id="event_<?echo $event['Campaign_Event_ID'];?>_details">
			<table class="inner_table">
				<tr><td><strong>Date: </strong></td><td><?echo $date;?></td></tr>
				<tr><td><strong>Address: </strong></td><td><?echo $event['Address_Num']." ".$event['Address_Dir']." ".$event['Address_Street']." ".$event['Address_Suffix'];?></td></tr>
				<tr><td><strong>Type: </strong></td><td></td>
				<tr><td class="blank"><strong>Attendance: </strong></td>
					<td class="blank">
						<?
							$get_attendance = "SELECT * FROM Participants_Events INNER JOIN Participants ON Participants_Events.Participant_ID=Participants.Participant_ID WHERE Participants_Events.Event_ID='".$event['Campaign_Event_ID']."' ORDER BY Participants.Last_Name";
							$attendance = mysqli_query($cnnEnlace, $get_attendance);
							while ($attendee = mysqli_fetch_array($attendance)) {
						?>
							<a href="../participants/participant_profile.php?id=<?echo $attendee['Participant_ID'];?>"><?echo $attendee['First_Name']." ".$attendee['Last_Name'];?></a><br/>
						<?
							}
						?>
						<br/>
                                                
                                                <!--Search the database for attendees here: -->
                                                
						<a href="javascript:;" onclick="$('#add_attendance_<?echo $event['Campaign_Event_ID'];?>').toggle();" class="helptext">Add attendee...</a>
						<div style="display:none;" id="add_attendance_<?echo $event['Campaign_Event_ID'];?>">
						<table class="inner_table" id="search_parti_table" style="font-size:.9em;">
				<tr>
					<td><strong>First Name: </strong></td>
					<td><input type="text" id="first_name_search" style="width:125px;"/></td>
					<td><strong>Last Name: </strong></td>
					<td><input type="text" id="last_name_search" style="width:125px;" /></td>
				</tr>
				<tr>
					<td><strong>Date of Birth: </strong></td>
					<td><input type="text" id="dob_search" class="addDP" /></td>
<!--					<td><strong>Grade Level: </strong></td>
					<td><select id="grade_search">
							<option value="">--------</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
						</select>
					</td>-->
				</tr>
				<tr>
					<td colspan="4" style="text-align:center;" class="blank">
						<input type="button" value="Search" onclick="
     			                       $('#add_participant_button').show();
									   $.post(
          			                      '/enlace/ajax/search_participants.php',
         			                       {
                                                         result: 'dropdown',
         			                         first: document.getElementById('first_name_search').value,
         			                         last: document.getElementById('last_name_search').value,
          			                         dob: document.getElementById('dob_search').value
           			                         //grade: document.getElementById('grade_search').value
            			                    },
             			                   function (response){
               			                     document.getElementById('show_results').innerHTML = response;
               			                 });"/><div id="show_results"></div>
						<input type="button" value="Add Participant" onclick="$.post(
									'../ajax/add_participant.php',
									{
										action: 'link_event',
										participant: document.getElementById('relative_search').value,
										event: '<?echo $event['Campaign_Event_ID'];?>'
									},
									function (response){
										//document.write(response);
										window.location='events.php?event=<?echo $event['Campaign_Event_ID'];?>';
									}
								)" id="add_participant_button" />
					</td>
				</tr>
			</table>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</li>
<?
	}
	include "../include/dbconnclose.php";
?>
	</ul>
            <a href="javascript:;" onclick="$('.hide_old_events').toggle();">Show older events.</a>
	</td>
	</tr>
</table>


</div>
<br/><br/>
<?
	include "../../footer.php";
?>