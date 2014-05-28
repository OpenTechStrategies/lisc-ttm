<?php

include "../../header.php";
include "../header.php";
include "reports_menu.php";
?>
<!-- Shows the number of leaders in each institution, and how many events they have attended. -->

<h4>Leaders by Institution</h4><br/>
<!--<p>N.B.: add change over time - search by time period?  Graph of change by quarters? (
                WHERE Event_Date>='2013-01-01' AND Event_Date<='2013-03-31')</p>-->
<table class="leader_report_table">
    <!-- count leaders sorted by type and institution: -->
    <tr><th>Institution</th><th>Number of leaders</th></tr>
    <?$get_leaders ="SELECT Institution_Name, Leader_Type, COUNT(Leader_Type) FROM Participants_Leaders 
        INNER JOIN Institutions_Participants
            ON Participants_Leaders.Participant_ID=Institutions_Participants.Participant_ID
        INNER JOIN Institutions
            ON Institutions_Participants.Institution_ID=Institutions.Institution_ID
             WHERE Leader_Type!=4
            GROUP BY Institution_Name, Leader_Type;";
  //  echo $get_leaders;
    include "../include/dbconnopen.php";
    $leaders=mysqli_query($cnnSWOP, $get_leaders);
    $inst='';
    while ($lea=mysqli_fetch_row($leaders)){
        if ($lea[0]!=$inst){?>
	<tr><td colspan="2"><hr/></td></tr>
	<?}?>
	<tr><td style="padding-left:20px;"><?
        /* display institution name if it has changed */
        if ($lea[0]!=$inst){
        echo $lea[0];
        $inst=$lea[0];
        }?>
        </td><td><?if ($lea[1]==3){ echo 'Tertiary: ' . $lea[2]; }
        elseif($lea[1]==2){ echo 'Secondary: ' . $lea[2]; }
        elseif($lea[1]==1){ echo 'Primary: ' . $lea[2]; }?>
     </td>   
    </tr>
            <?
    }
    include "../include/dbconnclose.php";
    ?>
</table>

<p>*****</p>

<table class="leader_report_table">
    <tr><th>Institution Name</th><th>Events Attended by Institution Affiliates</th></tr>
    <?
    /* sort people by their primary institution and the roles they've had at events. */
        $count_roles="SELECT Institution_Name, Institutions_Participants.Participant_ID, Role_Name, Event_Name, 
            COUNT(*)
        FROM Institutions_Participants
        INNER JOIN Institutions
            ON Institutions_Participants.Institution_ID=Institutions.Institution_ID
        INNER JOIN Participants_Events
            ON Institutions_Participants.Participant_ID=Participants_Events.Participant_ID
        INNER JOIN Campaigns_Events
            ON Participants_Events.Event_ID=Campaigns_Events.Campaign_Event_ID
            INNER JOIN Participants_Roles ON Role_Type=Role_ID
                    GROUP BY Institution_Name, Role_Type;";
        //echo $count_roles;
        include "../include/dbconnopen.php";
    $roleplayers=mysqli_query($cnnSWOP, $count_roles);
    $inst='';
    while ($role=mysqli_fetch_row($roleplayers)){
	if ($role[0]!=$inst){?>
	<tr><td colspan="2"><hr/></td></tr>
	<?}?>
    <tr><td style="padding-left:20px;"><?
        if ($role[0]!=$inst){
        echo $role[0];
        $inst=$role[0];
        }?>
        </td><td><?
        if ($role[2]!==NULL){echo $role[2] .": ". $role[4];}
        elseif($role[2]==NULL){ echo 'No role: ' . $role[4]; }?>
     </td>   
    </tr> 
            <?
    }
    include "../include/dbconnclose.php";
    ?>
</table>

<br/><br/>
<?
	include "../../footer.php";
?>