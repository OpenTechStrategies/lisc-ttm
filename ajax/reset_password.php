<?php
/*Resetting the password from the Alter Privileges page (e.g. for a user who has forgotten 
 * his/her password)
 */
require("../include/PasswordHash.php");
$hasher=new PasswordHash(8, false);

$new_password=$_POST['pw'];
$username=$_POST['user'];
$hash=$hasher->HashPassword($new_password);
            if (strlen($hash)>=20){
            $change_pw_query = "UPDATE Users SET User_Password ='". $hash . "' WHERE User_ID='" . $_POST['user'] . "'";
            //echo $change_pw_query;
include "../include/dbconnopen.php";
            mysqli_query($cnnLISC, $change_pw_query);
            echo "Password updated! <a href='/index.php'>Back to main site</a>";
            }
include "../include/dbconnclose.php";

?>
