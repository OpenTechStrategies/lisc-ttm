<?php
require_once("../siteconfig.php");
?>
<?php

/*Obsolete.  Users decided not to use this report.*/

include "../../header.php";
include "../header.php";
$months=array(1=>'1: 2012-13',
   2=>'2: 2012-13',
    3=>'3: 2012-13',
    4=>'4: 2012-13',
    5=>'1: 2013-14',
    6=>'2: 2013-14',
    7=>'3: 2013-14',
    8=>'4: 2013-14',
    9=>'1: 2014-15',
    10=>'2: 2014-15',
    11=>'3: 2014-15',
    12=>'4: 2014-15');
?>
<br>
<span class="helptext">Note that this table only includes programs that have participants enrolled and recorded in the database.</span>
<table class="all_projects">
    <col width="100px">
<!--    <col>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col>-->
    <tr><th>Quarter</th><th>GPA Min</th><th>GPA Max</th><th>GPA Average</th><th>Attendance (rate)</th><th>Number of office referrals</th>
        <th>Number of in-school suspensions</th><th>Number of out-of-school suspensions</th><th>Number of expulsions</th><th>Percent participants
            on track</th></tr>
    <?
    include "../include/dbconnopen.php";
//    foreach ($months as $month_num=>$month){
//        ?>
    <tr><td class="all_projects"><?echo $month?></td>
        <td class="all_projects"><?//count number of events
//        $num_events="SELECT COUNT(*) FROM Campaigns_Events WHERE MONTH(Event_Date)=" . $month_num;
//        $events=mysqli_query($cnnEnlace, $num_events);
//        $num_eve=mysqli_fetch_row($events);
//        echo $num_eve[0];
//        ?></td>
        <td class="all_projects"></td>
        <td class="all_projects">
            <?//count number of people with non-zero role types
//        $num_events="SELECT COUNT(*) FROM Participants_Events INNER JOIN Campaigns_Events
//            ON Participants_Events.Event_ID=Campaign_Event_ID WHERE MONTH(Event_Date)=$month_num AND Role_Type!=0;";
//        $events=mysqli_query($cnnEnlace, $num_events);
//        $num_eve=mysqli_fetch_row($events);
//        echo $num_eve[0];
//        ?>
        </td>
        <td class="all_projects">
            <?//count number of people with non-zero role types
//        $num_events="SELECT COUNT(*) FROM Participants_Events INNER JOIN Campaigns_Events
//            ON Participants_Events.Event_ID=Campaign_Event_ID WHERE MONTH(Event_Date)=$month_num AND Role_Type=0;";
//        $events=mysqli_query($cnnEnlace, $num_events);
//        $num_eve=mysqli_fetch_row($events);
//        echo $num_eve[0];
//        ?>
        </td>
    </tr>
            <?
//    }
    include "../include/dbconnclose.php";
?>
</table>