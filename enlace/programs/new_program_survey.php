<?php
require_once("../siteconfig.php");
?>
<?php

/*Add a new program quality survey here: */

include "../../header.php";
include "../header.php";
include "../classes/program.php";
$survey_program=new Program();
$survey_program->load_with_program_id($_GET['prog']);
include "../include/dbconnopen.php";
$prog_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_GET['prog']);
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#programs_selector').addClass('selected');
			$('#ajax_loader').hide();
	});
	
	$(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });
            
    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
	});
</script>

<h3>New Program Quality Survey: <?echo $survey_program->name;?></h3><hr/><br/>
    <!--<a href='javascript:;' onclick="$.post(
                '../ajax/set_program_id.php',
                {
                    page: 'profile',
                    id: '<?echo $this_survey[1];?>'
                },
                function (response){
                    window.location='profile.php';
                }
            )">Return to program profile.</a>-->
<div width="100%" style="text-align:center;">

    
    <!--Surveys need to be linked to a session: -->
<!--    <span class="helptext">Is this a pre- or post-program survey?</span>
<select id="pre_post">
	<option value="">-------</option>
	<option value="pre">Pre-program</option>
	<option value="post">Post-program</option>
</select><br>-->
    <span class="helptext">Please choose the session for which this survey was filled out:</span>
    <select id="surveyed_session"><option value="">-----</option>
                                                    <?//get sessions
                                                    $related_sessions="SELECT * FROM Session_Names WHERE Program_ID='".$prog_sqlsafe."'";
                                                    include "../include/dbconnopen.php";
                                                    $sessions=mysqli_query($cnnEnlace, $related_sessions);
                                                    while ($sess=mysqli_fetch_row($sessions)){
                                                        ?>
                                                    <option value="<?echo $sess[0];?>"><?echo $sess[1];?></option>
                                                            <?
                                                    }
                                                    include "../include/dbconnclose.php";
                                                    ?></select>
</div><br/>

<!--Enter survey responses here: -->
<table class="inner_table" style="border: 2px solid #696969;font-size:.9em;width:70%;margin-left:auto;margin-right:auto;" >
    <tr><th>At this program...</th><th></th></tr>
    <tr><td>I get chances to do things with other people my age.</td><td><select id="progsurv_1">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I feel safe.</td><td><select  id="progsurv_2">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I feel respected by program staff.</td><td><select id="progsurv_3">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I have to do what's planned, no matter what.</td><td><select id="progsurv_4">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I'm usually bored.</td><td><select id="progsurv_5">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I get to decide what activities I'm going to do here.</td><td><select id="progsurv_6">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I feel like I belong here.</td><td><select id="progsurv_7">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I have a chance to learn how to do new things here.</td><td><select id="progsurv_8">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I wish I didn't have to attend this program.</td><td><select id="progsurv_9">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><Td>The staff here challenges me to do my best.</td><td><select id="progsurv_10">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I feel like my ideas count.</td><td><select id="progsurv_11">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>The staff know me well.</td><td><select id="progsurv_12">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I have the chance to develop skills.</td><td><select id="progsurv_13">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I have the chance to develop friendships with other students.</td><td><select id="progsurv_14">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><Td>If I didn't show up, someone would notice that I'm not here.</td><td><select id="progsurv_15">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td>I feel like I matter.</td><td><select id="progsurv_16">
                <option value="0">-----</option>
                <option value="1">Strongly disagree</option>
                <option value="2">Disagree</option>
                <option value="3">Agree</option>
                <option value="4">Strongly agree</option>
            </select></td></tr>
    <tr><td colspan="2"><input type="button" value="Save" onclick="
                               $.post(
                                '../ajax/save_progsurv.php',
                                {
                                    program: '<?echo $prog_sqlsafe?>',
                                    1: document.getElementById('progsurv_1').value,
                                    2: document.getElementById('progsurv_2').value,
                                    3: document.getElementById('progsurv_3').value,
                                    4: document.getElementById('progsurv_4').value,
                                    5: document.getElementById('progsurv_5').value,
                                    6: document.getElementById('progsurv_6').value,
                                    7: document.getElementById('progsurv_7').value,
                                    8: document.getElementById('progsurv_8').value,
                                    9: document.getElementById('progsurv_9').value,
                                    10: document.getElementById('progsurv_10').value,
                                    11: document.getElementById('progsurv_11').value,
                                    12: document.getElementById('progsurv_12').value,
                                    13: document.getElementById('progsurv_13').value,
                                    14: document.getElementById('progsurv_14').value,
                                    15: document.getElementById('progsurv_15').value,
                                    16: document.getElementById('progsurv_16').value,
                                   // pre_post: document.getElementById('pre_post').value,
                                    session: document.getElementById('surveyed_session').value
                                },
                                function (response){
                                    document.getElementById('progsurv_response').innerHTML=response;
                                }
                           )"></td></tr>
</table>

<div id="progsurv_response"></div>
<br/><br/>

<?
	include "../../footer.php";
?>