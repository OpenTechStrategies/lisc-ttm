<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

include "../../header.php";
include "../header.php";
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#institutions_selector').addClass('selected');
	});
</script>
         <div id="institution_search" class="content_block">
<h3>Add New Institution</h3><hr/><br/>

<!-- Create a profile for a SWOP institution in the database. -->

<table class="search_table">
	<tr>
		<td><strong>Name:</strong></td>
		<td><input type="text" id="name_new" /></td>
                
                <!-- The contact person must be someone who already has a profile in the database,
                because s/he is linked to the institution via ID.
                -->
                <td style="width:150px"><strong>Contact Person:</strong><br>
                    <span class="helptext">(search the database for this institution's contact person, 
                        then choose him or her from the dropdown list of results)</span></td>
		<td><div id="search_participants_div">
			<table class="search_table" >
			<tr>
				<td><strong>First Name:</strong></td>
				<td><input type="text" id="prop_name_search" /></td>
				</tr><tr><td><strong>Last Name:</strong></td>
				<td><input type="text" id="prop_surname_search" /></td>
			
			<tr>
				<td><strong>Primary Institution:</strong></td>
				<td><select id="prop_inst_search" />
                                        <option value="">-----</option>
    <?
			$get_institutions_sqlsafe = "SELECT * FROM Institutions ORDER BY Institution_Name";
			include "../include/dbconnopen.php";
			$institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
			while ($institution = mysqli_fetch_array($institutions)) {?>
    <option value="<?echo $institution['Institution_ID'];?>"><?echo $institution['Institution_Name'];?></option>
			<?}
			//include "../include/dbconnclose.php";
		?></select></td>
			</tr>
                        
			<tr>
				<td colspan="4"><input type="button" value="Search" onclick="
                               $('#link_button').show();
							   $.post(
                                '../ajax/search_users.php',
                                {
                                    first: document.getElementById('prop_name_search').value,
                                    last: document.getElementById('prop_surname_search').value,
                                    inst: document.getElementById('prop_inst_search').value,
                                    dropdown: 1
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_swop_results').innerHTML = response;
                                    document.getElementById('create_participant').style.display='block';
                                }
                                                           ).fail(failAlert);"/></td>
			</tr>
		</table>
                        <!-- shows select menu of search results. -->
                <div id="show_swop_results"></div>
               
                                    </div>

                </td>
		<tr><td><strong>Type:</strong></td>
		<td><select id="type_new">
                        <option value="">-----</option>
                        <?//get types
                        $select_types_sqlsafe="SELECT * FROM Institution_Types";
                        include "../include/dbconnopen.php";
                        $types=mysqli_query($cnnSWOP, $select_types_sqlsafe);
                        while ($type=mysqli_fetch_row($types)){
                            ?>
                        <option value="<?echo $type[0]?>"><?echo $type[1];?></option>
                                <?
                        }
                        include "../include/dbconnclose.php";
                        ?>
                    </select></td>
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
		
	</tr>
	<tr>
			<td colspan="2"><input type="button" value="Save" onclick="
                            
                            /* if they searched for a contact then indicate that the select
                             * element will exist (id=choose_participant).  */
                            if (document.getElementById('choose_participant')){
                            var contact=document.getElementById('choose_participant').value;}
                        else{/* otherwise, no contact will be entered: */
                            var contact='';}
                            
				$.post(
						'../ajax/add_institution.php',
						{
							name: document.getElementById('name_new').value,
							type: document.getElementById('type_new').value,
							address_num: document.getElementById('new_user_address_number').value,
                                                        address_dir: document.getElementById('new_user_address_direction').value,
                                                        address_name: document.getElementById('new_user_address_street').value,
                                                        address_type: document.getElementById('new_user_address_street_type').value,
							contact: contact,
							phone: document.getElementById('phone_new').value
                                                },
						function (response){
							document.getElementById('confirmation').innerHTML = response;
						}
				).fail(failAlert);
                                    ;"/></td>
        </tr>
</table>
<div id="confirmation"></div>
</div>
<?
	include "../../footer.php";
?>
	