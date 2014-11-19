<?php
//if action is logout
if ( (isset($_GET['action'])) && $_GET['action'] == 'logout') {
    //kill cookie
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
?>
<!DOCTYPE html>
<html>
    <?php
    include "header.php";

    if (!isset($_COOKIE['user'])) {
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
        //  print_r($_COOKIE);
        if (in_array('all_sites', $_COOKIE['sites'])) {
            /*
             * Didn't end up using this option.
             */
            echo "You have access to all sites.";
        } else {
            /*
             * Count through the sites where this user has access.
             */
            $n = 0;
            while ($n < count($_COOKIE['sites'])) {
                include "include/dbconnopen.php";
                $privilege_id_sqlsafe=  mysqli_real_escape_string($cnnLISC, $_COOKIE['sites'][$n]);
                $get_privilege_name_sqlsafe = "SELECT * FROM Privileges WHERE Privilege_Id='" . $privilege_id_sqlsafe . "'";
                //echo $get_privilege_name_sqlsafe;
                $privilege_name = mysqli_query($cnnLISC, $get_privilege_name_sqlsafe);
                $name = mysqli_fetch_array($privilege_name);
                if ($name['Privilege_Name'] == 'Bickerdike') {
                    ?>
                    You have access to the <a href="/bickerdike/">Bickerdike</a> site information. <br>
                    <?php
                } elseif ($name['Privilege_Name'] == 'Logan Square Neighborhood Association') {
                    ?>
                    You have access to the <a href="/lsna/">LSNA</a> site information. <br>
                    <?php
                } else if ($name['Privilege_Name'] == 'The Resurrection Project') {
                    ?>
                    You have access to <a href="/trp/">The Resurrection Project</a> site information. <br/>
                    <?php
                } else if ($name['Privilege_Name'] == 'Southwest Organizing Project') {
                    ?>
                    You have access to the <a href="/swop/">Southwest Organizing Project</a> site information. <br/>
                    <?php
                } else if ($name['Privilege_Name'] == 'Enlace') {
                    ?>
                    You have access to the <a href="/enlace/">Enlace</a> site information. <br/>
                    <?php
                }
                ?>
                <?php
                include "include/dbconnclose.php";
                $n = $n + 1;
            }
        }
    }
    ?>
    <div id="site_notification"></div>
    <!--<a href="/index.php?action=logout">Logout</a>-->
<?php include "footer.php"; ?>
</html>
