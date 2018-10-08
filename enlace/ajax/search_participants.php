<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *   Copyright (C) 2018 Open Tech Strategies, LLC
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

$access_array = $USER->program_access($Enlace_id);
$access = $access_array[0];

/* search from the participants homepage. */
/* if a search term is filled in, then it is included in the query.  otherwise it isn't. */
include "../include/dbconnopen.php";
if ($_POST['first'] == '') {
    $first = '';
} else {
    $first_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['first']);
    $first = ' AND First_Name LIKE "%' . $first_sqlsafe . '%" ';
}
if ($_POST['last'] == '') {
    $last = '';
} else {
    $last_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['last']);
    $last = " AND Last_Name LIKE '%" . $last_sqlsafe . "%' ";
}
if ($_POST['dob'] == '') {
    $dob = '';
} else {
    $dob_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['dob']);
    $dob = " AND DOB='" . $dob_sqlsafe . "' ";
}
if ($_POST['gender'] == '') {
    $gender = '';
} else {
    $gender_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['gender']);
    $gender = " AND Gender='" . $gender_sqlsafe . "' ";
}
if ($_POST['role'] == '') {
    $role = '';
} else {
    $role_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['role']);
    $role = " AND Role='" . $role_sqlsafe . "' ";
}
if ($_POST['grade'] == '') {
    $grade = '';
} else {
    $grade_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['grade']);
    $grade = " AND Grade='" . $grade_sqlsafe . "' ";
}
if ($_POST['program'] == 0) {
    $program = '';
    $program_join = '';
} else {
    $program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program']);
    $program_join = " INNER JOIN Participants_Programs ON Participants_Programs.Participant_ID=
    Participants.Participant_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_ID ";
    $program = " AND Session_Names.Program_ID='" . $program_sqlsafe . "' ";
}
if ($_POST['id'] == '') {
    $id = '';
} else {
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
    $id = " AND Participants.Participant_ID='" . $id_sqlsafe . "' ";
}

if (!isset($_POST['order'])) {
    $order = " Last_Name ";
} elseif ($_POST['order'] == 'dob') {
    $order = " DOB";
} elseif ($_POST['order'] == 'id') {
    $order = " Participants.Participant_ID ";
} elseif ($_POST['order'] == 'name') {
    $order = " Last_Name";
}

$uncertain_search_query = "SELECT * FROM Participants " . $program_join
        . " WHERE Participants.Participant_ID!='' " . $first . $last . $dob . $gender
        . $role . $grade . $id . $program . " ORDER BY " . $order;
//echo $uncertain_search_query;

$results = mysqli_query($cnnEnlace, $uncertain_search_query);

/* show results as dropdown. */
if ($_POST['result'] == 'dropdown') {
    //echo $uncertain_search_query;
    ?>
    <span class="helptext">Select the name of the person you would like to add: </span><select id="relative_search">
        <option value="">-----</option>
        <?php while ($user = mysqli_fetch_array($results)) {
            if (isset($_POST['verbose'])) {
                $this_date = explode('-', $user['DOB']);
                if ($user['DOB'] != '0000-00-00' && $this_date[1]) {
                    date_default_timezone_set('America/Chicago');
                    $show_date = mktime(0, 0, 0, $this_date[1], $this_date[2], $this_date[0]);
                    $display_date = "DOB: " . date('n/j/Y', $show_date) . ", ";
                } else {
                    $display_date = "";
                }

                $display = $user['First_Name'] . " " . $user['Last_Name'] . " (" . $display_date . "ID: " . $user['Participant_ID'] . ")";
            } else {
                $display = $user['First_Name'] . " " . $user['Last_Name'];
            }
            ?><option value="<?php echo $user['Participant_ID']?>"><?php echo $display; ?></option><?php
        }
        ?>
    </select>
    <?php
}
/* show results as table */ else {
    ?>
    <br/><h4>Search Results</h4>
    <table class="program_table" width="50%">
        <tr>
            <!--Can sort results by any of the table headings.-->
            <th><a href="javascript:;" onclick="$.post(
                                '/enlace/ajax/search_participants.php',
                                {
                                    first: document.getElementById('first_name_search').value,
                                    last: document.getElementById('last_name_search').value,
                                    dob: document.getElementById('dob_search').value,
                                    grade: document.getElementById('grade_search').value,
                                    gender: document.getElementById('gender_search').options[document.getElementById('gender_search').selectedIndex].value,
                                    role: document.getElementById('role_search').options[document.getElementById('role_search').selectedIndex].value,
                                    program: document.getElementById('program_search').value,
                                    id: document.getElementById('search_id').value,
                                    order: 'id'
                                            //  inst: document.getElementById('institution_search').value
                                },
                        function(response) {
                            document.getElementById('show_results').innerHTML = response;
                        }).fail(function() {alert('You do not have permission to perform this action.');});">ID</a></th>
            <th><a href="javascript:;" onclick="$.post(
                                '/enlace/ajax/search_participants.php',
                                {
                                    first: document.getElementById('first_name_search').value,
                                    last: document.getElementById('last_name_search').value,
                                    dob: document.getElementById('dob_search').value,
                                    grade: document.getElementById('grade_search').value,
                                    gender: document.getElementById('gender_search').options[document.getElementById('gender_search').selectedIndex].value,
                                    role: document.getElementById('role_search').options[document.getElementById('role_search').selectedIndex].value,
                                    program: document.getElementById('program_search').value,
                                    id: document.getElementById('search_id').value,
                                    order: 'name'
                                            //  inst: document.getElementById('institution_search').value
                                },
                        function(response) {
                            document.getElementById('show_results').innerHTML = response;
                        }).fail(function() {alert('You do not have permission to perform this action.');});">Name</a></th>
            <th><a href="javascript:;" onclick="$.post(
                                '/enlace/ajax/search_participants.php',
                                {
                                    first: document.getElementById('first_name_search').value,
                                    last: document.getElementById('last_name_search').value,
                                    dob: document.getElementById('dob_search').value,
                                    grade: document.getElementById('grade_search').value,
                                    gender: document.getElementById('gender_search').options[document.getElementById('gender_search').selectedIndex].value,
                                    role: document.getElementById('role_search').options[document.getElementById('role_search').selectedIndex].value,
                                    program: document.getElementById('program_search').value,
                                    id: document.getElementById('search_id').value,
                                    order: 'dob'
                                            //  inst: document.getElementById('institution_search').value
                                },
                        function(response) {
                            document.getElementById('show_results').innerHTML = response;
                        }).fail(function() {alert('You do not have permission to perform this action.');});">DOB</a></th>
                <?php
                //if an administrator
    if ($USER->has_site_access($Enlace_id, $AdminAccess)) {
                    //show delete area
                    ?>
                    <th>
                        Delete
                    </th>
                    <?php
                }
                ?>
        </tr>
        <?php
        while ($user = mysqli_fetch_array($results)) {
            $this_date = explode('-', $user['DOB']);
            if ($this_date[1]) {
                date_default_timezone_set('America/Chicago');
                $show_date = mktime(0, 0, 0, $this_date[1], $this_date[2], $this_date[0]);
                $display_date = date('n/j/Y', $show_date);
            } else {
                $display_date = "";
            }
            ?>
            <tr>
                <td class="all_projects"><?php echo $user['Participant_ID']; ?></td>
                <td class="all_projects" style="text-align:left;"><a href="participant_profile.php?id=<?php echo $user['Participant_ID'];?>"><?php echo $user['First_Name'] . " " . $user['Last_Name']; ?></a></td>
                <td class="all_projects"><?php
                    if ($user['DOB'] != '0000-00-00') {
                        echo $display_date;
                    }
                    ?></td>
                <?php
                //if an administrator

                    if ($USER->has_site_access($Enlace_id, $AdminAccess)) {
                    //show delete area
                    ?>
                <td class="all_projects" style="text-align: center;">
                        <a href="javascript:;" onclick="
                                            if (confirm('ARE YOU SURE YOU WANT TO COMPLETELY DELETE THIS PARTICIPANT?\r\n'
                                                        + 'NOTE: This will delete all of this participant\'s data as well.')) {
                                                if (confirm('ARE YOU SURE?')) {
                                                    $.post(
                                                            '../ajax/join_program.php',
                                                            {
                                                                action: 'delete_participant',
                                                                participant_id: '<?php echo $user['Participant_ID']; ?>'
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location = 'participants.php';
                                                    }
                                                    ).fail(function() {alert('You do not have permission to perform this action.');});
                                                }
                                            }" style="font-size:.8em; color: #f00; font-weight: bold;">X</a>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <?php
        }
    }

    include "../include/dbconnclose.php";
    ?>