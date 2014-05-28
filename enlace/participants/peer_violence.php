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
<h4>Attitude Toward Interpersonal Peer Violence - <?echo $parti['First_Name'] . " " . $parti['Last_Name'];?></h4><hr/><br/>
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
                    <table class="inner_table" style="border: 2px solid #696969;font-size:.9em;width:70%;margin-left:auto;margin-right:auto;" id="peer_violence_table">
                        <tr><td>If I walked away from a fight, I'd be a coward ("chicken").</td><td><select id="chicken">
                                    <option value="0">N/A</option>
                                    <option value="4">Disagree a lot</option>
                                    <option value="3">Disagree a little</option>
                                    <option value="2">Agree a little</option>
                                    <option value="1">Agree a lot</option>
                                </select></td></tr>
                        <tr><td>Anyone who won't fight is going to be picked on even more.</td><td><select id="prevention">
                                    <option value="0">N/A</option>
                                    <option value="4">Disagree a lot</option>
                                    <option value="3">Disagree a little</option>
                                    <option value="2">Agree a little</option>
                                    <option value="1">Agree a lot</option>
                                </select></td></tr>
                        <tr><td>I don't need to fight because there are other ways to deal with being mad.</td><td><select id="other_ways">
                                    <option value="0">N/A</option>
                                    <option value="1">Disagree a lot</option>
                                    <option value="2">Disagree a little</option>
                                    <option value="3">Agree a little</option>
                                    <option value="4">Agree a lot</option>
                                </select></td></tr>
                        <tr><td>It's okay to hit someone who hits you first.</td><td><select id="self_defense">
                                    <option value="0">N/A</option>
                                    <option value="4">Disagree a lot</option>
                                    <option value="3">Disagree a little</option>
                                    <option value="2">Agree a little</option>
                                    <option value="1">Agree a lot</option>
                                </select></td></tr>
                        <tr><td>When actions of others make me angry, I can usually deal with it without getting into a physical fight.</td><td>
                                <select id="coping_strategies">
                                    <option value="0">N/A</option>
                                    <option value="1">Disagree a lot</option>
                                    <option value="2">Disagree a little</option>
                                    <option value="3">Agree a little</option>
                                    <option value="4">Agree a lot</option>
                                </select></td></tr>
                        <tr><Td>If a kid teases me or disses me, I usually cannot get them to stop unless I hit them.</td><td><select id="act_out">
                                    <option value="0">N/A</option>
                                    <option value="4">Disagree a lot</option>
                                    <option value="3">Disagree a little</option>
                                    <option value="2">Agree a little</option>
                                    <option value="1">Agree a lot</option>
                                </select></td></tr>
                        <tr><td>If I really want to, I can usually talk someone out of trying to fight with me.</td><td><select id="negotiation">
                                    <option value="0">N/A</option>
                                    <option value="1">Disagree a lot</option>
                                    <option value="2">Disagree a little</option>
                                    <option value="3">Agree a little</option>
                                    <option value="4">Agree a lot</option>
                                </select></td></tr>
                        <tr><td>My family would be mad at me if I got in a fight with another student, no matter what the reason.</td><td>
                                <select id="disapproval">
                                    <option value="0">N/A</option>
                                    <option value="1">Disagree a lot</option>
                                    <option value="2">Disagree a little</option>
                                    <option value="3">Agree a little</option>
                                    <option value="4">Agree a lot</option>
                                </select></td></tr>
                        <tr><td>If a student hits me first, my family would want me to hit them back.</td><td><select id="approval">
                                    <option value="0">N/A</option>
                                    <option value="4">Disagree a lot</option>
                                    <option value="3">Disagree a little</option>
                                    <option value="2">Agree a little</option>
                                    <option value="1">Agree a lot</option>
                                </select></td></tr>
                        <Tr><td>I usually can tell when things are bothering me or getting on my nerves.</td><td><select id="self_awareness">
                                    <option value="0">N/A</option>
                                    <option value="1">Disagree a lot</option>
                                    <option value="2">Disagree a little</option>
                                    <option value="3">Agree a little</option>
                                    <option value="4">Agree a lot</option>
                                </select></td></tr>
                        <tr><td>If things are bothering me or getting on my nerves, I do things to relax.</td><td><select id="self_care">
                                    <option value="0">N/A</option>
                                    <option value="1">Disagree a lot</option>
                                    <option value="2">Disagree a little</option>
                                    <option value="3">Agree a little</option>
                                    <option value="4">Agree a lot</option>
                                </select></td></tr>
                        <tr><td colspan="2"><input type="button" value="Save Survey" onclick="
                                                  $.post(
                                                    '../ajax/save_assessments.php',
                                                    {
                                                        action: 'violence',
                                                        person: '<?echo $_GET['id'];?>',
                                                        fear: document.getElementById('chicken').value,
                                                        prevent: document.getElementById('prevention').value,
                                                        manage: document.getElementById('other_ways').value,
                                                        defense: document.getElementById('self_defense').value,
                                                        coping: document.getElementById('coping_strategies').value,
                                                        others: document.getElementById('act_out').value,
                                                        negotiation: document.getElementById('negotiation').value,
                                                        disapproval: document.getElementById('disapproval').value,
                                                        approval: document.getElementById('approval').value,
                                                        awareness: document.getElementById('self_awareness').value,
                                                        care: document.getElementById('self_care').value
                                                    },
                                                    function (response){
                                                        document.getElementById('show_violent_response').innerHTML='Thank you for entering this survey.\n\
<a href=participant_profile.php?id=<?echo $_GET['id'];?>>Click here to return to the participant profile.</a>  ';
                                                    }
                                               )"></td></tr>
                    </table>
<div id="show_violent_response"></div>
<br/><br/>
<?
	include "../../footer.php";
?>