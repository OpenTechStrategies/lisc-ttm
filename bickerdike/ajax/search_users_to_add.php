<?php
/*
 * Query-type search for users, specifically for adding them to programs.
 */
/*if the ID isn't specified:
 * If any of the fields is blank, then it isn't included in the search query.  If it is filled in, then
 * the search includes it (zipcode is equal to the selected zip).
 */
if ($_POST['first']==''){$first='';}else{$first=' AND First_Name LIKE "%' . $_POST['first'] . '%"';};
if ($_POST['last']==''){$last='';}else{$last=" AND Last_Name LIKE '%" . $_POST['last'] . "%'";}
if ($_POST['zip']==''){$zip='';}else{$zip=" AND Zipcode='" .$_POST['zip'] . "'";}
if ($_POST['age']==''){$age='';}else{$age=" AND Age='" . $_POST['age'] . "'";}
if ($_POST['gender']==''){$gender='';}else{$gender=" AND Gender='" . $_POST['gender'] . "'";}
if($_POST['race']==''){$race='';}else{$race=" AND Race='" . $_POST['race'] . "'";}
if($_POST['type']==''){$type='';}else{
    if ($_POST['type']==1){
        $type=" AND Adult='1'";
    }
    elseif ($_POST['type']==2){
        $type=" AND Parent='1'";
    }
    elseif ($_POST['type']==3){
        $type=" AND Child='1'";
    }
}

$uncertain_search_query = "SELECT * FROM Users WHERE User_ID!='' " . $first . $last .  $zip .  $age .  $gender . $race . $type;
//echo $uncertain_search_query;

include "../include/dbconnopen.php";
$results =mysqli_query($cnnBickerdike, $uncertain_search_query);
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