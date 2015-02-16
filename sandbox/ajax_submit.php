<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
if ($_POST['passable'] == "yes") {
    // an actually reasonable passable check
    user_enforce_has_access($TRP_id);
} else {
    // Require at least a "0" level permission, which is beyond
    // the admin requirement, thus impossible... this will fail!
    user_enforce_has_access($TRP_id, 0);
}
include "../include/dbconnclose.php";
?>
