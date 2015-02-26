<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id);

include "../../header.php";
include "../header.php";


?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#campaigns_selector').addClass('selected');
                $('#add_new_campaign').hide();
                $('#campaign_profile').hide();
		$('#add_date').hide();
	});
</script>

<div id="campaign_search" class="content_block">
	<h3>Campaigns</h3><hr/><br/>

   
<!--<img src="/images/ajax-loader.gif" width="40" height="40" alt="Loading..." id="ajax_loader" style="position: fixed; top: 0; left: 0;" />-->
<div class="content" id="search_all_campaigns">

<table style="margin-right:auto;margin-left:auto;" width="60%">
	<tr>
		<td width="50%" style="vertical-align:top;">
                    
                    <!--
                    List of existing campaigns:
                    -->
                    
		<h4>Campaign List</h4>
	<ul class="programs_by_category">
        <?php
$get_campaigns="SELECT * FROM Campaigns ORDER BY Campaign_Name";

include "../include/dbconnopen.php";
$campaigns = mysqli_query($cnnEnlace, $get_campaigns);

while ($campaign=mysqli_fetch_array($campaigns)){
    ?>
<a href="javascript:;" onclick="$.post(
            '../ajax/set_campaign_id.php',
            {
                id: '<?php echo $campaign['Campaign_ID'];?>'
            },
            function (response){
            window.location='campaign_profile.php';}).fail(failAlert);">
            <?php echo $campaign['Campaign_Name'];?></a><br>
	
        <?php
}
include "../include/dbconnclose.php";?>
                                </td>
	
                                <!--
                                Add a new campaign:
                                -->
                                
	<td style="vertical-align:top;">
		<h4>New Campaign</h3>
		<table class="campaign_table">

    <tr>
        <td>Campaign Name:</td><td><input type="text" id="name_new"></td>
    </tr>


   
<tr><th colspan="2">
<input type="button" value="Add" onclick="
    
    var name= document.getElementById('name_new').value;
    if (name!=''){
    $('#add_date').show();
    //test to see whether there is already a campaign with this name
	$.post(
            '../ajax/program_duplicate_check.php',
            {
                name: document.getElementById('name_new').value
            },
            function (response){
                if (response != ''){
                    //if there is a campaign with this campaign, issue a warning:
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
                //if there isn't one with this name already:
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
</table>

<?php // include "../include/datepicker_wtw.php";?>
<div id="show_add_participants"></div>
	
	<!--<div style="text-align:center;"><a class="add_new" href="new_campaign.php"><span class="add_new_button">Add New Campaign</span></a></div><br/><br/>-->

<!--<table class="program_table">
    <tr><td class="all_projects"><strong>Campaign Name (or part of name):</strong></td>
        <td class="all_projects"><input type="text" id="name"></td></tr>

    <tr><th colspan="2"><input type="button" value="Search" onclick="
                               $.post(
                                '../ajax/search_campaigns.php',
                                {
                                    name: document.getElementById('name').value
                                },
                                function (response){
                                    document.getElementById('show_results_campaign_search').innerHTML = response;
                                }
                           ).fail(failAlert);"></th></tr>
</table>--><br/>
<div id="show_results_campaign_search"></div></td>
	</tr>
</table>
<br/>
<br/>

</div>

</div>

<?php
	include "../../footer.php";
?>
	