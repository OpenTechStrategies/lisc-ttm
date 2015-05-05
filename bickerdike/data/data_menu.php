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