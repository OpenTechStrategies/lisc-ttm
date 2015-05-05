<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id);

	include "../../header.php";
	include "../header.php";
        include "../include/datepicker_simple.php";
        /* homepage for community events and outcomes.  general Pilsen-wide measures. */
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#engagement_selector').addClass('selected');
		$('#engagement_home').show();
		$('#new_trp_event').hide();
		$('#trp_event_details').hide();
		$('#outcomes').hide();
		$('.outcomes_data').hide();
		$('.event_info').hide();
		$('.edit').hide();
		$('.add_attendee').hide();
                $('.inactive_events').hide();
		<?
	if (isset ($_GET['event'])) {
            /* not sure that this is still relevant: */
?>
		$('#event_<?echo $_GET['event'];?>_details').show();
<?
	}
?>
		$("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});
	});
</script>

<h3>Community Engagement</h3><hr/><br/>
	
<div class="trp_content_block" id="engagement_home">    <!-- Community Engagement Home -->
	<table id="engagement_summary_table">
		<tr>
                    <!-- List of events that are not affiliated with a specific campaign: -->
			<td width="60%"><h2>TRP Events</h2><br/>
                            <!-- add a noncampaign event: -->
<?php
if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>
				<div style="text-align:center;font-size:.9em;"><a class="add_new" onclick="
							$('#engagement_home').hide();
							$('#new_trp_event').show();
							$('#trp_event_details').hide();
							$('#outcomes').hide();
						"><span class="add_new_button">Add New Event</span></a></div>
<?php
} // end access level check
?>				
				<ul id="events_list">
                                    <!-- list of active events.  Events are set as active or inactive by users.  So, all events could be
                                    active or inactive at the same time: -->
				<?
					include "../include/dbconnopen.php";
					$events_query_sqlsafe = "SELECT * FROM Events  WHERE Active=1 ORDER BY Event_Date DESC";
					$events = mysqli_query($cnnTRP, $events_query_sqlsafe);
					while ($event = mysqli_fetch_array($events)) {
					$date_formatted = explode('-', $event['Event_Date']);
					$display_date = $date_formatted[1]."/".$date_formatted[2]."/".$date_formatted[0];
				?>
					<li><h4 onclick="
							$('#event_<?echo $event['Event_ID'];?>_details').slideToggle();
						"><?echo $display_date." - ".$event['Event_Name'];?></h4>
						<div class="event_info" id="event_<?echo $event['Event_ID'];?>_details">
						<table width="100%">
							<tr>
                                                            <!-- basic information about this event: -->
								<td width="30%"><strong>Date:</strong></td>
								<td><span class="display event_<?echo $event['Event_ID'];?>_display"><?echo $display_date;?></span>
									<input class="edit event_<?echo $event['Event_ID'];?>_edit" id="<?echo $event['Event_ID'];?>_edit_date" value="<?echo $display_date;?>" style="width:70px;"/>
								</td>
                                                                <!-- link specific people to this event (if desired) -->
								<td rowspan="3"><h5>Attendee List</h5>
									<?
										$event_attendance_sqlsafe = "SELECT * FROM Participants INNER JOIN Events_Participants ON Participants.Participant_ID=Events_Participants.Participant_ID WHERE Events_Participants.Event_ID='" . $event['Event_ID'] . "' ORDER BY Participants.Last_Name";
										$attendees = mysqli_query($cnnTRP, $event_attendance_sqlsafe);
										while ($attendee = mysqli_fetch_array($attendees)) {
									?>
										<a href="../participants/profile.php?id=<?echo $attendee['Participant_ID'];?>" style="font-size:.9em;margin-left:10px;"><?echo $attendee['First_Name'] . " " . $attendee['Last_Name'];?></a><br/>
									<?									
										}
									?>
								</td>
							</tr>
							<tr>
								<td><strong>Goal Attendance:</strong></td>
								<td><span class="display event_<?echo $event['Event_ID'];?>_display"><?echo $event['Event_Goal'];?></span>
									<input class="edit event_<?echo $event['Event_ID'];?>_edit" id="<?echo $event['Event_ID'];?>_edit_goal" value="<?echo $event['Event_Goal'];?>" style="width:70px;"/></td>
							</tr>
							<tr>
								<td><strong>Actual Attendance:</strong></td>
								<td><span class="display event_<?echo $event['Event_ID'];?>_display"><?echo $event['Event_Actual'];?></span>
									<input class="edit event_<?echo $event['Event_ID'];?>_edit" id="<?echo $event['Event_ID'];?>_edit_actual" value="<?echo $event['Event_Actual'];?>" style="width:70px;"/></td>
							</tr>
<?php
if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>
							<tr>
								<td colspan="2"><a href="javascript:;" class="display helptext event_<?echo $event['Event_ID'];?>_edit_click" onclick="
											$('.event_<?echo $event['Event_ID'];?>_edit_click').hide();
											$('.event_<?echo $event['Event_ID'];?>_save_click').show();
											$('.event_<?echo $event['Event_ID'];?>_display').hide();
											$('.event_<?echo $event['Event_ID'];?>_edit').show();
									" style="margin-left:30px;">Add/edit...</a>
									<a href="javascript:;" class="edit helptext event_<?echo $event['Event_ID'];?>_save_click" onclick="
											$.post(
                                                                                            '../ajax/edit_event.php',
                                                                                            {
                                                                                                date: document.getElementById('<?echo $event['Event_ID'];?>_edit_date').value,
                                                                                                goal: document.getElementById('<?echo $event['Event_ID'];?>_edit_goal').value,
                                                                                                actual: document.getElementById('<?echo $event['Event_ID'];?>_edit_actual').value,
                                                                                                id: '<?echo $event['Event_ID'];?>'
                                                                                            },
                                                                                            function (response){
                                                                                                window.location = 'engagement.php?event=<?echo $event['Event_ID'];?>';
                                                                                            }
                                                                                    ).fail(failAlert);
								" style="margin-left:30px;">Save changes</a><br/></td>
								<td>
									<a href="javascript:;" class="helptext" onclick="
										$('#add_attendee_<?echo $event['Event_ID'];?>').toggle();
									"
                                                                         >Add attendee...</a>
								</td>
							</tr>
<?php
} // end access level check
?>
                                                        <!-- search for a new attendee: -->
							<tr class="add_attendee" id="add_attendee_<?echo $event['Event_ID'];?>">
								<td></td>
								<td colspan="2" style="padding-left:50px;">
										<table style="font-size:.8em;">
											<tr>
												<td><strong>First Name:</strong></td>
												<td><input type="text" id="first_name_search_<?echo $event['Event_ID'];?>" style="width:80px;"/></td>
												<td><strong>Last Name:</strong></td>
												<td><input type="text" id="last_name_search_<?echo $event['Event_ID'];?>"  style="width:80px;"/></td>
											</tr>
											<tr>
												<td><strong>DOB:</strong></td>
												<td><input type="text" id="dob_search_<?echo $event['Event_ID'];?>"  style="width:80px;"/></td>
												<td colspan="2"><input type="button" value="Search" onclick="
													$.post(
														'../ajax/search_users.php', {
															first: document.getElementById('first_name_search_<?echo $event['Event_ID'];?>').value,
															last: document.getElementById('last_name_search_<?echo $event['Event_ID'];?>').value,
															dob: document.getElementById('dob_search_<?echo $event['Event_ID'];?>').value,
															event_add: '1',
															event_id: <?echo $event['Event_ID'];?>
														},
													function (response){
														document.getElementById('attendee_search_results_<?echo $event['Event_ID'];?>').innerHTML = response;
													}
												).fail(failAlert);"/></td>
											</tr>
										</table>
										<div id="attendee_search_results_<?echo $event['Event_ID'];?>"></div>
								</td>
							</tr>
							<tr>
                                                            <!-- set event to active or inactive: -->
<?php
if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>
								<td>
									<br/><input type="checkbox" id="<?echo $event['Event_ID'];?>_active" <?if ($event['Active']==1) { echo "checked";}?> 
                                                                                    onchange="StatusChange(this, '<?echo $event['Event_ID'];?>')"/><span style="font-size:.9em;font-style:italic;">Active?</span></td>
<?php
} // end access level check
?>
								<td></td>
								<td>
								</td>
							</tr>
						</table>
						
						<script type="text/javascript">
							function StatusChange(cb, event_id) {
								if(cb.checked== true) {
									$.post(
										'../ajax/change_event_status.php',
										{
											action: 'add',
											status: cb.value,
											event_id: event_id
										},
										function (response){
											window.location = "engagement.php?event=<?echo $event['Event_ID'];?>";
										}
									).fail(failAlert);
								}
								else if (cb.checked== false) {
									$.post(
										'../ajax/change_event_status.php',
										{
											action: 'remove',
											status: cb.value,
											event_id: event_id
										},
										function (response){
											window.location = "engagement.php";
										}
									).fail(failAlert);
								}
							}
						</script>
						
						</div>
					</li>
				<?
					}
				?>
				</ul>
                            <!-- all the same information for inactive events: -->
                            <h4><a href="javascript:;" onclick="$('.inactive_events').toggle();">View Inactive Events</a></h4>
                            <ul id="events_list" class="inactive_events">
				<?
					include "../include/dbconnopen.php";
					$events_query_sqlsafe = "SELECT * FROM Events WHERE Active!=1 OR Active IS NULL ORDER BY Event_Date DESC";
					$events = mysqli_query($cnnTRP, $events_query_sqlsafe);
					while ($event = mysqli_fetch_array($events)) {
                                         
					$date_formatted = explode('-', $event['Event_Date']);
					$display_date = $date_formatted[1]."/".$date_formatted[2]."/".$date_formatted[0];
				?>
					<li><h4 onclick="
							$('#event_<?echo $event['Event_ID'];?>_details').slideToggle();
						"><?echo $display_date." - ".$event['Event_Name'];?></h4>
						<div class="event_info" id="event_<?echo $event['Event_ID'];?>_details">
						<table width="100%">
							<tr>
								<td width="30%"><strong>Date:</strong></td>
								<td><span class="display event_<?echo $event['Event_ID'];?>_display"><?echo $display_date;?></span>
									<input class="edit event_<?echo $event['Event_ID'];?>_edit" id="<?echo $event['Event_ID'];?>_edit_date" value="<?echo $display_date;?>" style="width:70px;"/>
								</td>
								<td rowspan="3"><h5>Attendee List</h5>
									<?
										$event_attendance_sqlsafe = "SELECT * FROM Participants INNER JOIN Events_Participants ON Participants.Participant_ID=Events_Participants.Participant_ID WHERE Events_Participants.Event_ID='" . $event['Event_ID'] . "' ORDER BY Participants.Last_Name";
										$attendees = mysqli_query($cnnTRP, $event_attendance_sqlsafe);
										while ($attendee = mysqli_fetch_array($attendees)) {
									?>
										<a href="../participants/profile.php?id=<?echo $attendee['Participant_ID'];?>" style="font-size:.9em;margin-left:10px;"><?echo $attendee['First_Name'] . " " . $attendee['Last_Name'];?></a><br/>
									<?									
										}
									?>
								</td>
							</tr>
							<tr>
								<td><strong>Goal Attendance:</strong></td>
								<td><span class="display event_<?echo $event['Event_ID'];?>_display"><?echo $event['Event_Goal'];?></span>
									<input class="edit event_<?echo $event['Event_ID'];?>_edit" id="<?echo $event['Event_ID'];?>_edit_goal" value="<?echo $event['Event_Goal'];?>" style="width:70px;"/></td>
							</tr>
							<tr>
								<td><strong>Actual Attendance:</strong></td>
								<td><span class="display event_<?echo $event['Event_ID'];?>_display"><?echo $event['Event_Actual'];?></span>
									<input class="edit event_<?echo $event['Event_ID'];?>_edit" id="<?echo $event['Event_ID'];?>_edit_actual" value="<?echo $event['Event_Actual'];?>" style="width:70px;"/></td>
							</tr>
<?php
if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>
							<tr>
								<td colspan="2"><a href="javascript:;" class="display helptext event_<?echo $event['Event_ID'];?>_edit_click" onclick="
											$('.event_<?echo $event['Event_ID'];?>_edit_click').hide();
											$('.event_<?echo $event['Event_ID'];?>_save_click').show();
											$('.event_<?echo $event['Event_ID'];?>_display').hide();
											$('.event_<?echo $event['Event_ID'];?>_edit').show();
									" style="margin-left:30px;">Add/edit...</a>
									<a href="javascript:;" class="edit helptext event_<?echo $event['Event_ID'];?>_save_click" onclick="
                                                                                $.post(
                                                                                            '../ajax/edit_event.php',
                                                                                            {
                                                                                                date: document.getElementById('<?echo $event['Event_ID'];?>_edit_date').value,
                                                                                                goal: document.getElementById('<?echo $event['Event_ID'];?>_edit_goal').value,
                                                                                                actual: document.getElementById('<?echo $event['Event_ID'];?>_edit_actual').value,
                                                                                                id: '<?echo $event['Event_ID'];?>'
                                                                                            },
                                                                                            function (response){
                                                                                                //document.write(response);
                                                                                                window.location = 'engagement.php?event=<?echo $event['Event_ID'];?>';
                                                                                            }
                                                                                    ).fail(failAlert);
								" style="margin-left:30px;">Save changes</a><br/></td>
								<td>
									<a href="javascript:;" class="helptext" onclick="
										$('#add_attendee_<?echo $event['Event_ID'];?>').toggle();
									">Add attendee...</a>
								</td>
							</tr>
<?php
} // end access level check
?>
							<tr class="add_attendee" id="add_attendee_<?echo $event['Event_ID'];?>">
								<td></td>
								<td colspan="2" style="padding-left:50px;">
										<table style="font-size:.8em;">
											<tr>
												<td><strong>First Name:</strong></td>
												<td><input type="text" id="first_name_search_<?echo $event['Event_ID'];?>" style="width:80px;"/></td>
												<td><strong>Last Name:</strong></td>
												<td><input type="text" id="last_name_search_<?echo $event['Event_ID'];?>"  style="width:80px;"/></td>
											</tr>
											<tr>
												<td><strong>DOB:</strong></td>
												<td><input type="text" id="dob_search_<?echo $event['Event_ID'];?>"  style="width:80px;"/></td>
												<td colspan="2"><input type="button" value="Search" onclick="
                                                                                                 //   alert('yes, you did click!');
													$.post(
														'../ajax/search_users.php', 
                                                                                                                {
															first: document.getElementById('first_name_search_<?echo $event['Event_ID'];?>').value,
															last: document.getElementById('last_name_search_<?echo $event['Event_ID'];?>').value,
															dob: document.getElementById('dob_search_<?echo $event['Event_ID'];?>').value,
															event_add: '1',
															event_id: <?echo $event['Event_ID'];?>
														},
													function (response){
                                                                                                        //    alert('and got a response!');
														document.getElementById('attendee_search_results_<?echo $event['Event_ID'];?>').innerHTML = response;
													}
												).fail(failAlert);"/></td>
											</tr>
										</table>
										<div id="attendee_search_results_<?echo $event['Event_ID'];?>"></div>
								</td>
							</tr>
<?php
if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>
							<tr>
								<td>
									<br/><input type="checkbox" id="<?echo $event['Event_ID'];?>_active"  <?if ($event['Active']==1) { echo "checked";}?> 
                                                                                    onchange="StatusChange(this, '<?echo $event['Event_ID'];?>')"/><span style="font-size:.9em;font-style:italic;">Active?</span></td>
								<td></td>
								<td>
								</td>
							</tr>
<?php
} // end access level check
?>
						</table>
						
						<script type="text/javascript">
							function StatusChange(cb, event_id) {
								if(cb.checked== true) {
									$.post(
										'../ajax/change_event_status.php',
										{
											action: 'add',
											status: cb.value,
											event_id: event_id
										},
										function (response){
											window.location = "engagement.php?event=<?echo $event['Event_ID'];?>";
										}
									).fail(failAlert);
								}
								else if (cb.checked== false) {
									$.post(
										'../ajax/change_event_status.php',
										{
											action: 'remove',
											status: cb.value,
											event_id: event_id
										},
										function (response){
											window.location = "engagement.php?event=<?echo $event['Event_ID'];?>";
										}
									).fail(failAlert);
								}
							}
						</script>
						
						</div>
					</li>
				<?
					}
				?>
				</ul>
			</td>
                        <!-- shows community outcomes.  New outcomes must be added by us.  That's probably an area for improvement in the future.
                        
                        -->
			<td><h2>Outcomes Data</h2>
			<ul id="outcomes_list">
			<?
				include "../include/dbconnopen.php";
				$outcomes_query_sqlsafe = "SELECT * FROM Outcomes";
				$outcomes = mysqli_query($cnnTRP, $outcomes_query_sqlsafe);
				while ($outcome = mysqli_fetch_array($outcomes)) {
			?>
					<li>
                                            <!-- for each outcome, show the data that has already been added and allow adding new info: -->
                                            <h3 onclick="
						$('#<?echo $outcome['Outcome_ID'];?>_data').slideToggle();
						"><?echo $outcome['Outcome_Name'];?></h3>
						<div class="outcomes_data" id="<?echo $outcome['Outcome_ID'];?>_data" style="font-size:.9em;padding-left:30px;">
							<table>
								<tr>
									<th>Month</th>
									<th>Goal</th>
									<th>Actual</th>
									<th><th/>
								</tr>
								<?
                                                                include "../include/dbconnopen.php";
									$outcomes_data_query_sqlsafe = "SELECT * FROM Outcomes_Months WHERE Outcome_ID='" . $outcome['Outcome_ID'] . "' ORDER BY Year,Month";
									$outcomes_data = mysqli_query($cnnTRP, $outcomes_data_query_sqlsafe);
                                                                        $months_with_outcomes=mysqli_num_rows($outcomes_data);
                                                                        if ($months_with_outcomes>0){
									while ($outcomes_datum = mysqli_fetch_array($outcomes_data)) {
								?>
									<tr>
										<td><?
											if ($outcomes_datum['Month']==1) {echo "January ";}
											if ($outcomes_datum['Month']==2) {echo "February ";}
											if ($outcomes_datum['Month']==3) {echo "March ";}
											if ($outcomes_datum['Month']==4) {echo "April ";}
											if ($outcomes_datum['Month']==5) {echo "May ";}
											if ($outcomes_datum['Month']==6) {echo "June ";}
											if ($outcomes_datum['Month']==7) {echo "July ";}
											if ($outcomes_datum['Month']==8) {echo "August ";}
											if ($outcomes_datum['Month']==9) {echo "September ";}
											if ($outcomes_datum['Month']==10) {echo "October ";}
											if ($outcomes_datum['Month']==11) {echo "November ";}
											if ($outcomes_datum['Month']==12) {echo "December ";}
											echo $outcomes_datum['Year'];?></td>
										<td><?echo $outcomes_datum['Goal_Outcome'];?></td>
										<td><?echo $outcomes_datum['Actual_Outcome'];?></td>
										<td></td>
									</tr>
								<?
                                                                            }
                                                                        }
									include "../include/dbconnclose.php";
								?>
								<tr>
									<td colspan="4"><span class="helptext">Add data for a new month...</span>
								</tr>
								<tr>
									<td><select id="<?echo $outcome['Outcome_ID'];?>_month">
											<option value="">-----------</option>
											<option value="1">January</option>
											<option value="2">February</option>
											<option value="3">March</option>
											<option value="4">April</option>
											<option value="5">May</option>
											<option value="6">June</option>
											<option value="7">July</option>
											<option value="8">August</option>
											<option value="9">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>
										<select id="<?echo $outcome['Outcome_ID'];?>_year">
											<option value="">----</option>
											<option value="2013">2013</option>
											<option value="2014">2014</option>
											<option value="2015">2015</option>
											<option value="2016">2016</option>
											<option value="2017">2017</option>
										</select>
									</td>
									<td><input type="text" id="<?echo $outcome['Outcome_ID'];?>_goal" style="width:40px;"/></td>
									<td><input type="text" id="<?echo $outcome['Outcome_ID'];?>_actual" style="width:40px;"/></td>
<?php
    if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>

									<td><input type="button" value="Add" onclick="
										$.post(
											'../ajax/save_outcomes_data.php',
											{
												outcome_id: '<?echo $outcome['Outcome_ID'];?>',
												outcome_month: document.getElementById('<?echo $outcome['Outcome_ID'];?>_month').value,
												outcome_year: document.getElementById('<?echo $outcome['Outcome_ID'];?>_year').value,
												outcome_goal: document.getElementById('<?echo $outcome['Outcome_ID'];?>_goal').value,
												outcome_actual: document.getElementById('<?echo $outcome['Outcome_ID'];?>_actual').value
											},
											function (response){
												//alert(response);
												window.location='engagement.php';
											}
										).fail(failAlert);"/>
</td>
<?php
} // end access level check
?>
								</tr>
							</table>
						</div>
					</li>
			<?
				}
			?>
			</ul>
			</td>
		</tr>
	</table>
</div>


<div class="trp_content_block" id="new_trp_event">          <!-- Add new TRP event -->
	<? include "new_event.php"; ?>
</div>


<div class="trp_content_block" id="trp_event_details">          <!-- View TRP event details -->
	<h2>Event Details</h2>
</div>


<div class="trp_content_block" id="outcomes">          <!-- Outcomes...this may not even be needed. -->
	<h2>Outcomes Data</h2>
</div>

<br/><br/>

<?
	include "../../footer.php";
?>
	