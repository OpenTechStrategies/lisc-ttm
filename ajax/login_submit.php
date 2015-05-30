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
ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/core/tools/auth.php";
ob_end_clean();
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
if (isset($_POST['username'])){
    $username = $_POST["username"];
    $password_received = $_POST["password"];
}

// Will be set to the password exactly as found in the DB.
// Initialized to "*" because that's PHPass's signal of invalidity.
$password_in_db="*";
$username_sqlsafe=mysqli_real_escape_string($cnnLISC, $username);

$user_query = "SELECT User_ID, User_Password, Locked FROM Users WHERE User_Email = '$username_sqlsafe'";
$query_result = mysqli_query($cnnLISC, $user_query);

// Will be > 0 iff $username is in the database.
//
// However, if > 1, then this is an instance of issue #15.  For now,
// we'll tolerate it, but in the long run there shouldn't be any
// duplicate usernames, and resolving issue #15 means raising an
// error here if the number of rows in the result != 1.
$user_exists = mysqli_num_rows($query_result);
if (! $user_exists) {
    $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT('" . $username . "', ' - Unknown username'))";
    mysqli_query($cnnLISC, $log_call);
    echo 'Please enter a valid username and password.'; // signal to caller that something here failed
}
else {
    $user_row = mysqli_fetch_row($query_result);
    $user_id=$user_row[0];
    $password_in_db=$user_row[1];
    $locked_value = $user_row[2];
    $hash_match = $hasher->CheckPassword($password_received, $password_in_db);
    include "locked_response.php";
    $locked = lock_response($locked_value);

    if ($hash_match) {
        if ($locked[0]) {
            $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT('" . $username_sqlsafe . "', ' - Locked user login attempt'))";
            mysqli_query($cnnLISC, $log_call);
            // They gave the correct password, so we inform them that they've been locked out.
            echo $locked[1];
        }
        else {
            //record this login in the Log
            $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT('" . $username_sqlsafe . "', ' - Logged In'))";
    
            mysqli_query($cnnLISC, $log_call);
    
            session_start();
            session_regenerate_id();

            $_SESSION['user_id'] = $user_id;
            echo "0"; //signal to caller that log in was successful
        }
    }
    else {
        $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT('" . $username_sqlsafe . "', ' - Failed login'))";
        mysqli_query($cnnLISC, $log_call);
        echo 'Please enter a valid username and password.';
    }
}
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>
