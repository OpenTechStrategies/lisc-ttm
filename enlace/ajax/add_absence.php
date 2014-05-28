<?php
/*basic adding and removing of absences*/

if ($_POST['action']=='add'){
    $new_absence="INSERT INTO Absences (Participant_ID, Program_Date) VALUES ('".$_POST['user_id']."', '".$_POST['date']."')";
    echo $new_absence;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $new_absence);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='remove'){
    $false_absence="DELETE FROM Absences WHERE Participant_ID='".$_POST['user_id']."' AND Program_Date='".$_POST['date']."'";
    echo $false_absence;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $false_absence);
    include "../include/dbconnclose.php";
}
?>
