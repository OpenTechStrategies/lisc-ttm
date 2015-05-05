<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id);

?>
<?php
include "../header.php";
include "header.php";
include "include/datepicker_simple.php";
?>
<!--<img src="/images/ajax-loader.gif" width="40" height="40" alt="Loading..." id="ajax_loader" style="position: fixed; top: 0; left: 0;" />-->
<div class="content">
<h2 id="lsna_welcome">Welcome to the Pilsen Testing the Model Data Center!</h2><hr style="margin:3px"/><br/>


<!-- adds an event.  Doesn't link event to a campaign, so it shows up on the Community Engagement page. -->

<?php
    if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>
<h4>Create a New Event</h4>
	<br/>
				
				<table id="add_new_table"  style="margin-left:auto;margin-right:auto;font-size:.9em;">
					<tr>
						<td><strong>Event Name:</strong></td>
						<td><input type="text" id="event_name" /></td>
					</tr>
					<tr>
						<td><strong>Event Date:</strong></td>
						<td><input type="text" id="event_date" class="hasDatepickers"/> <span class="helptext">(MM/DD/YYYY)</span></td>
					</tr>
					<tr>
						<td><strong>Goal Attendance:</strong></td>
						<td><input type="text" id="event_goal" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Submit" onclick="
                                                                       $.post(
                                                                        'ajax/add_event.php',
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
<?php
} // end access level check
?>


</div>

<?php
 include "../footer.php"; ?>
