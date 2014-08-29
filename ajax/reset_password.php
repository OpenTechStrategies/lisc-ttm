<?php
require("../include/phpass-0.3/PasswordHash.php");
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
