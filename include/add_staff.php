<?php
//include "../../header.php";
include "../header.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#add_program_select_all').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.add_program_checkbox').each(function() { //loop through each checkbox
                this.checked = true;  
            });
        }else{
            $('.add_program_checkbox').each(function() { //loop through each checkbox
                this.checked = false; 
            });        
        }
    });
    $('#edit_program_select_all').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.edit_program_checkbox').each(function() { //loop through each checkbox
                this.checked = true;  
            });
        }else{
            $('.edit_program_checkbox').each(function() { //loop through each checkbox
                this.checked = false; 
            });        
        }
    });
   
});
</script>
<?php
if (!isLoggedIn()) {
    $die_unauthorized("Sorry, you must be logged in to access this page!");
}


$subsite_admin_access = array();
// Find the sites that this user has admin access for
foreach ($USER->site_permissions as $site_id => $site_info) {
    if ($USER->has_site_access($site_id, $AdminAccess)) {
        $subsite_admin_access[] = $site_id;
    }
}

$show_programs = false;
if ( in_array($Enlace_id, $subsite_admin_access) && (($_POST['choose_site'] == $Enlace_id) || ! isset($_POST['choose_site']) ) ) {
    include "../enlace/include/dbconnopen.php";
    $get_all_programs_sqlsafe="SELECT Programs.Program_ID, Name FROM Programs ORDER BY Name";
    $all_programs=mysqli_query($cnnEnlace, $get_all_programs_sqlsafe);
    $all_programs_array = array();
    while ($program=mysqli_fetch_row($all_programs)) { 
        $all_programs_array[] = $program;
    }
    include "../enlace/include/dbconnclose.php";
    $show_programs = true;
} elseif ( in_array($TRP_id, $subsite_admin_access) && ($_POST['choose_site'] == $TRP_id || ! isset($_POST['choose_site']) ) ) {
    include "../trp/include/dbconnopen.php";
    $get_all_programs_sqlsafe="SELECT Programs.Program_ID, Program_Name FROM Programs ORDER BY Program_Name";
    $all_programs=mysqli_query($cnnTRP, $get_all_programs_sqlsafe);
    $all_programs_array = array();
    while ($program=mysqli_fetch_row($all_programs)) { 
        $all_programs_array[] = $program;
    }
    include "../trp/include/dbconnclose.php";
    $show_programs = true;
}
if ( empty($subsite_admin_access)) {
    $die_unauthorized("You don't seem to be an administrator for any subsite!");
}

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

<?php
//if they have admin access to more than one subsite:
    if (count($subsite_admin_access) > 1 ) {
?>

<h3>Current site: <?php
if (isset($_POST['choose_site'])) {echo $_POST['choose_site']; }
elseif (count($subsite_admin_access) == 1) {echo $subsite_admin_access[0];}
else {echo "Select a site";}
?>
</h3><hr/><br/><!-- really needs to be the set of sites they have access to -->
<form action="" method="post">
               <select name="choose_site">
                    <option value = "">----</option>
<?php
if ( in_array($LSNA_id, $subsite_admin_access)) {
?>
    <option value = "<?php echo $LSNA_id; ?>">LSNA</option>        
<?php
}
if ( in_array($Bickerdike_id, $subsite_admin_access)) {
?>
    <option value = "<?php echo $Bickerdike_id; ?>">Bickerdike</option>
<?php
}
if ( in_array($TRP_id, $subsite_admin_access)) {
?>
    <option value = "<?php echo $TRP_id; ?>">TRP</option>
<?php
}
if ( in_array($SWOP_id, $subsite_admin_access)) {
?>
    <option value = "<?php echo $SWOP_id; ?>">SWOP</option>
<?php
}
if ( in_array($Enlace_id, $subsite_admin_access)) {
?>
    <option value = "<?php echo $Enlace_id; ?>">Enlace</option>
<?php
}
?>
                    </select>
<input type="submit" name="site_submit" value="Select Site">
</form>

<?php
    } //end multiple-site check

if (count($subsite_admin_access) > 1 && ! isset($_POST['choose_site']) ) {
    echo "Please select a site for user administration.";
}
else{
?>

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
        <?php if ($show_programs) { ?>
        <tr>
            <td>Program Affiliation:</td>
            <td colspan="2">
<table id = "show_program_checkboxes">
<tr>
<td>
<label for="program_list"><strong>Select all:</strong></label>
</td>
<td>
<input type="checkbox" id="add_program_select_all" />
</td>
</tr>
<?php
foreach ($all_programs_array as $program) { 
?>
<tr>
<td>
<label for="program_list"><?php echo $program[1];?>:</label>
</td>
<td>
<input type="checkbox" name = "add_programs[]" id="program_list" class = "add_program_checkbox" value="<?php echo $program[0];?>" />
</td>
</tr>
<?php
}
?>
</table>    </td>
        </tr>
        <tr>
        	<td></td>
        	<td><span class="helptext">By affiliating a person with a program, you allow them access to view and enter surveys for youth 
                    in that program.
                </span></td>
        </tr>
        <?php  } 


// determine which site we're adding a user to
                    if ( isset($_POST['choose_site'])) {
                        $site = $_POST['choose_site'];
                    }
                    else{
                        if ( count($subsite_admin_access) == 1) {
                            $site = $subsite_admin_access[0];
                        }
                        else{
                            echo "An error has occurred.  Please choose a site.";
                        }
                    }
?>
	<tr>
		<td colspan="2"><input type="button" value="Save" onclick="
        var programs = document.getElementsByName('add_programs[]');
        var program_array = new Array();
        var program_array_key = 0;
        for (var k = 0; k < programs.length; k++) {
            if (programs[k].checked == true) {
                program_array[program_array_key] = programs[k].value;
                program_array_key++;
            }
        }
        $.post(
            '../ajax/extend_staff_privilege.php',
        {
            username: document.getElementById('username').value,
            password: document.getElementById('password').value,
            level: document.getElementById('privilege_level').options[document.getElementById('privilege_level').selectedIndex].value,
            site: '<?php echo $site;?>',
            program: program_array
        },
        function (response){
            document.getElementById('confirm_add_user').innerHTML = response;
        }
   ).fail(failAlert);">
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
    <?php
    /*
     * Draws list of existing users that are linked to this site
     */
    include "../include/dbconnopen.php";

    $site_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $site);
    $staff_list_query_sqlsafe = "SELECT * FROM Users LEFT JOIN Users_Privileges ON 
        (Users_Privileges.User_ID=Users.User_ID) WHERE Users_Privileges.Privilege_ID='" . $site_id_sqlsafe . "'";
    $staff_list = mysqli_query($cnnLISC, $staff_list_query_sqlsafe);
    while ($staff=mysqli_fetch_array($staff_list)){
        echo $staff['User_ID'];
        echo $staff['User_Email'];
        ?>

    <option value="<?php echo $staff['User_ID']?>"><?php echo $staff['User_Email'];?></option>
            <?php 
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
        
        <?php if ($show_programs) { ?>
     	<tr>  
            <td>Program Affiliation:</td>
            <td>
<table id = "show_program_checkboxes">
<tr>
<td>
<label for="program_list"><strong>Select all:</strong></label>
</td>
<td>
<input type="checkbox" id="edit_program_select_all" />
</td>
</tr>
<?php
foreach ($all_programs_array as $program) { 
?>
<tr>
<td>
<label for="program_list"><?php echo $program[1];?>:</label>
</td>
<td>
<input type="checkbox" name = "edit_programs[]" id="program_list" class = "edit_program_checkbox" value="<?php echo $program[0];?>" />
</td>
</tr>
<?php
}
?>
</table>    
            </td>
        </tr>
        <?php  } ?>

    <tr>
    	<td></td>
    	<td><span class="helptext">By affiliating a person with a program, you allow them access to view and enter surveys for youth in that program.</span></td>
    </tr>

	<tr>
		<td><input type="button" value="Save" onclick="
        var programs = document.getElementsByName('edit_programs[]');
        var program_array = new Array();
        var program_array_key = 0;
        for (var k = 0; k < programs.length; k++) {
            if (programs[k].checked == true) {
                program_array[program_array_key] = programs[k].value;
                program_array_key++;
            }
        }
       $.post(
        '../ajax/edit_privileges.php',
        {
            user: document.getElementById('staff_list').options[document.getElementById('staff_list').selectedIndex].value,
            privilege: document.getElementById('privileges').options[document.getElementById('privileges').selectedIndex].value,
            site: '<?php echo $site; ?>',
            program: program_array
        },
        function (response){
            document.getElementById('updated_privilege').innerHTML = 'Thanks!  This user\'s privilege setting has been updated.';
        }
   ).fail(failAlert);">
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
  		  <?php
                  /*List of users at this site.*/
 		   include "../include/dbconnopen.php";
                   $site_id_sqlsafe=mysqli_real_escape_string($cnnLISC, $site);
 		   $staff_list_query_sqlsafe = "SELECT * FROM Users LEFT JOIN Users_Privileges ON 
 		       (Users_Privileges.User_ID=Users.User_ID) WHERE Users_Privileges.Privilege_ID='" . $site_id_sqlsafe . "'";
  		  //echo $staff_list_query_sqlsafe;
 		   $staff_list = mysqli_query($cnnLISC, $staff_list_query_sqlsafe);
 		   while ($staff=mysqli_fetch_array($staff_list)){
   		     echo $staff['User_ID'];
   		     echo $staff['User_Email'];
  		      ?>
 		   <option value="<?php echo $staff['User_ID']?>"><?php echo $staff['User_Email'];?></option>
 		           <?php
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
			document.getElementById('updated_password').innerHTML = 'Thanks!  This user\'s password has been updated.';
        }
    ).fail(failAlert);
    }">
	<div id="updated_password"></div>
	</td>
	</tr>
</table>

<?php
} //end show user administration for a user that has access to just one site or has selected one
?>

<br>
<br>
 

</div>
<?php
include "../footer.php";
?>
