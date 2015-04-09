<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id);

include "../../header.php";
include "../header.php";

?>
<!--This page is irrelevant.  It isn't linked from anywhere.-->
<script type="text/javascript">
	$(document).ready(function(){
		$('#reports_selector').addClass('selected');
	});
</script>

<div class="content_narrow">
<h2>Bickerdike Reports</h2>


    <ul>
        <li><a href="../reports/knowledge.php">Obesity Knowledge Over Time</a></li>
        <li><a href="../reports/attitude.php">Obesity Attitude Over Time</a></li>
        <li><a href="../reports/behavior.php">Obesity Behavior Over Time</a></li>
        <li>Physical Change Over Time</li>
        <li>Attendance Over Time</li>
        <li>Physical Environment Measures</li>
    </ul>
</div>	
<? include "../../footer.php"; ?>
