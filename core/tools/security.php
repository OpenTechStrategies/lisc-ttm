<?php
/*
 * This function will take any untrusted input (probably from a user)
 * and output it in a safe way to prevent XSS attacks.
 */
function safe_echo($input) {
    echo(htmlspecialchars($input));
}

?>
