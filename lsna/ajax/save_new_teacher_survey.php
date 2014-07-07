<?php
/*teacher surveys are different pre and post.  This is pre only.
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
$participant_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_COOKIE['participant']);
$survey_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['survey_id']);

if ($_POST['new_survey']==1){
$save_survey_answers = "INSERT INTO PM_Teacher_Survey (
    School_Name,
    Teacher_Name,
    Grade,
    Classroom_Language,
    Years_In_Program,
    Languages,
    Years_As_Teacher,
    Years_At_School,
    Num_Students,
    Num_ELL_Students,
    Num_IEP_Students,
    Num_Students_Below_Grade_Level,
    PM_Activities_Training,
    Teacher_Activities_Training,
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
	Parent_Mentor_ID)
    VALUES (    
                   '" . $school_sqlsafe . "',
                   '" . $teacher_sqlsafe . "',
                   '" . $grade_sqlsafe . "',
                   '" . $class_lang_sqlsafe . "',
                   '" . $years_pm_program_sqlsafe . "',
                   '" . $teacher_language_sqlsafe . "',
                   '" . $years_teacher_sqlsafe . "',
                   '" . $years_at_school_sqlsafe . "',
                   '" . $num_students_sqlsafe . "',
                   '" . $num_ell_sqlsafe . "',
                   '" . $num_iep_sqlsafe . "',
                   '" . $num_below_grade_sqlsafe . "',
                   '" . $training_pms_sqlsafe . "',
                   '" . $training_teachers_sqlsafe . "',                       
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
				   '" . $participant_sqlsafe . "')";
echo $save_survey_answers;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $save_survey_answers);
include "../include/dbconnclose.php";
} 
/* edit survey responses: */
else {
	$edit_survey = "UPDATE PM_Teacher_Survey SET 
	School_Name='" . $school_sqlsafe . "',
    Teacher_Name='" . $teacher_sqlsafe . "',
    Grade='" . $grade_sqlsafe . "',
    Classroom_Language='" . $class_lang_sqlsafe . "',
    Years_In_Program='" . $years_pm_program_sqlsafe . "',
    Languages='" . $teacher_language_sqlsafe . "',
    Years_As_Teacher='" . $years_teacher_sqlsafe . "',
    Years_At_School='" . $years_at_school_sqlsafe . "',
    Num_Students='" . $num_students_sqlsafe . "',
    Num_ELL_Students='" . $num_ell_sqlsafe . "',
    Num_IEP_Students='" . $num_iep_sqlsafe . "',
    Num_Students_Below_Grade_Level='" . $num_below_grade_sqlsafe . "',
    PM_Activities_Training='" . $training_pms_sqlsafe . "',
    Teacher_Activities_Training='" . $training_teachers_sqlsafe . "',
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
	Parent_Mentor_ID='" . $participant_sqlsafe . "'
	WHERE PM_Teacher_Survey_ID='" . $survey_id_sqlsafe . "'";
	
	include "../include/dbconnopen.php";
	echo $edit_survey;
	mysqli_query($cnnLSNA, $edit_survey);
	include "../include/dbconnclose.php";
}
?>
