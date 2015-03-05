<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id);

	include "../../header.php";
	include "../header.php";
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#reports_selector').addClass('selected');
	});
</script>


<div class="content_block">
	<h3>Reports</h3><hr/><br/>
        <?php include "report_menu.php";?>
</div>



<?php
	include "../../footer.php";
?>
	