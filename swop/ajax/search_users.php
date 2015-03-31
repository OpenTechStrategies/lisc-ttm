<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id);

/* search query for users. related to the participants homepage, not the user query search.
 * 
 * Same idea.  Those search elements that are filled in are included in the query.  some of them
 * require joins. */
include "../include/dbconnopen.php";
if ($_POST['first'] == '') {
    $first_sqlsafe = '';
} else {
    $first_sqlsafe = ' AND Name_First LIKE "%' . mysqli_real_escape_string($cnnSWOP, $_POST['first']) . '%"';
}
if ($_POST['last'] == '') {
    $last_sqlsafe = '';
} else {
    $last_sqlsafe = " AND Name_Last LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['last']) . "%'";
}
if ($_POST['dob'] == '') {
    $dob_sqlsafe = '';
} else {
    $dob_sqlsafe = " AND DOB='" . mysqli_real_escape_string($cnnSWOP, $_POST['dob']) . "'";
}
if ($_POST['gender'] == '') {
    $gender_sqlsafe = '';
} else {
    $gender_sqlsafe = " AND Gender='" . mysqli_real_escape_string($cnnSWOP, $_POST['gender']) . "'";
}
if ($_POST['inst'] == '') {
    $inst_sqlsafe = '';
    $inst_join_sqlsafe = '';
} else {
    $inst_sqlsafe = " AND Institutions_Participants.Institution_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['inst']) . "' AND Is_Primary=1 ";
    $inst_join_sqlsafe = " INNER JOIN Institutions_Participants ON Participants.Participant_ID=Institutions_Participants.Participant_ID 
    INNER JOIN Institutions ON Institutions_Participants.Institution_ID=Institutions.Institution_ID ";
}
if ($_POST['organizer'] != '') {
    $organizer_sqlsafe = " AND Participants.Primary_Organizer='" . mysqli_real_escape_string($cnnSWOP, $_POST['organizer']). "' ";
} else {
    $organizer_sqlsafe = "";
}
if ($_POST['active_pool'] == '') {
    $pool_sqlsafe = "";
    $pool_join_sqlsafe = "";
} elseif ($_POST['active_pool'] == 1) {
    $pool_sqlsafe = " AND Pool_Status_Changes.Active=1 ";
    $pool_join_sqlsafe = " INNER JOIN Pool_Status_Changes ON Participants.Participant_ID=Pool_Status_Changes.Participant_ID 
    INNER JOIN (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON Pool_Status_Changes.Date_Changed=laststatus.lastdate ";
} elseif ($_POST['active_pool'] == 2) {
    $pool_sqlsafe = " AND Pool_Status_Changes.Active=0 ";
    $pool_join_sqlsafe = " INNER JOIN Pool_Status_Changes ON Participants.Participant_ID=Pool_Status_Changes.Participant_ID 
    INNER JOIN (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON Pool_Status_Changes.Date_Changed=laststatus.lastdate ";
}

$uncertain_search_query_sqlsafe = "SELECT * FROM Participants " . $inst_join_sqlsafe . $pool_join_sqlsafe . " WHERE Participants.Participant_ID!='' " . $first_sqlsafe . $last_sqlsafe . $dob_sqlsafe . $gender .
        $inst_sqlsafe . $organizer_sqlsafe . $pool_sqlsafe . " ORDER BY Name_Last";
//echo $uncertain_search_query;

$results = mysqli_query($cnnSWOP, $uncertain_search_query_sqlsafe);

if ($_POST['dropdown'] == 1) {
    /* show results in a dropdown. */
    $search_flag = 1;
    ?>
    <select id="choose_participant<?php
    if ($_POST['multiple'] == 1) {
        echo "_" . $_POST['id'];
    }
    ?>">
        <option value="">-----</option>
            <?php while ($user = mysqli_fetch_array($results)) {
                ?><option value="<?php echo $user['Participant_ID']; ?>"><?php
            echo $user['Participant_ID'] . ": " . $user['Name_First'] . " " . $user['Name_Last']
            . " (" . $user['Institution_Name'] . ")";
            ?></option><?php
    }
    ?>
    </select>
    <?php
} else {
    ?>
    <!-- results table: -->
    <br/><h4>Search Results</h4>
    <table class="program_table" width="70%">
        <tr>
            <th>Name</th>
            <th>DOB</th>
            <th>Gender</th>
        </tr>
    <?php
    while ($user = mysqli_fetch_array($results)) {
        ?>
            <tr>

                <td class="all_projects" style="text-align:left;"><a href="javascript:;" onclick="
                                $.post(
                                        '../ajax/set_participant_id.php',
                                        {
                                            page: 'profile',
                                            participant_id: '<?php echo $user['Participant_ID']; ?>'
                                        },
                                function(response) {
                                    //                                if (response!='1'){
                                    //                                    document.getElementById('show_error').innerHTML = response;
                                    //                                }
                                    window.location = response;
                                });"><?php echo $user['Name_First'] . " " . $user['Name_Last']; ?></a></td>      

                <td class="all_projects"><?php
                    if ($user['Date_of_Birth'] != '0000-00-00') {
                        $date_pieces = explode('-', $user['Date_of_Birth']);
                        $display_date = $date_pieces[1] . '/' . $date_pieces[2] . '/' . $date_pieces[0];
                        echo $display_date;
                        //echo $user['Date_of_Birth'];
                    }
                    ?></td>
                <td class="all_projects"><?php
                    if ($user['Gender'] == 'm') {
                        echo "Male";
                    } else if ($user['Gender'] == 'f') {
                        echo "Female";
                    }
                    ?></td>
                <td class="all_projects" <?php
                        if (isset($_COOKIE['view_restricted'])) {
                            echo "style='display:none;'";
                        }
                        ?>><a href="javascript:;" onclick="
                        if (confirm('Are you sure you want to delete this participant?')) {
                            $.post(
                                    '../ajax/delete_elements.php',
                                    {
                                        action: 'user',
                                        id: <?php echo $user['Participant_ID']; ?>
                                    },
                            function(response) {
                                alert('This participant has been deleted. Click Search again for accurate results.');
                                //document.write(response);
                                //I want this to return us to the search results page, with the same results (minus deletion), but that seems difficult.
                            })
                        }">Delete</a></td>
            </tr>
        <?php
    }
    ?>
    </table>
    <?php
}
include "../include/dbconnclose.php";
?>

