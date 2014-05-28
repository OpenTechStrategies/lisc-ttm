<div id="add_property">
<h3>Properties</h3><hr/><br/>        
<h4>New Property</h4><br/>


<!-- Add a new property.  This may be a property being tracked for vacancy or acquisition purposes, or just someone's
address. -->
<table class="search_table">
	
	<tr>
		<td><strong>Street Address:</strong></td>
		<!-- Borrowing IDs here from Bickerdike so they'll format correctly, sorry they're a little clumsy. -MW -->
		<td><input type="text" id="new_user_address_number" /> <select id="new_user_address_direction">
                        <option>N</option>
                        <option>S</option>
                        <option>E</option>
                        <option>W</option>
                    </select> <input type="text" id="new_user_address_street" /> <select id="new_user_address_street_type">
                        <option>ST</option>
                        <option>AVE</option>
                        <option>RD</option>
                        <option>PL</option>
                        <option>CT</option>
                        <option>BLVD</option>
                    </select>
                    <br/>
			<span class="helptext">e.g. 1818 S Paulina St</span>
		</td>
		<td><strong>Zipcode:</strong></td>
		<td><input type="text" id="zip_new" maxlength="10"/></td>
	</tr>
        
	<tr>
		<td><strong>Vacant?</strong></td>
		<td><select id="vacant_new">
						<option value="">---------</option>
						<option value="1">Yes</option>
						<option value="2">No</option>
					</select></td>
                                        
		<td><strong>Disposition</strong></td>
                <td><select id="disposition_new">
						<option value="">---------</option>
                                                <?php $get_disps = "SELECT * FROM Property_Dispositions";
                                                include "../include/dbconnopen.php";
                                                $disps=mysqli_query($cnnSWOP, $get_disps);
                                                while ($disp=mysqli_fetch_row($disps)){
                                                ?>
                                                <option value="<?echo $disp[0]?>"><?echo $disp[1];?></option>
						<?php }
                                                include "../include/dbconnclose.php";?>
					</select></td>
	</tr>
        <tr>
            <td><strong>Construction Type</strong></td>
            <td>
                 <select id="construction_new">
                                        <option value="">-----</option>
                                        <option value="4" >Brick/masonry</option>
                                        <option value="5" >Frame</option>
                                    </select>
            </td>
            <td><strong>Home Size</strong></td>
            <td> <select id="size_new">
                                        <option value="">-----</option>
                                        <option value="1" >Single-family</option>
                                        <option value="2" >2/3 flat</option>
                                        <option value="3" >Multi-unit</option>
                                    </select></td>
        </tr>
        <tr>
            <td><strong>Property Type:</strong></td>
            <td><select id="prop_type_new">
                                        <option value="">-----</option>
                                        <option value="1" >Residential</option>
                                        <option value="2" >Commercial</option>
                                        <option value="3" >Mixed Use</option>
                                    </select></td>
                                    <td><strong>PIN:</strong></td>
		<td><input type="text" id="pin_new" maxlength="10"/></td>
        </tr>
	<tr>
			<td colspan="2"><input type="button" value="Save" onclick="
                            /* they asked us to make PINs required, and then got rid of that requirement: */
                            
//                            var pin = document.getElementById('pin_new').value;
//                            if (pin==''){
//                                alert('Please add the property PIN.');
//                                return false;
//                            }
            $.post(
            '../ajax/program_duplicate_check.php',
            {
                action: 'property',
                street_number: document.getElementById('new_user_address_number').value,
		street_name: document.getElementById('new_user_address_street').value,
                pin: document.getElementById('pin_new').value
            },
            function (response){
                if (response != ''){
                    /* check whether a person with this name is already in the database: */
                    var deduplicate = confirm(response);
                    if (deduplicate){
                                $.post(
						'../ajax/add_property.php',
						{
							num: document.getElementById('new_user_address_number').value,
                                                        dir: document.getElementById('new_user_address_direction').value,
                                                        name: document.getElementById('new_user_address_street').value,
                                                        type: document.getElementById('new_user_address_street_type').value,
							pin: document.getElementById('pin_new').value,
                                                        zipcode: document.getElementById('zip_new').value,
							vacant: document.getElementById('vacant_new').value,
							disposition: document.getElementById('disposition_new').value,
                                                        construction_type: document.getElementById('construction_new').value,
                                                        home_size: document.getElementById('size_new').value,
                                                        prop_type: document.getElementById('prop_type_new').value
                                                },
						function (response){
							document.getElementById('confirmation').innerHTML = response;
						}
				); 
                    }
                }
                else{
				$.post(
						'../ajax/add_property.php',
						{
							num: document.getElementById('new_user_address_number').value,
                                                        dir: document.getElementById('new_user_address_direction').value,
                                                        name: document.getElementById('new_user_address_street').value,
                                                        type: document.getElementById('new_user_address_street_type').value,
							pin: document.getElementById('pin_new').value,
                                                        zipcode: document.getElementById('zip_new').value,
							vacant: document.getElementById('vacant_new').value,
							disposition: document.getElementById('disposition_new').value,
                                                        construction_type: document.getElementById('construction_new').value,
                                                        home_size: document.getElementById('size_new').value,
                                                        prop_type: document.getElementById('prop_type_new').value
                                                },
						function (response){
							document.getElementById('confirmation').innerHTML = response;
						}
				);
                    }}
            );"/></td>
        </tr>
</table>
<div id="confirmation"></div>

</div>
