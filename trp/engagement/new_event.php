	<h2>Create a New Event</h2>
        
        <!-- Add a new non-campaign-affiliated event. -->
	<br/>
				
				<table id="add_new_table">
					<tr>
						<td><strong>Event Name:</strong></td>
						<td><input type="text" id="event_name" /></td>
					</tr>
					<tr>
						<td><strong>Event Date:</strong></td>
						<td><input type="text" id="event_date" class="hasDatepickers"/> <span class="helptext">(MM/DD/YYYY)</span>
                                                </td>
					</tr>
					<tr>
						<td><strong>Goal Attendance:</strong></td>
						<td><input type="text" id="event_goal" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Submit" onclick="
                                                                       $.post(
                                                                        '../ajax/add_event.php',
                                                                        {
                                                                            name: document.getElementById('event_name').value,
                                                                            goal: document.getElementById('event_goal').value,
                                                                            date: document.getElementById('event_date').value
                                                                        },
                                                                        function (response){
                                                                            document.getElementById('show_event_result').innerHTML =response;
                                                                        }
                                                                   )"/></strong></td>
					</tr>
				</table>
        <div id="show_event_result"></div>