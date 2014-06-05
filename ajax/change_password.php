<?php
require("../include/PasswordHash.php");
$hasher=new PasswordHash(8, false);

include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
if (isset($_POST['current_pw'])){
    $current_pw = $_POST['current_pw'];
}
$username = $_POST['username']; 
$user_query = "SELECT User_Password, User_ID FROM  Users WHERE User_Email = '$username'";

$stored_hash="*";
$user = mysqli_query($cnnLISC, $user_query);
$user_hash = mysqli_fetch_row($user);
$stored_hash=$user_hash[0];

$check=$hasher->CheckPassword($current_pw, $stored_hash);

/*
 * Test to make sure that the username and password match:
 */
if ($check){
       /*if they match, then reset the password to the new password:
        */
        $new_pw = $_POST['new_pw'];
        $confirm_pw = $_POST['new_pw_2'];
        /*make sure the new and confirmed passwords match:*/
        if ($new_pw == $confirm_pw){
            $hash=$hasher->HashPassword($new_pw);
            if (strlen($hash)>=20){
            $change_pw_query = "UPDATE Users SET User_Password ='". $hash . "' WHERE User_ID=$user_hash[1]";
            //echo $change_pw_query;
            mysqli_query($cnnLISC, $change_pw_query);
            echo "Password updated! <a href='/index.php'>Back to main site</a>";
            }
            else{echo "Something went wrong.";}
        }
        else{
            echo "The new passwords you entered do not match.  Please try again.";
        }
}
else{
    echo "The current password you entered doesn't seem to be correct.  Please try again.";
}

include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>
