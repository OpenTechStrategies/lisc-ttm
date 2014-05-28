<?php

/*This has been absorbed into all_impact and all_intake.  Obsolete.*/
include "../../header.php";
include "../header.php";
$get_participant_info = "SELECT * FROM Participants WHERE Participant_ID='".$_GET['id']."'";
include "../include/dbconnopen.php";
$participant = mysqli_query($cnnEnlace, $get_participant_info);
$parti = mysqli_fetch_array($participant);
$get_programs = "SELECT * FROM Participants_Programs INNER JOIN Programs ON Participants_Programs.Program_ID=Programs.Program_ID WHERE Participants_Programs.Participant_ID='".$_GET['id']."'";
$programs = mysqli_query($cnnEnlace, $get_programs);
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#participants_selector').addClass('selected');
		$('#ajax_loader').hide();
	});
	
	$(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });
            
    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>
<h4>Future Expectations Questionnaire - <?echo $parti['First_Name'] . " " . $parti['Last_Name'];?></h4><hr/><br/>
<div style="text-align:center;"><span class="helptext">Program: </span>
<select id="program">
	<option value="">-------</option>
	<?
		while ($program = mysqli_fetch_array($programs)) {
	?>
	<option value="<?echo $program['Program_ID'];?>"><?echo $program['Name'];?></option>
	<?
		}
	?>
</select><br/><br/></div>

<table class="inner_table" style="border: 2px solid #696969;font-size:.9em;width:70%;margin-left:auto;margin-right:auto;" id="future_table">
    <tr><td><b>When I think about the future...</b></td><td></td></tr>
    <tr><td>I am sure I can handle the problems that might come up.</td><td><select id="solve_probs"><option value="0">N/A</option>\
                <option value="1">Not likely at all</option>
                <option value="2">May be likely but probably not</option>
                <option value="3">Could go either way</option>
                <option value="4">Very likely, not absolute</option>
                <option value="5">Definitely will</option>
            </select></td></tr>
    <tr><td>I will be able to stay safe and out of danger.</td><td><select id="stay_safe"><option value="0">N/A</option>\
                <option value="1">Not likely at all</option>
                <option value="2">May be likely but probably not</option>
                <option value="3">Could go either way</option>
                <option value="4">Very likely, not absolute</option>
                <option value="5">Definitely will</option>
            </select></td></tr>
    <tr><td>I will be alive and well.</td><td><select id="alive_well"><option value="0">N/A</option>\
                <option value="1">Not likely at all</option>
                <option value="2">May be likely but probably not</option>
                <option value="3">Could go either way</option>
                <option value="4">Very likely, not absolute</option>
                <option value="5">Definitely will</option>
            </select></td></tr>
    <tr><td>I am sure that I can handle work or school.</td><td><select id="manage_work"><option value="0">N/A</option>\
                <option value="1">Not likely at all</option>
                <option value="2">May be likely but probably not</option>
                <option value="3">Could go either way</option>
                <option value="4">Very likely, not absolute</option>
                <option value="5">Definitely will</option>
            </select></td></tr>
    <tr><td>I think I will have friends and people that care about me.</td><td><select id="have_friends"><option value="0">N/A</option>\
                <option value="1">Not likely at all</option>
                <option value="2">May be likely but probably not</option>
                <option value="3">Could go either way</option>
                <option value="4">Very likely, not absolute</option>
                <option value="5">Definitely will</option>
            </select></td></tr>
    <tr><td>I will have a happy life.</td><td><select id="happy_life"><option value="0">N/A</option>\
                <option value="1">Not likely at all</option>
                <option value="2">May be likely but probably not</option>
                <option value="3">Could go either way</option>
                <option value="4">Very likely, not absolute</option>
                <option value="5">Definitely will</option>
            </select></td></tr>
    <tr><td>My life will be interesting.</td><td><select id="interesting_life"><option value="0">N/A</option>\
                <option value="1">Not likely at all</option>
                <option value="2">May be likely but probably not</option>
                <option value="3">Could go either way</option>
                <option value="4">Very likely, not absolute</option>
                <option value="5">Definitely will</option>
            </select></td></tr>
    <tr><td>My parents will be proud of me.</td><td><select id="proud_parents"><option value="0">N/A</option>\
                <option value="1">Not likely at all</option>
                <option value="2">May be likely but probably not</option>
                <option value="3">Could go either way</option>
                <option value="4">Very likely, not absolute</option>
                <option value="5">Definitely will</option>
            </select></td></tr>
    <tr><td>Thinking about yourself and when you get older, how likely do you think it is that you will finish high school?</td>
    <td><select id="finish_hs"><option value="0">N/A</option>\
                <option value="1">Not likely at all</option>
                <option value="2">May be likely but probably not</option>
                <option value="3">Could go either way</option>
                <option value="4">Very likely, not absolute</option>
                <option value="5">Definitely will</option>
            </select></td></tr>
    <tr><td colspan="2"><input type="button" value="Save" onclick="
                               $.post(
                                '../ajax/save_assessments.php',
                                {
                                    action: 'future',
                                    person: '<?echo $_GET['id'];?>',
                                    solutions: document.getElementById('solve_probs').value,
                                    safety: document.getElementById('stay_safe').value,
                                    living: document.getElementById('alive_well').value,
                                    manage: document.getElementById('manage_work').value,
                                    friends: document.getElementById('have_friends').value,
                                    happy: document.getElementById('happy_life').value,
                                    interesting: document.getElementById('interesting_life').value,
                                    parents: document.getElementById('proud_parents').value,
                                    finish_hs: document.getElementById('finish_hs').value,
									program: document.getElementById('program').value
                                },
                                                    function (response){
                                                        document.getElementById('show_future_response').innerHTML='Thank you for entering this survey.\n\
<a href=participant_profile.php?id=<?echo $_GET['id'];?>>Click here to return to the participant profile.</a>  ';
                                                    }
                           )"></td></tr>
</table>
<div id="show_future_response"></div>
<br/><br/>
<?
	include "../../footer.php";
?>