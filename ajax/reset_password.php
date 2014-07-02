<?php
/*Resetting the password from the Alter Privileges page (e.g. for a user who has forgotten 
 * his/her password)
 */

include "../include/dbconnopen.php";
$pw_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['pw']);
$user_sqlsafe=  mysqli_real_escape_string($cnnLISC, $_POST['user']);
$reset_pw_query = "UPDATE Users SET User_Password='" . $pw_sqlsafe . "' WHERE User_Id='" . $pw_user . "'";
echo $reset_pw_query;
mysqli_query($cnnLISC, $reset_pw_query);
include "../include/dbconnclose.php";

?>
