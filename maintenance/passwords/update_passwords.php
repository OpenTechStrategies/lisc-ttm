<?php

/* Script to update users' passwords in the TTM database.  Usage:
 * 
 *   $ php update_passwords.php ACTION < USERMAP_FILE > OUTPUT_SQL_FILE
 * 
 * The input is lines (taken from stdin) that map usernames to
 * plaintext passwords; the output (on stdout) is SQL that can
 * be loaded to update those users' passwords in the database.
 *
 * ACTION is one word: "hash" or "nohash".  If "hash", the plaintext
 * passwords from the input will be hashed in the output; if "nohash",
 * the passwords will be passed through without hashing.  If ACTION is
 * any other word, the script will exit with error.
 *
 * The format of the input (USERMAP_FILE in the example usage above)
 * is lines that map usernames to plaintext passwords, with pipe ("|")
 * as the separator.  For example:
 * 
 *   jrandom|mysupersecretpassword
 *   brobbin|pephKq8ou6TalhT8te
 * 
 * Afterwards, OUTPUT_SQL_FILE would contain SQL you could load to
 * effect the changes.  (Neither the input nor the output has to be in
 * file form, of course; that's just how we usually expect this script
 * to be run.)
 *
 * This script must be run from this directory, because it looks in a
 * relative parent directory for an included library.
 *
 * This script was originally written to enable a transition from
 * plaintext passwords being stored in the database to hashed
 * passwords, but it is genericized so that it can be used to simply
 * store a given string as a user's password in the database (e.g., if
 * you have a hashed password, you can provide it as "plaintext" in
 * the input and tell the script not to hash -- in which case the
 * script just provides a convenient way to get the needed SQL).
 */

require("../../include/phpass-0.3/PasswordHash.php");
$hasher=new PasswordHash(8, false);

if ($argc != 2) {
  die("ERROR: Wrong number of arguments.\n");
}

// Global variable: TRUE if we're hashing, FALSE if we're not.
$Hashing;
if ($argv[1] == 'hash') {  
  $Hashing = TRUE;
}
else if ($argv[1]=='nohash') {
  $Hashing = FALSE;
}
else {
  die("ERROR: Unrecognized action: '" . $argv[1] . "'\n");
}

fwrite(STDOUT, "/* Load the SQL to save the new passwords in the Users table:
 *
 *   mysql> use ttm-core;
 *   Database changed
 *   mysql> source 'OUTPUT_SQL_FILE';
 */
");

// Loop through input lines, extracting passwords.
while (($this_line = fgets(STDIN)) != FALSE)
{
  // If this is a blank line, then just continue on to the next line.  
  // We don't set $this_line itself to the result of the trim(), because
  // we're just testing to see if this is a blank line -- if it's not,
  // we must preserve any whitespace on (say) the end of the password. 
  if (trim($this_line) == '') {
    continue;
  }

  // Separate username from plaintext password.
  $line_array=explode('|', $this_line);

  // If there wasn't even a pipe separator, something's wrong.
  if (! $line_array[1]) {
    die("ERROR: bad line: '" . $this_line. "'\n");
  }

  // Trim the spurious trailing newline from the plaintext password.
  $line_array[1] = rtrim($line_array[1], "\n");

  // Output the SQL.
  fwrite(STDOUT, "UPDATE ttm-core.Users SET User_Password='");
  if ($Hashing == TRUE) {  
    fwrite(STDOUT, $hasher->HashPassword($line_array[1]));
  }
  else {
    fwrite(STDOUT, $line_array[1]);
  }
  fwrite(STDOUT, "' WHERE User_ID='$line_array[0]';\n");
}

?>
