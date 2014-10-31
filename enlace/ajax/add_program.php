<?php
require_once("../siteconfig.php");
?>
<?php
/* make a new program: */
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['name']);
$host_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['host']);
$create_program = "INSERT INTO Programs (Name, Host) VALUES ('" . $name_sqlsafe . "', '" . $host_sqlsafe . "')";
mysqli_query($cnnEnlace, $create_program);
$id = mysqli_insert_id($cnnEnlace);

date_default_timezone_set('America/Chicago');
$end_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['end']);
$session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['session']);
$start_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['start']);
$end_session = new DateTime($_POST['end']);
$survey_date = $end_session->sub(new DateInterval('P7D'));
$survey_date = $survey_date->format('Y-m-d');

/* make a new session, because every program has to have a session. */
$create_session = "INSERT INTO Session_Names (Session_Name, Program_ID, Start_Date, End_Date, Survey_Due) VALUES ('" . $session_sqlsafe . "',
            $id, '" . $start_sqlsafe . "', '" . $end_sqlsafe . "', '" . $survey_date . "' )";
mysqli_query($cnnEnlace, $create_session);
include "../include/dbconnclose.php";
?>

<br/>
<span style="color:#990000; font-weight:bold;">Thank you for adding <?php echo $_POST['name']; ?> to the database.</span><br/>
<a href="javascript:;" onclick="$.post(
                '../ajax/set_program_id.php',
                {
                    page: 'profile',
                    id: '<?echo $id;?>'
                },
        function(response) {
            window.location = 'profile.php';
        }
        )" class="helptext">View profile</a>
