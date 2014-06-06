<?php
include "../header.php";

?><html>
<body>
<h2>Contact Us</h2>

<span class="helptext">Fill out this form:</span>


<?php
//this code is drawn from the example at: http://www.w3schools.com/php/php_secure_mail.asp

function spamcheck($field) {
  // Sanitize e-mail address
  $field=filter_var($field, FILTER_SANITIZE_EMAIL);
  // Validate e-mail address
  if(filter_var($field, FILTER_VALIDATE_EMAIL)) {
    return TRUE;
  } else {
    return FALSE;
  }
}
?>

<?php
// display form if user has not clicked submit
if (!isset($_POST["submit"])) {
  ?>
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
 <table class="all_projects">
     <tr><th class="contact">Full Name:</th><td class="contact"> <input type="text" name="subject"></td></tr>
  <tr><th class="contact">Email:</th><td class="contact">  <input type="text" name="email"></td></tr>
  <tr><th class="contact">Message: </th><td class="contact"> <textarea rows="10" cols="40" name="message"></textarea></td></tr>
  <tr><th class="contact" colspan="2"><input type="submit" name="submit" value="Send Message"></th></tr>
 </table>
  </form>
  <?php 
} else {  // the user has submitted the form
  // Check if the "from" input field is filled out
  if (isset($_POST["email"])) {
    // Check if "from" email address is valid
    $mailcheck = spamcheck($_POST["email"]);
    if ($mailcheck==FALSE) {
      echo "Invalid input.  Please enter a valid email address.";
    } else {
      $from = $_POST["email"]; // sender
      $subject = "LISC TTM Help message submitted by: " .$_POST["subject"];
      $message = $_POST["message"];
      // message lines should not exceed 70 characters (PHP rule), so wrap it
      $message = wordwrap($message, 70);
      // send mail
      mail("ttmhelp@opentechstrategies.com",$subject,$message,"From: $from\n");
      echo "Thank you for your message.  Someone will respond to you as soon as possible.";
    }
  }
}
?>
</body>
</html>

<p></p>
<p>Or, email us directly at ttmhelp@opentechstrategies.com.</p>
<!--Alternatively: 
<p>Or, email us directly at ttmhelp[at]opentechstrategies[dot]com. <span class="helptext">(replacing [at] with @ and [dot] with . where appropriate)</span></p>-->
<!--When the git repository is open, add a line here about submitting issues on GitHub. -->
    
    <?php

include "../footer.php";
?>