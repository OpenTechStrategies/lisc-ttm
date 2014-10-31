<?php
require_once("../siteconfig.php");
?>
<?php
/* all edits to programs */

/* adding a new program session */
if ($_POST['action'] == 'new_session') {
    include "../include/dbconnopen.php";
    $end_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['end']);
    $program_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['program']);
    $start_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['start']);
    date_default_timezone_set('America/Chicago');
    $end_session = new DateTime($end_sqlsafe);
    $survey_date = $end_session->sub(new DateInterval('P7D'));
    $survey_date = $survey_date->format('Y-m-d');
    $new_session = "INSERT INTO Session_Names (Session_Name, Program_ID, Start_Date, End_Date, Survey_Due) VALUES ('" . $_POST['session'] . "', 
        '" . $program_sqlsafe . "', '" . $start_sqlsafe . "', '" . $end_sqlsafe . "', '" . $survey_date . "')";
    echo $new_session;
    mysqli_query($cnnEnlace, $new_session);
    include "../include/dbconnclose.php";
}
/* checking for a duplicate session before adding the new session (does a session with this name
 * already exist?)
 */ elseif ($_POST['action'] == 'deduplicate_sessions') {
    include "../include/dbconnopen.php";
    $program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program']);
    $name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['name']);
    $check_session = "SELECT * FROM Session_Names WHERE Program_ID='" . $program_sqlsafe . "' AND Session_Name='" . $name_sqlsafe . "'";
    //echo $check_session;
    $sessh = mysqli_query($cnnEnlace, $check_session);
    echo mysqli_num_rows($sessh);
    include "../include/dbconnclose.php";
}
/* change a session name: */ elseif ($_POST['action'] == 'edit_session') {
    include "../include/dbconnopen.php";
    $new_name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['new_name']);
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
    $edit_session = "UPDATE Session_Names SET Session_Name='" . $_POST['new_name'] . "' WHERE Session_ID='" . $_POST['id'] . "'";
    echo $edit_session;
    mysqli_query($cnnEnlace, $edit_session);
    include "../include/dbconnclose.php";
}
/* get all the existing sessions for a dropdown. */ 
elseif ($_POST['action'] == 'find_sessions') {
    include "../include/dbconnopen.php";
    $program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program']);
    $get_sessions = "SELECT * FROM Session_Names WHERE Program_Id='" . $_POST['program'] . "'";
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
        
        include "../include/dbconnopen.php";
        $name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['name']);
        $host_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['host']);
        $start_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['start']);
        $end_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['end']);
        $begin_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['begin']);
        $finish_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['finish']);
        $begin_am_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['begin_am']);
        $finish_am_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['finish_am']);
        $hrs_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['hrs']);
        $act_class_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['act_class']);
        $mental_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['mental']);
        $referral_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['referral']);
        $community_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['community']);
        $counseling_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['counseling']);
        $sports_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['sports']);
        $mentoring_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['mentoring']);
        $service_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['service']);
        $mon_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['mon']);
        $tue_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['tue']);
        $wed_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['wed']);
        $thur_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['thur']);
        $fri_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['fri']);
        $sat_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['sat']);
        $sun_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['sun']);
        $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
        $program_update = "UPDATE Programs SET 
    Name='" . $name_sqlsafe . "',
        Host='" . $host_sqlsafe . "',
        Start_Date='" . $start_sqlsafe . "',
        End_Date='" . $end_sqlsafe . "',
        Start_Hour='" . $begin_sqlsafe . "',
        End_Hour='" . $finish_sqlsafe . "',
        Start_Suffix='" . $begin_am_sqlsafe . "',
        End_Suffix='" . $finish_am_sqlsafe . "',
        Max_Hours='" . $hrs_sqlsafe . "',
            Activity_Class='" . $act_class_sqlsafe . "',
            Activity_Clinic='" . $mental_sqlsafe . "',
            Activity_Referrals='" . $referral_sqlsafe . "',
            Activity_Community='" . $community_sqlsafe . "',
            Activity_Counseling='" . $counseling_sqlsafe . "',
            Activity_Sports='" . $sports_sqlsafe . "',
            Activity_Mentor='" . $mentoring_sqlsafe . "',
            Activity_Service='" . $service_sqlsafe . "',
            Monday='" . $mon_sqlsafe . "',
            Tuesday='" . $tue_sqlsafe . "',
            Wednesday='" . $wed_sqlsafe . "',
            Thursday='" . $thur_sqlsafe . "',
            Friday='" . $fri_sqlsafe . "',
            Saturday='" . $sat_sqlsafe . "',
            Sunday='" . $sun_sqlsafe . "'
            WHERE Program_ID='" . $id_sqlsafe . "'";
        echo $program_update;
        mysqli_query($cnnEnlace, $program_update);
        include "../include/dbconnclose.php";
    }
    ?>
