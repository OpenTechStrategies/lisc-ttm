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

include_once $_SERVER['DOCUMENT_ROOT'] . "/core/include/enforce_admin_of_something.php";

require("../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);

$new_password=$_POST['password'];
$hash=$hasher->HashPassword($new_password);

include "../include/dbconnopen.php";

$username_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['username']);
//add staff to login in lisc database as a whole
if (strlen($hash)>=20){
    $lisc_query = "INSERT INTO Users (User_Email, User_Password)
        VALUES ('" . $username_sqlsafe . "', '" . $hash . "')";
    mysqli_query($cnnLISC, $lisc_query);
    $user_id_sqlsafe = mysqli_insert_id($cnnLISC);

    /*
     * Give new user privileges by site.
     */
    $site_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['site']);
    $level_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['level']);
    $privileges_query_sqlsafe = "INSERT INTO Users_Privileges (User_ID, Privilege_ID, Site_Privilege_ID) VALUES ('" . $user_id_sqlsafe . "', '" . $site_sqlsafe . "', '" . $level_sqlsafe . "')";
    mysqli_query($cnnLISC, $privileges_query_sqlsafe);
    $user_privileges_id_sqlsafe = mysqli_insert_id($cnnLISC);
    $program_access_query_sqlsafe = createProgramQuery($_POST['program'], $user_privileges_id_sqlsafe);
    mysqli_query($cnnLISC, $program_access_query_sqlsafe);

    include "../include/dbconnclose.php";
}
else
{
   echo 'Unable to store new password&nbsp;&mdash;&nbsp;please '
    . '<a href="/include/contact.php" >report this bug</a>.';
}

?>
<span style="color:#990000; font-weight:bold;">Thank you for adding 
    <?php echo $username_sqlsafe;?> to the database.</span>  
