<?php

/*This has been absorbed into all_impact and all_intake.  Obsolete.*/

include "../../header.php";
include "../header.php";
include "../include/dbconnopen.php";
$id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_GET['id']);
$get_participant_info = "SELECT * FROM Participants WHERE Participant_ID='".$id_sqlsafe."'";
$participant = mysqli_query($cnnEnlace, $get_participant_info);
$parti = mysqli_fetch_array($participant);
$get_programs = "SELECT * FROM Participants_Programs INNER JOIN Programs ON Participants_Programs.Program_ID=Programs.Program_ID WHERE Participants_Programs.Participant_ID='".$id_sqlsafe."'";
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
<h4>Caring Adults Survey - <?echo $parti['First_Name'] . " " . $parti['Last_Name'];?></h4><hr/><br/>
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
                    <table class="inner_table" style="border: 2px solid #696969;font-size:.9em;width:70%;margin-left:auto;margin-right:auto;" id="caring_adults_table">
                        <tr><td><strong>How many adults in your life:</strong></td><td></td></tr>
                        <tr><td>Pay attention to what's going on in your life?</td><td><select id="pay_attention">
                                    <option value="0">N/A</option>
                                    <option value="1">None</option>
                                    <option value="2">One</option>
                                    <option value="3">2-3</option>
                                    <option value="4">More than 3</option>
                                </select></td></tr>
                        <tr><td>Would say something to you if something in your life wasn't going right?</td>
                        <td><select id="check_in">
                                    <option value="0">N/A</option>
                                    <option value="1">None</option>
                                    <option value="2">One</option>
                                    <option value="3">2-3</option>
                                    <option value="4">More than 3</option>
                                </select></td></tr>
                        <tr><td>Say something nice to you when you do something good?</td><td><select id="praise">
                                    <option value="0">N/A</option>
                                    <option value="1">None</option>
                                    <option value="2">One</option>
                                    <option value="3">2-3</option>
                                    <option value="4">More than 3</option>
                                </select></td></tr>
                        <tr><td>Could you talk to if you are upset or mad about something?</td><td><select id="upset">
                                    <option value="0">N/A</option>
                                    <option value="1">None</option>
                                    <option value="2">One</option>
                                    <option value="3">2-3</option>
                                    <option value="4">More than 3</option>
                                </select></td></tr>
                        <tr><td>Could you go to for help in a crisis?</td><td><select id="crisis">
                                    <option value="0">N/A</option>
                                    <option value="1">None</option>
                                    <option value="2">One</option>
                                    <option value="3">2-3</option>
                                    <option value="4">More than 3</option>
                                </select></td></tr>
                        <tr><td>Could you go to if you need advice about personal problems?</td><td><select id="advice">
                                    <option value="0">N/A</option>
                                    <option value="1">None</option>
                                    <option value="2">One</option>
                                    <option value="3">2-3</option>
                                    <option value="4">More than 3</option>
                                </select></td></tr>
                        <tr><Td>Know a lot about you?</td><td><select id="know_you">
                                    <option value="0">N/A</option>
                                    <option value="1">None</option>
                                    <option value="2">One</option>
                                    <option value="3">2-3</option>
                                    <option value="4">More than 3</option>
                                </select></td></tr>
                        <tr><td>Know what is important to you?</td><td><select id="important">
                                    <option value="0">N/A</option>
                                    <option value="1">None</option>
                                    <option value="2">One</option>
                                    <option value="3">2-3</option>
                                    <option value="4">More than 3</option>
                                </select></td></tr>
                        <tr><td colspan="2"><input type="button" value="Save Survey" onclick="
                                                  $.post(
                                                    '../ajax/save_assessments.php',
                                                    {
                                                        action: 'caring',
                                                        person: '<?echo $_GET['id'];?>',
                                                        attn: document.getElementById('pay_attention').value,
                                                        check: document.getElementById('check_in').value,
                                                        praise: document.getElementById('praise').value,
                                                        upset: document.getElementById('upset').value,
                                                        crisis: document.getElementById('crisis').value,
                                                        advice: document.getElementById('advice').value,
                                                        know: document.getElementById('know_you').value,
                                                        important: document.getElementById('important').value,
														program: document.getElementById('program').value
                                                    },
                                                    function (response){
                                                        document.getElementById('show_caring_response').innerHTML='Thank you for entering this survey.\n\
<a href=participant_profile.php?id=<?echo $_GET['id'];?>>Click here to return to the participant profile.</a>';
                                                    }
                                               )"></td></tr>
                    </table>
<div id="show_caring_response"></div>
<br/><br/>
<?
	include "../include/dbconnclose.php";
	include "../../footer.php";
?>