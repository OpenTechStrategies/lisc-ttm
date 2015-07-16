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

user_enforce_has_access($LSNA_id, $DataEntryAccess);

if ($_POST['action'] == 'save_note') {
    /* add notes to the program/campaign date: */
    include "../include/dbconnopen.php";
    $note_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['note']);
    $event_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['event']);
    $update_query = "UPDATE Subcategory_Dates SET Meeting_Note='" . $_POST['note'] . "' WHERE Wright_College_Program_Date_ID='" . $_POST['event'] . "'";
    mysqli_query($cnnLSNA, $update_query);
    include "../include/dbconnclose.php";
} else {
    /* save a new date (program session or campaign event) */
    include "../include/dbconnopen.php";
    $program_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['program_id']);
    $name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['name']);
    $type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['type']);
    $funder_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['funder']);
    $note_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['note']);
    $date_reformat = explode('-', $_POST['date']);
    $save_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
    if ($funder_sqlsafe == ""){
        $funder_sqlsafe = "null";
    }
    $add_date_to_program = "INSERT INTO Subcategory_Dates (
                            Subcategory_ID,
                            Date,
                            Activity_Name,
                            Activity_Type, 
                            Meeting_Note, Funder_ID) VALUES (
                            '" . $program_id_sqlsafe . "',
                            '" . $save_date . "',
                            '" . $name_sqlsafe . "',
                            '" . $type_sqlsafe . "',
                            '" . $note_sqlsafe . "',
                            " . $funder_sqlsafe . "
                            )";
    mysqli_query($cnnLSNA, $add_date_to_program);
    include "../include/dbconnclose.php";
}

if ($_POST['quick_add'] == 1) {
    /* link to add an event from the homepage. */
    ?>
    <span style="color:#990000; font-weight:bold;">Thank you for adding this event to the database. <br/>
        Go to the <a href="javascript:;" onclick="
                    $.post(
                            'ajax/set_program_id.php',
                            {
                                id:'<?echo $_POST['program_id'];?>'
                            },
                            function(response) {
                                if (response != '1') {
                                    document.getElementById('show_error').innerHTML = response;
                                }
                                window.location = 'programs/program_profile.php?schedule=1';
                            }
                    );
                     ">campaign schedule</a> to add attendance or additional information.</span>
    <?php
}
?>
