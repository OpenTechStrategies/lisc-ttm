<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/core/include/enforce_admin_of_something.php";

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
    mysqli_query($cnnLISC, $lisc_query);
    $user_id_sqlsafe = mysqli_insert_id($cnnLISC);

    /*
     * Give new user privileges by site.
     */

    $site_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['site']);
    $level_sqlsafe=mysqli_real_escape_string($cnnLISC, $_POST['level']);
    $program_sqlsafe=  mysqli_real_escape_string($cnnLISC, $_POST['program']);
    $privileges_query_sqlsafe = "INSERT INTO Users_Privileges (User_ID, Privilege_ID, Site_Privilege_ID) VALUES ('" . $user_id_sqlsafe . "', '" . $site_sqlsafe . "', '" . $level_sqlsafe . "')";
    mysqli_query($cnnLISC, $privileges_query_sqlsafe);
    $user_privileges_id_sqlsafe = mysqli_insert_id($cnnLISC);
    if ($program_sqlsafe == "n" || $program_sqlsafe == ""){
        //do nothing
    }
    elseif ($program_sqlsafe == "a"){
        $program_array = findAllPrograms($site_sqlsafe);
        $program_access_query_sqlsafe = "INSERT INTO Users_Program_Access
            (Users_Privileges_ID, Program_Access) VALUES";
        $counter = 0;
        foreach ($program_array as $program){
            if ($counter == (count($program_array) - 1)) {
                $program_access_query_sqlsafe .= "('" . $user_privileges_id_sqlsafe . "', '" . $program . "');";
            }
            else{
                $program_access_query_sqlsafe .= "('" . $user_privileges_id_sqlsafe . "', '" . $program . "'), ";
            }
            $counter ++;
        }
        mysqli_query($cnnLISC, $program_access_query_sqlsafe);
    }
    else{
        $program_access_query_sqlsafe = "INSERT INTO Users_Program_Access (Users_Privileges_ID, Program_Access) VALUES ('" . $user_privileges_id_sqlsafe . "', '" . $program_sqlsafe . "')";
        mysqli_query($cnnLISC, $program_access_query_sqlsafe);
    }
    include "../include/dbconnclose.php";
}
else
{
   echo 'Unable to store new password&nbsp;&mdash;&nbsp;please '
    . '<a href="/include/contact.php" >report this bug</a>.';
}

?>
<span style="color:#990000; font-weight:bold;">Thank you for adding 
    <?php echo $username_sqlsafe;?> to the database.</span>  
