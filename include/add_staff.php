<?php
//include "../../header.php";
include "../header.php";
?>

<!--
file for adding new users, editing user privileges, and resetting user passwords.
-->

<div class="navigation">
<a href="/"><span>Homepage</span></a><!--</li>-->
                        <a href="/include/add_staff.php"><span>Alter Privileges</span></a>
                        <a href="/index.php?action=logout">Log Out</a>
            </div>
<div id="manage_privileges">
<h3>Add User</h3><hr/><br/>
<!--
Add a new user to the system.
-->
<table>
	<tr>
		<td width="25%">Username:</td>
		<td colspan="2"> <input type="text" id="username"></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td> <input type="text" id="password">&nbsp;&nbsp;<span class="helptext">(they will be able to change this)</span></td>
	</tr>
	<tr>
		<td>Privilege level:</td>
		<td colspan="2"> <select id="privilege_level">
				<option>----</option>
				<option value="1">Administrator</option>
				<option value="2">Data Entry</option>
				<option value="3">Viewer</option>
			</select>
		</td>
	</tr>
        <!--
        Enlace and TRP show information based on program-specific privileges, which are 
        included here:
        -->
        <?if ($_COOKIE['sites'][0]==6){?>
        <tr>
            <td>Program Affiliation:</td>
            <td colspan="2"><select id="affiliated_program">
                    <option value="n">No Program Access</option>
                    <option value="a">Access to all program information</option>
                    <?//get enlace programs
                    include "../enlace/include/dbconnopen.php";
                     $get_all_programs="SELECT Programs.Program_ID, Name FROM Programs ORDER BY Name";
                   // include "../include/dbconnopen.php";
                    $all_programs=mysqli_query($cnnEnlace, $get_all_programs);
                    while ($program=mysqli_fetch_row($all_programs)){
                       ?><option value="<?echo $program[0];?>">
                <?echo $program[1];?></option><?
                    }
                    include "../enlace/include/dbconnclose.php";
                    ?>
                </select></td>
        </tr>
        <tr>
        	<td></td>
        	<td><span class="helptext">By affiliating a person with a program, you allow them access to view and enter surveys for youth 
                    in that program.
                </span></td>
        </tr>
        <?}?>
        <?if ($_COOKIE['sites'][0]==4){?>
        <tr>
            <td>Program Affiliation:</td>
            <td><select id="affiliated_program">
                    <option value="n">No Program Access</option>
                    <option value="a">Access to all program information</option>
                    <?//get enlace programs
                    include "../trp/include/dbconnopen.php";
                     $get_all_programs="SELECT Programs.Program_ID, Program_Name FROM Programs ORDER BY Program_Name";
                    include "../include/dbconnopen.php";
                    $all_programs=mysqli_query($cnnTRP, $get_all_programs);
                    while ($program=mysqli_fetch_row($all_programs)){
                       ?><option value="<?echo $program[0];?>">
                <?echo $program[1];?></option><?
                    }
                    include "../trp/include/dbconnclose.php";
                    ?>
                </select></td>
        </tr>
        <tr>
        	<td></td>
        	<td><span class="helptext">By affiliating a person with a program, you allow them access to view and enter surveys for youth 
                    in that program.
                </span></td>
        </tr>
        <?}?>
        <!--
        The site of the user is drawn from the site of the logged-in user.  This is a problem for admin users, 
        for whom the first site cookie will be used, regardless of whether that is the intended site.
        -->
	<tr>
		<td colspan="2"><input type="button" value="Save" onclick="
                    if (<?echo $_COOKIE['sites'][0]?>==6 || <?echo $_COOKIE['sites'][0]?>==4 ){var set_program=document.getElementById('affiliated_program').value;}
                    else{var set_program='';}
       $.post(
        '../ajax/extend_staff_privilege.php',
        {
            username: document.getElementById('username').value,
            password: document.getElementById('password').value,
            level: document.getElementById('privilege_level').options[document.getElementById('privilege_level').selectedIndex].value,
            site: '<?echo $_COOKIE['sites'][0];?>',
            program: set_program
        },
        function (response){
           // document.write(response);
			//window.location='/include/add_staff.php';
			document.getElementById('confirm_add_user').innerHTML = response;
        }
   )">
<div id="confirm_add_user"></div></td>
	</tr>
</table>
<br>
<br>



<h3>Edit Privileges</h3><hr/><br/>
<table>
	<tr>
		<td width="25%">User: </td>
		<td><select id="staff_list">
    <option>-----</option>
    <?
    /*
     * Draws list of existing users that are linked to this site (again, for admin users, it will
     * be the first site that they are linked to)
     */
    $staff_list_query = "SELECT * FROM Users LEFT JOIN Users_Privileges ON 
        (Users_Privileges.User_ID=Users.User_ID) WHERE Users_Privileges.Privilege_ID='" . $_COOKIE['sites'][0] . "'";
    //echo $staff_list_query;
    include "../include/dbconnopen.php";
    $staff_list = mysqli_query($cnnLISC, $staff_list_query);
    print_r($staff_list);
    while ($staff=mysqli_fetch_array($staff_list)){
        echo $staff['User_ID'];
        echo $staff['User_Email'];
        ?>

    <option value="<?echo $staff['User_ID']?>"><?echo $staff['User_Email'];?></option>
            <?
    }
    include "../include/dbconnclose.php";
    ?>
</select></td>
	</tr>
	<tr>
		<td>Privilege List:</td>
		<td><select id="privileges">
    <option value="">-----</option>
    <option value="1">Administrator</option>
    <option value="2">Data Entry</option>
    <option value="3">Viewer</option>
</select></td>
	</tr>
        <!--Again, for TRP and Enlace program-specific privileges will show up:-->
        
		<?if ($_COOKIE['sites'][0]==6){?>
     	<tr>  
            <td>Program Affiliation:</td>
            <td><select id="edit_affiliated_program">
                    <option value="n">No Program Access</option>
                    <option value="a">Access to all program information</option>
                    <?//get enlace programs
                    include "../enlace/include/dbconnopen.php";
                    
                        $get_all_programs="SELECT Programs.Name, Programs.Program_ID FROM Programs 
                           ORDER BY Name";
                       // echo $get_all_programs;
                    include "../include/dbconnopen.php";
                    $all_programs=mysqli_query($cnnEnlace, $get_all_programs);
                    while ($program=mysqli_fetch_row($all_programs)){
                       ?> <option value="<?echo $program[1];?>">
                <?echo $program[0];?></option><?
                    }
                    include "../enlace/include/dbconnclose.php";
                    ?>
                </select></td>
    </tr>
    <tr>
    	<td></td>
    	<td><span class="helptext">By affiliating a person with a program, you allow them access to view and enter surveys for youth 
                    in that program.
                </span></td>
    </tr>
        <?}?><?if ($_COOKIE['sites'][0]==4){?>
	<tr>
            <td>Program Affiliation:</td>
            <td><select id="edit_affiliated_program">
                    <option value="n">No Program Access</option>
                    <option value="a">Access to all program information</option>
                    <?//get enlace programs
                    include "../trp/include/dbconnopen.php";
                     $get_all_programs="SELECT Programs.Program_ID, Program_Name FROM Programs ORDER BY Program_Name";
                    include "../include/dbconnopen.php";
                    $all_programs=mysqli_query($cnnTRP, $get_all_programs);
                    while ($program=mysqli_fetch_row($all_programs)){
                       ?><option value="<?echo $program[0];?>">
                <?echo $program[1];?></option><?
                    }
                    include "../trp/include/dbconnclose.php";
                    ?>
                </select><br/> </td>
	</tr>
	<tr>
		<td></td>
		<td><span class="helptext">By affiliating a person with a program, you allow them access to view and enter surveys for youth 
                    in that program.
                </span></td>
	</tr>
        <?}?>

	<tr>
		<td><input type="button" value="Save" onclick="
    if (<?echo $_COOKIE['sites'][0]?>==6 || <?echo $_COOKIE['sites'][0]?>==4)
    {var set_program=document.getElementById('edit_affiliated_program').value;}
                    else{var set_program='';}
       $.post(
        '../ajax/edit_privileges.php',
        {
            user: document.getElementById('staff_list').options[document.getElementById('staff_list').selectedIndex].value,
            privilege: document.getElementById('privileges').options[document.getElementById('privileges').selectedIndex].value,
            site: '<?echo $_COOKIE['sites'][0]?>',
            program: set_program
        },
        function (response){
            document.write(response);
            document.getElementById('updated_privilege').innerHTML = 'Thanks!  This user\'s privilege setting has been updated.';
        }
   )">
<div id="updated_privilege"></div></td>
		<td></td>
	</tr>
</table>



<br><br>

<h3>Reset Password</h3><hr/><br/>
<table>
	<tr>
		<td width="25%">User:</td>
		<td> <select id="user_id">
			<option>-----</option>
  		  <?
                  /*List of users at this site.*/
 		   include "../include/dbconnopen.php";
                   $site_cookie_sqlsafe=mysqli_real_escape_string($cnnLISC, $_COOKIE['sites'][0]);
 		   $staff_list_query = "SELECT * FROM Users LEFT JOIN Users_Privileges ON 
 		       (Users_Privileges.User_ID=Users.User_ID) WHERE Users_Privileges.Privilege_ID='" . $site_cookie_sqlsafe . "'";
  		  //echo $staff_list_query;
 		   $staff_list = mysqli_query($cnnLISC, $staff_list_query);
 		   print_r($staff_list);
 		   while ($staff=mysqli_fetch_array($staff_list)){
   		     echo $staff['User_ID'];
   		     echo $staff['User_Email'];
  		      ?>
 		   <option value="<?echo $staff['User_ID']?>"><?echo $staff['User_Email'];?></option>
 		           <?
 		   }
		    include "../include/dbconnclose.php";
 		   ?>
		</select></td>
	</tr>
	<tr>
            <!--New password set and confirmed.-->
		<td>New Password:</td>
		<td><input type="text" id="pw"></td>
	</tr>
	<tr>
		<td>Retype Password:</td>
		<td><input type="text" id="pw_check"><br>
<div id="check_warning"></div></td>
	</tr>
	<tr>
		<td colspan="2"><input type="button" value="Submit" onclick="
    var pass = document.getElementById('pw').value;
    var word = document.getElementById('pw_check').value;
    if (pass!=word){
        document.getElementById('check_warning').innerHTML = 'Stop!  These passwords don\'t match!';
    }
    else{
       $.post(
        '../ajax/reset_password.php',
        {
            user:  document.getElementById('user_id').options[document.getElementById('user_id').selectedIndex].value,
            pw: document.getElementById('pw').value
        },
        function (response){
            document.write(response);
			document.getElementById('updated_password').innerHTML = 'Thanks!  This user\'s password has been updated.';
        }
    )
    }">
	<div id="updated_password"></div>
	</td>
	</tr>
</table>



<br>
<br>
 

</div>
<?
include "../footer.php";
?>