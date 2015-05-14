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

user_enforce_has_access($LSNA_id);
include "../../header.php";
include "../header.php";
?>
<div id="program_involvement">
    <h4>Extent of Involvement - All Programs and Campaigns</h4>
<?php
include "../include/datepicker.php";
include "../include/dbconnopen.php";
if (isset($_POST['submit']) && ! isset($_POST['clear'])){
    //reformat
    $start_date_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['start_date']);
    $end_date_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['end_date']);
    $start_date_array = explode('-', $start_date_sqlsafe);
    $start_date = $start_date_array[2] . '-' . $start_date_array[0] . '-' . $start_date_array[1];
    $end_date_array = explode('-', $end_date_sqlsafe);
    $end_date = $end_date_array[2] . '-' . $end_date_array[0] . '-' . $end_date_array[1];
    $date_query_substring = " AND Date_Linked >= '$start_date' AND Date_Linked <= '$end_date' ";
}
else{
    //default values
     $date_query_substring = "";
}


?>
<script text="javascript">
    $(document).ready(function() {
        $(".list_of_names").hide();
    });
</script>
<!--
    Shows how many programs & campaigns people are involved in.
    -->
    <span class="helptext">This table provides a summary of the total number of different programs and campaigns that participants (and types of participants) have been involved in.</span><br/>
    <table class="program_involvement_table">
    <caption> Showing results from <?php $start_date_display=date_create($start_date);
echo date_format($start_date_display,"M d, Y");
?> to <?php $end_date_display=date_create($end_date);
echo date_format($end_date_display,"M d, Y"); ?> </caption>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="filterByDate">
    <tr><th>Start Date:</th>
    <th><input type = "text" name = "start_date" class = "hadDatepicker"></th>
    <th>End Date:</th>
    <th><input type = "text" name = "end_date" class = "hadDatepicker"></th>
    <th><input type = "submit" value = "Sort" name = "submit"></th>
    </form>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="clearFilter">
     <th><input type = "submit" value = "Clear Filter" name = "clear"></th>
</form>
    </tr>

    <tr style="font-size:.9em;"><th>Number of Programs and Campaigns</th>
    <th>Number of Participants</th>
    <th>Number of Adults</th>
    <th>Number of Parent Mentors</th>
    <th>Number of Youth</th>
    <th>Number of Parent Mentor\'s Children</th>
    </tr>
<?php
/*
 * Takes a query that returns both the Participant_ID and the number
 * of programs/campaigns that the person is involved in (as
 * Number_Involved)
 * The number of programs the person is involved in
 * The number of people involved in that number of programs
 * The name of the span to hold the people's names
*/

    function show_involved_people($query, $count_programs, $counter_num, $span_id_name){
        include "../include/dbconnopen.php";
        $name_query = "SELECT Participants.Participant_ID, Participants.Name_First, Participants.Name_Last FROM Participants INNER JOIN ($query) AS Counter on Counter.Participant_ID = Participants.Participant_ID WHERE Number_Involved = $count_programs;";
        $result_string = "";
        $query_result = mysqli_query($cnnLSNA, $name_query);
        while ($result_row = mysqli_fetch_array($query_result)) {
            $result_string .= "<br>" . $result_row['Participant_ID'] . ": " . $result_row['Name_First'] . " " . $result_row['Name_Last'];
        }
        $result_span = '<a href = "javascript:;" onclick = \'$("#' . $span_id_name . '_span_' . $count_programs . '").toggle();\'>' . $counter_num . '</a> <span id = "' . $span_id_name . '_span_' . $count_programs . '" class = "list_of_names">' . $result_string . '</span>';

        return $result_span;
    }

function count_participant_types($query, $i, $index){
    $counter = 0;
    include "../include/dbconnopen.php";
    $ct = mysqli_query($cnnLSNA, $query);
    while ($count = mysqli_fetch_row($ct)) {
        if ($count[$index] == $i) {
            $counter++;
        }
    }
    return $counter;
}

function count_participant_totals($query){
    include "../include/dbconnopen.php";
    $rows = mysqli_query($cnnLSNA, $query);
    $total_number = mysqli_num_rows($rows);
    return $total_number;
}

    function show_counted_participants($query, $counter_num, $span_id_name){
        include "../include/dbconnopen.php";
        $name_query = "SELECT Participants.Participant_ID, Participants.Name_First, Participants.Name_Last FROM Participants INNER JOIN ($query) AS Counter on Counter.Participant_ID = Participants.Participant_ID";
        $result_string = "";
        $query_result = mysqli_query($cnnLSNA, $name_query);
        while ($result_row = mysqli_fetch_array($query_result)) {
            $result_string .= "<br>" . $result_row['Participant_ID'] . ": " . $result_row['Name_First'] . " " . $result_row['Name_Last'];
        }
        $result_span = '<a href = "javascript:;" onclick = \'$("#' . $span_id_name . '_span_' . $count_programs . '").toggle();\'>' . $counter_num . '</a> <span id = "' . $span_id_name . '_span_' . $count_programs . '" class = "list_of_names">' . $result_string . '</span>';

        return $result_span;
    }


//so here we count up the number of programs and campaigns in a while loop
//first I'm going to get the highest number of programs/campaigns that anyone is involved in.
$count_participants = "SELECT Participant_ID, COUNT(*) FROM Participants_Subcategories WHERE Participant_ID IS NOT NULL " . $date_query_substring . " GROUP BY Participant_ID ORDER BY COUNT(*) DESC";
include "../include/dbconnopen.php";
$ct_participants = mysqli_query($cnnLSNA, $count_participants);
$top_num = mysqli_fetch_row($ct_participants);
$most_programs = $top_num[1];
    for ($i = 1; $i < $most_programs + 1; $i++) {
    ?>
    <tr>
        <td style="background-color:lightgray;text-align:center;">
    <?php echo $i; ?>
        </td>
        <td>
<?php
    $count_participants = "SELECT Participants_Subcategories.Participant_ID, Name_First, Name_Last, COUNT(*) AS Number_Involved FROM Participants_Subcategories LEFT JOIN Participants ON Participants.Participant_ID = Participants_Subcategories.Participant_ID WHERE Participant_Subcategory_ID IS NOT NULL " . $date_query_substring . " GROUP BY Participant_ID ORDER BY Number_Involved DESC";
    $counter_num = count_participant_types($count_participants, $i, 3);
    /* number of people who participated in this number of programs and campaigns */
    echo show_involved_people($count_participants, $i, $counter_num, "participant");

?>
    </td>
    <td>
<?php
    /* number of adults who participated in this number of programs and campaigns */
    $counter_num = 0;
    $count_adults = "SELECT Participants_Subcategories.Participant_ID, COUNT(*) AS Number_Involved
                    FROM Participants_Subcategories INNER JOIN Participants
                    ON Participants.Participant_Id=Participants_Subcategories.Participant_ID
                    WHERE (Is_Child IS NULL OR Is_Child=3 OR Is_Child=0) " . $date_query_substring .  " 
                    GROUP BY Participant_ID ORDER BY COUNT(*) DESC";
    $counter_num = count_participant_types($count_adults, $i, 1);
    echo show_involved_people($count_adults, $i, $counter_num, "adult");
                    
?>
    </td>
    <td>
<?php
    /* number of parent mentors who participated in this number of programs and campaigns */
    $counter_num = 0;
    $count_pms = "SELECT Participants_Subcategories.Participant_ID, COUNT(*) AS Number_Involved  FROM Participants_Subcategories INNER JOIN Participants ON Participants.Participant_Id=Participants_Subcategories.Participant_ID INNER JOIN (SELECT DISTINCT Participant_ID FROM Participants_Subcategories WHERE Subcategory_ID=19) as check_pm ON check_pm.Participant_ID=Participants_Subcategories.Participant_ID WHERE Participant_Subcategory_ID IS NOT NULL  " . $date_query_substring .  " GROUP BY check_pm.Participant_ID ORDER BY COUNT(*) DESC";
    $counter_num = count_participant_types($count_pms, $i, 1);
    echo show_involved_people($count_pms, $i, $counter_num, "parent_mentor");

?>
    </td>
    <td>
<?php
    /* number of children who participated in this number of programs and campaigns */
    $counter_num = 0;
    $count_youth = "SELECT Participants_Subcategories.Participant_ID, COUNT(*) AS Number_Involved FROM Participants_Subcategories INNER JOIN Participants ON Participants.Participant_Id=Participants_Subcategories.Participant_ID WHERE (Is_Child IS NOT NULL AND Is_Child=2) " . $date_query_substring .  " GROUP BY Participant_ID ORDER BY COUNT(*) DESC";
    $counter_num = count_participant_types($count_youth, $i, 1);
    echo show_involved_people($count_youth, $i, $counter_num, "youth");
?>
    </td>
    <td>
<?php
    /* number of parent mentor children who participated in this number of programs and campaigns */
    $counter_num = 0;
    //this takes account of children who might have more than one parent in the PM program
    $count_children = "SELECT DISTINCT(Participants_Subcategories.Participant_ID), COUNT(Subcategory_ID) AS Number_Involved FROM Participants_Subcategories INNER JOIN Parent_Mentor_Children ON Parent_Mentor_Children.Child_Id=Participants_Subcategories.Participant_ID WHERE  " . $date_query_substring .  " GROUP BY Parent_Mentor_Children_Link_ID";
    $counter_num = count_participant_types($count_children, $i, 1);
    echo show_involved_people($count_children, $i, $counter_num, "pm_child");
?>
    </td>
    </tr>
<?php
}

if ( ! isset($_POST['submit']) || isset($_POST['clear'])){
?>
<tr>
<td><span class="helptext">Total participants in the system:</span></td>
    <td>
<?php
    $get_participants = "SELECT * FROM Participants";
    echo count_participant_totals($get_participants);
?>
</td>
<td>
<?php
    $get_adults = "SELECT * FROM Participants WHERE (Is_Child IS NULL OR Is_Child=3 OR Is_Child=0)";
    echo count_participant_totals($get_adults);
?>
</td>
<td>
<?php
    $get_pms = "SELECT DISTINCT Participant_ID FROM Participants_Subcategories WHERE Subcategory_ID='19' " . $date_query_substring;
    echo count_participant_totals($get_pms);
?></td>
<td>
<?php
    $get_youth = "SELECT * FROM Participants WHERE Is_Child=2";
    echo count_participant_totals($get_youth);
?>
</td>
<td>
<?php
    $get_pm_children = "SELECT DISTINCT Child_ID FROM Parent_Mentor_Children;";
    echo count_participant_totals($get_pm_children);
?>
</td>
</tr>
<?php
}
?>
</table>
<br/><br/>

 <!--Shows how many of each type of person are involved in each program/campaign: -->
<h4>Extent of Involvement By Program/Campaign</h4>
<table class="program_involvement_table">
<tr>
<th>Program/Campaign</th>
<th>Number of Participants</th><!--Total -->
<th>Number of Adults</th>
<th>Number of Parent-Mentors</th>
<th>Number of Youth</th>
<th>Number of Parent Mentor's Children</th>
</tr>
    <?php
        $get_programs = "SELECT * FROM Subcategories ORDER BY Subcategory_Name";
        include "../include/dbconnopen.php";
        $programs = mysqli_query($cnnLSNA, $get_programs);
        while ($program = mysqli_fetch_array($programs)) {
    ?>
<tr>
<!--For each subcategory (program or campaign), count the total number of people involved and then
split them up by type of person.
-->
    <td style="text-align:left;"><strong><?php echo $program['Subcategory_Name']; ?><strong></td>
    <td>
    <?php
            $count_participants = "SELECT DISTINCT Participant_ID FROM Participants_Subcategories WHERE Subcategory_ID='" . $program['Subcategory_ID'] . "'" . $date_query_substring;
            $counter_num = count_participant_totals($count_participants);
            $span_id = "participants_" . $program['Subcategory_ID'];
            echo show_counted_participants($count_participants, $counter_num, $span_id);
    ?>
    </td>
    <td>
    <?php
            $count_adults = "SELECT DISTINCT Participants_Subcategories.Participant_ID FROM Participants_Subcategories INNER JOIN Participants ON Participants.Participant_Id=Participants_Subcategories.Participant_ID WHERE (Is_Child IS NULL OR Is_Child=3 OR Is_Child=0) AND Participants_Subcategories.Subcategory_ID='" . $program['Subcategory_ID'] . "'" . $date_query_substring;
            $counter_num = count_participant_totals($count_adults);
            $span_id = "adults_" . $program['Subcategory_ID'];
            echo show_counted_participants($count_adults, $counter_num, $span_id);
    ?>
    </td>
    <td>
    <?php
            $count_pms = "SELECT DISTINCT Participants_Subcategories.Participant_ID FROM Participants_Subcategories INNER JOIN Participants ON Participants.Participant_Id=Participants_Subcategories.Participant_ID INNER JOIN (SELECT * FROM Participants_Subcategories WHERE Subcategory_ID=19) as check_pm ON check_pm.Participant_ID=Participants_Subcategories.Participant_ID WHERE Participants_Subcategories.Subcategory_ID='" . $program['Subcategory_ID'] . "'" . $date_query_substring;
            $counter_num = count_participant_totals($count_pms);
            $span_id = "pms_" . $program['Subcategory_ID'];
            echo show_counted_participants($count_pms, $counter_num, $span_id);
    ?>
    </td>
    <td>
    <?php
            $count_youth = "SELECT * FROM Participants_Subcategories INNER JOIN Participants ON Participants.Participant_Id=Participants_Subcategories.Participant_ID WHERE (Is_Child IS NOT NULL AND Is_Child=2) AND Participants_Subcategories.Subcategory_ID='" . $program['Subcategory_ID'] . "'" . $date_query_substring;
            $counter_num = count_participant_totals($count_youth);
            $span_id = "youth_" . $program['Subcategory_ID'];
            echo show_counted_participants($count_youth, $counter_num, $span_id);
    ?>
    </td>
    <td>
    <?php
            $count_children = "SELECT * FROM Participants_Subcategories INNER JOIN Parent_Mentor_Children ON Parent_Mentor_Children.Child_Id=Participants_Subcategories.Participant_ID WHERE Participants_Subcategories.Subcategory_Id='" . $program['Subcategory_ID'] . "'" . $date_query_substring;
            $counter_num = count_participant_totals($count_children);
            $span_id = "children_" . $program['Subcategory_ID'];
            echo show_counted_participants($count_children, $counter_num, $span_id);
    ?>
    </td>
</tr>
    <?php
        }
        include "../include/dbconnclose.php";
    ?>
</table>
</div>


<?php
    include "../../footer.php";
?>
