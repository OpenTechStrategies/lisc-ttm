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