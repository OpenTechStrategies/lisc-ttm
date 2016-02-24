<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($Enlace_id);
//get user's access
$program_string ="";
include_once("../include/dosage_percentage.php");
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#start_1').on('change', function () {
        $('#start_2').val($('#start_1').val());
    });
    $('#end_1').on('change', function () {
        $('#end_2').val($('#end_1').val());
    });
});

</script>
<div style="display: none;">
    <?php include_once("../include/datepicker_wtw.php");?>
</div>

<h3>Attendance Hours</h3>
<form action="reports.php" method="post">
    <table class="all_projects">
    <tr><td>
    <span id="attendance_sessions_toggler" style="font-weight: bold; text-decoration: underline; cursor: pointer;">
    Show/hide options:
    </span>
    </td>
    <th class="hide_unchecked"> Start date: </th>
    <td class="hide_unchecked"><input type="text" class="addDP" id="start_1" value="<?php echo $_POST['start_date']; ?>"></td>
    <th class="hide_unchecked"> End date: </th>
    <td class="hide_unchecked"><input type="text" class="addDP" id="end_1" value="<?php echo $_POST['end_date']; ?>"></td>
    <td class="hide_unchecked"><input type="submit" value="Search" name="attendance_submit_btn"></td>
    </tr>
    <tr>
    <td> <div id="attendance_sessions"> <br \ >
    <span class="hide_unchecked"><input type="checkbox" id="select_all_attendance_checkboxes" > <b>Select all</b> <br></span>
    <br \ >
<?php
            //get user's programs
         $all_progs = "SELECT Session_ID, Name, Session_Name, COUNT(Participant_ID) FROM Session_Names 
                            INNER JOIN Participants_Programs ON Participants_Programs.Program_ID = Session_ID 
                            INNER JOIN Programs ON Session_Names.Program_Id = Programs.Program_ID 
                            GROUP BY Session_ID ORDER BY Name;";
        include "../include/dbconnopen.php";
        $all_programs = mysqli_query($cnnEnlace, $all_progs);
        $checkbox_count = 0;
        $session_array = [];
        while ($program = mysqli_fetch_row($all_programs)) {
            $session_array[$program[0]] = array($program[1], $program[2]);
            $checkbox_count++;
            ?>
            <span <?php if ($_POST['attendance_program_select']) {
                echo (in_array($program[0], $_POST['attendance_program_select']) ?  null : 'class="hide_unchecked"');
            } ?>>
            <input type="checkbox" name="attendance_program_select[]" id="checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
            <?php
            if ($_POST['attendance_program_select']) {
                echo (in_array($program[0], $_POST['attendance_program_select']) ? 'checked="true"' : null);
            }
            ?>><?php
                   echo "<label for=\"checkbox_" . $checkbox_count . "\">" . $program[1] . " -- <b>" . $program[2] . "</b></label><br></span>";
               }
        ?>
</div>
</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<th></th>
<th>Start date: </th>
<td><input type="text" class="addDP" name="start_date" id="start_2" value="<?php echo $_POST['start_date']; ?>"></td>
<th> End date: </th>
<td><input type="text" class="addDP" name="end_date" id="end_2" value="<?php echo $_POST['end_date']; ?>"></td>
<td><input type="submit" value="Search" name="attendance_submit_btn"></td>
</tr>
</table>
</form>
&nbsp
<?php
    if ($_POST) {
        if (! $_POST['start_date'] || ! $_POST['end_date']) {
            ?>
            <div style="color: red; font-weight: bold;">Please choose a start and end date.</div>
            <?php
        }
        else {
?>
<table class="all_projects">
        <tr>
            <th>Program name</th>
            <th>Session name</th>
            <th>Enrollment per session</th>
            <th>Dosage hours</th>
        </tr>
<?php
        // loop through selected sessions here
        $total_hours = 0;
        $total_enrollment = 0;
        $session_querystring = " ";
        $counter = 0;
        $end_date_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['end_date']);
        $start_date_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['start_date']);
        foreach ($_POST['attendance_program_select'] as $session ) {
            $session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $session);
            if ($counter != 0) {
                $session_querystring .= " OR Program_ID = " . $session_sqlsafe;
            }
            else {
                $session_querystring .= " AND (Program_ID = " . $session_sqlsafe;
            }
            $dosage_array = calculate_dosage($session_sqlsafe, null, $start_date_sqlsafe, $end_date_sqlsafe);
            ?>
            <tr>
            <td><?php echo $session_array[$session_sqlsafe][0]; ?></td>
            <td><?php echo $session_array[$session_sqlsafe][1]; ?></td>
            <td><?php echo $dosage_array[3];?></td>
            <td><?php echo $dosage_array[1];?></td>
            </tr>
            <?php
            $total_hours = $total_hours + $dosage_array[1];
            $total_enrollment = $total_enrollment + $dosage_array[3];
            $counter++;
        }
            if ($session_querystring != " " ) {
                $session_querystring .= ")";
            }

if ($_POST['attendance_program_select']) {
?>
             <tr>
            <td class="all_projects"></td>
            <td class="all_projects">Total enrollment: </td>
            <td class="all_projects"><b><?php echo $total_enrollment; ?></b></td>
            <td class="all_projects"></td>
            </tr>
             <tr>
            <td class="all_projects"></td>
            <td class="all_projects">Unique enrollment: </td>
            <td class="all_projects"><b>
<?php
$unique_enrollees_query = "select count(distinct Participant_ID) from Participants_Programs WHERE (
 Program_ID is not null and
 Participant_ID > 0) " . $session_querystring;
$unique_enrollees_result = mysqli_query($cnnEnlace, $unique_enrollees_query);
$unique_enrollees_array=mysqli_fetch_row($unique_enrollees_result);
$unique_enrollees = $unique_enrollees_array[0];
echo $unique_enrollees;
?>
            </b>
            </td>
            </tr>
             <tr>
            <td class="all_projects"></td>
            <td class="all_projects"></td>
            <td class="all_projects">Total hours:</td>
            <td class="all_projects"><b> <?php echo $total_hours; ?></b></td>
</tr>
<?php
include "../include/dbconnclose.php";

// end of if-sessions-chosen conditional
}
?>
</table>
<?php

// end of dates-chosen else
        }
// end of "POST" if
    }
?>