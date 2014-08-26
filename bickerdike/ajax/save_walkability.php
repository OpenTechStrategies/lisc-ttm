<?php
/*
 * Save new walkability assessment.
 */
include "../include/dbconnopen.php";
$date_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$stop_signs_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['stop_signs']);
$speed_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['speed']);
$sidewalk_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['sidewalk']);
$intersection_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['intersection']);
$crosswalks_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['crosswalks']);

$walk_query = "INSERT INTO Walkability_Assessment
    (Date_Evaluated,
     Cars_Stop,
     Speed_Limit_Obeyed,
     No_Gaps_In_Sidewalk,
     Intersection_Assessed,
     Crosswalk_Painted)
     VALUES
     ('" . $date_sqlsafe ."',
      '" . $stop_signs_sqlsafe . "',
      '" . $speed_sqlsafe . "',
      '" . $sidewalk_sqlsafe ."',
      '" . $intersection_sqlsafe . "',
      '" . $crosswalks_sqlsafe ."')";
echo $walk_query;
mysqli_query($cnnBickerdike, $walk_query);
include "../include/dbconnclose.php";
?>
