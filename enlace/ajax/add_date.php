<?php
if ($_POST['action']=='delete'){
    /* delete a session date: */
    $delete_attendance="DELETE FROM Absences WHERE Program_Date='" .$_POST['id']. "'";
    echo $delete_attendance . "<Br>";
    $delete_date="DELETE FROM Program_Dates WHERE Program_Date_ID='" .$_POST['id']. "'";
    echo $delete_date;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_attendance);
    mysqli_query($cnnEnlace, $delete_date);
    include "../include/dbconnclose.php";
}
else{
/*add new program date.*/
$new_date="INSERT INTO Program_Dates (Program_ID, Date_Listed) VALUES 
    ('".$_POST['program']."', '".$_POST['date']."')";
echo $new_date;

include "../include/dbconnopen.php";
mysqli_query($cnnEnlace, $new_date);
include "../include/dbconnclose.php";
}
?>
