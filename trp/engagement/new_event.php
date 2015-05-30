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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id);

?>
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
                                                                   ).fail(failAlert);"/></strong></td>
					</tr>
				</table>
        <div id="show_event_result"></div>