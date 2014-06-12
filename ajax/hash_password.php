<?php
require("../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);


/*$get_plaintext_passes="SELECT User_ID, User_Password FROM Users";
include "../include/dbconnopen.php";
$plaintext_passes=mysqli_query($cnnLISC, $get_plaintext_passes);
while ($plainpass=mysqli_fetch_row($plaintext_passes)){
    $hashpass=$hasher->HashPassword($plainpass[1]);
    $save_hashed="UPDATE Users SET User_Password='$hashpass' WHERE User_ID='$plainpass[0]'";
    mysqli_query($cnnLISC, $save_hashed);
}
*/

/*
include "../include/dbconnclose.php";*/

/*hash a sample password*/
$hashpass=$hasher->HashPassword('password');
echo $hashpass . "\n";

/*check to see if hash matches the plaintext*/
$check=$hasher->CheckPassword('password', $hashpass);
echo $check . "\n";


/*now that we've established that works, do this for an array of passwords*/

$password_array=array('password', 'test', '123456', 'c0mb0numl3t');
foreach ($password_array as $pass){
    $hashpass_array[]=$hasher->HashPassword($pass);
}
print_r($hashpass_array);

$n=0;

while($n<count($password_array)){
    $check_array[]=$hasher->CheckPassword($password_array[$n], $hashpass_array[$n]);
    $n++;
}
print_r($check_array);

?>
