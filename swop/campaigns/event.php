<?
/* holds all information about an event (participants, subcampaign, location) */
	include "../../header.php";
	include "../header.php";
	include "../include/dbconnopen.php";
	$get_event_info_sqlsafe = "SELECT * FROM Campaigns_Events INNER JOIN Campaigns ON Campaigns_Events.Campaign_ID=Campaigns.Campaign_ID WHERE Campaign_Event_ID='" . mysqli_real_escape_string($cnnSWOP, $_GET['event']) . "'";
	$event_info = mysqli_query($cnnSWOP, $get_event_info_sqlsafe);
	$event = mysqli_fetch_array($event_info);
	include "../include/dbconnclose.php";
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#programs_selector').addClass('selected');
                $('#add_new_campaign').hide();
                $('#campaign_profile').hide();
		$('#add_date').hide();
		$('.edit').hide();
                $('.event_edit').hide();
                $('#property_search_div').hide();
	});
</script>
<div class="content_block" id="event_profile">
<h3>Event Profile - <?echo $event['Event_Name'];?></h3><hr/><br/>
		<table class="inner_table" style="width:50%;">
                    <!--Basic information here.  All editable.-->
            <tr><td><strong>Name: </strong></td><td><span class="event_show"><?echo $event['Event_Name'];?></span>
                            <input type="text" class="event_edit" id="event_new_name" value="<?echo $event['Event_Name'];?>">                                
                        </td></tr>
			<tr><td><strong>Date: </strong></td><td><span class="event_show"><?echo $event['Event_Date'];?></span>
							<input type="text" class="event_edit" id="event_new_date" value="<?echo $event['Event_Date'];?>"/>
				</td></tr>
			<tr><td><strong>Campaign: </strong></td><td><?echo $event['Campaign_Name'];?></td></tr>
			<tr><td><strong>Subcampaign: </strong></td><td><span class="event_show"><?echo $event['Subcampaign'];?></span>
					<select id="event_new_subcampaign" class="event_edit">
    <option value="0">-------</option>
    <?php
    $get_subcampaigns_sqlsafe="SELECT DISTINCT Subcampaign FROM Campaigns_Events WHERE Subcampaign!='0' AND Subcampaign IS NOT NULL 
        AND Campaign_ID='" . mysqli_real_escape_string($cnnSWOP, $_COOKIE['campaign']) . "' ORDER BY Subcampaign";
    include "../include/dbconnopen.php";
    $subcampaigns=mysqli_query($cnnSWOP, $get_subcampaigns_sqlsafe);
    while ($subcam=mysqli_fetch_row($subcampaigns)){
        ?>
    <option><?echo $subcam[0];?></option>
            <?
    }
    include "../include/dbconnclose.php";
    ?>
</select>
				</td></tr>
			<tr><td><strong>Location: </strong></td><td><span class="event_show"><?echo $event['Location'];?></span>
						<select id="event_new_location" class="event_edit">
    <option value="0">-------</option>
    <?
    $get_subcampaigns_sqlsafe="SELECT DISTINCT Location FROM Campaigns_Events WHERE Location!='0' AND Location IS NOT NULL  ORDER BY Location";
    include "../include/dbconnopen.php";
    $subcampaigns=mysqli_query($cnnSWOP, $get_subcampaigns_sqlsafe);
    while ($subcam=mysqli_fetch_row($subcampaigns)){
        ?>
    <option><?echo $subcam[0];?></option>
            <?
    }
    include "../include/dbconnclose.php";
    ?>
</select><br>
<span class="helptext event_edit">Or, add a new location: </span><input type="text" id="new_location" class="event_edit">
				</td></tr>
			<tr><td class="blank"></td><td class="blank"><a href="javascript:;" class="event_edit" onclick="
                            if (document.getElementById('new_location').value!=''){
                            var location=document.getElementById('new_location').value;}
                            else{var location=document.getElementById('event_new_location').value;}
                            $.post('../ajax/add_event.php',
                                {
                                    action: 'edit',
                                    id: '<?echo $event['Campaign_Event_ID'];?>',
                                    name: document.getElementById('event_new_name').value,
                                    date: document.getElementById('event_new_date').value,
                                    subcampaign: document.getElementById('event_new_subcampaign').value,
                                    location: location
                                },
                            function (response){
                                window.location='event.php?event=<?echo $event['Campaign_Event_ID'];?>';
                            })">Save</a><a href="javascript:;" onclick="$('.event_edit').toggle();
                                $('.event_show').toggle();" class="event_show">Edit</a></td></tr>
		</table>
		<br/>
                
                <!--This was designed to resemble a sign-in sheet.  Shows list of people who attended with their roles, institutions, and other
                information.  Can add people and edit information about them here. -->
                
		<h4>Attendance</h4>
		<table class="inner_table" style="border-bottom: 2px solid #696969;font-size:.8em;">
			<tr style="border-bottom:2px solid #696969;"><th>ID</th><th>Name</th><th>Role</th><th>Primary Institution</th><th>Home Phone</th><th>Cell Phone</th><th>Email address</th><th>Address</th><th></th></tr>
			<?php
                        /* get existing attendees: */
				$get_attendance_sqlsafe = "SELECT * FROM Participants_Events INNER JOIN Participants ON Participants_Events.Participant_ID=Participants.Participant_ID WHERE Event_ID='" . $event['Campaign_Event_ID'] . "'";
				include "../include/dbconnopen.php";
				$attendance = mysqli_query($cnnSWOP, $get_attendance_sqlsafe);
				while ($attendee = mysqli_fetch_array($attendance)) {
				//find current home address
				$find_institution_sqlsafe = "SELECT * FROM Institutions INNER JOIN Institutions_Participants ON Institutions.Institution_ID=Institutions_Participants.Institution_ID WHERE Institutions_Participants.Participant_ID='".$attendee['Participant_ID']."' AND Institutions_Participants.Is_Primary=1";
				$institution = mysqli_query($cnnSWOP, $find_institution_sqlsafe);
				$inst = mysqli_fetch_array($institution);
			?>
			<tr style="border-left:2px solid #696969;border-right:2px solid #696969;">
				<td class="blank"><?echo $attendee['Participant_ID'];?></td>
				<td class="blank"><a href="javascript:;" onclick="
                            $.post(
                            '../ajax/set_participant_id.php',
                            {
                                page: 'profile',
                                participant_id: '<?echo $attendee['Participant_ID'];?>'
                            },
                            function (response){
//                                if (response!='1'){
//                                    document.getElementById('show_error').innerHTML = response;
//                                }
                            window.location=response;
                                });"><?echo $attendee['Name_First']." ".$attendee['Name_Last'];?></a></td>
				<td class="blank"><span class="show <?echo $attendee['Participant_ID'];?>">
                                    <?
                                   /* this should be linked to the roles table, not dependent on these if/elses.  */
                                    if ($attendee['Role_Type']==6)
                    {echo 'Testimony&nbsp;';}elseif($attendee['Role_Type']==2){echo 'Speaker&nbsp;';}
                    elseif($attendee['Role_Type']==3){echo 'Chair&nbsp;';}elseif($attendee['Role_Type']==4)
                        {echo 'Floor Team&nbsp;';}elseif($attendee['Role_Type']==5){echo 'Media Contact&nbsp;';}
                        elseif($attendee['Role_Type']==7){echo 'Turnout&nbsp;';}
                        if ($attendee['Exceptional']==1){echo '(exceptional)';}?></span>
                                    <!-- also edit role here: -->
					<select class="edit <?echo $attendee['Participant_ID'];?>" id="edit_role_<?echo $attendee['Participant_ID'];?>">
					<option value="">----------</option>
							<option value="3" <?echo ($attendee['Role_Type']=='3' ? 'selected="selected"' :null);?>>Chair</option>
							<option value="2" <?echo ($attendee['Role_Type']=='2' ? 'selected="selected"' :null);?>>Speaker</option>
                            <option value="6" <?echo ($attendee['Role_Type']=='6' ? 'selected="selected"' :null);?>>Testimony</option>
							<option value="4" <?echo ($attendee['Role_Type']=='4' ? 'selected="selected"' :null);?>>Floor Team</option>
							<option value="7" <?echo ($attendee['Role_Type']=='7' ? 'selected="selected"' :null);?>>Turnout</option>
							<option value="5" <?echo ($attendee['Role_Type']=='5' ? 'selected="selected"' :null);?>>Media Contact</option>
					</select><br>
                                        <!--y/n exceptional question. -->
                                    <input type="checkbox" class="edit <?echo $attendee['Participant_ID'];?>" 
                                           id="edit_exceptional_<?echo $attendee['Participant_ID'];?>">
                                  <span class="edit <?echo $attendee['Participant_ID'];?>">  Was this person exceptional?</span>
				</td>
				<td class="blank">
                                    <!-- show the person's primary institution (useful for determining what institutions brought the greatest number
                                    of people to an event) -->
                                    <span class="show <?echo $attendee['Participant_ID'];?>"><?echo $inst['Institution_Name'];?></span>
                                    <!-- edit primary institution. -->
					<select class="edit <?echo $attendee['Participant_ID'];?>" id="edit_inst_<?echo $attendee['Participant_ID'];?>">
						<option value="">-----</option>
                            <?
                                $get_all_insts_sqlsafe="SELECT * FROM Institutions ORDER BY Institution_Name;";
                                //include "../include/dbconnopen.php";
                                $all_insts=mysqli_query($cnnSWOP, $get_all_insts_sqlsafe);
                                $count_insts=mysqli_num_rows($all_insts);
                                while ($this_inst=mysqli_fetch_row($all_insts)){
                            ?>
						<option value="<?echo $this_inst[0];?>" <?echo ($inst['Institution_ID']==$this_inst['0'] ? 'selected="selected"' :null);?>><?echo $this_inst[1];?></option>
                            <?
                                }
                                //include "../include/dbconnclose.php";
                            ?>
					</select>
				</td>
                                <!-- Edit other participant info: -->
				<td class="blank"><span class="show <?echo $attendee['Participant_ID'];?>"><?echo $attendee['Phone_Day'];?></span>
					<input type="text" class="edit <?echo $attendee['Participant_ID'];?>" value="<?echo $attendee['Phone_Day'];?>" id="edit_home_phone_<?echo $attendee['Participant_ID'];?>" style="width:80px;" />
				</td>
				<td class="blank"><span class="show <?echo $attendee['Participant_ID'];?>"><?echo $attendee['Phone_Evening'];?></span>
					<input type="text" class="edit <?echo $attendee['Participant_ID'];?>" value="<?echo $attendee['Phone_Evening'];?>" id="edit_cell_phone_<?echo $attendee['Participant_ID'];?>" style="width:80px;" />
				</td>
				<td class="blank"><span class="show <?echo $attendee['Participant_ID'];?>"><?echo $attendee['Email'];?></span>
					<input type="text" class="edit <?echo $attendee['Participant_ID'];?>" value="<?echo $attendee['Email'];?>" id="edit_email_<?echo $attendee['Participant_ID'];?>" />
				</td>
				<td class="blank">
                                    <!-- Address is complicated, of course, because it involves linking to a property (and possibly
                                    creating a property and THEN linking to it). -->
                                    <!-- Address goes here... -->
                               <?     $address_info_sqlsafe="SELECT Address_Street_Num, Address_Street_Direction, Address_Street_Name, Address_Street_Type 
                                        FROM Participants_Properties INNER JOIN Properties ON Participants_Properties.Property_ID=
                                        Properties.Property_ID WHERE Primary_Residence=1 AND Participant_ID='" . $attendee['Participant_ID'] . "' 
                                            AND (End_Primary IS NULL OR End_Primary='0000-00-00 00:00:00')";
                             //  echo $address_info_sqlsafe;
                                $address=mysqli_query($cnnSWOP, $address_info_sqlsafe);
                                $address_info_temp=mysqli_fetch_array($address);
                                echo $address_info_temp['Address_Street_Num'] . " " .$address_info_temp['Address_Street_Direction'] . " ".
                                        $address_info_temp['Address_Street_Name']  . " ".$address_info_temp['Address_Street_Type'];
                                ?>
				</td>
				<td class="blank">
                                    <!-- shows editable elements: -->
                                    <a class="helptext <?echo $attendee['Participant_ID'];?> no_view" href="javascript:;" 
                                       onclick="$('.<?echo $attendee['Participant_ID'];?>').toggle();">Edit...</a>
                                    
                                    <!-- save changes. -->
					<a class="helptext <?echo $attendee['Participant_ID'];?> edit" href="javascript:;" onclick="
                                            if (document.getElementById('edit_exceptional_<?echo $attendee['Participant_ID'];?>').checked==true){var exceptional=1;}
                                            else{var exceptional=0;}
                                            $.post(
                                                            '../ajax/edit_participant.php',
                                                            {
                                                                    action: 'edit_via_event',
                                                                    participant: '<?echo $attendee['Participant_ID'];?>',
                                                                    event: '<?echo $event['Campaign_Event_ID'];?>',
                                                                    participant_event: '<?echo $attendee['Participants_Events_ID'];?>',
                                                                    role: document.getElementById('edit_role_<?echo $attendee['Participant_ID'];?>').value,
                                                                    inst: document.getElementById('edit_inst_<?echo $attendee['Participant_ID'];?>').value,
                                                                    day_phone: document.getElementById('edit_home_phone_<?echo $attendee['Participant_ID'];?>').value,
                                                                    evening_phone: document.getElementById('edit_cell_phone_<?echo $attendee['Participant_ID'];?>').value,
                                                                    email: document.getElementById('edit_email_<?echo $attendee['Participant_ID'];?>').value,
                                                                    ex: exceptional
                                                            },
                                                            function(response){
                                                                //document.write(response);
                                                                    window.location='event.php?event=<?echo $event['Campaign_Event_ID'];?>';
                                                            })">Save</a>
				</td>
				</tr>
                                <!-- row if address needs to be added/changed: -->
				<tr style="border-left:2px solid #696969;border-right:2px solid #696969;">
				<td colspan="4" style="padding:0;"></td>
				<td colspan="5" style="padding:0;">
                                    <!-- search first, to see if his/her address is in the system: -->
                                <a href="javascript:;" onclick="$('#property_search_div_<?echo $attendee['Participant_ID'];?>').toggle();" class="no_view <?echo $attendee['Participant_ID'];?> edit">
                                    Search for a property</a>
                        <div class="edit" id="property_search_div_<?echo $attendee['Participant_ID'];?>"><table class="search_table">
			<tr>
                            <!-- simple search: -->
				<td><strong>Street Name:</strong></td>
				<td><input type="text" id="prop_name_search_<?echo $attendee['Participant_ID'];?>" /></td>
				<td><strong>PIN:</strong></td>
				<td><input type="text" id="pin_search_<?echo $attendee['Participant_ID'];?>" /></td>
			</tr>
		
			<tr>
				<td colspan="4"><input type="button" value="Search" onclick="
                               $('#prop_link_button_<?echo $attendee['Participant_ID'];?>').show();
							   $.post(
                                '../ajax/search_props.php',
                                {
                                    name: document.getElementById('prop_name_search_<?echo $attendee['Participant_ID'];?>').value,
                                    pin: document.getElementById('pin_search_<?echo $attendee['Participant_ID'];?>').value,
                                    dropdown: 1
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_swop_results_<?echo $attendee['Participant_ID'];?>').innerHTML = response;
                                    document.getElementById('add_new_prop_<?echo $attendee['Participant_ID'];?>').style.display='block';
                                }
                           )"/></td>
			</tr>
		</table>
                            <!-- show search results -->
                        <div id="show_swop_results_<?echo $attendee['Participant_ID'];?>"></div>
                        
                        <!-- add property as address:  -->
                        <span id="add_new_prop_<?echo $attendee['Participant_ID'];?>" style="display:none;"><input style="display:none;" id="prop_link_button_<?echo $attendee['Participant_ID'];?>" type="button" value="Link This Property" onclick="
                                                                       $.post(
                                                                        '../ajax/link_property.php',
                                                                        {
                                                                            property: document.getElementById('choose_property').value,
                                                                            person: '<?echo $attendee['Participant_ID']?>',
																			link_from_event: '1'
                                                                        },
                                                                        function (response){
                                                                            //document.write(response);
                                                                                window.location='event.php?event=<?echo $event['Campaign_Event_ID'];?>';
                                                                        }
                                                                   )">
                            <!-- or create a property here: -->
                            <br>Didn't find the property you were looking for?  Quick add it here:
                            <table class="search_table">
	
	<tr>
		<td><strong>Street Address:</strong></td>
		<!-- Borrowing IDs here from Bickerdike so they'll format correctly, sorry they're a little clumsy. -MW -->
		<td><input type="text" id="new_user_address_number_<?echo $attendee['Participants_Events_ID'];?>" />
                    <select id="new_user_address_direction_<?echo $attendee['Participants_Events_ID'];?>">
                        <option value="N">N</option>
                        <option value="S">S</option>
                        <option value="E">E</option>
                        <option value="W">W</option>
                    </select> <input type="text" id="new_user_address_street_<?echo $attendee['Participants_Events_ID'];?>" /> 
                    <select id="new_user_address_street_type_<?echo $attendee['Participants_Events_ID'];?>">
                        <option value="ST">ST</option>
                        <option value="AVE">AVE</option>
                        <option value="RD">RD</option>
                        <option value="PL">PL</option>
                        <option value="CT">CT</option>
                        <option value="BLVD">BLVD</option>
                    </select><br/>
			<span class="helptext">e.g. 1818 S Paulina St</span>
		</td>
		<td><strong>PIN:</strong></td>
		<td><input type="text" id="pin_new_<?echo $attendee['Participants_Events_ID'];?>" maxlength="10"/></td>
	</tr>
	
	<tr>
            <!-- adds property to system and links it to this participant (as address, with primary residence=1) -->
			<td colspan="2"><input type="button" value="Save" onclick="
				$.post(
						'../ajax/add_property.php',
						{
							num: document.getElementById('new_user_address_number_<?echo $attendee['Participants_Events_ID'];?>').value,
                                                        dir: document.getElementById('new_user_address_direction_<?echo $attendee['Participants_Events_ID'];?>').value,
                                                        name: document.getElementById('new_user_address_street_<?echo $attendee['Participants_Events_ID'];?>').value,
                                                        type: document.getElementById('new_user_address_street_type_<?echo $attendee['Participants_Events_ID'];?>').value,
							pin: document.getElementById('pin_new_<?echo $attendee['Participants_Events_ID'];?>').value,
                                                        link_from_event: 1,
                                                        person: '<?echo $attendee['Participant_ID'];?>'
                                                },
						function (response){
							document.getElementById('confirmation_<?echo $attendee['Participants_Events_ID'];?>').innerHTML = response;
                                                        
						}
				);"/></td>
        </tr>
</table>
<div id="confirmation_<?echo $attendee['Participants_Events_ID'];?>"></div>
                        </span>
                        </div>
                                
                                
                                </td>
			</tr>
			<?
				}
				//include "../include/dbconnclose.php";
			?>
                        
                        
                        <!-- add new participants to event:  -->
			<tr style="border-left:2px solid #696969;border-right:2px solid #696969;"><td colspan="9"><a href="javascript:;" class="no_view" style="margin-left:115px;" onclick="$('#search_participants_div_<?echo $event['Participant_ID'];?>').toggle();
										$('#link_button_<?echo $event['Participant_ID'];?>').hide();">Add a participant...</a><div id="search_participants_div_<?echo $event['Participant_ID'];?>" style="display:none;">
                                                                                    
                       <!-- search system for person: -->
                        <span class="helptext">First, search for the participant in the database:</span>
			<table class="search_table" style="margin-left:5px;margin-right:0;">
			<tr>
				<td><strong>First Name:</strong></td>
				<td><input type="text" id="name_search_<?echo $event['Participant_ID'];?>" style="width:80px;" /></td>
				<td><strong>Last Name:</strong></td>
				<td><input type="text" id="surname_search_<?echo $event['Participant_ID'];?>" style="width:80px;" /></td>
			</tr>
			<tr>
				<td><strong>Primary Institution:</strong></td>
				<td colspan="3"><select id="inst_quick_search_<?echo $event['Participant_ID'];?>">
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
                            <!-- perform search -->
				<td colspan="4" class="blank"><input type="button" value="Search" id="search_button_<?echo $event['Participant_ID'];?>" onclick="
                               $('#link_button_<?echo $event['Participant_ID'];?>').show();
							   $('#create_participant_<?echo $event['Participant_ID'];?>').show();
							   $.post(
                                '../ajax/search_users.php',
                                {
                                    first: document.getElementById('name_search_<?echo $event['Participant_ID'];?>').value,
                                    last: document.getElementById('surname_search_<?echo $event['Participant_ID'];?>').value,
                                    inst: document.getElementById('inst_quick_search_<?echo $event['Participant_ID'];?>').value,
                                    dropdown: 1,
                                    multiple: 1,
                                    id: '<?echo $event['Participant_ID'];?>'
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_results_<?echo $event['Participant_ID'];?>').innerHTML = response;
                                }
                           )"/><br/>
                                    <!-- view search results: -->
					<span id="show_results_<?echo $event['Participant_ID'];?>"></span>
                                        
                                        <!-- if search was successful, add this person to the event: -->
                                        <input type="button" value="Add Existing Attendee to Event" id="link_button_<?echo $event['Participant_ID'];?>" onclick="
                   $.post(
                    '../ajax/add_participant.php',
                    {
                        action: 'link_event',
                        participant: document.getElementById('choose_participant_<?echo $event['Participant_ID'];?>').value,
                        event: '<?echo $event['Campaign_Event_ID'];?>'
                    },
                    function (response){
                        //document.write(response);
                        window.location='event.php?event=<?echo $event['Campaign_Event_ID'];?>';
                    }
               )"> 
					</td>
			</tr>
		</table>
<!-- if the search was not successful, add the person here. -->
                <div id="create_participant_<?echo $event['Participant_ID'];?>" style="display:none;">
                    <span class="helptext">Not in the database? Add them here:</span>
					<table class="inner_table" style="width:50%;border:1px solid #696969;">
                                            <!-- includes basic info (name, phones, inst, email) and event-specific info (role) -->
						<tr><td><strong>First Name: </strong></td><td><input type="text" id="first_name_new"/></td></tr>
						<tr><td><strong>Last Name: </strong></td><td><input type="text" id="last_name_new"/></td></tr>
						<tr><td><strong>Role: </strong></td>
							<td>
								<select id="role_new">
                                                                    <option value="">-----</option><?
                                        //get event roles
                                        include "../include/dbconnopen.php";
                                        $select_roles_sqlsafe="SELECT * FROM Participants_Roles";
                                        $roles=mysqli_query($cnnSWOP, $select_roles_sqlsafe);
                                        while ($role=mysqli_fetch_row($roles)){
                                            ?>
                                        <option value="<?echo $role[0];?>"><?echo $role[1];?></option>
                                                <?
                                        }
                                        include "../include/dbconnclose.php";
                                        ?></select>
							</td></tr>
						<tr><td><strong>Primary Institution: </strong></td>
							<td>
								<select id="inst_new">
									<option value="">-----</option>
  							  <?
										$get_institutions_sqlsafe = "SELECT * FROM Institutions ORDER BY Institution_Name";
										include "../include/dbconnopen.php";
										$institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
										while ($institution = mysqli_fetch_array($institutions)) {?>
									<option value="<?echo $institution['Institution_ID'];?>"><?echo $institution['Institution_Name'];?></option>
									<? }
										include "../include/dbconnclose.php";
									?>
								</select>
							</td></tr>
						<tr><td><strong>Home Phone: </strong></td><td><input type="text" id="home_phone_new"/></td></tr>
						<tr><td><strong>Cell Phone: </strong></td><td><input type="text" id="cell_phone_new"/></td></tr>
						<tr><td><strong>Email Address: </strong></td><td><input type="text" id="email_new"/></td></tr>
					</table>
                    <!-- Creates a DB profile for them and adds them to the event: -->
				<input type="button" value="Add to Database and Event" style="margin-left:115px;" onclick="
                       $.post(
                    '../ajax/add_participant.php',
                    {
                        action: 'new_person_link_event',
                        first: document.getElementById('first_name_new').value,
                        last: document.getElementById('last_name_new').value,
                        inst: document.getElementById('inst_new').value,
						role: document.getElementById('role_new').value,
                        event: '<?echo $event['Campaign_Event_ID'];?>',
						home_phone: document.getElementById('home_phone_new').value,
						cell_phone: document.getElementById('cell_phone_new').value,
						email: document.getElementById('email_new').value
                    },
                    function (response){
                        //document.write(response);
                        window.location='event.php?event=<?echo $event['Campaign_Event_ID'];?>';
                    }
               );"></div>

				</div></td></tr>
		</table>

</div>
<br/><br/>
<?
	include "../../footer.php";
?>