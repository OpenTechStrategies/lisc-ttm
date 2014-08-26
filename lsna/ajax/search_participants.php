<?php
/*search participants: */
include "../include/dbconnopen.php";
$first_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['first']);
$last_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['last']);
$gender_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['gender']);
$grade_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['grade']);

$date_reformat=explode('-', $_POST['dob']);
$save_date=$date_reformat[2] . '-'. $date_reformat[0] . '-'. $date_reformat[1];

/*if the search terms are filled in, they are included in the query: */
if ($_POST['first']==''){$first='';}else{$first=' AND Participants.Name_First LIKE "%' . $first_sqlsafe . '%"';};
if ($_POST['last']==''){$last='';}else{$last=" AND Participants.Name_Last LIKE '%" . $last_sqlsafe . "%'";}
if ($_POST['gender']==''){$gender='';}else{$gender=" AND Participants.Gender='" . $gender_sqlsafe . "'";}
if ($_POST['dob']==''){$dob='';}else{$dob=" AND Participants.Date_of_Birth='" .$save_date . "' ";}
if ($_POST['grade']==''){$grade='';}else{$grade=" AND Participants.Grade_Level='" . $grade_sqlsafe . "'";}
if ($_POST['pm']==1){$pm_join=" LEFT JOIN Participants_Subcategories ON Participants.Participant_ID=Participants_Subcategories.Participant_ID ";
$pm=" AND Subcategory_ID=19 ";
}
elseif($_POST['pm']==2){//$pm_join=" LEFT JOIN Participants_Subcategories ON Participants.Participant_ID=Participants_Subcategories.Participant_ID ";
$pm_join="LEFT JOIN
 Participants_Subcategories 
ON (Participants.Participant_Id=Participants_Subcategories.Participant_ID AND Subcategory_ID='19')";
//$pm=" AND Subcategory_ID!=19 ";
$pm=" AND Participant_Subcategory_ID IS NULL";
}else{$pm_join=""; $pm="";}

if ($_POST['year']==''){$year='';}else{
    $year_join=" LEFT JOIN PM_Years ON Participants.Participant_ID=Participant ";
    $year=" AND Year='" . $_POST['year'] . "'";}

if ($_POST['role']==''){
    $uncertain_search_query = "SELECT * FROM Participants " . $pm_join . $year_join .  " WHERE Participants.Participant_ID!='' " . $first . $last.  
            $gender .  $dob .  $grade . $year . 
            $pm . " GROUP BY Participants.Participant_ID ORDER BY Name_Last";
}
else{
    $uncertain_search_query = "SELECT * FROM Participants
    INNER JOIN Participants_Roles
    ON Participants.Participant_ID=Participants_Roles.Participant_ID " . $pm_join . $year_join . "
    WHERE Participants_Roles.Role_ID='" . $_POST['role'] . "'" . $first . $last.  $gender .  $dob .  $grade . $pm . $year .
            " GROUP BY Participants.Participant_ID ORDER BY Name_Last";
}



/*$actual_find_non_pms="SELECT * FROM Participants LEFT JOIN
 Participants_Subcategories 
ON (Participants.Participant_Id=Participants_Subcategories.Participant_ID AND Subcategory_ID='19')
WHERE Participant_Subcategory_ID IS NULL;";*/

//echo $uncertain_search_query;

$results =mysqli_query($cnnLSNA, $uncertain_search_query);
?>
<br/>

<!--show results as dropdown: -->
<?if ($_POST['result']=='dropdown'){
    /*results for surveys: */
    if ($_POST['action']=='teacher'){
        ?>
        <span class="helptext">Select the name of the teacher: </span><select id="new_teacher_name">
            <option value="">-----</option>
            <?while ($user=mysqli_fetch_array($results)){
                ?><option value="<?echo $user['Participant_ID']?>"><?echo $user['Name_First'] . " " . $user['Name_Last'];?></option><?
            }
            ?>
        </select>
        <?
    }
    else{
    ?>
        <span class="helptext">Select the name of the person you would like to add: </span><select id="relative_search">
            <option value="">-----</option>
            <?while ($user=mysqli_fetch_array($results)){
                ?><option value="<?echo $user['Participant_ID']?>"><?echo $user['Name_First'] . " " . $user['Name_Last'];?></option><?
            }
            ?>
        </select>
        <?
    }
}
else{?>
        <!--Table of search results: -->
<h4>Search Results</h4>
    <table class="program_table" style="width:750px;">
    <tr>
        <th>Database ID</th>
		<th>Name</th>
        <th>Gender</th>
        <th width="12%">Date of Birth</th>
        <th>Grade Level</th>
        <th>Role(s)</th>
		<th></th>
    </tr>
    <?
while ($user=mysqli_fetch_array($results)){
	$date_formatted = explode('-', $user['Date_of_Birth']);
	$date = $date_formatted[1] . '-'. $date_formatted[2] . '-'. $date_formatted[0];
    ?>
    <tr>
        <td class="all_projects" ><?echo $user['Participant_ID'];?></td>
		<td class="all_projects" style="text-align:left;"><a href="javascript:;" onclick="
		$('#participant_search_div').hide();
		$('#new_participant_div').hide();
		$('#participant_profile_div').show();
                   $.post(
                        '/lsna/ajax/set_participant_id.php',
                        {
                            page: 'profile',
                            participant_id:'<?echo $user['Participant_ID'];?>'
                        },
                        function (response){
                            if (response!='1'){
                                document.getElementById('show_error').innerHTML = response;
                            }
                            document.write(response);
                            window.location='/lsna/participants/participant_profile.php';
                       }
           );
		"><?echo $user['Name_First'] . " " . $user['Name_Last'];?></a></td>
        <td class="all_projects"><?if ($user['Gender']=='m'){echo 'Male';}else if ($user['Gender']=='f'){echo 'Female';}?></td>
        <td class="all_projects"><?echo $date;?></td>
        <td class="all_projects"><?echo $user['Grade_Level'];?></td>
        <td class="all_projects"><?$get_roles = "SELECT * FROM Participants_Roles INNER JOIN Roles ON Participants_Roles.Role_ID=
            Roles.Role_ID WHERE Participants_Roles.Participant_ID='" . $user['Participant_ID'] . "'";
            $roles = mysqli_query($cnnLSNA, $get_roles);
            while ($role = mysqli_fetch_array($roles)){
                echo $role['Role_Title'] . "<br>";
            }
        ?></td><td class="all_projects hide_on_view">
            <input type="button" value="Delete..." class="hide_on_view" onclick="
                   var double_check=confirm('Are you sure you want to delete this participant from the database?  This action cannot be undone.');
                   if (double_check){
                       $.post(
                        '../ajax/delete_elements.php',
                        {
                            action: 'participant',
                            id: '<?echo $user['Participant_ID'];?>'
                        },
                        function (response){
                            //document.write(response);
                            alert('This participant has been successfully deleted.');
                        }
                   );
                   }
                                  ">
        </td>
    </tr>
        <?
}
include "../include/dbconnclose.php";
?>
    </table>
<div id="show_error"></div>
<?}?>