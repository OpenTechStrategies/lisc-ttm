<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($Enlace_id, $DataEntryAccess);


?>

<h3>Export All Information</h3>

<table class="all_projects">
    <tr><th>Export Description</th><th>Identified Version</th><th>Deidentified Version</th></tr>

    <tr>
        <td class="all_projects">
            All events, with their corresponding campaign.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_events">
                Download.</a></td>
        <td class="all_projects">---</td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            All campaigns that are associated with an institution.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_inst_campaigns">
                Download.</a>
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr>
        <td class="all_projects">
            All campaigns.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_campaigns">
                Download.</a>    
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            All institutions.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_institutions_deid">
                Download.</a></td>
        <td class="all_projects">---</td>
    </tr>


    <tr>
        <td class="all_projects">
            All participants.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_participants">
    Download</a>
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_participants_deid">
    Download</a>
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            All intake assessments.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_intake_assessments">
    Download.</a>
        </td>
        <td class="all_projects">
    <a href="/include/generalized_download_script.php?download_name=enlace_intake_assessments_deid"> 
    Download.</a>
        </td>
    </tr>

    <tr>
        <td class="all_projects">
            All impact surveys.
        </td>
        <td class="all_projects">
    <a href="/include/generalized_download_script.php?download_name=enlace_impact_surveys">
    Download.</a>
        </td>
        <td class="all_projects">
    <a href="/include/generalized_download_script.php?download_name=enlace_impact_surveys_deid">            
            Download.</a>
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            Participant consent records.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_consent_records">
                Download.</a>
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_consent_records_deid">
                Download.</a>
        </td>
    </tr>


    <tr>
        <td class="all_projects">
            Event attendance, with roles.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_event_attendance">Download.</a>
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_event_attendance_deid"> 
                Download. </a>
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            Participant mentorship hours.
        </td>

        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_mentorship_hours">
                Download.</a>
        </td>

        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_mentorship_hours_deid">
                Download.</a>
        </td>
    </tr>


    <tr>
        <td class="all_projects">
            All programs.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_programs">
            Download.</a>
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_programs">
                Download.</a>
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            Program participation (includes date dropped if applicable).
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_program_participation"> Download.</a>
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_program_participation_deid">
                Download.</a>
        </td>
    </tr>


    <tr>
        <td class="all_projects">
            Program attendance.
            <!--This should more properly be called "session attendance," since dates and attendance are now measured by session.
            Need to include program and session information here.
            At the moment it is only absences.  Trying to figure out how to change that.
            -->
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_session_attendance">Download.</a>
        </td>

        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_session_attendance_deid">
                Download.</a>
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            Program surveys.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_session_surveys">Download.</a>
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr>
        <td class="all_projects">
            All sessions (by program).
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_sessions">Download.</a>
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            All referrals.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_referrals">Download.</a>
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_referrals_deid">Download.</a>
        </td>
    </tr>

    <tr>
        <td class="all_projects">Participant dosages.</td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_participant_dosage">
                Download.</a> 
        </td>
        <td class="all_projects">
              <a href="/include/generalized_download_script.php?download_name=enlace_participant_dosage_deid">
                Download.</a> 
        </td>
    </tr>


    <tr>
        <td class="all_projects">New survey exports</td>
        <td class="all_projects">
            <!-- Users want to be able to pull pre and post surveys together in one line. -->
              <a href="/include/generalized_download_script.php?download_name=enlace_new_surveys">
                Download.</a>
        </td>

        <td class="all_projects">
            <!-- Users want to be able to pull pre and post surveys together in one line. -->
              <a href="/include/generalized_download_script.php?download_name=enlace_new_surveys_deid">            
                Download.</a>
        </td>
    </tr>
</table>
