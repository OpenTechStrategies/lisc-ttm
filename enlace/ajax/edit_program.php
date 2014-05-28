<?php
/* all edits to programs */

/* adding a new program session */
if ($_POST['action'] == 'new_session') {
    date_default_timezone_set('America/Chicago');
    $end_session = new DateTime($_POST['end']);
    $survey_date = $end_session->sub(new DateInterval('P7D'));
    $survey_date = $survey_date->format('Y-m-d');
    $new_session = "INSERT INTO Session_Names (Session_Name, Program_ID, Start_Date, End_Date, Survey_Due) VALUES ('" . $_POST['session'] . "', 
        '" . $_POST['program'] . "', '" . $_POST['start'] . "', '" . $_POST['end'] . "', '" . $survey_date . "')";
    echo $new_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $new_session);
    include "../include/dbconnclose.php";
}
/* checking for a duplicate session before adding the new session (does a session with this name
 * already exist?)
 */ elseif ($_POST['action'] == 'deduplicate_sessions') {
    $check_session = "SELECT * FROM Session_Names WHERE Program_ID='" . $_POST['program'] . "' AND Session_Name='" . $_POST['name'] . "'";
    //echo $check_session;
    include "../include/dbconnopen.php";
    $sessh = mysqli_query($cnnEnlace, $check_session);
    echo mysqli_num_rows($sessh);
    include "../include/dbconnclose.php";
}
/* change a session name: */ elseif ($_POST['action'] == 'edit_session') {
    $edit_session = "UPDATE Session_Names SET Session_Name='" . $_POST['new_name'] . "' WHERE Session_ID='" . $_POST['id'] . "'";
    echo $edit_session;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $edit_session);
    include "../include/dbconnclose.php";
}
/* get all the existing sessions for a dropdown. */ elseif ($_POST['action'] == 'find_sessions') {
    $get_sessions = "SELECT * FROM Session_Names WHERE Program_Id='" . $_POST['program'] . "'";
    include "../include/dbconnopen.php";
    $sessions = mysqli_query($cnnEnlace, $get_sessions);
    ?>
    <span class="helptext">Choose session:</span><br>
    <select id="choose_session_new">
        <option value="">----</option>
    <?php
    while ($sess = mysqli_fetch_row($sessions)) {
        ?>
            <option value="<?php echo $sess[0] ?>"><?php echo $sess[1]; ?></option>
            <?php
        }
        ?>
    </select>
        <?php
        include "../include/dbconnclose.php";
    }
    /* finally, maybe we just want to edit the program. */ else {
        $program_update = "UPDATE Programs SET 
    Name='" . $_POST['name'] . "',
        Host='" . $_POST['host'] . "',
        Start_Date='" . $_POST['start'] . "',
        End_Date='" . $_POST['end'] . "',
        Start_Hour='" . $_POST['begin'] . "',
        End_Hour='" . $_POST['finish'] . "',
        Start_Suffix='" . $_POST['begin_am'] . "',
        End_Suffix='" . $_POST['finish_am'] . "',
        Max_Hours='" . $_POST['hrs'] . "',
            Activity_Class='" . $_POST['act_class'] . "',
            Activity_Clinic='" . $_POST['mental'] . "',
            Activity_Referrals='" . $_POST['referral'] . "',
            Activity_Community='" . $_POST['community'] . "',
            Activity_Counseling='" . $_POST['counseling'] . "',
            Activity_Sports='" . $_POST['sports'] . "',
            Activity_Mentor='" . $_POST['mentoring'] . "',
            Activity_Service='" . $_POST['service'] . "',
            Monday='" . $_POST['mon'] . "',
            Tuesday='" . $_POST['tue'] . "',
            Wednesday='" . $_POST['wed'] . "',
            Thursday='" . $_POST['thur'] . "',
            Friday='" . $_POST['fri'] . "',
            Saturday='" . $_POST['sat'] . "',
            Sunday='" . $_POST['sun'] . "'
            WHERE Program_ID='" . $_POST['id'] . "'";
        echo $program_update;
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $program_update);
        include "../include/dbconnclose.php";
    }
    ?>
