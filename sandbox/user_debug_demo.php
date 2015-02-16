<?php
/* shows associated institutions and events; provides space to add a new event: */
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
?>

<?php

// Set up some utilities for ourself for this demo...

function bullet_print_r($topic, $data) {
    echo("<li>");
    echo("<b>" . $topic . ":</b> ");
    print_r($data);
    echo("</li>");
}

function print_site_access($site_id, $site_name, $this_user = NULL) {
    if (is_null($this_user)) {
        global $USER;
        $this_user = $USER;
    }
    
    global $AdminAccess;
    global $DataEntryAccess;
    global $ReadOnlyAccess;

    if ($this_user->has_site_access($site_id)) {
        $access_level = $this_user->site_access_level($site_id);
        if ($access_level == $AdminAccess) {
            $printed_access_level = "admin";
        } else if ($access_level == $DataEntryAccess) {
            $printed_access_level = "data entry";
        } else if ($access_level == $ReadOnlyAccess) {
            $printed_access_level = "read only";
        } else {
            $printed_access_level = "mysterious database error";
        }

        bullet_print_r($site_name, "User has access! At the $printed_access_level level!");
    } else {
        bullet_print_r($site_name, "User does <i>NOT HAVE</i> access!");
    }
}

$fake_die_unauthorized = function($message = "") {
    echo("<b><i>*SIREN NOISE! SIREN NOISE!*</i></b> Failed check, imagine we blew up with the message: $message <br />");
};

?>


<html>
  <head>
    <title>
      User test page
    </title>
  </head>

  <body>

    
    <?php

    if (isLoggedIn()) {
        echo("<h1>Welcome to the user test page, " . $USER->username . "!</h1>");

        echo("<p>Here are some things we know about you:</p>");
        echo("<p><ul>");
        bullet_print_r("id", $USER->id);
        bullet_print_r("username", $USER->username);
        bullet_print_r("site permissions", $USER->site_permissions);
        print_site_access($LSNA_id, "LSNA");
        print_site_access($Bickerdike_id, "Bickerdike");
        print_site_access($TRP_id, "TRP");
        print_site_access($SWOP_id, "SWOP");
        print_site_access($Enlace_id, "Enlace");
        echo("</p></ul>");

        echo("<p>So, let's try to make it in to some places... do we trip any alarms?</p>");
        echo("<p>");
        echo("Plain LSNA<br/>");
        user_enforce_has_access($LSNA_id, NULL, NULL, $fake_die_unauthorized);
        echo("Plain Bickerdike<br/>");
        user_enforce_has_access($Bickerdike_id, NULL, NULL, $fake_die_unauthorized);
        echo("Plain TRP<br/>");
        user_enforce_has_access($TRP_id, NULL, NULL, $fake_die_unauthorized);
        echo("Plain SWOP<br/>");
        user_enforce_has_access($SWOP_id, NULL, NULL, $fake_die_unauthorized);
        echo("Plain Enlace<br/>");
        user_enforce_has_access($Enlace_id, NULL, NULL, $fake_die_unauthorized);
        echo("</p>");
        echo("<p>Past the basic checks, now let's try some subsites and stuff...</p>");
        echo("TRP w/ access level 1 and program access 'b'<br/>");
        user_enforce_has_access($TRP_id, 1, "b", $fake_die_unauthorized);
        echo("SWOP w/ access level 2 and program access 'g'<br/>");
        user_enforce_has_access($SWOP_id, 2, "g", $fake_die_unauthorized);
        echo("Enlace w/ access level 3 and no program access check<br/>");
        user_enforce_has_access($Enlace_id, 3, NULL, $fake_die_unauthorized);
        echo("Enlace w/ no access level check an program access 'b'<br/>");
        user_enforce_has_access($Enlace_id, NULL, "b", $fake_die_unauthorized);
        echo("<p>Okay, that's enough :)</p>");

    } else {
        echo("<p>Without being logged in, we can't show much about yourself!</p>");
    }
    ?>

    <h2>The mystique of other users' permissions</h2>

    <p>Okay, how about showing some stuff about someone else?  How
      about this user here...</p>

    <?php

    $test_subject = new User(30);

    echo("<p>Here are some things we know about you:</p>");
    echo("<p><ul>");
    bullet_print_r("id", $test_subject->id);
    bullet_print_r("site permissions", $test_subject->site_permissions);
    print_site_access($LSNA_id, "LSNA", $test_subject);
    print_site_access($Bickerdike_id, "Bickerdike", $test_subject);
    print_site_access($TRP_id, "TRP", $test_subject);
    print_site_access($SWOP_id, "SWOP", $test_subject);
    print_site_access($Enlace_id, "Enlace", $test_subject);
    echo("</p></ul>");


    echo("<p>So, let's try to make it in to some places... do we trip any alarms?</p>");
    echo("<p>");
    echo("Plain LSNA<br/>");
    $test_subject->enforce_has_access($LSNA_id, NULL, NULL, $fake_die_unauthorized);
    echo("Plain Bickerdike<br/>");
    $test_subject->enforce_has_access($Bickerdike_id, NULL, NULL, $fake_die_unauthorized);
    echo("Plain TRP<br/>");
    $test_subject->enforce_has_access($TRP_id, NULL, NULL, $fake_die_unauthorized);
    echo("Plain SWOP<br/>");
    $test_subject->enforce_has_access($SWOP_id, NULL, NULL, $fake_die_unauthorized);
    echo("Plain Enlace<br/>");
    $test_subject->enforce_has_access($Enlace_id, NULL, NULL, $fake_die_unauthorized);
    echo("</p>");
    echo("<p>Past the basic checks, now let's try some subsites and stuff...</p>");
    echo("TRP w/ access level 1 and program access 'b'<br/>");
    $test_subject->enforce_has_access($TRP_id, 1, "b", $fake_die_unauthorized);
    echo("SWOP w/ access level 2 and program access 'g'<br/>");
    $test_subject->enforce_has_access($SWOP_id, 2, "g", $fake_die_unauthorized);
    echo("Enlace w/ access level 3 and no program access check<br/>");
    $test_subject->enforce_has_access($Enlace_id, 3, NULL, $fake_die_unauthorized);
    echo("Enlace w/ no access level check an program access 'b'<br/>");
    $test_subject->enforce_has_access($Enlace_id, NULL, "b", $fake_die_unauthorized);
    echo("<p>Okay, that's enough :)</p>");
    ?>
    
  </body>
</html>
<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>
