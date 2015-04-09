<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($Bickerdike_id);
?>
<!--
Report menu for all the knowledge/attitude/behavior reports.
-->
	<table width="80%" align="center" id="reports_menu">
<tr>
    <td class="menu_item"><strong><a href="../reports/attitude.php" id="adults_attitude_selector">Attitude</a></strong></td>
			<td class="menu_item"><strong><a href="../reports/behavior.php" id="adults_behavior_selector">Behavior</a></strong></td>
                        
                        <td class="menu_item"><strong>Knowledge:</strong><a href="../reports/knowledge.php" id="adults_knowledge_selector">Adults</a>
                        <a href="../reports/knowledge_parents.php" id="parents_knowledge_selector">Parents</a>
                        <a href="../reports/knowledge_youth.php" id="youth_knowledge_selector">Youth</a></td>

		</tr>

        </table>
<p></p>
<hr>
<p></p>