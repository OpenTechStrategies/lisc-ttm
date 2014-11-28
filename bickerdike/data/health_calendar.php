<?php

include "../../header.php";
include "../header.php";
?>

<!--Shows the program dates that have been entered into the system in calendar format.-->

<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
	});
</script>
<div class="content_wide">
<h3>Health Calendar</h3>

<!--<table>
    <tr>
        <th>Program Name</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
</table>-->
<hr/><br/>
<!--Total number of programs available:


<table>
    <tr>
        <th>Sunday</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
    </tr>
    
</table>-->


<!--I used a template from the internet (see source) to build a calendar.-->

<?php
//http://keithdevens.com/software/php_calendar
date_default_timezone_set('America/Chicago');
$time = time();
$today = date('j', $time);
$days = array($today => array(null, null,'<div id="today">' . $today . '</div>'));
$pn = array('&laquo;' => date('n', $time) - 1, '&raquo;' => date('n', $time) + 1);
echo generate_calendar(date('Y', $time), date('n', $time), $days, 3, null, 0);
echo  date('n', $time)+1;
// PHP Calendar (version 2 . 3), written by Keith Devens
// http://keithdevens . com/software/php_calendar
//  see example at http://keithdevens . com/weblog
// License: http://keithdevens . com/software/license

function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array())
{
    $first_of_month = gmmktime(0, 0, 0, $month, 1, $year);
    // remember that mktime will automatically correct if invalid dates are entered
    // for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
    // this provides a built in "rounding" feature to generate_calendar()

    $day_names = array(); //generate all the day names according to the current locale
    for ($n = 0, $t = (3 + $first_day) * 86400; $n < 7; $n++, $t+=86400) //January 4, 1970 was a Sunday
        $day_names[$n] = ucfirst(gmstrftime('%A', $t)); //%A means full textual day name

    list($month, $year, $month_name, $weekday) = explode(',', gmstrftime('%m, %Y, %B, %w', $first_of_month));
    $weekday = ($weekday + 7 - $first_day) % 7; //adjust for $first_day
    //echo $weekday;
    $title   = htmlentities(ucfirst($month_name)) . $year;  //note that some locales don't capitalize month and day names

    //Begin calendar .  Uses a real <caption> .  See http://diveintomark . org/archives/2002/07/03
    @list($p, $pl) = each($pn); @list($n, $nl) = each($pn); //previous and next links, if applicable
    if($p) $p = '<span class="calendar-prev">' . ($pl ? '<a href="' . htmlspecialchars($pl) . '">' . $p . '</a>' : $p) . '</span>&nbsp;';
    if($n) $n = '&nbsp;<span class="calendar-next">' . ($nl ? '<a href="' . htmlspecialchars($nl) . '">' . $n . '</a>' : $n) . '</span>';
    $calendar = "<div class=\"mini_calendar\">\n<table id=health_calendar_table>" . "\n" . 
        '<caption class="calendar-month">' . $p . ($month_href ? '<a href="' . htmlspecialchars($month_href) . '">' . $title . '</a>' : $title) . $n . "</caption>\n<tr>";

    if($day_name_length)
    {   //if the day names should be shown ($day_name_length > 0)
        //if day_name_length is >3, the full name of the day will be printed
        foreach($day_names as $d)
            $calendar  .= '<th abbr="' . htmlentities($d) . '">' . htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d) . '</th>';
        $calendar  .= "</tr>\n<tr>";
    }

    if($weekday > 0) 
    {
        for ($i = 0; $i < $weekday; $i++) 
        {
            $calendar  .= '<td class=all_projects>&nbsp;</td>'; //initial 'empty' days (days before the first of the month)
        }
    }
    
    $weekday=$weekday+1;
    for($day = 1, $days_in_month = gmdate('t',$first_of_month); $day <= $days_in_month; $day++, $weekday++)
            //for each day, if a program was meeting that day, view the program names on each day.
    {
        date_default_timezone_set('America/Chicago');
        $time = time();
        $this_date = date('Y', $time) . "-" . date('m', $time) . "-" . $day;
        $get_program_names_sqlsafe = "SELECT * FROM Programs LEFT JOIN (Program_Dates)
                                ON (Program_Dates.Program_ID=Programs.Program_ID) WHERE Program_Dates.Program_Date='" . $this_date . "'";
        //echo $get_program_names_sqlsafe . "<br>";
        include "../include/dbconnopen.php";
        $programs = mysqli_query($cnnBickerdike, $get_program_names_sqlsafe);
        $names = array();
        while ($program=mysqli_fetch_array($programs)){
            $names[] = $program['Program_Name'];
        }
        if($weekday == 7)
        {
            $weekday   = 0; //start a new week
            $calendar  .= "<td class=all_projects><strong>" . $day ."</strong> <br><span class=health_event>";
            for ($program=0; $program<count($names); $program++){
                $calendar .=$names[$program] . "<br><br>";
            }
            $calendar .= "<br></span></td></tr>\n<tr>";
        }
        else {$calendar  .= "<td class=all_projects><strong>" . $day ."</strong> <br><span class=health_event>";
        for ($program=0; $program<count($names); $program++){
                $calendar .=$names[$program] . "<br><br>";
            }
        $calendar .= "<br></span></td>";
        }
        include "../include/dbconnclose.php";
    }
    if($weekday != 7) $calendar  .= '<td id="emptydays" colspan="' . (7-$weekday) . '"  class=all_projects>&nbsp;</td>'; //remaining "empty" days

    return $calendar . "</tr>\n</table>\n</div>\n";
}
?>
</div>
<? include "../../footer.php"; ?>
