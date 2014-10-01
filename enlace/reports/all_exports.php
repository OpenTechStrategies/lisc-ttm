<?php
include "../../header.php";
include "../header.php";
// include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
?>
<?php
//get user's access
//
// *First determine the program that the logged-in user has access to.  Usually this will be a program ID number,
// *but sometimes it will be 'a' (all) or 'n' (none).
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
$user_sqlsafe=mysqli_real_escape_string($cnnLISC, $_COOKIE['user']);
$get_program_access = "SELECT Program_Access FROM Users_Privileges INNER JOIN Users ON Users.User_Id = Users_Privileges.User_ID
    WHERE User_Email = '" .$user_sqlsafe . "'";
//echo $get_program_access;
$program_access = mysqli_query($cnnLISC, $get_program_access);
$prog_access = mysqli_fetch_row($program_access);
$access = $prog_access[0];
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>

<h3>Export All Information</h3>

<!--
Export files for all tables.  This is going to change once Taryn determines what she needs.
-->

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
                Download.</a></td>
        <td class="all_projects">---</td>
    </tr>


    <tr>
        <td class="all_projects">
            All campaigns.
        </td>
        <td class="all_projects">
               Download.</a></td>
        <td class="all_projects">--</td>
    </tr>


    <tr bgcolor="#cccccc">
        <td class="all_projects">
            All institutions.
        </td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_institutions">
                Download.</a></td>
        <td class="all_projects">
            <a href="/include/generalized_download_script.php?download_name=enlace_institutions">
                Download.</a></td>
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
                $non_admin_string = "WHERE Participants.Participant_ID IN "
                                    . "(SELECT Participant_ID FROM Participants_Programs WHERE Program_ID = " . $access . ");";
            }
            
            $get_events = "SELECT Participant_ID, First_Name, Last_Name, Day_Phone, Evening_Phone,
                            Participants.Address_Num, Participants.Address_Dir, 
                            Participants.Address_Street,
                            Participants.Address_Street_Type, Address_City, Address_State, Address_ZIP,
                            DOB, Age, Gender, Grade, Institution_Name, Roles.Role, Participants.Email
                            FROM Participants
                            LEFT JOIN Roles ON Participants.Role = Roles.Role_ID
                            LEFT JOIN Institutions ON School = Inst_ID"
                            . $non_admin_string;
            echo $get_events;
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
            <a href="/include/generalized_download_script.php?download_name=enlace_participants_deid">
                Download.</a>
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
            $get_events = "SELECT Assessment_ID, Assessments.Participant_ID, First_Name, Last_Name, Assessments.Pre_Post, Assessments.Date_Logged, 
        BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_T, BYS_E, 
        JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_T, JVQ_E, JVQ_12, US_Born,
         Check_In, Compliment, Crisis_Help, Know_You, KnowImportance, Pay_Attention, Personal_Advice,   Upset_Discussion,
         Alive_Well, Finish_HS, Friends, Happy_Life, Interesting_Life, Manage_Work, Proud_Parents, Solve_Problems, Stay_Safe,
        Anger_Mgmt, Coping, Cowardice, Handle_Others, Negotiation, Parent_Approval, Parent_Disapproval,
         Self_Awareness, Self_Care, Self_Defense, Teasing_Prevention
       
    FROM Assessments
    LEFT JOIN Participants_Baseline_Assessments ON Baseline_Assessment_ID=Baseline_ID
    LEFT JOIN Participants_Caring_Adults ON Caring_ID=Caring_Adults_ID
    LEFT JOIN Participants_Future_Expectations ON Future_Id=Future_Expectations_ID
    LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID=Interpersonal_Violence_ID
    LEFT JOIN Participants ON Assessments.Participant_Id=Participants.Participant_ID
    WHERE Assessments.Pre_Post=1;";
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

            fputcsv($fp, $title_array);
            $get_events = "SELECT Assessment_ID, Assessments.Participant_ID, Assessments.Pre_Post, Assessments.Date_Logged, 
        BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_T, BYS_E, 
        JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_T, JVQ_E, JVQ_12,  US_Born,
         Check_In, Compliment, Crisis_Help, Know_You, KnowImportance, Pay_Attention, Personal_Advice,   Upset_Discussion,
         Alive_Well, Finish_HS, Friends, Happy_Life, Interesting_Life, Manage_Work, Proud_Parents, Solve_Problems, Stay_Safe,
        Anger_Mgmt, Coping, Cowardice, Handle_Others, Negotiation, Parent_Approval, Parent_Disapproval,
         Self_Awareness, Self_Care, Self_Defense, Teasing_Prevention
       
    FROM Assessments
    LEFT JOIN Participants_Baseline_Assessments ON Baseline_Assessment_ID=Baseline_ID
    LEFT JOIN Participants_Caring_Adults ON Caring_ID=Caring_Adults_ID
    LEFT JOIN Participants_Future_Expectations ON Future_Id=Future_Expectations_ID
    LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID=Interpersonal_Violence_ID
    LEFT JOIN Participants ON Assessments.Participant_Id=Participants.Participant_ID
    WHERE Assessments.Pre_Post=1;";
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
            $get_events = "SELECT Assessment_ID, Assessments.Participant_ID, Participants.First_Name, Participants.Last_Name, Assessments.Pre_Post, Assessments.Date_Logged, 
        
         Check_In, Compliment, Crisis_Help, Know_You, KnowImportance, Pay_Attention, Personal_Advice,   Upset_Discussion,
         Alive_Well, Finish_HS, Friends, Happy_Life, Interesting_Life, Manage_Work, Proud_Parents, Solve_Problems, Stay_Safe,
        Anger_Mgmt, Coping, Cowardice, Handle_Others, Negotiation, Parent_Approval, Parent_Disapproval,
         Self_Awareness, Self_Care, Self_Defense, Teasing_Prevention
       
    FROM Assessments
    
    LEFT JOIN Participants_Caring_Adults ON Caring_ID=Caring_Adults_ID
    LEFT JOIN Participants_Future_Expectations ON Future_Id=Future_Expectations_ID
    LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID=Interpersonal_Violence_ID
    LEFT JOIN Participants ON Assessments.Participant_Id=Participants.Participant_ID
    WHERE Assessments.Pre_Post=2;";
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
            $title_array = array("Assessment ID", "Participant ID", "Pre or Post", "Date Logged");
            $get_questions = "SELECT Question FROM Baseline_Assessment_Questions WHERE In_Table!='Participants_Baseline_Assessments' ORDER BY In_Table";
            include "../include/dbconnopen.php";
            $all_questions = mysqli_query($cnnEnlace, $get_questions);
            while ($q = mysqli_fetch_row($all_questions)) {
                $title_array[] = $q[0];
            }
            fputcsv($fp, $title_array);
            $get_events = "SELECT Assessment_ID, Assessments.Participant_ID, Assessments.Pre_Post, Assessments.Date_Logged, 
        
         Check_In, Compliment, Crisis_Help, Know_You, KnowImportance, Pay_Attention, Personal_Advice,   Upset_Discussion,
         Alive_Well, Finish_HS, Friends, Happy_Life, Interesting_Life, Manage_Work, Proud_Parents, Solve_Problems, Stay_Safe,
        Anger_Mgmt, Coping, Cowardice, Handle_Others, Negotiation, Parent_Approval, Parent_Disapproval,
         Self_Awareness, Self_Care, Self_Defense, Teasing_Prevention
       
    FROM Assessments
    
    LEFT JOIN Participants_Caring_Adults ON Caring_ID=Caring_Adults_ID
    LEFT JOIN Participants_Future_Expectations ON Future_Id=Future_Expectations_ID
    LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID=Interpersonal_Violence_ID
    LEFT JOIN Participants ON Assessments.Participant_Id=Participants.Participant_ID
    WHERE Assessments.Pre_Post=2;";
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
                Download.</a>
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
            <a href="/include/generalized_download_script.php?download_name=enlace_program_participation">                Download.</a>
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
            <?php
            $infile = "export_container/dosage_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "First Name", "Last Name", "Program ID", "Program Name", "Session ID", "Session Name",
                "Number of days attended",
                "Sum of hours for this session", "Dosage percentage for this session"); //"Total hours across sessions and programs", "Total hours including mentorship"
            fputcsv($fp, $title_array);
            $get_events = "SELECT Participants_Programs.Participant_ID, First_Name, Last_Name, Programs.Program_ID,
             Name, Session_ID, Session_Name, COUNT(Program_Date_ID) FROM Participants_Programs
            INNER JOIN Program_Dates ON Participants_Programs.Program_ID=Program_Dates.Program_ID
            INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID
            INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID
            INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID
            LEFT JOIN Absences ON ( Program_Date_ID=Program_Date AND Participants_Programs.Participant_ID=
            Absences.Participant_ID) WHERE Absence_ID IS NULL
            GROUP BY Session_ID, Participants.Participant_ID;";
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                //this should hold the max hours.
                $get_program_times = "SELECT * FROM Programs WHERE Program_ID=$event[3]";
                $program_times = mysqli_query($cnnEnlace, $get_program_times);
                $program_info = mysqli_fetch_array($program_times);
                if ($program_info['Start_Suffix'] == 'am') {
                    $begin = $program_info['Start_Hour'];
                } elseif ($program_info['Start_Suffix'] == 'pm') {
                    $begin = $program_info['Start_Hour'] + 12;
                } else {
                    $begin = 0;
                }
                if ($program_info['End_Suffix'] == 'am') {
                    $finish = $program_info['End_Hour'];
                } elseif ($program_info['End_Suffix'] == 'pm') {
                    $finish = $program_info['End_Hour'] + 12;
                } else {
                    $finish = 0;
                }
                $daily_hrs = (($finish) - ($begin));
                // echo $daily_hrs . "&nbsp";
                if ($program_info['Max_Hours'] != '') {
                    $max_hrs = $program_info['Max_Hours'];
                } else {
                    $max_hrs = ($daily_hrs);
                }
                // echo $max_hrs . "<br>";
                $total_hrs = $max_hrs * $event[7];
                array_push($event, $total_hrs);
                $get_max_days = "SELECT COUNT(*) FROM Program_Dates WHERE Program_ID=$event[5]";
                //echo $get_max_days . "<bR>";
                $max_days = mysqli_query($cnnEnlace, $get_max_days);
                $max = mysqli_fetch_row($max_days);
                if ($max[0] != 0) {
                    $percentage = number_format(($event[7] / $max[0]) * 100, 2) . '%';
                } else {
                    $percentage = 'N/A';
                }
                array_push($event, $percentage);
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?><a href="<?php echo $infile ?>">Download.</a>
        </td>
        <td class="all_projects">
            <?php
            $infile = "export_container/deid_dosage_" . date('m_d_Y') . ".csv";
            $fp = fopen($infile, "w") or die('can\'t open file');
            $title_array = array("Participant ID", "Program ID", "Program Name", "Session ID", "Session Name",
                "Number of days attended",
                "Sum of hours for this session", "Dosage percentage for this session"); //"Total hours across sessions and programs", "Total hours including mentorship"
            fputcsv($fp, $title_array);
            $get_events = "SELECT Participants_Programs.Participant_ID, Programs.Program_ID,
             Name, Session_ID, Session_Name, COUNT(Program_Date_ID) FROM Participants_Programs
            INNER JOIN Program_Dates ON Participants_Programs.Program_ID=Program_Dates.Program_ID
            INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID
            INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID
            INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID
            LEFT JOIN Absences ON ( Program_Date_ID=Program_Date AND Participants_Programs.Participant_ID=
            Absences.Participant_ID) WHERE Absence_ID IS NULL
            GROUP BY Session_ID, Participants.Participant_ID;";
            include "../include/dbconnopen.php";
            $event_info = mysqli_query($cnnEnlace, $get_events);
            while ($event = mysqli_fetch_row($event_info)) {
                //this should hold the max hours.
                $get_program_times = "SELECT * FROM Programs WHERE Program_ID=$event[3]";
                $program_times = mysqli_query($cnnEnlace, $get_program_times);
                $program_info = mysqli_fetch_array($program_times);
                if ($program_info['Start_Suffix'] == 'am') {
                    $begin = $program_info['Start_Hour'];
                } elseif ($program_info['Start_Suffix'] == 'pm') {
                    $begin = $program_info['Start_Hour'] + 12;
                } else {
                    $begin = 0;
                }
                if ($program_info['End_Suffix'] == 'am') {
                    $finish = $program_info['End_Hour'];
                } elseif ($program_info['End_Suffix'] == 'pm') {
                    $finish = $program_info['End_Hour'] + 12;
                } else {
                    $finish = 0;
                }
                $daily_hrs = (($finish) - ($begin));
                // echo $daily_hrs . "&nbsp";
                if ($program_info['Max_Hours'] != '') {
                    $max_hrs = $program_info['Max_Hours'];
                } else {
                    $max_hrs = ($daily_hrs);
                }
                // echo $max_hrs . "<br>";
                $total_hrs = $max_hrs * $event[7];
                array_push($event, $total_hrs);
                $get_max_days = "SELECT COUNT(*) FROM Program_Dates WHERE Program_ID=$event[3]";
                //echo $get_max_days . "<bR>";
                $max_days = mysqli_query($cnnEnlace, $get_max_days);
                $max = mysqli_fetch_row($max_days);
                if ($max[0] != 0) {
                    $percentage = number_format(($event[7] / $max[0]) * 100, 2) . '%';
                } else {
                    $percentage = 'N/A';
                }
                array_push($event, $percentage);
                fputcsv($fp, $event);
            }
            include "../include/dbconnclose.php";
            fclose($fp);
            ?><a href="<?php echo $infile ?>">Download.</a>
        </td>
    </tr>
</table>
