<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

include "../../header.php";
include "../header.php";
include "../include/datepicker_simple.php";
    if($_GET['history']==1){
			?>
	<script type="text/javascript">
		$(document).ready(function() {
			window.location.hash="activity_history";
		});
	</script>
	<?php }?>
        
        <!-- Attention: every person in the database has both a participant profile and a pool profile.
        The pool profile only shows up when they are in the pool, and the participant profile
        only shows up when they are not in the pool.  The pool profile includes everything that
        is on this participant profile, plus some more information.
        -->
        
<div id="participant_profile">
    <script type="text/javascript">
	$(document).ready(function(){
		$('#participants_selector').addClass('selected');
		$('.basic_info_edit').hide();
                $('#property_search_div').hide();
                $('#household_addition').hide();
                $('.details_rows').hide();
                $('.extra_events').hide();
                $('.extra_history').hide();
		});
</script>

<?php
include "../classes/participant.php";
$participant=new Participant();
$participant->load_with_participant_id($_COOKIE['participant']);
	include "../include/dbconnopen.php";
	$participant_query_sqlsafe = "SELECT * FROM Participants WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_COOKIE['participant']) . "'";
	$get_participant = mysqli_query($cnnSWOP, $participant_query_sqlsafe);
	$parti = mysqli_fetch_array($get_participant);
        
?>

	<h3>Participant Profile - <?php echo $parti['Name_First'] . " " . $parti['Name_Last'];?>
	</h3><hr/><br/>
	
        <!---Basic information about this person: -->
	<table class="profile_table">
		<tr>
			<td width="45%"> <!--Basic Info-->
				<table class="inner_table" style="border: 2px solid #696969;">
					<tr><td><strong>Database ID: </strong></td><td><?php echo $parti['Participant_ID']; ?></td></tr>
					<tr>
						<td><strong>Name: </strong></td>
						<td>
							<span class="basic_info_show"><?php echo $parti['Name_First'] . " " . $parti['Name_Last'];?></span>
							<input class="basic_info_edit" id="first_name_edit" value="<?php echo $parti['Name_First'];?>" style="width:100px;"/>&nbsp;
							<input class="basic_info_edit" id="last_name_edit" value="<?php echo $parti['Name_Last'];?>" style="width:100px;"/>
						</td>
					</tr>
					
					<tr>
						<td><strong>Home Phone Number: </strong></td>
						<td>
							<span class="basic_info_show"><?php echo $parti['Phone_Day'];?></span>
							<input class="basic_info_edit" id="day_phone_edit" value="<?php echo $parti['Phone_Day'];?>"/>
						</td>
					</tr>
                                        <tr>
						<td><strong>Cell Phone Number: </strong></td>
						<td>
							<span class="basic_info_show"><?php echo $parti['Phone_Evening'];?></span>
							<input class="basic_info_edit" id="eve_phone_edit" value="<?php echo $parti['Phone_Evening'];?>"/>
						</td>
					</tr>
					<tr>
						<td><strong>E-mail Address: </strong></td>
						<td>
							<span class="basic_info_show"><?php echo $parti['Email'];?></span>
							<input class="basic_info_edit" id="email_edit" value="<?php echo $parti['Email'];?>"/>
						</td>
					</tr>
					<tr>
						<td><strong>Date of Birth: </strong></td>
						<td>
							<span class="basic_info_show"><?php echo $parti['Date_of_Birth'];?></span>
							<input class="basic_info_edit hasDatepickers" id="dob_edit" value="<?php echo $parti['Date_of_Birth'];?>"/>
						</td>
					</tr>
					<tr>
						<td><strong>Gender: </strong></td>
						<td>
							<span class="basic_info_show"><?php if ($parti['Gender']=='m') {
													echo "Male";
												} else if ($parti['Gender']=='f') {
													echo "Female";
												};?></span>
							<select class="basic_info_edit" id="gender_edit"/>
									<option value="">-------</option>
									<option value="m" <?php echo($parti['Gender']=='m' ? 'selected="selected"' :null);?>>Male</option>
									<option value="f" <?php echo($parti['Gender']=='f' ? 'selected="selected"' :null);?>>Female</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><strong>Languages Spoken: </strong></td>
						<td>
							<span class="basic_info_show">
								<?
									if ($parti['Lang_Eng']==1) {echo "English<br/>";}
									if ($parti['Lang_Span']==1) {echo "Spanish<br/>";}
									if ($parti['Lang_Other']==1) {echo "Other<br/>";}
                                                                        echo "&nbsp - " .$parti['Other_Lang_Specify'];
								?>
							</span>
							<span class="basic_info_edit">
								<input type="checkbox" id="english_edit" <?php echo($parti['Lang_Eng']==1 ? "checked='checked'" : null);?>/>English<br/>
								<input type="checkbox" id="spanish_edit" <?php echo($parti['Lang_Span']==1 ? "checked='checked'" : null);?>/>Spanish<br/>
								<input type="checkbox" id="other_edit" <?php echo($parti['Lang_Other']==1 ? "checked='checked'" : null);?>/>Other <br/>
                                                                If other, please specify: <input type="text" id="other_specify_edit" value="<?php echo $parti['Other_Lang_Specify'];?>">
							</span>
						</td>
					</tr>
                                        <tr>
                                            <td><strong>Codename checkbox:</strong></td>
                                            <!-- this refers to whether or not the person has an ITIN. -->
                                            <td><span class="basic_info_show"><?php if ($parti['ITIN']==1){echo 'Yes';}else{echo 'No';}?></span>
                                                <input type="checkbox" id="never_tell" class="basic_info_edit"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <Strong>Ward: </Strong>
                                            </td>
                                            <td>
                                                <span class="basic_info_show"><?php echo $parti['Ward'];?></span>
                                                <input class="basic_info_edit" id="ward_edit" value="<?php echo $parti['Ward'];?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Primary Organizer:</strong></td>
                                            <!-- Can search the database for the primary organizer if s/he isn't already linked here. -->
                                            <td>
                                                <span><?php echo $participant->organizer;?></span>
												<span class="basic_info_edit helptext">Use the search tool below to change this person's primary organizer:</span>
                                                <span class="basic_info_edit">
                                                    <table class="search_table" style="margin-left:5px;margin-right:0;">
			<tr>
				<td><strong>First Name:</strong></td>
				<td><input type="text" id="name_search" style="width:80px;" /></td>
				<td><strong>Last Name:</strong></td>
				<td><input type="text" id="surname_search" style="width:80px;" /></td>
			</tr>
			<tr>
				<td><strong>Primary Institution:</strong></td>
				<td colspan="3"><select id="inst_quick_search">
    <option value="">-----</option>
    <?php
			$get_institutions_sqlsafe = "SELECT * FROM Institutions ORDER BY Institution_Name";
			include "../include/dbconnopen.php";
			$institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
			while ($institution = mysqli_fetch_array($institutions)) {?>
    <option value="<?php echo $institution['Institution_ID'];?>"><?php echo $institution['Institution_ID'] . ": " . $institution['Institution_Name'];?></option>
			<?php }
			//include "../include/dbconnclose.php";
		?>
</select>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="blank"><input type="button" value="Search" id="search_button_<?php echo $event['Campaign_Event_ID'];?>" onclick="
                               //$('#link_button_<?php echo $event['Campaign_Event_ID'];?>').show();
							   $.post(
                                '../ajax/search_users.php',
                                {
                                    first: document.getElementById('name_search').value,
                                    last: document.getElementById('surname_search').value,
                                    inst: document.getElementById('inst_quick_search').value,
                                    dropdown: 1
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_results').innerHTML = response;
                                }
                           ).fail(failAlert);"/>
                                    <!-- organizer results: -->
					<div id="show_results" style="margin-left:115px;"></div>	   
					</td>
			</tr>
		</table>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Notes save when save is clicked, not onchange.  Confusing because they are editable
                                            even when save button isn't visible. -->
                                            <td><strong>Notes: </strong></td>
                                            <td><span class="helptext">
                                                    Only 15000 characters will be saved in the database.
                                                </span><textarea id="notes_edit" maxlength="15000"><?php echo $parti['Notes'];?></textarea></td>
                                        </tr>
                                        <tr>
                                            <!-- Notes save when save is clicked, not onchange.  Confusing because they are editable
                                            even when save button isn't visible. -->
                                            <td><strong>Next Step Notes: </strong></td>
                                            <td><span class="helptext">
                                                    Only 1000 characters will be saved in the database.
                                                </span><textarea id="next_notes_edit" maxlength="1000"><?php echo $parti['Next_Notes'];?></textarea></td>
                                        </tr>
					<tr>
						<td colspan="2">
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
<a href="javascript:;" class="basic_info_show" onclick="
								$('.basic_info_show').toggle();
								$('.basic_info_edit').toggle();
						" style="margin-left:55px;">Edit...</a>
							<a href="javascript:;" class="basic_info_edit" onclick="
								if (document.getElementById('english_edit').checked) {var english = 1;}else {var english = 0;}
								if (document.getElementById('spanish_edit').checked) {var spanish = 1;}else {var spanish = 0;}
								if (document.getElementById('other_edit').checked) {var other = 1;}else {var other = 0;}
                                                                if (document.getElementById('never_tell').checked) {var code = 1;}else {var code = 0;}
                                                                var select_organizer=document.getElementById('choose_participant');
                                                                if(select_organizer != null){
                                                                //alert('yes!');
                                                                    var organizer = document.getElementById('choose_participant').options[document.getElementById('choose_participant').selectedIndex].value;
                                                                }
                                                                else{var organizer='<?php echo $participant->organizer_id;?>';}
								//alert(organizer);
                                                                $.post(
                                                                    '../ajax/edit_participant.php',
                                                                    {
                                                                        action: 'basic_info',
                                                                        id: '<?php echo $parti['Participant_ID'];?>',
                                                                        name: document.getElementById('first_name_edit').value,
                                                                        surname: document.getElementById('last_name_edit').value,
                                                                        day_phone: document.getElementById('day_phone_edit').value,
                                                                        evening_phone: document.getElementById('eve_phone_edit').value,
                                                                        email: document.getElementById('email_edit').value,
                                                                        dob: document.getElementById('dob_edit').value,
                                                                        gender: document.getElementById('gender_edit').value,
                                                                        english: english,
                                                                        spanish: spanish,
                                                                        other: other,
                                                                        code: code,
                                                                        other_specify: document.getElementById('other_specify_edit').value,
                                                                        ward: document.getElementById('ward_edit').value,
                                                                        notes: document.getElementById('notes_edit').value,
                                                                        next_notes: document.getElementById('next_notes_edit').value,
                                                                        primary_org: organizer
                                                                    },
                                                                    function (response){
									//document.write(response);
                                                                        window.location = 'participant_profile.php';
                                                                    }
                                                            ).fail(failAlert);" style="margin-left:55px;">Save!</a>
<?php
} //end access check
?>
						</td>
                                                
					</tr>
				</table><br/><br/>
                                
                                
                                <!-- Links people to institutions.  The primary institution is the most important
                                one here, but people will be searched by these connections, so all are relevant.
                                -->
				<h4>Institutional Connections</h4>
                <table class="inner_table" id="inst_conex">
                    <tr><th>Institution</th>
                        <th> Leader </th>
                        <th>Primary?</th>
                        <th></th>
                    </tr>
                    <?
                    include "../include/dbconnopen.php";
                    $get_inst_conns_sqlsafe = "SELECT * FROM Institutions_Participants INNER JOIN Institutions
                        ON Institutions_Participants.Institution_ID=Institutions.Institution_ID
                                                WHERE Institutions_Participants.Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_COOKIE['participant']) . "'";
                    $inst_conns = mysqli_query($cnnSWOP, $get_inst_conns_sqlsafe);
                    while ($inst = mysqli_fetch_array($inst_conns)){
                        ?>
                    <tr>
                        <td class="blank"><a href="javascript:;" onclick="$.post(
                        '../ajax/set_institution_id.php',
                        {
                            id: '<?php echo $inst['Institution_ID'];?>'
                        },
                        function (response){
                        window.location='../institutions/inst_profile.php';}).fail(failAlert);"><?php echo $inst['Institution_Name'];?></a></td>
                        <td class="blank"><?
                        /* This "leader" piece is rather ambiguous. Choice of any primary organizer, determines that this
                         * organizer can pull in this person (the subject of this profile) to an action if necessary.
                         */
                        if ($inst['Individual_Connection']!=''){
                        $get_name_sqlsafe="SELECT Name_First, Name_Last FROM Participants WHERE Participant_ID=".$inst['Individual_Connection'];
                        $name=mysqli_query($cnnSWOP, $get_name_sqlsafe);
                        $leader=mysqli_fetch_row($name);
                        echo $leader[0] . " " . $leader[1];}?></td>
                        <td class="blank"><?php if ($inst['Is_Primary']==1){
                            echo 'Yes';}else{echo 'No';} ?></td>
                    </tr>
					<tr>
                                            <!-- The "reason" is essentially a tiny notes field. -->
						<td colspan="2"><strong>Reason: </strong><?php echo $inst['Connection_Reason'];?></td>
                                                <!-- Delete connections here: -->
						<td>
<?php
if ($USER->site_access_level($SWOP_id) <= $AdminAccess){
?>
<input type="button"  value="Delete" onclick="
                                                           $.post(
                                                            '../ajax/pool_connections.php',
                                                            {
                                                                action: 'delete_conn',
                                                                link_id: '<?php echo $inst['Institutions_Participants_ID'];?>'
                                                            },
                                                            function (response){
                                                                //document.write(response);
                                                                window.location='participant_profile.php';
                                                            }
                                                       ).fail(failAlert);">
<?php
                                         } //end access check
?>
</td>
					</tr>
                            <?
                    }
                    include "../include/dbconnclose.php";
                    ?>
                                        <!-- Add new institutional connection: -->
                    <tr><td class="blank"><select id="institution">
                                <option value="">-----</option>
                                <?
                                $get_all_insts_sqlsafe="SELECT * FROM Institutions ORDER BY Institution_Name;";
                                include "../include/dbconnopen.php";
                                $all_insts=mysqli_query($cnnSWOP, $get_all_insts_sqlsafe);
                                $count_insts=mysqli_num_rows($all_insts);
                                while ($inst=mysqli_fetch_row($all_insts)){
                                    ?><option value="<?php echo $inst[0];?>"><?php echo $inst[1];?></option>
                                        <?
                                }
                                include "../include/dbconnclose.php";
                                ?><
                            </select></td>
                            <td class="blank"><select id="connection">
                        <option value="">--Primary Organizers--</option>
                            <?php
			$get_primarys_sqlsafe = "SELECT 
                                Organizer_Info.Participant_ID, Organizer_Info.Name_First, Organizer_Info.Name_Last
                                FROM Participants INNER JOIN 
                                Participants AS Organizer_Info ON Participants.Primary_Organizer = Organizer_Info.Participant_ID
                                GROUP BY Organizer_Info.Participant_ID ORDER BY Organizer_Info.Name_Last;";
			include "../include/dbconnopen.php";
			$primarys = mysqli_query($cnnSWOP, $get_primarys_sqlsafe);
			while ($primary = mysqli_fetch_array($primarys)) {?>
    <option value="<?php echo $primary['Participant_ID'];?>"><?php echo  $primary['Participant_ID'] . ": " .$primary['Name_First'] ." ". $primary['Name_Last'];?></option>
			<?php }
			include "../include/dbconnclose.php";
		?>
                        </td>
                                <td class="blank">
                                    <!-- Generally there should only be one primary inst connection.  That isn't enforced here, though. -->
                                    <select id="primary">
                                        <option value="">-----</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                    </tr>
					<tr>
						<td colspan="2"><strong>Reason: </strong> <input type="text" id="reason"></td>
						<td>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
                                    <input type="button" value="Add" onclick="
                                           $.post(
                                            '../ajax/pool_connections.php',
                                            {
                                                action: 'add_conn',
                                                person: '<?php echo $participant->participant_id;?>',
                                                inst: document.getElementById('institution').value,
                                                conn: document.getElementById('connection').value,
                                                prime: document.getElementById('primary').value,
                                                reason: document.getElementById('reason').value
                                            },
                                            function (response){
                                                //document.write(response);
                                                window.location='participant_profile.php';
                                            }
                                       ).fail(failAlert);">
<?php
} //end access check
?>
                                </td>
					</tr>
                </table>
    </td>
	<td>
            <!-- Events this person has attended.  While people have roles at events (often), those 
            roles aren't shown here.  They are visible on the event page. Events should probably be linked
            from here, but aren't. -->
		<h4>Campaign Events Attended</h4>
				<table class="inner_table" style="width:90%;">
					<tr><th>Date</th><th>Event</th><th>Associated Campaign</th></tr>
					<?
						$get_events_sqlsafe = "SELECT * FROM Participants_Events INNER JOIN Campaigns_Events ON Participants_Events.Event_ID=Campaigns_Events.Campaign_Event_ID WHERE Participants_Events.Participant_ID='" . $parti['Participant_ID'] . "' ORDER BY Campaigns_Events.Event_Date DESC";
						include "../include/dbconnopen.php";
						$events = mysqli_query($cnnSWOP, $get_events_sqlsafe);
                                                $count_events=0;
						while ($event = mysqli_fetch_array($events)) {
                                                    $count_events++;
					?>
                                    <!-- Shows 5 most recent events, hides the remainder -->
						<tr <?php if ($count_events>5){echo "class='extra_events'";}?>>
							<td><?$this_date=explode('-', $event['Event_Date']);
                                date_default_timezone_set('America/Chicago');
                                $show_date=mktime(0,0,0, $this_date[1], $this_date[2], $this_date[0]);
                                $display_date=date('n/j/Y', $show_date);
                                echo $display_date;
                                ?>
							</td>
							<td>
								<?php echo $event['Event_Name'];?>
							</td>
							<td>
								<?$get_campaign_sqlsafe = "SELECT * FROM Campaigns WHERE Campaign_ID='" . $event['Campaign_ID'] . "'";
									$campaign = mysqli_query($cnnSWOP, $get_campaign_sqlsafe);
									$cmpgn = mysqli_fetch_array($campaign);
									echo $cmpgn['Campaign_Name'];
								?>
							</td>
						</tr>
					<?
						}
					?>
                                                <!-- show/hide any events that are farther back than the 5 most recent: -->
                                </table><a href="javascript:;" onclick="$('.extra_events').toggle();">Show more events</a>
                                <br/>
                                
                                <!-- Add a person to another event.  This will almost always be done on the events page, which
                                is set up to look like a sign-in sheet.  The option is here, though.  We can't add "exceptional"ism
                                here, though. -->
				<span class="helptext">Add this participant to another event:</span><br/>
				<select id="event_add">
					<option value="">----Event Name----</option>
					<?
						$get_all_events_sqlsafe = "SELECT * FROM Campaigns_Events ORDER BY Event_Date DESC";
						$all_events = mysqli_query($cnnSWOP, $get_all_events_sqlsafe);
						while ($event=mysqli_fetch_array($all_events)){
					?>
						<option value="<?php echo $event['Campaign_Event_ID'];?>">
							<?$this_date=explode('-', $event['Event_Date']);
                                date_default_timezone_set('America/Chicago');
                                $show_date=mktime(0,0,0, $this_date[1], $this_date[2], $this_date[0]);
                                $display_date=date('n/j/Y', $show_date);
                                echo $display_date." - ".$event['Event_Name']." (".$event['Subcampaign'].")";
                                ?>
						  </option>
					<?
						}
						include "../include/dbconnclose.php";
					?>
				</select>
				<select id="event_role_add">
					<option value="">----Role---</option>
					<?
                                        //get roles
                                        $select_roles_sqlsafe="SELECT * FROM Participants_Roles";
										include "../include/dbconnopen.php";
                                        $roles=mysqli_query($cnnSWOP, $select_roles_sqlsafe);
                                        while ($role=mysqli_fetch_row($roles)){
                                            ?>
                                        <option value="<?php echo $role[0];?>"><?php echo $role[1];?></option>
                                                <?
                                        }
										include "../include/dbconnclose.php";
                                        ?>
				</select>
                                
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
				 <input type="button" value="Add to Event" onclick="$.post(
                    '../ajax/add_participant.php',
                    {
                        action: 'link_event',
                        participant: '<?php echo $parti['Participant_ID'];?>',
                        event: document.getElementById('event_add').value,
                        role: document.getElementById('event_role_add').value
                    },
                    function (response){
                        //document.write(response);
                        window.location='participant_profile.php';
                    }
               ).fail(failAlert);
              ">
<?php
                                                                               } //end access check
?>                <br/><br/>
                
                <!-- Households are mainly useful for pool participants.  They are used in cases where a single person
                might not be able to own a home, but a household of working adults may be able to. -->
		 <h4>Household</h4>
                 <!-- Link to household (or households, but almost certainly just one) that this person belongs to: -->
<?php $find_household_sqlsafe="SELECT * FROM Households_Participants INNER JOIN Households ON Household_ID=New_Household_ID
                            WHERE Participant_ID='".$parti['Participant_ID']."'";
                        include "../include/dbconnopen.php";
                        $this_household=mysqli_query($cnnSWOP, $find_household_sqlsafe);
                        while ($house=mysqli_fetch_array($this_household)){
                            ?><a href='family_profile.php?household=<?php echo $house['New_Household_ID']?>'><?php echo $house['Household_Name'];?></a><?php
                            if ($house['Head_of_Household']=='1'){echo ' (Head) ';}
                                echo "<br>";
                        }
                        include "../include/dbconnclose.php";?>
                            
                            <!-- Add this person to a  household: -->
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
                        <a href="javascript:;" onclick="$('#household_addition').toggle();" >Add this participant to a household:</a>
                        <div id="household_addition">
                            <!-- Either choose an existing household... -->
                        Add this person to an existing household: <select id="all_households"><option value="">-----</option>
                            <?php $get_households_sqlsafe = "SELECT * FROM Households;";
                            include "../include/dbconnopen.php";
                            $all_households=mysqli_query($cnnSWOP, $get_households_sqlsafe);
                            while ($household=mysqli_fetch_row($all_households)){
                                $get_primary_address_sqlsafe="SELECT Address_Street_Num, Address_Street_Direction, Address_Street_Name, Address_Street_Type
                                    FROM Households INNER JOIN Households_Participants ON New_Household_ID= Household_ID 
                                    INNER JOIN Participants_Properties ON
                                        Participants_Properties.Participant_ID= Households_Participants.Participant_ID
                                    INNER JOIN Properties ON Properties.Property_ID=Participants_Properties.Property_ID
                                    WHERE Head_of_Household=1 AND Primary_Residence=1 AND Household_ID=" . $household[0];
                                $primary_address=mysqli_query($cnnSWOP, $get_primary_address_sqlsafe);
                                $address=mysqli_fetch_row($primary_address);
                                ?><option value="<?php echo $household[0]?>"><?php echo $household[0] . ": " . $household[1] . '--' . $address[0] . " " . $address[1] . " " .
                                        $address[2] . " " . $address[3];?></option><?php
                            }
                            include "../include/dbconnclose.php";?>
                        </select><br>
                        <!-- And name them the head or not... -->
                        Is this person the head of household? <select id="is_head"><option value="">-----</option>
                            <option value="1">Yes</option>
                            <option value="2">No</option>
                        </select>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
                        <input type="button" value="Add to Household" onclick="$.post(
                                '../ajax/new_household.php',
                                {
                                    action: 'add',
                                    participant: '<?php echo $parti['Participant_ID'];?>',
                                    household: document.getElementById('all_households').value,
                                    head: document.getElementById('is_head').value
                                },
                                function (response){
                                    //document.write(response);
                                    window.location='participant_profile.php';
                                }).fail(failAlert);">
<?php
} //end access check
?>
<p>
                            
                            <!-- OR create a brand new household altogether: -->
                        Or, create a new household: <input type="text" id="new_household_name" value="Household Name"><br>
                        Is this person the head of household? <select id="is_head_new"><option value="">-----</option>
                            <option value="1">Yes</option>
                            <option value="2">No</option>
                        </select>
                        <input type="button" value="Create and Add to Household" onclick="$.post(
                                '../ajax/new_household.php',
                                {
                                    action: 'new',
                                    participant: '<?php echo $parti['Participant_ID'];?>',
                                    household: document.getElementById('new_household_name').value,
                                    head: document.getElementById('is_head_new').value
                                },
                                function (response){
                                    //document.write(response);
                                    window.location='participant_profile.php';
                                }).fail(failAlert);">
                        </div>
<?php
} //end access check
?>
<br/><br/>
        
		
         <br/></br> 
	</td>
                </tr>
                <tr><td colspan="2">
                        <!-- The person's address will be a linked property.  Some people may own other properties or may
                        have former addresses linked here. -->
                        <h4>Linked Properties</h4>
                        <table id="linked_properties_table" class="inner_table" style="width:100%;">
							<tr>
								<th>Street Address</th>
								<th>Unit #</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>End Reason</th>
								<th>Primary Residence?</th>
								<th>Rent or Own?</th>
								<th></th>
							</tr>
						<?$get_linked_props_sqlsafe="SELECT * FROM Participants_Properties INNER JOIN Properties ON 
                            Participants_Properties.Property_ID=Properties.Property_ID WHERE Participant_ID='".$parti['Participant_ID']."'";
                       // echo $get_linked_props;
                        include "../include/dbconnopen.php";
                        $linked_props =mysqli_query($cnnSWOP, $get_linked_props_sqlsafe);
                        while ($linked=mysqli_fetch_array($linked_props)){
                            ?>
							<!-- If this property is the person's primary residence (i.e. current address) then
                                                        the row will be highlighted in blue. -->
                                                        <tr
							<?
								if ($linked['Primary_Residence']==1 && $linked['End_Primary']=='0000-00-00 00:00:00') {
									echo " class='current_residence'";
								}
							?>
							>
								<td><?//echo $linked['Participant_Property_ID'];?><a href="javascript:;" onclick="$.post(
										'../ajax/set_property_id.php',
										{
											page: 'profile',
											id: '<?php echo $linked['Property_ID'];?>'
										},
										function (response){
                                                                                    window.location='../properties/profile.php';}).fail(failAlert);"><?php echo $linked['Address_Street_Num'] . " " .$linked['Address_Street_Direction'] ." " . $linked['Address_Street_Name'] . " " . $linked['Address_Street_Type'] . "<br>";?></a>
								</td>
								<td><input type="text" style="width:25px;" value="<?php echo $linked['Unit_Number'];?>" id="<?php echo $linked['Property_ID'];?>_unit" /></td>
								<!-- This start and end date refers to the time during which this property was
                                                                linked to this person. -->
                                                                <td><input type="text" style="width:68px;" value="<?php echo $linked['Start_Date'];?>" id="<?php echo $linked['Property_ID'];?>_start"  class="hasDatepickers"/></td>
								<td><input type="text" style="width:68px;" value="<?php echo $linked['End_Date'];?>" id="<?php echo $linked['Property_ID'];?>_end"  class="hasDatepickers"/></td>
								<td><select id="<?php echo $linked['Property_ID'];?>_end_reason">
										<option value="">------</option>
										<option value="sold" <?php echo($linked['Reason_End']=="sold" ? "selected='selected'" : null);?>>Sold</option>
										<option value="moved" <?php echo($linked['Reason_End']=="moved" ? "selected='selected'" : null);?>>Moved</option>
										<option value="foreclosed" <?php echo($linked['Reason_End']=="foreclosed" ? "selected='selected'" : null);?>>Foreclosed</option>
                                                                                <option value="short_sale" <?php echo($linked['Reason_End']=="short_sale" ? "selected='selected'" : null);?>>Short Sale</option>
									</select>
								</td>
								<td><input type="checkbox" id="<?php echo $linked['Property_ID'];?>_primary" <?php echo($linked['Primary_Residence']==1 ? "checked" : null);?>/>
								<!-- These dates refer to the period of time during which this property was 
                                                                this person's primary residence. -->	
                                                                    <input type="text" style="width:68px;" value="<?php echo $linked['Start_Primary'];?>" id="<?php echo $linked['Property_ID'];?>_start_primary"  class="hasDatepickers"/><br/>
									<span class="helptext" style="margin-left:10px;">to </span><input type="text" style="width:68px;" value="<?php echo $linked['End_Primary'];?>" id="<?php echo $linked['Property_ID'];?>_end_primary"  class="hasDatepickers"/>
								</td>
								<td><select id="<?php echo $linked['Property_ID'];?>_rent_own">
										<option value="">----</option>
										<option value="rent" <?php echo($linked['Rent_Own']=="rent" ? "selected='selected'" : null);?>>Renter</option>
										<option value="own" <?php echo($linked['Rent_Own']=="own" ? "selected='selected'" : null);?>>Owner</option>
									</select>
								</td>
                                                                <!-- These changes must be saved by clicked save.  Nothing saves onchange. -->
								<td>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
<a class="helptext" href="javascript:;" onclick="
                                                                    if (document.getElementById('<?php echo $linked['Property_ID'];?>_primary').checked==true){
                                                                        var primary=1;
                                                                    }
                                                                    else{
                                                                        var primary=0;
                                                                    }
										$.post(
                                                                                '../ajax/update_linked_property.php',
											{
												link_id: '<?php echo $linked['Participant_Property_ID'];?>',
												unit: document.getElementById('<?php echo $linked['Property_ID'];?>_unit').value,
												start: document.getElementById('<?php echo $linked['Property_ID'];?>_start').value,
												end: document.getElementById('<?php echo $linked['Property_ID'];?>_end').value,
												reason_end: document.getElementById('<?php echo $linked['Property_ID'];?>_end_reason').value,
												primary: primary,
												start_primary: document.getElementById('<?php echo $linked['Property_ID'];?>_start_primary').value,
												end_primary: document.getElementById('<?php echo $linked['Property_ID'];?>_end_primary').value,
												rent_own: document.getElementById('<?php echo $linked['Property_ID'];?>_rent_own').value
											},
											function (response) {
                                                                                            document.getElementById('save_response_<?php echo $linked['Property_ID'];?>').innerHTML='Thank you for editing the details on this linked property.';
											}
										).fail(failAlert);
                                                                                       ">Save changes...</a>
                                                                    <div id="save_response_<?php echo $linked['Property_ID'];?>"></div>
<?php
} //end access check
?>
</td>
							</tr>
							<?
                       			 }
                     		   include "../include/dbconnclose.php";
							?>					
						</table>
                        
                        <!-- Add a new linked property here.  Search on basic attributes.
                        A new property may not be added to the database here.  This search can only add a link
                        between this person and an existing property (in the DB).
                        -->
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
                        <a href="javascript:;" onclick="$('#property_search_div').toggle();" >Search for a property</a>
                        <div id="property_search_div"><table class="search_table">
			<tr>
				<td><strong>Street Name:</strong></td>
				<td><input type="text" id="prop_name_search" /></td>
				<td><strong>PIN:</strong></td>
				<td><input type="text" id="pin_search" /></td>
			</tr>
                        
			<tr>
				<td colspan="4"><input type="button" value="Search" onclick="
                               $('#link_button').show();
							   $.post(
                                '../ajax/search_props.php',
                                {
                                    name: document.getElementById('prop_name_search').value,
                                    pin: document.getElementById('pin_search').value,
                                    dropdown: 1
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_swop_results').innerHTML = response;
                                }
                                                           ).fail(failAlert);"/></td>
			</tr>
			<tr>
				<td colspan="4">
                                    <!-- Results dropdown shows up here, and then the "Link This Property" button appears. -->
				<div id="show_swop_results"></div>
<?php
} //end access check
?>
<span>
				<input type="button" value="Link This Property" onclick="
                                                                       $.post(
                                                                        '../ajax/link_property.php',
                                                                        {
                                                                            property: document.getElementById('choose_property').value,
                                                                            person: '<?php echo $parti['Participant_ID']?>'
                                                                        },
                                                                        function (response){
                                                                                window.location='participant_profile.php';
                                                                        }
                                                                       ).fail(failAlert);" id="link_button" style="display:none;"></span>
                       
				</td>
			</tr>
		</table>
                         </div>
                    </td></tr>
         <tr><td colspan="2">
                 
                 <!-- Activity history shows the changes over time in this person's status.  It's more detailed for pool members (and so 
                 on the pool profile), but here it includes institutional connections, entrances and exits from the pool, and leadership 
                 evolution.  Note that only admin users may see the leadership levels, since that is considered sensitive information.
                 -->
					   <h4 id="activity_history">Participant Activity History</h4>
					<table class="inner_table activity_history" style="width:100%">
						<?php
                                                /* get info from all relevant tables: */
							$get_events_sqlsafe = "SELECT Date_Changed, Active, Activity_Type, Pool_Status_Change_ID FROM Pool_Status_Changes
                                                            WHERE Participant_ID='" . $parti['Participant_ID'] . "'
                                                            UNION ALL
										SELECT Date_Added, '', Activity_Type, Participant_ID FROM Participants WHERE Participant_ID='".$parti['Participant_ID']."'
															UNION ALL
                                                            SELECT Date_Completed, Benchmark_Completed, Activity_Type, Pool_Progress_ID FROM Pool_Progress
                                                            WHERE Participant_ID='" . $parti['Participant_ID'] . "' AND Date_Completed!='0000-00-00'
                                                            UNION ALL
                                                            SELECT Date_Logged, Leader_Type, Activity_Type, Participants_Leader_ID FROM Participants_Leaders
                                                            WHERE Participant_ID='" . $parti['Participant_ID'] . "'
                                                            UNION ALL
                                                            SELECT Date_Logged, Institution_ID, Activity_Type, Institutions_Participants_ID 
                                                            FROM Institutions_Participants WHERE Participant_ID='" . $parti['Participant_ID'] . "'
                                                            UNION ALL
                                                            SELECT Date_Exited, Outcome_ID, Activity_Type, Pool_Outcome_ID FROM Pool_Outcomes
                                                            WHERE Participant_ID='" . $parti['Participant_ID'] . "'
                                                            ORDER BY Date_Changed DESC";
                                                        //echo $get_events;
							include "../include/dbconnopen.php";
							$events = mysqli_query($cnnSWOP, $get_events_sqlsafe);
                                                        $count_history=0;
							while ($event = mysqli_fetch_array($events)) {
                                                            $count_history++;
						?>
							<tr <?php if ($count_history>5){echo "class='extra_history'";}?>>
							<td><?php echo $event['Date_Changed']; ?></td>
								<td><?php if ($event['Activity_Type']==1) { 
                                                                    /* then this is a benchmark, and needs to be marked as such (bold "Benchmark") */
											$get_benchmark_sqlsafe = "SELECT * FROM Pool_Benchmarks WHERE Pool_Benchmark_ID='" . $event['Active'] . "'";
											$benchmark = mysqli_query($cnnSWOP, $get_benchmark_sqlsafe);
											$bm = mysqli_fetch_array($benchmark);
											echo "<strong>Benchmark: </strong>". $bm['Benchmark_Name'];
 } else if ($event['Activity_Type']==2) {
 /* then this is a leadership level, and the DB int needs to be shown as text, but only to admin users.  */
if ($USER->site_access_level($SWOP_id) <= $AdminAccess){
 if ($event['Active']==1){?><span >Identified as a primary leader</span><?php }
 elseif ($event['Active']==2){?><span>Identified as a secondary leader</span><?php }
 elseif ($event['Active']==3){?><span>Identified as a tertiary leader</span><?php }
 elseif ($event['Active']==4){?><span>Identified as not being part of leadership development</span><?php 
} 
} //end access check
 } else if ($event['Activity_Type']==3) {
 /* then this is an outcome int, and the corresponding name needs to be pulled from its table. */
 $get_outcome_sqlsafe = "SELECT * FROM Outcomes_for_Pool WHERE Outcome_ID='" . $event['Active'] . "'";
 $outcome = mysqli_query($cnnSWOP, $get_outcome_sqlsafe);
 $oc = mysqli_fetch_array($outcome);
 echo $oc['Outcome_Name'];
 } else if ($event['Activity_Type']==4) {
 /* then this is a status change, and needs to be shown as text: */
 if ($event['Active']==1) {echo "Entered the Housing Pool";}
 else if ($event['Active']==0) {echo "Left the Housing Pool";}
										}else if ($event['Activity_Type']==6) {
                                                                                    /* then this is an institution link, and the name should be pulled and shown: */
											$get_institution_sqlsafe = "SELECT Institution_Name FROM Institutions WHERE Institution_ID='" . $event['Active'] . "'";
											$institution = mysqli_query($cnnSWOP, $get_institution_sqlsafe);
											$inst = mysqli_fetch_array($institution);
											echo "New institutional connection: ".$inst['Institution_Name'];
											if ($event['Member_Type']==1) {echo " (primary connection)";}
                                                                                        $activity_id=$event['Pool_Status_Change_ID'];
										} else if ($event['Activity_Type']==7){
                                                                                    /* then this just refers to the creation of this person in the database: */
                                                                                    echo "Participant added to the database.";}
                                                                                $activity_id=$event['Pool_Status_Change_ID'];
									//echo $event['Active'];?></td>
                                                                 <td>
<?php
if ($USER->site_access_level($SWOP_id) <= $AdminAccess){
?>
                                                                    <input type="button" value="Delete" onclick="
                                                                           $.post(
                                                                            '../ajax/benchmark_changes.php',
                                                                            {
                                                                                action: 'delete',
                                                                                activity_type: '<?php echo $event['Activity_Type'];?>',
                                                                                id: '<?php echo $activity_id;?>'
                                                                            },
                                                                            function (response){
                                                                                //document.write(response);
                                                                                window.location='participant_profile.php?history=1';
                                                                            }
                                                                           ).fail(failAlert);">
<?php
} //end access check
?>
                                                                </td>
							</tr>
						<?php
							}
							include "../include/dbconnclose.php";
                                                        
                                                        //if the person has a first interacted date (for those who were tracked before the DB opened), show it here:
                                                        if ($participant->first_interacted!='' && $participant->first_interacted!='0000-00-00'){?>
                                                        <tr>
                                                            <td></td>
                                                            <td>Date of First Interaction: 
                                                                <?$reformat=explode('-',$participant->first_interacted);
                                                                echo $reformat[1] . '/' . $reformat[2] . '/' . $reformat[0];
                                                                ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php } ?>
					</table>
                                           <!-- Shows/hides history beyond the most recent 5 events: -->
                                           <a href="javascript:;" onclick="$('.extra_history').toggle();">Show more history</a><br>
                                           
                    <table class="inner_table">
                        <!-- holds both leadership levels and rubric details for leaders: -->
						<tr>
							<td class="blank" width="50%"> <?$participant->get_leadership_development();?>
                        
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
        <table class="inner_table" width="100%" id="leadership_table">
            <tr><th colspan="2">Add Leadership Development</th></tr>
            <!-- saves rubric additions (and subtractions).  Oncheck of a checkbox, the detail saves with an auto-generated date. -->
            <tr><td class="blank"><a href="javascript:;" onclick="$('.details_rows').toggle();">View Leadership Rubric Details</a></td></tr>
            <tr class="details_rows" style="background-color:#EEEEEE;"><td><strong>Tertiary Characteristics:</strong><br></td><td></td></tr>
              <tr class="details_rows"><td><input type="checkbox" value="1" id="regular_attendance_3" onchange="handleChange(this)">Regularly attends meetings or actions &nbsp
                  </td><td><?php echo $participant->detail_1;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="2" id="small_roles_3" onchange="handleChange(this)"> Accepts small roles in meeting or actions&nbsp
                        </td><td><?php echo $participant->detail_2;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="3" id="shows_up_3" onchange="handleChange(this)"> Goes where they are needed&nbsp
                        </td><td><?php echo $participant->detail_3;?></td></tr>
                    <tr class="details_rows" style="background-color:#EEEEEE;"><td><strong>Secondary Characteristics:</strong></td><td></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="4" id="key_qualities_2" onchange="handleChange(this)"> Has 2 of the 3 key qualities of a leader- Vision, Talent, or Network
                            </td><td><?php echo $participant->detail_4;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="5" id="tertiary_qualities_2" onchange="handleChange(this)"> Has all qualities of a tertiary  leader
                            </td><td><?php echo $participant->detail_5;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="6" id="org_understand_2" onchange="handleChange(this)">Basic understanding of organizing
                            </td><td><?php echo $participant->detail_6;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="7" id="one-ones_2" onchange="handleChange(this)">Does 1-1\'s
                            </td><td><?php echo $participant->detail_7;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="8" id="plays_role_2" onchange="handleChange(this)">Plays greater role in SWOP
                            </td><td><?php echo $participant->detail_8;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="9" id="pull_to_action_2" onchange="handleChange(this)">Willing to pull someone to action
                            </td><td><?php echo $participant->detail_9;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="10" id="frustration_2" onchange="handleChange(this)">Has frustration or anger about world as it is
                            </td><td><?php echo $participant->detail_10;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="11" id="analyzing_2" onchange="handleChange(this)">Starting analyzing and strategizing
                            </td><td><?php echo $participant->detail_11;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="12" id="self_interest_2" onchange="handleChange(this)">Thinking about personal and institutional self interest
                            </td><td><?php echo $participant->detail_12;?></td></tr>
              
            <tr class="details_rows" style="background-color:#EEEEEE;"><td><strong>Primary Characteristics:</strong></td><td></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="13" id="key_qualities_3" onchange="handleChange(this)">Has all 3 key qualities of a leader - Vision, Talent, Network
                            </td><td><?php echo $participant->detail_13;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="14" id="secondary_qualities_3" onchange="handleChange(this)">Has all qualities of secondary and tertiary leader
                            </td><td><?php echo $participant->detail_14;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="15" id="power_3" onchange="handleChange(this)">Has power in institution and in community
                            </td><td><?php echo $participant->detail_15;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="16" id="org_communicate_3" onchange="handleChange(this)">Can communicate how & why we organize
                            </td><td><?php echo $participant->detail_16;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="17" id="leader_dev_3" onchange="handleChange(this)">Engages in leadership development
                            </td><td><?php echo $participant->detail_17;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="18" id="carry_action_3" onchange="handleChange(this)">Can carry meeting or action
                            </td><td><?php echo $participant->detail_18;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="19" id="carry_training_3" onchange="handleChange(this)">Can carry training component
                            </td><td><?php echo $participant->detail_19;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="20" id="analyzes_3" onchange="handleChange(this)">Can analyze and strategize
                            </td><td><?php echo $participant->detail_20;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="21" id="self_3" onchange="handleChange(this)">Self-motivated
                            </td><td><?php echo $participant->detail_21;?></td></tr>
                    <tr class="details_rows"><td><input type="checkbox" value="22" id="self_interest_3" onchange="handleChange(this)">Understands personal and institutional self-interest
                            </td><td><?php echo $participant->detail_22;?></td></tr>
                </td></tr>
        <!-- Below the rubric, these leadership levels are the main points of interest for organizers.  They are not linked to 
        rubric checkboxes. -->
				<tr><td class="blank"><select id="leader_type_2">
                        <option value="">-----</option>
                        <option value="1">Primary</option>
                        <option value="2">Secondary</option>
                        <option value="3">Tertiary</option>
                        <option value="4">Not in Leadership Development</option>
                    </select></td>
                    <td class="blank">
					<input type="button" value="Add Development" onclick="
                        $.post(
                            '../ajax/leadership_dev.php',
                            {
                                participant: '<?php echo $participant->participant_id;?>',
                                leader: document.getElementById('leader_type_2').value,
								type: '2'
                            },
                            function (response){
                                //document.write(response);
                                window.location='participant_profile.php?history=1';
                            }).fail(failAlert);"></td></tr>
        </table>
<?php
} //end access check
?>
                            <script text="javascript">
        
        /* governs the saving of checkboxes on check or uncheck. */
           function handleChange(cb) {
               //alert("Changed, new value = " + cb.checked + " with value " +cb.value);
               if (cb.checked== true){
                   //document.write('true/false works');
                $.post(
                    '../ajax/leadership_dev.php',
                    {
                        action: 'details',
                        user_id: '<?php echo $participant->participant_id;?>',
                        detail_id: cb.value
                    },
                    function (response){
                        //document.write(response);
                        window.location = "participant_profile.php?history=1";
                    }
                ).fail(failAlert);
                }
                else if (cb.checked==false){
                    $.post(
                        '../ajax/remove_attendee.php',
                    {
                        user_id: '<?php echo $parti->participant_id;?>',
                        program_date_id: date
                    },
                    function (response){
                        //document.write(response);
                        window.location = "participant_profile.php?history=1";
                    }
                ).fail(failAlert);
                }
            }
    </script></td>
					<td class="blank">
						<table class="inner_table">
                                                    <!-- space to activate a person in the pool!  adds a person to the pool with a 
                                                    certain member type: -->
							<tr><th colspan="2">Add to Housing Pool</th></tr>
							<tr>
								<td><select id="pool_type">
									<option value="">--Pool Member Type--</option>
									<?
                                        $get_types_sqlsafe="SELECT * FROM Pool_Member_Types;";
                                        include "../include/dbconnopen.php";
                                        $all_types=mysqli_query($cnnSWOP, $get_types_sqlsafe);
                                        while ($type=mysqli_fetch_row($all_types)){
                                          ?><option value="<?php echo $type[0];?>" <?php echo($type[1]==$participant->get_type() ? 'selected="selected"' : null);?>><?php echo $type[1];?></option>
                                              <?
                                            }
                                           include "../include/dbconnclose.php";
                                            ?>
									</select>
                                            </td>
                                            <td>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
<input type="button" value="Add" onclick="
                                                    $.post(
                                                    '../ajax/add_participant.php',
                                                    {
                                                        action: 'add_to_pool',
                                                        person: '<?php echo $parti['Participant_ID'];?>',
                                                        member_type: document.getElementById('pool_type').value 
                                                    },
                                                    function (response){
                                                        
                                                        /* sends the user to the pool profile (since now they need more
                                                         * information that is related to pool information.) */
                                                        $.post(
                                                            '../ajax/set_participant_id.php',
                                                            {
                                                                page: 'profile',
                                                                participant_id: '<?php echo $parti['Participant_ID'];?>'
                                                            },
                                                            function (response){
                                   var url = response;
                                   window.location = url;
                                                            }
                                                        );
                                                    }
							).fail(failAlert);">
<?php
                                     } //end access check
?>
</td>
							</tr>
						</table>
					</td>
						</tr>
					</table>
					       <br/></br> 
					</td></tr>
		</table>
        <br/><br/>

        </table>
        
</div>

<?php include "../../footer.php"; ?>