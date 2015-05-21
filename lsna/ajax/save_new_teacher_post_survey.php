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

/*teacher surveys are different pre and post.  This is post only.
 * 
 *  add a new survey: */
include "../include/dbconnopen.php";
$school_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['school']);
$teacher_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['teacher']);
$grade_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['grade']);
$class_lang_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['class_lang']);
$years_pm_program_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['years_pm_program']);
$teacher_language_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['teacher_language']);
$years_teacher_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['years_teacher']);
$years_at_school_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['years_at_school']);
$num_students_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['num_students']);
$num_ell_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['num_ell']);
$num_iep_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['num_iep']);
$num_below_grade_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['num_below_grade']);
$training_pms_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['training_pms']);
$training_teachers_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['training_teachers']);
$grade_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['grade_checkbox']);
$tutor_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['tutor_checkbox']);
$half_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['half_checkbox']);
$hallway_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['hallway_checkbox']);
$discipline_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['discipline_checkbox']);
$homework_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['homework_checkbox']);
$groups_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['groups_checkbox']);
$whole_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['whole_checkbox']);
$organize_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['organize_checkbox']);
$other_checkbox_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['other_checkbox']);
$other_task_text_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['other_task_text']);
$pm_time_spent_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['pm_time_spent']);
$_8_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['8']);
$_9_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['9']);
$_10_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['10']);
$_11_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['11']);
$_12_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['12']);
$_13_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['13']);
$_14_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['14']);
$_15_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['15']);
$pm_training_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['pm_training']);
$teacher_training_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['teacher_training']);
$suggestions_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['suggestions']);
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
$exp_8_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['exp_8']);
$exp_9_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['exp_9']);
$exp_10_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['exp_10']);
$exp_11_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['exp_11']);
$exp_12_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['exp_12']);
$exp_13_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['exp_13']);
$exp_14_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['exp_14']);
$exp_15_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['exp_15']);
$participant_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_COOKIE['participant']);
$survey_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['survey_id']);


if ($_POST['new_survey']==1){
$save_survey_answers = "INSERT INTO PM_Teacher_Survey_Post (
    School_Name,
    Teacher_Name,
    Grade,
    Classroom_Language,
    Attendance,
    Task_1,
    Task_2,
    Task_3,
    Task_4,
    Task_5,
    Task_6,
    Task_7,
    Task_8,
    Task_9,
    Task_10,
    Task_Other_Text,
	Majority_Task,
	Classroom_Benefits_8,
	Classroom_Benefits_9,
	Classroom_Benefits_10,
	Classroom_Benefits_11,
	Classroom_Benefits_12,
	School_Benefits_13,
	School_Benefits_14,
	School_Benefits_15,
	Recommendations_16,
	Recommendations_17,
	Recommendations_18,
    Teacher_Involvement_A,
    Teacher_Involvement_B,
    Teacher_Involvement_C,
    Teacher_Involvement_D,
    Teacher_Involvement_E,
    Teacher_Involvement_F,
    Teacher_Involvement_G,
    Teacher_Involvement_H,
    Teacher_Involvement_I,
    Teacher_Involvement_J,
    Teacher_Parent_Network_K,
    Teacher_Parent_Network_L,
	Explain_8,
	Explain_9,
	Explain_10,
	Explain_11,
	Explain_12,
	Explain_13,
	Explain_14,
	Explain_15,
	Parent_Mentor_ID)
    VALUES (    
                   '" . $school_sqlsafe . "',
                   '" . $teacher_sqlsafe . "',
                   '" . $grade_sqlsafe . "',
                   '" . $class_lang_sqlsafe . "',
                   '" . $pm_attendance_sqlsafe . "',         
                   '" . $grade_checkbox_sqlsafe . "',
                   '" . $tutor_checkbox_sqlsafe . "',
                   '" . $half_checkbox_sqlsafe . "',
                   '" . $hallway_checkbox_sqlsafe . "',
                   '" . $discipline_checkbox_sqlsafe . "',
                   '" . $homework_checkbox_sqlsafe . "',
                   '" . $groups_checkbox_sqlsafe . "',
                   '" . $whole_checkbox_sqlsafe . "',
                   '" . $organize_checkbox_sqlsafe . "',
                   '" . $other_checkbox_sqlsafe . "',
                   '" . $other_task_text_sqlsafe . "',                   
                   '" . $pm_time_spent_sqlsafe . "',
				   '" . $_8_sqlsafe . "',
				   '" . $_9_sqlsafe . "',
				   '" . $_10_sqlsafe . "',
				   '" . $_11_sqlsafe . "',
				   '" . $_12_sqlsafe . "',
				   '" . $_13_sqlsafe . "',
				   '" . $_14_sqlsafe . "',
				   '" . $_15_sqlsafe . "',
				   '" . $pm_training_sqlsafe . "',
				   '" . $teacher_training_sqlsafe . "',
				   '" . $suggestions_sqlsafe . "',
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
				   '" . $exp_8_sqlsafe . "',
				   '" . $exp_9_sqlsafe . "',
				   '" . $exp_10_sqlsafe . "',
				   '" . $exp_11_sqlsafe . "',
				   '" . $exp_12_sqlsafe . "',
				   '" . $exp_13_sqlsafe . "',
				   '" . $exp_14_sqlsafe . "',
				   '" . $exp_15_sqlsafe . "',
				   '" . $participant_sqlsafe . "')";
echo $save_survey_answers;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $save_survey_answers);
include "../include/dbconnclose.php";
} 

/* edit survey responses: */
else {
	$edit_survey = "UPDATE PM_Teacher_Survey_Post SET 
	School_Name='" . $school_sqlsafe . "',
    Teacher_Name='" . $teacher_sqlsafe . "',
    Grade='" . $grade_sqlsafe . "',
    Classroom_Language='" . $class_lang_sqlsafe . "',
	Attendance='" . $pm_attendance_sqlsafe . "',
    Task_1='" . $grade_checkbox_sqlsafe . "',
    Task_2='" . $tutor_checkbox_sqlsafe . "',
    Task_3='" . $half_checkbox_sqlsafe . "',
    Task_4='" . $hallway_checkbox_sqlsafe . "',
    Task_5='" . $discipline_checkbox_sqlsafe . "',
    Task_6='" . $homework_checkbox_sqlsafe . "',
    Task_7='" . $groups_checkbox_sqlsafe . "',
    Task_8='" . $whole_checkbox_sqlsafe . "',
    Task_9='" . $organize_checkbox_sqlsafe . "',
    Task_10='" . $other_checkbox_sqlsafe . "',
    Task_Other_Text='" . $other_task_text_sqlsafe . "',
    Majority_Task='" . $pm_time_spent_sqlsafe . "',
	Classroom_Benefits_8='" . $_8_sqlsafe . "',
	Classroom_Benefits_9='" . $_9_sqlsafe . "',
	Classroom_Benefits_10='" . $_10_sqlsafe . "',
	Classroom_Benefits_11='" . $_11_sqlsafe . "',
	Classroom_Benefits_12='" . $_12_sqlsafe . "',
	School_Benefits_13='" . $_13_sqlsafe . "',
	School_Benefits_14='" . $_14_sqlsafe . "',
	School_Benefits_15='" . $_15_sqlsafe . "',
	Recommendations_16='" . $pm_training_sqlsafe . "',
	Recommendations_17='" . $teacher_training_sqlsafe . "',
	Recommendations_18='" . $suggestions_sqlsafe . "',
	Teacher_Involvement_A='" . $A_sqlsafe . "',
    Teacher_Involvement_B='" . $B_sqlsafe . "',
    Teacher_Involvement_C='" . $C_sqlsafe . "',
    Teacher_Involvement_D='" . $D_sqlsafe . "',
    Teacher_Involvement_E='" . $E_sqlsafe . "',
    Teacher_Involvement_F='" . $F_sqlsafe . "',
    Teacher_Involvement_G='" . $G_sqlsafe . "',
    Teacher_Involvement_H='" . $H_sqlsafe . "',
    Teacher_Involvement_I='" . $I_sqlsafe . "',
    Teacher_Involvement_J='" . $J_sqlsafe . "',
    Teacher_Parent_Network_K='" . $K_sqlsafe . "',
    Teacher_Parent_Network_L='" . $L_sqlsafe . "',
	Explain_8='" . $exp_8_sqlsafe . "',
	Explain_9='" . $exp_9_sqlsafe . "',
	Explain_10='" . $exp_10_sqlsafe . "',
	Explain_11='" . $exp_11_sqlsafe . "',
	Explain_12='" . $exp_12_sqlsafe . "',
	Explain_13='" . $exp_13_sqlsafe . "',
	Explain_14='" . $exp_14_sqlsafe . "',
	Explain_15='" . $exp_15_sqlsafe . "',
	Parent_Mentor_ID='" . $participant_sqlsafe . "'
	WHERE PM_Teacher_Survey_ID='" . $survey_id_sqlsafe . "'";
	
	include "../include/dbconnopen.php";
	echo $edit_survey;
	mysqli_query($cnnLSNA, $edit_survey);
	include "../include/dbconnclose.php";
}
?>
