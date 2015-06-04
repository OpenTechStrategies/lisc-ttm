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
<!--Home/search page for programs: -->
    <script type="text/javascript">
            $(document).ready(function() {
                $('#ajax_loader').hide();
				$('.program_by_category_list').hide();
				$('.user_dates').hide();
				$('.pm_dates').hide();
				$('.edit_attendance').hide();
				$('.detail_expand').hide();
				$('#programs_selector').addClass('selected');
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
		$('#programs_selector').addClass('selected');
                $("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});
		$('#search_all_programs').show();
		$('#add_new_program').hide();
		$('#program_profile_div').hide();
                $('.show_edit_space').hide();
                $('#user_search').hide();
				$('#show_next_parts').hide();
                $('#show_next_parts_new').hide();
	});

</script>

<div class="content" id="search_all_programs">
<h3>Issue Areas</h3><hr/><br/>

<table id="lsna_programs" width="100%">
	<tr>
		<td width="50%"><h3>Programs and Campaigns By Issue Area</h3>
		<p class="helptext" style="text-align:center;">Click on an issue area name to view the programs associated with it.</p>
	<ul class="programs_by_category">
            <!--List of programs and campaigns sorted by issue area.  -->
    <?
    $get_categories = "SELECT * FROM Categories ORDER BY Category_Name";
    include "../include/dbconnopen.php";
    $categories = mysqli_query($cnnLSNA, $get_categories);
    while ($category = mysqli_fetch_array($categories)){
        ?>
    <li>
		<a onclick="$('.category_<?echo $category['Category_ID'];?>_list').slideToggle();"><h4><?echo $category['Category_Name'];?></h4></a>
				<div class="category_<?echo $category['Category_ID'];?>_list program_by_category_list">
                                    <!--Divide subcategories between campaigns and programs: -->
<strong>Campaigns and Large Community Meetings/Assemblies</strong><br>
<div style="padding-left: 30px;">
<?
$get_related_campaigns = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links, Subcategories) ON
    Categories.Category_ID=Category_Subcategory_Links.Category_ID AND 
    Category_Subcategory_Links.Subcategory_ID=Subcategories.Subcategory_ID
    WHERE Category_Subcategory_Links.Category_ID='" . $category['Category_ID'] . "' AND Campaign_or_Program='Campaign' ORDER BY Subcategories.Subcategory_Name;";
include "../include/dbconnopen.php";
$related_subcategories = mysqli_query($cnnLSNA, $get_related_campaigns);
$category_name=0;
while ($sub = mysqli_fetch_array($related_subcategories)){
    
        if ($category_name != $sub['Category_ID']){
            $category_name = $sub['Category_ID'];?>
                <?
        }
        ?>
    <!--Link to campaigns: -->
    <a href="javascript:;" onclick="
                                                  $.post(
                                                    '../ajax/set_program_id.php',
                                                    {
                                                        id: '<?echo $sub['Subcategory_ID'];?>'
                                                    },
                                                    function (response){
                                                        //alert(response);
                                                        if (response!='1'){
                                                            document.getElementById('show_error').innerHTML = response;
                                                        }
                                                        window.location='program_profile.php';
                                                    }
                                              ).fail(failAlert);"><?echo $sub['Subcategory_Name'] . "<br>";?></a><?
}
?></div><br/>
<!--List of all programs linked to this issue area: -->
<strong>Programs</strong><br>
<div style="padding-left: 30px;">
<?
$get_related_programs = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links, Subcategories) ON
    Categories.Category_ID=Category_Subcategory_Links.Category_ID AND 
    Category_Subcategory_Links.Subcategory_ID=Subcategories.Subcategory_ID
    WHERE Category_Subcategory_Links.Category_ID='" . $category['Category_ID'] . "' AND Campaign_or_Program='Program' ORDER BY Subcategories.Subcategory_Name;";
include "../include/dbconnopen.php";
$related_subcategories = mysqli_query($cnnLSNA, $get_related_programs);
$related_category=0;
while ($sub = mysqli_fetch_array($related_subcategories)){
        if ($related_category != $sub['Category_ID']){
            $related_category = $sub['Category_ID'];?>
                <?
        }
        ?><a href="javascript:;" onclick="
                                                  $.post(
                                                    '../ajax/set_program_id.php',
                                                    {
                                                        id: '<?echo $sub['Subcategory_ID'];?>'
                                                    },
                                                    function (response){
                                                        //alert(response);
                                                        if (response!='1'){
                                                            document.getElementById('show_error').innerHTML = response;
                                                        }
                                                        window.location='program_profile.php';
                                                    }
                                              ).fail(failAlert);"><?echo $sub['Subcategory_Name'] . "<br>";?></a><?
}
    include "../include/dbconnclose.php";
?></div>
    <?
    //get the total number of people involved in this category of work
    $count_participants = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links, Subcategories, Participants_Subcategories) ON
                        Categories.Category_ID=Category_Subcategory_Links.Category_ID AND 
                        Category_Subcategory_Links.Subcategory_ID=Subcategories.Subcategory_ID
                        AND Subcategories.Subcategory_ID=Participants_Subcategories.Subcategory_ID
                        WHERE Category_Subcategory_Links.Category_ID='" . $category['Category_ID'] . "' GROUP BY Participant_ID";
    include "../include/dbconnopen.php";
    $count = mysqli_query($cnnLSNA, $count_participants);
    $num = mysqli_num_rows($count);
    echo "<br/>Total number of unique participants in these programs: " . $num . "<br/><br/>";
    include "../include/dbconnclose.php";
    ?>

				</div>
		   </li>
            <?
    }
    //include "../include/dbconnclose.php";
    ?>
	</ul></td>
	
        <!--Search programs and campaigns by name and category here: -->
	
	<td>
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<div style="text-align:center;"><a class="add_new" href="new_program.php"><span class="add_new_button">Add New Program or Campaign</span></a></div>
<?php
} //end access check
?>
<br/><br/>
<h4>Search Programs and Campaigns</h4>
<table class="program_table">
    <tr><td class="all_projects"><strong>Program/Campaign Name (or part of name):</strong></td>
        <td class="all_projects"><input type="text" id="name"></td></tr>
<!--    <tr><td class="all_projects"><strong>Program Organization:</strong></td>
        <td class="all_projects"><select id="org">
                <option value="">-----</option>
                <?
              /*  $program_query = "SELECT * FROM Programs GROUP BY Program_Organization";
include "../include/dbconnopen.php";
$programs = mysqli_query($cnnBickerdike, $program_query);
while ($program = mysqli_fetch_array($programs)){
    ?>
        <option value="<?echo $program['Program_Organization'];?>"><?echo $program['Program_Organization'];?></option>
        <?
}
include "../include/dbconnclose.php";*/
                ?>
            </select></td></tr>-->
    <tr><td class="all_projects"><strong>Issue Area:</strong></td>
        <td class="all_projects"><select id="type">
                <option value="">-----</option>
                <?
                $program_query = "SELECT * FROM Categories ORDER BY Category_Name";
include "../include/dbconnopen.php";
$programs = mysqli_query($cnnLSNA, $program_query);
while ($program = mysqli_fetch_array($programs)){
    ?>
        <option value="<?echo $program['Category_ID'];?>"><?echo $program['Category_Name'];?></option>
        <?
}
include "../include/dbconnclose.php";
                ?>
            </select></td></tr>
    <tr><th colspan="2"><input type="button" value="Search" onclick="
                               $.post(
                                '../ajax/search_programs.php',
                                {
                                    name: document.getElementById('name').value,
                                    type: document.getElementById('type').value
                                },
                                function (response){
                                    document.getElementById('show_results_program_search').innerHTML = response;
                                }
                           ).fail(failAlert);"></th></tr>
</table><br/>
<div id="show_results_program_search"></div></td>
	</tr>
</table>
<br/>
<br/>

</div>

<?php
include "../../footer.php";
?>
