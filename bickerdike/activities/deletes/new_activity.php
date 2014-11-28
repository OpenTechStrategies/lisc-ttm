<?php

include "../../header.php";
include "../../bickerdike/header.php";
include "../include/datepicker.php";
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#events_selector').addClass('selected');
	});
</script>


<div class="content_narrow">
<h3>Create New Event</h3>

<table>
    <tr>
        <td>Event Name:</td>
        <td><input type="text" id="new_activity_name"></td>
    </tr>
    <tr><td>Event Type:</td>
        <td><select id="new_activity_type">
                <option value="">-----</option>
                <?
                $orgs_sqlsafe = "SELECT * FROM Program_Types";
                include "../include/dbconnopen.php";
                $organisation = mysqli_query($cnnBickerdike, $orgs_sqlsafe);
                while ($org = mysqli_fetch_array($organisation)){
                    ?>
                <option value="<?echo $org['Program_Type_ID'];?>"><?echo $org['Program_Type_Name'];?></option>
                            <?
                }
                include "../include/dbconnclose.php";
                ?>
            </select></td>
    <td>
                Or add new type: 
            </td>
            <td>
                <input type="text" id="type_text">
            </td></tr>
    <tr>
        <td>Sponsoring Organization:</td>  
        <td><select id="new_activity_organization">
                <option value="">-----</option>
                <?
                $orgs_sqlsafe = "SELECT * FROM Org_Partners";
                include "../include/dbconnopen.php";
                $organisation = mysqli_query($cnnBickerdike, $orgs_sqlsafe);
                while ($org = mysqli_fetch_array($organisation)){
                    ?>
                <option value="<?echo $org['Partner_ID'];?>"><?echo $org['Partner_Name'];?></option>
                            <?
                }
                include "../include/dbconnclose.php";
                ?>
            </select></td>
            <td>
                Or add new organization: 
            </td>
            <td>
                <input type="text" id="org_text">
            </td>
    </tr>
	<? include "../include/datepicker.php" ;?>
    <tr>
        <td>Event Date:</td>
        <td colspan="3"><input type="text" id="new_activity_date">
	</td>
    </tr>
	<tr>
		<td colspan="4">
			<p class="helptext">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dates must be entered in the format YYYY-MM-DD (or use the pop-up calendar).</p>
		</td>
	</tr>
    <tr><td><input type="button" value="Save Activity" onclick="
                   $.post(
                    '../ajax/add_activity.php',
                    {
                        name: document.getElementById('new_activity_name').value,
                        type: document.getElementById('new_activity_type').options[document.getElementById('new_activity_type').selectedIndex].value,
                        org: document.getElementById('new_activity_organization').options[document.getElementById('new_activity_organization').selectedIndex].value,
                        date: document.getElementById('new_activity_date').value,
                        new_org: document.getElementById('org_text').value,
                        new_type: document.getElementById('type_text').value
                    },
                    function (response){
                        document.getElementById('show_response').innerHTML = 'Thank you for adding this program! Now <a href=activity_profile.php?activity='+response+'>add users.</a>';
                    }
               )
               "></td></tr>
</table>

<div id="show_response"></div>
</div>

<? include "../../footer.php"; ?>