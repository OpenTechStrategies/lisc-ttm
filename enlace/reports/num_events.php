<?php


/*Obsolete.  Users decided not to use this report.*/

include "../../header.php";
include "../header.php";
$months=array(1=>January,
   2=>February,
    3=>March,
    4=>April,
    5=>May,
    6=>June,
    7=>July,
    8=>August,
    9=>September,
    10=>October,
    11=>November,
    12=>December);
?>
<br>
<span class="helptext">Note that this table only includes programs that have participants enrolled and recorded in the database.</span>
<table class="all_projects">
    <tr><th>Month</th><th>Number of events</th><th>Number of Institutions Involved</th><th>Number of Volunteers</th><th>Number of Attendees</th></tr>
    <?
    include "../include/dbconnopen.php";
    foreach ($months as $month_num=>$month){
        ?>
    <tr><td class="all_projects"><?echo $month?></td>
        <td class="all_projects"><?//count number of events
        $num_events="SELECT COUNT(*) FROM Campaigns_Events WHERE MONTH(Event_Date)=" . $month_num;
        $events=mysqli_query($cnnEnlace, $num_events);
        $num_eve=mysqli_fetch_row($events);
        echo $num_eve[0];
        ?></td>
        <td class="all_projects"></td>
        <td class="all_projects">
            <?//count number of people with non-zero role types
        $num_events="SELECT COUNT(*) FROM Participants_Events INNER JOIN Campaigns_Events
            ON Participants_Events.Event_ID=Campaign_Event_ID WHERE MONTH(Event_Date)=$month_num AND Role_Type!=0;";
        $events=mysqli_query($cnnEnlace, $num_events);
        $num_eve=mysqli_fetch_row($events);
        echo $num_eve[0];
        ?>
        </td>
        <td class="all_projects">
            <?//count number of people with non-zero role types
        $num_events="SELECT COUNT(*) FROM Participants_Events INNER JOIN Campaigns_Events
            ON Participants_Events.Event_ID=Campaign_Event_ID WHERE MONTH(Event_Date)=$month_num AND Role_Type=0;";
        $events=mysqli_query($cnnEnlace, $num_events);
        $num_eve=mysqli_fetch_row($events);
        echo $num_eve[0];
        ?>
        </td>
    </tr>
            <?
    }
    include "../include/dbconnclose.php";
?>
</table>