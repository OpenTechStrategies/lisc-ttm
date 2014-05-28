<?php
/*
 * Save new walkability assessment.
 */
include "../include/dbconnopen.php";
$walk_query = "INSERT INTO Walkability_Assessment
    (Date_Evaluated,
     Cars_Stop,
     Speed_Limit_Obeyed,
     No_Gaps_In_Sidewalk,
     Intersection_Assessed,
     Crosswalk_Painted)
     VALUES
     ('" . $_POST['date'] ."',
      '" . $_POST['stop_signs'] . "',
      '" . $_POST['speed'] . "',
      '" . $_POST['sidewalk'] ."',
      '" . $_POST['intersection'] . "',
      '" . $_POST['crosswalks'] ."')";
echo $walk_query;
mysqli_query($cnnBickerdike, $walk_query);
include "../include/dbconnclose.php";
?>
