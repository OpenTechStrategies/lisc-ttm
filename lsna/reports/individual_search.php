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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($LSNA_id);
?>
<!--
Query construction and results for the Participant Query Search (see query.php)
-->

<?php
/* put date of birth in database format) */
$date_reformat = explode('-', $_POST['dob']);
$save_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];

/* like all the query reports I've built across these systems, if the search term is filled in then it is included
 * in the query.  If the space is left blank, then the variable in the query is empty.
 * For first name, for example, if it's left blank then "$first" doesn't add anything to the query.  If a first name
 * has been entered, then Participants.Name_First must include that name or name fragment. */
include "../include/dbconnopen.php";
$first_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['first']);
$role_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['role']);
$last_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['last']);
$gender_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['gender']);
$language_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['language']);
$zip_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['zip']);
$ward_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['ward']);
$phone_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['phone']);
$school_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['school']);
$grade_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['grade']);
$program_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['program']);
$campaign_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['campaign']);
$institution_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['institution']);
$event_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['event']);
$year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['year']);
$consent_2013_14_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['consent_2013_14']);
$consent_2014_15_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['consent_2014_15']);
$consent_2015_16_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['consent_2015_16']);



if ($_POST['first'] == '') {
    $first = '';
} else {
    $first = ' AND Participants.Name_First LIKE "%' . $first_sqlsafe . '%"';
};
/* some variables require a join to another table: */
if ($_POST['role'] != '') {
    $role_join = " INNER JOIN Participants_Roles
    ON Participants.Participant_ID=Participants_Roles.Participant_ID ";
    $role = " AND Participants_Roles.Role_ID='" . $role_sqlsafe . "' ";
} else {
    $role_join = "";
    $role = "";
}

if ($_POST['last'] == '') {
    $last = '';
} else {
    $last = " AND Participants.Name_Last LIKE '%" . $last_sqlsafe . "%'";
}
if ($_POST['gender'] == '') {
    $gender = '';
} else {
    $gender = " AND Participants.Gender='" . $gender_sqlsafe . "'";
}
if ($_POST['language'] == '') {
    $language = '';
} else {
    $language_join = " INNER JOIN Participants_Languages ON Participants.Participant_Id=Participants_Languages.Participant_ID ";
    $language = " AND Language_ID='" . $language_sqlsafe . "' ";
} //actually needs a join
if ($_POST['zip'] == '') {
    $zip = '';
} else {
    $zip = " AND Participants.Address_Zip='" . $zip_sqlsafe . "' ";
}
if ($_POST['ward'] == '') {
    $ward = '';
} else {
    $ward = " AND Participants.Ward='" . $ward_sqlsafe . "'";
}
if ($_POST['phone'] == '') {
    $phone = '';
} else {
    $phone = " AND (Participants.Phone_Day LIKE '%" . $phone_sqlsafe . "%' OR 
                Participants.Phone_Evening LIKE '%" . $phone_sqlsafe . "%')";
}
if ($_POST['school'] == '') {
    $school = "";
} else {
    $pm_year_join = " LEFT JOIN PM_Years ON Participants.Participant_ID=PM_Years.Participant ";
    $school = " AND PM_Years.School='" . $school_sqlsafe . "' ";
}
if ($_POST['dob'] == '') {
    $dob = '';
} else {
    $dob = " AND Participants.Date_of_Birth='" . $save_date . "' ";
}
if ($_POST['grade'] == '') {
    $grade = '';
} else {
    $grade = " AND Participants.Grade_Level='" . $grade_sqlsafe . "'";
}
if ($_POST['program'] == '' && $_POST['campaign'] == '') {
    $subcategory_join = "";
}
if ($_POST['program'] == '') {
    $program = "";
} else {
    $subcategory_join = " INNER JOIN Participants_Subcategories ON Participants.Participant_ID=
    Participants_Subcategories.Participant_ID ";
    $program = " AND Participants_Subcategories.Subcategory_ID='" . $program_sqlsafe . "'";
}
if ($_POST['campaign'] == '') {
    $campaign = "";
} else {
    $subcategory_join = " INNER JOIN Participants_Subcategories ON Participants.Participant_ID=
    Participants_Subcategories.Participant_ID ";
    $campaign = " AND Participants_Subcategories.Subcategory_ID='" . $campaign_sqlsafe . "'";
}
if ($_POST['institution'] == '') {
    $institution_join = "";
    $institution = "";
} else {
    $institution_join = " INNER JOIN Institutions_Participants ON Participants.Participant_ID=
    Institutions_Participants.Participant_ID ";
    $institution = " AND Institution_ID='" . $institution_sqlsafe . "'";
}
if ($_POST['event'] == '') {
    $event_join = "";
    $event = "";
} else {
    $event_join = " INNER JOIN Subcategory_Attendance ON Participants.Participant_ID=
    Subcategory_Attendance.Participant_ID LEFT JOIN Subcategory_Dates
ON Subcategory_Date=Wright_College_Program_Date_ID ";
    $event = " AND Wright_College_Program_Date_ID='" . $event_sqlsafe . "'";
}
if ($_POST['pm'] == 1) {
    $pm_join = " LEFT JOIN Participants_Subcategories AS PS_left ON Participants.Participant_ID=PS_left.Participant_ID ";
    $pm = " AND PS_left.Subcategory_ID=19 ";
} elseif ($_POST['pm'] == 2) {//$pm_join=" LEFT JOIN Participants_Subcategories ON Participants.Participant_ID=Participants_Subcategories.Participant_ID ";
    $pm_join = "LEFT JOIN
 Participants_Subcategories AS PS_left
ON (Participants.Participant_Id=PS_left.Participant_ID AND PS_left.Subcategory_ID='19')";
//$pm=" AND Subcategory_ID!=19 ";
    $pm = " AND Participant_Subcategory_ID IS NULL";
} else {
    $pm_join = "";
    $pm = "";
}

if ($_POST['year'] == '') {
    $year = '';
} else {
    $pm_year_join = " LEFT JOIN PM_Years ON Participants.Participant_ID=Participant ";
    $year = " AND Year='" . $year_sqlsafe . "'";
}

if ($_POST['consent_2013_14'] == '') {
    $consent_2013_14 = '';
} elseif ($_POST['consent_2013_14'] == '0') {
    $consent_2013_14 = " AND (Participants.Consent_2013_14='" . $consent_2013_14_sqlsafe . "' OR Participants.Consent_2013_14 IS NULL)";
} elseif ($_POST['consent_2013_14'] == '1') {
    $consent_2013_14 = " AND Participants.Consent_2013_14='" . $consent_2013_14_sqlsafe . "'";
}
if ($_POST['consent_2014_15'] == '') {
    $consent_2014_15 = '';
} elseif ($_POST['consent_2014_15'] == '0') {
    $consent_2014_15 = " AND (Participants.Consent_2014_15='" . $consent_2014_15_sqlsafe . "' OR Participants.Consent_2014_15 IS NULL)";
} elseif ($_POST['consent_2014_15'] == '1') {
    $consent_2014_15 = " AND Participants.Consent_2014_15='" . $consent_2014_15_sqlsafe . "'";
}
if ($_POST['consent_2015_16'] == '') {
    $consent_2015_16 = '';
} elseif ($_POST['consent_2015_16'] == '0') {
    $consent_2015_16 = " AND (Participants.Consent_2015_16='" . $consent_2015_16_sqlsafe . "' OR Participants.Consent_2015_16 IS NULL)";
} elseif ($_POST['consent_2015_16'] == '1') {
    $consent_2015_16 = " AND Participants.Consent_2015_16='" . $consent_2015_16_sqlsafe . "'";
}

/* all the query pieces come together here.  For the terms that weren't filled in, these joins and requirements are empty. */
$uncertain_search_query = "SELECT * FROM Participants " . $role_join . $pm_join . $pm_year_join . $subcategory_join . $institution_join . $event_join . $language_join . " 
    WHERE Participants.Participant_ID!='' " . $first . $last .
        $gender . $dob . $grade . $year . $consent_2013_14 . $consent_2014_15 . $consent_2015_16 .
        $role . $language . $ward . $zip . $phone . $school . $program . $campaign . $institution .
        $event . $pm . " GROUP BY Participants.Participant_ID ORDER BY Name_Last";

/* $actual_find_non_pms="SELECT * FROM Participants LEFT JOIN
  Participants_Subcategories
  ON (Participants.Participant_Id=Participants_Subcategories.Participant_ID AND Subcategory_ID='19')
  WHERE Participant_Subcategory_ID IS NULL;"; */


include "../include/dbconnopen.php";
$results = mysqli_query($cnnLSNA, $uncertain_search_query);

/* create file for export of results: */
date_default_timezone_set('America/Chicago');
$infile = "export_data/search_individuals_" . date('M-d-Y') . ".csv";
$fp = fopen($infile, "w") or die('can\'t open file');
$columns = array('Database ID', 'First Name', 'Last Name', 'Gender', 'Date of Birth', 'Grade Level', 'Role(s)');

if ($_POST['include_address'] == '1') array_push($columns, "Address");
if ($_POST['include_ward'] == '1') array_push($columns, "Ward");
if ($_POST['include_daytime_phone'] == '1') array_push($columns, "Daytime Phone");
if ($_POST['include_evening_phone'] == '1') array_push($columns, "Evening Phone");
if ($_POST['include_languages_spoken'] == '1') array_push($columns, "Languages Spoken");
if ($_POST['include_email'] == '1') array_push($columns, "Email");
fputcsv($fp, $columns);
?>
<!--Table of results: -->
<h4>Search Results</h4>
<table class="program_table" style="width:750px;">
    <tr>
        <th>Database ID</th>
        <th>Name</th>
        <th>Gender</th>
        <th width="12%">Date of Birth</th>
        <th>Grade Level</th>
        <th>Role(s)</th>
        <?php
        if ($_POST['include_address'] == '1') echo '<th>Address</th>';
        if ($_POST['include_ward'] == '1') echo '<th>Ward</th>';
        if ($_POST['include_daytime_phone'] == '1') echo '<th>Daytime Ph.</th>';
        if ($_POST['include_evening_phone'] == '1') echo '<th>Evening Ph.</th>';
        if ($_POST['include_languages_spoken'] == '1') echo '<th>Languages Sp.</th>';
        if ($_POST['include_email'] == '1') echo '<th>Email</th>';
        ?>
        <th></th>
    </tr>
<?php
while ($user = mysqli_fetch_array($results)) {
    $date_formatted = explode('-', $user['Date_of_Birth']);
    $date = $date_formatted[1] . '-' . $date_formatted[2] . '-' . $date_formatted[0];
    ?>
        <tr>
            <td class="all_projects"><?php echo $user['Participant_ID']; ?></td>
            <td class="all_projects" style="text-align:left;"><a href="javascript:;" onclick="
                            $('#participant_search_div').hide();
                            $('#new_participant_div').hide();
                            $('#participant_profile_div').show();
                            $.post(
                                    '/lsna/ajax/set_participant_id.php',
                                    {
                                        page: 'profile',
                                        participant_id: '<?php echo $user['Participant_ID']; ?>'
                                    },
                            function(response) {
                                if (response != '1') {
                                    document.getElementById('show_error').innerHTML = response;
                                }
                                document.write(response);
                                window.location = '/lsna/participants/participant_profile.php';
                            }
                            ).fail(failAlert);
                                                                 "><?php echo $user['Name_First'] . " " . $user['Name_Last']; ?></a></td>
            <td class="all_projects"><?php if ($user['Gender'] == 'm') {
        echo 'Male';
    } else if ($user['Gender'] == 'f') {
        echo 'Female';
    } ?></td>
            <td class="all_projects"><?php echo $date; ?></td>
            <td class="all_projects"><?php echo $user['Grade_Level']; ?></td>
            <td class="all_projects"><?php
    $get_roles = "SELECT * FROM Participants_Roles INNER JOIN Roles ON Participants_Roles.Role_ID=
            Roles.Role_ID WHERE Participants_Roles.Participant_ID='" . $user['Participant_ID'] . "'";
    $roles = mysqli_query($cnnLSNA, $get_roles);
    $role_string = "";
    while ($role = mysqli_fetch_array($roles)) {
        echo $role['Role_Title'] . "<br>";
        $role_string.= $role['Role_Title'] . "; ";
    }
    ?></td>
        <?php
        if ($_POST['include_address'] == '1') echo '<td class="all_projects">'
                                                    . $user['Address_Street_Num'] . ' '
                                                    . $user['Address_Street_Direction'] . ' '
                                                    . $user['Address_Street_Name'] . ' '
                                                    . $user['Address_Street_Type'] . ', '
                                                    . $user['Address_City'] . ', '
                                                    . $user['Address_State'] . ' '
                                                    . $user['Address_Zip']
                                                    . '</td>';
        if ($_POST['include_ward'] == '1') echo '<td class="all_projects">' . $user['Ward'] . '</td>';
        if ($_POST['include_daytime_phone'] == '1') echo '<td class="all_projects">' . $user['Phone_Day'] . '</td>';
        if ($_POST['include_evening_phone'] == '1') echo '<td class="all_projects">' . $user['Phone_Evening'] . '</td>';
        if ($_POST['include_languages_spoken'] == '1') {
            $get_languages = "SELECT *, Languages.Language FROM Participants_Languages
                                JOIN Languages ON Participants_Languages.Language_ID=
                                    Languages.Language_ID
                                WHERE Participants_Languages.Participant_ID='" . $user['Participant_ID'] . "'";
            $languages = mysqli_query($cnnLSNA, $get_languages);
            $language_string = "";
            while ($language = mysqli_fetch_array($languages)) {
                $language_string .= $language['Language'] . " ";
            }
            echo '<td class="all_projects">' . $language_string . '</td>';
        }
        if ($_POST['include_email'] == '1') echo '<td class="all_projects">' . $user['Email'] . '</td>';
        ?>
        </tr>
    <?php
    /* put results in the file: */
    $csv_array = array($user['Participant_ID'], $user['Name_First'], $user['Name_Last'], $user['Gender'], $user['Date_of_Birth'],
        $user['Grade_Level'], $role_string);
    
    if ($_POST['include_address'] == '1') array_push($csv_array, $user['Address_Street_Num'] . ' '
                                                    . $user['Address_Street_Direction'] . ' '
                                                    . $user['Address_Street_Name'] . ' '
                                                    . $user['Address_Street_Type'] . ', '
                                                    . $user['Address_City'] . ', '
                                                    . $user['Address_State'] . ' '
                                                    . $user['Address_Zip']);
    if ($_POST['include_ward'] == '1') array_push($csv_array, $user['Ward']);
    if ($_POST['include_daytime_phone'] == '1') array_push($csv_array, $user['Phone_Day']);
    if ($_POST['include_evening_phone'] == '1') array_push($csv_array, $user['Phone_Evening']);
    if ($_POST['include_languages_spoken'] == '1') array_push($csv_array, $language_string);
    if ($_POST['include_email'] == '1') array_push($csv_array, $user['Email']);
    fputcsv($fp, $csv_array);
}
fclose($fp);
include "../include/dbconnclose.php";
?>
</table>
<a href="<?php echo $infile; ?>">Download Results</a>
<div id="show_error"></div>

