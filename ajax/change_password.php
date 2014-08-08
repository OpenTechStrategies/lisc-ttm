<?php
require("../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);

include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
if (isset($_POST['current_pw'])){
    $current_pw = $_POST['current_pw'];
}
$username = $_POST['username']; 
$user_query = "SELECT User_ID, User_Password FROM  Users WHERE User_Email = '$username'";
$user = mysqli_query($cnnLISC, $user_query);
$user_row = mysqli_fetch_row($user);
$is_user = mysqli_num_rows($user);
$user_id = $user_row[0];
$found_pw = $user_row[1];
$cur_pw_hashed_match=$hasher->CheckPassword($current_pw, $found_pw);

/*
 * Test to make sure that the username and password match:
 */
if ($is_user > 0 && $cur_pw_hashed_match)
{
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
else
{
        echo "The current password you entered doesn't seem to be correct.  Please try again.";
}
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>
