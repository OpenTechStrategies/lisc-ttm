<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($Enlace_id, 2);

if ($_POST['action']=='delete'){
    user_enforce_has_access($Enlace_id, 1);
    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
    /* delete a session date: */
    $delete_attendance="DELETE FROM Absences WHERE Program_Date='" .$id_sqlsafe. "'";
    echo $delete_attendance . "<Br>";
    $delete_date="DELETE FROM Program_Dates WHERE Program_Date_ID='" .$id_sqlsafe. "'";
    echo $delete_date;
    mysqli_query($cnnEnlace, $delete_attendance);
    mysqli_query($cnnEnlace, $delete_date);
    include "../include/dbconnclose.php";
}
else{
/*add new program date.*/
include "../include/dbconnopen.php";
$program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program']);
$date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['date']);
$new_date="INSERT INTO Program_Dates (Program_ID, Date_Listed) VALUES 
    ('".$program_sqlsafe."', '".$date_sqlsafe."')";
echo $new_date;

mysqli_query($cnnEnlace, $new_date);
include "../include/dbconnclose.php";
}
?>
