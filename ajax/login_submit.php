<?php
require("../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);
require("session_test.php");
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
if (isset($_POST['username'])){
    $username = $_POST["username"];
    $password_received = $_POST["password"];
}

// Will be set to the password exactly as found in the DB.
// Initialized to "*" because that's PHPass's signal of invalidity.
$password_in_db="*";
$username_sqlsafe=mysqli_real_escape_string($cnnLISC, $username);
$password_sqlsafe=mysqli_real_escape_string($cnnLISC, $password);


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
    
    //set the user cookie
       // FIXME: see issue #33 re the single-quotes around $username here
       setcookie("user", "$username", time() + 10800, '/');
       session_start();
       session_regenerate_id();
       $php_session_sqlsafe = mysqli_real_escape_string($cnnLISC, session_id());
       $expire_time_sqlsafe = date('Y-m-d H:i:s', time() + 7200);
       $save_session_sqlsafe = "INSERT INTO User_Sessions (PHP_Session, User_ID, Expire_Time) VALUES ('" . $php_session_sqlsafe . "', '" . $user_id . "', '" . $expire_time_sqlsafe . "')";
       mysqli_query($cnnLISC, $save_session_sqlsafe);

       //saving permission information in a session, also
       //deprecating the use of the stored routine at @akshay's suggestion

       //this site_access element holds an array of subsites (keys) and user
       //role for each subsite (value)
       $_SESSION['site_access'] = getAllSiteAccess($user_id); 
       $_SESSION['is_logged_in'] = true;

       //now find which, if any, privileges they have and set an appropriate cookie
       $privileges_query = "CALL User__Find_Privileges('$username_sqlsafe')";
       $privileges = mysqli_query($cnnLISC, $privileges_query);
       
       $i=0;
       while ($privilege = mysqli_fetch_array($privileges)){
           if ($privilege['Privilege_Id'] == '1'){
               /*we don't really use this one*/
               setcookie('sites[]', 'all_sites', time() + 10800, '/');
               echo "Congrats!  You have access to all the sites.";
               break;
           }
           else{
               /*set a site cookie for each of the sites this person has access to.*/
               setcookie('sites['.$i.']', $privilege['Privilege_Id'], time() + 10800, '/');
               $get_level_of_access = "SELECT Site_Privilege_ID FROM Users_Privileges WHERE User_ID=$user_id";
               $access_level = mysqli_query($cnnLISC, $get_level_of_access);
               $level = mysqli_fetch_row($access_level);
               if ($level[0] !=1){
                   /*all non-admin users have the view_restricted cookie, which stops them from seeing admin-only
                    * options (e.g. Alter Privileges, delete buttons)
                    */
                   setcookie('view_restricted', $level[0], time()+10800, '/');
                   if ($level[0]==3){
                       /*View-only users have the view_only cookie, which is used to hide
                        * anything that edits or changes information.
                        */
                       setcookie('view_only', $level[0], time()+10800, '/');
                   }
               }
               else{
                   /* If user is an admin, unset the view_only and
                      view_restricted cookies. */
                   setcookie('view_only', $level[0], time()-10800, '/');
                   setcookie('view_restricted', $level[0], time()-10800, '/');
               }
           }
           $i=$i+1;
           
       }
}
else {
    $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT('" . $username_sqlsafe . "', ' - Failed login'))";
    mysqli_query($cnnLISC, $log_call);
    echo '0';
}

include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>
