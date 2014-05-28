<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include "../../header.php";
include "../../bickerdike/header.php";
?>

<script>
	$(document).ready(function(){
			$('#events_selector').addClass('selected');
			$("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});
		});
</script>

<div class="content_wide">
<h3>Events</h3>
<hr/><br/>

<table id="all_programs">
	<tr>
		<td width="50%"><h4>Search Events</h4>
			<table class="program_table">
    <tr><td class="all_projects"><strong>Program Name (or part of name):</strong></td>
        <td class="all_projects"><input type="text" id="name"></td></tr>
    <tr><td class="all_projects"><strong>Program Organization:</strong></td>
        <td class="all_projects"><select id="org">
                <option value="">-----</option>
                <?
                $program_query = "SELECT * FROM User_Established_Activities GROUP BY Activity_Org";
include "../include/dbconnopen.php";
$programs = mysqli_query($cnnBickerdike, $program_query);
while ($program = mysqli_fetch_array($programs)){
    ?>
        <option value="<?echo $program['Activity_Org'];?>"><?echo $program['Activity_Org'];?></option>
        <?
}
include "../include/dbconnclose.php";
                ?>
            </select></td></tr>
    <tr><td class="all_projects"><strong>Event Type:</strong></td>
        <td class="all_projects"><select id="type">
                <option value="">-----</option>
                <?
                $program_query = "SELECT * FROM User_Established_Activities GROUP BY Activity_Type";
include "../include/dbconnopen.php";
$programs = mysqli_query($cnnBickerdike, $program_query);
while ($program = mysqli_fetch_array($programs)){
    ?>
        <option value="<?echo $program['Activity_Type'];?>"><?echo $program['Activity_Type'];?></option>
        <?
}
include "../include/dbconnclose.php";
                ?>
            </select></td></tr>
        <tr><td class="all_projects"><strong>From Date:</strong></td>
        <td class="all_projects"><input type="text" id="date_start"></td></tr>
            <tr><td class="all_projects"><strong>To Date:</strong></td>
        <td class="all_projects"><input type="text" id="date_end"></td></tr>
    <tr><th colspan="2"><p class="helptext">Dates must be entered in the format YYYY-MM-DD (or use the pop-up calendar).</p><input type="button" value="Search" onclick="
                               $.post(
                                '../ajax/search_events.php',
                                {
                                    name: document.getElementById('name').value,
                                    org: document.getElementById('org').value,
                                    type: document.getElementById('type').value,
                                    start: document.getElementById('date_start').value,
                                    end: document.getElementById('date_end').value
                                },
                                function (response){
                                    document.getElementById('show_results').innerHTML = response;
                                }
                           )"></th></tr>
</table><br/>
<div id="show_results"></div>
		</td>
		<td><a href="new_activity.php"class="add_new"><span class="add_new_button">Create New Event</span></a></br><br/>
			<strong><em>Click on an event to see details:</em></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<ul>
<?

include "../include/datepicker.php";
$activity_query = "SELECT * FROM User_Established_Activities";
include "../include/dbconnopen.php";
$activities = mysqli_query($cnnBickerdike, $activity_query);
while ($act = mysqli_fetch_array($activities)){?>
    <li><a href="activity_profile.php?activity=<?echo $act['User_Established_Activities_ID'];?>"><?echo $act['Activity_Name'];?></a> &nbsp;&nbsp;&nbsp;
    <input type="button" value="Delete" onclick="var first='<?echo $act['Activity_Name']?>';
                                                var answer = confirm('Are you sure you want to delete '+first+' from the database?');
                                                if (answer){
                                                    $.post(
                                                        '../ajax/delete_event.php',
                                                        {
                                                            program_id: '<?echo $act['User_Established_Activities_ID'];?>'
                                                        },
                                                        function (response){
                                                            window.location = 'view_search_activities.php';
                                                        }
                                                    );
                                                }"></li>
<?}
include "../include/dbconnclose.php";
?>

</ul>
		</td>
	</tr>
</table>


</div>
<? include "../../footer.php"; ?>