<?
/*add academic info.  not just for parent mentor children, but for anyone with the child/youth role. */
	$add_records = "INSERT INTO PM_Children_Info (
					Child_ID,
					Quarter,
					Reading_Grade,
					Math_Grade,
					Num_Suspensions,
					Num_Office_Referrals,
					Days_Absent,
					School_Year) VALUES (
					'" . $_POST['participant'] . "',
					'" . $_POST['quarter'] . "',
					'" . $_POST['reading'] . "',
					'" . $_POST['math'] . "',
					'" . $_POST['suspensions'] . "',
					'" . $_POST['referrals'] . "',
					'" . $_POST['days_absent'] . "',
					'" . $_POST['school_year'] . "'
					)";
	
	include "../include/dbconnopen.php";
	mysqli_query($cnnLSNA, $add_records);
	include "../include/dbconnclose.php";

?>