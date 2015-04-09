<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id);
?>
<!--
Menu that shows up at the top of "Participant Survey, aggregate."  (links to reports
sorted by participant type)
-->	


<table width="60%" align="center" id="data_menu">
<tr>
			<td class="menu_item"><a href="participant_surveys_total.php" id="total_selector">All Surveys</a></td>
			<td class="menu_item"><a href="participant_surveys_youth.php" id="youth_selector">Youth</a></td>
			<td class="menu_item"><a href="participant_surveys_adults.php" id="adults_selector">Adults</a></td>
			<td class="menu_item"><a href="participant_surveys_parents.php" id="parents_selector">Parents</a></td>

		</tr>

        </table>
<p></p>
<hr>
<p></p>