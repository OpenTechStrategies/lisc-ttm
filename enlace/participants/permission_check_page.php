<?php
/*
 * This file is designed to prevent access to surveys for people who aren't related to the program.
 * That is, users can only view the surveys of participants in their own program.
 * 
 * Admin users have access to all programs ('a').
 * Some users may have access to no programs.
 */

/*
 * First determine the program that the logged-in user has access to.  Usually this will be a program ID number,
 * but sometimes it will be 'a' (all) or 'n' (none).
 */
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
$user_sqlsafe=mysqli_real_escape_string($cnnLISC, $_COOKIE['user']);
$get_program_access = "SELECT Program_Access FROM Users_Privileges INNER JOIN Users ON Users.User_Id = Users_Privileges.User_ID
    WHERE User_Email = '" . $user_sqlsafe . "'";
$program_access = mysqli_query($cnnLISC, $get_program_access);
$prog_access = mysqli_fetch_row($program_access);
$access = $prog_access[0];
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");

/* if this is a new survey (no assessment ID set), send them there right away, regardless of permissions: */
if (!isset($_GET['assessment'])) {
    if ($_GET['page'] == 'intake') {

        header('Location: all_intake.php?person=' . $_GET['id']);
        exit;
    } elseif ($_GET['page'] == 'impact') {
        header('Location: all_impact.php?person=' . $_GET['id']);
        exit;
    }

/* if they have access to all programs, then send them to the survey! */
} elseif ($access == 'a') {
    if ($_GET['page'] == 'intake') {
        header('Location: all_intake.php?id=' . $_GET['assessment']);
        exit;
    } elseif ($_GET['page'] == 'impact') {
        header('Location: all_impact.php?id=' . $_GET['assessment']);
        exit;
    }

/* if they don't have access to programs, show a permission denied message. */
} elseif ($access == 'n') {
    include "../../header.php";
    include "../header.php";
    ?>
    <h2>Access Denied</h2>
    <p>Access: <?php echo $access; ?><br>You do not have permission to view this page.  If you believe you have reached this page in error, please contact a system administrator.</p>
    <?php
    include "../../footer.php";

/* if an assessment ID was sent and the logged-in user has access to a program, then: */
} else {
    //test whether the access permission matches a program that this person is involved with
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_GET['id']);
    $get_program = "SELECT * FROM Participants_Programs INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_ID
        WHERE Participant_ID = '" . $id_sqlsafe . "' AND Session_Names.Program_ID = '$access'";
    include "../include/dbconnopen.php";
    $program_connected = mysqli_query($cnnEnlace, $get_program);
    $is_in_program = mysqli_num_rows($program_connected);

    /* if they have the permission for a program this person is in: 
     * Ohh, sessions are going to mess this up...
     * If they have the correct permission, then send them to the survey:
     */
    if ($is_in_program > 0) {
        if ($_GET['page'] == 'intake') {
            header('Location: all_intake.php?id=' . $_GET['assessment']);
            exit;
        } elseif ($_GET['page'] == 'impact') {
            header('Location: all_impact.php?id=' . $_GET['assessment']);
            exit;
        }
    }
    /* if they don't have the permission, show the access denied message: */ else {
        include "../../header.php";
        include "../header.php";
        ?>
        <h2>Access Denied</h2>
        <p>Access: <?php echo $access;?><br>The selected participant is not attached to your program.  If s/he is in your program, please add him or her to the program participants.
            If you believe you have reached this page in error, please contact a system administrator.</p>
        <?php
        include "../../footer.php";
    }
    include "../include/dbconnclose.php";
}
?>
