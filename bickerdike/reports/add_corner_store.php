<?php
include "../../header.php";
include "../header.php";

?>

<!--
This file creates a new corner store assessment, and often a new corner store entirely.
-->


<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
	});
</script>

<div class="content_wide">
<h3>New Corner Store Assessment</h3><hr/><br/>


<table>
    <tr>
        <td>Has this corner store been assessed before?  If so, please choose it from this<br> list and leave the name and address fields blank below:
</td>
<td>
    <select id="all_stores">
    <option value="">-----</option>
    <?
    /*Shows list of existing corner stores.  This is meant to allow tracking a corner store over time.*/
    $stores = "SELECT * FROM Corner_Stores";
    include "../include/dbconnopen.php";
    $str = mysqli_query($cnnBickerdike, $stores);
    while ($store = mysqli_fetch_array($str)){
        ?>
    <option value="<?echo $store['Corner_Store_ID'];?>"><?echo $store['Corner_Store_Name'] . " - " . $store['Corner_Store_Address'];?></option>
            <?
    }
    include "../include/dbconnclose.php";
    ?>
</select>
</td>
    </tr>
    <tr>
        <!--Leave these blank if the store has been selected from the list.-->
        <td>
            Corner Store Name:
        </td>
        <td>
            <input type="text" id="name">
        </td>
    </tr>
    <tr>
        <td>
            Corner Store Address:
        </td>
        <td>
            <input type="text" id="address">
        </td>
    </tr>
    <tr>
        <td>
            Does this store have at least 2 fresh vegetable options and 2 fresh
            fruit options?
        </td>
        <td>
            <select id="fresh_produce">
                <option value="">-----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            Does this store offer low-fat milk?
        </td>
        <td>
            <select id="low_fat_milk">
                <option value="">-----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            Does this store have health promotion signage (not including advertisements)?
        </td>
        <td>
            <select id="health_promotion">
                <option value="">-----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            Are healthy items stocked in the front of the store or in high traffic areas?
        </td>
        <td>
            <select id="stocking">
                <option value="">-----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            Date Evaluated:
        </td>
        
<?include "../include/datepicker.php";?>
        <td>
            <input type="text" id="date">
        </td>
    </tr>
    <tr>
        <td>
            <input type="button" value="Save" onclick="
                $.post(
                   '../ajax/save_corner_store_assessment.php',
                   {
                       store_id: document.getElementById('all_stores').options[document.getElementById('all_stores').selectedIndex].value,
                       name: document.getElementById('name').value,
                       address: document.getElementById('address').value,
                       produce: document.getElementById('fresh_produce').options[document.getElementById('fresh_produce').selectedIndex].value,
                       milk: document.getElementById('low_fat_milk').options[document.getElementById('low_fat_milk').selectedIndex].value,
                       promotions: document.getElementById('health_promotion').options[document.getElementById('health_promotion').selectedIndex].value,
                       stock: document.getElementById('stocking').options[document.getElementById('stocking').selectedIndex].value,
                       date: document.getElementById('date').value
                   },
                   function (response){
                       //document.write(response);
                       window.location = 'corner_store_report.php';
                   }
           )">
        </td>
    </tr>
</table>
</div>

<? include "../../footer.php"; ?>