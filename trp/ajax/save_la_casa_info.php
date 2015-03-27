<?php
include "../include/dbconnopen.php";
if ($_POST['college_name'] != ''){
        $insert_new_college = "INSERT INTO Colleges (College_Name, College_Type) VALUES ('" . mysqli_real_escape_string($cnnTRP, $_POST['college_name']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['college_type']) . "')";
        mysqli_query($cnnTRP, $insert_new_college);
        $college_id_sqlsafe = mysqli_insert_id($cnnTRP);
    }
    else{
        $college_id_sqlsafe = mysqli_real_escape_string($cnnTRP, $_POST['college_id']);
    }

if ($_POST['action']=='edit' && $_POST['subject'] == 'college'){
   $edit_college_data_sqlsafe = "UPDATE LC_Terms SET 
         College_ID = '" . $college_id_sqlsafe . "',
         Term_Type  = '" . mysqli_real_escape_string($cnnTRP, $_POST['term_type']) . "',
         Term  = '" . mysqli_real_escape_string($cnnTRP, $_POST['term_id']) . "',
         School_Year  = '" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
         Credits = '" . mysqli_real_escape_string($cnnTRP, $_POST['credits']) . "',
         Major  = '" . mysqli_real_escape_string($cnnTRP, $_POST['major_name']) . "',
         College_GPA = '" . mysqli_real_escape_string($cnnTRP, $_POST['gpa']) . "',
         College_Match = '" . mysqli_real_escape_string($cnnTRP, $_POST['match']) . "',
         Internship_Status =  '" . mysqli_real_escape_string($cnnTRP, $_POST['internship_status']) . "',
         Intern_Hours =   '" . mysqli_real_escape_string($cnnTRP, $_POST['intern_hours']) . "'
             WHERE Term_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
   echo $edit_college_data_sqlsafe;
   mysqli_query($cnnTRP, $edit_college_data_sqlsafe);
                              
}
elseif ($_POST['action']=='edit' && $_POST['subject'] == 'loans'){
   $edit_college_data_sqlsafe = "UPDATE LC_Terms SET 
         School_Year  = '" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
         Loan_Applications = '" . mysqli_real_escape_string($cnnTRP, $_POST['loan_apps']) . "',
         Loan_Volume  = '" . mysqli_real_escape_string($cnnTRP, $_POST['loan_volume']) . "',
         Loans_Received = '" . mysqli_real_escape_string($cnnTRP, $_POST['loans_received']) . "'
WHERE Term_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
   echo $edit_college_data_sqlsafe;
   mysqli_query($cnnTRP, $edit_college_data_sqlsafe);
                              
}

elseif ($_POST['action'] == 'new' && $_POST['subject'] == 'college'){
       $add_college_data_sqlsafe = "INSERT INTO LC_Terms
       (Participant_ID,  College_ID, Term_Type, Term,
       School_Year, Credits, Loan_Applications, Loan_Volume,
       Loans_Received, Major, College_Match, College_GPA)
       VALUES
       ( '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "',
'" . $college_id_sqlsafe . "',
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
    $check_for_existing_row_sqlsafe = "SELECT * FROM La_Casa_Basics WHERE Participant_ID_Students =  '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
    $num_rows_result = mysqli_query($cnnTRP, $check_for_existing_row_sqlsafe);
    $num_rows = mysqli_num_rows($num_rows_result);
    if ($num_rows < 1){
        $insert_constant_data_sqlsafe = "INSERT INTO La_Casa_Basics (
Household_Size, Parent1_AGI, Parent2_AGI, Student_AGI, ACT_Score, High_School_GPA, Dependency_Status, Father_Highest_Level_Education, Mother_Highest_Level_Education, Student_Aspiration, First_Generation_College_Student, Student_Hometown, Student_High_School, Participant_ID_Students
) VALUES (
'" . mysqli_real_escape_string($cnnTRP, $_POST['household_size']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['parent1agi']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['parent2agi']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['studentagi']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['actscore']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['hsgpa']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['dependency']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['father_ed']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['mother_ed']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['student_ed']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['first_gen']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['hometown']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['hs']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "');";
        echo $insert_constant_data_sqlsafe; //testing output
        mysqli_query($cnnTRP, $insert_constant_data_sqlsafe);
    }
    else{
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
WHERE Participant_ID_Students =  '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
    mysqli_query($cnnTRP, $edit_constant_data_sqlsafe);
    }
}

?>