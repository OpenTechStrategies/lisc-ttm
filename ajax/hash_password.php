<?php
require("../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);

$get_plaintext_passes="SELECT User_ID, User_Password FROM Users";
include "../include/dbconnopen.php";
$plaintext_passes=mysqli_query($cnnLISC, $get_plaintext_passes);
while ($plainpass=mysqli_fetch_row($plaintext_passes)){
    $hashpass=$hasher->HashPassword($plainpass[1]);
    $save_hashed="UPDATE Users SET User_Password=$hashpass WHERE User_ID=$plainpass[0]";
    mysqli_query($cnnLISC, $save_hashed);
}

include "../include/dbconnclose.php";

?>
