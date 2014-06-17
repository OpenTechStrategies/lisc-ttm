<?php

/*To run this file:
 * In command line:
 * $ php /path/to/this/file.php <name of file with plaintext passwords> <action to take>
 * 
 * $argv[0] is the name of this file.
 * $argv[1] is the file to read plaintext passwords from
 * $argv[2] is whether to hash passwords or not
 * if $argv[2]=='hash' then the passwords are being passed in plaintext and should
 * be hashed and saved
 * if $argv[2] is anything else or is missing then the passwords are already hashed and should be 
 * saved as they are.
 * 
 * This script will create (and/or fill) a file called "user_load.sql" in the directory where you
 * ran the script.  If you would like to change the destination, changed the file named in 
 * the fopen on line __.
*/

require("include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);


//passed file should include separated values with user id and user password
$link=$argv[1]; // the name of the file with the user IDs and passwords, separated by commas


$link_final=trim($link);
$file = fopen($link_final,"r");

//create array to put hashed (or plaintext) passwords into
$new_passes=array();

//loop through lines of file, extracting passwords
while(! feof($file))
  {
  $this_line=fgets($file);
  $line_array=explode(',', $this_line);//separates the line into an array
  $line_array[1]=trim($line_array[1]);
  $line_array[1]=str_replace('"', '', $line_array[1]);
  //here we don't know if we read a hashed password or a plaintext password.
  //if the passed argument says 'hash' then we hash and save
  if ($argv[2]=='hash'){  
      //it is plaintext
      //hash and save each hashed password corresponding to the user ID
      $hashpass=$hasher->HashPassword($line_array[1]);
      $new_passes[$line_array[0]]=$hashpass;
  }
  //else, save the password as read
  else{
     $new_passes[$line_array[0]]=$line_array[1];
  }
  }
fclose($file);

//now create the file to load new passwords into DB
$load_file=fopen('ajax/user_load.sql', 'w');
//empties the table and starts the insert statement to refill it
/*add instructions in a comment at the beginning of this file.*/
$insert_values="
    /* To load this sql file and save all user passwords as hashes...(instructions) */
    TRUNCATE ttm-core.Users;  
    INSERT INTO ttm-core.Users (User_ID, User_Password) VALUES "; 
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
