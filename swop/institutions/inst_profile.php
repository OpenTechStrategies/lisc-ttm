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
include "../include/dbconnopen.php";
$get_inst_info_sqlsafe = "SELECT * FROM Institutions WHERE Institution_ID='" . mysqli_real_escape_string($cnnSWOP, $_COOKIE['institution']) . "'";
$inst_info=mysqli_query($cnnSWOP, $get_inst_info_sqlsafe);
$inst=mysqli_fetch_array($inst_info);
include "../include/dbconnclose.php";

/* holds basic information about institutions. */

?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#institutions_selector').addClass('selected');
                $('#add_institution').hide();
                $('#institution_search').hide();
                $('#institution_profile').show();
		$('.edit_info').hide();
                $('#hide_too_many_people').hide();
	});
</script>
<div id="institution_profile" class="content_block" style="clear:both;">
<h3>Institution Profile: <?echo $inst['Institution_Name'];?> </h3><hr/><br/>
<table width="100%"><tr><td width="50%" style="vertical-align:top;">
<table class="inner_table" style="border:2px solid #696969;"> <!--Basic information-->
	<tr>
		<td><strong>Institution Name: </strong></td>
		<td><span class="show_info"><?echo $inst['Institution_Name'];?></span><input type="text" class="edit_info" id="name_edit" value="<?echo $inst['Institution_Name'];?>"/></td>
	</tr>
	<tr>
		<td><strong>Institution Type: </strong></td>
		<td><span class="show_info"><?
                $get_type_sqlsafe="SELECT Type_Name FROM Institution_Types WHERE Type_ID='".$inst['Institution_Type'] . "'";
              //  echo $get_type;
                 include "../include/dbconnopen.php";
                $this_type=mysqli_query($cnnSWOP, $get_type_sqlsafe);
                $type=mysqli_fetch_row($this_type);
                echo $type[0];
                ?></span>
			<select id="type_edit" class="edit_info">
				<option value="">-------</option>
				<?//get types
                        $select_types_sqlsafe="SELECT * FROM Institution_Types";
                        include "../include/dbconnopen.php";
                        $types=mysqli_query($cnnSWOP, $select_types_sqlsafe);
                        while ($type=mysqli_fetch_row($types)){
                            ?>
                        <option value="<?echo $type[0]?>" <?echo ($inst['Institution_Type']==$type[0] ? 'selected="selected"' :null);?>><?echo $type[1];?></option>
                                <?
                        }
                        include "../include/dbconnclose.php";
                        ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><strong>Primary Contact: </strong></td>
                <!-- Instead of searching the database for the primary contact, editing it here pulls a select list of all
                the people currently linked to this institution.  In order to add a primary contact, users must add a person 
                as an "associated participant" (on the right side of the page) and then choose him or her from this dropdown list.
                -->
		<td><?
				$get_contact_sqlsafe = "SELECT * FROM Participants WHERE Participant_ID='".$inst['Contact_Person']."'";
				include "../include/dbconnopen.php";
				$contact_info = mysqli_query($cnnSWOP, $get_contact_sqlsafe);
				$contact = mysqli_fetch_array($contact_info);
			?>
			<span class="show_info"><?echo $contact['Name_First']." ".$contact['Name_Last'];?></span>
			<select id="contact_edit" class="edit_info">
				<option value="">----------</option>
			<?
				$get_participants_sqlsafe = "SELECT * FROM Institutions_Participants 
                                    INNER JOIN Participants ON Institutions_Participants.Participant_ID=Participants.Participant_ID WHERE Institutions_Participants.Institution_ID='".$inst['Institution_ID']."'";
				$participants = mysqli_query($cnnSWOP, $get_participants_sqlsafe);
				while ($parti = mysqli_fetch_array($participants)) {
			?>
				<option value="<?echo $parti['Participant_ID'];?>"><?echo $parti['Name_First']." ".$parti['Name_Last'];?></option>
			<?
				}
				include "../include/dbconnclose.php";
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><strong>Address: </strong></td>
		<td>
			<span class="show_info"><?echo $inst['Street_Num'] . " " . $inst['Street_Direction'] . " " . $inst['Street_Name'] . " " . $inst['Street_Type'];?></span>
			<input type="text" id="edit_address_number" style="width:40px;" class="edit_info" value="<?echo $inst['Street_Num'];?>"/> 
			<select id="edit_address_direction"  class="edit_info"/>
                        <option <?echo($inst['Street_Direction']=='N' ? 'selected="selected"' : null);?>  value="N">N</option>
                        <option <?echo($inst['Street_Direction']=='S' ? 'selected="selected"' : null);?> value="S">S</option>
                        <option <?echo($inst['Street_Direction']=='E' ? 'selected="selected"' : null);?> value="E">E</option>
                        <option <?echo($inst['Street_Direction']=='W' ? 'selected="selected"' : null);?> value="W">W</option>
                    </select>
			<input type="text" id="edit_address_street" style="width:100px;" class="edit_info"  value="<?echo $inst['Street_Name'];?>"/>
			<select id="edit_address_street_type" class="edit_info" />
                        <option <?echo($inst['Street_Type']=='ST' ? 'selected=="selected"' : null);?> value="ST">ST</option>
                        <option <?echo($inst['Street_Type']=='AVE' ? 'selected=="selected"' : null);?> value="AVE">AVE</option>
                        <option <?echo($inst['Street_Type']=='RD' ? 'selected=="selected"' : null);?> value="RD">RD</option>
                        <option <?echo($inst['Street_Type']=='PL' ? 'selected=="selected"' : null);?> value="PL">PL</option>
                        <option <?echo($inst['Street_Type']=='CT' ? 'selected=="selected"' : null);?> value="CT">CT</option>
                        <option <?echo($inst['Street_Type']=='BLVD' ? 'selected=="selected"' : null);?> value="BLVD">BLVD</option>
                    </select>
		</td>
	</tr>
	<tr>
		<td><strong>Phone Number: </strong></td>
		<td><span class="show_info"><?echo $inst['Phone'];?></span>
			<input type="text" class="edit_info" id="phone_edit" value="<?echo $inst['Phone'];?>"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
<input type="button" value="Edit" onclick="
						$('.edit_info').toggle();
						$('.show_info').toggle();"/>
						<input  type="button" class="edit_info" value="Save" onclick="
							$.post(
								'../ajax/edit_inst.php',
								{
									name: document.getElementById('name_edit').value,
									type: document.getElementById('type_edit').value,
									contact: document.getElementById('contact_edit').value,
									phone: document.getElementById('phone_edit').value,
									num: document.getElementById('edit_address_number').value,
									dir: document.getElementById('edit_address_direction').value,
									street: document.getElementById('edit_address_street').value,
									st_type: document.getElementById('edit_address_street_type').value,
									id: '<?echo $inst['Institution_ID'];?>'
								},
								function(response) {
                                                                    //document.write(response);
									window.location='inst_profile.php';
								}
							).fail(failAlert);" />
<?php
} //end access level
?>
	</tr>
</table>
            <!-- show all campaigns to which this institution is linked, and add more if desired. -->
</td><td style="vertical-align:top;padding-left:30px;"><h4>Associated Campaigns</h4>

<?$get_persons_sqlsafe = "SELECT * FROM Campaigns_Institutions INNER JOIN Campaigns ON Campaigns_Institutions.Campaign_ID=
    Campaigns.Campaign_ID WHERE Institution_ID='".$inst['Institution_ID']."'";
include "../include/dbconnopen.php";
$persons=mysqli_query($cnnSWOP, $get_persons_sqlsafe);
while ($person=  mysqli_fetch_array($persons)){
    ?><a href="javascript:;" onclick="
			$.post(
            '../ajax/set_campaign_id.php',
            {
                id: '<?echo $person['Campaign_ID'];?>'
            },
            function (response){
            window.location='../campaigns/campaign_profile.php';}).fail(failAlert);"><?echo $person['Campaign_Name'];?></a><br/><?
}
include "../include/dbconnclose.php";
?>
<br/>
<span class="helptext">Associate a campaign with this institution: </span><br/><select id="campaign_select">
    <option value="">-----</option>
    <?
    $get_all_participants_sqlsafe="SELECT * FROM Campaigns";
    include "../include/dbconnopen.php";
    $people=mysqli_query($cnnSWOP, $get_all_participants_sqlsafe);
                while ($person=mysqli_fetch_array($people)){
                    ?>
                <option value="<?echo $person['Campaign_ID'];?>"><?echo $person['Campaign_Name'];?></option>
                        <?
                }
                
    ?>
</select>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
<input type="button" value="Add"  onclick="$.post(
        '../ajax/link_inst.php',
        {
            type: 'campaign',
            inst: '<?echo $inst['Institution_ID'];?>',
            campaign: document.getElementById('campaign_select').value
        },
        function (response){
            //document.write(response);
            window.location = 'inst_profile.php';
        }).fail(failAlert);">
<?php
                                                     } //end access check
?>
		<br/><br/>
                
                <!-- List the participants affiliated with this institution.  This is particularly
                important for SWOP, because they tend to search for people by their primary institution.
                There's no way to indicate here that this is their primary institution, though.  That
                has to be done on the participant profile.
                -->
<h4>Associated Participants</h4>

 
<?$get_persons_sqlsafe = "SELECT * FROM Institutions_Participants INNER JOIN Participants ON Institutions_Participants.Participant_ID=
    Participants.Participant_ID WHERE Institution_Id='".$inst['Institution_ID']."'";
include "../include/dbconnopen.php";
$persons=mysqli_query($cnnSWOP, $get_persons_sqlsafe);
$count_people=0;
while ($person=  mysqli_fetch_array($persons)){
    /* show only two people above the break. */
    $count_people++;if ($count_people==3){
                                    ?>
<a href="javascript:;" onclick="$('#hide_too_many_people').toggle();"><strong>***Show more participants***</strong></a>
                                <div id="hide_too_many_people">
                                        <?
                                }
    ?><a href="javascript:;" onclick="
                            $.post(
                            '../ajax/set_participant_id.php',
                            {
                                page: 'profile',
                                participant_id: '<?echo $person['Participant_ID'];?>'
                            },
                            function (response){
                                   var url = response;
                                   window.location = url;
                                }).fail(failAlert);"><?echo $person['Name_First'] . " " . $person['Name_Last'];?></a><br/><?
                                
                                
}
include "../include/dbconnclose.php";

                                if ($count_people>=3){
                                    ?>
                                </div>
                                        <?
                                }?>
<br/><br/><br/>

<!-- Add a new person to this institution: -->
<span class="helptext">Associate a participant with this institution: </span><br/>
<div id="search_participants_div_campaign" >
			<table class="search_table" style="margin-left:5px;margin-right:0;">
			<tr>
				<td><strong>First Name:</strong></td>
				<td><input type="text" id="name_search_campaign" style="width:80px;" /></td>
				<td><strong>Last Name:</strong></td>
				<td><input type="text" id="surname_search_campaign" style="width:80px;" /></td>
			</tr>
			<tr>
				<td><strong>Date of Birth:</strong></td>
				<td><input type="text" id="dob_search_campaign" class="hasDatepicker"/></td>
				<td><strong>Gender:</strong></td>
				<td><select id="gender_search_campaign">
						<option value="">---------</option>
						<option value="m">Male</option>
						<option value="f">Female</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="4" class="blank"><input type="button" value="Search" id="search_button_campaign" onclick="
                               $('#link_button_campaign').show();
							   $('#search_button_campaign').hide();
							   $.post(
                                '../ajax/search_users.php',
                                {
                                    first: document.getElementById('name_search_campaign').value,
                                    last: document.getElementById('surname_search_campaign').value,
                                    dob: document.getElementById('dob_search_campaign').value,
                                    gender: document.getElementById('gender_search_campaign').value,
                                    dropdown: 1
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_results_campaign').innerHTML = response;
                                }
                           ).fail(failAlert);"/>
                                    <!-- People resulting from this search show up here: -->
					<div id="show_results_campaign" style="margin-left:115px;"></div>	   
					</td>
			</tr>
		</table>
                
				</div>
<!-- Choose a person from the search results and then click add: -->
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
<input type="button" value="Add" class="no_view" onclick="$.post(
        '../ajax/link_inst.php',
        {
            type: 'participant',
            inst: '<?echo $inst['Institution_ID'];?>',
            person: document.getElementById('choose_participant').value
        },
        function (response){
            //document.write(response);
            window.location = 'inst_profile.php';
        }).fail(failAlert);">
<?php
} //end access check
?>		
<br/><br/>

</td></tr></table>
</div><br/><br/>
<?php
include "../../footer.php";
close_all_dbconn();
?>