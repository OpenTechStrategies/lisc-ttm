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
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id);

include "../../header.php";
include "../../bickerdike/header.php";

?>
<!-- Enter program name, organization, and type here.  Can also create new organizations and program types from this page. -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#program_selector').addClass('selected');
                $('#show_next_parts').hide();
	});
</script>

<div class="content_narrow">
<h3>Add New Program</h3><hr/><br/>

<?
if ($_GET['origin'] != ''){
    ?>
    <a href="../users/user_profile.php?id=<?echo $_GET['origin']?>">Return to participant profile</a>
        <?
}
?>

<h4>Basic Information:</h4>
<span class="helptext">You must enter a program name for this information to save.</span>
<table>
    <tr>
        <td>Program Name:</td><td><input type="text" id="name"></td>
    </tr>
    <tr>
        <td>Program Organization:</td><td><select id="org">
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
    <tr>
        <td>Program Type:</td><td><select id="type">
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
            </td>
    </tr>
</table>
<input type="button" value="Save Basic Information" onclick="
    var name= document.getElementById('name').value;
    if (name!=''){
        
    //check whether there is already a program with this name
    $.post(
                        '../ajax/program_duplicate_check.php',
                        {
                            name: document.getElementById('name').value
                        },
                        function (response){
                            if (response != ''){
                                var deduplicate = confirm(response);
                                if (deduplicate){
                                    $.post(
                                        '../ajax/create_program.php',
                                        {
                                            name: document.getElementById('name').value,
                                            org: document.getElementById('org').value,
                                            type: document.getElementById('type').value,
                                            new_org: document.getElementById('org_text').value,
                                            new_type: document.getElementById('type_text').value,
                                            origin_user: '<?echo $_GET['origin'];?>'
                                        },
                                        function (response){
                                            $('#show_next_parts').show();
                                            document.getElementById('response_repository').innerHTML = response;
                                        }
                                    ).fail(failAlert);
                                 }
                            }
                            else{
                                $.post(
                                        '../ajax/create_program.php',
                                        {
                                            name: document.getElementById('name').value,
                                            org: document.getElementById('org').value,
                                            type: document.getElementById('type').value,
                                            new_org: document.getElementById('org_text').value,
                                            new_type: document.getElementById('type_text').value,
                                            origin_user: '<?echo $_GET['origin'];?>'
                                        },
                                        function (response){
                                            $('#show_next_parts').show();
                                            document.getElementById('response_repository').innerHTML = response;
                                        }
                                    ).fail(failAlert);
                            }
                        }
                        ).fail(failAlert);
                        }
   "><br/><br/>

<div id="show_next_parts">
   Thank you for creating a program!  Now, add dates and participants here:<br/><br/>
<h4>Add Program Dates:</h4>
    <?include "../include/datepicker_wtw.php";?>
   

</div><div id="response_repository"></div>

</div>

<?php 

include "../../footer.php"; ?>