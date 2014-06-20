<?php
require("../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);

include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
if (isset($_POST['password'])){
    $current_pw = $_POST['password'];
}
$username = $_POST['username']; 
$user_query = "SELECT User_Password, User_ID FROM  Users WHERE User_Email = '$username'";
//echo $user_query;
$stored_hash="*";
$user = mysqli_query($cnnLISC, $user_query);
$user_hash = mysqli_fetch_row($user);
$stored_hash=$user_hash[0];
$user_id=$user_hash[1];
$check=$hasher->CheckPassword($current_pw, $stored_hash);


//if the password is correct:
if ($check || $stored_hash==$current_pw){
   // echo 'check matched';
    //record this login in the Log
    $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT(" . $username . ", ' - Logged In'))";
    
    mysqli_query($cnnLISC, $log_call);
    
    //set the user cookie
       setcookie("user", $username, time() + 10800, '/');
      
       //now find which, if any, privileges they have and set an appropriate cookie
       $privileges_query = "CALL User__Find_Privileges('$username')";
       echo $privileges_query;
       include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
       $privileges = mysqli_query($cnnLISC, $privileges_query);
       echo "privileges: ";
       print_r($privileges);
       $i=0;
       while ($privilege = mysqli_fetch_array($privileges)){
           if ($privilege['Privilege_Id'] == '1'){
               /*we don't really use this one*/
               setcookie('sites[]', 'all_sites', time() + 10800, '/');
               echo "Congrats!  You have access to all the sites.";
               break;
           }
           else{
               /*set a site cookie for each of the sites this person has access to.*/
               setcookie('sites['.$i.']', $privilege['Privilege_Id'], time() + 10800, '/');
               $get_level_of_access = "SELECT Site_Privilege_ID FROM Users_Privileges WHERE User_ID=$user_id";
               //echo $get_level_of_access;
              include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
               $access_level = mysqli_query($cnnLISC, $get_level_of_access);
               $level = mysqli_fetch_row($access_level);
               if ($level[0] !=1){
                   /*all non-admin users have the view_restricted cookie, which stops them from seeing admin-only
                    * options (e.g. Alter Privileges, delete buttons)
                    */
                   setcookie('view_restricted', $level[0], time()+10800, '/');
                   if ($level[0]==3){
                       /*View-only users have the view_only cookie, which is used to hide
                        * anything that edits or changes information.
                        */
                       setcookie('view_only', $level[0], time()+10800, '/');
                   }
               }
               else{
                   /* if user is an admin, unset the view_only and view_restricted cookes */
                   setcookie('view_only', $level[0], time()-10800, '/');
                   setcookie('view_restricted', $level[0], time()-10800, '/');
               }
           }
           //echo $i . "<br>";
           $i=$i+1;
           
       }
}
else{
    
            //the plaintext password did not match the saved password either
        $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT(" . $username . ", ' - Invalid Login'))";
        mysqli_query($cnnLISC, $log_call);

        echo '0';
}


include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>
