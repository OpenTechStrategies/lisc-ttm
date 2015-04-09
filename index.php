<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

//if action is logout
if ($_GET['action'] == 'logout') {
    $loggingout = pleaseLogOut();
    if ($loggingout){
        //redirect
        header('Location: /index.php');
    }
    else{
        echo "An error occurred.  Please try again.  If this problem persists, contact your system administrator.";
        } 
}
?>
<!DOCTYPE html>
<html>
<?php
include "header.php";

if (! isLoggedIn()) {
        //if no one is logged in, then send the user to the login page.  This also happens 
        //when the user cookie expires.

        include "login_page.php";


  } else {
        /*
         * If someone is logged in:
         */
        ?>
        <div class="navigation">
            <a href="#"><span>Homepage</span></a><!--</li>-->
            <?php if (!in_array($AdminAccess, $USER->site_permissions)) {

                /* Only admin users can alter privileges, so this will only be visible
                 * for them.
                 */
                ?>
                <a href="/include/add_staff.php"><span>Alter Privileges</span></a>
                <?php
            }
            ?>
            <a href="/index.php?action=logout">Log Out</a>
        </div>

        <?php
        echo "Thank you for logging in.<br>";
        include "include/dbconnopen.php";
        if ($USER->has_site_access($Bickerdike_id)) {
            ?>
            You have access to the <a href="/bickerdike/">Bickerdike</a> site information. <br>
            <?php
        }
        if ($USER->has_site_access($LSNA_id)) {
            ?>
            You have access to the <a href="/lsna/">LSNA</a> site information. <br>
            <?php
        }
        if ($USER->has_site_access($TRP_id)) {
            ?>
            You have access to <a href="/trp/">The Resurrection Project</a> site information. <br/>
            <?php
        }
        if ($USER->has_site_access($SWOP_id)) {
            ?>
            You have access to the <a href="/swop/">Southwest Organizing Project</a> site information. <br/>
            <?php
        }
        if ($USER->has_site_access($Enlace_id)) {
            ?>
            You have access to the <a href="/enlace/">Enlace</a> site information. <br/>
            <?php
        }
        ?>
        <?php
        include "include/dbconnclose.php";
    }
    ?>
    <div id="site_notification"></div>
    <!--<a href="/index.php?action=logout">Logout</a>-->
<?php include "footer.php"; ?>
</html>