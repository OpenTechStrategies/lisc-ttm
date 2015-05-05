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
 
?>
<!-- Institutions homepage.  Includes a search for institutions and a link to add a new institution: -->

<script type="text/javascript">
	$(document).ready(function(){
		$('#institutions_selector').addClass('selected');
                $('#add_institution').hide();
                $('#institution_profile').hide();
				$('#institution_search').show();
				$("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});
	});
</script>

         <div id="institution_search" class="content_block">
		<h3>Institutions</h3><hr/><br/>
		<div style="text-align:center;font-size:.9em;"><a class="add_new" href="add_institution.php">
                        <!-- Link to add a new institution: -->
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
                        <span class="add_new_button">Add New Institution</span></a></div><br/>
<?php
} //end access check
?>
                
                
		<!-- search here: -->
		<h4>Search Institutions</h4>
		<table class="search_table">
			<tr>
				<td><strong>Name:</strong></td>
				<td><input type="text" id="name_search" /></td>
                                <!-- This should be a select of institution types, not text: -->
				<td><strong>Type:</strong></td>
				<td><input type="text" id="type_search" /></td>
			</tr>
			<tr>
				<td colspan="4"><input type="button" value="Search" onclick="
                               $.post(
                                '../ajax/search_insts.php',
                                {
                                    name: document.getElementById('name_search').value,
                                    type: document.getElementById('type_search').value
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_inst_results').innerHTML = response;
                                }
                           ).fail(failAlert);"/></td>
			</tr>
		</table>
                <!-- Returns a list of institutions, with links to their profiles: -->
                <div id="show_inst_results"></div>
                <?
                /* this should give us alist of institutions, but the actual echo has been commented out.
                 * not sure why.
                 *  */
			$get_institutions_sqlsafe = "SELECT * FROM Institutions ORDER BY Institution_Name";
                        
			include "../include/dbconnopen.php";
			$institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
			while ($institution = mysqli_fetch_array($institutions)) {?>
				<a href="javascript:;" onclick="
                            $.post(
                            '../ajax/set_institution_id.php',
                            {
                                page: 'profile',
                                id: '<?echo $institution['Institution_ID'];?>'
                            },
                            function (response){
                                if (response!='1'){
                                    document.getElementById('show_error').innerHTML = response;
                                }
                            window.location='/swop/institutions/institutions.php';
                                }).fail(failAlert);"><? //echo $institution['Institution_Name'];?></a><br/>
			<?}
			include "../include/dbconnclose.php";
		?>

         </div>
        

<div id="add_institution">
    <? //include "add_institution.php";?>
</div>

<div id="institution_profile">
    <? //include "inst_profile.php";?>
</div>

<?
	include "../../footer.php";
?>
	