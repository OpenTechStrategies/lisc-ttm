<?php
//I'm going to follow the same partial search mechanism that I've used before.  If a search term
//is chosen, then I'll use it for searching.  One thing I may have to change is allowing them to search for the
//null - that is, find people who /don't have/ a primary institution or something like that.

if ($_POST['inst'] != 0) {
    $institution_sqlsafe = " AND Institution_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['inst']) . "' AND Is_Primary=1 ";
    $join_inst_sqlsafe = " INNER JOIN Institutions_Participants ON Participants.Participant_ID=Institutions_Participants.Participant_ID ";
} else {
    $institution_sqlsafe = "";
    $join_inst_sqlsafe = "";
}

    $join_inst_sqlsafe = " INNER JOIN Institutions_Participants ON Participants.Participant_ID=Institutions_Participants.Participant_ID ";



if ($_POST['type'] != 0) {
    $type_sqlsafe = " AND member_type.Member_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['type']) . "' ";
    $member_type_join_sqlsafe = " INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) lasttypestatus
        ON member_type.Date_Changed=lasttypestatus.lastdate ";
} else {
    $type_sqlsafe = "";
    $member_type_join_sqlsafe = "";
}
//note that this is a little trickier because we have to get the most recent benchmark completed.  that's where the extra join comes in.
if ($_POST['step'] != 0) {
    $step_sqlsafe = " AND Pool_Progress.Benchmark_Completed='" . mysqli_real_escape_string($cnnSWOP, $_POST['step']) . "' AND Pool_Progress.Participant_ID 
    = progress.Participant_ID ";
    $benchmarks_sqlsafe = " INNER JOIN Pool_Progress ON Participants.Participant_ID=Pool_Progress.Participant_ID 
        INNER JOIN (
        SELECT Participant_ID, Benchmark_Completed, MAX(Date_Completed) as LDATE
        FROM Pool_Progress
        GROUP BY Participant_ID) progress
ON Pool_Progress.Date_Completed = progress.LDATE ";
} else {
    $step_sqlsafe = "";
    $benchmarks_sqlsafe = "";
}



    $benchmarks_sqlsafe = " INNER JOIN Pool_Progress ON Participants.Participant_ID=Pool_Progress.Participant_ID 
        INNER JOIN (
        SELECT Participant_ID, Benchmark_Completed, MAX(Date_Completed) as LDATE
        FROM Pool_Progress
        GROUP BY Participant_ID) progress
ON Pool_Progress.Date_Completed = progress.LDATE ";

    
//benchmark that has been completed
if ($_POST['step_done'] != 0) {
    $step_done_sqlsafe = " AND Participants.Participant_ID IN (SELECT Participant_ID FROM Pool_Progress WHERE Benchmark_Completed = '" . mysqli_real_escape_string($cnnSWOP, $_POST['step_done']). "') ";
} else {
    $step_done_sqlsafe = "";
}

if ($_POST['start'] != '') {
    $start_sqlsafe = " AND member_type.Date_Changed>='" . mysqli_real_escape_string($cnnSWOP, $_POST['start']) . "' AND member_type.Active=1 ";
    $date_join_sqlsafe = " INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON member_type.Date_Changed=laststatus.lastdate ";
} else {
    $start_sqlsafe = "";
}
if ($_POST['end'] != '') {
    $end_sqlsafe = " AND member_type.Date_Changed<='" . mysqli_real_escape_string($cnnSWOP, $_POST['end']) . "' AND member_type.Active=1 ";
    $date_join_sqlsafe = " INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON member_type.Date_Changed=laststatus.lastdate ";
} else {
    $end_sqlsafe = "";
}

if ($_POST['type'] != 0 || $_POST['start'] != '' || $_POST['end'] != '') {
    $status_sqlsafe = " INNER JOIN Pool_Status_Changes as member_type
        ON Participants.Participant_ID=member_type.Participant_ID ";
} else {
    $status_sqlsafe = "";
}
if ($_POST['laggers'] != '') {//first get the date based on the number of days ago
    date_default_timezone_set('America/Chicago');
    $last_date = mktime(0, 0, 0, date("m"), date("d") - ($_POST['laggers']), date("Y"));
    $last_date_sqlsafe = mysqli_real_escape_string($cnnSWOP, date("Y-m-d", $last_date));
    $lag_sqlsafe = " AND Pool_Progress.Date_Completed<='" . $last_date_sqlsafe . "' AND Pool_Progress.Participant_ID 
    = progress.Participant_ID AND still_active.Active=1 ";
    $benchmarks_sqlsafe = " INNER JOIN Pool_Progress ON Participants.Participant_ID=Pool_Progress.Participant_ID 
        INNER JOIN (
        SELECT Participant_ID, Benchmark_Completed, MAX(Date_Completed) as LDATE
        FROM Pool_Progress
        GROUP BY Participant_ID) progress
    ON Pool_Progress.Date_Completed = progress.LDATE ";
    $date_join_sqlsafe = "INNER JOIN Pool_Status_Changes as still_active ON Participants.Participant_ID=still_active.Participant_ID
 INNER JOIN (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON still_active.Date_Changed=laststatus.lastdate ";
} else {
    $lag_sqlsafe = " ";
}

if ($_POST['organizer'] != '0') {
    $organizer_sqlsafe = " AND Participants.Primary_Organizer='" . mysqli_real_escape_string($cnnSWOP, $_POST['organizer']) . "' ";
    $organizer_join_sqlsafe = " INNER JOIN Participants AS Organizer_Info ON Participants.Primary_Organizer = Organizer_Info.Participant_ID ";
} else {
    $organizer_sqlsafe = "";
    $organizer_join_sqlsafe = "";
}
    $organizer_join_sqlsafe = " INNER JOIN Participants AS Organizer_Info ON Participants.Primary_Organizer = Organizer_Info.Participant_ID ";

if ($_POST['first_name'] != '') {
    $first_name_sqlsafe = " AND Participants.Name_First LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['first_name']). "%' ";
} else {
    $first_name_sqlsafe = "";
}

/*
if ($_POST['middle_name'] != '') {
    $middle_name = " AND Participants.Name_Middle LIKE '%" . $_POST['middle_name'] . "%' ";
} else {
    $middle_name = "";
}
*/

if ($_POST['last_name'] != '') {
    $last_name_sqlsafe = " AND Participants.Name_Last LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['last_name']) . "%' ";
} else {
    $last_name_sqlsafe = "";
}

if ($_POST['email'] != '') {
    $email_sqlsafe = " AND Participants.Email LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['email']) . "%' ";
} else {
    $email_sqlsafe = "";
}

if ($_POST['phone'] != '') {
    $phone_sqlsafe = " AND (Participants.Phone_Day LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['phone']) . "%' 
                OR Participants.Phone_Evening LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['phone']) . "%') ";
} else {
    $phone_sqlsafe = "";
}

if ($_POST['notes'] != '') {
    $notes_sqlsafe = " AND Participants.Notes LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['notes']) . "%' ";
} else {
    $notes_sqlsafe = "";
}

if ($_POST['date_of_birth'] != '') {
    $date_of_birth_sqlsafe = " AND Participants.Date_of_Birth = '" . mysqli_real_escape_string($cnnSWOP, $_POST['date_of_birth']) . "' ";
} else {
    $date_of_birth_sqlsafe = "";
}

if ($_POST['gender'] != '0') {
    $gender_sqlsafe = " AND Participants.Gender = '" . mysqli_real_escape_string($cnnSWOP, $_POST['gender']) . "' ";
} else {
    $gender_sqlsafe = "";
}

if ($_POST['has_itin'] != '') {
    $has_itin_sqlsafe = " AND Participants.ITIN = " . mysqli_real_escape_string($cnnSWOP, $_POST['has_itin']) . " ";
} else {
    $has_itin_sqlsafe = "";
}

if ($_POST['language_spoken'] == 'English') {
    $language_spoken_sqlsafe = " AND Participants.Lang_Eng = 1 ";
} else if ($_POST['language_spoken'] == 'Spanish') {
    $language_spoken_sqlsafe = " AND Participants.Lang_Span = 1 ";
} else if ($_POST['language_spoken'] == 'Other') {
    $language_spoken_sqlsafe = " AND Participants.Lang_Other = 1 ";
} else {
    $language_spoken_sqlsafe = "";
}

if ($_POST['ward'] != '0') {
    $ward_sqlsafe = " AND Participants.Ward = '" . mysqli_real_escape_string($cnnSWOP, $_POST['ward']) . "' ";
} else {
    $ward_sqlsafe = "";
}
    
$search_pool_sqlsafe = "SELECT * FROM Participants " . $status_sqlsafe . $join_inst_sqlsafe . $benchmarks_sqlsafe
        . $date_join_sqlsafe . $organizer_join_sqlsafe . $member_type_join_sqlsafe
        . "LEFT JOIN Participants_Properties ON Participants.Participant_ID=Participants_Properties.Participant_ID
            WHERE Participants.Participant_ID IS NOT NULL "
        . $institution_sqlsafe . $type_sqlsafe . $step_sqlsafe . $step_done_sqlsafe . $start_sqlsafe . $end_sqlsafe . $lag_sqlsafe . $organizer_sqlsafe
        . $first_name_sqlsafe /* . $middle_name */ . $last_name_sqlsafe . $email_sqlsafe . $phone_sqlsafe . $notes_sqlsafe
        . $date_of_birth_sqlsafe . $gender_sqlsafe . $has_itin_sqlsafe . $ward_sqlsafe . $language_spoken_sqlsafe;

//echo $search_pool . "<p>";

include "../include/dbconnopen.php";
$search_results = mysqli_query($cnnSWOP, $search_pool_sqlsafe);
?>

<table class="all_projects">
    <caption>Choose the columns you would like to view and export for this query:</caption>
    <?php
    $num_columns = mysqli_field_count($cnnSWOP);
    //echo $num_columns;
    //this is brought over from PAWS.  I'm trying to give Sarah what she wants in terms of checkboxes to determine which search fields will be 
    //returned.
    $table = '';
    for ($k = 0; $k < $num_columns; $k++) {
        $get_column_names = mysqli_fetch_field_direct($search_results, $k);
        //skip Name_Middle field
        if ($get_column_names->name == "Name_Middle") {
            continue;
        }
        if ($get_column_names->table != 'progress' && $get_column_names->table != 'laststatus') {
            if ($get_column_names->table != $table) {
                $table = $get_column_names->table;
                ?><tr class="note"><th colspan="4"><a href="javascript:;" onclick="
                                    $('.<?php echo $table; ?>_row').toggle();
                                                    "><?php echo $table; ?></a></th></tr><?php
                    if (($k + 1) % 4 != 1) {
                        echo "<tr class='" . $table . "_row addfields'>";
                    }
                }
                if (($k + 1) % 4 == 1) {
                    echo "<tr class='" . $table . "_row addfields'>";
                }
                ?><td class="all_projects" style="text-align: left;"><input type="checkbox" value="<?php echo $get_column_names->table . "." . $get_column_names->name; ?>"
                                                                          class="table_<?php echo $get_column_names->table; ?>"
                                                                      name="column_name[]" id="column_name_<?php echo $get_column_names->table . "_" . $get_column_names->name; ?>" <?php
                                                                      echo
                                                                      (($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Project_PI') ||
                                                                      ($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Short_Title') ||
                                                                      ($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Project_Status') ||
                                                                      ($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Funding_Source') ||
                                                                      ($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Project_Number') ? 'checked=="checked"' : null);
                                                                      ?>>
                <label for="column_name_<?php echo $get_column_names->table . "_" . $get_column_names->name; ?>"><?php echo $get_column_names->name; ?></label></td>
            <?php
            if (($k + 1) % 4 == 0) {
                echo "</tr>";
            }
        }
    }
    ?>
</table>
<input type="button" value="View and Export these Results" onclick="
        var columns = document.getElementsByName('column_name[]');
        var col_array = new Array();
        var j = 0;
        for (var k = 0; k < columns.length; k++) {
            if (columns[k].checked == true) {
                col_array[j] = columns[k].value;
                j++;
            }
        }
        
        //alert($('#group_by:checked').serialize());
        /*
                alert($('.table_Pool_Progress:checked').serialize());
                    table_institutions_participants: $('.table_Institutions_Participants:checked').serialize(),
                    table_pool_progress: $('.table_Pool_Progress:checked').serialize(),
                    table_organizer_info: $('.table_Organizer_Info:checked').serialize(),
                    table_participants_properties: $('.table_Participants_Properties:checked').serialize()
                    */
        $.post(
                '../reports/indiv_results_table.php',
                {
                    first_name: '<?php echo $_POST['first_name']; ?>',
                    //middle_name: '<?php echo $_POST['middle_name']; ?>',
                    last_name: '<?php echo $_POST['last_name']; ?>',
                    email: '<?php echo $_POST['email']; ?>',
                    phone: '<?php echo $_POST['phone']; ?>',
                    notes: '<?php echo $_POST['notes']; ?>',
                    date_of_birth: '<?php echo $_POST['date_of_birth']; ?>',
                    gender: '<?php echo $_POST['gender']; ?>',
                    has_itin: '<?php echo $_POST['has_itin']; ?>',
                    language_spoken: '<?php echo $_POST['language_spoken']; ?>',
                    ward: '<?php echo $_POST['ward']; ?>',
                    organizer: '<?php echo $_POST['organizer']; ?>',
                    inst: '<?php echo $_POST['inst']; ?>',
                    type: '<?php echo $_POST['type']; ?>',
                    step: '<?php echo $_POST['step']; ?>',
                    step_done: '<?php echo $_POST['step_done']; ?>',
                    start: '<?php echo $_POST['start']; ?>',
                    end: '<?php echo $_POST['end']; ?>',
                    search_type: 'pool',
                    laggers: '<?php echo $_POST['laggers']; ?>',
                    columns: col_array,
                    table_institutions_participants: $('.table_Institutions_Participants:checked').serialize(),
                    table_pool_progress: $('.table_Pool_Progress:checked').serialize(),
                    table_organizer_info: $('.table_Organizer_Info:checked').serialize(),
                    group_by: $('#group_by:checked').serialize()
                },
        function(response) {
            document.getElementById('show_results_table').innerHTML = response;
        }
        )
       ">

<br />
<label for="group_by">Group Results By Participant</label> <input type="checkbox" value="Yes" name="group_by" id="group_by" />
<br />
<label for="group_by">(limits to one record / participant)</label>
<?php
include "../include/dbconnclose.php";
?>
<p></p>
<div id="show_results_table"></div>

