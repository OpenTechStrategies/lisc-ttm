<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, 1);

// Delete a program
//
//
//make sure the user has access to the program
//
// *First determine the program that the logged-in user has access to.  Usually this will be a program ID number,
// *but sometimes it will be 'a' (all) or 'n' (none).
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
$user_sqlsafe=mysqli_real_escape_string($cnnLISC, $_COOKIE['user']);
$get_program_access = "SELECT Program_Access
                        FROM Users_Privileges
                        INNER JOIN Users ON Users.User_Id = Users_Privileges.User_ID
                        WHERE User_Email = '" . $user_sqlsafe . "'";
//echo $get_program_access;
$program_access = mysqli_query($cnnLISC, $get_program_access);
$prog_access = mysqli_fetch_row($program_access);
$access = $prog_access[0];
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");

//if an administrator
if ($access == 'a') {
    //if delete program action
    if ($_POST['action'] == "delete_program") {
        //get all program sessions
        include "../include/dbconnopen.php";
        $program_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program_id']);
        $all_program_sessions = "SELECT Session_ID FROM Session_Names "
                                . "WHERE Program_ID='" . $program_id_sqlsafe . "'";
        $all_program_sessions = mysqli_query($cnnEnlace, $all_program_sessions);
        include "../include/dbconnclose.php";
        
        //loop through program sessions
        while ($program_session = mysqli_fetch_array($all_program_sessions)) {
            //delete all program's sessions and details
            
            //delete session from baseline assessments
            $delete_session = "DELETE FROM Participants_Baseline_Assessments WHERE Program='" . $program_session['Session_ID'] . "'";
            echo $delete_session;
            include "../include/dbconnopen.php";
            mysqli_query($cnnEnlace, $delete_session);
            include "../include/dbconnclose.php";

            //delete session from Participants_Interpersonal_Violence
            $delete_session = "DELETE FROM Participants_Interpersonal_Violence WHERE Program='" . $program_session['Session_ID'] . "'";
            echo $delete_session;
            include "../include/dbconnopen.php";
            mysqli_query($cnnEnlace, $delete_session);
            include "../include/dbconnclose.php";

            //delete session from Participants_Caring_Adults
            $delete_session = "DELETE FROM Participants_Caring_Adults WHERE Program='" . $program_session['Session_ID'] . "'";
            echo $delete_session;
            include "../include/dbconnopen.php";
            mysqli_query($cnnEnlace, $delete_session);
            include "../include/dbconnclose.php";

            //delete session from Participants_Future_Expectations
            $delete_session = "DELETE FROM Participants_Future_Expectations WHERE Program='" . $program_session['Session_ID'] . "'";
            echo $delete_session;
            include "../include/dbconnopen.php";
            mysqli_query($cnnEnlace, $delete_session);
            include "../include/dbconnclose.php";

            //delete session from Participants_Programs
            $delete_session = "DELETE FROM Participants_Programs WHERE Program_ID='" . $program_session['Session_ID'] . "'";
            echo $delete_session;
            include "../include/dbconnopen.php";
            mysqli_query($cnnEnlace, $delete_session);
            include "../include/dbconnclose.php";

            //delete session from program_surveys
            $delete_session = "DELETE FROM Program_Surveys WHERE Session_ID='" . $program_session['Session_ID'] . "'";
            echo $delete_session;
            include "../include/dbconnopen.php";
            mysqli_query($cnnEnlace, $delete_session);
            include "../include/dbconnclose.php";

            //delete session from Session_Names
            $delete_session = "DELETE FROM Session_Names WHERE Session_ID='" . $program_session['Session_ID'] . "'";
            echo $delete_session;
            include "../include/dbconnopen.php";
            mysqli_query($cnnEnlace, $delete_session);
            include "../include/dbconnclose.php";
        }
        
        //delete program
        $delete_program = "DELETE FROM Programs "
                        . "WHERE Program_ID = '" . $program_id_sqlsafe . "'";
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $delete_program);
        include "../include/dbconnclose.php";
    }
}    
?>