<?php
/* participant_program changes */

// delete session and all corresponding data
if ($_POST['action'] == 'delete_session') {
    include "../include/dbconnopen.php";
    $session_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['session_id']);
    date_default_timezone_set('America/Chicago');
    
    //delete session from baseline assessments
    $delete_session = "DELETE FROM Participants_Baseline_Assessments WHERE Program='" . $session_id_sqlsafe . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Participants_Interpersonal_Violence
    $delete_session = "DELETE FROM Participants_Interpersonal_Violence WHERE Program='" . $session_id_sqlsafe . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Participants_Caring_Adults
    $delete_session = "DELETE FROM Participants_Caring_Adults WHERE Program='" . $session_id_sqlsafe . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Participants_Future_Expectations
    $delete_session = "DELETE FROM Participants_Future_Expectations WHERE Program='" . $session_id_sqlsafe . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Participants_Programs
    $delete_session = "DELETE FROM Participants_Programs WHERE Program_ID='" . $session_id_sqlsafe . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from program_surveys
    $delete_session = "DELETE FROM Program_Surveys WHERE Session_ID='" . $session_id_sqlsafe . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
    //delete session from Session_Names
    $delete_session = "DELETE FROM Session_Names WHERE Session_ID='" . $session_id_sqlsafe . "'";
    echo $delete_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_session);
    include "../include/dbconnclose.php";
    
}
/* delete participant completely */
else if ($_POST['action'] == 'delete_participant') {
    include "../include/dbconnopen.php";
    $participant_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['participant_id']);
    date_default_timezone_set('America/Chicago');
    
    //delete participant from programs
    $delete_participant = "DELETE FROM Participants_Programs WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from absences
    $delete_participant = "DELETE FROM Absences WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from baseline assessments
    $delete_participant = "DELETE FROM Participants_Baseline_Assessments WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from caring adults
    $delete_participant = "DELETE FROM Participants_Caring_Adults WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from parent / child relationships
    $delete_participant = "DELETE FROM Child_Parent WHERE Child_ID ='" . $participant_id_sqlsafe . "' "
                            . "OR Parent_ID ='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from participants
    $delete_participant = "DELETE FROM Participants WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from interpersonal violence
    $delete_participant = "DELETE FROM Participants_Interpersonal_Violence WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from consents
    $delete_participant = "DELETE FROM Participants_Consent WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from events
    $delete_participant = "DELETE FROM Participants_Events WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from future expectations
    $delete_participant = "DELETE FROM Participants_Future_Expectations WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
    
    //delete participant from referrals
    $delete_participant = "DELETE FROM Referrals WHERE Participant_ID='" . $participant_id_sqlsafe . "'";
    echo $delete_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_participant);
    include "../include/dbconnclose.php";
}
/* drop from program.  we delete people from participants_programs */ 
elseif ($_POST['action'] == 'delete_participant_from_program') {
    date_default_timezone_set('America/Chicago');
    include "../include/dbconnopen.php";
    $link_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['link_id']);
    
    //delete participant from program
    $delete_participant_from_program = "DELETE FROM Participants_Programs WHERE Participant_Program_ID='" . $link_id_sqlsafe . "'";
    echo $delete_participant_from_program;
    mysqli_query($cnnEnlace, $delete_participant_from_program);
    include "../include/dbconnclose.php";
}
/* drop from program.  we don't delete people from participants_programs, just add a "dropped" date */ 
elseif ($_POST['action'] == 'drop') {
    date_default_timezone_set('America/Chicago');
    include "../include/dbconnopen.php";
    $link_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['link_id']);

    $drop_from_program = "UPDATE Participants_Programs SET Date_Dropped='" . date('Y-m-d') . "' WHERE Participant_Program_ID='" . $link_id . "'";
    echo $drop_from_program;
    mysqli_query($cnnEnlace, $drop_from_program);
    include "../include/dbconnclose.php";
}
/* or, add someone to a program!  which I believe is actually adding them to a session. */
else {
    include "../include/dbconnopen.php";
    $participant_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['participant']);
    $program_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program_id']);

    $add_person_to_program = "INSERT INTO Participants_Programs (Participant_ID, Program_ID) VALUES (
    '" . $participant_sqlsafe . "', '" . $program_id_sqlsafe . "')";
    echo $add_person_to_program;
    mysqli_query($cnnEnlace, $add_person_to_program);

    // Check if they have a previous impact survey which can be used as their intake survey.
    $impact_survey_search = "SELECT * FROM Assessments WHERE Date_Logged >= DATE_SUB(now(), INTERVAL 6 MONTH)";
    $impact_surveys = mysqli_query($cnnEnlace, $impact_survey_search);
    if ($impact_surveys) {
        /* We've found one so we want to duplicate that and store it as an intake survey
           Ideally we'd reference the Assessment from the session table but in the interests
           of time we'll duplicate the data and store a different Session_ID.
        */
        $impact_survey = mysqli_fetch_assoc($impact_surveys);



        // Now we need to duplicate it but set a different Session_ID
        // Note: Pre_Post field can be 1 or 2 which are intake and impact respectively.
        $add_intake_survey = "INSERT INTO Assessments (Participant_ID, Baseline_ID, Caring_ID, Future_ID, Violence_ID, Pre_Post, Date_Logged, Session_ID) VALUES (";
        $add_intake_survey = $add_intake_survey . "'" . $impact_survey['Participant_ID'] . "', '" . $impact_survey['Baseline_ID'] . "', '".
                             $impact_survey['Caring_ID'] . "', '". $impact_survey['Future_ID'] . "', '" . $impact_survey['Violence_ID'] . "', '1', '".
                             $impact_survey['Date_Logged'] . "', '" . $program_id_sqlsafe . "')";

        mysqli_query($cnnEnlace, $add_intake_survey);

    }
    include "../include/dbconnclose.php";
}
?>
