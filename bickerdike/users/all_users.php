<?php

//list all users, make them editable and deletable 
//add search module
include "../../header.php";
include "../header.php";

?>

<!--Hide the "remove participants" area, but leave the option there-->

<script type="text/javascript">
            $(document).ready(function(){
				$('#remove_participants').hide();
				$('.remove_step').hide();
				$('#participants_selector').addClass('selected');
                                $('.edit_hide').hide();
				$("a.add_new").hover(function(){
				$(this).addClass("selected");
			}, function() {
				$(this).removeClass("selected");
			});
            });
           
            </script>
<div class="content_wide" id="search_participant_div">		
    
<h3>Participants</h3><hr/><br/>

<div style="text-align:center;"><a href="../users/add_user.php" class="add_new hide_on_view"><span class="add_new_button">Add New Participant</span></a></div><br/>
<h4>Search All Participants:</h4>
<table class="search_table">
    <tr><td class="all_projects"><strong>First Name:</strong></td>
        <td class="all_projects"><input type="text" id="first_n"></td>
        <td class="all_projects"><strong>Last Name:</strong></td>
        <td class="all_projects"><input type="text" id="last_n"></td>
    </tr>
    <tr>
        <td class="all_projects"><strong>Zipcode:</strong></td>
        <td class="all_projects"><select id="zip">
                <option value="">-----</option>
                <?
                //only allows data enterers to choose zipcodes from those already entered (odd)
                $get_zips_sqlsafe = "SELECT Zipcode FROM Users WHERE Zipcode !=0 GROUP BY Zipcode";
                include "../include/dbconnopen.php";
                $zips = mysqli_query($cnnBickerdike, $get_zips_sqlsafe);
                while ($zip = mysqli_fetch_row($zips)){
                    ?>
                <option value="<?echo $zip[0];?>"><?echo $zip[0];?></option>
                        <?
                }
                include "../include/dbconnclose.php";
                ?>
            </select></td>
        <td class="all_projects"><strong>Age:</strong></td>
        <td class="all_projects"><select id="age">
                <option value="">-----</option>
                <option value="12">10-19</option>
                <option value="20">20-34</option>
                <option value="35">35-44</option>
                <option value="45">45-59</option>
                <option value="60">60 or over</option>
            </select></td>
    </tr>
    <tr>
        <td class="all_projects"><strong>Gender:</strong></td>
        <td class="all_projects"><select id="user_gender">
                <option value="">-----</option>
                <option value="F">Female</option>
                <option value="M">Male</option>
            </select></td>
            <td class="all_projects"><strong>Race/Ethnicity:</strong></td><td class="all_projects"><select id="user_race">
                <option value="">-----</option>
                <option value="b">Black</option>
                <option value="l">Latino</option>
                <option value="a">Asian</option>
                <option value="w">White</option>
                <option value="o">Other</option>
            </select></td>
    </tr>
    <tr><td class="all_projects">
            <strong>Participant Type:</strong>
        </td>
        <td class="all_projects">
            <select id="type">
                <option value="">-----</option>
                <option value="1">Adult</option>
                <option value="2">Parent</option>
                <option value="3">Youth</option>
            </select>
        </td>
		<td class="all_projects" colspan="2"></td>
    </tr>
    <tr>
        <th colspan="4"><input type="button" value="Search" onclick="
                               $.post(
                                '../ajax/search_users.php',
                                {
                                    first: document.getElementById('first_n').value,
                                    last: document.getElementById('last_n').value,
                                    zip: document.getElementById('zip').value,
                                    age: document.getElementById('age').value,
                                    gender: document.getElementById('user_gender').value,
                                    race: document.getElementById('user_race').value,
                                    type: document.getElementById('type').value
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('show_results').innerHTML = response;
                                }
                           )"></th>
    </tr>
</table>

<div id="show_results"></div>

<br/><br/>

<!--
This area allows users to remove people from the database either by merging them with someone else
or deleting them outright.  The merging is still not available on the live site.
-->

<h4 onclick="$('#remove_participants').toggle();
			 $('#remove_1').show();" style="cursor:pointer;">Remove Participants</h4>
<div id="remove_participants">
	<div class="remove_step" id="remove_1">
            <!--First find person that needs to be removed: -->
            
		<span class="helptext">Search for the participant whose profile you would like to delete.</span>
		<table class="search_table">
			<tr><td class="all_projects"><strong>First Name:</strong></td>
				<td class="all_projects"><input type="text" id="first_name1"></td>
				<td class="all_projects"><strong>Last Name:</strong></td>
				<td class="all_projects"><input type="text" id="last_name1"></td>
			</tr>
			<tr><td class="all_projects"><strong>Database ID:</strong></td>
				<td class="all_projects"><input type="text" id="db_id1"></td>
				<td class="all_projects"><input type="button" value="Search" onclick="
                               $.post(
                                '../ajax/search_users.php',
                                {
                                    first: document.getElementById('first_name1').value,
                                    last: document.getElementById('last_name1').value,
                                    id: document.getElementById('db_id1').value,
									remove: '1'
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('search_results1').innerHTML = response;
                                }
                           )"></td>
			</tr>
		</table>
		<div id="search_results1"></div>
	</div>
	<!--Now, if you need to merge the person (esp in the case of duplicate entry), find the other
        account for that person and merge them.
        Merging includes programs, events, health data, attendance.  The basic info (address, phone, etc) will be lost for the
        deleted person and retained for the profile that is the recipient of the merge.
        -->
	<div class="remove_step" id="remove_3a">
		<span class="helptext">Search for the profile you would like to transfer participant #<?echo $user1['User_ID'];?>'s information to.</span>
		<table class="search_table">
			<tr><td class="all_projects"><strong>First Name:</strong></td>
				<td class="all_projects"><input type="text" id="first_name2"></td>
				<td class="all_projects"><strong>Last Name:</strong></td>
				<td class="all_projects" colspan="2"><input type="text" id="last_name2"></td>
			</tr>
			<tr><td class="all_projects"><strong>Database ID:</strong></td>
				<td class="all_projects"><input type="text" id="db_id2"></td>
				<td class="all_projects"><input type="button" value="Search" onclick="
                               $.post(
                                '../ajax/search_users.php',
                                {
                                    first: document.getElementById('first_name2').value,
                                    last: document.getElementById('last_name2').value,
                                    id: document.getElementById('db_id2').value,
									remove: '2'
                                },
                                function (response){
                                    //document.write(response);
                                    document.getElementById('search_results2').innerHTML = response;
                                }
                           )"></td>
			</tr>
		</table>
		<div id="search_results2"></div>
	</div>
	<div class="remove_step" id="remove_3b">
	
	</div>
</div>

<!-------------------------------->

<!--<table class="all_participants">
    <tr>
        <th style="text-align:left;">Name</th>
        <th>Zipcode</th>
        <th>Main Program</th>
        <th></th>
    </tr>
    <?
    //include "../include/dbconnopen.php";
    //$get_all_users_query_sqlsafe = "SELECT * FROM Users ORDER BY Last_Name";
    //$all_users = mysqli_query($cnnBickerdike, $get_all_users_query_sqlsafe);
    //$count=0;
    //while ($user=mysqli_fetch_array($all_users)){
    
    ?>
    <tr>
        <td class="all_projects" style="text-align:left;"><a href="user_profile.php?id=<?//echo $user['User_ID'];?>"><?//echo $user['First_Name'] ." " . $user['Last_Name']?></a><br>
                        <div class="edit_hide">First Name: <input type="text" id="edit_first_<?//echo $count;?>"><br>
                        Last Name: <input type="text" id="edit_last_<?//echo $count;?>"></div></td>
                        <td class="all_projects"><?//echo $user['Zipcode'];?><br><div class="edit_hide">Zipcode: <input type="text" id="edit_zip_<?//echo $count;?>"></div></td>
<!--        <td class="all_projects"></td>-->
       <!-- <td class="all_projects"><!--<input type="button" value="Edit" onclick="
                                        $('.edit_hide').toggle();
                                        ">-->
            <!--<input type="button" class="edit_hide" value="Save Changes" onclick="
                                        $.post(
                                            '../ajax/edit_user.php',
                                            {
                                                first_name: document.getElementById('edit_first_<?//echo $count;?>').value,
                                                last_name: document.getElementById('edit_last_<?//echo $count;?>').value,
                                                user_id: '<?//echo $user['User_ID'];?>',
                                                zip: document.getElementById('edit_zip_<?//echo $count;?>').value
                                            },
                                            function (response){
                                                //document.write(response);
                                                window.location='all_users.php';
                                            }
                                    )
                                    "><input type="button" value="Delete" onclick="
                                                var first='<?//echo $user['First_Name']?>';
                                                var last='<?//echo $user['Last_Name']?>';
                                                var answer = confirm('Are you sure you want to delete '+first+' '+last+' from the database?');
                                                if (answer){
                                                    $.post(
                                                        '../ajax/delete_user.php',
                                                        {
                                                            user_id: '<?//echo $user['User_ID'];?>'
                                                        },
                                                        function (response){
                                                            //document.write(response);
                                                            window.location = 'all_users.php';
                                                        }
                                                    );
                                                }
                                                else{
                                                   // alert('guess you weren\'t sure');
                                                }
                                "></td>
    </tr>
    <?
    //$count=$count+1;
    //}
    //include "../include/dbconnclose.php";?>
</table>-->


</div>

<? include "../../footer.php"; ?>