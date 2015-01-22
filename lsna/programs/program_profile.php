<?php
include "../../header.php";
include "../header.php";
//print_r($_COOKIE);
?>

<!--All information about a program or campaign: -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#ajax_loader').hide();
        $('.program_by_category_list').hide();
        $('.user_dates').hide();
        $('.pm_dates').hide();
        $('.edit_attendance').hide();
        $('.detail_expand').hide();
        $('#programs_selector').addClass('selected');
    });

    $(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });

    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#programs_selector').addClass('selected');
        $("a.add_new").hover(function() {
            $(this).addClass("selected");
        }, function() {
            $(this).removeClass("selected");
        });
        $('#search_all_programs').hide();
        $('#add_new_program').hide();
        $('#program_profile_div').show();
        $('.show_edit_space').hide();
        $('.attendee_role_edit').hide();
        $('#user_search').hide();
        $('#add_participant').hide();
        $('#show_next_parts_new').hide();
        $('#show_next_parts').hide();
        $('.hide_notes').hide();
    });

</script>

<div  class="content" id="program_profile_div">

    <?php
    include "../classes/program.php";
    $program = new Program();
    $program->load_with_program_id($_COOKIE['program']);
    if ($_GET['schedule'] == 1) {
        ?><script type="text/javascript">
            $(document).ready(function() {
                window.location.hash = "schedule";
            });
        </script><?php
    }
    ?>

    <?php //find the else to this if around line 900 
    if ($_COOKIE['program'] != 19 ) {
        ?>
        <h3><?php
            if ($program->issue_type == 'Program') {
                echo "Program";
            } else if ($program->issue_type == 'Campaign') {
                echo "Campaign";
            }
            ?> Profile: <?php echo $program->program_name; ?></h3><hr/><br/>
        <table class="profile_table">
            <tr>
                <td width="50%"><!--Basic program info-->
                    <table class="inner_table" style="border:2px solid #696969;">
                        <tr>
                            <td width="30%"><strong>Name:</strong></td>
                            <td><span class="displayed_info"><?php echo $program->program_name; ?></span>
                                <input style="width:100%;" type="text" value="<?php echo $program->program_name; ?>" id="edit_name" class="show_edit_space">
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Issue Area:</strong></td>
                            <td><span class="displayed_info"><?php
                                    $find_org = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links)
                                    ON Categories.Category_ID=Category_Subcategory_Links.Category_ID
                                    WHERE Subcategory_ID='" . $program->program_id . "'";
                                    //echo $find_org;
                                    include "../include/dbconnopen.php";
                                    $org = mysqli_query($cnnLSNA, $find_org);
                                    $partner = mysqli_fetch_array($org);
                                    echo $partner['Category_Name'] . "<br>";

                                    include "../include/dbconnclose.php";
                                    ?></span>
                                <select id="edit_type" class="show_edit_space">
                                    <option value="">-----</option>
                                    <?php
                                    $program_query = "SELECT * FROM Categories";
                                    include "../include/dbconnopen.php";
                                    $programs = mysqli_query($cnnLSNA, $program_query);
                                    while ($prog = mysqli_fetch_array($programs)) {
                                        ?>
                                        <option value="<?php echo $prog['Category_ID']; ?>"
                                                <?php echo($partner['Category_ID'] == $prog['Category_ID'] ? 'selected="selected"' : null); ?>><?php echo $prog['Category_Name']; ?></option>
                                                <?php
                                            }
                                            include "../include/dbconnclose.php";
                                            ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><strong>Program or Campaign:</strong></td>
                            <td><span class="displayed_info"><?php echo $program->issue_type; ?></span>
                                <select id="issue_type" class="show_edit_space">
                                    <option value="">-----</option>
                                    <option value="program" <?php echo ($program->issue_type == 'Program' ? 'selected="selected"' : null); ?>>Program</option>
                                    <option value="campaign" <?php echo ($program->issue_type == 'Campaign' ? 'selected="selected"' : null); ?>>Campaign</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Number of Total Participants:</strong></td>
                            <td><?php
                                $get_participant_num = "SELECT * FROM Participants LEFT JOIN (Participants_Subcategories)
                                ON (Participants.Participant_ID=Participants_Subcategories.Participant_ID)
                                WHERE Participants_Subcategories.Subcategory_ID='" . $program->program_id . "'";
                                include "../include/dbconnopen.php";
                                $get_num = mysqli_query($cnnLSNA, $get_participant_num);
                                $num = mysqli_num_rows($get_num);
                                echo $num;
                                include "../include/dbconnclose.php";
                                ?></td>
                        </tr>
                        <tr>
                            <td><strong>Notes:</strong></td>
                            <!--Notes save onchange, not when the save button is clicked.-->
                            <td><textarea id="program_notes" class="no_view" onchange="
                                    $.post(
                                            '../ajax/save_notes.php',
                                            {
                                                type: 'program',
                                                id: '<?php echo $program->program_id; ?>',
                                                note: this.value
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = 'program_profile.php';
                                    }
                                    )"><?php echo $program->notes; ?></textarea><p class="helptext no_view">(only 400 characters will be saved in the database)</p></td>
                        </tr>
                        <tr>
                            <td><input type="button" value="Edit Program Information"  class="no_view" onclick="
                                    $('.displayed_info').toggle();
                                    $('.show_edit_space').toggle();
                                       "></td>
                            <td><input type="button" value="Save Changes" class="show_edit_space" onclick="
                                    $.post(
                                            '../ajax/edit_program.php',
                                            {
                                                name: document.getElementById('edit_name').value,
                                                issue_type: document.getElementById('issue_type').value,
                                                type: document.getElementById('edit_type').options[document.getElementById('edit_type').selectedIndex].value,
                                                id: '<?php echo $program->program_id; ?>'
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = 'program_profile.php';
                                    }
                                    )"></td>
                        </tr>
                    </table><br/><br/>
    <?php if ($_COOKIE['program'] != 19 && $program->issue_type != 'Campaign') { ?>
                        <!--Satisfaction surveys only show up for programs.  Campaigns don't have surveys. -->
                        <h4>Satisfaction Surveys</h4>
                        <table id="survey_list_table">
                            <?php
                            /* Show existing surveys: */
                            $get_linked_surveys = "SELECT * FROM Satisfaction_Surveys INNER JOIN Participants ON Satisfaction_Surveys.Participant_ID=Participants.Participant_ID WHERE Program_ID='" . $program->program_id . "'";
                            //echo $get_linked_surveys;
                            include "../include/dbconnopen.php";
                            $linked_surveys = mysqli_query($cnnLSNA, $get_linked_surveys);
                            $num_surveys = mysqli_num_rows($linked_surveys);
                            //echo $num_surveys;
                            while ($survey = mysqli_fetch_array($linked_surveys)) {
                                $date_formatted = explode('-', $survey['Date']);
                                $date = $date_formatted[1] . '-' . $date_formatted[2] . '-' . $date_formatted[0];
                                ?>
                                <tr>
                                    <td><?php echo $survey['Name_First'] . " " . $survey['Name_Last'] . ": " . $date; ?></a></td>
                                    <td><a  class="no_view" href="new_satisfaction_survey.php?survey=<?php echo $survey['Satisfaction_Survey_ID']; ?>">View</a></td> 
                                </tr>
                                <?php
                            }
                            include "../include/dbconnclose.php";
                            ?>
                            <tr class="no_view"><td><a href="new_satisfaction_survey.php">Add New Satisfaction Survey</a></td></tr>
                        </table>
    <?php }
    /* end satisfaction survey area */
    ?>
                    <br/>

                    <!--Show all institution relationships: -->

                    <h4>Associated Institutions</h4>
                    <table class="inner_table">
                        <tr>
                            <th>Institution Name</th>
                            <th>Institution Type</th>
                        </tr>
    <?php
    if ($institutions = $program->get_institutions()) {
        while ($institution = mysqli_fetch_array($institutions)) {
            ?>
                                <tr>
                                    <!--Link to Institution profile: -->
                                    <td><a href="javascript:;" onclick="
                                                            $.post(
                                                                    '../ajax/set_institution_id.php',
                                                                    {
                                                                        page: 'profile',
                                                                        id: '<?php echo $institution['Institution_ID']; ?>'
                                                                    },
                                                            function(response) {
                                                                //alert(response);
                                                                if (response != '1') {
                                                                    document.getElementById('show_error').innerHTML = response;
                                                                }
                                                                window.location = '/lsna/institutions/institution_profile.php';
                                                            }
                                                            )
                                           "><?php echo $institution['Institution_Name']; ?></a></td>
                                    <td><?php
                                        if (isset($institution['Institution_Type'])) {
                                            $get_institution_types = "SELECT * FROM Institution_Types WHERE Institution_Type_ID=" . $institution['Institution_Type'];
                                            include "../include/dbconnopen.php";
                                            $types = mysqli_query($cnnLSNA, $get_institution_types);
                                            $type = mysqli_fetch_array($types);
                                            echo $type['Institution_Type_Name'];
                                            include "../include/dbconnclose.php";
                                        }
                                        ?></td>
                                </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                        <!--Add new institution connection: -->
                        <tr class="no_view" ><td><select id="institution_list">
                                    <option value="">-----</option>
                                    <?php
                                    $get_institutions = "SELECT * FROM Institutions ORDER BY Institution_Name";
                                    include "../include/dbconnopen.php";
                                    $institutions = mysqli_query($cnnLSNA, $get_institutions);
                                    while ($inst = mysqli_fetch_array($institutions)) {
                                        ?><option value="<?php echo $inst['Institution_ID']; ?>"><?php echo $inst['Institution_Name']; ?></option><?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                                </select></td><td><input type="button" value="Add Institution" onclick="
                                                    $.post(
                                                            '../ajax/add_program_to_institution.php',
                                                            {
                                                                inst: document.getElementById('institution_list').options[document.getElementById('institution_list').selectedIndex].value,
                                                                program: '<?php echo $program->program_id; ?>'
                                                            },
                                                    function(response) {
                                                        document.write(response);
                                                        window.location = 'program_profile.php';
                                                    }
                                                    )
                                                     "></td></tr>
                    </table>

                </td>
                <td width="50%"><!--Participants-->
                    <h4>Participants:</h4>
                    <!-- For non-Parent Mentor programs...-->
                    <div style="height: 310px; overflow: auto; border: 1px solid #ccc;">
                        <?php if ($_COOKIE['program'] != 19) { ?>
                        <table class="inner_table participant_list">
                            <tr>
                                <th>Participant Name</th>
                                <th>Number of Times Attended</th>
                                <th>Satisfaction Surveys</th>
                            </tr>
                                    <?php
                                    /* show list of people in this program */
                                    $users = $program->get_users();
                                    while ($user = mysqli_fetch_array($users)) {
                                        ?>
                                <tr>
                                    <td><a href="javascript:;" onclick="
                                                $.post(
                                                        '../ajax/set_participant_id.php',
                                                        {
                                                            page: 'profile',
                                                            participant_id: '<?php echo $user['Participant_ID']; ?>'
                                                        },
                                                function(response) {
                                                    if (response != '1') {
                                                        document.getElementById('show_error').innerHTML = response;
                                                    }
                                                    window.location = '../participants/participant_profile.php';
                                                }
                                                );
                                           "><?php echo $user['Name_First'] . " " . $user['Name_Last']; ?></a></td>
                                    <td>
                                        <?php
                                        /* display the dates when this person attended (only those, not the dates s/he was absent) */
                                        $times_attended = "SELECT * FROM Subcategory_Attendance INNER JOIN
                                                    Subcategory_Dates ON (Subcategory_Attendance.Subcategory_Date=Subcategory_Dates.Wright_College_Program_Date_ID)
                                                WHERE Subcategory_Dates.Subcategory_ID='" . $program->program_id . "'
                                                AND Subcategory_Attendance.Participant_ID='" . $user['Participant_ID'] . "'";
                                        //echo $times_attended;
                                        include "../include/dbconnopen.php";
                                        $num = mysqli_query($cnnLSNA, $times_attended);
                                        echo mysqli_num_rows($num);
                                        include "../include/dbconnclose.php";
                                        ?>&nbsp;&nbsp;
                                        <!--roll up and roll down the dates attended: -->
                                        <a class="helptext" onclick="
                                                                                    $('.dates_<?php echo $user['Participant_ID']; ?>').slideToggle();
                                           ">Show/hide dates attended</a>
                                        <div style="padding-left:30px" class="dates_<?php echo $user['Participant_ID']; ?> user_dates">
                                            <?php
                                            date_default_timezone_set('America/Chicago');
                                            while ($date = mysqli_fetch_array($num)) {
                                                $datetime = new DateTime($date['Date']);
                                                //echo $date . "<br>";
                                                echo date_format($datetime, 'M d, Y') . "<br>";
                                                //echo $date['Program_Date'] 
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Show the satisfaction survey corresponding to this person and this program.
                                        
                                        -->
                                        <?php
                                        $get_linked_surveys = "SELECT * FROM Satisfaction_Surveys WHERE Program_ID='" . $program->program_id . "' AND Participant_ID='" . $user['Participant_ID'] . "'";
                                        //echo $get_linked_surveys;
                                        include "../include/dbconnopen.php";
                                        $linked_surveys = mysqli_query($cnnLSNA, $get_linked_surveys);
                                        //echo $num_surveys;
                                        while ($survey = mysqli_fetch_array($linked_surveys)) {
                                            $date_formatted = explode('-', $survey['Date']);
                                            $date = $date_formatted[1] . '-' . $date_formatted[2] . '-' . $date_formatted[0];
                                            echo $date;
                                            ?>
                                            <span class="no_view"><a href="new_satisfaction_survey.php?survey=<?php echo $survey['Satisfaction_Survey_ID']; ?>">View</a></span><br/>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                                    </td>
                                </tr>
            <?php
        }
        ?>

                        </table>
                        <?php } else if ($_COOKIE['program'] == 19) { ?>

                        <!--For the Parent Mentor program...-->
                        <p class="helptext">Parent Mentor monthly attendance is shown as the number of days the Parent Mentor spent in the classroom out of the total number of possible days for each month.</p>
                        <table class="inner_table">
                                    <?php
                                    $users = $program->get_users();
                                    while ($user = mysqli_fetch_array($users)) {
                                        ?>
                                <tr>
                                    <!-- List of people. -->
                                    <td><a href="javascript:;" onclick="
                                                $.post(
                                                        '../ajax/set_participant_id.php',
                                                        {
                                                            page: 'profile',
                                                            participant_id: '<?php echo $user['Participant_ID']; ?>'
                                                        },
                                                function(response) {
                                                    if (response != '1') {
                                                        document.getElementById('show_error').innerHTML = response;
                                                    }
                                                    window.location = '../participants/participant_profile.php';
                                                }
                                                );
                                           "><?php echo $user['Name_First'] . " " . $user['Name_Last']; ?></a></td>
                                    <td>
                                        <!-- Show list of months with possible attendance and actual attendance. -->
                                        <a class="helptext" onclick="
                                                                                    $('.pm_dates_<?php echo $user['Participant_ID']; ?>').slideToggle();
                                           ">Show/hide monthly attendance</a>
                                        <div style="padding-left:30px" class="pm_dates_<?php echo $user['Participant_ID']; ?> pm_dates">
            <?php
            $pm_attendance_query = "SELECT * FROM PM_Monthly_Attendance WHERE Participant_ID=" . $user['Participant_ID'];
            include "../include/dbconnopen.php";
            $monthly_attendance = mysqli_query($cnnLSNA, $pm_attendance_query);
            while ($pm_attendance = mysqli_fetch_array($monthly_attendance)) {
                echo $pm_attendance['Month_Year'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $pm_attendance['Days_Attended'] . "/" . $pm_attendance['Days_Scheduled'] . " days<br/>";
            }
            include "../include/dbconnclose.php";
            ?>
                                        </div>
                                    </td>
                                </tr>
        <?php } ?>
                        </table>
    <?php } ?>
                        </div>
                    <br/>
                    <a class="search_toggle no_view" onclick="
                            $('#user_search').toggle();
                       "><em>Add Participant: Search</em></a>
                    <!-- Search for new people to add to this program: -->
                    <div id="user_search" style="font-size:.8em;">
                        <table class="inner_table">
                            <tr>
                                <td><strong>First Name: </strong></td>
                                <td><input type="text" id="first_name" style="width:100px;" /></td>
                                <td><strong>Role: </strong></td>
                                <td><select id="role">
                                        <option value="">--------</option>
                                        <?php
                                        $get_roles = "SELECT * FROM Roles";
                                        include "../include/dbconnopen.php";
                                        $roles = mysqli_query($cnnLSNA, $get_roles);
                                        while ($role = mysqli_fetch_array($roles)) {
                                            ?>
                                            <option value="<?php echo $role['Role_ID']; ?>"><?php echo $role['Role_Title']; ?></option>
    <?php
    }
    include "../include/dbconnclose.php";
    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Last Name: </strong></td>
                                <td><input type="text" id="last_name" style="width:100px;" /></td>
                                <td><strong>Gender: </strong></td>
                                <td><select id="gender">
                                        <option value="">--------</option>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Date of Birth: </strong></td>
                                <td><input type="text" id="dob" class="hasDatepicker" style="width:100px;" /></td>
                                <td><strong>Grade Level: </strong></td>
                                <td><select id="grade">
                                        <option value="">--------</option>
                                        <option value="k">Kindergarten</option>
                                        <option value="1">1st Grade</option>
                                        <option value="2">2nd Grade</option>
                                        <option value="3">3rd Grade</option>
                                        <option value="4">4th Grade</option>
                                        <option value="5">5th Grade</option>
                                        <option value="6">6th Grade</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <input type="button" value="Search" onclick="
                                    $.post(
                                            '../ajax/search_participants.php',
                                            {
                                                result: 'dropdown',
                                                first: document.getElementById('first_name').value,
                                                last: document.getElementById('last_name').value,
                                                dob: document.getElementById('dob').value,
                                                grade: document.getElementById('grade').value,
                                                gender: document.getElementById('gender').options[document.getElementById('gender').selectedIndex].value,
                                                role: document.getElementById('role').options[document.getElementById('role').selectedIndex].value
                                            },
                                    function(response) {
                                        document.getElementById('show_results').innerHTML = response;
                                        $('#add_button').show();
                                    }
                                    );
                                           "/>
                                </td>
                            </tr>
                        </table>
                        <!--Add person to the program or campaign: -->
                        <div id="show_results"></div><span><input type="button" value="Add Participant" id="add_button" class="no_view"  onclick="
            $.post(
                    '../ajax/add_participant_to_program.php',
                    {
                        participant: document.getElementById('relative_search').options[document.getElementById('relative_search').selectedIndex].value,
                        subcategory: '<?php echo $program->program_id; ?>'
                    },
            function(response) {
                //document.write(response);
                window.location = 'program_profile.php';
            }
            )"></span>
                    </div>
                    <br/><br/>
            <?php //if ($program->issue_type != 'Campaign'){?>	<!--<a href="new_satisfaction_survey.php" class="no_view" >Add a Satisfaction Survey for this program </a>--><?php //}?>

                </td>
            </tr>
            <?php
            //if information about this program was imported
            /* I added this section because there was no good place to include the imported information on the existing
             * program profile.
             */
            $check_if_imported = "SELECT * FROM Import_Destination WHERE Program_ID='" . $program->program_id . "'";
            include "../include/dbconnopen.php";
            $if_imported = mysqli_query($cnnLSNA, $check_if_imported);
            $if_im = mysqli_num_rows($if_imported);
            if ($if_im > 0) {
                include "../include/dbconnclose.php";
                ?>
                <tr>

                    <td colspan="2"><h4>Imported Information</h4>
                        <table>
                            <tr><th>Program Category</th>
                                <th>Funding Source</th><th>Total Enrollment1</th><th>Total Dropped2</th><th>Current Enrollment</th>
                                <th>Total Service Days3</th><th>Total Scheduled Service Hours</th><th>Total Present Records4</th>
                                <th>Total Activity Records5</th><th>Average Daily Attendance6</th><th>Average Weekly Attendance7</th><th>
                                    # of Weeks8</th><th>Attendance Rate9</th><th>% Sessions w/ attendee(s)10%</th><th>Attendance Entered (Records)11</th>
                                <th>Reported Period</th><th>School</th>
                            </tr>
                <?php while ($imported = mysqli_fetch_row($if_imported)) { ?>
                                <tr><td><?php echo $imported[2]; ?></td><td><?php echo $imported[3]; ?></td><td><?php echo $imported[4]; ?></td>
                                    <td><?php echo $imported[5]; ?></td><td><?php echo $imported[6]; ?></td><td><?php echo $imported[7]; ?></td><td><?php echo $imported[8]; ?></td>
                                    <td><?php echo $imported[9]; ?></td><td><?php echo $imported[10]; ?></td><td><?php echo $imported[11]; ?></td><td><?php echo $imported[12]; ?></td>
                                    <td><?php echo $imported[13]; ?></td><td><?php echo $imported[14]; ?></td><td><?php echo $imported[15]; ?></td><td><?php echo $imported[16]; ?></td>
                                    <td><?php echo $imported[17]; ?></td><td><?php echo $imported[18]; ?></td>
                                </tr>
                <?php } ?>
                        </table></td>
                </tr>
        <?php
    }
    //end import information


    if ($_COOKIE['program'] != 19) {
        /* for all programs that aren't the parent mentor program and have surveys, create
         * a chart of survey responses: 
         */
        if ($num_surveys > 0 && $program->issue_type != 'Campaign') {
            ?>
                    <tr><td colspan="2">
                            <!--Quick View Report on Surveys-->
                            <h4>Satisfaction Surveys - Aggregate Results</h4>            
                            <?php
                            /* I want to set up a set of arrays that show the number of each answer to each question.  Did most kids agree, disagree, or in between?
                             * 
                             */
                            $agree_array = array();
                            $somewhat_array = array();
                            $disagree_array = array();
                            $program_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_COOKIE['program']);
                            for ($j = 1; $j < 12; $j++) {
                                /* get responses to each question.  the for loop goes through all the question columns. */
                                $count_query = "SELECT COUNT(*), Question_" . $j . " FROM Satisfaction_Surveys WHERE Program_ID='" . $program_sqlsafe . "' 
        GROUP BY Question_" . $j . ";";
                                include "../include/dbconnopen.php";
                                $count_for_arrays = mysqli_query($cnnLSNA, $count_query);

                                while ($ct = mysqli_fetch_row($count_for_arrays)) {
                                    /* place the number of responses in the correct array, in order to get a total response */
                                    if ($ct[1] == 1) {
                                        $agree_array[$j] = $ct[0];
                                    }
                                    if ($ct[1] == 2) {
                                        $somewhat_array[$j] = $ct[0];
                                    }
                                    if ($ct[1] == 3) {
                                        $disagree_array[$j] = $ct[0];
                                    }
                                }
                                include "../include/dbconnclose.php";
                            }
                            $agree_string = '';
                            $counter = 0;
                            foreach ($agree_array as $key => $value) {
                                $agree_string.='[' . $key . ', ' . $value . ']';
                                $counter++;
                                if ($counter < count($agree_array)) {
                                    $agree_string.=',';
                                }
                            }
                            $somewhat_string = '';
                            $counter = 0;
                            foreach ($somewhat_array as $key => $value) {
                                $somewhat_string.='[' . $key . ', ' . $value . ']';
                                $counter++;
                                if ($counter < count($somewhat_array)) {
                                    $somewhat_string.=',';
                                }
                            }
                            $disagree_string = '';
                            $counter = 0;
                            foreach ($disagree_array as $key => $value) {
                                $disagree_string.='[' . $key . ', ' . $value . ']';
                                $counter++;
                                if ($counter < count($disagree_array)) {
                                    $disagree_string.=',';
                                }
                            }
                            ?>
                            <!--Create the chart: -->

                            <!--[if IE]>
                           <script src="/include/excanvas_r3/excanvas.js"></script>
                           <![endif]-->
                           <!--<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>-->
                            <script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
                            <link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
                            <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.barRenderer.min.js"></script>
                            <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.categoryAxisRenderer.min.js"></script>
                            <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pointLabels.min.js"></script>

                            <script type="text/javascript">
                                var answers1 = [<?php echo $agree_string; ?>];
                                var answers2 = [<?php echo $somewhat_string; ?>];
                                var answers3 = [<?php echo $disagree_string; ?>];
                                var ticks = ['Improved Grades', 'New Friends', 'Improved<br>Math', 'Improved<br>Reading',
                                    'Help Kids<br>Stay Out<br>of Trouble',
                                    'Will Tell<br>Friends', 'Had Fun', 'Teacher<br>Suggested', 'Parents<br>Suggested', 'Self-chosen'];
                                $(document).ready(function() {
                                    var plot2 = $.jqplot('chart2', [answers1, answers2, answers3],
                                            {
                                                seriesDefaults: {
                                                    renderer: $.jqplot.BarRenderer,
                                                    pointLabels: {show: true, edgeTolerance: -15},
                                                    rendererOptions: {
                                                        barDirection: 'vertical',
                                                        barMargin: 10,
                                                        barWidth: 10
                                                    }
                                                },
                                                series: [
                                                    {label: '1. Agree'},
                                                    {label: '2. Somewhat Agree'},
                                                    {label: '3. Disagree'}
                                                ],
                                                // Show the legend and put it outside the grid, but inside the
                                                // plot container, shrinking the grid to accomodate the legend.
                                                // A value of "outside" would not shrink the grid and allow
                                                // the legend to overflow the container.
                                                legend: {
                                                    show: true,
                                                    placement: 'outsideGrid'
                                                },
                                                axes: {
                                                    yaxis: {
                                                        min: 0,
                                                        max: 10
                                                    },
                                                    xaxis: {
                                                        renderer: $.jqplot.CategoryAxisRenderer,
                                                        ticks: ticks,
                                                        min: 0,
                                                        max: 12
                                                    }
                                                }
                                            });
                                });

                            </script>
                            <div id="chart2" style="height: 300px; width: 1000px; position: relative; margin-left:auto; margin-right:auto;"></div>

                        </td>
                    </tr>
                            <?php } ?>
                <tr>


                    <td colspan="2"><!--Schedule for regular programs, neither parent mentor nor pm friday workshops -->
                        <h4 id="schedule">Schedule: </h4>
                        <table class="profile_table" id="program_schedule_table">
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            <!-- For campaigns......
                            Campaigns include names and types of events: -->
        <?php if ($program->issue_type == 'Campaign') { ?>

                                <tr class="no_view"><?php include "../include/datepicker.php"; ?>
                                    <td colspan="7"><strong>Add Date: </strong><input type="text" id="new_date" class="hadDatepicker">
                                        &nbsp;&nbsp;<span class="helptext">Dates must be entered in the format MM-DD-YYYY (or use the pop-up calendar).</span>
                                        <br/>
                                        <span class="helptext">If this date refers to a specific activity or event, please enter its name and event type: </span>
                                        <!--Type of event: -->
                                        <input type="text" value="Event name" id="date_activity_name">
                                        <select id="date_activity_type">
                                            <option value="">-----</option>
                                            <option value="1">Leadership Meeting</option>
                                            <option value="2">Board Meeting</option>
                                            <option value="3">Rally/March</option>
                                            <option value="4">Press Conference</option>
                                            <option value="5">Doorknocking</option>
                                            <option value="6">Aldermanic Meeting</option>
                                            <option value="7">City Council Meeting</option>
                                            <option value="8">Legislative Meeting</option>
                                            <option value="11">Meeting/Assembly</option>
                                            <option value="9">Petitions/Postcards</option>
                                            <option value="10">Other</option>
                                        </select>
                                        <!--Save a new date.  Check to make sure that the campaign doesn't already have an event on this date (deduplicate): -->
                                        <input type="button" value="Save" onclick="
                                            $.post(
                                                    '../ajax/program_duplicate_check.php',
                                                    {
                                                        date: document.getElementById('new_date').value,
                                                        subcategory: '<?php echo $program->program_id ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                if (response != '') {
                                                    var deduplicate = confirm(response);
                                                    if (deduplicate) {
                                                        $.post(
                                                                '../ajax/add_new_program_date.php',
                                                                {
                                                                    program_id: '<?php echo $program->program_id ?>',
                                                                    date: document.getElementById('new_date').value,
                                                                    name: document.getElementById('date_activity_name').value,
                                                                    type: document.getElementById('date_activity_type').options[document.getElementById('date_activity_type').selectedIndex].value
                                                                },
                                                        function(response) {
                                                            //document.write(response);
                                                            window.location = 'program_profile.php?schedule=1';
                                                        }
                                                        );
                                                    }
                                                }
                                                else {
                                                    $.post(
                                                            '../ajax/add_new_program_date.php',
                                                            {
                                                                program_id: '<?php echo $program->program_id ?>',
                                                                date: document.getElementById('new_date').value,
                                                                name: document.getElementById('date_activity_name').value,
                                                                type: document.getElementById('date_activity_type').options[document.getElementById('date_activity_type').selectedIndex].value
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location = 'program_profile.php?schedule=1';
                                                    }
                                                    );
                                                }
                                            }
                                            );
                                               ">
                                    </td>
                                </tr>
                                <tr>
                                    <!--Show the schedule: -->
                                    <th>Delete this Session</th><th>Session/Activity Name</th><th width="10%">Date</th>
                                    <th width="25%">Participants and Involvement Type</th><th>Session/Activity Type</th>
                                    <th>No. of Participants</th><th>Add/Remove Participants</th>
                                </tr>
            <?php
            date_default_timezone_set('America/Chicago');
            $dates = $program->get_dates();
            $attendance_num_array = array();
            $array_of_dates = array();
            $program_length = 0;
            while ($date = mysqli_fetch_array($dates)) {
                $program_length = $program_length + 1;
                ?>
                                    <tr>
                                        <td style="padding-bottom:0;"><input type="button"  class="no_view hide_on_view" value="Delete Session" onclick="
                                        var double_check = confirm('Are you sure you want to delete this session from the database?  This action cannot be undone.');
                                        if (double_check) {
                                            $.post(
                                                    '../ajax/delete_elements.php',
                                                    {
                                                        action: 'event',
                                                        id: '<?php echo $date['Wright_College_Program_Date_ID']; ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                alert('This session has been successfully deleted.');
                                            }
                                            );
                                        }"></td>
                                        <td style="padding-bottom:0;"><?php echo $date['Activity_Name']; ?></td>
                                        <td style="padding-bottom:0;"><?php
                                            $array_of_dates[] = $date['Date'];
                                            $datetime = new DateTime($date['Date']);
                                            //echo $date . "<br>";
                                            echo date_format($datetime, 'M d, Y');
                                            //echo $date['Program_Date'];
                                            ?></td>
                                        <td style="padding-bottom:0;">
                                            <?php
                                            $find_attendance_by_date = "SELECT * FROM Participants LEFT JOIN (Subcategory_Attendance)
                                ON (Participants.Participant_ID=Subcategory_Attendance.Participant_ID)
                                WHERE Subcategory_Attendance.Subcategory_Date='" . $date['Wright_College_Program_Date_ID'] . "' ORDER BY Participants.Name_Last";
                                            include "../include/dbconnopen.php";
                                            $attendees = mysqli_query($cnnLSNA, $find_attendance_by_date);
                                            $count = 0;

                                            /* show list of attendees, allow edits to their roles here. */
                                            while ($attendee = mysqli_fetch_array($attendees)) {
                                                $count = $count + 1;
                                                ?>
                                                <a href="javascript:;" onclick="
                                                    $.post(
                                                            '../ajax/set_participant_id.php',
                                                            {
                                                                page: 'profile',
                                                                participant_id: '<?php echo $attendee['Participant_ID']; ?>'
                                                            },
                                                    function(response) {
                                                        window.location = '../participants/participant_profile.php';
                                                    });"><?php echo $attendee['Name_First'] . " " . $attendee['Name_Last'] ?></a>&nbsp;
                                                <span class="show_role_<?php echo $attendee['Subcategory_Attendance_ID']; ?>">
                                                    <?php
                                                    if ($attendee['Type_of_Participation'] == '1') {
                                                        echo 'Attendee';
                                                    } elseif ($attendee['Type_of_Participation'] == '2') {
                                                        echo 'Speaker';
                                                    } elseif ($attendee['Type_of_Participation'] == '3') {
                                                        echo 'Chairperson';
                                                    } elseif ($attendee['Type_of_Participation'] == '4') {
                                                        echo 'Prep Work';
                                                    } elseif ($attendee['Type_of_Participation'] == '5') {
                                                        echo 'Staff';
                                                    }
                                                    ?>
                                                </span>
                                                <select class="attendee_role_edit role_<?php echo $attendee['Subcategory_Attendance_ID']; ?> no_view"
                                                        id="attendee_role" onchange="$.post(
                                                                                            '../ajax/save_attendee_role.php',
                                                                                            {
                                                                                                role: this.value,
                                                                                                attendee_date: '<?php echo $attendee['Subcategory_Attendance_ID']; ?>'
                                                                                            },
                                                                                    function(response) {
                                                                                        //document.write(response);
                                                                                        window.location = 'program_profile.php?schedule=1';
                                                                                    }
                                                                                    )">
                                                    <option value="">----------</option>
                                                    <option value="1" <?php echo ($attendee['Type_of_Participation'] == '1' ? 'selected="selected"' : null); ?>>Attendee</option>
                                                    <option value="2" <?php echo ($attendee['Type_of_Participation'] == '2' ? 'selected="selected"' : null); ?>>Speaker</option>
                                                    <option value="3" <?php echo ($attendee['Type_of_Participation'] == '3' ? 'selected="selected"' : null); ?>>Chairperson</option>
                                                    <option value="4" <?php echo ($attendee['Type_of_Participation'] == '4' ? 'selected="selected"' : null); ?>>Prep work</option>
                                                    <option value="5" <?php echo ($attendee['Type_of_Participation'] == '5' ? 'selected="selected"' : null); ?>>Staff</option>
                                                </select>&nbsp;&nbsp;<a class="helptext" href="javascript:;" onclick="
                                                                            $('.role_<?php echo $attendee['Subcategory_Attendance_ID']; ?>').toggle();
                                                                            $('.show_role_<?php echo $attendee['Subcategory_Attendance_ID']; ?>').toggle();
                                                                        "><em class="no_view" >edit...</em></a><br>
                                                <?php
                                            }
                                            include "../include/dbconnclose.php";
                                            ?>
                                        </td>
                                        <td style="padding-bottom:0;">
                                            <!--Show session/activity type: -->
                                            <?php
                                            if ($date['Activity_Type'] == 1) {
                                                echo 'Leadership Meeting';
                                            } elseif ($date['Activity_Type'] == 2) {
                                                echo 'Board Meeting';
                                            } elseif ($date['Activity_Type'] == 3) {
                                                echo 'Rally/March';
                                            } elseif ($date['Activity_Type'] == 4) {
                                                echo 'Press Conference';
                                            } elseif ($date['Activity_Type'] == 5) {
                                                echo 'Doorknocking';
                                            } elseif ($date['Activity_Type'] == 6) {
                                                echo 'Aldermanic Meeting';
                                            } elseif ($date['Activity_Type'] == 7) {
                                                echo 'City Council Meeting';
                                            } elseif ($date['Activity_Type'] == 8) {
                                                echo 'Legislative Meeting';
                                            } elseif ($date['Activity_Type'] == 9) {
                                                echo 'Petitions/Postcards';
                                            } elseif ($date['Activity_Type'] == 10) {
                                                echo 'Other';
                                            }
                                            ?>
                                        </td>
                                        <td style="padding-bottom:0;">
                                                <?php
                                                $attendance_num_array[] = $count;
                                                echo $count;
                                                ?>
                                        </td>
                                        <td class="no_view" style="padding-bottom:0;">
                                            <!--People in this dropdown are ONLY those who have already been added as campaign participants at the top right.-->
                                            <script src="/include/jquery/1.9.1/development-bundle/ui/jquery-ui.custom.js" type="text/javascript"></script>

                                            <input type="text" name="participant_name_<?php echo $date['Wright_College_Program_Date_ID'] ?>" id="participant_name_<?php echo $date['Wright_College_Program_Date_ID'] ?>" placeholder="Enter Participant Name" class="span3" />
                                            <div style="font-size: 10px;">
                                            Enter / select Participant Name, then click "Add" / "Delete"
                                            </div>
                                            
                                            <script>
                                                $(function() {
                                                  var availableTags = [
                                                    <?php
                                                    $get_current_participants = "SELECT * FROM Participants_Subcategories
                                                                INNER JOIN Participants ON Participants.Participant_ID=Participants_Subcategories.Participant_ID
                                                                WHERE Subcategory_ID='" . $program->program_id . "' ORDER BY Participants.Name_Last";
                                                    include "../include/dbconnopen.php";
                                                    $participants = mysqli_query($cnnLSNA, $get_current_participants);
                                                    include "../include/dbconnclose.php";
                                                    //while ($part = mysqli_fetch_array($participants)) {
                                                    
                                                    /*
                                                    include $_SERVER['DOCUMENT_ROOT'] . '/include/dbconnopen.php';
                                                    $family_heads = mysqli_query($cnnRSHF, "Call Participant__Get_Family_Heads()");
                                                    include $_SERVER['DOCUMENT_ROOT'] . '/include/dbconnclose.php';
                                                    */
                                                    $count = 0;
                                                    while ($part = mysqli_fetch_array($participants)) {
                                                        if ($count > 0) {
                                                            echo ",";
                                                        }
                                                        $count++;
                                                        ?>
                                                        {"value": "<?php echo $part['Name_First'] . ' ' . $part['Name_Last']; ?>", "participant_id": "<?php echo $part['Participant_ID']; ?>"}
                                                        <?php
                                                    }
                                                    ?>
                                                  ];
                                                  $("#participant_name_<?php echo $date['Wright_College_Program_Date_ID'] ?>").autocomplete({
                                                    source: availableTags,
                                                    select: function(event, ui) {
                                                        $('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val(ui.item.participant_id);
                                                        /*
                                                        
                                                        $.post(
                                                        './ajax/select_family_head.php',
                                                        {
                                                            family_id: ui.item.family_id
                                                        },
                                                        function(response) {
                                                                //alert(response);
                                                            if (response != '0') {
                                                                document.getElementById('family_members_list').innerHTML = response;
                                                                $('#family_members_list').slideDown('slow');
                                                                $('#add_event_message_box').stop().slideUp('slow');
                                                            } else {
                                                            }
                                                        });
                                                        */
                                                    }
                                                });
                                            });
                                            </script>
                                            
<!--
                                            <select id="choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>">
                                                <option value="">-----</option>
                                                <?php
                                                $get_current_participants = "SELECT * FROM Participants_Subcategories
                                                            INNER JOIN Participants ON Participants.Participant_ID=Participants_Subcategories.Participant_ID
                                                            WHERE Subcategory_ID='" . $program->program_id . "' ORDER BY Participants.Name_Last";
                                                include "../include/dbconnopen.php";
                                                $participants = mysqli_query($cnnLSNA, $get_current_participants);
                                                while ($part = mysqli_fetch_array($participants)) {
                                                    ?>
                                                    <option value="<?php echo $part['Participant_ID'] ?>"><?php echo $part['Name_First'] . " " . $part['Name_Last']; ?></option>
                                                    <?php
                                                }
                                                include "../include/dbconnclose.php";
                                                ?>
                                            </select><br/>
-->
                                            
                                            <input type="hidden" id="choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>" />
                                            
                                            <input type="button" value="Add" onclick="
                                                if ($('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val() != '') {
                                                    $.post(
                                                            '../ajax/add_attendee.php',
                                                            {
                                                                program_date_id: '<?php echo $date['Wright_College_Program_Date_ID'] ?>',
                                                                user_id: $('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val()
                                                                //user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').selectedIndex].value
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location = 'program_profile.php?schedule=1';
                                                    }
                                                    )
                                                }">
                                            <!-- Choose the attendee from the select area and click remove.  S/he will be deleted from the list of attendees for the session. -->
                                            <input type="button" value="Remove" onclick="
                                            //alert(document.getElementById('choose_from_current_participants').options[document.getElementById('choose_from_current_participants').selectedIndex].value);
                                                if ($('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val() != '') {
                                                    $.post(
                                                            '../ajax/remove_attendee.php',
                                                            {
                                                                program_date_id: '<?php echo $date['Wright_College_Program_Date_ID'] ?>',
                                                                user_id: $('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val()
                                                                //user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').selectedIndex].value
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location = 'program_profile.php?schedule=1';
                                                    }
                                                    )
                                            }">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:0;"></td>
                                        <td colspan="6" style="padding-top:0;"><a href="javascript:;" onclick="$('#meeting_note_<?php echo $date['Wright_College_Program_Date_ID'] ?>').slideToggle();">Add/view meeting notes:</a><br/>
                                            <textarea class="hide_notes" id="meeting_note_<?php echo $date['Wright_College_Program_Date_ID'] ?>" onchange="
                                            var note = this.value;
                                            $.post(
                                                    '../ajax/add_new_program_date.php',
                                                    {
                                                        action: 'save_note',
                                                        note: note,
                                                        event: '<?php echo $date['Wright_College_Program_Date_ID'] ?>'
                                                    },
                                            function(response) {
                                                window.location = 'program_profile.php?schedule=1';
                                            }
                                            )" rows="6" cols="50"><?php echo $date['Meeting_Note']; ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="padding:0;"><hr style="color:#696969; border-style:inset; margin:0;" /></td>
                                    </tr>
                                            <?php
                                        }
                                        ?>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                <!-- For programs......
                                Same schedule, but no names for the activities nor types.
                                -->
                                    <?php } else if ($program->issue_type == 'Program') {
                                        ?>
                                <tr class="no_view">
                                    <td colspan="7"><strong>Add Date:</strong><input type="text" id="new_date" class="hadDatepicker">
                                        &nbsp;&nbsp;<span class="helptext">Dates must be entered in the format MM-DD-YYYY (or use the pop-up calendar).</span>
                                        <br/>
                                        <span class="helptext">If this date refers to a specific activity or event, please enter its name and event type: </span>
                                        <!--Type of event: -->
                                        <input type="text" value="Event name" id="date_activity_name">
                                        <select id="date_activity_type">
                                            <option value="">-----</option>
                                            <option value="1">Leadership Meeting</option>
                                            <option value="2">Board Meeting</option>
                                            <option value="3">Rally/March</option>
                                            <option value="4">Press Conference</option>
                                            <option value="5">Doorknocking</option>
                                            <option value="6">Aldermanic Meeting</option>
                                            <option value="7">City Council Meeting</option>
                                            <option value="8">Legislative Meeting</option>
                                            <option value="11">Meeting/Assembly</option>
                                            <option value="9">Petitions/Postcards</option>
                                            <option value="10">Other</option>
                                        </select>
                                        <!--Save a new date.  Check to make sure that the campaign doesn't already have an event on this date (deduplicate): -->
                                        <input type="button" value="Save" onclick="
                                            $.post(
                                                    '../ajax/program_duplicate_check.php',
                                                    {
                                                        date: document.getElementById('new_date').value,
                                                        subcategory: '<?php echo $program->program_id ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                if (response != '') {
                                                    var deduplicate = confirm(response);
                                                    if (deduplicate) {
                                                        $.post(
                                                                '../ajax/add_new_program_date.php',
                                                                {
                                                                    program_id: '<?php echo $program->program_id ?>',
                                                                    date: document.getElementById('new_date').value,
                                                                    name: document.getElementById('date_activity_name').value,
                                                                    type: document.getElementById('date_activity_type').options[document.getElementById('date_activity_type').selectedIndex].value
                                                                },
                                                        function(response) {
                                                            //document.write(response);
                                                            window.location = 'program_profile.php?schedule=1';
                                                        }
                                                        );
                                                    }
                                                }
                                                else {
                                                    $.post(
                                                            '../ajax/add_new_program_date.php',
                                                            {
                                                                program_id: '<?php echo $program->program_id ?>',
                                                                date: document.getElementById('new_date').value,
                                                                name: document.getElementById('date_activity_name').value,
                                                                type: document.getElementById('date_activity_type').options[document.getElementById('date_activity_type').selectedIndex].value
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location = 'program_profile.php?schedule=1';
                                                    }
                                                    );
                                                }
                                            }
                                            );
                                               ">
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <th>Date</th><th width="25%">Participants</th><th>No. of Participants</th><th>Add/Remove Participants</th> -->
                                    <!--Show the schedule: -->
                                    <th>Delete this Session</th><th>Session/Activity Name</th><th width="10%">Date</th>
                                    <th width="25%">Participants and Involvement Type</th><th>Session/Activity Type</th>
                                    <th>No. of Participants</th><th>Add/Remove Participants</th>
                                </tr>
                                        <?php
                                        date_default_timezone_set('America/Chicago');
                                        $dates = $program->get_dates();
                                        $attendance_num_array = array();
                                        $array_of_dates = array();
                                        $program_length = 0;
                                        while ($date = mysqli_fetch_array($dates)) {
                                            $program_length = $program_length + 1;
                                            ?>
                                
                                
                                
                                
                                
                                
                                <tr>
                                        <td style="padding-bottom:0;"><input type="button"  class="no_view hide_on_view" value="Delete Session" onclick="
                                        var double_check = confirm('Are you sure you want to delete this session from the database?  This action cannot be undone.');
                                        if (double_check) {
                                            $.post(
                                                    '../ajax/delete_elements.php',
                                                    {
                                                        action: 'event',
                                                        id: '<?php echo $date['Wright_College_Program_Date_ID']; ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                alert('This session has been successfully deleted.');
                                            }
                                            );
                                        }"></td>
                                        <td style="padding-bottom:0;"><?php echo $date['Activity_Name']; ?></td>
                                        <td style="padding-bottom:0;"><?php
                                            $array_of_dates[] = $date['Date'];
                                            $datetime = new DateTime($date['Date']);
                                            //echo $date . "<br>";
                                            echo date_format($datetime, 'M d, Y');
                                            //echo $date['Program_Date'];
                                            ?></td>
                                        <td style="padding-bottom:0;">
                                            <?php
                                            $find_attendance_by_date = "SELECT * FROM Participants LEFT JOIN (Subcategory_Attendance)
                                ON (Participants.Participant_ID=Subcategory_Attendance.Participant_ID)
                                WHERE Subcategory_Attendance.Subcategory_Date='" . $date['Wright_College_Program_Date_ID'] . "' ORDER BY Participants.Name_Last";
                                            include "../include/dbconnopen.php";
                                            $attendees = mysqli_query($cnnLSNA, $find_attendance_by_date);
                                            $count = 0;

                                            /* show list of attendees, allow edits to their roles here. */
                                            while ($attendee = mysqli_fetch_array($attendees)) {
                                                $count = $count + 1;
                                                ?>
                                                <a href="javascript:;" onclick="
                                                    $.post(
                                                            '../ajax/set_participant_id.php',
                                                            {
                                                                page: 'profile',
                                                                participant_id: '<?php echo $attendee['Participant_ID']; ?>'
                                                            },
                                                    function(response) {
                                                        window.location = '../participants/participant_profile.php';
                                                    });"><?php echo $attendee['Name_First'] . " " . $attendee['Name_Last'] ?></a>&nbsp;
                                                <span class="show_role_<?php echo $attendee['Subcategory_Attendance_ID']; ?>">
                                                    <?php
                                                    if ($attendee['Type_of_Participation'] == '1') {
                                                        echo 'Attendee';
                                                    } elseif ($attendee['Type_of_Participation'] == '2') {
                                                        echo 'Speaker';
                                                    } elseif ($attendee['Type_of_Participation'] == '3') {
                                                        echo 'Chairperson';
                                                    } elseif ($attendee['Type_of_Participation'] == '4') {
                                                        echo 'Prep Work';
                                                    } elseif ($attendee['Type_of_Participation'] == '5') {
                                                        echo 'Staff';
                                                    }
                                                    ?>
                                                </span>
                                                <select class="attendee_role_edit role_<?php echo $attendee['Subcategory_Attendance_ID']; ?> no_view"
                                                        id="attendee_role" onchange="$.post(
                                                                                            '../ajax/save_attendee_role.php',
                                                                                            {
                                                                                                role: this.value,
                                                                                                attendee_date: '<?php echo $attendee['Subcategory_Attendance_ID']; ?>'
                                                                                            },
                                                                                    function(response) {
                                                                                        //document.write(response);
                                                                                        window.location = 'program_profile.php?schedule=1';
                                                                                    }
                                                                                    )">
                                                    <option value="">----------</option>
                                                    <option value="1" <?php echo ($attendee['Type_of_Participation'] == '1' ? 'selected="selected"' : null); ?>>Attendee</option>
                                                    <option value="2" <?php echo ($attendee['Type_of_Participation'] == '2' ? 'selected="selected"' : null); ?>>Speaker</option>
                                                    <option value="3" <?php echo ($attendee['Type_of_Participation'] == '3' ? 'selected="selected"' : null); ?>>Chairperson</option>
                                                    <option value="4" <?php echo ($attendee['Type_of_Participation'] == '4' ? 'selected="selected"' : null); ?>>Prep work</option>
                                                    <option value="5" <?php echo ($attendee['Type_of_Participation'] == '5' ? 'selected="selected"' : null); ?>>Staff</option>
                                                </select>&nbsp;&nbsp;<a class="helptext" href="javascript:;" onclick="
                                                                            $('.role_<?php echo $attendee['Subcategory_Attendance_ID']; ?>').toggle();
                                                                            $('.show_role_<?php echo $attendee['Subcategory_Attendance_ID']; ?>').toggle();
                                                                        "><em class="no_view" >edit...</em></a><br>
                                                <?php
                                            }
                                            include "../include/dbconnclose.php";
                                            ?>
                                        </td>
                                        <td style="padding-bottom:0;">
                                            <!--Show session/activity type: -->
                                            <?php
                                            if ($date['Activity_Type'] == 1) {
                                                echo 'Leadership Meeting';
                                            } elseif ($date['Activity_Type'] == 2) {
                                                echo 'Board Meeting';
                                            } elseif ($date['Activity_Type'] == 3) {
                                                echo 'Rally/March';
                                            } elseif ($date['Activity_Type'] == 4) {
                                                echo 'Press Conference';
                                            } elseif ($date['Activity_Type'] == 5) {
                                                echo 'Doorknocking';
                                            } elseif ($date['Activity_Type'] == 6) {
                                                echo 'Aldermanic Meeting';
                                            } elseif ($date['Activity_Type'] == 7) {
                                                echo 'City Council Meeting';
                                            } elseif ($date['Activity_Type'] == 8) {
                                                echo 'Legislative Meeting';
                                            } elseif ($date['Activity_Type'] == 9) {
                                                echo 'Petitions/Postcards';
                                            } elseif ($date['Activity_Type'] == 10) {
                                                echo 'Other';
                                            }
                                            ?>
                                        </td>
                                        <td style="padding-bottom:0;">
                                                <?php
                                                $attendance_num_array[] = $count;
                                                echo $count;
                                                ?>
                                        </td>
                                        <td class="no_view" style="padding-bottom:0;">
                                            <!--People in this dropdown are ONLY those who have already been added as campaign participants at the top right.-->
                                            <script src="/include/jquery/1.9.1/development-bundle/ui/jquery-ui.custom.js" type="text/javascript"></script>

                                            <input type="text" name="participant_name_<?php echo $date['Wright_College_Program_Date_ID'] ?>" id="participant_name_<?php echo $date['Wright_College_Program_Date_ID'] ?>" placeholder="Enter Participant Name" class="span3" />
                                            <div style="font-size: 10px;">
                                            Enter / select Participant Name, then click "Add" / "Delete"
                                            </div>
                                            
                                            <script>
                                                $(function() {
                                                  var availableTags = [
                                                    <?php
                                                    $get_current_participants = "SELECT * FROM Participants_Subcategories
                                                                INNER JOIN Participants ON Participants.Participant_ID=Participants_Subcategories.Participant_ID
                                                                WHERE Subcategory_ID='" . $program->program_id . "' ORDER BY Participants.Name_Last";
                                                    include "../include/dbconnopen.php";
                                                    $participants = mysqli_query($cnnLSNA, $get_current_participants);
                                                    include "../include/dbconnclose.php";
                                                    //while ($part = mysqli_fetch_array($participants)) {
                                                    
                                                    /*
                                                    include $_SERVER['DOCUMENT_ROOT'] . '/include/dbconnopen.php';
                                                    $family_heads = mysqli_query($cnnRSHF, "Call Participant__Get_Family_Heads()");
                                                    include $_SERVER['DOCUMENT_ROOT'] . '/include/dbconnclose.php';
                                                    */
                                                    $count = 0;
                                                    while ($part = mysqli_fetch_array($participants)) {
                                                        if ($count > 0) {
                                                            echo ",";
                                                        }
                                                        $count++;
                                                        ?>
                                                        {"value": "<?php echo $part['Name_First'] . ' ' . $part['Name_Last']; ?>", "participant_id": "<?php echo $part['Participant_ID']; ?>"}
                                                        <?php
                                                    }
                                                    ?>
                                                  ];
                                                  $("#participant_name_<?php echo $date['Wright_College_Program_Date_ID'] ?>").autocomplete({
                                                    source: availableTags,
                                                    select: function(event, ui) {
                                                        $('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val(ui.item.participant_id);
                                                        /*
                                                        
                                                        $.post(
                                                        './ajax/select_family_head.php',
                                                        {
                                                            family_id: ui.item.family_id
                                                        },
                                                        function(response) {
                                                                //alert(response);
                                                            if (response != '0') {
                                                                document.getElementById('family_members_list').innerHTML = response;
                                                                $('#family_members_list').slideDown('slow');
                                                                $('#add_event_message_box').stop().slideUp('slow');
                                                            } else {
                                                            }
                                                        });
                                                        */
                                                    }
                                                });
                                            });
                                            </script>
                                            
<!--
                                            <select id="choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>">
                                                <option value="">-----</option>
                                                <?php
                                                $get_current_participants = "SELECT * FROM Participants_Subcategories
                                                            INNER JOIN Participants ON Participants.Participant_ID=Participants_Subcategories.Participant_ID
                                                            WHERE Subcategory_ID='" . $program->program_id . "' ORDER BY Participants.Name_Last";
                                                include "../include/dbconnopen.php";
                                                $participants = mysqli_query($cnnLSNA, $get_current_participants);
                                                while ($part = mysqli_fetch_array($participants)) {
                                                    ?>
                                                    <option value="<?php echo $part['Participant_ID'] ?>"><?php echo $part['Name_First'] . " " . $part['Name_Last']; ?></option>
                                                    <?php
                                                }
                                                include "../include/dbconnclose.php";
                                                ?>
                                            </select><br/>
-->
                                            
                                            <input type="hidden" id="choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>" />
                                            
                                            <input type="button" value="Add" onclick="
                                                if ($('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val() != '') {
                                                    $.post(
                                                            '../ajax/add_attendee.php',
                                                            {
                                                                program_date_id: '<?php echo $date['Wright_College_Program_Date_ID'] ?>',
                                                                user_id: $('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val()
                                                                //user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').selectedIndex].value
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location = 'program_profile.php?schedule=1';
                                                    }
                                                    )
                                                }">
                                            <!-- Choose the attendee from the select area and click remove.  S/he will be deleted from the list of attendees for the session. -->
                                            <input type="button" value="Remove" onclick="
                                            //alert(document.getElementById('choose_from_current_participants').options[document.getElementById('choose_from_current_participants').selectedIndex].value);
                                                if ($('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val() != '') {
                                                    $.post(
                                                            '../ajax/remove_attendee.php',
                                                            {
                                                                program_date_id: '<?php echo $date['Wright_College_Program_Date_ID'] ?>',
                                                                user_id: $('#choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').val()
                                                                //user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').selectedIndex].value
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location = 'program_profile.php?schedule=1';
                                                    }
                                                    )
                                            }">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:0;"></td>
                                        <td colspan="6" style="padding-top:0;"><a href="javascript:;" onclick="$('#meeting_note_<?php echo $date['Wright_College_Program_Date_ID'] ?>').slideToggle();">Add/view meeting notes:</a><br/>
                                            <textarea class="hide_notes" id="meeting_note_<?php echo $date['Wright_College_Program_Date_ID'] ?>" onchange="
                                            var note = this.value;
                                            $.post(
                                                    '../ajax/add_new_program_date.php',
                                                    {
                                                        action: 'save_note',
                                                        note: note,
                                                        event: '<?php echo $date['Wright_College_Program_Date_ID'] ?>'
                                                    },
                                            function(response) {
                                                window.location = 'program_profile.php?schedule=1';
                                            }
                                            )" rows="6" cols="50"><?php echo $date['Meeting_Note']; ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="padding:0;"><hr style="color:#696969; border-style:inset; margin:0;" /></td>
                                    </tr>
                                
                                
                                
                                
                                
                                
                                <?php /*
                                    <tr>
                                        <td><?php
                                            $array_of_dates[] = $date['Date'];
                                            $datetime = new DateTime($date['Date']);
                                            //echo $date . "<br>";
                                            echo date_format($datetime, 'M d, Y');
                                            //echo $date['Program_Date'];
                                            ?></td>
                                        <td>
                                            <?php
                                            $find_attendance_by_date = "SELECT * FROM Participants LEFT JOIN (Subcategory_Attendance)
                                ON (Participants.Participant_ID=Subcategory_Attendance.Participant_ID)
                                WHERE Subcategory_Attendance.Subcategory_Date='" . $date['Wright_College_Program_Date_ID'] . "' ORDER BY Participants.Name_Last";
                                            include "../include/dbconnopen.php";
                                            $attendees = mysqli_query($cnnLSNA, $find_attendance_by_date);
                                            $count = 0;

                                            while ($attendee = mysqli_fetch_array($attendees)) {
                                                $count = $count + 1;
                                                ?>
                                                <a href="javascript:;" onclick="
                                                    $.post(
                                                            '../ajax/set_participant_id.php',
                                                            {
                                                                page: 'profile',
                                                                participant_id: '<?php echo $attendee['Participant_ID']; ?>'
                                                            },
                                                    function(response) {
                                                        window.location = '../participants/participant_profile.php';
                                                    });
                                                   "><?php echo $attendee['Name_First'] . " " . $attendee['Name_Last'] ?></a>&nbsp;
                                                <br>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?>
                                        </td>
                                        <td>

                                                <?php
                                                $attendance_num_array[] = $count;
                                                echo $count;
                                                ?>
                                        </td>
                                        <td class="no_view">
                                            <!--Again, this select is only pulling from people who have been added as participants at the top right. -->
                                            <select id="choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>">
                                                <option value="">-----</option>
                <?php
                $get_current_participants = "SELECT * FROM Participants_Subcategories
                            INNER JOIN Participants ON Participants.Participant_ID=Participants_Subcategories.Participant_ID
                            WHERE Subcategory_ID='" . $program->program_id . "' ORDER BY Participants.Name_Last";
                include "../include/dbconnopen.php";
                $participants = mysqli_query($cnnLSNA, $get_current_participants);
                while ($part = mysqli_fetch_array($participants)) {
                    ?>
                                                    <option value="<?php echo $part['Participant_ID'] ?>"><?php echo $part['Name_First'] . " " . $part['Name_Last']; ?></option>
                                                <?php
                                            }
                                            include "../include/dbconnclose.php";
                                            ?>
                                            </select><br/>

                                            <input type="button" value="Add" onclick="
                                            //alert(document.getElementById('choose_from_current_participants').options[document.getElementById('choose_from_current_participants').selectedIndex].value);
                                            $.post(
                                                    '../ajax/add_attendee.php',
                                                    {
                                                        program_date_id: '<?php echo $date['Wright_College_Program_Date_ID'] ?>',
                                                        user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').selectedIndex].value
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'program_profile.php?schedule=1';
                                            }
                                            )">  
                                            <!--Removes the person from the attendance list for this date, not from the program entirely: -->
                                            <input type="button" value="Remove" onclick="
                                            //alert(document.getElementById('choose_from_current_participants').options[document.getElementById('choose_from_current_participants').selectedIndex].value);
                                            $.post(
                                                    '../ajax/remove_attendee.php',
                                                    {
                                                        program_date_id: '<?php echo $date['Wright_College_Program_Date_ID'] ?>',
                                                        user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').selectedIndex].value
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'program_profile.php?schedule=1';
                                            }
                                            )">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding:0;"><hr style="color:#696969; border-style:inset; margin:0;" /></td>
                                    </tr>

                <?php */ }
            }
            ?>
                        </table>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?php
        }
        /* aaaand for the parent mentor program!  just has to be a special snowflake:
         * Essentially I think anything above that was supposedly for the parent mentor program is invalid, because all of the parent mentor
         * program page is shown here (until about line 1464)
         */ else if ($_COOKIE['program'] == 19) {
            ?>
        <h3>Program Profile: Parent Mentor Program</h3><hr/><br/>
        <!--Link to workshop profile: -->
        <div style="text-align:center;"><a class="helptext" href="javascript:;" onclick="
                    $.post(
                            '../ajax/set_program_id.php',
                            {
                                id: '53'
                            },
                    function(response) {
                        //alert(response);
                        if (response != '1') {
                            document.getElementById('show_error').innerHTML = response;
                        }
                        window.location = 'program_profile.php';
                    }
                    )" style="font-size:.9em;">View the Parent Mentor Friday Workshop Program Profile</a></div><br/>
        <table class="profile_table">
            <tr>
                <td width="50%"><!--Basic program info-->
                    <table class="inner_table" style="border:2px solid #696969;">
                        <tr>
                            <td width="30%"><strong>Name:</strong></td>
                            <td><span class="displayed_info"><?php echo $program->program_name; ?></span>
                                <input style="width:100%;" type="text" value="<?php echo $program->program_name; ?>" id="edit_name" class="show_edit_space">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Issue Area:</strong></td>
                            <td><span class="displayed_info"><?php
                                    $find_org = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links)
                                    ON Categories.Category_ID=Category_Subcategory_Links.Category_ID
                                    WHERE Subcategory_ID='" . $program->program_id . "'";
                                    // echo $find_org;
                                    include "../include/dbconnopen.php";
                                    $org = mysqli_query($cnnLSNA, $find_org);
                                    while ($partner = mysqli_fetch_array($org)) {
                                        echo $partner['Category_Name'] . "<br>";
                                    }
                                    include "../include/dbconnclose.php";
                                    ?></span>
                                <select id="edit_type" class="show_edit_space">
                                    <option value="">-----</option>
    <?php
    $program_query = "SELECT * FROM Categories";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnLSNA, $program_query);
    while ($prog = mysqli_fetch_array($programs)) {
        ?>
                                        <option value="<?php echo $prog['Category_ID']; ?>" <?php echo ($partner['Category_ID'] == $prog['Category_ID'] ? 'selected="selected"' : null); ?>><?php echo $prog['Category_Name']; ?></option>
        <?php
    }
    include "../include/dbconnclose.php";
    ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><strong>Program or Campaign:</strong></td>
                            <td><span class="displayed_info"><?php echo $program->issue_type; ?></span>
                                <select id="issue_type" class="show_edit_space">
                                    <option value="">-----</option>
                                    <option value="program" <?php echo ($program->issue_type == 'Program' ? 'selected="selected"' : null); ?>>Program</option>
                                    <option value="campaign" <?php echo ($program->issue_type == 'Campaign' ? 'selected="selected"' : null); ?>>Campaign</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Number of Total Participants:</strong></td>
                            <td><?php
                                $get_participant_num = "SELECT * FROM Participants LEFT JOIN (Participants_Subcategories)
                                ON (Participants.Participant_ID=Participants_Subcategories.Participant_ID)
                                WHERE Participants_Subcategories.Subcategory_ID='" . $program->program_id . "'";
                                include "../include/dbconnopen.php";
                                $get_num = mysqli_query($cnnLSNA, $get_participant_num);
                                $num = mysqli_num_rows($get_num);
                                echo $num;
                                include "../include/dbconnclose.php";
                                ?></td>
                        </tr>
                        <tr>
                            <td><strong>Notes:</strong></td>
                            <td><textarea id="program_notes" class="no_view"  onchange="
                                    $.post(
                                            '../ajax/save_notes.php',
                                            {
                                                type: 'program',
                                                id: '<?php echo $program->program_id; ?>',
                                                note: this.value
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = 'program_profile.php';
                                    }
                                    )"><?php echo $program->notes; ?></textarea><p class="helptext no_view">(only 400 characters will be saved in the database)</p></td>
                        </tr>
                        <tr>
                            <td><input type="button" class="no_view"  value="Edit Program Information" onclick="
                                    $('.displayed_info').toggle();
                                    $('.show_edit_space').toggle();
                                       "></td>
                            <td><input type="button" value="Save Changes" class="show_edit_space" onclick="
                                    $.post(
                                            '../ajax/edit_program.php',
                                            {
                                                name: document.getElementById('edit_name').value,
                                                issue_type: document.getElementById('issue_type').value,
                                                type: document.getElementById('edit_type').options[document.getElementById('edit_type').selectedIndex].value,
                                                id: '<?php echo $program->program_id; ?>'
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = 'program_profile.php';
                                    }
                                    )"></td>
                        </tr>
                    </table><br/><br/>
                    <br/>
                    <!--Add new program participants: 
                    First, search for the person to be added -->
                    <a class="search_toggle no_view" onclick="
                            $('#user_search').toggle();
                       "><em class="no_view" >Add Participant: Search</em></a>

                    <div id="user_search" style="font-size:.8em;">
                        <table class="inner_table">
                            <tr>
                                <td><strong>First Name: </strong></td>
                                <td><input type="text" id="first_name" style="width:100px;" /></td>
                                <td><strong>Role: </strong></td>
                                <td><select id="role">
                                        <option value="">--------</option>
    <?php
    $get_roles = "SELECT * FROM Roles";
    include "../include/dbconnopen.php";
    $roles = mysqli_query($cnnLSNA, $get_roles);
    while ($role = mysqli_fetch_array($roles)) {
        ?>
                                            <option value="<?php echo $role['Role_ID']; ?>"><?php echo $role['Role_Title']; ?></option>
    <?php
    }
    include "../include/dbconnclose.php";
    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Last Name: </strong></td>
                                <td><input type="text" id="last_name" style="width:100px;" /></td>
                                <td><strong>Gender: </strong></td>
                                <td><select id="gender">
                                        <option value="">--------</option>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Date of Birth: </strong></td>
                                <td><input type="text" id="dob" class="hadDatepicker" style="width:100px;" /></td>
                                <td><strong>Grade Level: </strong></td>
                                <td><select id="grade">
                                        <option value="">--------</option>
                                        <option value="k">Kindergarten</option>
                                        <option value="1">1st Grade</option>
                                        <option value="2">2nd Grade</option>
                                        <option value="3">3rd Grade</option>
                                        <option value="4">4th Grade</option>
                                        <option value="5">5th Grade</option>
                                        <option value="6">6th Grade</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <input type="button" value="Search" onclick="
                                    $.post(
                                            '../ajax/search_participants.php',
                                            {
                                                result: 'dropdown',
                                                first: document.getElementById('first_name').value,
                                                last: document.getElementById('last_name').value,
                                                dob: document.getElementById('dob').value,
                                                grade: document.getElementById('grade').value,
                                                gender: document.getElementById('gender').options[document.getElementById('gender').selectedIndex].value,
                                                role: document.getElementById('role').options[document.getElementById('role').selectedIndex].value
                                            },
                                    function(response) {
                                        document.getElementById('show_results').innerHTML = response;
                                        $('#add_participant').show();
                                    }
                                    );
                                           "/>
                                </td>
                            </tr>
                        </table>
                        <!--Once search results come back, choose the school and the year for which this person was a parent mentor: 
                        (to add multiple schools/years, search for the person again)-->
                        <div id="show_results"></div>
                        <span id="add_participant">
                            <span class="helptext">Select the school this parent is associated with: </span><select id="pm_school">
                                <option value="">---------</option>
                            <?php
                            $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1' ORDER BY Institution_Name";
                            include "../include/dbconnopen.php";
                            $schools = mysqli_query($cnnLSNA, $get_schools);
                            while ($school = mysqli_fetch_array($schools)) {
                                ?>
                                    <option value="<?php echo $school['Institution_ID']; ?>"><?php echo $school['Institution_Name']; ?></option>
        <?php
    }
    include "../dbconnclose.php";
    ?>
                            </select><br/>
    <?php
//get the date so that you can find the school year
    $this_month = date('m');
    $this_year = date('Y');
    if ($this_month > 7) {
        $school_year = $this_year + 1;
    } else {
        $school_year = $this_year;
    }
//$school_year=2011;
    ?><span class="helptext">Select a year: </span>
                            <select id="year_chosen"><option value="">------</option>

                                <option value="1011" <?php echo ($school_year == 2011 ? 'selected=="selected"' : null) ?>>2010-11</option>
                                <option value="1112" <?php echo ($school_year == 2012 ? 'selected=="selected"' : null) ?>>2011-12</option>
                                <option value="1213" <?php echo ($school_year == 2013 ? 'selected=="selected"' : null) ?>>2012-13</option>
                                <option value="1314" <?php echo ($school_year == 2014 ? 'selected=="selected"' : null) ?>>2013-14</option>
                                <option value="1415" <?php echo ($school_year == 2015 ? 'selected=="selected"' : null) ?>>2014-15</option>
                                <option value="1516" <?php echo ($school_year == 2016 ? 'selected=="selected"' : null) ?>>2015-16</option>
                                <option value="1617" <?php echo ($school_year == 2017 ? 'selected=="selected"' : null) ?>>2016-17</option>
                            </select><br/>
                            <span class="helptext">(You must select a person, school, and year for this information to save correctly.)</span>
                            <input type="button" value="Add Participant" id="add_button" onclick="
                            $.post(
                                    '../ajax/add_participant_to_program.php',
                                    {
                                        participant: document.getElementById('relative_search').options[document.getElementById('relative_search').selectedIndex].value,
                                        subcategory: '<?php echo $program->program_id; ?>',
                                        school: document.getElementById('pm_school').options[document.getElementById('pm_school').selectedIndex].value,
                                        year: document.getElementById('year_chosen').value
                                    },
                            function(response) {
                                //document.write(response);
                                window.location = 'program_profile.php';
                            }
                            )"></span>
                    </div>
                    <br/>&nbsp<p>
    <?php if ($program->program_id == 19 || $program->program_id == 53) { ?>
                            <!--This probably shouldn't be here, since the parent mentor program wouldn't have satisfaction surveys.
                            Those are for children in after-school programs. -->
                            <a href="/lsna/programs/new_satisfaction_survey.php" class="no_view">Add Satisfaction Survey</a></p><?php } ?>
                </td>
                <td>

                    <!--The top right of the parent mentor profile.  Shows all the listed schools with their associated mentors.-->

                    <span class="helptext">Click on a school heading to view the list of Parent Mentors for that school.</span>	<br/><br/>	
                        <?php
                        $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1' ORDER BY Institution_Name";
                        include "../include/dbconnopen.php";
                        $schools = mysqli_query($cnnLSNA, $get_schools);
                        while ($school = mysqli_fetch_array($schools)) {
                            /* this while creates the list of schools */
                            ?>
                        <a href="javascript:;" style="text-decoration:none;" onclick="
                                                        $('#school_<?php echo $school['Institution_ID']; ?>_details').slideToggle();
                           "><h4 style="text-align:left;margin-left:20px;background-color:#f2f2f2;padding:2px 5px;border:1px solid #696969;"><?php echo $school['Institution_Name']; ?></h4></a>
                        <div id="school_<?php echo $school['Institution_ID']; ?>_details" class="detail_expand" style="margin-left:25px;">
                            <?php
                            $get_PMs = "SELECT * FROM Participants INNER JOIN Institutions_Participants ON Institutions_Participants.Participant_ID=Participants.Participant_ID
                                                            INNER JOIN PM_Years ON Participant=Participant_ID AND School='" . $school['Institution_ID'] . "'
                                                            WHERE Institutions_Participants.Institution_ID='" . $school['Institution_ID'] . "' AND Institutions_Participants.Is_PM='1'";
                            $get_PMs = "SELECT * FROM Participants 
                                                            INNER JOIN Institutions_Participants 
                                                                    ON Institutions_Participants.Participant_ID=Participants.Participant_ID
                                                            LEFT JOIN PM_Years ON (Participant=Participants.Participant_ID AND School=Institutions_Participants.Institution_ID)
                                                                WHERE Institutions_Participants.Institution_ID='" . $school['Institution_ID'] . "'
                                                                    AND Institutions_Participants.Is_PM='1'
                                                                    GROUP BY Participants.Participant_ID, Year";
                            // echo $get_PMs;
                            // $get_PMs="SELECT * FROM Participants INNER JOIN PM_Years ON Participant=Participant_ID AND School='" . $school['Institution_ID'] . "'";
                            $PMs = mysqli_query($cnnLSNA, $get_PMs);
                            while ($PM = mysqli_fetch_array($PMs)) {
                                /* creates the list of parent mentors for this school, with links to their profiles: */
                                ?>
                                <a href="javascript:;" onclick="
                                                                            $.post(
                                                                                    '../ajax/set_participant_id.php',
                                                                                    {
                                                                                        page: 'profile',
                                                                                        participant_id: '<?php echo $PM['Participant_ID']; ?>'
                                                                                    },
                                                                            function(response) {
                                                                                if (response != '1') {
                                                                                    document.getElementById('show_error').innerHTML = response;
                                                                                }
                                                                                window.location = '../participants/participant_profile.php';
                                                                            }
                                                                            );
                                   " style="font-size:1.1em;padding-left:30px;"><strong><?php echo $PM['Name_First'] . " " . $PM['Name_Last']; ?></strong></a> 
                                    <?php
                                    /* shows year(s) in which this parent mentor worked at this school. */
                                    if ($PM['Year'] != '') {
                                        $show_year = str_split($PM['Year'], 2);
                                        echo '20' . $show_year[0] . '-20' . $show_year[1];
                                    }
                                    ?>
                                <!--Expand for surveys and attendance: -->
                                <a href="javascript:;" onclick="
                                                                            $('#PM_<?php echo $PM['Participant_ID']; ?>_details').slideToggle();
                                   " class="helptext" style="color:#3954A2">show/hide details...</a>
                                <div class="detail_expand" id="PM_<?php echo $PM['Participant_ID']; ?>_details" style="padding-left:50px;">
                                    <h5>Surveys</h5>
                                        <?php
                                                                $get_surveys = "SELECT * FROM Parent_Mentor_Survey WHERE Participant_ID='" . $PM['Participant_ID'] . "' ORDER BY Date";
                                                                $surveys = mysqli_query($cnnLSNA, $get_surveys);
                                                                while ($survey = mysqli_fetch_array($surveys)) {
                                                                    $date_reformat = explode('-', $survey['Date']);
                                                                    $use_date = $date_reformat[1] . '-' . $date_reformat[2] . '-' . $date_reformat[0];
                                                                    ?>
                                        <a href="../participants/new_parent_mentor_survey.php?survey=<?php echo $survey['Parent_Mentor_Survey_ID']; ?>"  class="no_view" >Survey <?php echo $survey['Parent_Mentor_Survey_ID'] . ": " . $use_date; ?></a><br/>
                                                    <?php
                                                }
                                                ?>
                                    <br/>
                                    <!--Edit attendance by clicking the "Edit" button in the far right column -->
                                    <h5>Attendance</h5>
                                    <table class="inner_table" id="attendance_table" style="font-size:.9em;">
                                        <tr><th width="20%">Month</th><th width="20%">Year</th><th width="20%"># Days Attended</th><th width="20%"># Days Possible</th><th></th></tr>
                                                <?php
                                                date_default_timezone_set('America/Chicago');
                                                $month_array = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                                                $get_this_year_months = "SELECT * FROM PM_Possible_Attendance WHERE Year='" . date('Y') . "'";
                                                $this_year_months = mysqli_query($cnnLSNA, $get_this_year_months);
                                                while ($month_loop = mysqli_fetch_array($this_year_months)) {
                                                    ?><tr>
                                                <td><?php echo $month_array[$month_loop['Month'] - 1]; ?></td>
                                                <td><?php echo $month_loop['Year']; ?></td>
                                                <td><?php
                                    $get_attendance = "SELECT Num_Days_Attended FROM PM_Actual_Attendance WHERE Parent_Mentor_ID='" . $PM['Participant_ID'] . "' 
											AND Possible_Attendance_ID='" . $month_loop['PM_Possible_Attendance_ID'] . "'";
                                    $attendance = mysqli_query($cnnLSNA, $get_attendance);
                                    $att = mysqli_fetch_row($attendance);
                                    ?><span class="display_attendance"><?php echo $att[0]; ?></span>
                                                    <input type="text" id="attended_days_<?php echo $month_loop['PM_Possible_Attendance_ID']; ?>" class="edit_attendance" style="width:30px;" value="<?php echo $att[0]; ?>"></td>
                                                <td><?php echo $month_loop['Max_Days_Possible']; ?></td>
                                                <td>
                                                       <input type="button" value="Edit"  class="no_view" onclick="$('.edit_attendance').toggle();
                                                                                                                        $('.display_attendance').toggle();">
                                                    <input type="button" value="Save" class="edit_attendance" onclick="
                                                                                                                        $.post(
                                                                                                                                '../ajax/save_pm_attendance.php',
                                                                                                                                {
                                                                                                                                    pm_id: '<?php echo $PM['Participant_ID'] ?>',
                                                                                                                                    days: document.getElementById('attended_days_<?php echo $month_loop['PM_Possible_Attendance_ID']; ?>').value,
                                                                                                                                    possible_id: <?php echo $month_loop['PM_Possible_Attendance_ID']; ?>
                                                                                                                                },
                                                                                                                        function(response) {
                                                                                                                            window.location = 'program_profile.php';
                                                                                                                        }
                                                                                                                        )">
                                                </td>
                                            </tr><?php
                }
                ?>
                                    </table>
                                    <br/>
                                </div>
                                <br/>
                    <?php
                }
                ?>
                        </div>
                        <br/>
                <?php
            }
            include "../include/dbconnclose.php";
            ?>
                </td>
            </tr>		
        </table>		
    <?php
}
/* for the parent mentor workshop program: */ else if ($_COOKIE['program'] == 53) {
    ?>
        <h3>Program Profile: Parent Mentor Friday Workshops</h3><hr/><br/>
        <div style="text-align:center;"><a class="helptext" href="javascript:;" onclick="
                    $.post(
                            '../ajax/set_program_id.php',
                            {
                                id: '19'
                            },
                    function(response) {
                        //alert(response);
                        if (response != '1') {
                            document.getElementById('show_error').innerHTML = response;
                        }
                        window.location = 'program_profile.php';
                    }
                    )" style="font-size:.9em;">View the main Parent Mentor Program Profile</a></div><br/>
        <table class="profile_table">
            <tr>
                <td width="50%"><!--Basic program info-->
                    <table class="inner_table" style="border:2px solid #696969;">
                        <tr>
                            <td width="30%"><strong>Name:</strong></td>
                            <td><span class="displayed_info"><?php echo $program->program_name; ?></span>
                                <input style="width:100%;" type="text" value="<?php echo $program->program_name; ?>" id="edit_name" class="show_edit_space">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Issue Area:</strong></td>
                            <td><span class="displayed_info"><?php
                                    $find_org = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links)
                                    ON Categories.Category_ID=Category_Subcategory_Links.Category_ID
                                    WHERE Subcategory_ID='" . $program->program_id . "'";
                                    // echo $find_org;
                                    include "../include/dbconnopen.php";
                                    $org = mysqli_query($cnnLSNA, $find_org);
                                    while ($partner = mysqli_fetch_array($org)) {
                                        echo $partner['Category_Name'] . "<br>";
                                    }
                                    include "../include/dbconnclose.php";
                                    ?></span>
                                <select id="edit_type" class="show_edit_space">
                                    <option value="">-----</option>
    <?php
    $program_query = "SELECT * FROM Categories";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnLSNA, $program_query);
    while ($prog = mysqli_fetch_array($programs)) {
        ?>
                                        <option value="<?php echo $prog['Category_ID']; ?>" <?php echo ($partner['Category_ID'] == $prog['Category_ID'] ? 'selected="selected"' : null); ?>><?php echo $prog['Category_Name']; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><strong>Program or Campaign:</strong></td>
                            <td><span class="displayed_info"><?php echo $program->issue_type; ?></span>
                                <select id="issue_type" class="show_edit_space">
                                    <option value="">-----</option>
                                    <option value="program" <?php echo ($program->issue_type == 'Program' ? 'selected="selected"' : null); ?>>Program</option>
                                    <option value="campaign" <?php echo ($program->issue_type == 'Campaign' ? 'selected="selected"' : null); ?>>Campaign</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Number of Total Participants:</strong></td>
                            <td><?php
                                $get_participant_num = "SELECT * FROM Participants LEFT JOIN (Participants_Subcategories)
                                ON (Participants.Participant_ID=Participants_Subcategories.Participant_ID)
                                WHERE Participants_Subcategories.Subcategory_ID='" . $program->program_id . "'";
                                include "../include/dbconnopen.php";
                                $get_num = mysqli_query($cnnLSNA, $get_participant_num);
                                $num = mysqli_num_rows($get_num);
                                echo $num;
                                include "../include/dbconnclose.php";
                                ?></td>
                        </tr>
                        <tr>
                            <td><strong>Notes:</strong></td>
                            <td><textarea id="program_notes"  class="no_view" onchange="
                                    $.post(
                                            '../ajax/save_notes.php',
                                            {
                                                type: 'program',
                                                id: '<?php echo $program->program_id; ?>',
                                                note: this.value
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = 'program_profile.php';
                                    }
                                    )"><?php echo $program->notes; ?></textarea><p class="helptext no_view">(only 400 characters will be saved in the database)</p></td>
                        </tr>
                        <tr>
                            <td><input type="button" class="no_view"  value="Edit Program Information" onclick="
                                    $('.displayed_info').toggle();
                                    $('.show_edit_space').toggle();
                                       "></td>
                            <td><input type="button" value="Save Changes" class="show_edit_space" onclick="
                                    $.post(
                                            '../ajax/edit_program.php',
                                            {
                                                name: document.getElementById('edit_name').value,
                                                issue_type: document.getElementById('issue_type').value,
                                                type: document.getElementById('edit_type').options[document.getElementById('edit_type').selectedIndex].value,
                                                id: '<?php echo $program->program_id; ?>'
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = 'program_profile.php';
                                    }
                                    )"></td>
                        </tr>
                    </table><br/><br/>
                    <br/>
                    <!--Add participant.  First search for the person.-->
                    <a class="search_toggle no_view" onclick="
                            $('#user_search').toggle();
                       "><em>Add Participant: Search</em></a>

                    <div id="user_search" style="font-size:.8em;">
                        <table class="inner_table">
                            <tr>
                                <td><strong>First Name: </strong></td>
                                <td><input type="text" id="first_name" style="width:100px;" /></td>
                                <td><strong>Role: </strong></td>
                                <td><select id="role">
                                        <option value="">--------</option>
    <?php
    $get_roles = "SELECT * FROM Roles";
    include "../include/dbconnopen.php";
    $roles = mysqli_query($cnnLSNA, $get_roles);
    while ($role = mysqli_fetch_array($roles)) {
        ?>
                                            <option value="<?php echo $role['Role_ID']; ?>"><?php echo $role['Role_Title']; ?></option>
    <?php
    }
    include "../include/dbconnclose.php";
    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Last Name: </strong></td>
                                <td><input type="text" id="last_name" style="width:100px;" /></td>
                                <td><strong>Gender: </strong></td>
                                <td><select id="gender">
                                        <option value="">--------</option>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Date of Birth: </strong></td>
                                <td><input type="text" id="dob" class="hasDatepicker" style="width:100px;" /></td>
                                <td><strong>Grade Level: </strong></td>
                                <td><select id="grade">
                                        <option value="">--------</option>
                                        <option value="k">Kindergarten</option>
                                        <option value="1">1st Grade</option>
                                        <option value="2">2nd Grade</option>
                                        <option value="3">3rd Grade</option>
                                        <option value="4">4th Grade</option>
                                        <option value="5">5th Grade</option>
                                        <option value="6">6th Grade</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <input type="button" value="Search" onclick="
                                    $.post(
                                            '../ajax/search_participants.php',
                                            {
                                                result: 'dropdown',
                                                first: document.getElementById('first_name').value,
                                                last: document.getElementById('last_name').value,
                                                dob: document.getElementById('dob').value,
                                                grade: document.getElementById('grade').value,
                                                gender: document.getElementById('gender').options[document.getElementById('gender').selectedIndex].value,
                                                role: document.getElementById('role').options[document.getElementById('role').selectedIndex].value
                                            },
                                    function(response) {
                                        document.getElementById('show_results').innerHTML = response;
                                        $('#add_participant').show();
                                    }
                                    );
                                           "/>
                                </td>
                            </tr>
                        </table>
                        <!--Then add the school that s/he is going to workshops in: -->

                        <div id="show_results"></div><span id="add_participant">
                            <span class="helptext">Select the school this parent is associated with: </span>
                            <select id="pm_school">
                                <option value="">---------</option>
                            <?php
                            $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1' ORDER BY Institution_Name";
                            include "../include/dbconnopen.php";
                            $schools = mysqli_query($cnnLSNA, $get_schools);
                            while ($school = mysqli_fetch_array($schools)) {
                                ?>
                                    <option value="<?php echo $school['Institution_ID']; ?>"><?php echo $school['Institution_Name']; ?></option>
        <?php
    }
    include "../dbconnclose.php";
    ?>
                            </select><br/>

                            <span class="helptext">(You must select both a person and a school for this information to save correctly.)</span>
                            <input type="button" value="Add Participant" id="add_button" onclick="
                            $.post(
                                    '../ajax/add_participant_to_program.php',
                                    {
                                        participant: document.getElementById('relative_search').options[document.getElementById('relative_search').selectedIndex].value,
                                        subcategory: '<?php echo $program->program_id; ?>',
                                        school: document.getElementById('pm_school').options[document.getElementById('pm_school').selectedIndex].value

                                    },
                            function(response) {
                                //document.write(response);
                                window.location = 'program_profile.php';
                            }
                            )"></span>
                    </div>
                    <br/><br/>&nbsp<p>

                        <!--Create list of schools at top right: -->
                        <?php //echo $program->program_id;
                        if ($program->program_id == 19 || $program->program_id == 53) {
                            ?>   <a href="/lsna/programs/new_satisfaction_survey.php" class="no_view">Add Satisfaction Survey</a></p><?php } ?>
                </td>
                <td>
                        <?php
                        $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1' ORDER BY Institution_Name";
                        include "../include/dbconnopen.php";
                        $schools = mysqli_query($cnnLSNA, $get_schools);
                        while ($school = mysqli_fetch_array($schools)) {
                            ?>
                        <a href="javascript:;" style="text-decoration:none;" onclick="
                                                        $('#school_<?php echo $school['Institution_ID']; ?>_details').slideToggle();
                           "><h4 style="text-align:left;margin-left:20px;background-color:#f2f2f2;padding:2px 5px;border:1px solid #696969;"><?php echo $school['Institution_Name']; ?></h4></a>
                        <div id="school_<?php echo $school['Institution_ID']; ?>_details" class="detail_expand" style="margin-left:25px;">
                            <?php
                            $get_PMs = "SELECT * FROM Participants INNER JOIN Institutions_Participants ON Institutions_Participants.Participant_ID=Participants.Participant_ID WHERE Institutions_Participants.Institution_ID='" . $school['Institution_ID'] . "' AND Institutions_Participants.Is_PM='1'";
                            include "../include/dbconnopen.php";
                            $PMs = mysqli_query($cnnLSNA, $get_PMs);
                            while ($PM = mysqli_fetch_array($PMs)) {
                                ?>
                                <!--List of people going to PM workshops (not necessarily all PMs)-->
                                <a href="javascript:;" onclick="
                                                                            $.post(
                                                                                    '../ajax/set_participant_id.php',
                                                                                    {
                                                                                        page: 'profile',
                                                                                        participant_id: '<?php echo $PM['Participant_ID']; ?>'
                                                                                    },
                                                                            function(response) {
                                                                                if (response != '1') {
                                                                                    document.getElementById('show_error').innerHTML = response;
                                                                                }
                                                                                window.location = '../participants/participant_profile.php';
                                                                            }
                                                                            );
                                   " style="font-size:1.1em;padding-left:30px;" ><strong><?php echo $PM['Name_First'] . " " . $PM['Name_Last']; ?></strong></a> 
                                <a href="javascript:;" onclick="
                                                                            $('#PM_<?php echo $PM['Participant_ID']; ?>_details').slideToggle();
                                   " class="helptext">show/hide details...</a>
                                <div class="detail_expand" id="PM_<?php echo $PM['Participant_ID']; ?>_details" style="padding-left:50px;">
                                    <h5>Surveys</h5>
                                    <!--Show any parent mentor surveys completed-->
                                    <?php
                                    $get_surveys = "SELECT * FROM Parent_Mentor_Survey WHERE Participant_ID='" . $PM['Participant_ID'] . "' ORDER BY Date";
                                    include "../include/dbconnopen.php";
                                    $surveys = mysqli_query($cnnLSNA, $get_surveys);
                                    while ($survey = mysqli_fetch_array($surveys)) {
                                        $date_reformat = explode('-', $survey['Date']);
                                        $use_date = $date_reformat[1] . '-' . $date_reformat[2] . '-' . $date_reformat[0];
                                        ?>
                                        <a href="" class="no_view" >Survey <?php echo $survey['Parent_Mentor_Survey_ID'] . ": " . $use_date; ?></a><br/>
                                            <?php
                                        }
                                        ?>
                                    <br/>
                                    <h5>Attendance</h5>
                                    <!--Count number of days attended and more detail onclick -->
                                    Number of days attended: <?php
                                        $times_attended = "SELECT * FROM Subcategory_Attendance INNER JOIN
                                                    Subcategory_Dates ON (Subcategory_Attendance.Subcategory_Date=Subcategory_Dates.Wright_College_Program_Date_ID)
                                                WHERE Subcategory_Dates.Subcategory_ID='" . $program->program_id . "'
                                                AND Subcategory_Attendance.Participant_ID='" . $user['Participant_ID'] . "'";
                                        //echo $times_attended;
                                        include "../include/dbconnopen.php";
                                        $num = mysqli_query($cnnLSNA, $times_attended);
                                        echo mysqli_num_rows($num);
                                        include "../include/dbconnclose.php";
                                        ?>&nbsp;&nbsp;
                                    <!--Show dates when this person attended a workshop:-->
                                    <a class="helptext" onclick="
                                                                                    $('.dates_<?php echo $user['Participant_ID']; ?>').slideToggle();
                                       ">Show/hide dates attended</a>
                                    <div style="padding-left:30px" class="dates_<?php echo $user['Participant_ID']; ?> user_dates">
            <?php
            date_default_timezone_set('America/Chicago');
            while ($date = mysqli_fetch_array($num)) {
                $datetime = new DateTime($date['Date']);
                //echo $date . "<br>";
                echo date_format($datetime, 'M d, Y') . "<br>";
                //echo $date['Program_Date'] 
            }
            ?>
                                    </div>
                                    <br/>
                                </div>
                                <br/>
                                        <?php
                                    }
                                    ?>
                        </div>
                        <br/>
                                    <?php
                                }
                                //include "../include/dbconnclose.php";
                                ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <!--This is the schedule for the parent mentor workshops.
                    Show schedule like any other program: -->
                    <h4 id="schedule">Schedule: </h4>
                    <table class="profile_table" id="program_schedule_table">
                        <tr class="no_view" >
                            <td colspan="4"><strong>Add Date: </strong><input type="text" id="new_date"  class="hadDatepicker">
                            &nbsp;&nbsp;<!--<span class="helptext">Dates must be entered in the format YYYY-MM-DD (or use the pop-up calendar).</span>-->
                                <input type="button" value="Save" onclick="
                        $.post(
                                '../ajax/add_new_program_date.php',
                                {
                                    program_id: '<?php echo $program->program_id ?>',
                                    date: document.getElementById('new_date').value
                                },
                        function(response) {
                            //document.write(response);
                            window.location = 'program_profile.php?schedule=1';
                        }
                        )
                                       ">
                            </td>
                        </tr>
                        <tr>
                            <th>Delete Activity</th><th>Date</th><th width="25%">Participants</th><th>No. of Participants</th><th>Add/Remove Participants</th>
                        </tr>
                                <?php
                                date_default_timezone_set('America/Chicago');
                                $dates = $program->get_dates();
                                $attendance_num_array = array();
                                $array_of_dates = array();
                                $program_length = 0;
                                while ($date = mysqli_fetch_array($dates)) {
                                    $program_length = $program_length + 1;
                                    ?>
                            <tr><td style="padding-bottom:0;"><input type="button"  class="no_view hide_on_view" value="Delete Session" onclick="
                                        var double_check = confirm('Are you sure you want to delete this session from the database?  This action cannot be undone.');
                                        if (double_check) {
                                            $.post(
                                                    '../ajax/delete_elements.php',
                                                    {
                                                        action: 'event',
                                                        id: '<?php echo $date['Wright_College_Program_Date_ID']; ?>'
                                                    },
                                            function(response) {
                                               //document.write(response);
                                                alert('This session has been successfully deleted.  Refresh page to remove from screen.');
                                            }
                                            );
                                        }"></td>
                                <td><?php
                                    $array_of_dates[] = $date['Date'];
                                    $datetime = new DateTime($date['Date']);
                                    //echo $date . "<br>";
                                    echo date_format($datetime, 'M d, Y');
                                    //echo $date['Program_Date'];
                                    ?></td>
                                <td>
                                    <?php
                                    $find_attendance_by_date = "SELECT * FROM Participants LEFT JOIN (Subcategory_Attendance)
                                ON (Participants.Participant_ID=Subcategory_Attendance.Participant_ID)
                                WHERE Subcategory_Attendance.Subcategory_Date='" . $date['Wright_College_Program_Date_ID'] . "' ORDER BY Participants.Name_Last";
                                    include "../include/dbconnopen.php";
                                    $attendees = mysqli_query($cnnLSNA, $find_attendance_by_date);
                                    $count = 0;

                                    while ($attendee = mysqli_fetch_array($attendees)) {
                                        $count = $count + 1;
                                        ?>
                                        <a href="javascript:;" onclick="
                                            $.post(
                                                    '../ajax/set_participant_id.php',
                                                    {
                                                        page: 'profile',
                                                        participant_id: '<?php echo $attendee['Participant_ID']; ?>'
                                                    },
                                            function(response) {
                                                if (response != '1') {
                                                    document.getElementById('show_error').innerHTML = response;
                                                }
                                                window.location = '../participants/participant_profile.php';
                                            }
                                            );
                                           "><?php echo $attendee['Name_First'] . " " . $attendee['Name_Last'] ?></a>&nbsp;
                                        <br>
                                            <?php
                                        }
                                        include "../include/dbconnclose.php";
                                        ?>
                                </td>
                                <td>

                                    <?php
                                    $attendance_num_array[] = $count;
                                    echo $count;
                                    ?>
                                </td>
                                <td  class="no_view" >
                                    <select id="choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>">
                                        <option value="">-----</option>
                                    <?php
                                    $get_current_participants = "SELECT * FROM Participants_Subcategories
                            INNER JOIN Participants ON Participants.Participant_ID=Participants_Subcategories.Participant_ID
                            WHERE Subcategory_ID='" . $program->program_id . "' ORDER BY Participants.Name_Last";
                                    include "../include/dbconnopen.php";
                                    $participants = mysqli_query($cnnLSNA, $get_current_participants);
                                    while ($part = mysqli_fetch_array($participants)) {
                                        ?>
                                            <option value="<?php echo $part['Participant_ID'] ?>"><?php echo $part['Name_First'] . " " . $part['Name_Last']; ?></option>
                                               <?php
                                           }
                                           include "../include/dbconnclose.php";
                                           ?>
                                    </select>&nbsp;&nbsp;

                                    <input type="button" value="Add" onclick="
                                    //alert(document.getElementById('choose_from_current_participants').options[document.getElementById('choose_from_current_participants').selectedIndex].value);
                                    $.post(
                                            '../ajax/add_attendee.php',
                                            {
                                                program_date_id: '<?php echo $date['Wright_College_Program_Date_ID'] ?>',
                                                user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').selectedIndex].value
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = 'program_profile.php?schedule=1';
                                    }
                                    )">     <input type="button" value="Remove" onclick="
                                            //alert(document.getElementById('choose_from_current_participants').options[document.getElementById('choose_from_current_participants').selectedIndex].value);
                                            $.post(
                                                    '../ajax/remove_attendee.php',
                                                    {
                                                        program_date_id: '<?php echo $date['Wright_College_Program_Date_ID'] ?>',
                                                        user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Wright_College_Program_Date_ID'] ?>').selectedIndex].value
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'program_profile.php?schedule=1';
                                            }
                                            )">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="padding:0;"><hr style="color:#696969; border-style:inset; margin:0;" /></td>
                            </tr>

    <?php }
    ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>


                </td>
            </tr>
        </table>	

                    <?php
                }
                /* ends the parent mentor workshops case.  */
                ?>
    <br/><br/>
    <!--Late addition to all programs and campaigns.  This is meant to allow them to track
    participation in programs over time: -->

    <h5>Keep track of participant and attendance over time</h5>
    <table class="all_projects">
        <caption>Participant over years</caption>
        <tr><th>Year</th><th>Number of Participants</th></tr>
<?php
//cycle through years for which this program has participants:
$years_query = "SELECT DISTINCT YEAR(Date_Linked) FROM Participants_Subcategories WHERE Subcategory_ID='" . $program->program_id . "'";
//echo $years_query;
include "../include/dbconnopen.php";
$these_years = mysqli_query($cnnLSNA, $years_query);
while ($year = mysqli_fetch_row($these_years)) {
    ?>
            <tr>
                <td class="all_projects"><?php echo $year[0]; ?></td>
                <td class="all_projects"> 
                    <?php
                    //get the number of participants for this year
                    $num_people_query = "SELECT COUNT(*) FROM Participants_Subcategories WHERE Subcategory_ID='" . $program->program_id . "'
                                        AND YEAR(Date_Linked)='$year[0]';";
                    $num_people = mysqli_query($cnnLSNA, $num_people_query);
                    $num_persons = mysqli_fetch_row($num_people);
                    echo $num_persons[0];
                    ?>
                </td>
            </tr>
                    <?php
                }
                ?>
    </table>     
    <p></p>
    <table class="all_projects">
        <caption>Attendance over quarters of <?php
                //the current year:
                date_default_timezone_set('America/Chicago');
                echo date('Y');
                ?></caption>
        <tr><th>Quarter</th><th>Number of Attendees</th></tr>
        <tr><td class="all_projects">1</td><td class="all_projects"><?php
                //get number of attendees in that quarter
                $attendee_num_query = "SELECT COUNT(*) FROM Subcategory_Dates INNER JOIN Subcategory_Attendance ON Subcategory_Attendance.Subcategory_Date=
                    Subcategory_Dates.Wright_College_Program_Date_ID WHERE Subcategory_Dates.Subcategory_ID='" . $program->program_id . "' 
                    AND MONTH(Date)>=1 AND MONTH(Date)<4;";
                $num_people = mysqli_query($cnnLSNA, $attendee_num_query);
                $num_persons = mysqli_fetch_row($num_people);
                echo $num_persons[0];
                ?></td></tr>
        <tr><td class="all_projects">2</td><td class="all_projects"><?php
//get number of attendees in that quarter
$attendee_num_query = "SELECT COUNT(*) FROM Subcategory_Dates INNER JOIN Subcategory_Attendance ON Subcategory_Attendance.Subcategory_Date=
                    Subcategory_Dates.Wright_College_Program_Date_ID WHERE Subcategory_Dates.Subcategory_ID='" . $program->program_id . "' 
                    AND MONTH(Date)>3 AND MONTH(Date)<7;";
$num_people = mysqli_query($cnnLSNA, $attendee_num_query);
$num_persons = mysqli_fetch_row($num_people);
echo $num_persons[0];
                ?></td></tr>
        <tr><td class="all_projects">3</td><td class="all_projects"><?php
//get number of attendees in that quarter
$attendee_num_query = "SELECT COUNT(*) FROM Subcategory_Dates INNER JOIN Subcategory_Attendance ON Subcategory_Attendance.Subcategory_Date=
                    Subcategory_Dates.Wright_College_Program_Date_ID WHERE Subcategory_Dates.Subcategory_ID='" . $program->program_id . "' 
                    AND MONTH(Date)>7 AND MONTH(Date)<10;";
$num_people = mysqli_query($cnnLSNA, $attendee_num_query);
$num_persons = mysqli_fetch_row($num_people);
echo $num_persons[0];
                ?></td></tr>
        <tr><td class="all_projects">4</td><td class="all_projects"><?php
//get number of attendees in that quarter
$attendee_num_query = "SELECT COUNT(*) FROM Subcategory_Dates INNER JOIN Subcategory_Attendance ON Subcategory_Attendance.Subcategory_Date=
                    Subcategory_Dates.Wright_College_Program_Date_ID WHERE Subcategory_Dates.Subcategory_ID='" . $program->program_id . "' 
                    AND MONTH(Date)>10";
$num_people = mysqli_query($cnnLSNA, $attendee_num_query);
$num_persons = mysqli_fetch_row($num_people);
echo $num_persons[0];
                ?>
            </td>
        </tr>
    </table>
</div>
<?php include "../../footer.php"; ?>
