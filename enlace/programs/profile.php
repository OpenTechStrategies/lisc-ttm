<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($Enlace_id, $ReadOnlyAccess, $_COOKIE['program']);

include "../../header.php";
include "../header.php";
include "../classes/program.php";
require_once("../classes/assessment.php");
$program = new Program();
$program->load_with_program_id($_COOKIE['program']);


?>
<!--
Shows all program information.
-->

<div style="display:none;">
    <?php include "../include/datepicker_wtw.php"; ?></div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#programs_selector').addClass('selected');
        $('.edit_program').hide();
        $('#add_participant_button').hide();
        $('#search_parti_table').hide();
        $('.hide_dates').hide();
        $('.add_new_person_to_session').hide();
    });</script>

<div class="content_block">
    <h3>Program Profile: <?php echo $program->name; ?></h3><hr/><br/>

    <table class="profile_table"><tr><td width="35%">

                <!--Basic information: -->
                <table class="inner_table" style="border: 2px solid #696969;">
                    <tr>
                        <td><strong>Program Name:</strong></td>
                        <td><input type="text" value="<?php echo $program->name; ?>" class="edit_program" id="program_name_edit">
                            <span class="display_program"><?php echo $program->name; ?></span></td>
                    </tr>
                    <tr><td><strong>Host Organization:</strong></td><td><span class="display_program"><a href="/enlace/institutions/inst_profile.php?inst=<?php echo $program->instid; ?>"><?php echo $program->host; ?></a></span>
                            <select id="hosting_org" class="edit_program" value="<?php echo $program->host; ?>">
                                <option value="">----------</option>
                                <?php
                                $get_institutions = "SELECT * FROM Institutions ORDER BY Institution_Name";
                                include "../include/dbconnopen.php";
                                $institutions = mysqli_query($cnnEnlace, $get_institutions);
                                while ($inst = mysqli_fetch_array($institutions)) {
                                    ?>
                                    <option value="<?php echo $inst['Inst_ID']; ?>" <?php echo($inst['Inst_ID'] == $program->instid ? "selected='selected'" : null); ?>><?php echo $inst['Institution_Name']; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select>
                        </td></tr>
                    <tr><td><strong>Activities:</strong></td><td>
                            <!--The "mentorship hours" section only shows up if "Mentorship" is checked below.-->
                            <div class="display_program">
                                <?php
                                if ($program->class_act == 1) {
                                    echo "Classroom Activities<br/>";
                                }
                                if ($program->clinic == 1) {
                                    echo "Mental Health Clinic<br/>";
                                }
                                if ($program->referrals == 1) {
                                    echo "Referrals to mental health counseling<br/>";
                                }
                                if ($program->community == 1) {
                                    echo "Community building<br/>";
                                }
                                if ($program->counseling == 1) {
                                    echo "Counseling<br/>";
                                }
                                if ($program->sport == 1) {
                                    echo "Sports and play<br/>";
                                }
                                if ($program->mentor == 1) {
                                    echo "Mentorship<br/>";
                                }
                                if ($program->service == 1) {
                                    echo "Community Service";
                                }
                                ?>
                            </div>
                            <div class="edit_program"><input type="checkbox" id="class" <?php echo($program->class_act == 1 ? "checked=true" : null); ?>>Classroom Activities<br>
                                <input type="checkbox" id="mental" <?php echo($program->clinic == 1 ? "checked=true" : null); ?>>Mental Health Clinic<br>
                                <input type="checkbox" id="referrals"  <?php echo($program->referrals == 1 ? "checked=true" : null); ?>>Referrals to mental health counseling<br>
                                <input type="checkbox" id="community"  <?php echo($program->community == 1 ? "checked=true" : null); ?>> Community building <br>
                                <input type="checkbox" id="counseling"  <?php echo($program->counseling == 1 ? "checked=true" : null); ?>> Counseling <br>
                                <input type="checkbox" id="sport"  <?php echo($program->sport == 1 ? "checked=true" : null); ?>> Sports and play <br>
                                <input type="checkbox" id="mentors" <?php echo($program->mentor == 1 ? "checked=true" : null); ?>> Mentorship <br>
                                <input type="checkbox" id="service"  <?php echo($program->service == 1 ? "checked=true" : null); ?>> Community Service <br></div>
                        </td></tr>


                    <tr><td><strong>Days per week:</strong></td><td>
                            <div class="display_program">
                                <?php
                                if ($program->monday == 1) {
                                    echo "Monday<br/>";
                                }
                                if ($program->tuesday == 1) {
                                    echo "Tuesday<br/>";
                                }
                                if ($program->wednesday == 1) {
                                    echo "Wednesday<br/>";
                                }
                                if ($program->thursday == 1) {
                                    echo "Thursday<br/>";
                                }
                                if ($program->friday == 1) {
                                    echo "Friday<br/>";
                                }
                                if ($program->saturday == 1) {
                                    echo "Saturday<br/>";
                                }
                                if ($program->sunday == 1) {
                                    echo "Sunday<br/>";
                                }
                                ?>
                            </div>
                            <div class="edit_program"><input type="checkbox" id="mon"  <?php echo($program->monday == 1 ? "checked=true" : null); ?>> Monday <br>
                                <input type="checkbox" id="tues" <?php echo($program->tuesday == 1 ? "checked=true" : null); ?>> Tuesday <br>
                                <input type="checkbox" id="weds" <?php echo($program->wednesday == 1 ? "checked=true" : null); ?>> Wednesday <br>
                                <input type="checkbox" id="thurs" <?php echo($program->thursday == 1 ? "checked=true" : null); ?>> Thursday <br>
                                <input type="checkbox" id="fri" <?php echo($program->friday == 1 ? "checked=true" : null); ?>> Friday <br>
                                <input type="checkbox" id="sat"  <?php echo($program->saturday == 1 ? "checked=true" : null); ?>> Saturday <br>
                                <input type="checkbox" id="sun" <?php echo($program->sunday == 1 ? "checked=true" : null); ?>> Sunday <br></div>
                        </td></tr>

                    <!--Start and end times are used to calculate maximum hours (if necessary) to show total dosage.-->
                    <tr><td><strong>Daily start time:</strong></td><td><span class="display_program"><?php echo $program->begin; ?></span>
			    <?php $program_begin_option= '0';
				  $program_begin_am='';
				  if($program->begin != '0') {
				  	list($program_begin_option, $program_begin_am) = preg_split(' /\s+/',$program->begin);}?>
                            <select id="start_hour" class="edit_program">
			        <option value="-----" <?php if($program_begin_option == '0') echo 'selected="selected"'; ?>>-----</option>
                                <option value="1" <?php if($program_begin_option == '1') echo 'selected="selected'; ?>>1</option>
                                <option value="2" <?php if($program_begin_option == '2') echo 'selected="selected"'; ?>>2</option>
                                <option value="3" <?php if($program_begin_option == '3') echo 'selected="selected"'; ?>>3</option>
                                <option value="4" <?php if($program_begin_option == '4') echo 'selected="selected"'; ?>>4</option>
                                <option value="5" <?php if($program_begin_option == '5') echo 'selected="selected"'; ?>>5</option>
                                <option value="6"<?php if($program_begin_option == '6') echo 'selected="selected"'; ?>>6</option>
                                <option value="7" <?php if($program_begin_option == '7') echo 'selected="selected"'; ?>>7</option>
                                <option value="8" <?php if($program_begin_option == '8') echo 'selected="selected"'; ?>>8</option>
                                <option value="9" <?php if($program_begin_option == '9') echo 'selected="selected"'; ?>>9</option>
                                <option value="10" <?php if($program_begin_option == '10') echo 'selected="selected"'; ?>>10</option>
                                <option value="11" <?php if($program_begin_option == '11') echo 'selected="selected"'; ?>>11</option>
                                <option value="12" <?php if($program_begin_option == '12') echo 'selected="selected"'; ?>>12</option>
                             
                            </select>
                            <select id="start_suffix" class="edit_program"><option value="-----"<?php if($program_begin_am == '') echo 'selected="selected"'; ?>>-----</option>
                                <option value="am" <?php if($program_begin_am == 'AM') echo 'selected="selected"';?>>AM</option><option value="pm" <?php if($program_begin_am == 'PM') echo 'selected="selected"';?>>PM</option><option value="am"  <?php if($program_begin_am == 'Noon') echo 'selected="selected"';?>>Noon</option></select>
                        </td></tr>
                    <tr><td><strong>Daily end time:</strong></td><td><span class="display_program"><?php echo $program->finish; ?></span>
			      <?php $program_end_option= '0';
				   $program_end_am='';
				  if($program->finish != 0) {
				  	list($program_end_option, $program_end_am) = preg_split(' /\s+/',$program->finish);}?>
                            <select id="end_hour" class="edit_program">
                                <option value="-----" <?php if($program_end_option == '0') echo 'selected="selected"'; ?>>-----</option>
                                <option value="1" <?php if($program_end_option == '1') echo 'selected="selected'; ?>>1</option>
                                <option value="2" <?php if($program_end_option == '2') echo 'selected="selected"'; ?>>2</option>
                                <option value="3" <?php if($program_end_option == '3') echo 'selected="selected"'; ?>>3</option>
                                <option value="4" <?php if($program_end_option == '4') echo 'selected="selected"'; ?>>4</option>
                                <option value="5" <?php if($program_end_option == '5') echo 'selected="selected"'; ?>>5</option>
                                <option value="6"<?php if($program_end_option == '6') echo 'selected="selected"'; ?>>6</option>
                                <option value="7" <?php if($program_end_option == '7') echo 'selected="selected"'; ?>>7</option>
                                <option value="8" <?php if($program_end_option == '8') echo 'selected="selected"'; ?>>8</option>
                                <option value="9" <?php if($program_end_option == '9') echo 'selected="selected"'; ?>>9</option>
                                <option value="10" <?php if($program_end_option == '10') echo 'selected="selected"'; ?>>10</option>
                                <option value="11" <?php if($program_end_option == '11') echo 'selected="selected"'; ?>>11</option>
                                <option value="12" <?php if($program_end_option == '12') echo 'selected="selected"'; ?>>12</option>
                            </select>
                            <select id="end_suffix" class="edit_program"><option value="-----"<?php if($program_end_am == '') echo 'selected="selected"'; ?>>-----</option>
                                <option value="am" <?php if($program_end_am == 'AM') echo 'selected="selected"';?>>AM</option><option value="pm" <?php if($program_end_am == 'PM') echo 'selected="selected"';?>>PM</option><option value="am"  <?php if($program_end_am == 'Noon') echo 'selected="selected"';?>>Noon</option></select>
                        </td></tr>
                    <tr><td><strong>Maximum total hours:</strong></td><td><span class="display_program"><?php echo $program->max_hrs; ?></span>
                            <input type="text" value="<?php echo $program->max_hrs; ?>"class="edit_program"  id="max_hrs"</td></tr>
                    <tr><td><input type="button" class="edit_button" value="Edit" onclick="$('.edit_program').toggle();
                            $('.display_program').toggle();
			    $('.edit_button').attr('value', $('.edit_button').attr('value') == 'Edit' ? 'Cancel' : 'Edit');"></td>
                        <td><input type="button" value="Save Changes" onclick="
                                //first deal with all the checkboxes
                                if (document.getElementById('class').checked == true) {
                                    var activity_class = 1;
                                }
                                if (document.getElementById('mental').checked == true) {
                                    var activity_mental = 1;
                                }
                                if (document.getElementById('referrals').checked == true) {
                                    var activity_referrals = 1;
                                }
                                if (document.getElementById('community').checked == true) {
                                    var activity_community = 1;
                                }
                                if (document.getElementById('counseling').checked == true) {
                                    var activity_counseling = 1;
                                }
                                if (document.getElementById('sport').checked == true) {
                                    var activity_sport = 1;
                                }
                                if (document.getElementById('mentors').checked == true) {
                                    var activity_mentors = 1;
                                }
                                if (document.getElementById('service').checked == true) {
                                    var activity_service = 1;
                                }

                                if (document.getElementById('mon').checked == true) {
                                    var monday = 1;
                                }
                                if (document.getElementById('tues').checked == true) {
                                    var tuesday = 1;
                                }
                                if (document.getElementById('weds').checked == true) {
                                    var wednesday = 1;
                                }
                                if (document.getElementById('thurs').checked == true) {
                                    var thursday = 1;
                                }
                                if (document.getElementById('fri').checked == true) {
                                    var friday = 1;
                                }
                                if (document.getElementById('sat').checked == true) {
                                    var saturday = 1;
                                }
                                if (document.getElementById('sun').checked == true) {
                                    var sunday = 1;
                                }
                                //  alert('check checkboxes');
                                $.post(
                                        '../ajax/edit_program.php',
                                        {
                                            id: '<?php echo $program->program_id; ?>',
                                            host: document.getElementById('hosting_org').value,
                                            name: document.getElementById('program_name_edit').value,
                                            begin: document.getElementById('start_hour').value,
                                            finish: document.getElementById('end_hour').value,
                                            begin_am: document.getElementById('start_suffix').value,
                                            finish_am: document.getElementById('end_suffix').value,
                                            hrs: document.getElementById('max_hrs').value,
                                            act_class: activity_class,
                                            mental: activity_mental,
                                            referral: activity_referrals,
                                            community: activity_community,
                                            counseling: activity_counseling,
                                            sports: activity_sport,
                                            mentoring: activity_mentors,
                                            service: activity_service,
                                            mon: monday,
                                            tue: tuesday,
                                            wed: wednesday,
                                            thur: thursday,
                                            fri: friday,
                                            sat: saturday,
                                            sun: sunday
                                        },
                                function(response) {
                                    //document.write(response);
                                    window.location = 'profile.php';
                                }
                                ).fail(failAlert);" class="edit_program">

                        </td></tr>
                </table><br/><br/>
                <h4>Surveys</h4>


                <!--Originally this section showed a list of surveys.  Users requested instead a 
                percentage completed per session.
                -->
                <table class="inner_table">
                    <tr><th>Session</th><th>Number Surveys Completed / Number Participants in the Session</th><th>Percent Surveys Completed</th></tr>
                    <?php
                    //get each session
                    $get_sessions = "SELECT * FROM Session_Names WHERE Program_ID='$program->program_id'";
                    include "../include/dbconnopen.php";
                    $sessions = mysqli_query($cnnEnlace, $get_sessions);
                    while ($sesh = mysqli_fetch_row($sessions)) {
                        ?>
                        <tr><td><?php echo $sesh[0] . ": " . $sesh[1]; ?></td>
                            <td>
                                <?php
                                //get count of participants in this session
                                $get_people = "SELECT COUNT(*) FROM Participants_Programs WHERE Program_Id=$sesh[0] AND Participant_ID!='0'";
                                $people = mysqli_query($cnnEnlace, $get_people);
                                $count_people = mysqli_fetch_row($people);
                                $num_people = $count_people[0];

                                //get count of surveys already entered for this session
                                $get_surveys = "SELECT COUNT(*) FROM Program_Surveys WHERE Session_Id=$sesh[0]";
                                $surveys = mysqli_query($cnnEnlace, $get_surveys);
                                $count_surveys = mysqli_fetch_row($surveys);
                                $num_surveys = $count_surveys[0];

                                //calculate percentage complete
                                echo $num_surveys . '/' . $num_people;
                                ?>
                            </td>
                            <td>
                                <?php
                                //show as a percentage (without dividing by zero)
                                if ($num_people != 0) {
                                    $complete_percentage = $num_surveys / $num_people;
                                    echo number_format($complete_percentage * 100) . '%';
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </table>

                <!--Add new survey here.-->
                <a href="new_program_survey.php?prog=<?php echo $program->program_id; ?>">Add a new Program Quality Survey</a> 
            </td>
            <td>

                <!--Create a new session: -->
                <h4>Add New Session</h4>
                <span class="helptext">Adding a new session of the program allows you to add a new set of participants and dates.  It's appropriate for 
                    adding spring and fall versions of a program, or a new year altogether.  Be sure to title the session clearly - "Spring 2013" is better than "Spring."</span>
                <br/><br/>
                <table class="inner_table" style="width:350px;">
                    <tr><td><strong>Name: </strong></td><td><input type="text" id="new_session_name" style="width:150px;"></td></tr>
                    <tr><td><strong>Start Date: </strong></td><td><input type="text" id="new_session_start" class="addDP"></td></tr>
                    <tr><td><strong>End Date: </strong></td><td><input type="text" id="new_session_end" class="addDP"></td></tr>
                    <tr><td colspan="2" class="blank"><input type="button" onclick="
                            //first check whether a session with this name already exists:
                            $.post(
                                    '../ajax/edit_program.php',
                                    {
                                        action: 'deduplicate_sessions',
                                        name: document.getElementById('new_session_name').value,
                                        program: '<?php echo $program->program_id; ?>'
                                    },
                            function(response) {
                                // alert(response);
                                if (response != 0) {
                                    alert('This program already has a session with this name.  Please choose a different name.');
                                    return false;
                                } else {
                                    $.post(
                                            '../ajax/edit_program.php',
                                            {
                                                action: 'new_session',
                                                session: document.getElementById('new_session_name').value,
                                                program: '<?php echo $program->program_id; ?>',
                                                start: document.getElementById('new_session_start').value,
                                                end: document.getElementById('new_session_end').value
                                                        //survey: document.getElementById('new_session_survey').value
                                            },
                                    function(response) {
                                        // document.write(response);
                                        document.getElementById('save_new_session').innerHTML = 'Thank you for adding this session (refresh to view).';
                                    }).fail(failAlert);
                                }
                            }).fail(failAlert);
                                                             " value="Save Session">
                            <div id="save_new_session" style="font-weight: bold;"></div></td></tr>
                </table>
                <br>
                <br>

                <!-- Choose a session from a dropdown menu and edit its name. -->
                <h4>Edit Session Name</h4>
                <br/><br/>
                1. Choose session:  <select id="edited_session"><option value="">-----</option>
                    <?php
                    //get sessions
                    $related_sessions = "SELECT * FROM Session_Names WHERE Program_ID='" . $program->program_id . "'";
                    include "../include/dbconnopen.php";
                    $sessions = mysqli_query($cnnEnlace, $related_sessions);
                    while ($sess = mysqli_fetch_row($sessions)) {
                        ?>
                        <option value="<?php echo $sess[0]; ?>"><?php echo $sess[1]; ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?></select>
                <br>
                2. Enter new name: <input type="text" id="edited_session_name"><br>
                3. Save changes: <input type="button" value="Save" onclick="
                        //  alert(document.getElementById('new_session_name').value);
                        $.post(
                                '../ajax/edit_program.php',
                                {
                                    action: 'edit_session',
                                    id: document.getElementById('edited_session').value,
                                    new_name: document.getElementById('edited_session_name').value
                                },
                        function(response) {
                            // document.write(response);
                            window.location = 'profile.php';
                        }
                        ).fail(failAlert);">

                <br/><br/>

                <!--List of participants in this program, sorted by session:-->
                <h4>Participants</h4>
                <?php
                $get_all_participants = "SELECT Session_Names.Session_ID, Session_Names.Session_Name, Participants.Participant_ID, Participants_Programs.Date_Dropped, Participant_Program_ID, Participants.First_Name, Participants.Last_Name, COUNT(Assessments.Assessment_ID) FROM Participants_Programs INNER JOIN Participants ON Participants.Participant_ID=Participants_Programs.Participant_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_ID LEFT JOIN Assessments ON (Participants.Participant_ID = Assessments.Participant_ID AND Session_Names.Session_ID = Assessments.Session_ID) WHERE Session_Names.Program_ID='$program->program_id' GROUP BY Session_Names.Session_ID, Participants.Participant_ID ORDER BY Session_Names.Session_ID, Participants.Last_Name";

                include "../include/dbconnopen.php";
                $all_participants = mysqli_query($cnnEnlace, $get_all_participants);
                $all_surveys = mysqli_query($cnnEnlace, $get_intake_surveys);
                $current_session = "";
                ?><table class="inner_table">

                    <!--Participants list includes dosage percentage (hours participated in this program divided by total possible program hours),
                    the total hours in this program, and the total hours across programs.
                    -->
                    <tr style="font-size:.9em;">
                        <th style="width:45%">Participant</th>
                        <th>Dosage Percentage</th>
                        <th>Total hours in this program</th>
                        <th>Total hours across funded programs</th>
                        <th>Intake survey completed</th>
                        <?php
                        //if an administrator
                        if ($access == 'a') {
                            //show delete area
                            ?>
                            <th>Delete</th>
                            <?php
                        }
                        ?>
                    </tr><?php
                    while ($all_p = mysqli_fetch_array($all_participants)) {
                        if ($all_p['Session_Name'] != $current_session) {
                            ?><tr><td colspan="4"><h5><?php echo $all_p['Session_Name']; ?>
                                        <?php
                                        //if an administrator
                                        if ($access == 'a') {
                                            //show delete area
                                            ?>
                                            &nbsp; &nbsp; &nbsp;
                                            <a href="javascript:;" onclick="
                                                            if (confirm('ARE YOU SURE YOU WANT TO DELETE THIS SESSION?')) {
                                                                if (confirm('ARE YOU SURE YOU WANT TO DELETE THIS SESSION?\r\nNOTE: This will remove all session data as well.')) {
                                                                    $.post(
                                                                            '../ajax/join_program.php',
                                                                            {
                                                                                action: 'delete_session',
                                                                                session_id: '<?php echo $all_p['Session_ID']; ?>'
                                                                            },
                                                                    function(response) {
                                                                        //document.write(response);
                                                                        window.location = 'profile.php';
                                                                    }
                                                                    ).fail(failAlert);}
                                                            }" style="font-size: .8em; color: #f00; font-weight: bold;">X</a>
                                               <?php
                                           }
                                           ?></h5>
                                </td></tr><?php
                            $current_session = $all_p['Session_Name'];
                        }
                        ?>
                        <tr>
                            <td> <a href='../participants/participant_profile.php?id=<?php echo $all_p['Participant_ID']; ?>'><?php echo $all_p['First_Name'] . " " . $all_p['Last_Name'];
                        ?></a> -                         
                                <?php if ($all_p['Date_Dropped'] === null) { ?>
                                    (<a href="javascript:;" onclick="
                                                    $.post(
                                                            '../ajax/join_program.php',
                                                            {
                                                                action: 'drop',
                                                                link_id: '<?php echo $all_p['Participant_Program_ID']; ?>'
                                                            },
                                                    function(response) {
                                                       // document.write(response);
                                                       window.location='profile.php';
                                                    }
                                                    ).fail(failAlert);" style="font-size:.8em;">Drop from program</a>)
                                        <?php
                                    } else {
                                        echo 'Dropped: ' . $all_p['Date_Dropped'];
                                    }
                                    ?></td>
                            <td>
                                <?php
                                include "../include/dosage_percentage.php";
                                $return_array= calculate_dosage($all_p['Session_ID'], $all_p['Participant_ID']);
                                echo $return_array[2];
                                ?>
                            </td>
                            <td><?php
                            echo $return_array[1];
                                ?>
                            </td>
                            <td>
    <?php
    $all_hours = 0;
    //Find the dates that this person has attended programs:
    $get_progs = "SELECT * FROM Participants_Programs 
        INNER JOIN Program_Dates ON Program_Dates.Program_ID=Participants_Programs.Program_ID
        INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID
        INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID
        LEFT JOIN Absences ON (Program_Date_ID=Program_Date AND Participants_Programs.Participant_ID=Absences.Participant_ID)
        WHERE Participants_Programs.Participant_ID='" . $all_p['Participant_ID'] . "' AND Absence_ID IS NULL;";
    $dates_attended = mysqli_query($cnnEnlace, $get_progs);
    while ($dates = mysqli_fetch_array($dates_attended)) {
        //get daily hours for each date
        if ($dates['Max_Hours']==0 && $dates['Start_Hour']==0 && $dates['End_Hour']==0){
            $daily_hrs=0;
        }
        else{
        if ($dates['Max_Hours']!='' && $dates['Max_Hours']!=NULL && $dates['Max_Hours']!='0' && $dates['Max_Hours']!=0){
            $daily_hrs=$dates['Max_Hours'];
        }
        else{
        if ($dates['Start_Suffix'] == 'pm') {
            $begin = $dates['Start_Hour'] + 12;
        } else{
            $begin = $dates['Start_Hour'];
        }
        if ($dates['End_Suffix'] == 'pm') {
            $finish = $dates['End_Hour']+12;
        } else {
            $finish = $dates['End_Hour'];
        }
        $daily_hrs = (($finish) - ($begin));
        }
        }
        //add the hours for this program to all_hours
        $all_hours+=$daily_hrs; 
    }
    
    echo $all_hours;
    ?>
                            </td>
                            <td><?php echo ($all_p['COUNT(Assessments.Assessment_ID)'] > 0) ? 'Yes' : 'No'; ?></td>
                                <?php
                                //if an administrator
                                if ($access == 'a') {
                                    //show delete area
                                    ?>
                                <td>
                                    <a href="javascript:;" onclick="
                                                    if (confirm('ARE YOU SURE YOU WANT TO DELETE THIS USER FROM THIS PROGRAM?')) {
                                                        $.post(
                                                                '../ajax/join_program.php',
                                                                {
                                                                    action: 'delete_participant_from_program',
                                                                    link_id: '<?php echo $all_p['Participant_Program_ID']; ?>'
                                                                },
                                                        function(response) {
                                                            //document.write(response);
                                                            window.location = 'profile.php';
                                                        }
                                                        ).fail(failAlert);
                                                    }" style="font-size:.8em; color: #f00; font-weight: bold;">X</a>
                                </td>
                                       <?php
                                   }
                                   ?>
                        </tr><?php
                        }
                        include "../include/dbconnclose.php";
                        ?></table>
                <br/>

                <!--Add a person to a session: -->

                <a href="javascript:;" onclick="$('#search_parti_table').toggle();">Add a participant...</a>
                <table class="inner_table" id="search_parti_table" style="font-size:.9em;">
                    <tr>
                        <td><strong>First Name: </strong></td>
                        <td><input type="text" id="first_name_search" style="width:125px;"/></td>
                        <td><strong>Last Name: </strong></td>
                        <td><input type="text" id="last_name_search" style="width:125px;" /></td>
                    </tr>
                    <tr>
                        <td><strong>Date of Birth: </strong></td>
                        <td><input type="text" id="dob_search" class="hasDatepicker" /></td>
                        <td><strong>Grade Level: </strong></td>
                        <td><select id="grade_search">
                                <option value="">--------</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            <input type="button" value="Search" onclick="
                                    $('#add_participant_button').show();
                                    $.post(
                                            '/enlace/ajax/search_participants.php',
                                            {
                                                result: 'dropdown',
                                                first: document.getElementById('first_name_search').value,
                                                last: document.getElementById('last_name_search').value,
                                                dob: document.getElementById('dob_search').value,
                                                grade: document.getElementById('grade_search').value
                                            },
                                    function(response) {
                                        document.getElementById('show_results').innerHTML = response;
                                        $('.add_new_person_to_session').show();
                                    }).fail(failAlert);"/>
                            <div id="show_results"></div>
                            <div id="session_selector"><span class="helptext">Select the name of the session this person participated in: </span>
                                   <?php
                                   $related_sessions = "SELECT * FROM Session_Names WHERE Program_ID=$program->program_id";
                                   ?>
                            <select id="add_to_session">
                                <option value="">-----</option>
<?php
//get sessions
include "../include/dbconnopen.php";
$sessions = mysqli_query($cnnEnlace, $related_sessions);
while ($sess = mysqli_fetch_row($sessions)) {
    ?>
                                    <option value="<?php echo $sess[0]; ?>"><?php echo $sess[1]; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select>
                            </div>
                            <input type="button" value="Add Participant" onclick="
                                    var session = document.getElementById('add_to_session').value;
                                    if (session == '') {
                                        document.getElementById('session_alert').innerHTML = '<span>Please select a session.</span>';
                                        return false;
                                    }

                                    $.post(
                                            '../ajax/join_program.php',
                                            {
                                                program_id: document.getElementById('add_to_session').value,
                                                participant: document.getElementById('relative_search').value
                                            },
                                    function(response) {
                                        window.location = 'profile.php';
                                    }
                                    ).fail(failAlert);" id="add_participant_button">
                            <div id="session_alert" style="font-weight:bold;color:#990000;"></div>
                        </td>
                    </tr>
                </table>
                <span class='add_new_person_to_session'>
                    <span class="helptext">Can't find the person you're looking for?  Add them to the database here:</span>
                    <table class="search_table" style="border:2px solid #696969;">
                <tr>
                    <td><strong>First Name: </strong></td>
                    <td><input type="text" id="name_new"  style="width:125px;"/></td>
                    <td><strong>Last Name: </strong></td>
                    <td><input type="text" id="surname_new"  style="width:125px;"/></td>
                </tr>
                <tr>
                    <td><strong>Date of Birth: </strong></td>
                    <td><input type="text" id="dob_new" class="addDP" /></td>
                    <td><strong>Age: </strong></td>
                    <td><input type="text" id="age_new"  style="width:25px;"/>&nbsp;&nbsp;<span class="helptext">If date of birth is not available</span></td>
                </tr>
                <tr>
                    <td><strong>Daytime Phone: </strong></td>
                    <td><input type="text" id="day_phone_new"  style="width:100px;"/></td>
                    <td><strong>Evening Phone: </strong></td>
                    <td><input type="text" id="evening_phone_new"  style="width:100px;"/></td>
                </tr>
                <tr>
                    <td><strong>Grade Level: </strong></td>
                    <td><select id="grade_new">
                            <option value="">----</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </td>
                    <td><strong>Gender: </strong></td>
                    <td><select id="gender_new">
                            <option value="">----</option>
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>School: </strong></td>
                    <td><select id="school_new">
                            <option value="">--------</option>
                            <?php
                            $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1' ORDER BY Institution_Name";
                            include "../include/dbconnopen.php";
                            $schools = mysqli_query($cnnEnlace, $get_schools);
                            while ($school = mysqli_fetch_array($schools)) {
                                ?>
                                <option value="<?php echo $school['Inst_ID'];?>"><?php echo $school['Institution_Name']; ?></option>
                                <?php
                            }
                            include "../include/dbconnclose.php";
                            ?>
                        </select>
                    </td>
                    <td><strong>Role: </strong><span class="helptext">(required)</span></td>
                    <td><select id="role_new">
                            <option value="">--------</option>
                            <?php
                            $get_roles = "SELECT * FROM Roles";
                            include "../include/dbconnopen.php";
                            $roles = mysqli_query($cnnEnlace, $get_roles);
                            while ($role = mysqli_fetch_array($roles)) {
                                ?>
                                <option value="<?php echo $role['Role_ID']; ?>"><?php echo $role['Role']; ?></option>
                                <?php
                            }
                            include "../include/dbconnclose.php";
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:center;"><input type="button" onclick="
                            var x = document.getElementById('dob_new').value;
                            if (x != '') {
                                var firstslash = x.indexOf('/');
                                var lastslash = x.lastIndexOf('/');
                                var firstdash = x.indexOf('-');
                                var lastdash = x.lastIndexOf('-');
                                // alert('open: '+firstdash+' close: '+lastdash);
                                if ((firstslash != 2 && lastslash != 5) && (firstdash != 4 && lastdash != 7))
                                {
                                    alert('Not a valid date of birth');
                                    return false;
                                }
                            }
                            var role = document.getElementById('role_new').value;
                            if (role == '') {
                                alert('You have not entered a role for this participant.  Please enter a role for this participant and then hit Save again.');
                                return false;
                            }
                            var program = document.getElementById('add_to_session').value;
                            if (program == '') {
                                alert('You have not chosen a session for this participant.  Please choose a session for this participant (dropdown labeled: Select the name of the session this person participated in) and then hit Save again.');
                                return false;
                            }
                            $.post(
                                    '../ajax/add_participant.php',
                                    {
                                        action: 'add_program',
                                        program_id: program,
                                        first_name: document.getElementById('name_new').value,
                                        last_name: document.getElementById('surname_new').value,
                                        dob: document.getElementById('dob_new').value,
                                        age: document.getElementById('age_new').value,
                                        day_phone: document.getElementById('day_phone_new').value,
                                        evening_phone: document.getElementById('evening_phone_new').value,
                                        grade: document.getElementById('grade_new').value,
                                        gender: document.getElementById('gender_new').value,
                                        school: document.getElementById('school_new').value,
                                        role: document.getElementById('role_new').value
                                    },
                            function(response) {
                                document.getElementById('confirmation').innerHTML = response;
                            }
                            ).fail(failAlert);" value="Save" /></td>
                </tr>
            </table>
            <div id="confirmation" style="text-align:center;"></div>
                </span>

                <br/><br/>               

                <!--Display and add dates to sessions: -->

                <h4>Program Dates</h4>
                <table class="inner_table">
                    <tr style="font-size:.9em;"><th>Date</th><th>Attendees<br>
                            <!--Participants are assumed to be present (checked).  Unchecking marks them as absent.-->
                            <span class="helptext">Uncheck the checkbox next to the participant's name on days when they are absent.</span></th></tr>
<?php
$related_sessions = "SELECT * FROM Session_Names WHERE Program_ID=$program->program_id";
include "../include/dbconnopen.php";
$sessions = mysqli_query($cnnEnlace, $related_sessions);
while ($sess = mysqli_fetch_row($sessions)) {

    /* show all sessions for this program: */
    $get_dates = "SELECT * FROM Program_Dates WHERE Program_ID='" . $sess[0] . "' ORDER BY Date_Listed";
    include "../include/dbconnopen.php";
    $program_info = mysqli_query($cnnEnlace, $get_dates);
    $current_session = "";
    if ($sess[1] != $current_session) {
        $current_session = $sess[1];
        ?><tr><td class="all_projects" colspan="2">
                                    <a href="javascript:;" onclick="$('.toggler_<?php echo $sess[0] ?>').toggle();"><?php echo $current_session; ?></a></td></tr>
                            <tr class="toggler_<?php echo $sess[0] ?> hide_dates"><td class="all_projects" ><strong>Dates:</strong> <?php echo $sess[3] . ' --- ' . $sess[4]; ?></td>
                                <td class="all_projects"><strong>Surveys Due:</strong> <?php echo $sess[5]; ?></td></tr><?php
                        }

                        /* show dates and attendance for each session: */
                        while ($temp_program = mysqli_fetch_array($program_info)) {
        ?><tr class="toggler_<?php echo $sess[0] ?> hide_dates">
                                <td class="all_projects"><?php
                                $this_date = explode('-', $temp_program['Date_Listed']);
                                date_default_timezone_set('America/Chicago');
                                $show_date = mktime(0, 0, 0, $this_date[1], $this_date[2], $this_date[0]);
                                $display_date = date('n/j/Y', $show_date);
                                echo $display_date;
                                ?>
                                    &nbsp<p></p>
                                    <a href="javascript:;" onclick="
                                                    $.post(
                                                            '../ajax/add_date.php',
                                                            {
                                                                action: 'delete',
                                                                id: '<?php echo $temp_program['Program_Date_ID']; ?>'
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location = 'profile.php';
                                                    }
                                                    ).fail(failAlert);">Delete this date</a>
                                </td>
                                <td class="all_projects"><?php
                            $get_all_participants = "SELECT * FROM Participants_Programs INNER JOIN Participants
                    ON Participants.Participant_ID=Participants_Programs.Participant_ID WHERE Program_ID='" . $sess[0] . "' ORDER BY Last_Name";
                            //echo $get_all_participants;
                            $all_participants = mysqli_query($cnnEnlace, $get_all_participants);
                            while ($all_p = mysqli_fetch_array($all_participants)) {
                                $find_absence = "SELECT COUNT(*) FROM Absences WHERE Participant_ID='" . $all_p['Participant_ID'] . "'
                        AND Program_Date='" . $temp_program['Program_Date_ID'] . "'";
                                $absent = mysqli_query($cnnEnlace, $find_absence);
                                $num_abs = mysqli_fetch_row($absent);
                                $was_absent = $num_abs[0];

                                /* uncheck box to add an absence, and check the box to delete that absence: */
                                    ?><input type="checkbox" <?php echo($was_absent <= 0 ? 'checked="true"' : null); ?>
                                               id="date_<?php echo $temp_program['Program_Date_ID']; ?>_person_<?php echo $all_p['Participant_ID'] ?>"
                                               onchange="handleRole(this, '<?php echo $temp_program['Program_Date_ID']; ?>', '<?php echo $all_p['Participant_ID'] ?>');">
            <?php echo $all_p['First_Name'] . " " . $all_p['Last_Name'];
            ?><br><?php
                                           }
                                           ?></td></tr><?php
                                }
                                include "../include/dbconnclose.php";
                            }
                            ?>


                    <!--Add new session dates: -->

                    <tr><td class="all_projects">Add Date: <input type="text" class="addDP" id="new_program_date"><br>
<?php
$related_sessions = "SELECT * FROM Session_Names WHERE Program_ID = $program->program_id";
?>
                            <select id="add_date_to_session">
                                <option value="">-----</option>
<?php
//get sessions
include "../include/dbconnopen.php";
$sessions = mysqli_query($cnnEnlace, $related_sessions);
while ($sess = mysqli_fetch_row($sessions)) {
    ?>
                                    <option value="<?php echo $sess[0]; ?>"><?php echo $sess[1]; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select>
                        </td>
                        <td class="all_projects"><input type="button" value="Submit" onclick="
                                var session = document.getElementById('add_date_to_session').value;
                                if (session == '') {
                                    alert('Please choose a session.');
                                    return false;
                                }
                                $.post(
                                        '../ajax/add_date.php',
                                        {
                                            program: document.getElementById('add_date_to_session').value,
                                            date: document.getElementById('new_program_date').value
                                        },
                                function(response) {
                                    //document.write(response);
                                    window.location = 'profile.php';
                                }
                                ).fail(failAlert)"></td></tr>
                </table>

                <!--Function for adding and removing absences: -->
                <script text="javascript">

                    function handleRole(cb, date, user) {
                        if (cb.checked == true) {
                            $.post(
                                    '../ajax/add_absence.php',
                                    {
                                        action: 'remove',
                                        date: date,
                                        user_id: user
                                    },
                            function(response) {
                                //document.write(response);
                                //window.location = "profile.php";
                            }
                            ).fail(failAlert);
                        }
                        else if (cb.checked == false) {
                            $.post(
                                    '../ajax/add_absence.php',
                                    {
                                        action: 'add',
                                        date: date,
                                        user_id: user
                                    },
                            function(response) {
                                // document.write(response);
                                // window.location = "profile.php";
                            }
                            ).fail(failAlert);
                        }
                    }
                </script>
            </td></tr>
        <tr>
            <td></td>
            <td>

                <!-- Mentorship hours; shown for programs with the Mentorship activity checked: -->
<?php
if ($program->mentor == 1) {
    ?><h4>Mentorship Hours</h4>
                    <table class="inner_table">
                        <tr style="font-size:.9em;"><th>Participant</th><th>Hours (this program)</th><th>Total hours across funded programs</th></tr>
    <?php
    $get_dosages_mentorship = "SELECT SUM(Mentorship_Hours_Logged), Mentee_ID, First_Name, Last_Name FROM Participants_Mentorship 
                        INNER JOIN Participants ON Participant_Id=Mentee_ID
                        INNER JOIN Session_Names ON Mentorship_Program=Session_ID
                        WHERE Session_Names.Program_ID='" . $program->program_id . "' GROUP BY Mentee_ID";


    include "../include/dbconnopen.php";
    $mentorship_dosage = mysqli_query($cnnEnlace, $get_dosages_mentorship);
    while ($mentee = mysqli_fetch_row($mentorship_dosage)) {
        ?>
                            <tr><td><?php echo $mentee[2] . " " . $mentee[3]; ?></td><td><?php echo round($mentee[0], 2); ?></td>
                                <td>
        <?php
        $total_mentorship_hrs = "SELECT SUM(Mentorship_Hours_Logged) FROM Participants_Mentorship
                                WHERE Mentee_ID = " . $mentee[1];

        $total_hrs = mysqli_query($cnnEnlace, $total_mentorship_hrs);
        $hrs = mysqli_fetch_row($total_hrs);
        echo round($hrs[0], 2);
        ?>
                                </td></tr>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                    </table><?php } ?>
            </td>
        </tr>
    </table>
</div>
<br/><br/>
<?php
include "../../footer.php";
?>
