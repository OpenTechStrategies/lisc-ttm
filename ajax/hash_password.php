<?php
require("/include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);

//file should include separated values with user id and user password
$link="C:/Users/cdonnelly/Documents/GitHub/lisc-ttm/ajax/test.txt";
$link_final=trim($link);
$file = fopen($link_final,"r");

//create array to put hashed (or plaintext) passwords into
$new_passes=array();

//loop through lines of file, extracting passwords
while(! feof($file))
  {
  $this_line=fgets($file);
  $line_array=explode(',', $this_line);
  print_r($line_array); //testing only
  $hashpass=$hasher->HashPassword($line_array[1]);
  //get the stored hash - do we need to read from another file that is a current
  //export from the db?
  /* get $storedhash here */
  
  //here we don't know if we read a hashed password or a plaintext password.
  //if the read password (line_array[1]) matches the stored password through
  //CheckPassword, then the read password is plaintext.
  if (($hasher->CheckPassword($line_array[1], $stored_hash))==1){  
      //it is the correct plaintext
      //hash and save each hashed password corresponding to the user ID
      $new_passes[$line_array[0]]=$hashpass;
  }
  //if the read password does NOT match the stored (hashed) password through CheckPassword,
  //then the read password is itself already a hash (or is wrong, but we assume the passwords read
  //into this script are correct)
  else{
     //restore from original file
  }
fclose($file);

//now create the file to load new passwords into DB
$load_file=fopen('ajax/user_load.sql', 'w');
//empties the table and starts the insert statement to refill it
$insert_values="TRUNCATE ttm-core.Users;  INSERT INTO ttm-core.Users VALUES "; 
$counter=0;
foreach ($new_passes as $id=>$password){
    $insert_values.="('$id', '$password')";
    $counter++;
    //add comma if not last pair
    if ($counter<count($new_passes)){
        $insert_values .=", ";
    }
    //if last pair add a semicolon
    else{
        $insert_values.=";";
    }
}

fwrite($load_file, $insert_values);
fclose($load_file);

?>
