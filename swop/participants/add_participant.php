<?include "../include/datepicker_simple.php";?>	

<h3>Participants</h3><hr/><br/>
<!-- This is a div that shows up under participants.php, when the "Add New Participant" button is clicked. -->
<h4>New Participant</h4><br/>

<table class="search_table">
	<tr>
		<td><strong>First Name:</strong></td>
		<td><input type="text" id="name_new" /></td>
		<td><strong>Last Name:</strong></td>
		<td><input type="text" id="surname_new" /></td>
	</tr>
	<tr>
		<td><strong>Date of Birth:</strong><br/>
			<span class="helptext">YYYY-MM-DD</span></td>
		<td><input type="text" id="dob_new" class="hasDatepickers" /></td>
		<td><strong>Gender:</strong></td>
		<td><select id="gender_new">
				<option value="">---------</option>
				<option value="m">Male</option>
				<option value="f">Female</option>
			</select>
		</td>
	</tr>
	
	<tr>
		<td><strong>Phone Number:</strong></td>
		<td><input type="text" id="phone_new" /></td>
		<td><strong>Email address:</strong></td>
		<td><input type="text" id="email_new" /></td>
	</tr>
        <tr>
            <!-- Only relevant for people who were being tracked before this database was completed: -->
            <td><strong>Date of first interaction:</strong><br/>
                <span class="helptext">(for people who were tracked before the database went live)</span></td>
            <td><input type="text" id="first_interaction" class="hasDatepickers"></td>
            <td><strong>Primary Organizer:</strong></td>
            <td>
                <table class="search_table" style="margin-left:5px;margin-right:0;">
                    <!-- search for a primary organizer.  must be someone who is already in the database: -->
			<tr>
				<td><strong>First Name:</strong></td>
				<td><input type="text" id="name_quick_search" style="width:80px;" /></td>
				<td><strong>Last Name:</strong></td>
				<td><input type="text" id="surname_quick_search" style="width:80px;" /></td>
			</tr>
			<tr>
				<td><strong>Primary Institution:</strong></td>
				<td colspan="3"><select id="inst_quick_search">
                                    <option value="">-----</option>
                                    <?
                                                        $get_institutions_sqlsafe = "SELECT * FROM Institutions ORDER BY Institution_Name";
                                                        include "../include/dbconnopen.php";
                                                        $institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
                                                        while ($institution = mysqli_fetch_array($institutions)) {?>
                                    <option value="<?echo $institution['Institution_ID'];?>"><?echo $institution['Institution_Name'];?></option>
                                                        <?}
                                                        //include "../include/dbconnclose.php";
                                                ?>
                                </select>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="blank">
                                    <input type="button" value="Search" id="search_button" onclick="
								var has_organizer=1;
							   $.post(
                                '../ajax/search_users.php',
                                {
                                    first: document.getElementById('name_quick_search').value,
                                    last: document.getElementById('surname_quick_search').value,
                                    inst: document.getElementById('inst_quick_search').value,
                                    dropdown: 1
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_results').innerHTML = response;
                                }
                           )"/>
					<div id="show_results" style="margin-left:115px;"></div>	   
					</td>
			</tr>
		</table>
            </td>
        </tr>
        <tr>
			<td><strong>Primary Institution:</strong></td>
            <td>
                <select id="primary_inst_new">
    <option value="">-----</option>
    <?
			$get_institutions_sqlsafe = "SELECT * FROM Institutions ORDER BY Institution_Name";
			include "../include/dbconnopen.php";
			$institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
			while ($institution = mysqli_fetch_array($institutions)) {?>
    <option value="<?echo $institution['Institution_ID'];?>"><?echo $institution['Institution_Name'];?></option>
			<?}
			//include "../include/dbconnclose.php";
		?>
</select>
            </td>
			<td><strong>Is this person a member of the housing pool?</strong></td>
			<td><select id="pool_y_n">
				<option value="">----</option>
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select></td>	
	</tr>
	<tr>
		<td colspan="2"></td>
                <!-- This determines the pool progress options for this person.  Different types
                have different things to finish. -->
		<td><strong>Housing pool type:</strong></td>
		<td><select id="pool_type">
			<option value="">-------</option>
									<?
               $get_types_sqlsafe="SELECT * FROM Pool_Member_Types;";
                include "../include/dbconnopen.php";
                $all_types=mysqli_query($cnnSWOP, $get_types_sqlsafe);
                while ($type=mysqli_fetch_row($all_types)){
                ?><option value="<?echo $type[0];?>"><?echo $type[1];?></option>
                        <?
                }
                include "../include/dbconnclose.php";
                ?>
		</select></td>
	</tr>
	<tr>
			<td colspan="4"><input type="button" value="Save" onclick="
                            var name=document.getElementById('name_new').value;
                            var surname=document.getElementById('surname_new').value;
                            if (name=='' || surname==''){
                                alert('Please enter a first and last name for this participant.');
                                return false;
                            }
                            if (document.getElementById('choose_participant')===null){
                                var organizer='';
                            }
                            else{var organizer=document.getElementById('choose_participant').value;}
                            //alert(organizer);
                            
                            $.post(
            '../ajax/program_duplicate_check.php',
            {
                action: 'person',
                first_name: document.getElementById('name_new').value,
		last_name: document.getElementById('surname_new').value
            },
            function (response){
                if (response != ''){
                    /* check whether a person with this name is already in the database: */
                    var deduplicate = confirm(response);
                    if (deduplicate){
                                $.post(
						'../ajax/add_participant.php',
						{
							first_name: document.getElementById('name_new').value,
							last_name: document.getElementById('surname_new').value,
							dob: document.getElementById('dob_new').value,
							gender: document.getElementById('gender_new').value,
							email: document.getElementById('email_new').value,
							day_phone: document.getElementById('phone_new').value,
                                                        first_date: document.getElementById('first_interaction').value,
                                                        primary_organizer: organizer,
                                                        primary_inst: document.getElementById('primary_inst_new').value,
														pool: document.getElementById('pool_y_n').value,
														pool_type: document.getElementById('pool_type').value
                                                },
						function (response){
							document.getElementById('confirmation').innerHTML = response;
						}
				); 
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
							email: document.getElementById('email_new').value,
							day_phone: document.getElementById('phone_new').value,
                                                        first_date: document.getElementById('first_interaction').value,
                                                        primary_organizer: organizer,
                                                        primary_inst: document.getElementById('primary_inst_new').value,
														pool: document.getElementById('pool_y_n').value,
														pool_type: document.getElementById('pool_type').value
                                                },
						function (response){
							document.getElementById('confirmation').innerHTML = response;
						}
				);
                }
            }
            );"/></td>
        </tr>
</table>
<br/><br/>
<!-- shows message confirming person creation: -->
<div id="confirmation" style="margin-left:auto;margin-right:auto;width:500px;"></div>