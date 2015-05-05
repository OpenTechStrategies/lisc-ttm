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

/* adds and deletes institutional connections from person profile (both participant and pool profile pages). */

if ($_POST['action'] == 'get_list') {
    /* obsolete. not sure what this was for. */
    ?><option value="">-----</option><?php
    include "../include/dbconnopen.php";
    $get_all_conns_sqlsafe = "SELECT * FROM Participants INNER JOIN Institutions_Participants
            ON Institutions_Participants.Participant_Id=Participants.Participant_ID
            WHERE Institution_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['inst']) . "';";

    $all_conns = mysqli_query($cnnSWOP, $get_all_conns_sqlsafe);
    while ($conn = mysqli_fetch_array($all_conns)) {
        ?><option value="<?php echo $conn['Participant_ID']; ?>"><?php echo $conn['Name_First'] . " " . $conn['Name_Last']; ?></option>
        <?php
    }
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'add_conn') {
    /* add a new institutional connection (if this person isn't already connected to this institution) */
    include "../include/dbconnopen.php";
    $check_already_connected_sqlsafe = "SELECT * FROM Institutions_Participants WHERE Institution_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['inst']) . "' AND Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "'";

    $add_connection_sqlsafe = "INSERT INTO Institutions_Participants (Institution_ID, Participant_Id, Is_Primary, Individual_Connection, Connection_Reason, Activity_Type)
        VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['inst']) . "',
            '" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "',
                '" . mysqli_real_escape_string($cnnSWOP, $_POST['prime']) . "',
                '" . mysqli_real_escape_string($cnnSWOP, $_POST['conn']) . "',
                '" . mysqli_real_escape_string($cnnSWOP, $_POST['reason']) . "',
				6)";

    echo $add_connection_sqlsafe;
    $check_conn = mysqli_query($cnnSWOP, $check_already_connected_sqlsafe);
    $conn_num = mysqli_num_rows($check_conn);
    if ($conn_num <= 0) {
        mysqli_query($cnnSWOP, $add_connection_sqlsafe);
        $id = mysqli_insert_id($cnnSWOP);
    } else {
        $id_conn = mysqli_fetch_row($check_conn);
        $id = $id_conn[0];
    }
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'delete_conn') {
    user_enforce_has_access($SWOP_id, $AdminAccess);
    /* delete institutional connection. */
    include "../include/dbconnopen.php";
    $delete_connection_sqlsafe = "DELETE FROM Institutions_Participants WHERE Institutions_Participants_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['link_id']) . "'";
    mysqli_query($cnnSWOP, $delete_connection_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
<!--            <option>this worked</option>-->
