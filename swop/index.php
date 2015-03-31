<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

include "../header.php";
include "header.php";
include "include/datepicker_simple.php";
?>
<!-- Landing page for SWOP -->
<script type="text/javascript">
	$(document).ready(function() {
	$("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});
	});
</script>

<div class="content">
<h3 id="swop_welcome">Welcome to the Chicago Lawn Testing the Model Data Center!</h3><hr/><br/><br/>
<table style="margin-left:auto;margin-right:auto;width:80%;">
    <!-- quick links to other parts of the system.  Note that this is the only link to the edit_dropdowns page: -->
	<tr>
		<td style="font-size:.9em;vertical-align:top;" width="30%"><div class="hide_on_view"><a class="add_new" href="include/edit_dropdowns.php"><span class="add_new_button">
            Alter System Dropdowns</span></a></div><br/><br/>
		<div><a class="add_new" href="participants/participants.php?new=1"><span class="add_new_button">
            Add New Participant</span></a></div><br/><br/>
		<div><a class="add_new" href="properties/properties.php?new=1"><span class="add_new_button">
            Add New Property</span></a></div></td>
            
            <!-- Alerts for people who have missed their expected dates.  the progress for people in the pool
            is automated, and these alerts are for people who were supposed to have a meeting or something
            and didn\'t do it on time.
            -->
		<td><h4>Alerts</h4>
    <table class="inner_table">
        <tr><th>Person</th><th>Benchmark Missed</th><th>Expected Date</th></tr>
        <?php
        $get_alert_people="SELECT Name_First, Name_Last, Benchmark_Name, MONTH(Expected_Date), 
            DAY(Expected_Date), YEAR(Expected_Date) FROM Pool_Progress
            INNER JOIN Participants ON Pool_Progress.Participant_Id=Participants.Participant_ID
            INNER JOIN Pool_Benchmarks ON Benchmark_Completed=Pool_Benchmark_ID
            INNER JOIN Pool_Status_Changes ON Pool_Progress.Participant_ID=Pool_Status_Changes.Participant_ID
            INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON Pool_Status_Changes.Date_Changed=laststatus.lastdate 
            WHERE (Date_Completed='0000-00-00 00:00:00' OR Date_Completed IS NULL) AND 
                Expected_Date<'".date('Y-m-d')."' AND laststatus.Active=1
                    ORDER BY Expected_Date";
        $get_alert_people_sqlsafe="SELECT Name_First, Name_Last, Benchmark_Name, MONTH(Pool_Progress.Expected_Date), DAY(Pool_Progress.Expected_Date),
YEAR(Pool_Progress.Expected_Date), Pool_Status_Changes.Active, laststatus.lastdate FROM Pool_Progress 
INNER JOIN Participants ON Pool_Progress.Participant_Id=Participants.Participant_ID 
INNER JOIN Pool_Benchmarks ON Benchmark_Completed=Pool_Benchmark_ID 
INNER JOIN Pool_Status_Changes ON Pool_Progress.Participant_ID=Pool_Status_Changes.Participant_ID 
INNER JOIN (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes 
GROUP BY Participant_ID) laststatus ON Pool_Status_Changes.Date_Changed=laststatus.lastdate 
WHERE (Date_Completed='0000-00-00 00:00:00' OR Date_Completed IS NULL) AND 
Pool_Progress.Expected_Date<'".date('Y-m-d')."' AND Pool_Status_Changes.Active=1 
AND Participants.Participant_ID NOT IN (SELECT Participant_ID FROM Pool_Outcomes WHERE Outcome_ID = 5)
ORDER BY Pool_Progress.Expected_Date";
        //echo $get_alert_people;
        include "include/dbconnopen.php";
        $alert_people=mysqli_query($cnnSWOP, $get_alert_people_sqlsafe);
        while ($alert=mysqli_fetch_row($alert_people)){
            ?>
        <tr><td><?php echo $alert[0] ." ". $alert[1];?></td><td><?php echo $alert[2];?></td>
            <td><?php echo $alert[5] . '-' . $alert[3] . '-' . $alert[4];?></td></tr>  
                <?php
        }
        include "include/dbconnclose.php";
        ?>
    </table><br/><br/>
</td>
	</tr>
</table>



</div>

<?php include "../footer.php"; ?>