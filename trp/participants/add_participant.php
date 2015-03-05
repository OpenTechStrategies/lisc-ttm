<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id);
?>
<h4>New Participant</h4><br/>
<!-- div that appears on participants.php for adding a new person to the DB 

No required fields.
-->
<table class="search_table">
    <tr>
        <td><strong>First Name:</strong></td>
        <td><input type="text" id="name_new" /></td>
        <td><strong>Last Name:</strong></td>
        <td><input type="text" id="surname_new" /></td>
    </tr>
    <tr>
        <td><strong>CPS ID:</strong></td>
        <td><input type="text" id="cps_id_new"></td>
    </tr>
    <tr>
        <td><strong>Date of Birth:</strong><br>
            <span class="helptext">Dates must be entered in MM/DD/YYYY format.</span></td>
        <td><input type="text" id="dob_new" class="hasDatepickers"/></td>
        <td><strong>Gender:</strong></td>
        <td><select id="gender_new">
                <option value="">---------</option>
                <option value="m">Male</option>
                <option value="f">Female</option>
            </select>
        </td>
    </tr>
    <tr>
        <td><strong>Street Address:</strong></td>
        <!-- Borrowing IDs here from Bickerdike so they'll format correctly, sorry they're a little clumsy. -MW -->
        <td><input type="text" id="new_user_address_number" /> <input type="text" id="new_user_address_direction" /> <input type="text" id="new_user_address_street" /> <input type="text" id="new_user_address_street_type" /><br/>
            <span class="helptext">e.g. 1818 S Paulina St</span>
        </td>
        <td><strong>Phone Number:</strong></td>
        <td><input type="text" id="phone_new" /></td>
    </tr>
    <tr>
        <td><strong>City and State:</strong></td>
        <td><input type="text" id="city_new" style="width:100px;" /> <input type="text" id="state_new" style="width:25px;" /></td>
        <td><strong>Email address:</strong></td>
        <td><input type="text" id="email_new" /></td>
    </tr>
    <tr>
        <td><strong>ZIP Code:</strong></td>
        <td><input type="text" id="zip_new" /></td>
        <td><strong>Race/Ethnicity</strong></td>
        <td><select id="race">
                <option value="0">N/A</option>
                <option value="1">African-American</option>
                <option value="2">Asian-American</option>
                <option value="3">Latin@</option>
                <option value="4">White</option>
                <option value="5">Other</option>
            </select></td>
    </tr>
    <tr><td colspan="4"><span class="helptext">Answer the following questions if they are applicable (esp. if this participant is in the NMMA program).
            </span></td></tr>
    <tr><td><strong>Grade:</strong></td><td><select id="grade_level">
                <option>-----</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
            </select></td>
        <td><strong>Class Room Number:</strong></td><td><input type="text" id="class_num"></td></tr>
    <tr><td><strong>Free or Reduced Price Lunch?</strong></td><td><select id="lunch_price">
                <option value="0">No Answer</option>
                <option value="1">Free</option>
                <option value="2">Reduced Price</option>
                <option value="3">None</option>
            </select></td></tr>
    <tr>
        <td colspan="2"><input type="button" value="Save" onclick="
                                $.post(
                                        '../ajax/program_duplicate_check.php',
                                        {
                                            name: document.getElementById('name_new').value,
                                            surname: document.getElementById('surname_new').value,
                                            cps_id: document.getElementById('cps_id_new').value
                                        },
                                        function (response){
                                            if (response != ''){
                                                var deduplicate = confirm(response);
                                                if (deduplicate){
                                                    $.post(
                                        '../ajax/add_participant.php',
                                        {
                                            first_name: document.getElementById('name_new').value,
                                            last_name: document.getElementById('surname_new').value,
                                            dob: document.getElementById('dob_new').value,
                                            gender: document.getElementById('gender_new').value,
                                            address_num: document.getElementById('new_user_address_number').value,
                                            address_dir: document.getElementById('new_user_address_direction').value,
                                            address_name: document.getElementById('new_user_address_street').value,
                                            address_type: document.getElementById('new_user_address_street_type').value,
                                            city: document.getElementById('city_new').value,
                                            state: document.getElementById('state_new').value,
                                            zip: document.getElementById('zip_new').value,
                                            email: document.getElementById('email_new').value,
                                            day_phone: document.getElementById('phone_new').value,
                                            race: document.getElementById('race').value,
                                            grade: document.getElementById('grade_level').value,
                                            classroom: document.getElementById('class_num').value,
                                            lunch: document.getElementById('lunch_price').value
                                        },
                                function(response) {
                                    document.getElementById('confirmation').innerHTML = response;
                                }
                                ).fail(failAlert);
                                                    }
                                            }
                                            else{
                                                $.post(
                                        '../ajax/add_participant.php',
                                        {
                                            first_name: document.getElementById('name_new').value,
                                            last_name: document.getElementById('surname_new').value,
                                            dob: document.getElementById('dob_new').value,
                                            gender: document.getElementById('gender_new').value,
                                            address_num: document.getElementById('new_user_address_number').value,
                                            address_dir: document.getElementById('new_user_address_direction').value,
                                            address_name: document.getElementById('new_user_address_street').value,
                                            address_type: document.getElementById('new_user_address_street_type').value,
                                            city: document.getElementById('city_new').value,
                                            state: document.getElementById('state_new').value,
                                            zip: document.getElementById('zip_new').value,
                                            email: document.getElementById('email_new').value,
                                            day_phone: document.getElementById('phone_new').value,
                                            race: document.getElementById('race').value,
                                            grade: document.getElementById('grade_level').value,
                                            classroom: document.getElementById('class_num').value,
                                            lunch: document.getElementById('lunch_price').value
                                        },
                                function(response) {
                                    document.getElementById('confirmation').innerHTML = response;
                                }
                                ).fail(failAlert);
                                            }
                                        }
                                      ).fail(failAlert);
                                 
                                "/></td>
    </tr>
</table>
<div id="confirmation"></div>