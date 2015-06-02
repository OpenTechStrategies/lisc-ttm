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
include "../include/datepicker.php";
//filter by dates and funder(s) (probably by checkbox?)
// show table of activities in funding period
?>

<h3>Search Events by Funder</h3>
    <table class="all_projects">
<form method = "post"  action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<tr>
<th class="all_projects">Funder:</th><td class="all_projects">
<?php
$institution_list = "SELECT Institution_ID, Institution_Name FROM Institutions LEFT JOIN Institution_Types on Institution_Type = Institution_Type_ID WHERE Institution_Type_Name = 'Funder'";
include "../include/dbconnopen.php";
$funders_result_sqlsafe = mysqli_query($cnnLSNA, $institution_list);
$funder_array = array();
while ($funder = mysqli_fetch_row($funders_result_sqlsafe)){
    //also make array of funders for reference below
    $funder_array[$funder[0]] = $funder[1];
    ?>
    <input type="checkbox" id="" name = "funder[]"value = <?php echo $funder[0];?>><label for=""><?php echo $funder[1];?></label><br />
<?php
}
?>
</td>
<th class="all_projects">Start date:</th>
<td class="all_projects"> <input type="text" class="hadDatepicker" name = "start_date"></td>
<th class="all_projects">End date:</th>
<td class="all_projects"> <input type="text" class="hadDatepicker" name = "end_date"> </td>
</tr>
<tr>
<td class="all_projects" colspan="6">
<input type = "submit" value = "Filter" name = "funder_submit">
</td>
</tr>
</form>

<?php
$start_string = "";
$end_string = "";
$funder_string = "";
if (isset($_POST['funder_submit'])){
?>
     <h5> Current search based on: </h5>
<?php
    if ($_POST['start_date'] != ''){
        $reorder_start_date = explode('-', $_POST['start_date']);
        $start_date = $reorder_start_date[2] . '-' . $reorder_start_date[0] . '-' . $reorder_start_date[1];
        $start_string = " AND Date >= '$start_date' ";
        echo "<br /><strong>After: </strong>" . $_POST['start_date'];
    }
    if ($_POST['end_date'] != ''){
        $reorder_end_date = explode('-', $_POST['end_date']);
        $end_date = $reorder_end_date[2] . '-' . $reorder_end_date[0] . '-' . $reorder_end_date[1];
        $end_string = " AND Date <= '$end_date' ";
        echo "<br /><strong>Before: </strong> " . $_POST['end_date'];
    }
    if ($_POST['funder'] != ''){
        echo "<br /> <strong> Funded by: </strong>";
        $funder_string = " AND (";
        foreach ($_POST['funder'] as $funder){
            if ($funder != $_POST['funder'][0]) {
                echo " or ";
                $funder_string .= " OR Funder_ID = $funder"; 
            }
            else {
                $funder_string .= "  Funder_ID = $funder"; 
            }
            echo $funder_array[$funder];
        }
        $funder_string .=")";
    }
}

$funder_schedule_query = "SELECT Activity_Name, Date, Subcategory_Name, Institution_Name FROM Subcategory_Dates LEFT JOIN Subcategories ON Subcategory_Dates.Subcategory_ID = Subcategories.Subcategory_ID LEFT JOIN Institutions ON Funder_ID = Institution_ID WHERE Wright_College_Program_Date_ID IS NOT NULL $start_string $end_string $funder_string ORDER BY Subcategory_Dates.Subcategory_ID;";


?>

<br />
<br />

<tr><th colspan="2">Activity Name</th><th>Date</th><th>Program/Campaign</th><th colspan="2">Funder</th></tr>
<?php
include "../include/dbconnopen.php";
$funder_schedule = mysqli_query($cnnLSNA, $funder_schedule_query);
while ($row = mysqli_fetch_row($funder_schedule)){
    ?>
    <tr><td colspan="2" class="all_projects"><?php echo $row[0]; ?></td>
    <td class="all_projects"><?php echo $row[1]; ?></td>
    <td class="all_projects"><?php echo $row[2]; ?></td>
    <td class="all_projects" colspan="2"><?php echo $row[3]; ?></td>
</tr>
<?php
}


?>
</table>

<?php
include "../../footer.php";
?>
