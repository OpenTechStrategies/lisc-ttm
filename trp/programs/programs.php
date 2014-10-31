<?php
require_once( "../siteconfig.php");

	include "../../header.php";
	include "../header.php";
        
        /* program home page. */
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#programs_selector').addClass('selected');
		$('.program_summary').hide();
	});
</script>


<div id="programs_home" class="content_block">
	<h3>Programs</h3><hr/><br/>

<div style="width:400px;margin-left:auto;margin-right:auto;">
<?php
/* list of all programs */
	$get_programs_sqlsafe = "SELECT * FROM Programs ORDER BY Program_Name";
	include "../include/dbconnopen.php";
	$programs = mysqli_query($cnnTRP, $get_programs_sqlsafe);
	while ($program = mysqli_fetch_array($programs)) {
	$get_participants_sqlsafe = "SELECT * FROM Participants_Programs WHERE Program_ID='".$program['Program_ID']."'";
	$participants = mysqli_query($cnnTRP, $get_participants_sqlsafe);
	$num_participants = mysqli_num_rows($participants);
?>
	<h4 onclick="
		$('#summary<?echo $program['Program_ID'];?>').slideToggle();
	"><?php echo $program['Program_Name'];?></h4>
    <!-- basic information about each program, with a link to the more detailed program profile. -->
		<div class="program_summary" id="summary<?echo $program['Program_ID'];?>">
			<table width="100%">
				<tr>
					<td colspan="2" style="text-align:center;"><a href="profile.php?id=<?echo $program['Program_ID'];?>">View program profile</a></td>
				</tr>
				<tr>
					<td><strong>Organization:</strong></td>
					<td><?echo $program['Program_Org'];?></td>
				</tr>
				<tr>
					<td><strong>Total Participants:</strong></td>
					<td><?echo $num_participants;?></td>
				</tr>
			</table>
		</div>
<?php
	}
?>
</div></div>
<br/><br/>
<?php
	include "../include/dbconnclose.php";
	include "../../footer.php";
?>
	