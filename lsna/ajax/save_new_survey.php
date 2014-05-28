<?php
/*format date*/
$date_reformat=explode('-', $_POST['date']);
        $save_date=$date_reformat[2] . '-'. $date_reformat[0] . '-'. $date_reformat[1];
        
/* add a new survey: */
if ($_POST['new_survey']==1){
    /* check that this isn't a duplicate survey. */
    
    
$save_survey_answers = "INSERT INTO Parent_Mentor_Survey (
    Pre_Post,
	Participant_ID,
    Date,
    School,
    Grade,
    Room_Number,
    First_Year_PM,
    Number_Children,
    Marital_Status,
    Place_Birth,
    Years_In_IL,
    Classes_Taking,
    Currently_Working,
    Current_Job,
    Monthly_Income,
    On_Food_Stamps,
    Rent_Own,
    Rent_Payment,
    Student_Involvement_A,
    Student_Involvement_B,
    Student_Involvement_C,
    Student_Involvement_D,
    Student_Involvement_E,
    Student_Involvement_F,
    Student_Involvement_G,
    Student_Involvement_H,
    School_Network_I,
    School_Network_J,
    School_Network_K,
    School_Network_L,
    School_Involvement_M,
    School_Involvement_N,
    School_Involvement_O,
    School_Involvement_P,
    School_Involvement_Q,
    School_Involvement_R,
	Self_Efficacy_Q,
	Self_Efficacy_R,
	Self_Efficacy_S,
	Self_Efficacy_T,
	Self_Efficacy_U,
	Self_Efficacy_V,
	Self_Efficacy_W,
	Self_Efficacy_X)
    VALUES (
    
    '" . $_POST['pre_post'] . "',
	'" . $_POST['participant'] . "',
                   '" . $save_date . "',
                   '" . $_POST['school'] . "',
                   '" . $_POST['grade'] . "',
                   '" . $_POST['room'] . "',
                   '" . $_POST['first_pm_year'] . "',
                   '" . $_POST['num_children'] . "',
                   '" . $_POST['marital_status'] . "',
                   '" . $_POST['place_birth'] . "',
                   '" . $_POST['years_in_il'] . "',
                   '" . $_POST['current_classes'] . "',
                   '" . $_POST['currently_working'] . "',
                   '" . $_POST['current_job'] . "',
                   '" . $_POST['monthly_income'] . "',
                   '" . $_POST['food_stamps'] . "',
                   '" . $_POST['rent_own'] . "',
                   '" . $_POST['rent_payment'] . "',
                       
                   '" . $_POST['A'] . "',
                   '" . $_POST['B'] . "',
                   '" . $_POST['C'] . "',
                   '" . $_POST['D'] . "',
                   '" . $_POST['E'] . "',
                   '" . $_POST['F'] . "',
                   '" . $_POST['G'] . "',
                   '" . $_POST['H'] . "',
                   '" . $_POST['I'] . "',
                   '" . $_POST['J'] . "',
                   '" . $_POST['K'] . "',
                   '" . $_POST['L'] . "',
                   '" . $_POST['M'] . "',
                   '" . $_POST['N'] . "',
                   '" . $_POST['O'] . "',
                   '" . $_POST['P'] . "',
                   '" . $_POST['Q'] . "',
                   '" . $_POST['R'] . "',
				   '" . $_POST['Q1'] . "',
				   '" . $_POST['R1'] . "',
				   '" . $_POST['S'] . "',
				   '" . $_POST['T'] . "',
				   '" . $_POST['U'] . "',
				   '" . $_POST['V'] . "',
				   '" . $_POST['W'] . "',
				   '" . $_POST['X'] . "')";
echo $save_survey_answers;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $save_survey_answers);
include "../include/dbconnclose.php";
}
/* edit survey responses: */
else {
	$edit_survey = "UPDATE Parent_Mentor_Survey SET 
	Pre_Post='" . $_POST['pre_post'] . "',
	Participant_ID='" . $_POST['participant'] . "',
    Date='" . $save_date . "',
    School='" . $_POST['school'] . "',
    Grade='" . $_POST['grade'] . "',
    Room_Number='" . $_POST['room'] . "',
    First_Year_PM='" . $_POST['first_pm_year'] . "',
    Number_Children='" . $_POST['num_children'] . "',
    Marital_Status='" . $_POST['marital_status'] . "',
    Place_Birth='" . $_POST['place_birth'] . "',
    Years_In_IL='" . $_POST['years_in_il'] . "',
    Classes_Taking='" . $_POST['current_classes'] . "',
    Currently_Working='" . $_POST['currently_working'] . "',
    Current_Job='" . $_POST['current_job'] . "',
    Monthly_Income='" . $_POST['monthly_income'] . "',
    On_Food_Stamps='" . $_POST['food_stamps'] . "',
    Rent_Own='" . $_POST['rent_own'] . "',
    Rent_Payment='" . $_POST['rent_payment'] . "',
    Student_Involvement_A='" . $_POST['A'] . "',
    Student_Involvement_B='" . $_POST['B'] . "',
    Student_Involvement_C='" . $_POST['C'] . "',
    Student_Involvement_D='" . $_POST['D'] . "',
    Student_Involvement_E='" . $_POST['E'] . "',
    Student_Involvement_F='" . $_POST['F'] . "',
    Student_Involvement_G='" . $_POST['G'] . "',
    Student_Involvement_H='" . $_POST['H'] . "',
    School_Network_I='" . $_POST['I'] . "',
    School_Network_J='" . $_POST['J'] . "',
    School_Network_K='" . $_POST['K'] . "',
    School_Network_L='" . $_POST['L'] . "',
    School_Involvement_M='" . $_POST['M'] . "',
    School_Involvement_N='" . $_POST['N'] . "',
    School_Involvement_O='" . $_POST['O'] . "',
    School_Involvement_P='" . $_POST['P'] . "',
    School_Involvement_Q='" . $_POST['Q'] . "',
    School_Involvement_R='" . $_POST['R'] . "',
	Self_Efficacy_Q='" . $_POST['Q1'] . "',
    Self_Efficacy_R='" . $_POST['R1'] . "',
	Self_Efficacy_S='" . $_POST['S'] . "',
    Self_Efficacy_T='" . $_POST['T'] . "',
	Self_Efficacy_U='" . $_POST['U'] . "',
    Self_Efficacy_V='" . $_POST['V'] . "',
	Self_Efficacy_W='" . $_POST['W'] . "',
    Self_Efficacy_X='" . $_POST['X'] . "'
	
	WHERE Parent_Mentor_Survey_ID='" . $_POST['survey_id'] . "'";
	
	include "../include/dbconnopen.php";
	echo $edit_survey;
	mysqli_query($cnnLSNA, $edit_survey);
	include "../include/dbconnclose.php";
}
?>
