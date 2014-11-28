<?php
include "../../header.php";
include "../header.php";



?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#participants_selector').addClass('selected');
	});
</script>

<!--
page where new database people are added.  Inserts them into the database, assigning them
an ID in the process.
-->

<div class="content_narrow">
<h3>Add New Participant</h3><hr/>
<br/>
<span class="helptext">You must enter a first or last name for this participant record to save.</span>
<table>
    <tr><td>First Name:</td><td><input type="text" id="new_user_first_name"></td></tr>
    <tr><td>Last Name:</td><td><input type="text" id="new_user_last_name"></td></tr>
    <tr><td>Gender:</td><td><select id="new_user_gender">
                <option value="">-----</option>
                <option value="F">Female</option>
                <option value="M">Male</option>
            </select></td></tr>
    <tr><td>Age:</td><td><select id="new_user_age">
                <option value="">-----</option>
                <option value="12">10-19</option>
                <option value="20">20-34</option>
                <option value="35">35-44</option>
                <option value="45">45-59</option>
                <option value="60">60 or over</option>
            </select></td></tr>
    <tr><td>Race/Ethnicity:</td><td><select id="new_user_race">
                <option>-----</option>
                <option value="b">African-American</option>
                <option value="l">Latino/a</option>
                <option value="a">Asian-American</option>
                <option value="w">White</option>
                <option value="o">Other</option>
            </select></td></tr>
    <tr><td>Zipcode:</td><td><input type="text" id="new_user_zipcode" maxlength="5"></td></tr>
    <tr><td style="vertical-align:top;">Address:</td><td>
	
		<input type="text" id="new_user_address_number"> <input type="text" id="new_user_address_direction"> <input type="text" id="new_user_address_street"> <input type="text" id="new_user_address_street_type"><br/><span class="helptext">e.g. 2550 W North Ave</span>
		</td></tr>

	<tr><td>Email Address:</td><td><input type="text" id="new_user_email"></td></tr>
        <tr><td>Phone Number:</td><td><input type="text" id="new_user_phone"></td></tr>
	<tr><td>Participant type:</td><td><select id="new_user_type">
			<option value="">-----</option>
			<option value="adult">Adult</option>
			<option value="parent">Parent</option>
			<option value="youth">Child/Youth</option>
		</select></td>
	</tr>

</table>

<input type="button" value="Add" onclick="
    //don't add empty records
    var first=document.getElementById('new_user_first_name').value;
    var last=document.getElementById('new_user_last_name').value;
    if (first!='' || last!=''){
                    //first check for duplicate(s)
                    $.post(
                        '../ajax/user_duplicate_check.php',
                        {
                            first_name: document.getElementById('new_user_first_name').value,
                            last_name: document.getElementById('new_user_last_name').value
                        },
                        function (response){
                            if (response != ''){
                                //if there is someone with this name already, ask the data enterer if s/he wants
                                //to add this person to the DB
                                var deduplicate = confirm(response);
                                if (deduplicate){
                                    $.post(
                                        '../ajax/insert_user.php',
                                        {
                                            first_name: document.getElementById('new_user_first_name').value,
                                            last_name: document.getElementById('new_user_last_name').value,
                                            zip: document.getElementById('new_user_zipcode').value,
                                            age: document.getElementById('new_user_age').options[document.getElementById('new_user_age').selectedIndex].value,
                                            race: document.getElementById('new_user_race').options[document.getElementById('new_user_race').selectedIndex].value,
                                            gender: document.getElementById('new_user_gender').options[document.getElementById('new_user_gender').selectedIndex].value,
                                            address_street: document.getElementById('new_user_address_street').value,
                                            address_number: document.getElementById('new_user_address_number').value,
                                            address_direction: document.getElementById('new_user_address_direction').value,
                                            address_street_type: document.getElementById('new_user_address_street_type').value,
                                            email: document.getElementById('new_user_email').value,
                                            phone: document.getElementById('new_user_phone').value,
                                            type: document.getElementById('new_user_type').options[document.getElementById('new_user_type').selectedIndex].value
                                        },
                                        function (response){
                                            //document.write(response);
                                            //window.location='/bickerdike/users/add_user.php';
                                            document.getElementById('confirmation').innerHTML = response;
                                        }
                                    );
                                }
                            }
                            else{
                            //if not, then simply save the user.
                                $.post(
                                    '../ajax/insert_user.php',
                                    {
                                            first_name: document.getElementById('new_user_first_name').value,
                                            last_name: document.getElementById('new_user_last_name').value,
                                            zip: document.getElementById('new_user_zipcode').value,
                                            age: document.getElementById('new_user_age').options[document.getElementById('new_user_age').selectedIndex].value,
                                            race: document.getElementById('new_user_race').options[document.getElementById('new_user_race').selectedIndex].value,
                                            gender: document.getElementById('new_user_gender').options[document.getElementById('new_user_gender').selectedIndex].value,
                                            address_street: document.getElementById('new_user_address_street').value,
                                            address_number: document.getElementById('new_user_address_number').value,
                                            address_direction: document.getElementById('new_user_address_direction').value,
                                            address_street_type: document.getElementById('new_user_address_street_type').value,
                                            email: document.getElementById('new_user_email').value,
                                            phone: document.getElementById('new_user_phone').value,
                                            type: document.getElementById('new_user_type').options[document.getElementById('new_user_type').selectedIndex].value
                                        },
                                    function (response){
                                        document.getElementById('confirmation').innerHTML = response;
                                    }
                                );
                            }
                        }
                );
    }">
<div id="confirmation"></div>
</div>

<? include "../../footer.php"; ?>