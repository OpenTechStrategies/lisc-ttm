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
  if ($line_array[1]){   //if is hashed (how to check that?)
      //restore from original file
  }
  else{
  //else if is plaintext
      //hash and save each hashed password corresponding to the user ID
      $new_passes[$line_array[0]]=$hasher->HashPassword($line_array[1]);
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
