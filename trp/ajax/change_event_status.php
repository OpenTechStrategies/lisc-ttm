<?
/* the event status refers to whether or not the event shows up on the Community Engagement homepage.  This toggles the
 * active/inactive status. */
if ($_POST['action']=='add'){
    $activate_sqlsafe = "UPDATE Events SET Active='1' WHERE Event_ID='" . mysqli_real_escape_string($_POST['event_id']) . "'";
    echo $activate_sqlsafe;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $activate_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif ($_POST['action']=='remove'){
    $deactivate_sqlsafe = "UPDATE Events SET Active='0' WHERE Event_ID='" . mysqli_real_escape_string($_POST['event_id']) . "'";
    echo $deactivate_sqlsafe;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $deactivate_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
