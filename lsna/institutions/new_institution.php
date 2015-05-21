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

user_enforce_has_access($LSNA_id);

include "../../header.php";
include "../header.php";
?>
<!--Add a new institution: -->
<script type="text/javascript">
            $(document).ready(function() {
                $('#ajax_loader').hide();
            });
            
            $(document).ajaxStart(function() {
                $('#ajax_loader').fadeIn('slow');
            });
            
            $(document).ajaxStop(function() {
                $('#ajax_loader').fadeOut('slow');
            });
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#institutions_selector').addClass('selected');
                $("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});

                $('.show_edit_space').hide();
	});

</script>

<div class="content" id="add_new_institution">


<h3>Add New Institution</h3><hr/><br/>

<div style="text-align:center;"><a class="add_new" href="institutions.php"><span class="add_new_button">Search All Institutions</span></a></div><br>

<table style="margin-left:auto; margin-right:auto;">
    <tr><td>
            <strong>Name:</strong>
        </td><td>
            <input type="text" id="inst_name">
        </td></tr>
	<tr><td><strong>Type: </strong></td>
		<td><select id="inst_type">
				<option value="">-----------</option>
				<? $get_types = "SELECT * FROM Institution_Types";
					include "../include/dbconnopen.php";
					$types = mysqli_query($cnnLSNA, $get_types);
					while ($type=mysqli_fetch_array($types)) {?>
						<option value="<?echo $type['Institution_Type_ID'];?>"><?echo $type['Institution_Type_Name'];?></option>
				<?	}
					include "../include/dbconnclose.php";
				?>
			</select>
		</td>
	</tr>
    <tr><td><strong>Address: </strong></td>
        <td><input type="text" id="inst_str_num" style="width:40px">
				<select id="inst_str_dir">
					<option value="">---</option>
					<option value="N">N</option>
					<option value="S">S</option>
					<option value="E">E</option>
					<option value="W">W</option>
				</select>
        <input type="text" id="inst_str_name" style="width:100px">
        <input type="text" id="inst_str_type" style="width:40px"><br>
        <span class="helptext">Ex: 2200 W North Ave</span></td></tr>
    <tr>
        <td colspan="2" style="text-align:center;">
            <input type="button" value="Add Institution" onclick="
                   $.post(
                    '../ajax/add_institution.php',
                    {
                        name: document.getElementById('inst_name').value,
						inst_type: document.getElementById('inst_type').value,
                        num: document.getElementById('inst_str_num').value,
                        dir: document.getElementById('inst_str_dir').value,
                        street_name: document.getElementById('inst_str_name').value,
                        type: document.getElementById('inst_str_type').value
                    },
                    function (response){
                        document.getElementById('institution_response_bucket').innerHTML = response;
                    }
               ).fail(failAlert);"></td>
    </tr>
</table>

<div id="institution_response_bucket"></div>




</div>

<?include "../../footer.php";?>