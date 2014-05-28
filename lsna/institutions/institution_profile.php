<? include "../../header.php";
	include "../header.php";
?>
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

<?
/*these ifs are left over from when the institution pages were divs that were hidden or shown depending
 * on the cookie of the moment.  This is now always the profile page, so the following
 * script is correct:
 */
if ($_COOKIE['inst_page']=='profile'){
            ?>

                <script type="text/javascript">
	$(document).ready(function() {
	$('#institutions_selector').addClass('selected');
	$("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});
		$('#search_all_institutions').hide();
		$('#add_new_institution').hide();
		$('#institution_profile_div').show();
        $('.show_edit_space').hide();
		$('.edit').hide();
	});

</script>
                <?
        }
        elseif ($_COOKIE['inst_page']=='search' || !isset($_COOKIE['inst_page'])){
        ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#institutions_selector').addClass('selected');
                $("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});
		$('#search_all_institutions').show();
		$('#add_new_institution').hide();
		$('#institution_profile_div').hide();
                $('.show_edit_space').hide();
	});

</script>

<?
        }
  //      print_r($_COOKIE);
?>


<div class="content" id="institution_profile_div">




<?
include "../classes/institutions.php";
$inst = new Institution();
$inst->load_with_institution_id($_COOKIE['institution']);
?>

<h3>Institution Profile - <?echo $inst->institution_name;?></h3><hr/><br/>
<table class="profile_table">
	<tr>
		<td width="50%">
                    
                    <!--Basic information table: -->
                    
			<table class="inner_table" style="border:2px solid #696969;">    <tr><td>
            <strong>Name: </strong>
        </td><td>
            <span class="display"><?echo $inst->institution_name;?></span>
			<input class="edit" type="text" value="<?echo $inst->institution_name;?>" id="edit_name"/>
        </td></tr>
	<tr><td><strong>Type: </strong></td>
		<td><span class="display"><?
			$find_type = "SELECT * FROM Institution_Types INNER JOIN (Institutions) ON Institution_Types.Institution_Type_ID=Institutions.Institution_Type WHERE Institution_Types.Institution_Type_ID='" . $inst->institution_type . "'";
			include "../include/dbconnopen.php";
			$types=mysqli_query($cnnLSNA, $find_type);
			$type=mysqli_fetch_array($types);
					echo $type['Institution_Type_Name'];
		?></span>
			<select class="edit" id="edit_type">
				<option value="">------</option>
				<?
					$all_types = "SELECT * FROM Institution_Types ORDER BY Institution_Type_Name";
					$list_types = mysqli_query($cnnLSNA, $all_types);
					while ($list_type=mysqli_fetch_array($list_types)) {
				?>
				<option value="<?echo $list_type['Institution_Type_ID'];?>" <?echo($list_type['Institution_Type_ID']==$type['Institution_Type_ID'] ? 'selected="selected"' : null);?>><?echo $list_type['Institution_Type_Name'];?></option>
				<?
					}
				?>
			</select>
		</td>
	</tr>
    <tr><td><strong>Address: </strong></td>
        <td><span class="display"><?echo $inst->address_full;?></span>
			<div class="edit">
				<input type="text" id="edit_str_num" style="width:40px" value="<?echo $inst->address_num;?>">
				<select id="edit_str_dir" >
					<option value="">---</option>
					<option value="N" <?echo($inst->address_dir=='N' ? 'selected="selected"' : null);?>>N</option>
					<option value="S" <?echo($inst->address_dir=='S' ? 'selected="selected"' : null);?>>S</option>
					<option value="E" <?echo($inst->address_dir=='E' ? 'selected="selected"' : null);?>>E</option>
					<option value="W" <?echo($inst->address_dir=='W' ? 'selected="selected"' : null);?>>W</option>
				</select>
				<input type="text" id="edit_str_name" style="width:100px" value="<?echo $inst->address_street;?>">
				<input type="text" id="edit_str_type" style="width:40px" value="<?echo $inst->address_street_type;?>"><br>
				<span class="helptext">Ex: 2200 W North Ave</span>
			</div>
		</td></tr>
	<tr>
		<td></td>
		<td><input type="button" class="display no_view" value="Edit" onclick="$('.edit').toggle();$('.display').toggle();" />
			<input type="button" class="edit" value="Save" onclick="
					$.post(
						'../ajax/edit_inst.php',
						{
							inst_id: '<?echo $inst->institution_id;?>',
							name: getElementById('edit_name').value,
							type: getElementById('edit_type').options[document.getElementById('edit_type').selectedIndex].value,
							str_num: getElementById('edit_str_num').value,
							str_dir: getElementById('edit_str_dir').value,
							str_name: getElementById('edit_str_name').value,
							str_type: getElementById('edit_str_type').value
						},
						function (response){
							window.location='institution_profile.php';
						}
			);"/>
		</td>
	</tr>
			</table>
		</td>
                
                <!--List of related programs: -->
                
		<td><h4>Related Programs</h4><div style="padding-left:200px;">
		    <?
			$progs = $inst->get_related_programs();
			while ($program = mysqli_fetch_array($progs)){
			?><a href="javascript:;" onclick="
				$.post(
                     '../ajax/set_program_id.php',
                     {
					 id: '<?echo $program['Subcategory_ID'];?>'
                     },
                     function (response){
                     //alert(response);
                     if (response!='1'){
                     document.getElementById('show_error').innerHTML = response;
                     }
                     window.location='/lsna/programs/program_profile.php';
                     })"><?echo $program['Subcategory_Name'];?></a><br/><?
    }
    ?></div><br/>
    
    <!--List of related participants: -->
		<h4>Related Participants</h4>	<div style="padding-left:200px;">		
    <?
    $progs = $inst->get_related_participants();
    while ($participant = mysqli_fetch_array($progs)){
        ?><a href="javascript:;" onclick="
					$.post(
                        '../ajax/set_participant_id.php',
                        {
                            page: 'profile',
                            participant_id:'<?echo $participant['Participant_ID'];?>'
                        },
                        function (response){
                            if (response!='1'){
                                document.getElementById('show_error').innerHTML = response;
                            }
                            window.location='../participants/participant_profile.php';
                       }
           );
		"><?echo $participant['Name_First'] . " " . $participant['Name_Last'];?></a><br><?
    }
    ?></div>
		</td>
	</tr>
</table>
<br/>
</div>

<?include "../../footer.php";?>