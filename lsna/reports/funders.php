<?php
include "../../header.php";
include "../header.php";
include "../include/datepicker.php";
//filter by dates and funder(s) (probably by checkbox?)
// show table of activities in funding period
?>

<form method = "post"  action="<?php echo $_SERVER['PHP_SELF']; ?>" >
Start date: <input type="text" class="hadDatepicker" name = "start_date"> <br>
    End date: <input type="text" class="hadDatepicker" name = "end_date"> <br>
    Funder:
<?php
$institution_list = "SELECT Institution_ID, Institution_Name FROM Institutions LEFT JOIN Institution_Types on Institution_Type = Institution_Type_ID WHERE Institution_Type_Name = 'Funder'";
include "../include/dbconnopen.php";
$funders_result_sqlsafe = mysqli_query($cnnLSNA, $institution_list);
while ($funder = mysqli_fetch_row($funders_result_sqlsafe)){
    ?>
    <input type="checkbox" id="" name = "funder[]"value = <?php echo $funder[0];?>><label for=""><?php echo $funder[1];?></label><br>
<?php
}
?>
<input type = "submit" value = "Filter" name = "funder_submit">
</form>

<table  class="program_involvement_table">
<tr><th>Activity Name</th><th>Date</th><th>Program/Campaign</th><th>Funder</th></tr>
<?php
$start_date = '2015-01-01';
$end_date = '2015-07-01';
$funder_string = '';
if (isset($_POST['funder_submit'])){
    if ($_POST['start_date'] != ''){
        $reorder_start_date = explode('-', $_POST['start_date']);
        $start_date = $reorder_start_date[2] . '-' . $reorder_start_date[0] . '-' . $reorder_start_date[1];
    }
    if ($_POST['end_date'] != ''){
        $reorder_end_date = explode('-', $_POST['end_date']);
        $end_date = $reorder_end_date[2] . '-' . $reorder_end_date[0] . '-' . $reorder_end_date[1];
    }
    foreach ($_POST['funder'] as $funder){
        $funder_string = " AND Funder_ID = $funder"; 
    }

}

$funder_schedule_query = "SELECT Activity_Name, Date, Subcategory_Name, Institution_Name FROM Subcategory_Dates LEFT JOIN Subcategories ON Subcategory_Dates.Subcategory_ID = Subcategories.Subcategory_ID LEFT JOIN Institutions ON Funder_ID = Institution_ID WHERE Date >= '$start_date' AND Date <= '$end_date' $funder_string ORDER BY Subcategory_Dates.Subcategory_ID;";
include "../include/dbconnopen.php";
$funder_schedule = mysqli_query($cnnLSNA, $funder_schedule_query);
while ($row = mysqli_fetch_row($funder_schedule)){
    ?>
    <tr><td><strong><?php echo $row[0]; ?></strong></td>
    <td><?php echo $row[1]; ?></td>
    <td><?php echo $row[2]; ?></td>
    <td><?php echo $row[3]; ?></td>
</tr>
<?php
}


?>
</table>

<?php
include "../../footer.php";
?>