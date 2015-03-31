<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

	include "../../header.php";
	include "../header.php";

?>
<!-- Campaign home page.  Shows list of campaigns and allows for adding new campaigns. -->

<script type="text/javascript">
	$(document).ready(function(){
		$('#programs_selector').addClass('selected');
                $('#add_new_campaign').hide();
                $('#campaign_profile').hide();
		$('#add_date').hide();
	});
</script>


<div id="campaign_search" class="content_block">
	<h3>Campaigns</h3><hr/><br/>

   
<div class="content" id="search_all_campaigns">

<table style="margin-right:auto;margin-left:auto;" width="75%">
	<tr>
		<td width="50%" style="vertical-align:top;">
		<h4>Campaign List</h4>
	<ul class="programs_by_category">
        <?
        
        /* show alphabetical list of campaigns.  Each links to its profile. */
$get_campaigns_sqlsafe="SELECT * FROM Campaigns ORDER BY Campaign_Name";

include "../include/dbconnopen.php";
$campaigns = mysqli_query($cnnSWOP, $get_campaigns_sqlsafe);

while ($campaign=mysqli_fetch_array($campaigns)){
    ?>
<a href="javascript:;" onclick="$.post(
            '../ajax/set_campaign_id.php',
            {
                id: '<?echo $campaign['Campaign_ID'];?>'
            },
            function (response){
            window.location='campaign_profile.php';}).fail(failAlert);">
            <?echo $campaign['Campaign_Name'];?></a><br>
	
        <?
}
include "../include/dbconnclose.php";?>
                                </td>
	
                                <!-- Add a new campaign. -->
	<td style="vertical-align:top;" >
<?php
 if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess) {
?>
		<h4>Add New Campaign</h3>
		<table class="campaign_table">

    <tr>
        <td>Campaign Name:</td><td><input type="text" id="name_new"></td>
    </tr>


   
<tr><th colspan="2">
<input type="button" value="Save" onclick="
    
    var name= document.getElementById('name_new').value;
    if (name!=''){
    $('#add_date').show();
    /* check to make sure a campaign with this name doesn't already exist: */
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
                        );
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
                        );
                }
            }
          ).fail(failAlert);
     }"></th></tr>
</table>

                <!--Add the first event here: -->
<?include "../include/datepicker_wtw.php";?>
<div id="show_add_participants"></div>
	
<br/>
<div id="show_results_campaign_search"></div>
<?php
 } //end access check
?>
</td>
	</tr>
</table>
<br/>
<br/>

</div>

</div>

<?
	include "../../footer.php";
close_all_dbconn();
?>
	