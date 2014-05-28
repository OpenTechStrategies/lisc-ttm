<?php
/* participant_program changes */

// delete session and all corresponding data
if ($_POST['action'] == 'delete_session') {
    date_default_timezone_set('America/Chicago');
    
    //delete session from baseline assessments
    $delete_session = "DELETE FROM Participants_Baseline_Assessments WHERE Program='" . $_POST['session_id'] . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Participants_Interpersonal_Violence
    $delete_session = "DELETE FROM Participants_Interpersonal_Violence WHERE Program='" . $_POST['session_id'] . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Participants_Caring_Adults
    $delete_session = "DELETE FROM Participants_Caring_Adults WHERE Program='" . $_POST['session_id'] . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Participants_Future_Expectations
    $delete_session = "DELETE FROM Participants_Future_Expectations WHERE Program='" . $_POST['session_id'] . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Participants_Programs
    $delete_session = "DELETE FROM Participants_Programs WHERE Program_ID='" . $_POST['session_id'] . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from program_surveys
    $delete_session = "DELETE FROM Program_Surveys WHERE Session_ID='" . $_POST['session_id'] . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Session_Names
    $delete_session = "DELETE FROM Session_Names WHERE Session_ID='" . $_POST['session_id'] . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
}
/* delete participant completely */
else if ($_POST['action'] == 'delete_participant') {
    date_default_timezone_set('America/Chicago');
    
    //delete participant from programs
    $delete_participant = "DELETE FROM Participants_Programs WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from absences
    $delete_participant = "DELETE FROM Absences WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from baseline assessments
    $delete_participant = "DELETE FROM Participants_Baseline_Assessments WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from caring adults
    $delete_participant = "DELETE FROM Participants_Caring_Adults WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from parent / child relationships
    $delete_participant = "DELETE FROM Child_Parent WHERE Child_ID ='" . $_POST['participant_id'] . "' "
                            . "OR Parent_ID ='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from participants
    $delete_participant = "DELETE FROM Participants WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from interpersonal violence
    $delete_participant = "DELETE FROM Participants_Interpersonal_Violence WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from consents
    $delete_participant = "DELETE FROM Participants_Consent WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from events
    $delete_participant = "DELETE FROM Participants_Events WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from future expectations
    $delete_participant = "DELETE FROM Participants_Future_Expectations WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from referrals
    $delete_participant = "DELETE FROM Referrals WHERE Participant_ID='" . $_POST['participant_id'] . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
}
/* drop from program.  we delete people from participants_programs */ elseif ($_POST['action'] == 'delete_participant_from_program') {
    date_default_timezone_set('America/Chicago');
    
    //delete participant from program
    $delete_participant_from_program = "DELETE FROM Participants_Programs WHERE Participant_Program_ID='" . $_POST['link_id'] . "'";
    echo $delete_participant_from_program;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant_from_program);
    include "../include/dbconnclose.php";
}
/* drop from program.  we don't delete people from participants_programs, just add a "dropped" date */ elseif ($_POST['action'] == 'drop') {
    date_default_timezone_set('America/Chicago');

    $drop_from_program = "UPDATE Participants_Programs SET Date_Dropped='" . date('Y-m-d') . "' WHERE Participant_Program_ID='" . $_POST['link_id'] . "'";
    echo $drop_from_program;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $drop_from_program);
    include "../include/dbconnclose.php";
}
/* or, add someone to a program!  which I believe is actually adding them to a session. */ else {
    $add_person_to_program = "INSERT INTO Participants_Programs (Participant_ID, Program_ID) VALUES (
    '" . $_POST['participant'] . "', '" . $_POST['program_id'] . "')";
    echo $add_person_to_program;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $add_person_to_program);
    include "../include/dbconnclose.php";
}
?>
