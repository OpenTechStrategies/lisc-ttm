<?php
require_once("../siteconfig.php");
?>
<?php
/*
 * First determine if the user is an admin. Usually this will be a program ID number,
 * but sometimes it will be 'a' (all) or 'n' (none).
 */
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");

$user_sqlsafe=mysqli_real_escape_string($cnnLISC, $_COOKIE['user']);
$get_program_access = "SELECT Program_Access FROM Users_Privileges INNER JOIN Users ON Users.User_Id = Users_Privileges.User_ID
    WHERE User_Email = '" . $user_sqlsafe . "'";

$program_access = mysqli_query($cnnLISC, $get_program_access);
$prog_access = mysqli_fetch_row($program_access);
$access = $prog_access[0];
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");


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
            ?><option value="<?echo $user['Participant_ID']?>"><?php echo $user['First_Name'] . " " . $user['Last_Name']; ?></option><?php
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
                        });">ID</a></th>
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
                        });">Name</a></th>
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
                        });">DOB</a></th>
                <?php
                //if an administrator
                if ($access == 'a') {
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
                <td class="all_projects" style="text-align:left;"><a href="participant_profile.php?id=<?echo $user['Participant_ID'];?>"><?php echo $user['First_Name'] . " " . $user['Last_Name']; ?></a></td>
                <td class="all_projects"><?php
                    if ($user['DOB'] != '0000-00-00') {
                        echo $display_date;
                    }
                    ?></td>
                <?php
                //if an administrator
                if ($access == 'a') {
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
                                                    )
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