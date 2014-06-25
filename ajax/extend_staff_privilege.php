<?php
require("../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);

$new_password=$_POST['password'];
$hash=$hasher->HashPassword($new_password);
//add staff to login in lisc database as a whole
            if (strlen($hash)>=20){
                $lisc_query = "INSERT INTO Users (User_Email, User_Password)
                    VALUES ('" . $_POST['username'] . "', '" . $hash . "')";
                include "../include/dbconnopen.php";
                mysqli_query($cnnLISC, $lisc_query);
                $user_id = mysqli_insert_id($cnnLISC);
                include "../include/dbconnopen.php";
            }
            else{
                'Something went wrong';
            }
/*
 * Give new user privileges by site.
 */
$privileges_query = "INSERT INTO Users_Privileges (User_ID, Privilege_ID, Site_Privilege_ID, Program_Access)
    VALUES ('" . $user_id . "', '" . $_POST['site'] . "', '" . $_POST['level'] . "', '" . $_POST['program'] . "')";
//echo $privileges_query;
include "../include/dbconnopen.php";
mysqli_query($cnnLISC, $privileges_query);
include "../include/dbconnopen.php";



?>
<span style="color:#990000; font-weight:bold;">Thank you for adding  <?echo $_POST['username'];?> to the database.</span>  