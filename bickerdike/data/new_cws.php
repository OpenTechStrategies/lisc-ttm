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
include "../include/datepicker.php";
?>

<!--Add a new community wellness survey to be used a baseline in the reports.-->

<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
	});
</script>


<div class="content_wide">
<h3>New Community Wellness Survey (Aggregate Information)</h3><hr/><br/>

<table id="cws_table">
    <tr>
        <td><strong>Date:</td>
        <td><input type="text" id="date"><p></td>
    </tr>
    <tr>
        <td><strong>CWS Question 15</strong> - How important is diet and nutrition to you personally?  Would you say...(1-4)</td>
        <td><input type="text" id="15"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 20</strong> - Not counting juice, how often  do you eat any fresh, frozen, or canned fruit, such as apples, oranges, bananas, 
        frozen strawberries, or canned peaches? (per day)</td>
        <td><input type="text" id="20"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 21</strong> - How often do you eat green salad, such as romaine, iceberg, spinach, or other types
of lettuce from a bag or a fresh bunch? (per day)</td>
        <td><input type="text" id="21"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 24 </strong>- Not counting potatoes or salad, how many servings of vegetables do you usually eat?
For example a serving of vegetables at both lunch and dinner would be two servings. (per day)</td>
        <td><input type="text" id="24"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 29</strong> - How many days per week do you do strenuous activities for at least 10 minutes at a
time. Strenuous activities cause heavy sweating or large increases in breathing or
heart rate. Running, soccer, basketball, swimming laps, fast bicycling, tennis are
examples of strenuous activities. (number of days)</td>
        <td><input type="text" id="29"></td>
    </tr>
        <tr>
        <td><strong>CWS Question 30</strong> - When you do strenuous activities, do you usually do them for 20 minutes or more, or
less than 20 minutes? (1 or 2)</td>
        <td><input type="text" id="30"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 31</strong> - How many days per week do you do light or moderate activities for at least 10
minutes at a time. Light and moderate activities cause only light sweating or
moderate increases in breathing or heart rate. Fast walking, golf, yoga, ballroom
dancing, mopping floors, pushing a lawn mower and gardening are examples of light
or moderate activities. (number of days: 0-7)</td>
        <td><input type="text" id="31"></td>
    <tr>
        <td><strong>CWS Question 32 </strong>- When you do light or moderate activities, do you usually do them 30 minutes or more,
or less than 30 minutes? (1-2)</td>
        <td><input type="text" id="32"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 41a </strong>- I would walk more often if I felt
safer in my community. (1[strongly agree]-4[strongly disagree])</td>
        <td><input type="text" id="41_a"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 41b</strong> - I feel comfortable with my child
playing outside in my community. (1[strongly agree]-4[strongly disagree])</td>
        <td><input type="text" id="41_b"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 44 </strong>- How satisfied or dissatisfied are you with the selection of food items available at the
store where you usually shop for food? Would you say… (1[not at all satisfied]-4[very satisfied])</td>
        <td><input type="text" id="44"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 69</strong> - Yesterday, how many servings of fruit, such as an apple or a banana did your child
have? (number of servings)</td>
        <td><input type="text" id="69"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 72 </strong>- Yesterday, how many servings of vegetables like corn, green beans, green salad, or
other vegetables did your child have? Do not include servings of potatoes that you
mentioned above. (number of servings)</td>
        <td><input type="text" id="72"></td>
    </tr>
    <tr>
        <td><strong>CWS Question 91 </strong>- On an average day, how many hours and minutes does your child spend in active play?
Some examples of active play include running around, playing catch, basketball and
bicycling. (time in minutes)</td>
        <td><input type="text" id="91"></td>
    </tr>
    <tr>
        <th colspan="2"><input type="button" value="Save" onclick="
                               $.post(
                                '../ajax/save_cws.php',
                                {
                                    date: document.getElementById('date').value,
                                    fifteen: document.getElementById('15').value,
                                    twenty: document.getElementById('20').value,
                                    twenty_one: document.getElementById('21').value,
                                    twenty_four: document.getElementById('24').value,
                                    twenty_nine: document.getElementById('29').value,
                                    thirty: document.getElementById('30').value,
                                    thirty_one: document.getElementById('31').value,
                                    thirty_two: document.getElementById('32').value,
                                    forty_one_a: document.getElementById('41_a').value,
                                    forty_one_b: document.getElementById('41_b').value,
                                    forty_four: document.getElementById('44').value,
                                    sixty_nine: document.getElementById('69').value,
                                    seventy_two: document.getElementById('72').value,
                                    ninety_one: document.getElementById('91').value
                                },
                                function (response){
                                    //document.write(response);
                                    window.location = '../include/reports.php';
                                }
                           ).fail(failAlert);"></th>
    </tr>
</table>
</div>
<? include "../../footer.php"; ?>