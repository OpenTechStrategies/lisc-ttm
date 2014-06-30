<?php
//get user's access
//
// *First determine the program that the logged-in user has access to.  Usually this will be a program ID number,
// *but sometimes it will be 'a' (all) or 'n' (none).
$get_program_access = "SELECT Program_Access FROM Users_Privileges INNER JOIN Users ON Users.User_Id = Users_Privileges.User_ID
    WHERE User_Email = " . stripslashes($_COOKIE['user']) . "";
//echo $get_program_access;
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
$program_access = mysqli_query($cnnLISC, $get_program_access);
$prog_access = mysqli_fetch_row($program_access);
$access = $prog_access[0];
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>

<h3>Export All Information</h3>

<table class="all_projects">
    <tr><th>Export Description</th><th>Identified Version</th><th>Deidentified Version</th></tr>

    <tr>
        <td class="all_projects">
            All events, with their corresponding campaign.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/events_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Event_Name", "Event_Date", "Address_Num", "Address_Dir", "Address_Street", "Address_Suffix", "Event Type",
                "File_Name of upload", "Campaign_Name");
            fputcsv($fp, $title_array);
            $get_events = "SELECT Event_Name, Event_Date, Address_Num, Address_Dir, Address_Street,
                            Address_Suffix, Event_Types.Type, Note_File_Name, Campaign_Name
                            FROM Campaigns_Events LEFT JOIN Campaigns ON Campaigns.Campaign_ID = Campaigns_Events.Campaign_ID
                            LEFT JOIN Event_Types ON Campaigns_Events.Type = Event_Type_ID;";
           // echo $get_events;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            All campaigns that are associated with an institution.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/campaign_institution_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Campaign_Name", "Institution Name");
            fputcsv($fp, $title_array);
            $get_events = "SELECT Campaign_Name, Institution_Name FROM Campaigns_Institutions
                            INNER JOIN Campaigns ON Campaigns_Institutions.Campaign_ID = Campaigns.Campaign_ID
                            INNER JOIN Institutions ON Institution_ID = Inst_ID;";
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr>
        <td class="all_projects">
            All campaigns.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/campaigns_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Campaign ID", "Campaign_Name");
            fputcsv($fp, $title_array);
            
            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Participants_Programs.Program_ID = " . $access . ";";
            }
            
            $get_events = "SELECT * FROM Campaigns "
                        . "LEFT JOIN Campaigns_Events ON Campaigns.Campaign_ID = Campaigns_Events.Campaign_ID "
                        . "LEFT JOIN Participants_Events ON Participants_Events.Event_ID = Campaigns_Events.Campaign_Event_ID "
                        . "LEFT JOIN Participants_Programs ON Participants_Programs.Participant_ID = Participants_Events.Participant_ID"
                        . $non_admin_string;
            
            $get_events = "SELECT * FROM Campaigns";
           // echo $get_events;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            All institutions.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/institutions_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Institution Name", "Institution Type", "Address_Num", "Address_Direction", "Address_Street", "Address_Street_Type",
                "Phone", "Email");
            fputcsv($fp, $title_array);
            $get_events = "SELECT Institution_Name, Type, Address_Num, Address_Dir, Address_Street, Address_Street_Type,
                            Phone, Email
                            FROM Institutions INNER JOIN Institution_Types
                            ON Institution_Type = Inst_Type_ID;";
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr>
        <td class="all_projects">
            All participants.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/participants_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "First_Name", "Last_Name", "Day_Phone", "Evening_Phone", "Address Number", "Address Direction",
                "Address Street Name",
                "Address Street Type", "Address_City", "Address_State", "Address_ZIP",
                "DOB", "Age", "Gender", "Grade", "School", "Role", "Email");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID
                                    INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID
                                    INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID
                                    WHERE Programs.Program_ID = " . $access . ";";
            }

            $get_events = "SELECT Participants.Participant_ID, First_Name, Last_Name, Day_Phone, Evening_Phone, Participants.Address_Num, Participants.Address_Dir, 
                            Participants.Address_Street,
                            Participants.Address_Street_Type, Address_City, Address_State, Address_ZIP,
                            DOB, Age, Gender, Grade, Institution_Name, Roles.Role, Participants.Email
                            FROM Participants
                            LEFT JOIN Roles ON Participants.Role = Roles.Role_ID
                            LEFT JOIN Institutions ON School = Inst_ID"
                            . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/deid_participants_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Address_City", "Address_State", "Address_ZIP",
                "Age", "Gender", "Grade", "School", "Role");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID
                                    INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID
                                    INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID
                                    WHERE Programs.Program_ID = " . $access . ";";
            }

            $get_events = "SELECT Address_City, Address_State, Address_ZIP,
                            Age, Gender, Grade, Institution_Name, Roles.Role
                            FROM Participants
                            LEFT JOIN Roles ON Participants.Role = Roles.Role_ID
                            LEFT JOIN Institutions ON School = Inst_ID"
                            . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            All intake assessments.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/intake_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Assessment ID", "Participant ID", "First_Name", "Last_Name", "Pre or Post", "Date Logged");
            $get_questions = "SELECT Question FROM Baseline_Assessment_Questions ORDER BY In_Table";
            include "../include/dbconnopen.php";
            $all_questions = mysqli_query($cnnEnlace, $get_questions);
            while ($q = mysqli_fetch_row($all_questions)) {
                $title_array[] = $q[0];
            }
            fputcsv($fp, $title_array);

            $non_admin_string = "";
            $non_admin_string1 = "";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID
                                    INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID
                                    INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID";
                $non_admin_string1 = " AND Programs.Program_ID = " . $access . ";";
            }

            $get_events = "SELECT Assessment_ID, Assessments.Participant_ID, First_Name, Last_Name, Assessments.Pre_Post, Assessments.Date_Logged, 
                            BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_T, BYS_E, 
                            JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_T, JVQ_E, JVQ_12, US_Born,
                            Check_In, Compliment, Crisis_Help, Know_You, KnowImportance, Pay_Attention, Personal_Advice, Upset_Discussion,

                            Alive_Well, Finish_HS, Friends, Happy_Life, Interesting_Life, Manage_Work, Proud_Parents, Solve_Problems, Stay_Safe,
                            Anger_Mgmt, Coping, Cowardice, Handle_Others, Negotiation, Parent_Approval, Parent_Disapproval,
                            Self_Awareness, Self_Care, Self_Defense, Teasing_Prevention

                            FROM Assessments
                            LEFT JOIN Participants_Baseline_Assessments ON Baseline_Assessment_ID = Baseline_ID
                            LEFT JOIN Participants_Caring_Adults ON Caring_ID = Caring_Adults_ID
                            LEFT JOIN Participants_Future_Expectations ON Future_Id = Future_Expectations_ID
                            LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID = Interpersonal_Violence_ID
                            LEFT JOIN Participants ON Assessments.Participant_Id = Participants.Participant_ID"
                            . $non_admin_string
                            . " WHERE Assessments.Pre_Post = 1"
                            . $non_admin_string1;
            //echo $get_events;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/intake_deid_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Assessment ID", "Participant_ID", "Pre or Post", "Date Logged");
            $get_questions = "SELECT Question FROM Baseline_Assessment_Questions ORDER BY In_Table";
            include "../include/dbconnopen.php";
            $all_questions = mysqli_query($cnnEnlace, $get_questions);
            while ($q = mysqli_fetch_row($all_questions)) {
                $title_array[] = $q[0];
            }

            $non_admin_string = "";
            $non_admin_string1 = "";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID
                                    INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID
                                    INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID";
                $non_admin_string1 = " AND Programs.Program_ID = " . $access . ";";
            }

            fputcsv($fp, $title_array);
            $get_events = "SELECT Assessment_ID, Assessments.Participant_ID, Assessments.Pre_Post, Assessments.Date_Logged, 
                            BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_T, BYS_E, 
                            JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_T, JVQ_E, JVQ_12, US_Born,
                            Check_In, Compliment, Crisis_Help, Know_You, KnowImportance, Pay_Attention, Personal_Advice,   Upset_Discussion,
                            Alive_Well, Finish_HS, Friends, Happy_Life, Interesting_Life, Manage_Work, Proud_Parents, Solve_Problems, Stay_Safe,
                            Anger_Mgmt, Coping, Cowardice, Handle_Others, Negotiation, Parent_Approval, Parent_Disapproval,
                            Self_Awareness, Self_Care, Self_Defense, Teasing_Prevention

                            FROM Assessments
                            LEFT JOIN Participants_Baseline_Assessments ON Baseline_Assessment_ID = Baseline_ID
                            LEFT JOIN Participants_Caring_Adults ON Caring_ID = Caring_Adults_ID
                            LEFT JOIN Participants_Future_Expectations ON Future_Id = Future_Expectations_ID
                            LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID = Interpersonal_Violence_ID
                            LEFT JOIN Participants ON Assessments.Participant_Id = Participants.Participant_ID"
                            . $non_admin_string
                            . " WHERE Assessments.Pre_Post = 1"
                            . $non_admin_string1;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>

    <tr>
        <td class="all_projects">
            All impact surveys.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/impact_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Assessment ID", "Participant ID", "First Name", "Last Name", "Pre or Post", "Date Logged");
            $get_questions = "SELECT Question FROM Baseline_Assessment_Questions WHERE In_Table!='Participants_Baseline_Assessments' ORDER BY In_Table";
            include "../include/dbconnopen.php";
            $all_questions = mysqli_query($cnnEnlace, $get_questions);
            while ($q = mysqli_fetch_row($all_questions)) {
                $title_array[] = $q[0];
            }
            fputcsv($fp, $title_array);

            $non_admin_string = "";
            $non_admin_string1 = "";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID
                                    INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID
                                    INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID";
                $non_admin_string1 = " AND Programs.Program_ID = " . $access . ";";
            }

            $get_events = "SELECT Assessment_ID, Assessments.Participant_ID, Participants.First_Name, Participants.Last_Name, Assessments.Pre_Post, Assessments.Date_Logged, 
                            Check_In, Compliment, Crisis_Help, Know_You, KnowImportance, Pay_Attention, Personal_Advice, Upset_Discussion,
                            Alive_Well, Finish_HS, Friends, Happy_Life, Interesting_Life, Manage_Work, Proud_Parents, Solve_Problems, Stay_Safe,
                            Anger_Mgmt, Coping, Cowardice, Handle_Others, Negotiation, Parent_Approval, Parent_Disapproval,
                            Self_Awareness, Self_Care, Self_Defense, Teasing_Prevention

                            FROM Assessments
                            LEFT JOIN Participants_Caring_Adults ON Caring_ID = Caring_Adults_ID
                            LEFT JOIN Participants_Future_Expectations ON Future_Id = Future_Expectations_ID
                            LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID = Interpersonal_Violence_ID
                            LEFT JOIN Participants ON Assessments.Participant_Id = Participants.Participant_ID"
                            . $non_admin_string
                            . " WHERE Assessments.Pre_Post = 2"
                            . $non_admin_string1;
                                        
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/deid_impact_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Assessment ID", "PArticipant ID", "Pre or Post", "Date Logged");
            $get_questions = "SELECT Question FROM Baseline_Assessment_Questions WHERE In_Table!='Participants_Baseline_Assessments' ORDER BY In_Table";
            include "../include/dbconnopen.php";
            $all_questions = mysqli_query($cnnEnlace, $get_questions);
            while ($q = mysqli_fetch_row($all_questions)) {
                $title_array[] = $q[0];
            }
            fputcsv($fp, $title_array);

            $non_admin_string = "";
            $non_admin_string1 = "";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID
                                    INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID
                                    INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID";
                $non_admin_string1 = " AND Programs.Program_ID = " . $access . ";";
            }

            $get_events = "SELECT Assessment_ID, Assessments.Participant_ID, Assessments.Pre_Post, Assessments.Date_Logged, 
                            Check_In, Compliment, Crisis_Help, Know_You, KnowImportance, Pay_Attention, Personal_Advice,   Upset_Discussion,
                            Alive_Well, Finish_HS, Friends, Happy_Life, Interesting_Life, Manage_Work, Proud_Parents, Solve_Problems, Stay_Safe,
                            Anger_Mgmt, Coping, Cowardice, Handle_Others, Negotiation, Parent_Approval, Parent_Disapproval,
                            Self_Awareness, Self_Care, Self_Defense, Teasing_Prevention
       
                            FROM Assessments
                            LEFT JOIN Participants_Caring_Adults ON Caring_ID = Caring_Adults_ID
                            LEFT JOIN Participants_Future_Expectations ON Future_Id = Future_Expectations_ID
                            LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID = Interpersonal_Violence_ID
                            LEFT JOIN Participants ON Assessments.Participant_Id = Participants.Participant_ID"
                            . $non_admin_string
                            . " WHERE Assessments.Pre_Post = 2"
                            . $non_admin_string1;
                                        
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            Participant consent records.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/consent_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant_ID", "First_Name", "Last_Name", "School_Year", "Consent_Given (1=Yes, 0=No)", "School");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Participants.Participant_ID IN "
                        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Participants_Consent.Participant_ID, First_Name, Last_Name, School_Year, Consent_Given, Institution_Name
                            FROM Participants_Consent
                            INNER JOIN Participants ON Participants.Participant_ID = Participants_Consent.Participant_ID
                            INNER JOIN Institutions ON School = Inst_ID"
                    . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/deid_consent_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant_ID", "School_Year", "Consent_Given (1=Yes, 0=No)", "School");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Participants.Participant_ID IN "
                        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Participants_Consent.Participant_ID, School_Year, 
                            Consent_Given, Institution_Name
                            FROM Participants_Consent
                            INNER JOIN Participants ON Participants.Participant_ID = Participants_Consent.Participant_ID
                            INNER JOIN Institutions ON School = Inst_ID";
                            //. $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>


    <tr>
        <td class="all_projects">
            Event attendance, with roles.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/event_attendance_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Event Name", "Event Date", "Participant ID", "First_Name", "Last_Name", "Role");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Participants.Participant_ID IN "
                        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Event_Name, Event_Date, Participants_Events.Participant_ID, First_Name, Last_Name, Event_Roles.Role
                            FROM Participants_Events
                            INNER JOIN Participants ON Participants.Participant_ID = Participants_Events.Participant_ID
                            INNER JOIN Event_Roles ON Role_Type = Event_Role_ID
                            INNER JOIN Campaigns_Events ON Event_ID = Campaign_Event_ID"
                    . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/deid_event_attendance_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Event ID", "Event Name", "Event Date", "Participant ID", "Role");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Participants.Participant_ID IN "
                        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Event_ID, Event_Name, Event_Date, Participants.Participant_ID, Event_Roles.Role
                            FROM Participants_Events
                            INNER JOIN Participants ON Participants.Participant_ID = Participants_Events.Participant_ID
                            INNER JOIN Event_Roles ON Role_Type = Event_Role_ID
                            INNER JOIN Campaigns_Events ON Event_ID = Campaign_Event_ID";
                            //. $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            Participant mentorship hours.
        </td>

        <td class="all_projects">
            <?php
            $infile = "export_container/mentorship_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "Mentorship Date", "Mentorship Hours", "First_Name", "Last_Name", "Program");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Participants.Participant_ID IN "
                        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Participant_ID, Mentorship_Date, Mentorship_Hours_Logged, First_Name, Last_Name, Name
                            FROM Participants_Mentorship
                            INNER JOIN Participants ON Participant_ID = Mentee_ID
                            INNER JOIN Programs ON Program_Id = Mentorship_Program"
                    . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>

        <td class="all_projects">
            <?php
            $infile = "export_container/deid_mentorship_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "Mentorship Date", "Mentorship Hours", "Program");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Participants.Participant_ID IN "
                        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Participant_ID, Mentorship_Date, Mentorship_Hours_Logged, Name
                            FROM Participants_Mentorship
                            INNER JOIN Participants ON Participant_ID = Mentee_ID
                            INNER JOIN Programs ON Program_Id = Mentorship_Program";
                            //. $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>


    <tr>
        <td class="all_projects">
            All programs.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/all_programs_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Program ID", "Program Name", "Host Organization ID", "Start Date", "End Date", "Start Hour", "Start am/pm", "End Hour", "End am/pm",
                "Maximum Hours", "Classwork?", "Clinic?", "Referrals?", "Community?", "Counseling?", "Sports?", "Mentorship?", "Service?",
                "Mondays?", "Tuesdays?", "Wednesdays?", "Thursdays?", "Fridays?", "Saturdays?", "Sundays?",
                "Host Institution Name");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Programs.Program_ID = " . $access . ";";
            }
            
            $get_events = "SELECT Programs.*, Institution_Name
                            FROM Programs
                            LEFT JOIN Institutions ON Host = Inst_ID"
                            . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            --- <!-- <a href="<?php echo $infile ?>">Download.</a> -->
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            Program participation (includes date dropped if applicable).
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/program_participation_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant_Program Link ID", "Participant ID", "First_Name", "Last_Name", "Session", "Program", "Date Dropped");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Programs.Program_ID = " . $access . ";";
                //$non_admin_string = " WHERE Participants.Participant_ID IN "
                //        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT DISTINCT Participant_Program_ID, Participants_Programs.Participant_ID, First_Name, Last_Name,
                            Session_Name, Name, Date_Dropped
                            FROM Participants_Programs
                            INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID
                            INNER JOIN Programs ON Session_Names.Program_Id = Programs.Program_ID
                            INNER JOIN Participants ON Participants_Programs.Participant_ID = Participants.Participant_ID"
                    . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/deid_program_participation_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant_Program Link ID", "Participant ID", "Session", "Program", "Date Dropped");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Programs.Program_ID = " . $access . ";";
                //$non_admin_string = " WHERE Participants.Participant_ID IN "
                //        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT DISTINCT Participant_Program_ID, Participants_Programs.Participant_ID, 
                            Session_Name, Name, Date_Dropped
                            FROM Participants_Programs
                            INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID
                            INNER JOIN Programs ON Session_Names.Program_Id = Programs.Program_ID
                            INNER JOIN Participants ON Participants_Programs.Participant_ID = Participants.Participant_ID"
                            . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
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
            <?php
            $infile = "export_container/attendance_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "First_Name", "Last_Name", "Date_Listed", "Session_Name", "Program", "Present (P) or Absent (A)");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            $non_admin_string1 = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Programs.Program_ID = " . $access . ";";
                $non_admin_string1 = " AND Programs.Program_ID = " . $access . ";";
                //$non_admin_string = " WHERE Participants.Participant_ID IN "
                //        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
                //$non_admin_string1 = " AND Participants.Participant_ID IN "
                //        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Participants.Participant_ID, First_Name, Last_Name, Date_Listed, Session_Name, Name
                            FROM Absences
                            INNER JOIN Participants ON Participants.Participant_ID = Absences.Participant_ID
                            INNER JOIN Program_Dates ON Program_Date = Program_Date_ID
                            INNER JOIN Session_Names ON Program_Dates.Program_ID = Session_ID
                            INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID"
                    . $non_admin_string;

            $get_present = "SELECT Participants_Programs.Participant_ID, First_Name, Last_Name,
                            Date_Listed, Session_Name, Name
                            FROM Participants_Programs
                            INNER JOIN Program_Dates ON Participants_Programs.Program_ID = Program_Dates.Program_ID
                            INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID
                            INNER JOIN Programs ON Session_Names.Program_Id = Programs.Program_ID
                            INNER JOIN Participants ON Participants_Programs.Participant_ID = Participants.Participant_ID
                            LEFT JOIN Absences ON (Program_Date_ID = Program_Date
                                AND Participants_Programs.Participant_ID = Absences.Participant_ID)
                            WHERE Absence_ID IS NULL"
                    . $non_admin_string1;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            $present_info = mysqli_query($cnnEnlace, $get_present);
            while ($event = mysqli_fetch_row($event_info)) {
                array_push($event, 'A');
                fputcsv($fp, $event);
            }
            while ($present = mysqli_fetch_row($present_info)) {
                array_push($present, 'P');
                fputcsv($fp, $present);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>

        <td class="all_projects">
            <?php
            $infile = "export_container/deidattendance_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "Date_Listed", "Session_Name", "Program", "Present (P) or Absent (A)");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            $non_admin_string1 = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Programs.Program_ID = " . $access . ";";
                $non_admin_string1 = " AND Programs.Program_ID = " . $access . ";";
                //$non_admin_string = " WHERE Participants.Participant_ID IN "
                //        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
                //$non_admin_string1 = " AND Participants.Participant_ID IN "
                //        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Participants.Participant_ID, Date_Listed, Session_Name, Name
                            FROM Absences
                            INNER JOIN Participants ON Participants.Participant_ID = Absences.Participant_ID
                            INNER JOIN Program_Dates ON Program_Date = Program_Date_ID
                            INNER JOIN Session_Names ON Program_Dates.Program_ID = Session_ID
                            INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID"
                            . $non_admin_string;

            $get_present = "SELECT Participants_Programs.Participant_ID, 
                            Date_Listed, Session_Name, Name FROM Participants_Programs
                            INNER JOIN Program_Dates ON Participants_Programs.Program_ID=Program_Dates.Program_ID
                            INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID
                            INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID
                            INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID
                            LEFT JOIN Absences ON ( Program_Date_ID=Program_Date AND Participants_Programs.Participant_ID=
                            Absences.Participant_ID) WHERE Absence_ID IS NULL"
                            . $non_admin_string1;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            $present_info = mysqli_query($cnnEnlace, $get_present);
            while ($event = mysqli_fetch_row($event_info)) {
                array_push($event, 'A');
                fputcsv($fp, $event);
            }
            while ($present = mysqli_fetch_row($present_info)) {
                array_push($present, 'P');
                fputcsv($fp, $present);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            Program surveys.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/program_surveys_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant_Program Link ID", "Program ID", "Question 1", "Question 2", "Question 3", "Question 4", "Question 5", "Question 6",
                "Question 7", "Question 8", "Question 9", "Question 10", "Question 11", "Question 12", "Question 13", "Question 14", "Question 15", "Question 16",
                "Date Added", "Session ID", "Session", "Program",);
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Programs.Program_ID = " . $access . ";";
            }

            $get_events = "SELECT Program_Surveys.*, Session_Name, Name
                            FROM Program_Surveys 
                            INNER JOIN Session_Names ON Program_Surveys.Session_ID = Session_Names.Session_ID
                            INNER JOIN Programs ON Programs.Program_ID = Session_Names.Program_ID"
                    . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr>
        <td class="all_projects">
            All sessions (by program).
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/sessions_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Session ID", "Session Name", "Program  ID", "Start Date", "End Date", "Survey Due Date", "Program");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE Programs.Program_ID = " . $access . ";";
            }

            $get_events = "SELECT Session_Names.*, Name
                            FROM Session_Names
                            INNER JOIN Programs ON Programs.Program_Id = Session_Names.Program_ID"
                    . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">---</td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            All referrals.
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/referrals_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Referral ID", "ID of referred person", "First name of referred person", "Last name of referred person",
                "Referrer First Name", "Referrer Last Name", "Referring Institution", "Referring Program", "Program referred to", "Date Logged");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE referrees.Participant_ID IN "
                        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Referral_ID, Referrals.Participant_ID, referrees.First_Name, referrees.Last_Name,
                            referrers.First_Name, referrers.Last_Name, Institution_Name, origin.Name, destination.Name, Referrals.Date_Logged
                            FROM Referrals 
                            LEFT JOIN Participants AS referrees ON Referrals.Participant_Id = referrees.Participant_ID
                            LEFT JOIN Participants AS referrers ON Referrals.Referrer_Person = referrers.Participant_ID
                            LEFT JOIN Institutions ON Referrer_Institution = Inst_ID
                            LEFT JOIN Programs as origin ON Referrer_Program = origin.Program_ID
                            LEFT JOIN Programs as destination ON Program_Referred = destination.Program_ID"
                    . $non_admin_string;
           // echo $get_events;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/deid_referrals_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Referral ID", "ID of referred person",
                "Referrer (person) ID", "Referring Institution", "Referring Program", "Program referred to", "Date Logged");
            fputcsv($fp, $title_array);

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                $non_admin_string = " WHERE referrees.Participant_ID IN "
                        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }

            $get_events = "SELECT Referral_ID, Referrals.Participant_ID, 
                            referrers.Participant_ID, Institution_Name, origin.Name, destination.Name, Referrals.Date_Logged
                            FROM Referrals 
                            LEFT JOIN Participants AS referrees ON Referrals.Participant_Id = referrees.Participant_ID
                            LEFT JOIN Participants AS referrers ON Referrals.Referrer_Person = referrers.Participant_ID
                            LEFT JOIN Institutions ON Referrer_Institution = Inst_ID
                            LEFT JOIN Programs as origin ON Referrer_Program = origin.Program_ID
                            LEFT JOIN Programs as destination ON Program_Referred = destination.Program_ID"
                            . $non_admin_string;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>

    <tr>
        <td class="all_projects">Participant dosages.</td>
        <td class="all_projects">
            <?php
            $infile = "export_container/dosage_" . date('m_d_Y') . ".csv";
            $deid_infile = "export_container/deid_dosage_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $deid_fp = fopen($deid_infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "First Name", "Last Name", "Program ID", "Program Name", "Session ID", "Session Name",
                "Number of days attended",
                "Sum of hours for this session", "Dosage percentage for this session");
            $deid_title_array = array("Participant ID", "Program ID", "Program Name", "Session ID", "Session Name",
                "Number of days attended",
                "Sum of hours for this session", "Dosage percentage for this session");
            fputcsv($fp, $title_array);
            fputcsv($deid_fp, $deid_title_array);
            include "../include/dosage_percentage.php";
            
            
            $non_admin_string = "";
            //if not an administrator
            if ($access != 'a') {
                //$non_admin_string = " AND Participants.Participant_ID IN "
                //        . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ")";
                $non_admin_string = " AND Programs.Program_ID = " . $access . " ";
            }

            $get_events = "SELECT Participants_Programs.Participant_ID, First_Name, Last_Name, Programs.Program_ID,
                            Name, Session_ID, Session_Name FROM Participants_Programs
                            INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID
                            INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID
                            INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID"
                    . $non_admin_string .
                    " GROUP BY Session_ID, Participants.Participant_ID;";
           /*equivalent to here*/
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            include "../include/dosage_percentage.php";
            while ($event = mysqli_fetch_row($event_info)) {
                $dosage=calculate_dosage($event[5], $event[0]);
                array_push($event, $dosage[0]);
                array_push($event, $dosage[1]);
                array_push($event, $dosage[2]);
                $deid_array=array($event[0], $event[3], $event[4], $event[5], $event[6], $dosage[0], $dosage[1], $dosage[2]);
                fputcsv($fp, $event);
                fputcsv($deid_fp, $deid_array);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            fclose($deid_fp)
            ?><a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            <a href="<?php echo $deid_infile ?>">Download.</a>
        </td>
    </tr>


    <tr>
        <td class="all_projects">New survey exports</td>
        <td class="all_projects">
            <!-- Users want to be able to pull pre and post surveys together in one line. -->
            <?php
            $infile = "export_container/all_surveys_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "First Name", "Last Name", "Session ID (of program)", "Session Name", "Program Name",
                "Home Language", "Ethnicity",
                "Race");
            $get_questions = "SELECT Question FROM Baseline_Assessment_Questions ORDER BY In_Table";
            include "../include/dbconnopen.php";
            $all_questions = mysqli_query($cnnEnlace, $get_questions);
            while ($q = mysqli_fetch_row($all_questions)) {
                $title_array[] = "Pre: " . $q[0];
            }
            $get_questions = "SELECT Question FROM Baseline_Assessment_Questions WHERE In_Table!='Participants_Baseline_Assessments' ORDER BY In_Table";
            include "../include/dbconnopen.php";
            $all_questions = mysqli_query($cnnEnlace, $get_questions);
            while ($q = mysqli_fetch_row($all_questions)) {
                $title_array[] = "Post: " . $q[0];
            }

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                //$non_admin_string = " AND Participants.Participant_ID IN "
                //                  . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
                $non_admin_string = " AND Programs.Program_ID = " . $access . ";";
            }

            fputcsv($fp, $title_array);
            $get_events = "SELECT  Pre_Assessments.Participant_ID, First_Name, Last_Name, Pre_Caring.Program, Session_Name, Name,
                            Home_Language, Ethnicity, Race, BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_T, BYS_E, 
                            JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_T, JVQ_E, JVQ_12, US_Born,

                            Pre_Caring.Check_In, Pre_Caring.Compliment, Pre_Caring.Crisis_Help, Pre_Caring.Know_You, 
                            Pre_Caring.KnowImportance, Pre_Caring.Pay_Attention, Pre_Caring.Personal_Advice, Pre_Caring.Upset_Discussion,

                            Pre_Future.Alive_Well, Pre_Future.Finish_HS, Pre_Future.Friends, Pre_Future.Happy_Life, 
                            Pre_Future.Interesting_Life, Pre_Future.Manage_Work, Pre_Future.Proud_Parents, Pre_Future.Solve_Problems, 
                            Pre_Future.Stay_Safe,

                            Pre_Violence.Anger_Mgmt, Pre_Violence.Coping, Pre_Violence.Cowardice, Pre_Violence.Handle_Others, 
                            Pre_Violence.Negotiation, Pre_Violence.Parent_Approval, Pre_Violence.Parent_Disapproval,
                            Pre_Violence.Self_Awareness, Pre_Violence.Self_Care, Pre_Violence.Self_Defense, 
                            Pre_Violence.Teasing_Prevention, 

                            Post_Caring.Check_In, Post_Caring.Compliment, Post_Caring.Crisis_Help, Post_Caring.Know_You, 
                            Post_Caring.KnowImportance, Post_Caring.Pay_Attention, Post_Caring.Personal_Advice, Post_Caring.Upset_Discussion,

                            Post_Future.Alive_Well, Post_Future.Finish_HS, Post_Future.Friends, Post_Future.Happy_Life, 
                            Post_Future.Interesting_Life, Post_Future.Manage_Work, Post_Future.Proud_Parents, Post_Future.Solve_Problems, 
                            Post_Future.Stay_Safe,

                            Post_Violence.Anger_Mgmt, Post_Violence.Coping, Post_Violence.Cowardice, Post_Violence.Handle_Others, 
                            Post_Violence.Negotiation, Post_Violence.Parent_Approval, Post_Violence.Parent_Disapproval,
                            Post_Violence.Self_Awareness, Post_Violence.Self_Care, Post_Violence.Self_Defense, 
                            Post_Violence.Teasing_Prevention

                            FROM Assessments AS Pre_Assessments
                            LEFT JOIN Assessments as Post_Assessments ON 
                            (Pre_Assessments.Participant_ID=Post_Assessments.Participant_ID AND Pre_Assessments.Assessment_ID!=Post_Assessments.Assessment_ID)
                            LEFT JOIN Participants_Baseline_Assessments ON
                            (Pre_Assessments.Baseline_ID=Baseline_Assessment_ID)
                            LEFT JOIN Participants_Caring_Adults AS Pre_Caring ON
                            (Pre_Caring.Caring_Adults_ID=Pre_Assessments.Caring_ID)
                            LEFT JOIN Participants_Caring_Adults AS Post_Caring ON
                            (Post_Caring.Caring_Adults_ID=Post_Assessments.Caring_ID)
                            LEFT JOIN Participants_Future_Expectations AS Pre_Future ON
                            (Pre_Future.Future_Expectations_ID=Pre_Assessments.Future_ID)
                            LEFT JOIN Participants_Future_Expectations AS Post_Future ON
                            (Post_Future.Future_Expectations_ID=Post_Assessments.Future_ID)
                            LEFT JOIN Participants_Interpersonal_Violence AS Pre_Violence ON
                            (Pre_Violence.Interpersonal_Violence_ID=Pre_Assessments.Violence_ID)
                            LEFT JOIN Participants_Interpersonal_Violence AS Post_Violence ON
                            (Post_Violence.Interpersonal_Violence_ID=Post_Assessments.Violence_ID)
                            LEFT JOIN Participants ON Pre_Assessments.Participant_ID=Participants.Participant_ID
                            LEFT JOIN Session_Names ON Pre_Caring.Program=Session_ID
                            LEFT JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID
                            WHERE  Pre_Assessments.Pre_Post=1 AND Post_Caring.Caring_Adults_ID IS NOT NULL
                            AND Post_Assessments.Pre_Post=2"
                            . $non_admin_string;
            //echo $get_events;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>

        <td class="all_projects">
            <!-- Users want to be able to pull pre and post surveys together in one line. -->
            <?php
            $infile = "export_container/deid_all_surveys_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "Session ID (of program)", "Home Language", "Ethnicity",
                "Race");
            $get_questions = "SELECT Question FROM Baseline_Assessment_Questions ORDER BY In_Table";
            include "../include/dbconnopen.php";
            $all_questions = mysqli_query($cnnEnlace, $get_questions);
            while ($q = mysqli_fetch_row($all_questions)) {
                $title_array[] = "Pre: " . $q[0];
            }
            $get_questions = "SELECT Question FROM Baseline_Assessment_Questions WHERE In_Table!='Participants_Baseline_Assessments' ORDER BY In_Table";
            include "../include/dbconnopen.php";
            $all_questions = mysqli_query($cnnEnlace, $get_questions);
            while ($q = mysqli_fetch_row($all_questions)) {
                $title_array[] = "Post: " . $q[0];
            }

            $non_admin_string = ";";
            //if not an administrator
            if ($access != 'a') {
                //$non_admin_string = " AND Participants.Participant_ID IN "
                //                  . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
                $non_admin_string = " AND Programs.Program_ID = " . $access . ";";
            }

            fputcsv($fp, $title_array);
            $get_events = "SELECT  Pre_Assessments.Participant_ID, Pre_Caring.Program, 
                            Home_Language, Ethnicity, Race, BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_T, BYS_E, 
                            JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_T, JVQ_E, JVQ_12, US_Born,

                            Pre_Caring.Check_In, Pre_Caring.Compliment, Pre_Caring.Crisis_Help, Pre_Caring.Know_You, 
                            Pre_Caring.KnowImportance, Pre_Caring.Pay_Attention, Pre_Caring.Personal_Advice, Pre_Caring.Upset_Discussion,

                            Pre_Future.Alive_Well, Pre_Future.Finish_HS, Pre_Future.Friends, Pre_Future.Happy_Life, 
                            Pre_Future.Interesting_Life, Pre_Future.Manage_Work, Pre_Future.Proud_Parents, Pre_Future.Solve_Problems, 
                            Pre_Future.Stay_Safe,


                            Pre_Violence.Anger_Mgmt, Pre_Violence.Coping, Pre_Violence.Cowardice, Pre_Violence.Handle_Others, 
                            Pre_Violence.Negotiation, Pre_Violence.Parent_Approval, Pre_Violence.Parent_Disapproval,
                            Pre_Violence.Self_Awareness, Pre_Violence.Self_Care, Pre_Violence.Self_Defense, 
                            Pre_Violence.Teasing_Prevention, 

                            Post_Caring.Check_In, Post_Caring.Compliment, Post_Caring.Crisis_Help, Post_Caring.Know_You, 
                            Post_Caring.KnowImportance, Post_Caring.Pay_Attention, Post_Caring.Personal_Advice, Post_Caring.Upset_Discussion,


                            Post_Future.Alive_Well, Post_Future.Finish_HS, Post_Future.Friends, Post_Future.Happy_Life, 
                            Post_Future.Interesting_Life, Post_Future.Manage_Work, Post_Future.Proud_Parents, Post_Future.Solve_Problems, 
                            Post_Future.Stay_Safe,

                            Post_Violence.Anger_Mgmt, Post_Violence.Coping, Post_Violence.Cowardice, Post_Violence.Handle_Others, 
                            Post_Violence.Negotiation, Post_Violence.Parent_Approval, Post_Violence.Parent_Disapproval,
                            Post_Violence.Self_Awareness, Post_Violence.Self_Care, Post_Violence.Self_Defense, 
                            Post_Violence.Teasing_Prevention


                            FROM Assessments AS Pre_Assessments
                            LEFT JOIN Assessments as Post_Assessments ON 
                            (Pre_Assessments.Participant_ID=Post_Assessments.Participant_ID AND Pre_Assessments.Assessment_ID!=Post_Assessments.Assessment_ID)
                            LEFT JOIN Participants_Baseline_Assessments ON
                            (Pre_Assessments.Baseline_ID=Baseline_Assessment_ID)
                            LEFT JOIN Participants_Caring_Adults AS Pre_Caring ON
                            (Pre_Caring.Caring_Adults_ID=Pre_Assessments.Caring_ID)
                            LEFT JOIN Participants_Caring_Adults AS Post_Caring ON
                            (Post_Caring.Caring_Adults_ID=Post_Assessments.Caring_ID)
                            LEFT JOIN Participants_Future_Expectations AS Pre_Future ON
                            (Pre_Future.Future_Expectations_ID=Pre_Assessments.Future_ID)
                            LEFT JOIN Participants_Future_Expectations AS Post_Future ON
                            (Post_Future.Future_Expectations_ID=Post_Assessments.Future_ID)
                            LEFT JOIN Participants_Interpersonal_Violence AS Pre_Violence ON
                            (Pre_Violence.Interpersonal_Violence_ID=Pre_Assessments.Violence_ID)
                            LEFT JOIN Participants_Interpersonal_Violence AS Post_Violence ON
                            (Post_Violence.Interpersonal_Violence_ID=Post_Assessments.Violence_ID)
                            LEFT JOIN Participants ON Pre_Assessments.Participant_ID=Participants.Participant_ID
                            LEFT JOIN Session_Names ON Pre_Caring.Program=Session_ID
                            LEFT JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID
                            
                            WHERE Pre_Assessments.Pre_Post=1 AND Post_Caring.Caring_Adults_ID IS NOT NULL
                            AND Post_Assessments.Pre_Post=2"
                            . $non_admin_string;
            //echo $get_events;
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?>
            <a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>
</table>
