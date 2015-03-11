<?
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/*add academic info.  not just for parent mentor children, but for anyone with the child/youth role. */
	include "../include/dbconnopen.php";
        $participant_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['participant']);
        $quarter_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['quarter']);
        $reading_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['reading']);
        $math_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['math']);
        $suspensions_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['suspensions']);
        $referrals_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['referrals']);
        $days_absent_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['days_absent']);
        $school_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['school_year']);
	$add_records = "INSERT INTO PM_Children_Info (
					Child_ID,
					Quarter,
					Reading_Grade,
					Math_Grade,
					Num_Suspensions,
					Num_Office_Referrals,
					Days_Absent,
					School_Year) VALUES (
					'" . $participant_sqlsafe . "',
					'" . $quarter_sqlsafe . "',
					'" . $reading_sqlsafe . "',
					'" . $math_sqlsafe . "',
					'" . $suspensions_sqlsafe . "',
					'" . $referrals_sqlsafe . "',
					'" . $days_absent_sqlsafe . "',
					'" . $school_year_sqlsafe . "'
					)";
	
	mysqli_query($cnnLSNA, $add_records);
	include "../include/dbconnclose.php";

?>