<?php

require("../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);

$new_password=$_POST['password'];
$hash=$hasher->HashPassword($new_password);

include "../include/dbconnopen.php";
$username_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['username']);
//add staff to login in lisc database as a whole
if (strlen($hash)>=20){
    $lisc_query = "INSERT INTO Users (User_Email, User_Password)
        VALUES ('" . $username_sqlsafe . "', '" . $hash . "')";
    //echo $lisc_query;
    mysqli_query($cnnLISC, $lisc_query);
    $user_id_sqlsafe = mysqli_insert_id($cnnLISC);

    /*
     * Give new user privileges by site.
     */

    $site_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['site']);
    $level_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['level']);
    $program_sqlsafe=  mysqli_real_escape_string($cnnLISC, $_POST['program']);

    $privileges_query_sqlsafe = "INSERT INTO Users_Privileges (User_ID, Privilege_ID, Site_Privilege_ID, Program_Access)
        VALUES ('" . $user_id_sqlsafe . "', '" . $site_sqlsafe . "', '" . $level_sqlsafe . "', '" . $program_sqlsafe . "')";

    mysqli_query($cnnLISC, $privileges_query_sqlsafe);
    include "../include/dbconnclose.php";
}
else
{
   echo 'Unable to store new password&nbsp;&mdash;&nbsp;please '
    . '<a href="/include/contact.php" >report this bug</a>.';
}

?>
<span style="color:#990000; font-weight:bold;">Thank you for adding 
    <?echo $username_sqlsafe;?> to the database.</span>  
