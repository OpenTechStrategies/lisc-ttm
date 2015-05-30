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

user_enforce_has_access($TRP_id);

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
	