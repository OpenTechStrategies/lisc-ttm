<?php
/*add or remove mentorship hours from a participant*/

if ($_POST['action']=='delete'){
    $delete_mentorship="DELETE FROM Participants_Mentorship WHERE Mentorship_Time_Id='".$_POST['id']."'";
        echo $delete_mentorship;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $delete_mentorship);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='edit'){
    $update_mentorship = "UPDATE Participants_Mentorship SET Mentorship_Date='".$_POST['date']."', Mentorship_Hours_Logged='".$_POST['hours']."',"
            . "Mentorship_Program='".$_POST['session']."' WHERE Mentorship_Time_ID='".$_POST['id']."'";
    echo $update_mentorship;
     include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $update_mentorship);
    include "../include/dbconnclose.php";
}
else{
$new_mentorship_hours_query="INSERT INTO Participants_Mentorship (Mentee_ID, Mentorship_Date, Mentorship_Hours_Logged,
    Mentorship_Program) VALUES ('".$_POST['person']."',
        '".$_POST['date']."',
        '".$_POST['hours']."',
        '".$_POST['program']."')";
echo $new_mentorship_hours_query;
include "../include/dbconnopen.php";
mysqli_query($cnnEnlace, $new_mentorship_hours_query);
include "../include/dbconnclose.php";
}
?>
