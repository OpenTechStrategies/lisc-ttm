<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id);

include "../../header.php";
include "../header.php";

?>

<!--Evidently this file is irrelevant.  It isn't linked to from anywhere.-->

<div class="content_narrow">
<h3>Bickerdike Partner Data</h3>
What are these programs?<br>
<ul>
    <li>Attendance</li>
    <li>Participation</li>
    <li>Number of scholarships awarded</li>
    <li>Number of free/reduced price fitness slots</li>
    <li>Participant health data (height, weight, BMI)</li>
</ul>

</div>

<? include "../../footer.php"; ?>