<?
/* the event status refers to whether or not the event shows up on the Community Engagement homepage.  This toggles the
 * active/inactive status. */
if ($_POST['action']=='add'){
    include "../include/dbconnopen.php";
    $activate_sqlsafe = "UPDATE Events SET Active='1' WHERE Event_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['event_id']) . "'";
    mysqli_query($cnnTRP, $activate_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif ($_POST['action']=='remove'){
    include "../include/dbconnopen.php";
    $deactivate_sqlsafe = "UPDATE Events SET Active='0' WHERE Event_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['event_id']) . "'";
    mysqli_query($cnnTRP, $deactivate_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
