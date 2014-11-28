<?php
include "../../header.php";
include "../header.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!--
Creates a new walkability assessment.  This will be changed and expanded in Bickerdike phase II
-->

<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
	});
</script>

<div class="content_wide">
<h3>New Walkability Assessment</h3><hr/><br/>

<table>
    <tr>
        <td>Block Assessed (ex: 2500 block of North Ave):</td>
        <td><input type="text" id="intersection"></td>
    </tr>
    <tr>
        <td>Do cars stop at stop signs?</td>
        <td><select id="stop_signs">
                <option value="">-----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select></td>
    </tr>
    <tr>
        <td>Are crosswalks painted and clearly visible?</td>
        <td><select id="crosswalks">
                <option value="">-----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select></td>
    </tr>
    <tr>
        <td>Do cars obey the speed limit?</td>
        <td><select id="speed_limit">
                <option value="">-----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select></td>
    </tr>
    <tr>
        <td>Does the sidewalk continue all the way down the block without gaps?</td>
        <td><select id="sidewalk">
                <option value="">-----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select></td>
    </tr>
    <tr>
        <td>Date Assessed:</td>
        
<?include "../include/datepicker.php";?>
        <td><input type="text" id="date"></td>
    </tr>
    <tr>
        <td><input type="button" value="Save" onclick="
                   $.post(
                    '../ajax/save_walkability.php',
                    {
                        intersection: document.getElementById('intersection').value,
                        stop_signs: document.getElementById('stop_signs').options[document.getElementById('stop_signs').selectedIndex].value,
                        crosswalks: document.getElementById('crosswalks').options[document.getElementById('crosswalks').selectedIndex].value,
                        speed: document.getElementById('speed_limit').options[document.getElementById('speed_limit').selectedIndex].value,
                        sidewalk: document.getElementById('sidewalk').options[document.getElementById('sidewalk').selectedIndex].value,
                        date: document.getElementById('date').value
                    },
                    function (response){
                        window.location = 'walkability_report.php';                    }
               )
               "></td>
    </tr>
</table>

</div>

<? include "../../footer.php"; ?>