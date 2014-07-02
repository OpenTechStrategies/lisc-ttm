<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
if (isset($_POST['current_pw'])){
    $current_pw = $_POST['current_pw'];
}
$username = $_POST['username']; 
$username_sqlsafe=mysqli_real_escape_string($cnnLISC, $username);
$current_pw_sqlsafe=mysqli_real_escape_string($cnnLISC, $current_pw);
$new_pw_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['new_pw']);
$user_query = "SELECT * FROM  Users WHERE User_Email = '$username_sqlsafe' AND User_Password = '$current_pw_sqlsafe'";
//echo $user_query;
$user = mysqli_query($cnnLISC, $user_query);
//print_r($user);
$is_user = mysqli_num_rows($user);
/*
 * Test to make sure that the username and password match:
 */
if ($is_user>0){
       /*if they match, then reset the password to the new password:
        */
        $new_pw = $_POST['new_pw'];
        $confirm_pw = $_POST['new_pw_2'];
        /*make sure the new and confirmed passwords match:*/
        if ($new_pw == $confirm_pw){
            $change_pw_query = "UPDATE Users SET User_Password ='". $new_pw_sqlsafe . "' WHERE User_Email='$username_sqlsafe'";
            //echo $change_pw_query;
            mysqli_query($cnnLISC, $change_pw_query);
            echo "Password updated! <a href='/index.php'>Back to main site</a>";
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
