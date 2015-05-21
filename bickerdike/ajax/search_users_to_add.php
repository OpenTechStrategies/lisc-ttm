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

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

/*
 * Query-type search for users, specifically for adding them to programs.
 */
/*if the ID isn't specified:
 * If any of the fields is blank, then it isn't included in the search query.  If it is filled in, then
 * the search includes it (zipcode is equal to the selected zip).
 */
include "../include/dbconnopen.php";
$first_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['first']);
$last_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['last']);
$zip_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['zip']);
$age_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['age']);
$gender_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['gender']);
$race_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['race']);
$type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['type']);

if ($_POST['first']==''){$first_sqlsafe='';}else{$first_sqlsafe=' AND First_Name LIKE "%' . $first_sqlsafe . '%"';};
if ($_POST['last']==''){$last_sqlsafe='';}else{$last_sqlsafe=" AND Last_Name LIKE '%" . $last_sqlsafe . "%'";}
if ($_POST['zip']==''){$zip_sqlsafe='';}else{$zip_sqlsafe=" AND Zipcode='" .$zip_sqlsafe . "'";}
if ($_POST['age']==''){$age_sqlsafe='';}else{$age_sqlsafe=" AND Age='" . $age_sqlsafe . "'";}
if ($_POST['gender']==''){$gender_sqlsafe='';}else{$gender_sqlsafe=" AND Gender='" . $gender_sqlsafe . "'";}
if($_POST['race']==''){$race_sqlsafe='';}else{$race_sqlsafe=" AND Race='" . $race_sqlsafe . "'";}
if($_POST['type']==''){$type_sqlsafe='';}else{
    if ($_POST['type']==1){
        $type_sqlsafe=" AND Adult='1'";
    }
    elseif ($_POST['type']==2){
        $type_sqlsafe=" AND Parent='1'";
    }
    elseif ($_POST['type']==3){
        $type_sqlsafe=" AND Child='1'";
    }
}

$uncertain_search_query_sqlsafe = "SELECT * FROM Users WHERE User_ID!='' " . $first_sqlsafe . $last_sqlsafe .  $zip_sqlsafe .  $age_sqlsafe .  $gender_sqlsafe . $race_sqlsafe . $type_sqlsafe;
//echo $uncertain_search_query_sqlsafe;

$results =mysqli_query($cnnBickerdike, $uncertain_search_query_sqlsafe);
?>
<!--Results come in a dropdown format.-->

<select  id="choose_from_all_adults">
    <option value="">-----</option>
    <?
while ($user=mysqli_fetch_array($results)){
    ?>
    <tr>
        <option value="<?echo $user['User_ID'];?>"><?echo $user['User_ID'] . ": " . $user['First_Name'] . " " . $user['Last_Name'];?></option>

        <?
}
include "../include/dbconnclose.php";
?>
</select>
<!--Button is included here and not on program profile so that the user id can be gotten from results and
isn't a pain to pass back and forth.-->
<input type="button" value="Add Participant" onclick="
			       $.post(
 			       '../ajax/add_participant.php',
 			           {
			                program_id: '<?echo $_POST['program'];?>',
			                user_id: document.getElementById('choose_from_all_adults').options[document.getElementById('choose_from_all_adults').selectedIndex].value
			            },
			           function (response){
 			              //window.location = '../activities/program_profile.php?program=<?echo $_POST['program'];?>';
						  document.getElementById('show_user_ok').innerHTML += 'Thank you for adding '+ response +'. <br>';
						  document.getElementById('first_n').value = '';
						  document.getElementById('last_n').value = '';
						  document.getElementById('zip').value = '';
						  document.getElementById('age').value = '';
						  document.getElementById('user_gender').value = '';
						  document.getElementById('user_race').value = '';
						  document.getElementById('type').value = '';
						  document.getElementById('choose_from_all_adults').value = '';
			           }
			   )">
<div id="show_user_ok"></div>