<?
/* the event status refers to whether or not the event shows up on the Community Engagement homepage.  This toggles the
 * active/inactive status. */
if ($_POST['action']=='add'){
    $activate = "UPDATE Events SET Active='1' WHERE Event_ID='" . $_POST['event_id'] . "'";
    echo $activate;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $activate);
    include "../include/dbconnclose.php";
}
elseif ($_POST['action']=='remove'){
    $deactivate = "UPDATE Events SET Active='0' WHERE Event_ID='" . $_POST['event_id'] . "'";
    echo $deactivate;
    include "../include/dbconnopen.php";
    mysqli_query($cnnTRP, $deactivate);
    include "../include/dbconnclose.php";
}
?>
