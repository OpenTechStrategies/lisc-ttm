<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($LSNA_id);


include "../../header.php";
include "../header.php";
?>
<!-- Add a new program or campaign here. -->
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
		$('#search_all_programs').hide();
		$('#add_new_program').show();
		$('#program_profile_div').hide();
                $('.show_edit_space').hide();
                $('#user_search').hide();
				$('#show_next_parts').hide();
                $('#show_next_parts_new').hide();
                
	});

</script>

<div  class="content_block" id="add_new_program">
<h3>New Program or Campaign</h3><hr/><br/>

<!--Link back to program home/search page: -->
<div style="text-align:center;">
    <a class="add_new" href="programs.php"><span class="add_new_button">Search Existing Programs and Campaigns</span></a></div><br/><br/>

		<td width="50%">
                    <!--Basic info to add a new program or campaign: -->
<table class="program_table">

    <tr>
        <td>Name:</td><td><input type="text" id="name_new"></td>
    </tr>

    <tr>
                        <td>Program or Campaign:</td>
                        <td><select id="issue_area_new">
                                <option value="">-----</option>
                                <option value="Program">Program</option>
                                <option value="Campaign">Campaign</option>
                            </select></td>
                    </tr>
    <tr>
        <td>Issue Area:</td><td><select id="type_new">
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
            </select></td>
            
    </tr>
<tr><th colspan="2">
<input type="button" value="Save Basic Information" onclick="
    /*issue area is required so that the program or campaign shows up correctly under the 'Issue Areas' tab.*/
    if (document.getElementById('type_new').value==''){
        alert('Please choose a value for Issue Area.');
        return false;
    }
    var name= document.getElementById('name_new').value;
    if (name!=''){
        /*check whether there is already a program or campaign with this name: */
    $.post(
            '../ajax/program_duplicate_check.php',
            {
                name: document.getElementById('name_new').value
            },
            function (response){
                if (response != ''){
                    var deduplicate = confirm(response);
                    if (deduplicate){
                        $.post(
                            '../ajax/create_program.php',
                            {
                                name: document.getElementById('name_new').value,
                                type: document.getElementById('type_new').value,
                                issue_area: document.getElementById('issue_area_new').value,
                             //   clc: document.getElementById('clc_new').value,
                                origin_user: '<?echo $_GET['origin'];?>'
                             //   organizing: organizing
                            },
                            function (response){
                                $('#show_next_parts_new').show();
								$('#show_next_parts').show();
                                document.getElementById('show_add_participants').innerHTML = response;
                            }
                        ).fail(failAlert);
                        }
                }
                else{
                    $.post(
                            '../ajax/create_program.php',
                            {
                                name: document.getElementById('name_new').value,
                                type: document.getElementById('type_new').value,
                                issue_area: document.getElementById('issue_area_new').value,
                           //     clc: document.getElementById('clc_new').value,
                                origin_user: '<?echo $_GET['origin'];?>'
                           //     organizing: organizing
                            },
                            function (response){
                                $('#show_next_parts_new').show();
				$('#show_next_parts').show();
                                document.getElementById('show_add_participants').innerHTML = response;
                            }
                        ).fail(failAlert);
                }
            }
          ).fail(failAlert);
     }"></th></tr>
</table><br/><br/>

    <div id="show_next_parts">
        <!--Quick add dates and people: -->
   Thank you for creating a program!  Now, add dates and participants here:<br/><br/>
<h4>Add Program Dates:</h4>
    <?include "../include/datepicker_wtw.php";?>

</div>
<div id="show_add_participants"></div>
<div id="show_next_parts_new">
    
<!--Not sure why this is here.-->
</div>



</div>

<?include "../../footer.php";?>