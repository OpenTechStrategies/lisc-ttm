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
user_enforce_has_access($SWOP_id, $DataEntryAccess);

/* first, calculate the block group of the new property: */

/* include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
  $this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['name'] . " " .$_POST['type'] .
  " " .$_POST['zipcode'];
  $block_group=do_it_all($this_address, $map);
 */
//echo 'got response';
/* set disposition if it's not set (joins to another table, so disposition should be set to something).   */
include "../include/dbconnopen.php";
if ($_POST['disposition'] == '' || !isset($_POST['disposition'])) {
    $disposition_sqlsafe = 4;
} else {
    $disposition_sqlsafe = mysqli_real_escape_string($cnnSWOP, $_POST['disposition']);
}
$create_new_property_query_sqlsafe = "INSERT INTO Properties (
                                Address_Street_Num,
                                Address_Street_Name,
                                Address_Street_Direction,
                                Address_Street_Type,
                                Zipcode,
                                Block_Group,
                                PIN,
                                Disposition,
                                Construction_Type,
                                Home_Size,
                                Property_Type) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['num']) . "',
                                        '" . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . "',
                                        '" . mysqli_real_escape_string($cnnSWOP, $_POST['dir']) . "',
                                        '" . mysqli_real_escape_string($cnnSWOP, $_POST['type']) . "',
                                            '" . mysqli_real_escape_string($cnnSWOP, $_POST['zipcode']) . "',
                                             '" . mysqli_real_escape_string($cnnSWOP, $block_group). "',
                                        '" . mysqli_real_escape_string($cnnSWOP, $_POST['pin']) . "',
                                            '" . $disposition_sqlsafe . "',
                                        '" . mysqli_real_escape_string($cnnSWOP, $_POST['construction_type']) . "',
                                        '" . mysqli_real_escape_string($cnnSWOP, $_POST['home_size']) . "',
                                        '" . mysqli_real_escape_string($cnnSWOP, $_POST['prop_type']) . "')";

//echo $create_new_property_query;
mysqli_query($cnnSWOP, $create_new_property_query_sqlsafe);
$id = mysqli_insert_id($cnnSWOP);
if ($_POST['vacant'] == 1) {
    $vacant_status_sqlsafe = 'Vacant';
} elseif ($_POST['vacant'] == 2) {
    $vacant_status_sqlsafe = 'Not vacant';
} else {
    $vacant_status_sqlsafe = '';
}
$add_vacant_sqlsafe = "INSERT INTO Property_Progress (Marker, Addtl_Info_1, Property_ID) VALUES (8, '$vacant_status_sqlsafe', $id)";
//echo $add_vacant;
if ($vacant_status_sqlsafe != '') {
    mysqli_query($cnnSWOP, $add_vacant_sqlsafe);
}
include "../include/dbconnclose.php";

if ($id != '') {
    /*  if property creation was successful: */
    if ($_POST['link_from_event'] == 1) {
        /* if this property was added when someone was linked to an event, then it is their address: */
        include "../include/dbconnopen.php";
        $link_prop_sqlsafe = "INSERT INTO Participants_Properties (Participant_ID, Property_ID, Primary_Residence)
		VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "', '" . $id . "', '1')";
        // echo $link_prop;
        mysqli_query($cnnSWOP, $link_prop_sqlsafe);
        include "../include/dbconnclose.php";
    }
    ?>
    <span style='color:#990000; font-weight:bold;'>Thank you for adding this property to the database.</span><br/>
    <a href='javascript:;' onclick="$.post(
                                            '../ajax/set_property_id.php',
                                            {
                                                page: 'profile',
                                                id: '<?echo $id;?>'
                                            },
                                    function(response) {
                                        window.location = '../properties/profile.php';
                                    })">View property profile</a>

    <?php
    if ($_POST['action'] == 'link_to_new') {
        /* links property to a newly created person: */
        include "../include/dbconnopen.php";
        $link_prop_sqlsafe = "INSERT INTO Participants_Properties (Participant_ID, Property_ID)
                    VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "', '" . $id . "')";
        //echo $link_prop;
        mysqli_query($cnnSWOP, $link_prop_sqlsafe);
        include "../include/dbconnclose.php";
        ?>
        <br>Or, <a href="javascript:;" onclick="
                    $.post(
                            '../ajax/set_participant_id.php',
                            {
                                page: 'profile',
                                participant_id:'<?echo $_POST['person'];?>'
                            },
                            function(response) {
                                   var url = response;
                                   window.location = url;
                            }
                    );
                   ">view participant profile</a>.
        <?php
    }
} else {
    echo '<span style="color:#990000; font-weight:bold; font-size:.9em;">An error occurred.  Please try again.  Note that you must choose a value for "Disposition" (it may be "N/A").</span>';
}
?>
