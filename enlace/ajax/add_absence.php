<?php
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
    $false_absence="DELETE FROM Absences WHERE Participant_ID='".$user_id_sqlsafe."' AND Program_Date='".$date_sqlsafe."'";
    echo $false_absence;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $false_absence);
    include "../include/dbconnclose.php";
}
?>
