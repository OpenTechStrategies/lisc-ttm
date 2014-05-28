<?php
//if action is logout, kill various navigation cookies: 
if ($_GET['action'] == 'logout') {
    //kill cookie
    setcookie('user', '', time() - 3600, '/');
    setcookie('sites', '', time() - 3600, '/');
    setcookie('page', '', time() - 3600, '/');
    setcookie('category', '', time() - 3600, '/');
    setcookie('participant', '', time() - 3600, '/');
    setcookie('program', '', time() - 3600, '/');
    setcookie('prog_page', '', time() - 3600, '/');
    //setcookie('session_id', '', time() - 3600, '/');
    //redirect
    header('Location: /index.php');
}

include "../header.php";
include "header.php";
?>

<div class="content">
    <h3 id="enlace_welcome">Welcome to the Little Village Testing the Model Data Center!</h3><hr/><br/>
    <div class="content_area">
        <table style="width:70%;margin-left:auto;margin-right:auto;">
            <tr><td colspan="3"><h4>Alerts</h4></td></tr>
            <tr>
                <td style="vertical-align:top;"><strong><u>Upcoming Program Quality Surveys Due:</u></strong><br>
                    <?php
////get session survey due dates that are within a week of now:
//shows alerts for overdue surveys (program quality and intake)

                    date_default_timezone_set('America/Chicago');
                    $next_week = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 7, date('Y')));
//echo $next_week;
                    $get_sessions = "SELECT Session_Name, Name, MONTH(Survey_Due), DAY(Survey_Due), YEAR(Survey_Due) FROM Session_Names INNER JOIN Programs ON Programs.Program_ID=Session_Names.Program_ID
        WHERE Survey_Due >= '" . date('Y-m-d') . "' AND Survey_Due <= '$next_week'";
//echo $get_sessions;
                    include "include/dbconnopen.php";
                    $sessions = mysqli_query($cnnEnlace, $get_sessions);
                    while ($sesh = mysqli_fetch_row($sessions)) {
                        echo "<strong>" . $sesh[1] . ": " . $sesh[0] . " --</strong> Due: " . $sesh[2] . '/' . $sesh[3] . '/' . $sesh[4] . '<br>';
                    }
                    include "include/dbconnclose.php";
                    ?></td>
                <td style="vertical-align:top;"><strong><u>Intake Surveys Due:</u></strong><br>
                    <?php
                    $month_ago = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 30, date('Y')));
//echo $month_ago;
                    $get_missing_intakes = "SELECT First_Name, Last_Name, MONTH(Date_Entered), DAY(Date_Entered), YEAR(Date_Entered), Participants.Participant_ID FROM Participants 
LEFT JOIN Participants_Baseline_Assessments ON Participants.Participant_ID =
Participants_Baseline_Assessments.Participant_ID
WHERE Date_Entered <= '$month_ago' AND Date_Logged IS NULL AND Role=1";
//echo $get_missing_intakes;
                    include "include/dbconnopen.php";
                    $missing_intakes = mysqli_query($cnnEnlace, $get_missing_intakes);
                    ?>
                    <table class="alert_table">
                        <?php
                    while ($intake = mysqli_fetch_row($missing_intakes)) {
                        ?>
                        <tr><td><a href='participants/participant_profile.php?id=<?php echo $intake[5];?>'><strong> <?php echo $intake[0] . " " . $intake[1];?></strong></a></td>
                            <td>Due: <?php echo ($intake[2] + 1) . '/' . $intake[3] . '/' . $intake[4];?></td>
                            <td><?php 
                            $get_all_programs = "SELECT Session_Names.*, Name FROM Session_Names INNER JOIN Participants_Programs ON 
                Session_Names.Session_ID=Participants_Programs.Program_ID 
                INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID
                WHERE Participant_Id='$intake[5]' ORDER BY Name";
                //echo $get_all_programs;
                include "../include/dbconnopen.php";
                $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
                while ($program = mysqli_fetch_row($all_programs)) {
                    ?><a href="javascript:;" onclick="$.post(
                                        '../ajax/set_program_id.php',
                                        {
                                            page: 'profile',
                                            id: '<?php echo $program[2]; ?>'
                                        },
                                function(response) {
                                    window.location = '/enlace/programs/profile.php';
                                }
                                )"><?php echo $program[6] . ' - ' . $program[1]; ?></a><br><?php
                   }
                   include "../include/dbconnclose.php";
                   ?>
                            </td></tr>
                        <?php
                    }
                    ?></table> <?php
                    include "include/dbconnclose.php";
                    ?></td>
                <?php
                /*
                <td style="vertical-align:top;">

                    <!--They want to check the people entered by partners, in case of errors: -->
                    <strong>New Participants:</strong>
                    <p><?php
                    //get today
                    $today = date('Y-m-d');
                    $today_datetime = new DateTime($today);
                    $three_days_ago = $today_datetime->sub(new DateInterval('P3D'));
                    //get participants added in the last 72 hours
                    $get_new_people = "SELECT Participant_ID, First_Name, Last_Name FROM Participants WHERE Date_Entered>='" . $three_days_ago->format('Y-m-d')
                            . "' ORDER BY Last_Name";
                    //echo $get_new_people;
                    include "include/dbconnopen.php";
                    $new_people = mysqli_query($cnnEnlace, $get_new_people);
                    while ($new_p = mysqli_fetch_row($new_people)) {
                        echo $new_p[1] . " " . $new_p[2];
                    }
                    ?></p>
                    <strong>Participants added to programs:</strong><p>
                        <?php
                        //get participants added to programs in the last 72 hours
                        $get_new_links = "SELECT Participants_Programs.Date_Added, Participants.Participant_ID,
                        First_Name, Last_Name, Programs.Program_ID, Name FROM Participants_Programs
                        INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID
                        INNER JOIN Programs ON Participants_Programs.Program_Id=Programs.Program_ID 
                        WHERE Date_Added>='" . $three_days_ago->format('Y-m-d')
                                . "' ORDER BY Last_Name";
                        //echo $get_new_links;
                        include "include/dbconnopen.php";
                        $new_links = mysqli_query($cnnEnlace, $get_new_links);
                        while ($link = mysqli_fetch_row($new_links)) {
                            echo $link[0] . ": " . $link[2] . " " . $link[3] . " " . $link[5];
                        }
                        ?>
                    </p>
                </td>
                 */
                ?>
            </tr>
        </table>
        <p></p>
    </div>
</div>

<?php include "../footer.php"; ?>
