<?php
//should check to make sure that they aren't already linked to the program
include "../include/dbconnopen.php";
$participant_sqlsafe=mysqli_real_escape_string($cnnLNSA, $_POST['participant']);
$subcategory_sqlsafe=mysqli_real_escape_string($cnnLNSA, $_POST['subcategory']);
$school_sqlsafe=mysqli_real_escape_string($cnnLNSA, $_POST['school']);
$year_sqlsafe=mysqli_real_escape_string($cnnLNSA, $_POST['year']);
$find_existing="SELECT * FROM Participants_Subcategories WHERE Participant_ID='" . $participant_sqlsafe . "' AND
    Subcategory_ID= '" . $subcategory_sqlsafe . "'";
$existing=mysqli_query($cnnLSNA, $find_existing);
$exists=mysqli_num_rows($existing);
include "../include/dbconnclose.php";

//if the link doesn't already exist
if ($exists<1){
$add_to_program = "INSERT INTO Participants_Subcategories (Participant_ID,
    Subcategory_ID) VALUES (
    '" . $participant_sqlsafe . "',
    '" . $subcategory_sqlsafe . "')";
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $add_to_program);
include "../include/dbconnclose.php";
}

if ($_POST['subcategory']==19) {
    
	include "../include/dbconnopen.php";
    //I think if the participant is already linked to 19 [parent mentor program] (i.e. if $exists>=1), then we don't need to add them to the workshops
    if ($exists<1){
	$add_to_pm_workshops = "INSERT INTO Participants_Subcategories (Participant_ID,
            Subcategory_ID) VALUES (
            '" . $participant_sqlsafe . "',
            '53')";
	mysqli_query($cnnLSNA, $add_to_pm_workshops);
    }
        //this is probably already set if they are already a PM, but no harm done in redoing:
        $make_pm = "UPDATE Participants SET Is_PM=1 WHERE Participant_ID='" . $participant_sqlsafe . "'";
	mysqli_query($cnnLSNA, $make_pm);
        
	//add PM school and year affiliation.  This is why we need to separate this out from the program link.  They can be linked
        //to multiple schools and years and still only count as one parent mentor
        //but check if they're already linked to this school, k?
        $check_pm_school="SELECT * FROM Institutions_Participants WHERE Participant_Id='" . $participant_sqlsafe . "'
            AND Institution_ID='" . $school_sqlsafe . "'";
        $school_existing=mysqli_query($cnnLSNA, $check_pm_school);
        $school_exists=mysqli_num_rows($school_existing);
        //if they aren't already linked to this school:
        if ($school_exists<1){
	$add_pm_school ="INSERT INTO Institutions_Participants (Participant_ID, Institution_ID, Is_PM) 
            VALUES ('" . $participant_sqlsafe . "', '" . $school_sqlsafe . "', '1')";
	mysqli_query($cnnLSNA, $add_pm_school);
        }
        $add_pm_year="INSERT INTO PM_Years (Participant, School, Year) VALUES ('" . $participant_sqlsafe . "', '" . $school_sqlsafe . "', '".$year_sqlsafe."')";
        mysqli_query($cnnLSNA, $add_pm_year);
	include "../include/dbconnclose.php";
}

if ($_POST['subcategory']==53) {
	//add school affiliation PM Friday workshops.
        //can go to friday workshops without being a parent mentor, so no requirement to add them to #19
	$add_pm_school ="INSERT INTO Institutions_Participants (Participant_ID, Institution_ID, Is_PM) VALUES ('" . $participant_sqlsafe . "', '" . $school_sqlsafe . "', '1')";
	include "../include/dbconnopen.php";
	mysqli_query($cnnLSNA, $add_pm_school);
	include "../include/dbconnclose.php";
}


?>
