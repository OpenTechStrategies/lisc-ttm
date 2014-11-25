<?php
include "../include/dbconnopen.php";

if ($_POST['action']=='edit' && $_POST['subject'] == 'college'){
   $edit_college_data_sqlsafe = "UPDATE La_Casa_Basics SET 
         College_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['college_id']) . "',
         Term_Type  = '" . mysqli_real_escape_string($cnnTRP, $_POST['term_type']) . "',
         Term  = '" . mysqli_real_escape_string($cnnTRP, $_POST['term_id']) . "',
         School_Year  = '" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
         Credits = '" . mysqli_real_escape_string($cnnTRP, $_POST['credits']) . "',
         Major  = '" . mysqli_real_escape_string($cnnTRP, $_POST['major']) . "',
         College_GPA = '" . mysqli_real_escape_string($cnnTRP, $_POST['gpa']) . "',
         College_Match = '" . mysqli_real_escape_string($cnnTRP, $_POST['match']) . "'
             WHERE Student_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
   echo $edit_college_data_sqlsafe;
   mysqli_query($cnnTRP, $edit_college_data_sqlsafe);
                              
}
elseif ($_POST['action']=='edit' && $_POST['subject'] == 'loans'){
   $edit_college_data_sqlsafe = "UPDATE La_Casa_Basics SET 
         School_Year  = '" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
         Loan_Applications = '" . mysqli_real_escape_string($cnnTRP, $_POST['loan_apps']) . "',
         Loan_Volume  = '" . mysqli_real_escape_string($cnnTRP, $_POST['loan_volume']) . "',
         Loans_Received = '" . mysqli_real_escape_string($cnnTRP, $_POST['loans_received']) . "'
WHERE Student_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
   echo $edit_college_data_sqlsafe;
   mysqli_query($cnnTRP, $edit_college_data_sqlsafe);
                              
}

elseif ($_POST['action'] == 'new' && $_POST['subject'] == 'college'){
       $add_college_data_sqlsafe = "INSERT INTO La_Casa_Basics
       (Participant_ID_Students,  College_ID, Term_Type, Term,
       School_Year, Credits, Loan_Applications, Loan_Volume,
       Loans_Received, Major, College_Match, College_GPA)
       VALUES
       ( '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['college_id']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['term_type']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['term_id']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['credits']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['loan_apps']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['loan_volume']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['loans_received']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['major']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['match']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['gpa']) . "'

)";
       echo $add_college_data_sqlsafe;
   mysqli_query($cnnTRP, $add_college_data_sqlsafe);
}
elseif ($_POST['action'] == 'edit' && $_POST['subject'] == 'constant'){
    $edit_constant_data_sqlsafe = "UPDATE La_Casa_Basics SET 
Household_Size = '" . mysqli_real_escape_string($cnnTRP, $_POST['household_size']) . "',
Parent1_AGI = '" . mysqli_real_escape_string($cnnTRP, $_POST['parent1agi']) . "',
Parent2_AGI = '" . mysqli_real_escape_string($cnnTRP, $_POST['parent2agi']) . "',
Student_AGI = '" . mysqli_real_escape_string($cnnTRP, $_POST['studentagi']) . "',
ACT_Score = '" . mysqli_real_escape_string($cnnTRP, $_POST['actscore']) . "',
High_School_GPA = '" . mysqli_real_escape_string($cnnTRP, $_POST['hsgpa']) . "',
Dependency_Status = '" . mysqli_real_escape_string($cnnTRP, $_POST['dependency']) . "',
Father_Highest_Level_Education = '" . mysqli_real_escape_string($cnnTRP, $_POST['father_ed']) . "',
Mother_Highest_Level_Education = '" . mysqli_real_escape_string($cnnTRP, $_POST['mother_ed']) . "',
Student_Aspiration = '" . mysqli_real_escape_string($cnnTRP, $_POST['student_ed']) . "',
First_Generation_College_Student = '" . mysqli_real_escape_string($cnnTRP, $_POST['first_gen']) . "',
Student_Hometown = '" . mysqli_real_escape_string($cnnTRP, $_POST['hometown']) . "',
Student_High_School = '" . mysqli_real_escape_string($cnnTRP, $_POST['hs']) . "'
WHERE Student_ID =  '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
    echo $edit_constant_data_sqlsafe;
}

?>