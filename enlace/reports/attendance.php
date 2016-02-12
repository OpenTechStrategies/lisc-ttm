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
<div style="display: none;">
    <?php include_once("../include/datepicker_wtw.php");?>
</div>

<h3>Program Enrollment</h3>
<form action="reports.php" method="post">
<?php
            //get user's programs
         $all_progs = "SELECT Session_ID, Name, Session_Name, COUNT(Participant_ID) FROM Session_Names 
                            INNER JOIN Participants_Programs ON Participants_Programs.Program_ID = Session_ID 
                            INNER JOIN Programs ON Session_Names.Program_Id = Programs.Program_ID 
                            " . $program_string . "
                            GROUP BY Session_ID;";
        include "../include/dbconnopen.php";
        $all_programs = mysqli_query($cnnEnlace, $all_progs);
        $checkbox_count = 0;
        $session_array = [];
        while ($program = mysqli_fetch_row($all_programs)) {
            $session_array[$program[0]] = array($program[1], $program[2]);
            $checkbox_count++;
            ?>
            <input type="checkbox" name="program_select[]" id="checkbox_<?php echo $checkbox_count; ?>" value="<?php echo $program[0]; ?>"
            <?php
            if ($_POST['program_select']) {
                echo (in_array($program[0], $_POST['program_select']) ? 'checked="true"' : null);
            }
            ?>><?php
                   echo "<label for=\"checkbox_" . $checkbox_count . "\">" . $program[2] . "--" . $program[1] . "</label><br>";
               }
        include "../include/dbconnclose.php";
        ?>
<br>
Start date: <input type="text" class="addDP" name="start_date" value="<?php echo $_POST['start_date']; ?>">
    End date: <input type="text" class="addDP" name="end_date" value="<?php echo $_POST['end_date']; ?>">
 <br>
<input type="submit" value="Search" name="submit_btn">
</form>
    <table class="all_projects">
        <tr>
            <th>Program Name</th>
            <th>Session Name</th>
            <th>Total enrollment</th>
            <th>Dosage hours</th>
        </tr>
<?php
    if ($_POST){
        // loop through selected sessions here
        $total_hours = 0;
        foreach ($_POST['program_select'] as $session ) {
            $dosage_array = calculate_dosage($session, null, $_POST['start_date'], $_POST['end_date']);
            ?>
            <tr>
            <td><?php echo $session_array[$session][0]; ?></td>
            <td><?php echo $session_array[$session][1]; ?></td>
            <td><?php echo $dosage_array[3];?></td>
            <td><?php echo $dosage_array[1];?></td>
            </tr>
            <?php
            $total_hours = $total_hours + $dosage_array[1];
        }
    }
 ?>
             <tr>
            <th>Total</th>
            <th></th>
            <th></th>
            <th><?php echo $total_hours; ?></th>
            </tr>
</table>