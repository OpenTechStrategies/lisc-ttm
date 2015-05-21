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
$hasher=new PasswordHash(8, false);

include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
if (isset($_POST['current_pw'])){
    $current_pw = $_POST['current_pw'];
}
$username = $_POST['username']; 
$username_sqlsafe=mysqli_real_escape_string($cnnLISC, $username);
$current_pw_sqlsafe=mysqli_real_escape_string($cnnLISC, $current_pw);
$new_pw_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['new_pw']);
$user_query = "SELECT User_ID, User_Password, Locked FROM  Users WHERE User_Email = '$username_sqlsafe'";
$user = mysqli_query($cnnLISC, $user_query);
$user_row = mysqli_fetch_row($user);
$is_user = mysqli_num_rows($user);
$user_id = $user_row[0];
$found_pw = $user_row[1];
$locked_value = $user_row[2];
include "locked_response.php";
$locked = lock_response($locked_value);

$cur_pw_hashed_match=$hasher->CheckPassword($current_pw, $found_pw);

/*
 * Test to make sure that the username and password match:
 */
if ($is_user > 0 && $cur_pw_hashed_match)
    {
        //if the user is locked, stop here
        if ($locked[0]) {
            echo $locked[1];
        }
        else {
            /*if they match, then reset the password to the new password:
             */
            $new_pw = $_POST['new_pw'];
            $confirm_pw = $_POST['new_pw_2'];
            /*make sure the new and confirmed passwords match:*/
            if ($new_pw == $confirm_pw)
                {
                    $new_hash = $hasher->HashPassword($new_pw);
                    if (strlen($new_hash) >= 20) 
                        {
                            $change_pw_query = "UPDATE Users SET User_Password ='". $new_hash . "' WHERE User_ID = $user_id";
                            mysqli_query($cnnLISC, $change_pw_query);
                            echo "Password updated! <a href='/index.php'>Back to main site</a>";
                        }
                    else
                        {
                            echo 'Unable to store new password&nbsp;&mdash;&nbsp;please <a href="/include/contact.php" >report this bug</a>.';
                        }
                }
            else
                {
                    echo "The new passwords you entered do not match.  Please try again.";
                }
        }
    }
else
    {
        echo "Please enter a valid username and password.";
    }
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>
