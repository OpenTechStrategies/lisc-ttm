<?php
/* Add or remove a development goal.  These are notes to track participant
 *  progress.
 */

if ($_POST['action']=='new'){
    $date_reformat=explode('-', $_POST['date']);
$save_date=$date_reformat[2] . '-'. $date_reformat[0] . '-'. $date_reformat[1];
    $add_dev="INSERT INTO Goals_Development (Participant_ID, Development_Date, Notes) VALUES ('".$_POST['person']."',
        '".$save_date."',
            '".$_POST['notes']."')";
    //echo $add_dev;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_dev);
    include "../include/dbconnclose.php";
    echo 'Thank you for adding this meeting.';
}
elseif($_POST['action']=='delete'){
    $delete_goal="DELETE FROM Goals_Development WHERE Goals_Development_ID='" . $_POST['id'] . "'";
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $delete_goal);
    include "../include/dbconnclose.php";
}
?>
