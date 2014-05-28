<?php
/*Resetting the password from the Alter Privileges page (e.g. for a user who has forgotten 
 * his/her password)
 */
$reset_pw_query = "UPDATE Users SET User_Password='" . $_POST['pw'] . "' WHERE User_Id='" . $_POST['user'] . "'";
echo $reset_pw_query;
include "../include/dbconnopen.php";
mysqli_query($cnnLISC, $reset_pw_query);
include "../include/dbconnclose.php";

?>
