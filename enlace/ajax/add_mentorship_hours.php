<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, $DataEntryAccess);

/*add or remove mentorship hours from a participant*/

if ($_POST['action']=='delete'){
    user_enforce_has_access($Enlace_id, 1);
    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
    $delete_mentorship="DELETE FROM Participants_Mentorship WHERE Mentorship_Time_Id='".$id_sqlsafe."'";
        echo $delete_mentorship;
    mysqli_query($cnnEnlace, $delete_mentorship);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='edit'){
    include "../include/dbconnopen.php";
    $date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['date']);
    $hours_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['hours']);
    $session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['session']);
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
    $update_mentorship = "UPDATE Participants_Mentorship SET Mentorship_Date='".$date_sqlsafe."', Mentorship_Hours_Logged='".$hours_sqlsafe."',"
            . "Mentorship_Program='".$session_sqlsafe."' WHERE Mentorship_Time_ID='".$id_sqlsafe."'";
    echo $update_mentorship;
    mysqli_query($cnnEnlace, $update_mentorship);
    include "../include/dbconnclose.php";
}
else{
include "../include/dbconnopen.php";
$date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['date']);
$hours_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['hours']);
$person_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['person']);
$program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program']);
$new_mentorship_hours_query="INSERT INTO Participants_Mentorship (Mentee_ID, Mentorship_Date, Mentorship_Hours_Logged,
    Mentorship_Program) VALUES ('".$person_sqlsafe."',
        '".$date_sqlsafe."',
        '".$hours_sqlsafe."',
        '".$program_sqlsafe."')";
echo $new_mentorship_hours_query;
mysqli_query($cnnEnlace, $new_mentorship_hours_query);
include "../include/dbconnclose.php";
}
?>
