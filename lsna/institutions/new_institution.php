<? include "../../header.php";
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

<?
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

                $('.show_edit_space').hide();
	});

</script>

<?
        }
?>

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
               )"></td>
    </tr>
</table>

<div id="institution_response_bucket"></div>




</div>

<?include "../../footer.php";?>