<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/*format date*/
$date_reformat=explode('-', $_POST['date']);
        $save_date=$date_reformat[2] . '-'. $date_reformat[0] . '-'. $date_reformat[1];
        
/* add a new survey: */
include "../include/dbconnopen.php";
$pre_post_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['pre_post']);
$participant_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['participant']);
$school_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['school']);
$grade_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['grade']);
$room_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['room']);
$first_pm_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['first_pm_year']);
$num_children_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['num_children']);
$marital_status_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['marital_status']);
$place_birth_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['place_birth']);
$years_in_il_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['years_in_il']);
$current_classes_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['current_classes']);
$currently_working_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['currently_working']);
$current_job_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['current_job']);
$monthly_income_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['monthly_income']);
$food_stamps_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['food_stamps']);
$rent_own_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['rent_own']);
$rent_payment_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['rent_payment']);
$A_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['A']);
$B_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['B']);
$C_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['C']);
$D_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['D']);
$E_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['E']);
$F_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['F']);
$G_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['G']);
$H_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['H']);
$I_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['I']);
$J_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['J']);
$K_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['K']);
$L_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['L']);
$M_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['M']);
$N_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['N']);
$O_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['O']);
$P_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['P']);
$Q_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['Q']);
$R_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['R']);
$Q1_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['Q1']);
$R1_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['R1']);
$S_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['S']);
$T_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['T']);
$U_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['U']);
$V_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['V']);
$W_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['W']);
$X_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['X']);
$survey_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['survey_id']);

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
    
    '" . $pre_post_sqlsafe . "',
	'" . $participant_sqlsafe . "',
                   '" . $save_date . "',
                   '" . $school_sqlsafe . "',
                   '" . $grade_sqlsafe . "',
                   '" . $room_sqlsafe . "',
                   '" . $first_pm_year_sqlsafe . "',
                   '" . $num_children_sqlsafe . "',
                   '" . $marital_status_sqlsafe . "',
                   '" . $place_birth_sqlsafe . "',
                   '" . $years_in_il_sqlsafe . "',
                   '" . $current_classes_sqlsafe . "',
                   '" . $currently_working_sqlsafe . "',
                   '" . $current_job_sqlsafe . "',
                   '" . $monthly_income_sqlsafe . "',
                   '" . $food_stamps_sqlsafe . "',
                   '" . $rent_own_sqlsafe . "',
                   '" . $rent_payment_sqlsafe . "',
                       
                   '" . $A_sqlsafe . "',
                   '" . $B_sqlsafe . "',
                   '" . $C_sqlsafe . "',
                   '" . $D_sqlsafe . "',
                   '" . $E_sqlsafe . "',
                   '" . $F_sqlsafe . "',
                   '" . $G_sqlsafe . "',
                   '" . $H_sqlsafe . "',
                   '" . $I_sqlsafe . "',
                   '" . $J_sqlsafe . "',
                   '" . $K_sqlsafe . "',
                   '" . $L_sqlsafe . "',
                   '" . $M_sqlsafe . "',
                   '" . $N_sqlsafe . "',
                   '" . $O_sqlsafe . "',
                   '" . $P_sqlsafe . "',
                   '" . $Q_sqlsafe . "',
                   '" . $R_sqlsafe . "',
				   '" . $Q1_sqlsafe . "',
				   '" . $R1_sqlsafe . "',
				   '" . $S_sqlsafe . "',
				   '" . $T_sqlsafe . "',
				   '" . $U_sqlsafe . "',
				   '" . $V_sqlsafe . "',
				   '" . $W_sqlsafe . "',
				   '" . $X_sqlsafe . "')";
echo $save_survey_answers;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $save_survey_answers);
include "../include/dbconnclose.php";
}
/* edit survey responses: */
else {
	$edit_survey = "UPDATE Parent_Mentor_Survey SET 
	Pre_Post='" . $pre_post_sqlsafe . "',
	Participant_ID='" . $participant_sqlsafe . "',
    Date='" . $save_date . "',
    School='" . $school_sqlsafe . "',
    Grade='" . $grade_sqlsafe . "',
    Room_Number='" . $room_sqlsafe . "',
    First_Year_PM='" . $first_pm_year_sqlsafe . "',
    Number_Children='" . $num_children_sqlsafe . "',
    Marital_Status='" . $marital_status_sqlsafe . "',
    Place_Birth='" . $place_birth_sqlsafe . "',
    Years_In_IL='" . $years_in_il_sqlsafe . "',
    Classes_Taking='" . $current_classes_sqlsafe . "',
    Currently_Working='" . $currently_working_sqlsafe . "',
    Current_Job='" . $current_job_sqlsafe . "',
    Monthly_Income='" . $monthly_income_sqlsafe . "',
    On_Food_Stamps='" . $food_stamps_sqlsafe . "',
    Rent_Own='" . $rent_own_sqlsafe . "',
    Rent_Payment='" . $rent_payment_sqlsafe . "',
    Student_Involvement_A='" . $A_sqlsafe . "',
    Student_Involvement_B='" . $B_sqlsafe . "',
    Student_Involvement_C='" . $C_sqlsafe . "',
    Student_Involvement_D='" . $D_sqlsafe . "',
    Student_Involvement_E='" . $E_sqlsafe . "',
    Student_Involvement_F='" . $F_sqlsafe . "',
    Student_Involvement_G='" . $G_sqlsafe . "',
    Student_Involvement_H='" . $H_sqlsafe . "',
    School_Network_I='" . $I_sqlsafe . "',
    School_Network_J='" . $J_sqlsafe . "',
    School_Network_K='" . $K_sqlsafe . "',
    School_Network_L='" . $L_sqlsafe . "',
    School_Involvement_M='" . $M_sqlsafe . "',
    School_Involvement_N='" . $N_sqlsafe . "',
    School_Involvement_O='" . $O_sqlsafe . "',
    School_Involvement_P='" . $P_sqlsafe . "',
    School_Involvement_Q='" . $Q_sqlsafe . "',
    School_Involvement_R='" . $R_sqlsafe . "',
	Self_Efficacy_Q='" . $Q1_sqlsafe . "',
    Self_Efficacy_R='" . $R1_sqlsafe . "',
	Self_Efficacy_S='" . $S_sqlsafe . "',
    Self_Efficacy_T='" . $T_sqlsafe . "',
	Self_Efficacy_U='" . $U_sqlsafe . "',
    Self_Efficacy_V='" . $V_sqlsafe . "',
	Self_Efficacy_W='" . $W_sqlsafe . "',
    Self_Efficacy_X='" . $X_sqlsafe . "'
	
	WHERE Parent_Mentor_Survey_ID='" . $survey_id_sqlsafe . "'";
	
	include "../include/dbconnopen.php";
	echo $edit_survey;
	mysqli_query($cnnLSNA, $edit_survey);
	include "../include/dbconnclose.php";
}
?>
