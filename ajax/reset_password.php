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
require("../include/phpass-0.3/PasswordHash.php");
include_once $_SERVER['DOCUMENT_ROOT'] . "/core/include/enforce_admin_of_something.php";

$hasher=new PasswordHash(8, false);
/*Resetting the password from the Alter Privileges page (e.g. for a user who has forgotten 
 * his/her password)
 */

include "../include/dbconnopen.php";
$new_password=$_POST['pw'];
$username_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['user']);
$hash=$hasher->HashPassword($new_password);
            if (strlen($hash)>=20){
                $change_pw_query = "UPDATE Users SET User_Password ='". $hash 
                        . "' WHERE User_ID='" . $username_sqlsafe . "'";
                mysqli_query($cnnLISC, $change_pw_query);
                include "../include/dbconnclose.php";
            }
            else
            {
               echo 'Unable to store new password&nbsp;&mdash;&nbsp;please '
                . '<a href="/include/contact.php" >report this bug</a>.';
            }

?>
