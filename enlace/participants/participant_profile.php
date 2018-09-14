<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id);

include "../../header.php";
include "../header.php";

//make sure the user has access to the participant
include "../include/dbconnopen.php";
$id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_GET['id']);
$participant_program_list = "SELECT Session_Names.*, Name FROM Session_Names INNER JOIN Participants_Programs ON Session_Names.Session_ID = Participants_Programs.Program_ID INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID WHERE Participant_Id = " . $id_sqlsafe . " ORDER BY Name;";
$access_to_participant = mysqli_query($cnnEnlace, $participant_program_list);
$program_array = array();
while ($program = mysqli_fetch_array($access_to_participant)){
    $program_array[] = $program['Program_ID'];
}    
$USER->enforce_access_program_array($Enlace_id, $program_array);

/* This page shows all the information about a person in one place.
 * The participant id comes in through a Get.
 */
include "../include/datepicker_wtw.php";

//get participant info
include "../classes/participant.php";
$person = new Participant();
$person->load_with_participant_id($_GET['id']);

/* Get role here.  The role determines what elements show on the page.s */
$get_role = "SELECT Role FROM Roles WHERE Role_ID = $person->role";
include "../include/dbconnopen.php";
if ($this_role = mysqli_query($cnnEnlace, $get_role)) {
    $role = mysqli_fetch_array($this_role);
}
include "../include/dbconnclose.php";
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#participants_selector').addClass('selected');
        $('#add_date').hide();
        $('#add_referral').hide();
        $('#find_relative').hide();
        $('.basic_info_edit').hide();
        $('#search_parti_table').hide();
        $('#first_program_date').hide();
        $('.youth_info').hide();
        $('.mentorship_edit').hide();
        $('#ajax_loader').hide();
        $('.error').hide();
    });

function checkDOB(dob) {
    if (dob != '') {
        var split_dob = dob.split('-');
        if (split_dob[2]) {
            if ( split_dob[0].length < 2 ) {
                split_dob[0] = 0 + split_dob[0];
            }
            if (split_dob[1].length < 2 ) {
                split_dob[1] = 0 + split_dob[1];
            }
            var reformatted_date = split_dob[2] + '-' +  split_dob[0] + '-' + split_dob[1];
            // This checks the date for validity, including edge cases
            // (like Feb 30), but requires double-digit days and months
            var date = new Date(reformatted_date);
            }
        else {
            return false;
        }
        if (date == 'Invalid Date') {
            return false;
        }
    }
    else {
        return "";
    }
    return reformatted_date;
}
function saveBasicInfo() {
    var valid_dob = checkDOB(document.getElementById('dob_edit').value);
    if (valid_dob === false) {
        $('#dob_warning').show();
        $('#basic_info_warning').show();
        return false;
    }
    if (document.getElementById('absences').checked == true) {
        var absences = 1;
    } else {
        var absences = 0;
    }
    if (document.getElementById('failed').checked == true) {
        var failed = 1;
    } else {
        var failed = 0;
    }
    if (document.getElementById('disciplinary').checked == true) {
        var discipline = 1;
    } else {
        var discipline = 0;
    }
    $.post(
        '../ajax/edit_participant.php',
        {
          id: '<?php echo $person->participant_id; ?>',
                name: document.getElementById('first_name_edit').value,
                surname: document.getElementById('last_name_edit').value,
                address_num: document.getElementById('st_num_edit').value,
                address_dir: document.getElementById('st_dir_edit').value,
                address_name: document.getElementById('st_name_edit').value,
                address_type: document.getElementById('st_type_edit').value,
                city: document.getElementById('city_edit').value,
                state: document.getElementById('state_edit').value,
                zip: document.getElementById('zip_edit').value,
                day_phone: document.getElementById('day_phone_edit').value,
                eve_phone: document.getElementById('eve_phone_edit').value,
                email: document.getElementById('email_edit').value,
                dob: valid_dob,
                age: document.getElementById('age_edit').value,
                gender: document.getElementById('gender_edit').value,
                role: document.getElementById('role_edit').value,
                grade: document.getElementById('grade_edit').value,
                grade_entered: document.getElementById('enter_grade_year').value,
                school: document.getElementById('school_edit').value,
                teacher: document.getElementById('referring_teacher').value,
                warning_absent: absences,
                warning_failed: failed,
                warning_discipline: discipline
                },
        function(response) {
            window.location = 'participant_profile.php?id=<?php echo $person->participant_id; ?>';
        }
    ).fail(function() { alert('You do not have permission to perform this action.');});
};

</script>

<div class="content_block">
    <h3>Participant Profile - <?php echo $person->first_name . " " . $person->last_name; ?></h3><hr/><br/>

    <table class="profile_table">
        <tr>
            <td width="45%"> <!--Basic Info-->
                <table class="inner_table" style="border: 2px solid #696969;">
                    <tr>
                        <td><strong>Name: </strong></td>
                        <td>
                            <span class="basic_info_show"><?php echo $person->first_name . " " . $person->last_name; ?></span>
                            <input class="basic_info_edit" id="first_name_edit" value="<?php echo $person->first_name; ?>" style="width:100px;"/>&nbsp;
                            <input class="basic_info_edit" id="last_name_edit" value="<?php echo $person->last_name; ?>" style="width:100px;"/>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Database ID: </strong></td>
                        <td><?php echo $person->participant_id; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Role: </strong></td>
                        <td>
                            <span class="basic_info_show"><?php echo $role['Role']; ?></span>
                            <select id="role_edit" class="basic_info_edit">
                                <option value="">--------</option>
                                <?php
                                $get_roles = "SELECT * FROM Roles";
                                include "../include/dbconnopen.php";
                                $roles = mysqli_query($cnnEnlace, $get_roles);
                                while ($edit_role = mysqli_fetch_array($roles)) {
                                    ?>
                                    <option value="<?php echo $edit_role['Role_ID']; ?>" <?php echo($person->role == $edit_role['Role_ID'] ? "selected='selected'" : null); ?>><?php echo $edit_role['Role']; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <!--Changing the address means the block group will be recalculated in the /ajax/ file.-->
                        <td><strong>Address: </strong></td>
                        <td>
                            <span class="basic_info_show"><?php echo $person->full_address; ?></span>
                            <div class="basic_info_edit">
                                <input id="st_num_edit" value="<?php echo $person->streetnum; ?>" style="width:40px;"/> 
                                <input id="st_dir_edit" value="<?php echo $person->streetdir; ?>" style="width:20px;"/> 
                                <input id="st_name_edit" value="<?php echo $person->street; ?>" style="width:100px;"/> 
                                <input id="st_type_edit" value="<?php echo $person->streettype; ?>" style="width:35px;"/> <br/>
                                <input id="city_edit" value="<?php echo $person->city; ?>" style="width:100px;"/> 
                                <input id="state_edit" value="<?php echo $person->state; ?>" style="width:20px;"/>
                                <input id="zip_edit" value="<?php echo $person->zip; ?>" style="width:40px;"/> <br/>
                                <span class="helptext">e.g. 2756 S Harding Ave<br/>Chicago, IL 60623</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Day Phone: </strong></td>
                        <td>
                            <span class="basic_info_show"><?php echo $person->day_phone; ?></span>
                            <input class="basic_info_edit" id="day_phone_edit" value="<?php echo $person->day_phone; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Evening Phone: </strong></td>
                        <td>
                            <span class="basic_info_show"><?php echo $person->evening_phone; ?></span>
                            <input class="basic_info_edit" id="eve_phone_edit" value="<?php echo $person->evening_phone; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>E-mail Address: </strong></td>
                        <td>
                            <span class="basic_info_show"><?php echo $person->email; ?></span>
                            <input class="basic_info_edit" id="email_edit" value="<?php echo $person->email; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Date of Birth: </strong><br>
                                    <span class="helptext">Dates must be entered<br> in MM-DD-YYYY format, like 05-01-2015 for May 1st.</span></td>
                        <td>
                        <span class="error" id="dob_warning">This date looks like it has a problem.  Check to be sure you used MM-DD-YYYY format.</span><br/>
                            <span class="basic_info_show"><?php
                                if ($person->dob != '' && $person->dob != 0) {
                                    try {
                                        $entrydate = new DateTime($person->dob);
                                        echo $entrydate->format('n/j/Y');
                                    }
                                    catch (Exception $invalidDate) {
                                        // show error
                                        echo $person->dob;
                                    }
                                }
                                ?></span>
                        <span class="basic_info_edit">
                                    
                        <?php
                                try {
                                    $entrydate = new DateTime($person->dob);
                                    echo '<input class="basic_info_edit birthdate" id="dob_edit" value="' . $entrydate->format('m-d-Y') . '" />';
                                }
                                catch (Exception $invalidDate) {
                                    // show error
                                    echo '<input class="basic_info_edit birthdate" id="dob_edit" value="' . $person->dob . '" />';
                                }
                        ?>
                        </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Age: </strong></td>
                        <td>
                            <span class="basic_info_show"><?php echo $person->age; ?></span>
                            <input class="basic_info_edit" id="age_edit" value="<?php echo $person->age; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Gender: </strong></td>
                        <td>
                            <span class="basic_info_show"><?php
                                if ($person->gender == 'm') {
                                    echo "Male";
                                } else if ($person->gender == 'f') {
                                    echo "Female";
                                };
                                ?></span>
                            <select class="basic_info_edit" id="gender_edit"/>
                    <option value="">-------</option>
                    <option value="m" <?php echo($person->gender == 'm' ? 'selected="selected"' : null); ?>>Male</option>
                    <option value="f" <?php echo($person->gender == 'f' ? 'selected="selected"' : null); ?>>Female</option>
                    </select>
            </td>
        </tr>
        <tr <?php
        if ($person->role != 1) {
            echo "class='youth_info'";
        }
        ?>>
            <td><strong>Grade: </strong></td>
            <td>
                <span class="basic_info_show"><?php echo $person->grade; ?> &nbsp (as of &nbsp <?php echo $person->grade_entered; ?>)</span>
                <select class="basic_info_edit" id="grade_edit">
                    <option value="" <?php echo($person->grade == 0 ? "selected=='selected'" : null); ?>>-----</option>
                    <option value="5" <?php echo($person->grade == 5 ? "selected=='selected'" : null); ?>>5</option>
                    <option value="6" <?php echo($person->grade == 6 ? "selected=='selected'" : null); ?>>6</option>
                    <option value="7" <?php echo($person->grade == 7 ? "selected=='selected'" : null); ?>>7</option>
                    <option value="8" <?php echo($person->grade == 8 ? "selected=='selected'" : null); ?>>8</option>
                    <option value="9" <?php echo($person->grade == 9 ? "selected=='selected'" : null); ?>>9</option>
                </select>

                <!--They asked for a field to show when the grade was last entered.  (obviously the grade will change from year to year)-->
                <span class="basic_info_edit">As of year: <input type="text" id="enter_grade_year" class="basic_info_edit" style="width:50px;"></span>
            </td>
        </tr>
        <tr>
            <td><strong>School:</strong></td>
            <td>
                <span class="basic_info_show"><?php echo $person->get_school(); ?></span>
                <select class="basic_info_edit" id="school_edit"/>
        <option value="0">-----</option>
        <?php
        $all_schools = "SELECT * FROM Institutions WHERE Institution_Type=1 ORDER BY Institution_Name";
        include "../include/dbconnopen.php";
        $program_info = mysqli_query($cnnEnlace, $all_schools);
        while ($temp_school = mysqli_fetch_array($program_info)) {
            ?><option value="<?php echo $temp_school['Inst_ID'] ?>" <?php echo($temp_school['Inst_ID'] == $person->schoolid ? "selected='selected'" : null); ?>>
                <?php echo $temp_school['Institution_Name']; ?>
            </option>
            <?php
        }
        include "../include/dbconnclose.php";
        ?>
        </select>
        </td>
        </tr>
        <tr <?php
        /* These only show up for youths.  People without roles won't see them either, so new participants must specifically be added as youths. */
        if ($person->role != 1) {
            echo "class='youth_info'";
        }
        ?>>
            <td><strong>Early Warning Indicator(s):</strong>
            </td>
            <td style="font-size:.9em;">
                <div class="basic_info_show">
                    <?php
                    if ($person->absences == 1) {
                        echo "Missed 20+ days of school<br/>";
                    }
                    if ($person->failed == 1) {
                        echo "Failed core course (reading or math)<br/>";
                    }
                    if ($person->discipline == 1) {
                        echo "Recorded disciplinary incident<br/>";
                    }
                    ?>
                </div>
                <div class="basic_info_edit"><input type="checkbox" id="absences" <?php echo($person->absences == 1 ? "checked" : null); ?>>Missed 20+ days of school<br>
                    <input type="checkbox" id="failed" <?php echo($person->failed == 1 ? "checked" : null); ?>>Failed core course (reading or math)<br>
                    <input type="checkbox" id="disciplinary" <?php echo($person->discipline == 1 ? "checked" : null); ?>>Recorded disciplinary incident<br></div>
            </td>
        </tr>
        <tr>
            <!--I don\'t know what this is!-->
            <td><strong>Name of referring teacher</strong></td>
            <td><span class="basic_info_show"><?php echo $person->teacher_reference; ?></span>
                <input type="text" class="basic_info_edit" value="<?php echo $person->teacher_reference; ?>" id="referring_teacher">
            </td> 
        </tr>
        <tr>
            <td><strong>Enrolled in a program?</strong></td>
            <td><span class="basic_info_show"><?php echo $person->is_enrolled();
                    ?></span></td>
        </tr>

        <tr><td><strong>Date Information Entered: </strong></td>
            <td><span class="basic_info_show"><?php
                    $entrydate = new DateTime($person->date_entered);
                    echo $entrydate->format('n/j/Y');
                    $followup = $entrydate->add(new DateInterval('P1M'));
                    ?></span></td>
        </tr>
        <!--This is meant to remind partners to enter intake information.  If the intake assessment
        is past due, an alert will show up on the homepage.-->
        <tr <?php if ($person->role!=1){echo "class='youth_info'";}?>>
            <td><strong>Follow-up Date:</strong></td>
            <td><span class="basic_info_show"><?php
                    echo "Intake Assessment Due: " . $followup->format('n/j/Y');
                    echo "<hr>Intake Assessment Completed: ";
                    $new_baseline_date = explode('-', $person->baseline_date);
                    $new_baseline_date_day = explode(' ', $new_baseline_date[2]);
                    $display_baseline_date = $new_baseline_date[1] . '/' . $new_baseline_date_day[0] . '/' . $new_baseline_date[0];
                    echo $display_baseline_date;
                    ?></span>
                <span class="basic_info_edit"></span>

            </td>
        </tr>
        <tr <?php
        if ($person->role != 1) {
            echo "class='youth_info'";
        }
        ?>>
            <td colspan="2">
                <!--Shows all entered surveys.  There should only be 2 per year or per program, not sure which.
                -->

                <table class="inner_table">
                    <tr><th>Date</th><th>Pre/Post</th><th>Program</th><th></th></tr>
                    <?php
                    //get assessments:
                    $query = "SELECT MONTH(Participants_Caring_Adults.Date_Logged), DAY(Participants_Caring_Adults.Date_Logged), YEAR(Participants_Caring_Adults.Date_Logged), 
                Assessments.Pre_Post, Programs.Name, Assessment_ID, Draft FROM Assessments
                LEFT JOIN Participants_Caring_Adults ON Caring_Id=Caring_Adults_ID
                LEFT JOIN Participants_Future_Expectations ON Future_Id=Future_Expectations_ID
                LEFT JOIN Participants_Interpersonal_Violence ON Violence_Id=Interpersonal_Violence_ID
                LEFT JOIN Session_Names ON Assessments.Session_ID=Session_Names.Session_ID
                LEFT JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID
                WHERE Assessments.Participant_ID=$person->participant_id";
                    //  echo $query;
                    include "../include/dbconnopen.php";
                    $result = mysqli_query($cnnEnlace, $query);
                    while ($row = mysqli_fetch_row($result)) {
                        if ($row[3] == 2) {
                            $page = 'all_impact';
                        } elseif ($row[3] == 1) {
                            $page = 'all_intake';
                        } else {
                            $page = 'error';
                        }
                        ?>
                        <tr <?php if($row[6] == '1') { ?>class="unmarked"<?php } ?>>
                            <td>
                                <a href="<?php echo $page; ?>.php?person=<?php echo $person->participant_id; ?>&assessment=<?php echo $row[5]; ?>">
                                    <?php
                                    echo $row[0] .'/'. $row[1] .'/'. $row[2];
                                    ?>
                                </a></td><td><?php
                                if ($row[3] == 2) {
                                    echo 'Impact';
                                } elseif ($row[3] == 1) {
                                    echo 'Intake';
                                }
                                if ($row[6] == 1) {
                                    echo ' (Draft)';
                                }
                                ?></td><td><?php echo $row[4]; ?></td>
                            <td>
                                <a href="javascript:;" onclick="
                                        var check = confirm('This action cannot be undone.  Are you sure you want to delete this survey?');
                                        if (check) {
                                            $.post(
                                                    '../ajax/delete_survey.php',
                                                    {
                                                        action: 'personal',
                                                        assessment: '<?php echo $row[5]; ?>'
                                                    },
                                            function(response) {
                                                // document.write(response);
                                                window.location = 'participant_profile.php?id=<?php echo $person->participant_id; ?>'
                                            }
                                            ).fail(function() {alert('You do not have permission to perform this action.');});
                                        }">Delete Survey</a>
                            </td></tr>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </table>
            </td>
        </tr>
        <tr <?php
        if ($person->role != 1) {
            echo "class='youth_info'";
        }
        ?>>
            <td colspan="2"><a href="all_intake.php?person=<?php echo $person->participant_id; ?>">Add New Intake Assessment</a><br>
                <a href="all_impact.php?person=<?php echo $person->participant_id; ?>">Add New Program Impact Survey</a></td>
        </tr>
        <tr>
            <td colspan="2">
                        <span class="error" id="basic_info_warning">Sorry, something went wrong.  Please see the error(s) above.</span><br/>
                        <a href="javascript:;" class="basic_info_show" onclick="
                    $('.basic_info_show').toggle();
                    $('.basic_info_edit').toggle();
                               " style="margin-left:55px;">Edit...</a>
                <a href="javascript:;" class="basic_info_edit" onclick="saveBasicInfo()" style="margin-left:55px;">Save!</a>

            </td>
        </tr>
    </table>
    <br/><br/>

    <!--Add parents or children of this participant. -->

    <h4>Parent-Child Connections</h4>
    <table class="inner_table">
        <tr style="font-size:.9em;"><th>Relation</th><th>Name</th></tr>
        <?php
        $get_parents = "SELECT * FROM Child_Parent INNER JOIN Participants ON Participant_ID=Parent_ID WHERE Child_ID=$person->participant_id";
        include "../include/dbconnopen.php";
        $parents = mysqli_query($cnnEnlace, $get_parents);
        while ($parent = mysqli_fetch_array($parents)) {
            ?>
            <tr><td>Parent</td>
                <td><a href="participant_profile.php?id=<?php echo $parent['Participant_ID'] ?>"><?php echo $parent['First_Name'] . " " . $parent['Last_Name']; ?></a></td></tr><?php
        }
        include "../include/dbconnclose.php";
        $get_children = "SELECT * FROM Child_Parent INNER JOIN Participants ON Participant_ID=Child_ID WHERE Parent_ID=$person->participant_id";
        include "../include/dbconnopen.php";
        $children = mysqli_query($cnnEnlace, $get_children);
        while ($child = mysqli_fetch_array($children)) {
            ?>
            <tr><td>Child</td>
                <td><a href="participant_profile.php?id=<?php echo $child['Participant_ID']; ?>"><?php echo $child['First_Name'] . " " . $child['Last_Name']; ?></a></td></tr><?php
        }
        ?>
<?php
                     if ($USER->has_site_access($Enlace_id, $DataEntryAccess)){
?>
        <tr><td colspan="2"><a class="search_toggle" onclick="
                $('#find_relative').toggle();
                                               "><em>Search to add a parent or child:</em></a></td></tr>
        <tr><td colspan="2"><table class="search_table" id="find_relative">
                    <tr>
                        <td class="all_projects"><strong>First Name: </strong></td>
                        <td class="all_projects"><input type="text" id="first_name_search" style="width:125px;"/></td>
                        <td class="all_projects"><strong>Last Name: </strong></td>
                        <td class="all_projects"><input type="text" id="last_name_search" style="width:125px;" /></td>
                    </tr>
                    <tr>
                        <td class="all_projects"><strong>Role: </strong></td>
                        <td class="all_projects"><select id="role_search">
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
                        <td class="all_projects"><strong>Gender: </strong></td>
                        <td class="all_projects"><select id="gender_search">
                                <option value="">--------</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="all_projects"><strong>Date of Birth: </strong></td>
                        <td class="all_projects"><input type="text" id="dob_search" class="addDP" /></td>
                        <td class="all_projects"><strong>Grade Level: </strong></td>
                        <td class="all_projects"><select id="grade_search">
                                <option value="">--------</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td class="all_projects"><strong>Program Enrolled In:</strong></td><td class="all_projects"><select id="program_search">
                                <option value="0">-----</option>
                                <?php
                                $get_all_programs = "SELECT Program_ID, Name FROM Programs ORDER BY Name";
                                include "../include/dbconnopen.php";
                                $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
                                while ($program = mysqli_fetch_row($all_programs)) {
                                    ?>
                                    <option value="<?php echo $program[0]; ?>"><?php echo $program[1]; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select></td>
                        <td class="all_projects"></td>
                        <td class="all_projects">
                        </td>
                    </tr>
                    <!--Search for the family member here.-->
                    <tr>
                        <td class="all_projects" colspan="4" style="text-align:center;">
                            <input type="button" value="Search" onclick="
                                    $.post(
                                            '/enlace/ajax/search_participants.php',
                                            {
                                                first: document.getElementById('first_name_search').value,
                                                last: document.getElementById('last_name_search').value,
                                                dob: document.getElementById('dob_search').value,
                                                grade: document.getElementById('grade_search').value,
                                                gender: document.getElementById('gender_search').options[document.getElementById('gender_search').selectedIndex].value,
                                                role: document.getElementById('role_search').options[document.getElementById('role_search').selectedIndex].value,
                                                program: document.getElementById('program_search').value,
                                                result: 'dropdown'
                                            },
                                    function(response) {
                                        document.getElementById('show_results_family').innerHTML = response;
                                        $('#add_buttons').show();
                                    }).fail(function() {alert('You do not have permission to perform this action.');});"/>
                        </td>
                    </tr>

                    <tr><td colspan="4"><div id="show_results_family"></div></td></tr>

                    <!--Use these buttons to add connection IF the desired person shows up in the search results.-->
                    <tr><td colspan="4" id="add_buttons"><input type="button" value="Add As Child" onclick="
                            $.post(
                                    '../ajax/add_relative.php',
                                    {
                                        parent: '<?php echo $person->participant_id ?>',
                                        child: document.getElementById('relative_search').options[document.getElementById('relative_search').selectedIndex].value
                                    },
                            function(response) {
                                window.location = 'participant_profile.php?id=<?php echo $person->participant_id ?>';
                            }
                            ).fail(function() {alert('You do not have permission to perform this action.');})">&nbsp;&nbsp;
                            <input type="button" value="Add As Parent" onclick="$.post(
                                            '../ajax/add_relative.php',
                                            {
                                                child: '<?php echo $person->participant_id ?>',
                                                parent: document.getElementById('relative_search').value
                                            },
                                    function(response) {
                                        window.location = 'participant_profile.php?id=<?php echo $person->participant_id ?>';
                                    }
                                    ).fail(function() {alert('You do not have permission to perform this action.');})">


                        </td></tr>
                    <!--If the right person didn't show up in the search, there's a quick add here.
                    This only requires the new person's first and last name.  If a child is in a program and you want to record 
                    his/her parent(s) in the DB, you need only their first and last names to add them with this quick add.
                    -->
                    <td colspan="4">
                        <a href="javascript:;" onclick="$('#family_quick_add').toggle();
                                $('#show_results_profile').hide();
                                $('#add_buttons').hide();" class="helptext">Can't find who you're looking for?</a>
                        <div id="family_quick_add" style="display:none;">
                            <table>
                                <tr><th colspan="2"><strong>Quick Add New Participant</strong></th></tr>
                                <tr><td><strong>First Name:</strong></td><td><input type="text" id="add_family_first_name" /></td></tr>
                                <tr><td><strong>Last Name:</strong></td><td><input type="text" id="add_family_last_name" /></td></tr>
                                <tr><td colspan="2"><input type="button" value="Add As Child" onclick="
                                        $.post(
                                                '../ajax/add_participant.php',
                                                {
                                                    action: 'link_child',
                                                    parent: '<?php echo $person->participant_id ?>',
                                                    first_name: document.getElementById('add_family_first_name').value,
                                                    last_name: document.getElementById('add_family_last_name').value,
                                                    add_to_parent: '1'
                                                },
                                        function(response) {
                                            window.location = 'participant_profile.php?id=<?php echo $person->participant_id ?>';
                                        }
                                        ).fail(function() {alert('You do not have permission to perform this action.');})">
                                        <input type="button" value="Add As Parent" onclick="$.post(
                                                        '../ajax/add_participant.php',
                                                        {
                                                            action: 'link_parent',
                                                            child: '<?php echo $person->participant_id ?>',
                                                            first_name: document.getElementById('add_family_first_name').value,
                                                            last_name: document.getElementById('add_family_last_name').value,
                                                            add_to_child: '1'
                                                        },
                                                function(response) {
                                                    //document.write(response);
                                                    window.location = 'participant_profile.php?id=<?php echo $person->participant_id ?>';
                                                }
                                                ).fail(function() {alert('You do not have permission to perform this action.');})">
                            </table>
<?php
} //end access check
?>
                    </td></tr></table></td></tr></table>
<br/><br/>

<!--Saves consent forms by year.  This is going to need refinement.  Right now it assumes only one kind of
consent form (CPS).  In reality, each program has program consent forms too, and they want to save those
forms as well.-->
<?php if ($person->role == 1) { ?><h4>Consent Forms</h4>
    <table class="inner_table">
        <tr style="font-size:.9em;"><th>School Year</th><th>Consent Form Received</th><th></th></tr>
        <?php
        //get existing records
        $all_consent = "SELECT * FROM Participants_Consent WHERE Participant_ID=$person->participant_id ORDER BY School_Year";
        // echo $all_consent;
        include "../include/dbconnopen.php";
        $consents_given = mysqli_query($cnnEnlace, $all_consent);
        while ($consent = mysqli_fetch_row($consents_given)) {
            ?>
            <tr><td><?php
                    $years = str_split($consent[2], 2);
                    echo '20' . $years[0] . '-20' . $years[1];
                    ?></td><td><?php
                    if ($consent[3] == 1) {
                        echo 'Yes';
                    } else {
                        echo 'No';
                    }
                    ?></td><td></td></tr>
                <?php
            }
            include "../include/dbconnclose.php";
            ?>
        <tr><!--Add new record-->
            <td><select id="school_year_consent_new">
                    <option value="">-----</option>
                    <option value="1213">2012-2013</option>
                    <option value="1314">2013-2014</option>
                    <option value="1415">2014-2015</option>
                    <option value="1516">2015-2016</option>
                    <option value="1617">2016-2017</option>
                    <option value="1718">2017-2018</option>
                    <option value="1819">2018-2019</option>
                    <option value="1920">2019-2020</option>
                </select></td>
            <td><input type="checkbox" id="form_consent_new"></td>
            <td><input type="button" value="Save" onclick="
                    if (document.getElementById('form_consent_new').checked == true) {
                        var consent_given = 1;
                    }
                    else {
                        var consent_given = 0;
                    }
                    $.post(
                            '../ajax/save_consent.php',
                            {
                                participant: '<?php echo $person->participant_id ?>',
                                year: document.getElementById('school_year_consent_new').value,
                                form: consent_given
                            },
                    function(response) {
                        window.location='participant_profile.php?id=<?php echo $person->participant_id ?>';
                    }
                    ).fail(function() {alert('You do not have permission to perform this action.');})"></td>
        </tr>
    </table>
    <?php
}
?>
</td>

<!--List of the programs and sessions that this person joined.
-->
<td><h4>Program Involvement</h4>
    <table>
        <tr>
            <td><?php
                $get_all_programs = "SELECT Session_Names.*, Name FROM Session_Names INNER JOIN Participants_Programs ON 
                Session_Names.Session_ID=Participants_Programs.Program_ID 
                INNER JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID
                WHERE Participant_Id='$person->participant_id' ORDER BY Name";
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
                                ).fail(function() {alert('You do not have permission to perform this action.');})"><?php echo $program[6] . ' - ' . $program[1]; ?></a><br><?php
                   }
                   include "../include/dbconnclose.php";
                   ?></td>

            <!--Add to new session here:-->

            <td><span class="helptext">Add to program:</span><br/>
                <select id="programs" onchange="
                        var selected_prog = this.value;
                        $.post(
                                '../ajax/edit_program.php',
                                {
                                    action: 'find_sessions',
                                    program: selected_prog
                                },
                        function(response) {
                            document.getElementById('show_sessions_results').innerHTML = response;
                        }).fail(function() {alert('You do not have permission to perform this action.');})">
                    <option value="0">-----</option>
                    <?php
                    $get_all_programs = "SELECT Program_ID, Name FROM Programs ORDER BY Name";
                    include "../include/dbconnopen.php";
                    $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
                    while ($program = mysqli_fetch_row($all_programs)) {
                        ?>
                        <option value="<?php echo $program[0]; ?>"><?php echo $program[1]; ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </select>
                <div id="show_sessions_results"></div>
                <input type="button" value="Add" onclick="
                        $.post(
                                '../ajax/join_program.php',
                                {
                                    participant: '<?php echo $person->participant_id; ?>',
                                    program_id: document.getElementById('choose_session_new').value
                                },
                        function(response) {
                            window.location = 'participant_profile.php?id=<?php echo $person->participant_id; ?>';
                        }
                        ).fail(function() {alert('You do not have permission to perform this action.');})"></td>
        </tr>
    </table>


    <br/>
    <br/>

    <!--
    Shows the events (both in and out of campaigns) that this person has attended.
    -->

    <h4>Event Attendance</h4>
    <table width="100%">
        <tr style="font-size:.9em;"><th>Campaign</th><th>Event Name</th><th>Date</th></tr>
        <?php
        $get_events = "SELECT Event_Name, Campaign_Name, MONTH(Event_Date), DAY(Event_Date), YEAR(Event_Date) FROM Participants_Events
        INNER JOIN Campaigns_Events ON Event_ID=Campaign_Event_ID
        LEFT JOIN Campaigns ON Campaigns_Events.Campaign_ID=Campaigns.Campaign_ID
        WHERE Participant_ID=$person->participant_id
        ORDER BY Event_Date DESC";
        include "../include/dbconnopen.php";
        $events = mysqli_query($cnnEnlace, $get_events);
        while ($ev = mysqli_fetch_row($events)) {
            ?>
            <tr><td><?php echo $ev[1]; ?></td><td><?php echo $ev[0]; ?></td>
                <td><?php echo $ev[2] . '/' . $ev[3] . '/' . $ev[4]; ?></td></tr>
            <?php
        }
        include "../include/dbconnclose.php";
        ?>
    </table>
    <br/><br/>

    <!--Shows the mentorship hours completed and allows new hours to be added.
    Note that mentorship hours are saved here because they are separate from
    program attendance.
    -->

    <h4>Mentorship Hours</h4>
    <table class="inner_table">
        <tr style="font-size:.9em;"><th>Date</th><th>No. of Hours</th><th>Program</th><th></th></tr>
        <?php
        //show entered hours for this person
        $get_mentee_hours = "SELECT MONTH(Mentorship_Date), DAY(Mentorship_Date), YEAR(Mentorship_Date),
        Mentorship_Hours_Logged, Name, Session_Name, Mentorship_Time_ID, Session_ID
        FROM Participants_Mentorship LEFT JOIN Session_Names
        ON Mentorship_Program=Session_ID
        LEFT JOIN Programs ON Programs.Program_Id=Session_Names.Program_Id
        WHERE Mentee_ID='" . $person->participant_id . "' ORDER BY Mentorship_Date DESC";
        // echo $get_mentee_hours;
        include "../include/dbconnopen.php";
        $mentee_hours = mysqli_query($cnnEnlace, $get_mentee_hours);
        while ($hrs = mysqli_fetch_row($mentee_hours)) {
            ?>
            <tr>
                <td><?php echo $hrs[0] . '/' . $hrs[1] . '/' . $hrs[2]; ?><br>
                    <input type="text" class="mentorship_edit_<?php echo $hrs[6]; ?> addDP mentorship_edit" id="edit_mentorship_date_<?php echo $hrs[6]; ?>" value="<?php echo $hrs[2] . '-' . $hrs[0] . '-' . $hrs[1]; ?>"
                           ></td>
                <td><?php echo $hrs[3]; ?><br>
                    <input type="text" class="mentorship_edit_<?php echo $hrs[6]; ?> mentorship_edit" id="edit_mentorship_hours_<?php echo $hrs[6]; ?>" value="<?php echo $hrs[3]; ?>"></td>
                <td><?php echo $hrs[4] . ' - ' . $hrs[5]; ?><br>
                    <select class="mentorship_edit_<?php echo $hrs[6]; ?> mentorship_edit" id="edit_mentorship_session_<?php echo $hrs[6]; ?>">
                        <option value="">-----</option>
                    <?php
                    $get_all_programs = "SELECT Session_Names.Session_ID, Name, Session_Name FROM Session_Names
                    INNER JOIN Participants_Programs ON Session_ID=Participants_Programs.Program_ID 
                    INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID
                    WHERE Participant_Id='$person->participant_id' ORDER BY Name";
                    include "../include/dbconnopen.php";
                    $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
                    while ($program = mysqli_fetch_row($all_programs)) {
                        ?><option value="<?php echo $program[0]; ?>" <?php echo($hrs[7] == $program[0] ? "selected='selected'" : null); ?>>
                            <?php echo $program[1] . ' - ' . $program[2]; ?></option><?php
                    }
                    //include "../include/dbconnclose.php";
                    ?>
                    </select></td>
                <td><input type="button" value="Edit" onclick="$('.mentorship_edit_<?php echo $hrs[6]; ?>').toggle();"><br>
                    <input type="button" class="mentorship_edit_<?php echo $hrs[6]; ?> mentorship_edit" onclick="$.post(
                                        '../ajax/add_mentorship_hours.php',
                                        {
                                            action: 'edit',
                                            date: document.getElementById('edit_mentorship_date_<?php echo $hrs[6]; ?>').value,
                                            hours: document.getElementById('edit_mentorship_hours_<?php echo $hrs[6]; ?>').value,
                                            session: document.getElementById('edit_mentorship_session_<?php echo $hrs[6]; ?>').value,
                                            id: '<?php echo $hrs[6]; ?>'
                                        },
                                function(response) {
                                 //     document.write(response);
                                   window.location = 'participant_profile.php?id=<?php echo $person->participant_id; ?>';
                                }
                                ).fail(function() {alert('You do not have permission to perform this action.');})" value="Save"></td>
                <td><!--Delete hours!-->
                    <input type="button" onclick="$.post(
                                        '../ajax/add_mentorship_hours.php',
                                        {
                                            action: 'delete',
                                            id: '<?php echo $hrs[6]; ?>'
                                        },
                                function(response) {
                                    //  document.write(response);
                                    window.location = 'participant_profile.php?id=<?php echo $person->participant_id; ?>';
                                }
                                ).fail(function() {alert('You do not have permission to perform this action.');})" value="Delete">
                </td>
            </tr>
            <?php
        }
        include "../include/dbconnclose.php";
        ?>
        <tr><td><input type="text" class="addDP" id="new_mentorship_date"></td>
            <td><input type="text" id="new_mentorship_hours" style="width:25px;"></td>
            <td><select id="all_programs_this_person">
                    <option value="">-----</option>
                    <?php
                    $get_all_programs = "SELECT Session_Names.Session_ID, Name, Session_Name FROM Session_Names
                    INNER JOIN Participants_Programs ON Session_ID=Participants_Programs.Program_ID 
                    INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID
                    WHERE Participant_Id='$person->participant_id' ORDER BY Name";
                    include "../include/dbconnopen.php";
                    $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
                    while ($program = mysqli_fetch_row($all_programs)) {
                        ?><option value="<?php echo $program[0]; ?>">
                            <?php echo $program[1] . ' - ' . $program[2]; ?></option><?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </select></td>
            <td><input type="button" value="Add Hours" onclick="
                    $.post(
                            '../ajax/add_mentorship_hours.php',
                            {
                                date: document.getElementById('new_mentorship_date').value,
                                hours: document.getElementById('new_mentorship_hours').value,
                                program: document.getElementById('all_programs_this_person').value,
                                person: '<?php echo $person->participant_id; ?>'
                            },
                    function(response) {
                        // document.write(response);
                        window.location = 'participant_profile.php?id=<?php echo $person->participant_id; ?>';
                    }
                    ).fail(function() {alert('You do not have permission to perform this action.');});"></td>
        </tr> 
    </table>

    <br/>
    <br/>
    <!--
    Shows referrals to programs from other programs, people, or institutions.
    -->
    <h4>Referrals</h4>
    <table width="100%">
        <tr style="font-size:.9em;">
            <th>Date</th><th>Referred by:</th><th>Program Referred to</th>
        </tr>
        <?php
//get referrals for this person
        $these_referrals = "SELECT MONTH(Date_Logged), DAY(Date_Logged), YEAR(Date_Logged), Institution_Name,
        referrer_prog.Name, prog_referred.Name, First_Name, Last_Name
        FROM Referrals 
        LEFT JOIN Institutions ON Referrer_Institution=Inst_ID
        LEFT JOIN Programs as referrer_prog ON Referrer_Program=referrer_prog.Program_ID
        LEFT JOIN Programs AS prog_referred ON Program_Referred=prog_referred.Program_ID
        LEFT JOIN Participants ON Referrer_Person=Participants.Participant_ID
        WHERE Referrals.Participant_ID=$person->participant_id";
// echo $these_referrals;
        include "../include/dbconnopen.php";
        $referrals = mysqli_query($cnnEnlace, $these_referrals);
        while ($refer = mysqli_fetch_row($referrals)) {
            ?>
            <tr><td><?php echo $refer[0] . '/' . $refer[1] . '/' . $refer[2]; ?></td>
                <td><b>Person:</b> <?php echo $refer[6] . " " . $refer[7]; ?><br>
                    <b>Program:</b> <?php echo $refer[4]; ?><br>
                    <b>Institution:</b> <?php echo $refer[3]; ?>
                </td>
                <td>
                    <?php echo $refer[5]; ?>
                </td>
            </tr>
            <?php
        }
        include "../include/dbconnclose.php";
        ?>
        <tr><td></td>

            <!--Add a new referral:
            Note that a referring person, program, OR institution may be added.  Any or all of these will do.
            -->
            <td colspan="2">
                <a href="javascript:;" onclick="$('#add_referral').toggle();" class="helptext">Add referral...</a>
                <div id="add_referral">
                    <span class="helptext">Referred by:</span><br/>
                    A person: <a href="javascript:;" onclick="$('#search_parti_table').toggle();">(search)</a><table class="inner_table" id="search_parti_table" style="font-size:.9em;">
                        <tr>
                            <td><strong>First Name: </strong></td>
                            <td><input type="text" id="first_name_search" style="width:125px;"/></td>
                            <td><strong>Last Name: </strong></td>
                            <td><input type="text" id="last_name_search" style="width:125px;" /></td>
                        </tr>
                        <tr>
                            <td><strong>Date of Birth: </strong></td>
                            <td><input type="text" id="dob_search" class="addDP" /></td>
                            <td><strong>Grade Level: </strong></td>
                            <td><select id="grade_search">
                                    <option value="">--------</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:center;">
                                <input type="button" value="Search" onclick="
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
                                            $('#search_parti_table').hide();
                                        }).fail(function() {alert('You do not have permission to perform this action.');});"/>


                            </td>
                        </tr>
                    </table><div id="show_results"></div><br>
                    A program: <select id="from_program"><option value="0">-----</option>
                        <?php
                        $get_all_programs = "SELECT Program_ID, Name FROM Programs ORDER BY Name";
                        include "../include/dbconnopen.php";
                        $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
                        while ($program = mysqli_fetch_row($all_programs)) {
                            ?>
                            <option value="<?php echo $program[0]; ?>"><?php echo $program[1]; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?></select><br>
                    Or an institution: <select id="from_inst"><option value="">-----</option>
                        <?php
                        $get_institutions = "SELECT * FROM Institutions ORDER BY Institution_Name";
                        include "../include/dbconnopen.php";
                        $institutions = mysqli_query($cnnEnlace, $get_institutions);
                        while ($institution = mysqli_fetch_array($institutions)) {
                            ?>
                            <option value="<?php echo $institution['Inst_ID']; ?>"><?php echo $institution['Institution_Name']; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?></select><br/>
                    <span class="helptext">Referred to:</span><select id="to_program"><option value="0">-----</option>
                        <?php
                        $get_all_programs = "SELECT Program_ID, Name FROM Programs ORDER BY Name";
                        include "../include/dbconnopen.php";
                        $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
                        while ($program = mysqli_fetch_row($all_programs)) {
                            ?>
                            <option value="<?php echo $program[0]; ?>"><?php echo $program[1]; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?></select><br/>
                    <input type="button" value="Add Referral" onclick="
                            if (document.getElementById('relative_search')) {
                                var referrer = document.getElementById('relative_search').value;
                            }
                            else {
                                var referrer = '';
                            }
                            $.post(
                                    '../ajax/add_referral.php',
                                    {
                                        action: 'new',
                                        participant: '<?php echo $person->participant_id ?>',
                                        person_referrer: referrer,
                                        program_referrer: document.getElementById('from_program').value,
                                        inst_referrer: document.getElementById('from_inst').value,
                                        program_referred: document.getElementById('to_program').value
                                    },
                            function(response) {
                                //document.write(response);
                                window.location = 'participant_profile.php?id=<?php echo $person->participant_id ?>';
                            }
                            ).fail(function() {alert('You do not have permission to perform this action.');});">
                </div>

            </td>
        </tr>

    </table>
</td>
</tr>


<tr><td>
        <br/><br/>

        <!--These follow-ups are a free text field (limited to 400 characters) where a person's progress over time
        can be recorded.-->

        <h4>Follow-up Notes</h4>
        <table class="inner_table">
            <tr style="font-size:.9em;"><th>Date</th><th>Type of Followup</th></tr>
            <?php
//get followups
            $get_notes = "SELECT Note, MONTH(Date), DAY(Date), YEAR(Date) FROM Followups WHERE Participant=$person->participant_id";
            include "../include/dbconnopen.php";
            $notes = mysqli_query($cnnEnlace, $get_notes);
            while ($note = mysqli_fetch_row($notes)) {
                ?>
                <tr><td><?php echo $note[1] . '/' . $note[2] . '/' . $note[3]; ?></td>
                    <td><?php echo $note[0]; ?></td>
                </tr>
                <?php
            }
            include "../include/dbconnclose.php";
            ?>

            <tr><td><span class="helptext">Notes will be saved automatically when you click away, along with today's date.</span></td>
                <td><textarea onblur="
                        $.post(
                                '../ajax/followup_edit.php',
                                {
                                    action: 'new',
                                    person: '<?php echo $person->participant_id; ?>',
                                    note: this.value
                                },
                        function(response) {
                            window.location = 'participant_profile.php?id=<?php echo $person->participant_id; ?>';
                        }
                        ).fail(function() {alert('You do not have permission to perform this action.');})">Add followup note here.</textarea></td></tr>
        </table>


    </td>
</tr>
<tr><td>
    </td></tr> 
</table>

<br/><br/>
</div>
<?php
include "../../footer.php";
?>
