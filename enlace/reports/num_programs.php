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

include "../include/settings.php";

$num_days_hidden = get_setting($NumDaysHiddenSetting);
//get user's access

$access_array = $USER->program_access($Enlace_id);
$program_string = " WHERE Programs.Program_ID = " . $access_array[0];
foreach ($access_array as $program){
    $program_string .= " OR Programs.Program_ID = " . $program;
}
$participant_program_string = " INNER JOIN Session_Names on Participants_Programs.Program_ID = Session_Names.Session_ID WHERE (Session_Names.Program_ID = " . $access_array[0];
foreach ($access_array as $program){
    $participant_program_string .= " OR Session_Names.Program_ID = " . $program;
}
$participant_program_string .= ")";
?>

<script type="text/javascript">
  function update_num_selected() {
    $(".numselected").each(function (idx, span) {
      span.innerHTML = $(".recent_program_checkbox:checked").length + $(".old_program_checkbox:checked").length;
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

    $('.recent_program_checkbox').on('click', update_num_selected);
    $('.old_program_checkbox').on('click', update_num_selected);

    $('#select_all_recent_program_checkboxes').on('click', function () {
        if ($('#select_all_recent_program_checkboxes').attr('checked')) {
            $('.recent_program_checkbox').each( function () {
                $(this).attr('checked', true);
            });
        }
        else {
            $('.recent_program_checkbox').each( function () {
                $(this).attr('checked', false);
            });
        }
        update_num_selected();
    });

    $('#select_all_old_program_checkboxes').on('click', function () {
        if ($('#select_all_old_program_checkboxes').attr('checked')) {
            $('.old_program_checkbox').each( function () {
                $(this).attr('checked', true);
            });
        }
        else {
            $('.old_program_checkbox').each( function () {
                $(this).attr('checked', false);
            });
        }
        update_num_selected();
    });
  });
</script>

<br/>
<!--Div on reports page that shows the program enrollment: -->
<h3>Program Enrollment</h3>
<form action="reports.php" method="post" style="text-align:center;">
    Start Date: <input type="text" class="addDP" name="programs_start_date" id="start_4" value="<?php echo $_POST['programs_start_date']; ?>"></td>
    End Date: <input type="text" class="addDP" name="programs_end_date" id="end_4" value="<?php echo $_POST['programs_end_date']; ?>">
    <?php
        $num_selected = isset($_POST['program_program_select']) ? count($_POST['program_program_select']) : 0;
    ?>
    <div class="popupcontainer popupcontainer-hidden programspopupcontainer">
    <button class="popupdisplay">Select Programs (<span class="numselected"><?php echo $num_selected; ?></span> Selected)</button>
    <div class="popupinner programspopup">
      <div class="programspopupheader">
        <div class="popupclose x-closer">X</div>
        <button class="popupclose">Select Programs (<span class="numselected"><?php echo $num_selected; ?></span> Selected)</button>
      </div>
    <div>

    <input type="checkbox" id="select_all_recent_program_checkboxes"> <b>Select All Recent</b><br>
<?php
    $checked_programs = [];
    $program_string = " WHERE (Programs.Program_ID = " . $access_array[0];
    foreach ($access_array as $program){
        $program_string .= " OR Programs.Program_ID = " . $program;
    }
    $program_string .= ")";
    $old_date = date("Y-m-d", strtotime("-$num_days_hidden days"));
    $get_all_programs_recent = "SELECT Session_ID, Session_Name, Name, Session_Names.End_Date FROM Session_Names INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID " . $program_string . " AND Session_Names.End_Date > '$old_date' ORDER BY Name";

    include "../include/dbconnopen.php";
    $all_programs = mysqli_query($cnnEnlace, $get_all_programs_recent);
    $checkbox_count = 0;
    while ($program = mysqli_fetch_row($all_programs)) {
        $checkbox_count++;
        ?>

        <input type="checkbox" name="program_program_select[]" class="recent_program_checkbox" id="program_checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
        <?php
        if ($_POST['program_program_select'] && in_array($program[0], $_POST['program_program_select'])) {
            $checked_programs[$program[0]] = ['name' => $program[2], 'session_name' => $program[1], 'end_date' => $program[3]];
            echo 'checked="true"';
        }
        ?>><?php
               echo "<label for=\"program_checkbox_" . $checkbox_count . "\">" . $program[2] . "--" . $program[1] . "</label><br>";
           }
           include "../include/dbconnclose.php";

    ?>
    <hr>
    <input type="checkbox" id="select_all_old_program_checkboxes"> <b>Select All Old</b><br>
    <?php
    $get_all_programs_old = "SELECT Session_ID, Session_Name, Name, Session_Names.End_Date FROM Session_Names INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID " . $program_string . " AND Session_Names.End_Date <= '$old_date' ORDER BY Name";

    include "../include/dbconnopen.php";
    $all_programs = mysqli_query($cnnEnlace, $get_all_programs_old);
    while ($program = mysqli_fetch_row($all_programs)) {
        $checkbox_count++;
        ?>

        <input type="checkbox" name="program_program_select[]" class="old_program_checkbox" id="program_checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
        <?php
        if ($_POST['program_program_select'] && in_array($program[0], $_POST['program_program_select'])) {
            $checked_programs[$program[0]] = ['name' => $program[2], 'session_name' => $program[1], 'end_date' => $program[3]];
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
    <input type="submit" name="program_submitbtn" value="Show Results">
</form>

<!--View results without month and year set: -->
<?php if (!isset($_POST['program_submitbtn'])) { ?>

    <h4>Results based on the current database information</h4>
    <table class="all_projects">
        <tr>
            <th>Program Name</th>
            <th>Session Name</th>
            <th>Total enrollment</th>
            <th>Total dropped</th>
            <th>Current enrollment</th>
        </tr>
        <?php
            //get user's programs
         $all_progs = "SELECT Name, Session_Name, Session_ID, COUNT(Participant_ID), Session_Names.End_Date FROM Session_Names
                            INNER JOIN Participants_Programs ON Participants_Programs.Program_ID = Session_ID 
                            INNER JOIN Programs ON Session_Names.Program_Id = Programs.Program_ID 
                            " . $program_string . "
                            AND Participant_ID > 0
                            GROUP BY Session_ID;";
        include "../include/dbconnopen.php";
        $all_programs = mysqli_query($cnnEnlace, $all_progs);
        while ($program = mysqli_fetch_row($all_programs)) {
            if(strtotime($program[4]) > strtotime("-$num_days_hidden days")) {
            ?>
                <tr><td class="all_projects"><?php echo $program[0] ?></td>
                    <td class="all_projects"><?php echo $program[1] ?></td>
                    <td class="all_projects">
                        <?php
                        //just get the count of people in this session.
                        $total_enrolled = "SELECT COUNT(*) FROM Participants_Programs WHERE Program_ID=$program[2] AND Participant_ID > 0";
                        $all_enrolled = mysqli_query($cnnEnlace, $total_enrolled);
                        $enrolled = mysqli_fetch_row($all_enrolled);
                        echo $enrolled[0];
                        ?>
                    </td>
                    <td class="all_projects">
                        <?php
                        //count of people who've dropped
                        $total_dropped = "SELECT COUNT(*) FROM Participants_Programs WHERE Program_ID=$program[2] AND Participant_ID > 0 AND Date_Dropped IS NOT NULL";
                        $all_dropped = mysqli_query($cnnEnlace, $total_dropped);
                        $dropped = mysqli_fetch_row($all_dropped);
                        echo $dropped[0];
                        ?>
                    </td>
                    <td class="all_projects">
                        <?php
                        //count of people remaining in the session
                        $total_current = "SELECT COUNT(*) FROM Participants_Programs WHERE Program_ID=$program[2] AND Participant_ID > 0 AND Date_Dropped IS NULL";
                        $all_current = mysqli_query($cnnEnlace, $total_current);
                        $current = mysqli_fetch_row($all_current);
                        echo $current[0];
                        ?>
                    </td>
                </tr>
            <?php
            }
        }
        include "../include/dbconnclose.php";
        ?>
        <tr>
            <td class="all_projects" colspan="2"><strong>Total number of students per category:</strong><br>
                <span class="helptext">(this row counts each participant only once, no matter how many programs s/he is involved in)</span>
            </td>
            <td class="all_projects"><?php
            //get distinct participants, then count rows
            //get user's programs
            $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs " . $participant_program_string . " AND Participant_ID > 0";
                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?></td>
            <td class="all_projects"><?php
                //get distinct participants, then count rows
                $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs "
                            . $participant_program_string . " AND Participant_ID > 0 AND Date_Dropped IS NOT NULL;";
                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?></td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                //get user's programs
                $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs "
                            . $participant_program_string . " AND Participant_ID > 0 AND Date_Dropped IS NULL;";
                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?></td>
        </tr>

        <tr>
            <td class="all_projects" colspan="2"><strong>Total for all programs:</strong><br>
                <span class="helptext">(this row counts each participant once per program of involvement)</span>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                //get user's programs
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs " . $participant_program_string . " AND Participant_ID > 0";
                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs " . $participant_program_string
                    . " AND Participant_ID > 0 AND Date_Dropped IS NOT NULL;";
                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                //get user's programs
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs "
                    . $participant_program_string . " AND Participant_ID > 0 AND Date_Dropped IS NULL;";
                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?>
            </td></tr>
    </table>
    <?php
    /* see results with month and year selected: */
} else {
    ?>
    <?php
        include "../include/dbconnopen.php";
        $start_date_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['programs_start_date']);
        $end_date_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_POST['programs_end_date']);

        $date_select_query_str = '';
        if($start_date_sqlsafe != '') {
            if ($end_date_sqlsafe != '') {
                $results_string = "Results between $start_date_sqlsafe and $end_date_sqlsafe";
                $date_select_query_str = " AND Session_Names.Start_Date BETWEEN '$start_date_sqlsafe' AND '$end_date_sqlsafe'
                                          AND Session_Names.End_Date BETWEEN '$start_date_sqlsafe' AND '$end_date_sqlsafe'";
            }
            else {
                $results_string = "Results after $start_date_sqlsafe";
                $date_select_query_str = " AND Session_Names.Start_Date >= '$start_date_sqlsafe' AND
                                          Session_Names.End_Date >= '$start_date_sqlsafe'";
            }
        }
        else if ($end_date_sqlsafe != '') {
            $results_string = "Results before $end_date_sqlsafe";
            $date_select_query_str = " AND Session_Names.Start_Date <= '$end_date_sqlsafe' AND
                                      Session_Names.End_Date <= '$end_date_sqlsafe'";
        }
    ?>
    <h3><?php echo $results_string ?></h3>
    <table class="all_projects">
        <tr>
            <th>Program Name</th>
            <th>Session Name</th>
            <th>Session End Date</th>
            <th>Total enrollment</th>
            <th>Total dropped</th>
            <th>Current enrollment</th>
        </tr>
        <?php
        //get user's programs culled by inputted program id

        $session_querystring = " ";
        foreach ($_POST['program_program_select'] as $session) {
            $session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $session);
            // if the querystring has begun:
            if ($session_querystring != " " ) {
                $session_querystring .= " OR Session_Names.Session_ID = " . $session_sqlsafe;
            }
            else {
                // The first addition to the querystring:
                $session_querystring .= " AND (Session_Names.Session_ID = " . $session_sqlsafe;
            }
        }
        if ($session_querystring != " " ) {
            $session_querystring .= ")";
        }

        $all_progs = "SELECT Name, Session_List.Session_Name, Session_List.Session_ID, Session_List.End_Date FROM Session_Names as Session_List INNER JOIN Participants_Programs ON Participants_Programs.Program_ID = Session_List.Session_ID INNER JOIN Programs ON Session_List.Program_Id = Programs.Program_ID " . $participant_program_string . $session_querystring . $date_select_query_str . " AND Participant_ID > 0 GROUP BY Session_ID;";

        $all_programs = mysqli_query($cnnEnlace, $all_progs);
        while ($program = mysqli_fetch_row($all_programs)) {

            unset($checked_programs[$program[2]]);
            ?>
            <tr>
                <td class="all_projects"><?php echo $program[0]; ?></td>
                <td class="all_projects"><?php echo $program[1]; ?></td>
                <td class="all_projects"><?php echo $program[3]; ?></td>
                <td class="all_projects">
                    <?php
            //get user's programs
            $total_enrolled = "SELECT COUNT(*) FROM Participants_Programs INNER JOIN Session_Names ON Session_Names.Session_ID = Participants_Programs.Program_ID WHERE Participants_Programs.Program_ID = " . $program[2] . " AND Participant_ID > 0 " . $date_select_query_str;
            $all_enrolled = mysqli_query($cnnEnlace, $total_enrolled);
            $enrolled = mysqli_fetch_row($all_enrolled);
            echo $enrolled[0];
                    ?>
                </td>
                <td class="all_projects">
                    <?php
            //get user's programs
            $total_dropped = "SELECT COUNT(*) FROM Participants_Programs INNER JOIN Session_Names ON Session_Names.Session_ID = Participants_Programs.Program_ID WHERE Participants_Programs.Program_ID = " . $program[2] . " AND Participant_ID > 0 " . $date_select_query_str . " AND Date_Dropped IS NOT NULL";
            $all_dropped = mysqli_query($cnnEnlace, $total_dropped);
            $dropped = mysqli_fetch_row($all_dropped);
            echo $dropped[0];
                    ?>
                </td>
                <td class="all_projects">
                    <?php
            //echo total remaining (at the selected month and year)
            $total_current = "SELECT COUNT(*) FROM Participants_Programs INNER JOIN Session_Names ON Session_Names.Session_ID = Participants_Programs.Program_ID WHERE Participants_Programs.Program_ID = " . $program[2] . " AND Participant_ID > 0 " . $date_select_query_str . " AND Date_Dropped IS NULL";

            $all_current = mysqli_query($cnnEnlace, $total_current);
            $current = mysqli_fetch_row($all_current);
            echo $current[0];
                    ?>
                </td>
            </tr>
            <?php
        }
        foreach ($checked_programs as $id => $checked_program) {
            ?>
                <tr>
                    <td class="all_projects"><?php echo $checked_program['name']; ?></td>
                    <td class="all_projects"><?php echo $checked_program['session_name'] ?></td>
                    <td class="all_projects"><?php echo $checked_program['end_date'] ?></td>
                    <td class="all_projects">0</td>
                    <td class="all_projects">0</td>
                    <td class="all_projects">0</td>
                </tr>
            <?php
        }
        include "../include/dbconnclose.php";
        ?>
        <tr>
            <td class="all_projects" colspan="3"><strong>Total number of students per category:</strong><br>
                <span class="helptext">(this row counts each participant only once, no matter how many programs s/he is involved in)</span>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
        $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . $date_select_query_str . " AND Participant_ID > 0;";
                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs  " . $participant_program_string . $session_querystring . $date_select_query_str . " AND Participant_ID > 0 AND Date_Dropped IS NOT NULL;";

                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . $date_select_query_str . " AND Participant_ID > 0 AND Date_Dropped IS NULL;";

                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?>
            </td>
        </tr>
        <tr>
            <td class="all_projects" colspan="3"><strong>Total for all programs:</strong><br>
                <span class="helptext">(this row counts each participant once per program of involvement)</span>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . $date_select_query_str . " AND Participant_ID > 0;";

                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . $date_select_query_str . " AND Participant_ID > 0 AND Date_Dropped IS NOT NULL;";

                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . $date_select_query_str . " AND Participant_ID > 0 AND Date_Dropped IS NULL;";

                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?></td>
        </tr>
    </table>
    <?php
}
?>
