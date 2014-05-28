<?php
/*
 * Completes all necessary procedures for adding a new program
 */


/*Test here to see whether the program is associated with a new organization or type.  If so, add the organization,
 *  type, and program here.
*/
if (isset($_POST['new_org']) && isset($_POST['new_type']) && $_POST['new_org']!='' && $_POST['new_type']!=''){
    $make_org="INSERT INTO Org_Partners (Partner_Name) VALUES ('" . $_POST['new_org'] ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_org);
    $org_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $make_type="INSERT INTO Program_Types (Program_Type_Name) VALUES ('" . $_POST['new_type'] ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_type);
    $type_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $make_program="INSERT INTO Programs (
                    Program_Name,
                    Program_Organization,
                    Program_Type) VALUES(
                    '" . $_POST['name'] ."',
                    '" . $org_id ."',
                    '" . $type_id ."'
                    )";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $make_program);
$id= mysqli_insert_id($cnnBickerdike);
include "../include/dbconnclose.php";
}

/*This adds a new organization and program if only a new organization has been created (i.e. not a new type
 * of program).*/
elseif (isset($_POST['new_org']) && $_POST['new_org']!=''){
    $make_org="INSERT INTO Org_Partners (Partner_Name) VALUES ('" . $_POST['new_org'] ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_org);
    $org_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $make_program="INSERT INTO Programs (
                    Program_Name,
                    Program_Organization,
                    Program_Type) VALUES(
                    '" . $_POST['name'] ."',
                    '" . $org_id ."',
                    '" . $_POST['type'] ."'
                    )";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $make_program);
$id= mysqli_insert_id($cnnBickerdike);
include "../include/dbconnclose.php";
}

/*This adds a new program type and program if only a new type has been created (i.e. not a new organization).*/
elseif (isset($_POST['new_type']) && $_POST['new_type']!=''){
    $make_type="INSERT INTO Program_Types (Program_Type_Name) VALUES ('" . $_POST['new_type'] ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_type);
    $type_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $make_program="INSERT INTO Programs (
                    Program_Name,
                    Program_Organization,
                    Program_Type) VALUES(
                    '" . $_POST['name'] ."',
                    '" . $_POST['org'] ."',
                    '" . $type_id ."'
                    )";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $make_program);
$id= mysqli_insert_id($cnnBickerdike);
include "../include/dbconnclose.php";
}

/*
 * Finally, if the program is linked to an existing organization and is of an existing type
 * (or if those fields were left blank), just add the new program:
 */

else{
$make_program="INSERT INTO Programs (
                    Program_Name,
                    Program_Organization,
                    Program_Type) VALUES(
                    '" . $_POST['name'] ."',
                    '" . $_POST['org'] ."',
                    '" . $_POST['type'] ."'
                    )";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $make_program);
$id= mysqli_insert_id($cnnBickerdike);
include "../include/dbconnclose.php";
}
?>





<?
//include "../include/datepicker.php";
include "../classes/program.php";
$program = new Program();
$program->load_with_program_id($id);

$dates = $program->get_dates();
while ($date = mysqli_fetch_array($dates)){
    echo $date['Program_Date'] . "<br>";
}


?>

<!--<input type="text" id="first_program_date">-->

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
                                $zips = mysqli_query($cnnBickerdike, $get_zips);
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
            '../ajax/search_users_to_add.php',
            {
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
                document.getElementById('show_results').innerHTML = response;
            }
        )"></td>
                    </tr>
					<tr>
						<td class="blank" colspan="4"><span class="helptext">A dropdown menu containing your search results will appear below. Select the name of the individual you would like to add to this program from the dropdown menu.</span></td>
					</tr>
                    <tr>
                        <td class="blank" colspan="4">
                            <div id="show_results">
                            </div>
                        </td>
                    </tr>
                </table><br>
   Or, <a href="program_profile.php?program=<?echo $id?>">go to program profile</a>.

   
<div id="show_user_ok"></div>

