<?php
require_once("../siteconfig.php");
?>
<?php

/*Obsolete.  There's no longer a link to view surveys.*/

include "../../header.php";
include "../header.php";
include "../classes/program.php";

include "../include/dbconnopen.php";
$surv_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_GET['surv']);
$get_survey_info="SELECT * FROM Program_Surveys INNER JOIN Programs ON Programs.Program_ID=Program_Surveys.Program_ID
    WHERE Program_Survey_ID='".$surv_sqlsafe."'";
//echo $get_survey_info;
$survey_info=mysqli_query($cnnEnlace, $get_survey_info);
$this_survey=mysqli_fetch_row($survey_info);
    include "../include/dbconnclose.php";
    $counter=0;
foreach ($this_survey as $abbr){
    if ($counter>1 && $counter<18){
    if ($abbr==0){$abbr='N/A';}
    elseif ($abbr==1){$abbr='Strongly disagree';}
    elseif ($abbr==2){$abbr='Disagree';}
    elseif ($abbr==3){$abbr='Agree';}
    elseif ($abbr==4){$abbr='Strongly agree';}
    $this_survey[$counter]=$abbr;
    }
    $counter++;
}
    ?>


<h3>Program Quality Survey: <?echo $this_survey[21];?></h3><hr/><br/>
    <a href='javascript:;' onclick="$.post(
                '../ajax/set_program_id.php',
                {
                    page: 'profile',
                    id: '<?echo $this_survey[1];?>'
                },
                function (response){
                    window.location='profile.php';
                }
            )">Return to program profile.</a>

<table class="inner_table" style="border: 2px solid #696969;font-size:.9em;width:70%;margin-left:auto;margin-right:auto;" >
    <tr><th>At this program...</th><th></th></tr>
    <tr><td>I get chances to do things with other people my age.</td><td><?echo $this_survey[2];?></td></tr>
    <tr><td>I feel safe.</td><td><?echo $this_survey[3];?></td></tr>
    <tr><td>I feel respected by program staff.</td><td><?echo $this_survey[4];?></td></tr>
    <tr><td>I have to do what's planned, no matter what.</td><td><?echo $this_survey[5];?></td></tr>
    <tr><td>I'm usually bored.</td><td><?echo $this_survey[6];?></td></tr>
    <tr><td>I get to decide what activities I'm going to do here.</td><td><?echo $this_survey[7];?></td></tr>
    <tr><td>I feel like I belong here.</td><td><?echo $this_survey[8];?></td></tr>
    <tr><td>I have a chance to learn how to do new things here.</td><td><?echo $this_survey[9];?></td></tr>
    <tr><td>I wish I didn't have to attend this program.</td><td><?echo $this_survey[10];?></td></tr>
    <tr><Td>The staff here challenges me to do my best.</td><td><?echo $this_survey[11];?></td></tr>
    <tr><td>I feel like my ideas count.</td><td><?echo $this_survey[12];?></td></tr>
    <tr><td>The staff know me well.</td><td><?echo $this_survey[13];?></td></tr>
    <tr><td>I have the chance to develop skills.</td><td><?echo $this_survey[14];?></td></tr>
    <tr><td>I have the chance to develop friendships with other students.</td><td><?echo $this_survey[15];?></td></tr>
    <tr><Td>If I didn't show up, someone would notice that I'm not here.</td><td><?echo $this_survey[16];?></td></tr>
    <tr><td>I feel like I matter.</td><td><?echo $this_survey[17];?></td></tr>
    
</table>

<div id="progsurv_response"></div>


			
<br/><br/>
<?
	include "../../footer.php";
?>