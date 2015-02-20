<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($Enlace_id, $DataEntryAccess);

/*basic adding and removing of absences*/
    include "../include/dbconnopen.php";
    $user_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['user_id']);
    $date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['date']);

if ($_POST['action']=='add'){
    $new_absence="INSERT INTO Absences (Participant_ID, Program_Date) VALUES ('".$user_id_sqlsafe."', '".$date_sqlsafe."')";
    echo $new_absence;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $new_absence);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='remove'){
    user_enforce_has_access($Enlace_id, 1);
    $false_absence="DELETE FROM Absences WHERE Participant_ID='".$user_id_sqlsafe."' AND Program_Date='".$date_sqlsafe."'";
    echo $false_absence;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $false_absence);
    include "../include/dbconnclose.php";
}
?>
