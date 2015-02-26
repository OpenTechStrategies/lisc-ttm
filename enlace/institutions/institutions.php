<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id);

include "../../header.php";
include "../header.php";
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#institutions_selector').addClass('selected');
		$('#ajax_loader').hide();
		$('#add_inst').hide();
	});
	
	$(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });
            
    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<div class="content_block">
<h3>Institutions</h3><hr/><br/>

<!--
List of institutions that have been added to the database.
-->

   <table class="inner_table" style="font-size:.9em;width:50%;margin-left:auto;margin-right:auto;">
	<tr><th>Name</th><th>Type</th><th></th></tr>
<?php
//show all institutions
$get_insts="SELECT * FROM Institutions LEFT JOIN Institution_Types ON Institutions.Institution_Type=Institution_Types.Inst_Type_ID ORDER BY Institutions.Institution_Name";
include "../include/dbconnopen.php";
$insts=mysqli_query($cnnEnlace, $get_insts);
while($inst=mysqli_fetch_array($insts)){
    ?>
        <tr>
        	<td><a href="inst_profile.php?inst=<?php echo $inst['Inst_ID'];?>"><?php echo $inst['Institution_Name'];?></a></td>
        	<td><?php echo $inst['Type'];?></td>
        	<td>
<?php
    /*Delete button only available to admin users: */
    if ($USER->site_access_level($Enlace_id) <= $AdminAccess){
?>
<a href="javascript:;" onclick="
        		$.post(
        			'/enlace/ajax/delete_inst.php',
        			{
        				inst: '<?php echo $inst['Inst_ID'];?>'
        			},
        			function(response){
        				window.location='institutions.php';
        			}).fail(failAlert);">Delete</a>
<?php
                } ?>
</td>
        </tr><?php
}
include "../include/dbconnclose.php";
?>
	</table><br/><br/>
        
        <!--
        It might be too far down to have this at the bottom of the list.
        
        Add new institution here: 
        -->
        
            <h4 onclick="$('#add_inst').slideToggle();" style="cursor:pointer;">Add New Institution...</h4>
            <div id="add_inst"><table class="inner_table" style="border:2px solid #696969;font-size:.9em;width:50%;margin-left:auto;margin-right:auto;">
                <tr><td><strong>Name:</strong></td><td><input type="text" id="new_name"></td></tr>
                <tr><td><strong>Address:</strong></td><td><input id="st_num_new" style="width:40px;"/> 
                                                                <input id="st_dir_new" style="width:20px;"/> 
                                                                <input id="st_name_new"  style="width:100px;"/> 
                                                                <input id="st_type_new" style="width:35px;"/> <br>
								<span class="helptext">e.g. 2756 S Harding Ave</span></td></tr>
                <tr><td><strong>Type:</strong></td><td><select id="new_inst_type">
                            <option value="0">-----</option>
                            <option value="1">School</option>
                            <option value="2">Church</option>
                            <option value="3">Community Organization</option>
                            <option value="4">Hospital</option>
                            <option value="5">University</option>
                        </select></td></tr>
                <tr><td><strong>Point person:</strong><br><span class="helptext">
                            This person must be in the database.
                        </span></td>
                        <!--
                        Once again, they need to search for the point person.  Can't add a new person here.
                        -->
                    <td>
                        <table class="inner_table" id="search_parti_table" style="font-size:.9em;">
    <tr>
            <td><strong>First Name: </strong></td>
            <td><input type="text" id="first_name_search" style="width:125px;"/></td>
            <td><strong>Last Name: </strong></td>
            <td><input type="text" id="last_name_search" style="width:125px;" /></td>
    </tr>
    <tr>
            <td><strong>Date of Birth: </strong></td>
            <td><input type="text" id="dob_search" class="addDP" /></td>
    </tr>
    <tr>
            <td colspan="4" style="text-align:center;" class="blank">
                    <input type="button" value="Search" onclick="
                                                $.post(
                            '/enlace/ajax/search_participants.php',
                            {
                                result: 'dropdown',
                                first: document.getElementById('first_name_search').value,
                                last: document.getElementById('last_name_search').value,
                                dob: document.getElementById('dob_search').value
                                //grade: document.getElementById('grade_search').value
                        },
                        function (response){
                            document.getElementById('show_results').innerHTML = response;
                        }).fail(failAlert);"/><div id="show_results"></div>
					</td>
				</tr>
			</table>
                    </td></tr>
                <tr><td><strong>Contact phone:</strong></td><td><input type="text" id="new_phone"></td></tr>
                <tr><td><strong>Contact Email:</strong></td><td><input type="text" id="new_email"></td></tr>
                <tr><td colspan="2"><input type="button" value="Add Institution" onclick="
                    if (document.getElementById('relative_search')){var point=document.getElementById('relative_search').value;}
                    else{var point='';}
                    //alert(point);
                    $.post(
                        '../ajax/new_inst.php',
                        {
                            name: document.getElementById('new_name').value,
                            num: document.getElementById('st_num_new').value,
                            dir: document.getElementById('st_dir_new').value,
                            street: document.getElementById('st_name_new').value,
                            suff: document.getElementById('st_type_new').value,
                            type: document.getElementById('new_inst_type').value,
                            person: point,
                            phone: document.getElementById('new_phone').value,
                            email: document.getElementById('new_email').value
                        },
                        function (response){
                            //document.write(response);
                            //window.location='inst_profile.php?inst='+response;
							document.getElementById('new_inst_confirm').innerHTML = response;
                        }
                ).fail(failAlert);">
				<div id="new_inst_confirm"></div>
				</td></tr>
            </table></div>
</div>
<br/><br/>

<?
	include "../../footer.php";
?>
