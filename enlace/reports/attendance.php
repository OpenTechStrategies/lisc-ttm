<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015, 2017  Local Initiatives Support Corporation (lisc.org)
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
include "../include/settings.php";

$num_days_hidden = get_setting($NumDaysHiddenSetting);
//get user's access
$access_array = $USER->program_access($Enlace_id);
$program_string = " WHERE Programs.Program_ID = " . $access_array[0];
foreach ($access_array as $program){
    $program_string .= " OR Programs.Program_ID = " . $program;
}
include_once("../include/dosage_percentage.php");
?>
<script type="text/javascript">
  function update_attendance_num_selected() {
    $(".numattendanceselected").each(function (idx, span) {
      span.innerHTML = $(".recent_attendance_program_checkbox:checked").length + $(".old_attendance_program_checkbox:checked").length;
    });
  }

$(document).ready(function() {
    $(".popupcontainer .popupclose").each(function(idx, closer) {
      $(closer).on("click", function() {
          $(closer).closest(".popupcontainer").addClass("popupcontainer-hidden");
          return false;
      });
    });

    $(".popupcontainer .popupdisplay").each(
      function(idx, display) {
        $(display).on("click", function() {
          $(display).closest(".popupcontainer").removeClass("popupcontainer-hidden");
          return false;
        });
        });

    $('.recent_attendance_program_checkbox').on('click', update_attendance_num_selected);
    $('.old_attendance_program_checkbox').on('click', update_attendance_num_selected);

    $('#select_all_recent_attendance_checkboxes').on('click', function () {
        if ($('#select_all_recent_attendance_checkboxes').attr('checked')) {
            $('.recent_attendance_program_checkbox').each( function () {
                $(this).attr('checked', true);
            });
        }
        else {
            $('.recent_attendance_program_checkbox').each( function () {
                $(this).attr('checked', false);
            });
        }
        update_attendance_num_selected();
    });

    $('#select_all_old_attendance_checkboxes').on('click', function () {
        if ($('#select_all_old_attendance_checkboxes').attr('checked')) {
            $('.old_attendance_program_checkbox').each( function () {
                $(this).attr('checked', true);
            });
        }
        else {
            $('.old_attendance_program_checkbox').each( function () {
                $(this).attr('checked', false);
            });
        }
        update_attendance_num_selected();
    });
});

</script>
<div style="display: none;">
    <?php include_once("../include/datepicker_wtw.php");?>
</div>

<h3>Attendance Hours</h3>
<form action="reports.php" method="post" style="text-align:center;">

    Start Date: <input type="text" class="addDP" name="start_date" value="<?php echo $_POST['start_date']; ?>"></td>
    End Date: <input type="text" class="addDP" name="end_date" value="<?php echo $_POST['end_date']; ?>">
    <?php
        $num_selected = isset($_POST['attendance_program_select']) ? count($_POST['attendance_program_select']) : 0;
    ?>
    <div class="popupcontainer popupcontainer-hidden programspopupcontainer">
    <button class="popupdisplay">Select Programs (<span class="numattendanceselected"><?php echo $num_selected; ?></span> Selected)</button>
    <div class="popupinner programspopup">
      <div class="programspopupheader">
        <div class="popupclose x-closer">X</div>
        <button class="popupclose">Select Programs (<span class="numattendanceselected"><?php echo $num_selected; ?></span> Selected)</button>
      </div>
    <div>

    <input type="checkbox" id="select_all_recent_attendance_checkboxes"> <b>Select All Recent</b><br>
<?php
    $session_array = [];
    $program_string = " WHERE (Programs.Program_ID = " . $access_array[0];
    foreach ($access_array as $program){
        $program_string .= " OR Programs.Program_ID = " . $program;
    }
    $program_string .= ")";
    $old_date = date("Y-m-d", strtotime("-$num_days_hidden days"));
        $get_recent_programs = "SELECT Session_ID, Session_Name, Name, Session_Names.End_Date FROM Session_Names INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID " . $program_string . " AND Session_Names.End_Date > '$old_date' ORDER BY Name";

        include "../include/dbconnopen.php";
        $all_programs = mysqli_query($cnnEnlace, $get_recent_programs);
        $checkbox_count = 0;
        while ($program = mysqli_fetch_row($all_programs)) {
            $session_array[$program[0]] = array($program[1], $program[2]);
            $checkbox_count++;
            ?>

            <input type="checkbox" name="attendance_program_select[]" class="recent_attendance_program_checkbox" id="program_checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
            <?php
            if ($_POST['attendance_program_select'] && in_array($program[0], $_POST['attendance_program_select'])) {
                echo 'checked="true"';
            }
            ?>><?php
                   echo "<label for=\"program_checkbox_" . $checkbox_count . "\">" . $program[2] . "--" . $program[1] . "</label><br>";
               }
               include "../include/dbconnclose.php";
               ?>
    <hr>
    <input type="checkbox" id="select_all_old_attendance_checkboxes"> <b>Select All Old</b><br>
<?php
    $program_string = " WHERE (Programs.Program_ID = " . $access_array[0];
    foreach ($access_array as $program){
        $program_string .= " OR Programs.Program_ID = " . $program;
    }
    $program_string .= ")";
        $get_old_programs = "SELECT Session_ID, Session_Name, Name, Session_Names.End_Date FROM Session_Names INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID " . $program_string . " AND Session_Names.End_Date <= '$old_date' ORDER BY Name";

        include "../include/dbconnopen.php";
        $all_programs = mysqli_query($cnnEnlace, $get_old_programs);
        $checkbox_count = 0;
        while ($program = mysqli_fetch_row($all_programs)) {
            $session_array[$program[0]] = array($program[1], $program[2]);
            $checkbox_count++;
            ?>

            <input type="checkbox" name="attendance_program_select[]" class="old_attendance_program_checkbox" id="program_checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
            <?php
            if ($_POST['attendance_program_select'] && in_array($program[0], $_POST['attendance_program_select'])) {
                echo 'checked="true"';
            }
            ?>><?php
                   echo "<label for=\"program_checkbox_" . $checkbox_count . "\">" . $program[2] . "--" . $program[1] . "</label><br>";
               }
               include "../include/dbconnclose.php";
               ?>
      </div>
      </div>
    </div>
    Exclude dropped youth: <input type="checkbox" name="dropped" name="dropped" <?php if ($_POST['dropped']) { echo "checked = 'checked'"; } ?>>
    <input type="submit" value="Search" name="attendance_submit_btn"></td>
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
            <th>Missing Attendance</th>
            <th>Enrollment per session</th>
            <th>Dosage hours</th>
        </tr>
<?php
        // loop through selected sessions here
        $total_hours = 0;
        $total_enrollment = 0;
        $session_querystring = " ";
        $counter = 0;
        include "../include/dbconnopen.php";
        $end_date_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['end_date']);
        $start_date_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['start_date']);
        if ($_POST['dropped']) {
            $dropped_sqlsafe = true;
        }
        foreach ($_POST['attendance_program_select'] as $session ) {
            include "../include/dbconnopen.php";
            $session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $session);
            // The session's enrollment should only be added to the
            // total and unique enrollment if the session met during the
            // selected date range.  See #183.  The $session_querystring
            // is only used to calculate the unique enrollment.
            $include_session = check_session_dates ($session_sqlsafe, $start_date_sqlsafe, $end_date_sqlsafe, $cnnEnlace);
            if ($include_session) {
                // if the querystring has begun:
                if ($session_querystring != " " ) {
                    $session_querystring .= " OR Program_ID = " . $session_sqlsafe;
                }
                else {
                    // The first addition to the querystring:
                    $session_querystring .= " AND (Program_ID = " . $session_sqlsafe;
                }
                $dosage_array = calculate_dosage($session_sqlsafe, null, $start_date_sqlsafe, $end_date_sqlsafe, $dropped_sqlsafe);
?>
                <tr <?php if ($dosage_array[4] != 0) { ?>class="unmarked"<?php } ?>>
                <td><?php echo $session_array[$session_sqlsafe][0]; ?></td>
                <td><?php echo $session_array[$session_sqlsafe][1]; ?></td>
                <td><?php echo $dosage_array[4];?></td>
                <td><?php
                // number of enrolled participants in this session
                echo $dosage_array[3];?></td>
                <td><?php echo $dosage_array[1];?></td>
                </tr>
<?php
                $total_hours = $total_hours + $dosage_array[1];
                $total_enrollment = $total_enrollment + $dosage_array[3];
            }
            $counter++;
        }
            if ($session_querystring != " " ) {
                $session_querystring .= ")";
            }

if ($_POST['attendance_program_select']) {
?>
             <tr>
            <td class="all_projects"></td>
            <td class="all_projects"></td>
            <td class="all_projects"></td>
            <td class="all_projects">Total enrollment: </td>
            <td class="all_projects"><b><?php echo $total_enrollment; ?></b></td>
            </tr>
             <tr>
            <td class="all_projects"></td>
            <td class="all_projects"></td>
            <td class="all_projects"></td>
            <td class="all_projects">Unique enrollment: </td>
            <td class="all_projects"><b>
<?php
// Only count unique enrollees in sessions that met during the selected
// date range, which is taken care of in the creation of the
// $session_querystring created above.  If the session_querystring is
// empty, then no sessions have been selected or no selected sessions
// met during the selected date range, so there are no relevant
// enrollees.

if ( $session_querystring != " ") {
    if (! $dropped_sqlsafe) {
        $unique_enrollees_query = "SELECT COUNT(DISTINCT Participant_ID) FROM 
        Participants_Programs WHERE ( Program_ID IS NOT NULL AND
        Participant_ID > 0) " . $session_querystring;
    }
    else {
        // exclude dropped youth
        $unique_enrollees_query = "SELECT COUNT(DISTINCT Participant_ID) FROM 
        Participants_Programs WHERE ( Program_ID IS NOT NULL AND
        Participant_ID > 0) AND (Date_Dropped IS NULL OR Date_Dropped > 
        '$end_date_sqlsafe') " . $session_querystring;
    }
    include "../include/dbconnopen.php";
    $unique_enrollees_result = mysqli_query($cnnEnlace, $unique_enrollees_query);
    $unique_enrollees_array=mysqli_fetch_row($unique_enrollees_result);
    $unique_enrollees = $unique_enrollees_array[0];
}
else {
    $unique_enrollees = 0;
}
echo $unique_enrollees;
?>
            </b>
            </td>
            </tr>
             <tr>
            <td class="all_projects"></td>
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

/*
 * Takes a session, a date range, and a database connection pointer.
 * Returns a boolean indicating whether the session had a meeting during
 * that date range.
 *
 * This function needs the database connection to be open.  
*/
function check_session_dates ( $session_id_sqlsafe, $start_date_sqlsafe, $end_date_sqlsafe, $cnnEnlace ) {
    // Note: the Program_Dates table has the session_id in the
    // Program_ID column
    $count_dates_query = "SELECT COUNT(*) FROM Program_Dates WHERE Program_ID =
                          '$session_id_sqlsafe' AND Date_Listed >=
                          '$start_date_sqlsafe' AND Date_Listed <=
                          '$end_date_sqlsafe';";
    $date_count_result = mysqli_query($cnnEnlace, $count_dates_query);
    $date_count_array=mysqli_fetch_row($date_count_result);
    $date_count = $date_count_array[0];
    if ( $date_count > 0 ) {
        return True;
    }
    else {
        return False;
    }
    
}

?>