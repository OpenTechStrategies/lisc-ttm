<?php
//if action is logout
if ($_GET['action'] == 'logout') {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/core/tools/auth.php";
    $loggingout = pleaseLogOut($_COOKIE['PHPSESSID']);
    if ($loggingout){
        //kill cookie
        setcookie('PHPSESSID', '', time() - 3600, '/');
        setcookie('user', '', time() - 3600, '/');
        setcookie('page', '', time() - 3600, '/');
        setcookie('participant', '', time() - 3600, '/');
        setcookie('sites[0]', '', time() - 3600, '/');
        setcookie('sites[1]', '', time() - 3600, '/');
        setcookie('sites[2]', '', time() - 3600, '/');
        setcookie('sites[3]', '', time() - 3600, '/');
        setcookie('sites[4]', '', time() - 3600, '/');
        setcookie('sites[5]', '', time() - 3600, '/');
        setcookie('sites[6]', '', time() - 3600, '/');
        setcookie('sites[7]', '', time() - 3600, '/');
        setcookie('view_restricted', '', time() - 3600, '/');
        setcookie('view_only', '', time() - 3600, '/');
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
include "core/include/setup_user.php";

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
            <!--                <ul class="navigation">-->
            <!--<li class="navigation">-->
            <a href="#"><span>Homepage</span></a><!--</li>-->
            <?php if (!isset($_COOKIE['view_restricted'])) {
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
            /*
             * Count through the sites where this user has access.
             */
if ($USER->site_access_check($Bickerdike_id)){
 ?>                   You have access to the <a href="/bickerdike/">Bickerdike</a> site information. <br>
<?php
}
if ($USER->site_access_check($LSNA_id)){
?>
    You have access to the <a href="/lsna/">LSNA</a> site information. <br>
<?php
}
if ($USER->site_access_check($TRP_id)){
?>
    You have access to <a href="/trp/">The Resurrection Project</a> site information. <br/>
<?php
        }
if ($USER->site_access_check($SWOP_id)){
?>
    You have access to the <a href="/swop/">Southwest Organizing Project</a> site information. <br/>
<?php
        }
if ($USER->site_access_check($Enlace_id)){
?>
    You have access to the <a href="/enlace/">Enlace</a> site information. <br/>
<?php
        }

}
?>
<?php include "footer.php"; ?>
</html>