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
      span.innerHTML = $(".program_checkbox:checked").length;
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

    $('.program_checkbox').on('click', update_num_selected);

    $('#select_all_program_checkboxes').on('click', function () {
        if ($('#select_all_program_checkboxes').attr('checked')) {
            $('.program_checkbox').each( function () {
                $(this).attr('checked', true);
            });
        }
        else {
            $('.program_checkbox').each( function () {
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
    <!--
    Sort enrollment by month and year (according to when participants where added to the session in the DB)
    -->
    <select name="month_select">
        <option>Select a month</option>
        <option value="1" <?php echo($_POST['month_select'] == 1 ? 'selected=="selected"' : null) ?>>January</option>
        <option value="2" <?php echo($_POST['month_select'] == 2 ? 'selected=="selected"' : null) ?>>February</option>
        <option value="3" <?php echo($_POST['month_select'] == 3 ? 'selected=="selected"' : null) ?>>March</option>
        <option value="4" <?php echo($_POST['month_select'] == 4 ? 'selected=="selected"' : null) ?>>April</option>
        <option value="5" <?php echo($_POST['month_select'] == 5 ? 'selected=="selected"' : null) ?>>May</option>
        <option value="6" <?php echo($_POST['month_select'] == 6 ? 'selected=="selected"' : null) ?>>June</option>
        <option value="7" <?php echo($_POST['month_select'] == 7 ? 'selected=="selected"' : null) ?>>July</option>
        <option value="8" <?php echo($_POST['month_select'] == 8 ? 'selected=="selected"' : null) ?>>August</option>
        <option value="9" <?php echo($_POST['month_select'] == 9 ? 'selected=="selected"' : null) ?>>September</option>
        <option value="10" <?php echo($_POST['month_select'] == 10 ? 'selected=="selected"' : null) ?>>October</option>
        <option value="11" <?php echo($_POST['month_select'] == 11 ? 'selected=="selected"' : null) ?>>November</option>
        <option value="12" <?php echo($_POST['month_select'] == 12 ? 'selected=="selected"' : null) ?>>December</option>
    </select>

    <select name="year_select">
        <option>Select a year</option>
        <option <?php echo($_POST['year_select'] == 2012 ? 'selected=="selected"' : null) ?>>2012</option>
        <option <?php echo($_POST['year_select'] == 2013 ? 'selected=="selected"' : null) ?>>2013</option>
        <option <?php echo($_POST['year_select'] == 2014 ? 'selected=="selected"' : null) ?>>2014</option>
        <option <?php echo($_POST['year_select'] == 2015 ? 'selected=="selected"' : null) ?>>2015</option>
    </select>
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

    <input type="checkbox" id="select_all_program_checkboxes"> <b>Select All</b><br>
<?php
    $checked_programs = [];
    $program_string = " WHERE Programs.Program_ID = " . $access_array[0];
    foreach ($access_array as $program){
        $program_string .= " OR Programs.Program_ID = " . $program;
    }
            $get_all_programs = "SELECT Session_ID, Session_Name, Name FROM Session_Names INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID " . $program_string . " ORDER BY Name";

        include "../include/dbconnopen.php";
        $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
        $checkbox_count = 0;
        while ($program = mysqli_fetch_row($all_programs)) {
            $checkbox_count++;
            ?>

            <input type="checkbox" name="program_program_select[]" class="program_checkbox" id="program_checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
            <?php
            if ($_POST['program_program_select'] && in_array($program[0], $_POST['program_program_select'])) {
                $checked_programs[$program[0]] = ['name' => $program[2], 'session_name' => $program[1]];
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
    <input type="submit" name="program_submitbtn" value="Sort by Month and Year">
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
         $all_progs = "SELECT Name, Session_Name, Session_ID, COUNT(Participant_ID) FROM Session_Names 
                            INNER JOIN Participants_Programs ON Participants_Programs.Program_ID = Session_ID 
                            INNER JOIN Programs ON Session_Names.Program_Id = Programs.Program_ID 
                            " . $program_string . "
                            GROUP BY Session_ID;";
        include "../include/dbconnopen.php";
        $all_programs = mysqli_query($cnnEnlace, $all_progs);
        while ($program = mysqli_fetch_row($all_programs)) {
            ?>
            <tr><td class="all_projects"><?php echo $program[0] ?></td>
                <td class="all_projects"><?php echo $program[1] ?></td>
                <td class="all_projects">
                    <?php
                    //just get the count of people in this session.
                    $total_enrolled = "SELECT COUNT(*) FROM Participants_Programs WHERE Program_ID=$program[2]";
                    $all_enrolled = mysqli_query($cnnEnlace, $total_enrolled);
                    $enrolled = mysqli_fetch_row($all_enrolled);
                    echo $enrolled[0];
                    ?>
                </td>
                <td class="all_projects">
                    <?php
                    //count of people who've dropped
                    $total_dropped = "SELECT COUNT(*) FROM Participants_Programs WHERE Program_ID=$program[2] AND Date_Dropped IS NOT NULL";
                    $all_dropped = mysqli_query($cnnEnlace, $total_dropped);
                    $dropped = mysqli_fetch_row($all_dropped);
                    echo $dropped[0];
                    ?>
                </td>
                <td class="all_projects">
                    <?php
                    //count of people remaining in the session
                    $total_current = "SELECT COUNT(*) FROM Participants_Programs WHERE Program_ID=$program[2] AND Date_Dropped IS NULL";
                    $all_current = mysqli_query($cnnEnlace, $total_current);
                    $current = mysqli_fetch_row($all_current);
                    echo $current[0];
                    ?>
                </td>
            </tr>
            <?php
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
            $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs " . $participant_program_string;
                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?></td>
            <td class="all_projects"><?php
                //get distinct participants, then count rows
                $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs "
                            . $participant_program_string . " AND Date_Dropped IS NOT NULL;";
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
                            . $participant_program_string . " AND Date_Dropped IS NULL;";
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
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs " . $participant_program_string;
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
                    . " AND Date_Dropped IS NOT NULL;";
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
                    . $participant_program_string . " AND Date_Dropped IS NULL;";
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
    <h3>Results as of <?php echo $_POST['month_select'] ?>/<?php echo $_POST['year_select'] ?></h3>
    <table class="all_projects">
        <tr>
            <th>Program Name</th>
            <th>Session Name</th>
            <th>Total enrollment</th>
            <th>Total dropped</th>
            <th>Current enrollment</th>
        </tr>
        <?php
        //get all programs that existed in the selected month and year
        include "../include/dbconnopen.php";
        $month_select_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['month_select']);
        $year_select_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['year_select']);
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

        $all_progs = "SELECT Name, Session_List.Session_Name, Session_List.Session_ID, COUNT(Participant_ID) FROM Session_Names as Session_List INNER JOIN Participants_Programs ON Participants_Programs.Program_ID = Session_List.Session_ID INNER JOIN Programs ON Session_List.Program_Id = Programs.Program_ID " . $participant_program_string . $session_querystring . " AND MONTH(Date_Added) <= '" . $month_select_sqlsafe . "' AND YEAR(Date_Added) <= '" . $year_select_sqlsafe . "' GROUP BY Session_ID;";

        $all_programs = mysqli_query($cnnEnlace, $all_progs);
        while ($program = mysqli_fetch_row($all_programs)) {

            unset($checked_programs[$program[2]]);
            ?>
            <tr>
                <td class="all_projects"><?php echo $program[0]; ?></td>
                <td class="all_projects"><?php echo $program[1] ?></td>
                <td class="all_projects">
                    <?php
            //get user's programs
            $total_enrolled = "SELECT COUNT(*) FROM Participants_Programs WHERE Program_ID = " . $program[2]  . " AND MONTH(Date_Added) <= '" . $month_select_sqlsafe . "' AND YEAR(Date_Added) <= '" . $year_select_sqlsafe . "' AND Program_ID = $program[2]";
            $all_enrolled = mysqli_query($cnnEnlace, $total_enrolled);
            $enrolled = mysqli_fetch_row($all_enrolled);
            echo $enrolled[0];
                    ?>
                </td>
                <td class="all_projects">
                    <?php
            //get user's programs
            $total_dropped = "SELECT COUNT(*) FROM Participants_Programs  WHERE Program_ID = " . $program[2]  . " AND MONTH(Date_Dropped)<='" . $month_select_sqlsafe . "' AND YEAR(Date_Dropped)<='" . $year_select_sqlsafe . "' AND Program_ID=$program[2] AND Date_Dropped IS NOT NULL";
            $all_dropped = mysqli_query($cnnEnlace, $total_dropped);
            $dropped = mysqli_fetch_row($all_dropped);
            echo $dropped[0];
                    ?>
                </td>
                <td class="all_projects">
                    <?php
            //echo total remaining (at the selected month and year)
            $total_current = "SELECT COUNT(*) FROM Participants_Programs WHERE Program_ID = " . $program[2]  . " AND MONTH(Date_Added)<='" . $month_select_sqlsafe . "' AND YEAR(Date_Added)<='" . $year_select_sqlsafe . "' AND Program_ID=$program[2] AND Date_Dropped IS NULL";

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
                    <td class="all_projects">0</td>
                    <td class="all_projects">0</td>
                    <td class="all_projects">0</td>
                </tr>
            <?php
        }
        include "../include/dbconnclose.php";
        ?>
        <tr>
            <td class="all_projects" colspan="2"><strong>Total number of students per category:</strong><br>
                <span class="helptext">(this row counts each participant only once, no matter how many programs s/he is involved in)</span>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
        $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . " AND MONTH(Date_Added)<='" . $month_select_sqlsafe . "' AND YEAR(Date_Added)<='" . $year_select_sqlsafe . "';";
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
                $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs  " . $participant_program_string . $session_querystring . " AND MONTH(Date_Added)<='" . $month_select_sqlsafe . "' AND YEAR(Date_Added)<='" . $year_select_sqlsafe . "' AND Date_Dropped IS NOT NULL;";

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
                $distinct_people = "SELECT DISTINCT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . " AND MONTH(Date_Added)<='" . $month_select_sqlsafe . "' AND YEAR(Date_Added)<='" . $year_select_sqlsafe . "' AND Date_Dropped IS NULL;";

                include "../include/dbconnopen.php";
                $distinct = mysqli_query($cnnEnlace, $distinct_people);
                $num_people = mysqli_num_rows($distinct);
                echo $num_people;
                include "../include/dbconnclose.php";
                ?>
            </td>
        </tr>
        <tr>
            <td class="all_projects" colspan="2"><strong>Total for all programs:</strong><br>
                <span class="helptext">(this row counts each participant once per program of involvement)</span>
            </td>
            <td class="all_projects">
                <?php
                //get distinct participants, then count rows
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . " AND MONTH(Date_Added)<='" . $month_select_sqlsafe . "' AND YEAR(Date_Added)<='" . $year_select_sqlsafe . "';";

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
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . " AND MONTH(Date_Added)<='" . $month_select_sqlsafe . "' AND YEAR(Date_Added)<='" . $year_select_sqlsafe . "' AND Date_Dropped IS NOT NULL;";

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
                $distinct_people = "SELECT Participant_ID FROM Participants_Programs " . $participant_program_string . $session_querystring . " AND MONTH(Date_Added)<='" . $month_select_sqlsafe . "' AND YEAR(Date_Added)<='" . $year_select_sqlsafe . "' AND Date_Dropped IS NULL;";

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
