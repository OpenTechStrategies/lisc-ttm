<?php

//delete participant and data

//delete from gads_hill_parent_survey
$delete_gads_hill_parent_survey = "DELETE FROM Gads_Hill_Parent_Survey "
                    . "WHERE Child_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_gads_hill_parent_survey . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_gads_hill_parent_survey);
include "../include/dbconnclose.php";

//delete from parents_children
$delete_parents_children = "DELETE FROM Parents_Children "
                    . "WHERE Parent_ID = '" . $_POST['participant_id'] . "' OR "
                    . "Child_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_parents_children . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_parents_children);
include "../include/dbconnclose.php";

//delete from programs_uploads
$delete_programs_uploads = "DELETE FROM Programs_Uploads "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_programs_uploads . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_programs_uploads);
include "../include/dbconnclose.php";

//delete from academic_info
$delete_academic_info = "DELETE FROM Academic_Info "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_academic_info . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_academic_info);
include "../include/dbconnclose.php";

//delete from ms_to_hs_over_time
$delete_ms_to_hs_over_time = "DELETE FROM MS_to_HS_Over_Time "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_ms_to_hs_over_time . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_ms_to_hs_over_time);
include "../include/dbconnclose.php";

//delete from gold_scores
$delete_gold_scores = "DELETE FROM GOLD_Scores "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_gold_scores . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_gold_scores);
include "../include/dbconnclose.php";

//delete from nmma_traditions_survey
$delete_nmma_traditions_survey = "DELETE FROM NMMA_Traditions_Survey "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_nmma_traditions_survey . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_nmma_traditions_survey);
include "../include/dbconnclose.php";

//delete from new_horizons_participants
$delete_new_horizons_participants = "DELETE FROM New_Horizons_Participants "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_new_horizons_participants . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_new_horizons_participants);
include "../include/dbconnclose.php";

//delete from participants_consent
$delete_participants_consent = "DELETE FROM Participants_Consent "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_participants_consent . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participants_consent);
include "../include/dbconnclose.php";

//delete from gold_score_totals
$delete_gold_score_totals = "DELETE FROM Gold_Score_Totals "
                    . "WHERE Participant = '" . $_POST['participant_id'] . "'";
//echo $delete_gold_score_totals . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_gold_score_totals);
include "../include/dbconnclose.php";

//delete from dap_group_scoreing
$delete_dap_group_scoring = "DELETE FROM DAP_Group_Scoring "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_dap_group_scoring . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_dap_group_scoring);
include "../include/dbconnclose.php";

//delete from new_horizons_participants
$delete_new_horizons_participants = "DELETE FROM New_Horizons_Participants "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_new_horizons_participants . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_new_horizons_participants);
include "../include/dbconnclose.php";

//delete from nmma_participants
$delete_nmma_participants = "DELETE FROM NMMA_Participants "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_nmma_participants . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_nmma_participants);
include "../include/dbconnclose.php";

//delete from nmma_identity_survey
$delete_nmma_identity_survey = "DELETE FROM NMMA_Identity_Survey "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_nmma_identity_survey . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_nmma_identity_survey);
include "../include/dbconnclose.php";

//delete from nmma_participants
$delete_nmma_participants = "DELETE FROM NMMA_Participants "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_nmma_participants . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_nmma_participants);
include "../include/dbconnclose.php";

//delete from program_attendance
$delete_program_attendance = "DELETE FROM Program_Attendance "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_program_attendance . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_program_attendance);
include "../include/dbconnclose.php";

//delete from participants_teachers
$delete_participants_teachers = "DELETE FROM Participants_Teachers "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_participants_teachers . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participants_teachers);
include "../include/dbconnclose.php";

//delete from outcomes_participants
$delete_outcomes_participants = "DELETE FROM Outcomes_Participants "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_outcomes_participants . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_outcomes_participants);
include "../include/dbconnclose.php";

//delete from explore_scores
$delete_explore_scores = "DELETE FROM Explore_Scores "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_explore_scores . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_explore_scores);
include "../include/dbconnclose.php";

//delete from events_participants
$delete_events_participants = "DELETE FROM Events_Participants "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_events_participants . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_events_participants);
include "../include/dbconnclose.php";

//delete from participants_program_sessions
$delete_participants_program_sessions = "DELETE FROM Participants_Program_Sessions "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_participants_program_sessions . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participants_program_sessions);
include "../include/dbconnclose.php";

//delete from participants_programs
$delete_participants_programs = "DELETE FROM Participants_Programs "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_participants_programs . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participants_programs);
include "../include/dbconnclose.php";

//delete participant
$delete_participant = "DELETE FROM Participants "
                    . "WHERE Participant_ID = '" . $_POST['participant_id'] . "'";
//echo $delete_participant . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participant);
include "../include/dbconnclose.php";

?>