<?php
/* save outcomes data from the Community Engagement page. */
$new_outcomes_data = "INSERT INTO Outcomes_Months (
				Outcome_ID,
				Month,
				Year,
				Goal_Outcome,
				Actual_Outcome
				) VALUES (
				'" . $_POST['outcome_id'] . "',
				'" . $_POST['outcome_month'] . "',
				'" . $_POST['outcome_year'] . "',
				'" . $_POST['outcome_goal'] . "',
				'" . $_POST['outcome_actual'] . "')";
echo $new_outcomes_data;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $new_outcomes_data);
include "../include/dbconnclose.php";

?>