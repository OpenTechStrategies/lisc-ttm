<?php
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
    /* delete institutional connection. */
    include "../include/dbconnopen.php";
    $delete_connection_sqlsafe = "DELETE FROM Institutions_Participants WHERE Institutions_Participants_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['link_id']) . "'";
    mysqli_query($cnnSWOP, $delete_connection_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
<!--            <option>this worked</option>-->
