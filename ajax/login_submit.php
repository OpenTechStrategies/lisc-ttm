<?php
require("../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);
include_once $_SERVER['DOCUMENT_ROOT'] . "/core/tools/auth.php";
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
if (isset($_POST['username'])){
    $username = $_POST["username"];
    $password_received = $_POST["password"];
}

// Will be set to the password exactly as found in the DB.
// Initialized to "*" because that's PHPass's signal of invalidity.
$password_in_db="*";
$username_sqlsafe=mysqli_real_escape_string($cnnLISC, $username);

$user_query = "SELECT User_ID, User_Password FROM Users WHERE User_Email = '$username_sqlsafe'";
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
    echo '0'; // signal to caller that something here failed
    return 0;
}

$user_row = mysqli_fetch_row($query_result);
$user_id=$user_row[0];
$password_in_db=$user_row[1];
$hash_match = $hasher->CheckPassword($password_received, $password_in_db);

if ($hash_match) {
    //record this login in the Log
    $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT('" . $username_sqlsafe . "', ' - Logged In'))";
    
    mysqli_query($cnnLISC, $log_call);
    
       session_start();
       session_regenerate_id();

       $_SESSION['user_id'] = $user_id;
}
else {
    $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT('" . $username_sqlsafe . "', ' - Failed login'))";
    mysqli_query($cnnLISC, $log_call);
    echo '0';
}

include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>
