<?php
include "../include/dbconnopen.php";
if ( isset($_POST['college_name']) && $_POST['college_name'] != ''){
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
         Major  = '" . mysqli_real_escape_string($cnnTRP, $_POST['major']) . "',
         Minor  = '" . mysqli_real_escape_string($cnnTRP, $_POST['minor']) . "',
         College_GPA = '" . mysqli_real_escape_string($cnnTRP, $_POST['gpa']) . "',
         Actual_Match = '" . mysqli_real_escape_string($cnnTRP, $_POST['actual_match']) . "',
         Expected_Match = '" . mysqli_real_escape_string($cnnTRP, $_POST['expected_match']) . "',
         Internship_Status =  '" . mysqli_real_escape_string($cnnTRP, $_POST['internship_status']) . "',
         Intern_Hours =   '" . mysqli_real_escape_string($cnnTRP, $_POST['intern_hours']) . "',
         Dropped_Classes = '" . mysqli_real_escape_string($cnnTRP, $_POST['dropped_classes']) . "',
         Dropped_Credits = '" . mysqli_real_escape_string($cnnTRP, $_POST['dropped_credits']) . "'
             WHERE Term_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
   echo $edit_college_data_sqlsafe; //testing
   mysqli_query($cnnTRP, $edit_college_data_sqlsafe);
                              
}
elseif ($_POST['action']=='edit' && $_POST['subject'] == 'loans'){
   $edit_college_data_sqlsafe = "UPDATE LC_Terms SET 
         School_Year  = '" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
         Loan_Applications = '" . mysqli_real_escape_string($cnnTRP, $_POST['loan_apps']) . "',
         Loan_Volume  = '" . mysqli_real_escape_string($cnnTRP, $_POST['loan_volume']) . "',
         Loans_Received = '" . mysqli_real_escape_string($cnnTRP, $_POST['loans_received']) . "'
WHERE Term_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
   mysqli_query($cnnTRP, $edit_college_data_sqlsafe);
                              
}

elseif ($_POST['action'] == 'new' && $_POST['subject'] == 'college'){
       $add_college_data_sqlsafe = "INSERT INTO LC_Terms
       (Participant_ID,  College_ID, Term_Type, Term,
       School_Year, Credits, Major, Minor, Expected_Match, Actual_Match, College_GPA, Internship_Status, Intern_Hours, Dropped_Classes, Dropped_Credits) 
       VALUES
       ( '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "',
'" . $college_id_sqlsafe . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['term_type']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['term_id']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['credits']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['major']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['minor']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['expected_match']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['actual_match']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['gpa']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['internship_status']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['internship_hours']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['dropped_classes']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['dropped_credits']) . "'
)";
       echo $add_college_data_sqlsafe;
//   mysqli_query($cnnTRP, $add_college_data_sqlsafe);
}
elseif($_POST['action'] == 'edit' && $_POST['subject'] == 'emergency') {
    $edit_emergency_contacts_sqlsafe = "UPDATE Emergency_Contacts SET
            First_Name = '" . mysqli_real_escape_string($cnnTRP, $_POST['first_name']) . "', 
            Last_Name = '" . mysqli_real_escape_string($cnnTRP, $_POST['last_name']) . "', 
            Phone = '". mysqli_real_escape_string($cnnTRP, $_POST['phone']) . "', 
            Relationship = '" . mysqli_real_escape_string($cnnTRP, $_POST['relationship']) . "'
            WHERE Emergency_Contact_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['contact_id']) . "'";
    mysqli_query($cnnTRP, $edit_emergency_contacts_sqlsafe);
}
elseif ($_POST['action'] == 'edit' && $_POST['subject'] == 'constant'){
    $check_for_existing_row_sqlsafe = "SELECT * FROM LC_Basics WHERE Participant_ID =  '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
    $num_rows_result = mysqli_query($cnnTRP, $check_for_existing_row_sqlsafe);
    $num_rows = mysqli_num_rows($num_rows_result);
    if ($num_rows < 1){
        $insert_constant_data_sqlsafe = "INSERT INTO LC_Basics (
Household_Size, Parent1_AGI, Parent2_AGI, Student_AGI, ACT_Score, High_School_GPA, Dependency_Status, Father_Highest_Level_Education, Mother_Highest_Level_Education, Student_Aspiration, First_Generation_College_Student, Student_Hometown, Student_High_School, Scholarship_Apps, Scholarship_Num, Scholarship_Volume, Scholarships_Received, Household_Income, AMI, Move_In_Date, Move_Out_Date, Mid_Twenties, Masters_Degree, Married, Has_Children, Homeless, Self_Sustaining, Participant_ID_Students
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
'" . mysqli_real_escape_string($cnnTRP, $_POST['scholarship_apps']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['scholarship_num']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['scholarship_volume']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['scholarships_received']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['household_income']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['AMI']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_date']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_out_date']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['mid_twenties']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['masters']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['married']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['has_children']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['homeless']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['self_sust']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "');";
        echo $insert_constant_data_sqlsafe; //testing output
        mysqli_query($cnnTRP, $insert_constant_data_sqlsafe);
    }
    else{

        $edit_constant_data_sqlsafe = "UPDATE LC_Basics SET 
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
Student_High_School = '" . mysqli_real_escape_string($cnnTRP, $_POST['hs']) . "',
Scholarship_Apps =  '" . mysqli_real_escape_string($cnnTRP, $_POST['scholarship_apps']) . "',
Scholarship_Num =  '" . mysqli_real_escape_string($cnnTRP, $_POST['scholarship_num']) . "',
Scholarship_Volume =  '" . mysqli_real_escape_string($cnnTRP, $_POST['scholarship_volume']) . "',
Scholarships_Received =  '" . mysqli_real_escape_string($cnnTRP, $_POST['scholarships_received']) . "',
Household_Income =  '" . mysqli_real_escape_string($cnnTRP, $_POST['household_income']) . "',
AMI =  '" . mysqli_real_escape_string($cnnTRP, $_POST['AMI']) . "',
Move_In_Date =  '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_date']) . "',
Move_Out_Date =  '" . mysqli_real_escape_string($cnnTRP, $_POST['move_out_date']) . "',
Mid_Twenties =  '" . mysqli_real_escape_string($cnnTRP, $_POST['mid_twenties']) . "',
Masters_Degree =  '" . mysqli_real_escape_string($cnnTRP, $_POST['masters']) . "',
Married =  '" . mysqli_real_escape_string($cnnTRP, $_POST['married']) . "',
Has_Children =  '" . mysqli_real_escape_string($cnnTRP, $_POST['has_children']) . "',
Homeless =  '" . mysqli_real_escape_string($cnnTRP, $_POST['homeless']) . "',
Self_Sustaining =  '" . mysqli_real_escape_string($cnnTRP, $_POST['self_sust']) . "'
WHERE Participant_ID_Students =  '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";

        $edit_constant_data_sqlsafe = "UPDATE LC_Basics SET 
Cohort = '" . mysqli_real_escape_string($cnnTRP, $_POST['cohort']) . "',
Status = '" . mysqli_real_escape_string($cnnTRP, $_POST['status']) . "',
Handbook = '" . mysqli_real_escape_string($cnnTRP, $_POST['handbook']) . "',
Floor = '" . mysqli_real_escape_string($cnnTRP, $_POST['floor']) . "',
Pod = '" . mysqli_real_escape_string($cnnTRP, $_POST['pod']) . "',
Room_Number = '" . mysqli_real_escape_string($cnnTRP, $_POST['room_number']) . "',
Key_Card_Number = '" . mysqli_real_escape_string($cnnTRP, $_POST['key_card_number']) . "',
Transcript_Submitted = '" . mysqli_real_escape_string($cnnTRP, $_POST['transcript_submitted']) . "',
Service_Hours_Submitted = '" . mysqli_real_escape_string($cnnTRP, $_POST['service_hours_submitted']) . "',
LCRC_Username = '" . mysqli_real_escape_string($cnnTRP, $_POST['lcrc_username']) . "',
LCRC_Password = '" . mysqli_real_escape_string($cnnTRP, $_POST['lcrc_password']) . "',
LCRC_Print_Code = '" . mysqli_real_escape_string($cnnTRP, $_POST['lcrc_print_code']) . "',
Application_Received = '" . mysqli_real_escape_string($cnnTRP, $_POST['application_received']) . "',
Application_Completed = '" . mysqli_real_escape_string($cnnTRP, $_POST['application_completed']) . "',
Household_Size = '" . mysqli_real_escape_string($cnnTRP, $_POST['household_size']) . "',
Parent1_AGI = '" . mysqli_real_escape_string($cnnTRP, $_POST['parent1_agi']) . "',
Parent2_AGI = '" . mysqli_real_escape_string($cnnTRP, $_POST['parent2_agi']) . "',
Student_AGI = '" . mysqli_real_escape_string($cnnTRP, $_POST['student_agi']) . "',
Act_Score = '" . mysqli_real_escape_string($cnnTRP, $_POST['act_score']) . "',
High_School_Gpa = '" . mysqli_real_escape_string($cnnTRP, $_POST['high_school_gpa']) . "',
Dependency_Status = '" . mysqli_real_escape_string($cnnTRP, $_POST['dependency_status']) . "',
HS_GPA_Weighted = '" . mysqli_real_escape_string($cnnTRP, $_POST['hs_gpa_weighted']) . "',
Expected_Graduation_Year = '" . mysqli_real_escape_string($cnnTRP, $_POST['expected_graduation_year']) . "',
College_Grade_Level = '" . mysqli_real_escape_string($cnnTRP, $_POST['college_grade_level']) . "',
Reason_Leave = '" . mysqli_real_escape_string($cnnTRP, $_POST['reason_leave']) . "',
Reason_Stay = '" . mysqli_real_escape_string($cnnTRP, $_POST['reason_stay']) . "',
Father_Highest_Level_Education = '" . mysqli_real_escape_string($cnnTRP, $_POST['father_highest_level_education']) . "',
Mother_Highest_Level_Education = '" . mysqli_real_escape_string($cnnTRP, $_POST['mother_highest_level_education']) . "',
Student_Aspiration = '" . mysqli_real_escape_string($cnnTRP, $_POST['student_aspiration']) . "',
First_Generation_College_Student = '" . mysqli_real_escape_string($cnnTRP, $_POST['first_generation_college_student']) . "',
Persistence_Graduation = '" . mysqli_real_escape_string($cnnTRP, $_POST['persistence_graduation']) . "',
Student_High_School = '" . mysqli_real_escape_string($cnnTRP, $_POST['student_high_school']) . "',
Pell_Grant = '" . mysqli_real_escape_string($cnnTRP, $_POST['pell_grant']) . "',
Map_Grant = '" . mysqli_real_escape_string($cnnTRP, $_POST['map_grant']) . "',
University_Scholarship = '" . mysqli_real_escape_string($cnnTRP, $_POST['university_scholarship']) . "',
AMI = '" . mysqli_real_escape_string($cnnTRP, $_POST['ami']) . "',
Move_In_Date = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_date']) . "',
Move_Out_Date = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_out_date']) . "',
Mid_Twenties = '" . mysqli_real_escape_string($cnnTRP, $_POST['mid_twenties']) . "',
Masters_Degree = '" . mysqli_real_escape_string($cnnTRP, $_POST['masters_degree']) . "',
Married = '" . mysqli_real_escape_string($cnnTRP, $_POST['married']) . "',
Military = '" . mysqli_real_escape_string($cnnTRP, $_POST['military']) . "',
Has_Children = '" . mysqli_real_escape_string($cnnTRP, $_POST['has_children']) . "',
Homeless = '" . mysqli_real_escape_string($cnnTRP, $_POST['homeless']) . "',
Self_Sustaining = '" . mysqli_real_escape_string($cnnTRP, $_POST['self_sustaining']) . "',
Tax_Exemptions = '" . mysqli_real_escape_string($cnnTRP, $_POST['tax_exemptions']) . "',
Household_Size_TRP = '" . mysqli_real_escape_string($cnnTRP, $_POST['household_size_trp']) . "',
Tuition = '" . mysqli_real_escape_string($cnnTRP, $_POST['tuition']) . "',
Mandatory_Fees = '" . mysqli_real_escape_string($cnnTRP, $_POST['mandatory_fees']) . "',
College_Cost = '" . mysqli_real_escape_string($cnnTRP, $_POST['college_cost']) . "',
Savings = '" . mysqli_real_escape_string($cnnTRP, $_POST['savings']) . "',
Family_Help = '" . mysqli_real_escape_string($cnnTRP, $_POST['family_help']) . "',
LC_Scholarship = '" . mysqli_real_escape_string($cnnTRP, $_POST['lc_scholarship']) . "',
Application_Source = '" . mysqli_real_escape_string($cnnTRP, $_POST['application_source']) . "',
Notes = '" . mysqli_real_escape_string($cnnTRP, $_POST['notes']) . "',
Email_Pack = '" . mysqli_real_escape_string($cnnTRP, $_POST['email_pack']) . "',
Email_Orientation = '" . mysqli_real_escape_string($cnnTRP, $_POST['email_orientation']) . "',
Email_Roommate = '" . mysqli_real_escape_string($cnnTRP, $_POST['email_roommate']) . "',
Move_In_Time = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_time']) . "',
Move_In_Registration = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_registration']) . "',
Move_In_Address = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_address']) . "',
Move_In_Note = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_note']) . "',
Orientation_Date = '" . mysqli_real_escape_string($cnnTRP, $_POST['orientation_date']) . "',
Orientation_Time = '" . mysqli_real_escape_string($cnnTRP, $_POST['orientation_time']) . "'
WHERE Participant_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "';";
        echo $edit_constant_data_sqlsafe; //testing

    mysqli_query($cnnTRP, $edit_constant_data_sqlsafe);
    }
}

?>