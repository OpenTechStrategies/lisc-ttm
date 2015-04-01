<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

include "../../header.php";
include "../header.php";
include "reports_menu.php";
include "../include/dbconnopen.php";
?>

<h4>Active/Inactive Pool Members</h4><br/>

<!-- counts people entering and exiting pool each quarter. -->

<table class="all_projects">
    <tr><th width="15%">Quarter</th><th>Number of Active Pool Members</th><th>Number of New Pool Members</th><th>Number of Exited Pool Members (by outcome?)</th>
        <th>Number of Deactivated Pool Members</th><th>Number of Reactivated Pool Members</th></tr>
    <?//need to loop through quarters here to show change over time.  Current quarter minus...8 quarters?  But not going back beyond 1st quarter 2013.
    //that seems reasonable.
    $quarter_array=array(1, 2, 3, 4);
    $start_dates_arr=array('01-01', '04-01', '07-01', '10-01');
    $end_dates_arr=array('03-31', '06-30', '09-30', '12-31');
    date_default_timezone_set('America/Chicago');
    $this_year=date('Y');
    for ($i=0; $i<3; $i++){
        $year=$this_year-$i;
        $counter=0;
        foreach($start_dates_arr as $start){
            
    ?>
    <tr><td class="all_projects"><?echo $year;?> - Quarter <?echo $quarter_array[$counter];?></td> 
        <td class="all_projects"><?php
        //gets all the people added up to the end of the given quarter.
        $get_current_status_sqlsafe = "SELECT COUNT(Active) as count  
            FROM Pool_Status_Changes 
            INNER JOIN (
                SELECT Pool_Status_Changes.Participant_ID,  MAX(Date_Changed) AS maxdate 
                FROM Pool_Status_Changes WHERE Active=1
            AND Date_Changed<='$year-$end_dates_arr[$counter]'  GROUP BY Pool_Status_Changes.Participant_ID
            ) ms ON  Pool_Status_Changes.Participant_ID = ms.Participant_ID AND Date_Changed = maxdate 
            WHERE Active=1 AND
            Date_Changed<='$year-$end_dates_arr[$counter]' 
            GROUP BY Active;";
       // echo $get_current_status;
       $current_active=mysqli_query($cnnSWOP, $get_current_status_sqlsafe);
       $current=mysqli_fetch_row($current_active);
       echo $current[0];
    ?></td>
        <td class="all_projects"><?
        /* get people added to the pool for the first time in this quarter */
        $new_members_sqlsafe="SELECT COUNT(Pool_Status_Changes.Participant_ID) as num_participants
            FROM Pool_Status_Changes 
            INNER JOIN (
                SELECT Pool_Status_Changes.Participant_ID,  MIN(Date_Changed) AS firstdate 
                FROM Pool_Status_Changes WHERE Date_Changed>='$year-$start' AND 
                Date_Changed<='$year-$end_dates_arr[$counter]'
                GROUP BY Pool_Status_Changes.Participant_ID
            ) ms ON  Pool_Status_Changes.Participant_ID = ms.Participant_ID AND Date_Changed = firstdate
            WHERE Active=1;";
       // echo $new_members;
        $members=mysqli_query($cnnSWOP, $new_members_sqlsafe);
       $member_num=mysqli_fetch_row($members);
       echo $member_num[0];?></td>
        
        <td class="all_projects"><?
        /* get people exited from pool in this quarter. */
        $all_exits_sqlsafe="SELECT COUNT(*) FROM Pool_Outcomes WHERE Date_Exited>='$year-$start' AND Date_Exited<='$year-$end_dates_arr[$counter]';";
            $exiters=mysqli_query($cnnSWOP, $all_exits_sqlsafe);
       $exits=mysqli_fetch_row($exiters);
       echo $exits[0];?></td>
        
        <td class="all_projects"><?
        /* get people who were deactivated from the pool in this quarter */
        $deactivated_members_sqlsafe="SELECT COUNT(Active) as count  
            FROM Pool_Status_Changes 
            INNER JOIN (
                SELECT Pool_Status_Changes.Participant_ID,  MAX(Date_Changed) AS maxdate 
                FROM Pool_Status_Changes WHERE Date_Changed<='$year-$end_dates_arr[$counter]' AND Date_Changed>='$year-$start' 
                GROUP BY Pool_Status_Changes.Participant_ID
            ) ms ON  Pool_Status_Changes.Participant_ID = ms.Participant_ID AND Date_Changed = maxdate 
            WHERE Active=0
            AND Date_Changed<='$year-$end_dates_arr[$counter]' AND Date_Changed>='$year-$start' 
            GROUP BY Active;";
        $deactivees=mysqli_query($cnnSWOP, $deactivated_members_sqlsafe);
       $deactivee_num=mysqli_fetch_row($deactivees);
       echo $deactivee_num[0];?></td>
        <td class="all_projects"><?
        /* get people who re-entered the pool this quarter (after deactivation) */
        $reactivated_rows_sqlsafe="SELECT *
        FROM Pool_Status_Changes 
        INNER JOIN (
            SELECT Pool_Status_Changes.Participant_ID, Date_Changed as zerodate
            FROM Pool_Status_Changes WHERE Active=0 AND Date_Changed>='$year-$start' AND 
            Date_Changed<='$year-$end_dates_arr[$counter]'
            GROUP BY Pool_Status_Changes.Participant_ID
        ) ms ON  Pool_Status_Changes.Participant_ID = ms.Participant_ID
        WHERE Active=1 AND Date_Changed>zerodate GROUP BY Pool_Status_Changes.Participant_ID;";
        $reactivees=mysqli_query($cnnSWOP, $reactivated_rows_sqlsafe);
       $reactivee_num=mysqli_num_rows($reactivees);
       echo $reactivee_num;
        ?></td></tr>
    <?$counter++;
        }
        ?><tr><td colspan="6"><hr></td></tr><?
    }?>
</table>
<br/><br/>
<?php
include "../../footer.php";
close_all_dbconn();
?>