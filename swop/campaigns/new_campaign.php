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

<!-- Obsolete.  We now add new campaigns straight from the campaign homepage (campaigns.php). -->

<script type="text/javascript">
	$(document).ready(function(){
		$('#programs_selector').addClass('selected');
        $('#add_new_campaign').show();
        $('#campaign_profile').hide();
	});
</script>

<div  class="content_block" id="add_new_campaign">
<h3>New Campaign</h3><hr/><br/>
<div style="text-align:center;"><a class="add_new" href="campaigns.php"><span class="add_new_button">Search Existing Campaigns</span></a></div><br/><br/>

		<td width="50%">
<table class="campaign_table">

    <tr>
        <td>Campaign Name:</td><td><input type="text" id="name_new"></td>
    </tr>


   
<tr><th colspan="2">
<input type="button" value="Save Basic Information" onclick="
    
    var name= document.getElementById('name_new').value;
    if (name!=''){
    $.post(
            '../ajax/program_duplicate_check.php',
            {
                action: 'campaign',
                name: document.getElementById('name_new').value
            },
            function (response){
                if (response != ''){
                    var deduplicate = confirm(response);
                    if (deduplicate){
                        $.post(
                            '../ajax/create_program.php',
                            {
                                name: document.getElementById('name_new').value
                            },
                            function (response){
                                document.getElementById('show_add_participants').innerHTML = response;
                            }
                        ).fail(failAlert);
                        }
                }
                else{
                    $.post(
                            '../ajax/create_program.php',
                            {
                                name: document.getElementById('name_new').value
                            },
                            function (response){
                                document.getElementById('show_add_participants').innerHTML = response;
                            }
                        ).fail(failAlert);
                }
            }
          ).fail(failAlert);
     }"></th></tr>
</table><br/><br/>

<?include "../include/datepicker_wtw.php";?>
<div id="show_add_participants"></div>




</div>

<? include "../../footer.php"; ?>