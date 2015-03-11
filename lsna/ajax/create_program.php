<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/*create a new program or campaign: 
 */
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['name']);
$issue_area_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue_area']);
$type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['type']);
$clc_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['clc']);

    $make_program="INSERT INTO Subcategories (
                Subcategory_Name, Campaign_or_Program) VALUES(
                '" . $name_sqlsafe ."',
                '" . $issue_area_sqlsafe . "')";
    //echo $make_program;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $make_program);
    $id= mysqli_insert_id($cnnLSNA);
    include "../include/dbconnclose.php";
    
    /*link the new campaign/program to a category so that it shows up properly under
     * "Issue Areas"
     */
    $link_to_category="INSERT INTO Category_Subcategory_Links (Category_ID, Subcategory_ID)
                        VALUES ('" . $type_sqlsafe . "', '" . $id ."')";
     include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $link_to_category);
    include "../include/dbconnclose.php";
    
    /*obsolete.  CLCs aren't used this way. */
        $link_to_clc="INSERT INTO CLC_Subcategory (CLC_ID, Subcategory_ID)
                        VALUES ('" . $clc_sqlsafe . "', '" . $id ."')";
       // echo $link_to_clc;
     include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $link_to_clc);
    include "../include/dbconnclose.php";

?>


<?

include "../classes/program.php";
?>

                                              
                   <!--
                   Add dates and people to new program/campaign.
                   -->
                   
                   
<!--<input type="text" id="first_program_date" >-->
<input type="button" value="Add Date" onclick="
    var date=document.getElementById('first_program_date').value;
    if (date!=''){
                $.post(
                '../ajax/add_new_program_date.php',
                {
                    program_id: '<?echo $id;?>',
                    date: document.getElementById('first_program_date').value
                },
                function (response){
                    //alert('response');
                    document.getElementById('show_ok').innerHTML += 'Thank you for adding '+document.getElementById('first_program_date').value + ' <br>';
					document.getElementById('first_program_date').value = '';
                    document.getElementById('first_program_date').focus();
                }
            );}"><br/><span class="helptext">Dates must be entered in the format YYYY-MM-DD.</span>
<div id="show_ok"></div>
<br/><br/>
<h4>Add Program Participants:</h4>

<table class="inner_table" id="user_search">
                    <tr><td>First Name:</td>
                        <td><input type="text" id="first_n"></td>
                        <td>Last Name:</td>
                        <td><input type="text" id="last_n"></td>
                    </tr>
                    <tr>
                        <td>Zipcode:</td>
                        <td><select id="zip">
                                <option value="">-----</option>
                                <?
                                $get_zips = "SELECT Zipcode FROM Users WHERE Zipcode !=0 GROUP BY Zipcode";
                                include "../include/dbconnopen.php";
                                $zips = mysqli_query($cnnLSNA, $get_zips);
                                while ($zip = mysqli_fetch_row($zips)) {
                                    ?>
                                    <option value="<? echo $zip[0]; ?>"><? echo $zip[0]; ?></option>
                                    <?
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select></td>
                        <td>Age:</td>
                        <td><select id="age">
                                <option value="">-----</option>
                                <option value="12">12-19</option>
                                <option value="20">20-34</option>
                                <option value="35">35-44</option>
                                <option value="45">45-59</option>
                                <option value="60">60 or over</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td><select id="user_gender">
                                <option value="">-----</option>
                                <option value="F">Female</option>
                                <option value="M">Male</option>
                            </select></td>
                        <td>Race/Ethnicity:</td><td><select id="user_race">
                                <option value="">-----</option>
                                <option value="b">Black</option>
                                <option value="l">Latino</option>
                                <option value="a">Asian</option>
                                <option value="w">White</option>
                                <option value="o">Other</option>
                            </select></td>
                    </tr>
                    <tr><td>
                            Participant Type:
                        </td>
                        <td>
                            <select id="type">
                                <option value="">-----</option>
                                <option value="1">Adult</option>
                                <option value="2">Parent</option>
                                <option value="3">Youth</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="blank" colspan="4"><input type="button" value="Search" onclick="
            $.post(
            '../ajax/search_participants.php',
            {
                result: 'dropdown',
                first: document.getElementById('first_n').value,
                last: document.getElementById('last_n').value,
                zip: document.getElementById('zip').value,
                age: document.getElementById('age').value,
                gender: document.getElementById('user_gender').value,
                race: document.getElementById('user_race').value,
                type: document.getElementById('type').value,
                program: <? echo $id; ?>
            },
            function (response){
                //document.write(response);
                document.getElementById('show_results_new_program').innerHTML = response;
            }
        )"></td>
                    </tr>
					<tr>
						<td class="blank" colspan="4"><span class="helptext">A dropdown menu containing your search results will appear below. Select the name of the individual you would like to add to this program from the dropdown menu.</span></td>
					</tr>
                    <tr>
                        <td class="blank" colspan="4">
                            <div id="show_results_new_program">
                            </div>
                            <input type="button" value="Add" onclick="
                                   $.post(
                                   '../ajax/add_participant_to_program.php',
                                   {
                                    participant: document.getElementById('relative_search').options[document.getElementById('relative_search').selectedIndex].value,
                                    subcategory: '<?echo $id;?>'
                                   },
                               function (response){
                                   document.getElementById('show_user_ok_new_program').innerHTML = 'Thank you for adding this participant to this program';
                               }
                               )">
                        </td>
                    </tr>
                </table>

<div id="show_user_ok_new_program"></div>


Or, <a href="javascript:;" onclick="
                                                  $.post(
                                                    '../ajax/set_program_id.php',
                                                    {
                                                        id: '<?echo $id;?>',
                                                        page: 'search'
                                                    },
                                                    function (response){
                                                        if (response!='1'){
                                                            document.getElementById('show_error').innerHTML = response;
                                                        }
                                                        window.location='program_profile.php';
                                                    }
                                              )">go to program profile</a>.<br/><br/>