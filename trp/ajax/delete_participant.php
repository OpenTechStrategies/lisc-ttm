<?php

//delete participant and data

//delete from gads_hill_parent_survey
$delete_gads_hill_parent_survey_sqlsafe = "DELETE FROM Gads_Hill_Parent_Survey "
                    . "WHERE Child_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_gads_hill_parent_survey_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_gads_hill_parent_survey_sqlsafe);
include "../include/dbconnclose.php";

//delete from parents_children
$delete_parents_children_sqlsafe = "DELETE FROM Parents_Children "
                    . "WHERE Parent_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "' OR "
                    . "Child_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_parents_children_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_parents_children_sqlsafe);
include "../include/dbconnclose.php";

//delete from programs_uploads
$delete_programs_uploads_sqlsafe = "DELETE FROM Programs_Uploads "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_programs_uploads_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_programs_uploads_sqlsafe);
include "../include/dbconnclose.php";

//delete from academic_info
$delete_academic_info_sqlsafe = "DELETE FROM Academic_Info "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_academic_info_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_academic_info_sqlsafe);
include "../include/dbconnclose.php";

//delete from ms_to_hs_over_time
$delete_ms_to_hs_over_time_sqlsafe = "DELETE FROM MS_to_HS_Over_Time "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_ms_to_hs_over_time_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_ms_to_hs_over_time_sqlsafe);
include "../include/dbconnclose.php";

//delete from gold_scores
$delete_gold_scores_sqlsafe = "DELETE FROM GOLD_Scores "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_gold_scores_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_gold_scores_sqlsafe);
include "../include/dbconnclose.php";

//delete from nmma_traditions_survey
$delete_nmma_traditions_survey_sqlsafe = "DELETE FROM NMMA_Traditions_Survey "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_nmma_traditions_survey_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_nmma_traditions_survey_sqlsafe);
include "../include/dbconnclose.php";

//delete from new_horizons_participants
$delete_new_horizons_participants_sqlsafe = "DELETE FROM New_Horizons_Participants "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_new_horizons_participants_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_new_horizons_participants_sqlsafe);
include "../include/dbconnclose.php";

//delete from participants_consent
$delete_participants_consent_sqlsafe = "DELETE FROM Participants_Consent "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_participants_consent_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participants_consent_sqlsafe);
include "../include/dbconnclose.php";

//delete from gold_score_totals
$delete_gold_score_totals_sqlsafe = "DELETE FROM Gold_Score_Totals "
                    . "WHERE Participant = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_gold_score_totals_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_gold_score_totals_sqlsafe);
include "../include/dbconnclose.php";

//delete from dap_group_scoreing
$delete_dap_group_scoring_sqlsafe = "DELETE FROM DAP_Group_Scoring "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_dap_group_scoring_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_dap_group_scoring_sqlsafe);
include "../include/dbconnclose.php";

//delete from new_horizons_participants
$delete_new_horizons_participants_sqlsafe = "DELETE FROM New_Horizons_Participants "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_new_horizons_participants_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_new_horizons_participants_sqlsafe);
include "../include/dbconnclose.php";

//delete from nmma_participants
$delete_nmma_participants_sqlsafe = "DELETE FROM NMMA_Participants "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_nmma_participants_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_nmma_participants_sqlsafe);
include "../include/dbconnclose.php";

//delete from nmma_identity_survey
$delete_nmma_identity_survey_sqlsafe = "DELETE FROM NMMA_Identity_Survey "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_nmma_identity_survey_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_nmma_identity_survey_sqlsafe);
include "../include/dbconnclose.php";

//delete from nmma_participants
$delete_nmma_participants_sqlsafe = "DELETE FROM NMMA_Participants "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_nmma_participants_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_nmma_participants_sqlsafe);
include "../include/dbconnclose.php";

//delete from program_attendance
$delete_program_attendance_sqlsafe = "DELETE FROM Program_Attendance "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_program_attendance_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_program_attendance_sqlsafe);
include "../include/dbconnclose.php";

//delete from participants_teachers
$delete_participants_teachers_sqlsafe = "DELETE FROM Participants_Teachers "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_participants_teachers_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participants_teachers_sqlsafe);
include "../include/dbconnclose.php";

//delete from outcomes_participants
$delete_outcomes_participants_sqlsafe = "DELETE FROM Outcomes_Participants "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_outcomes_participants_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_outcomes_participants_sqlsafe);
include "../include/dbconnclose.php";

//delete from explore_scores
$delete_explore_scores_sqlsafe = "DELETE FROM Explore_Scores "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_explore_scores_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_explore_scores_sqlsafe);
include "../include/dbconnclose.php";

//delete from events_participants
$delete_events_participants_sqlsafe = "DELETE FROM Events_Participants "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_events_participants_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_events_participants_sqlsafe);
include "../include/dbconnclose.php";

//delete from participants_program_sessions
$delete_participants_program_sessions_sqlsafe = "DELETE FROM Participants_Program_Sessions "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_participants_program_sessions_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participants_program_sessions_sqlsafe);
include "../include/dbconnclose.php";

//delete from participants_programs
$delete_participants_programs_sqlsafe = "DELETE FROM Participants_Programs "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_participants_programs_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participants_programs_sqlsafe);
include "../include/dbconnclose.php";

//delete participant
$delete_participant_sqlsafe = "DELETE FROM Participants "
                    . "WHERE Participant_ID = '" . mysqli_real_escape_string($_POST['participant_id']) . "'";
//echo $delete_participant_sqlsafe . "<br />";
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $delete_participant_sqlsafe);
include "../include/dbconnclose.php";

?>