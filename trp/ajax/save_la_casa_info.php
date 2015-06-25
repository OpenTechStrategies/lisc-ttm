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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

include "../include/dbconnopen.php";
include "../participants/construction_functions.php";
$la_casa_id = 6;
function format_escape_date($date){
    include "../include/dbconnopen.php";
    $date_formatted = explode('/', $date);
    $date_sqlsafe = mysqli_real_escape_string($cnnTRP, $date_formatted[2]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[0]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[1]);
    return $date_sqlsafe;
}
$DOB_sqlsafe = format_escape_date($_POST['dob']);

//set college id
if ( isset($_POST['new_college']) && $_POST['new_college'] != ''){
        $insert_new_college = "INSERT INTO Colleges (College_Name) VALUES ('" . 
            mysqli_real_escape_string($cnnTRP, $_POST['new_college']) . "')";
        mysqli_query($cnnTRP, $insert_new_college);
        $college_id_sqlsafe = mysqli_insert_id($cnnTRP);
}
else{
        $college_id_sqlsafe = mysqli_real_escape_string($cnnTRP, $_POST['college_id']);
}
if ( isset($_POST['new_cohort']) && $_POST['new_cohort'] != ''){
        $insert_new_cohort = "INSERT INTO Cohorts (Cohort_Name) VALUES ('" . 
            mysqli_real_escape_string($cnnTRP, $_POST['new_cohort']) . "')";
        mysqli_query($cnnTRP, $insert_new_cohort);
        $cohort = mysqli_insert_id($cnnTRP);
}
else{
        $cohort = $_POST['cohort'];
}
if ( isset($_POST['new_status']) && $_POST['new_status'] != ''){
        $insert_new_status = "INSERT INTO Statuses (Status_Name) VALUES ('" . 
            mysqli_real_escape_string($cnnTRP, $_POST['new_status']) . "')";
        mysqli_query($cnnTRP, $insert_new_status);
        $status = mysqli_insert_id($cnnTRP);
}
else{
        $status = $_POST['status'];
}


$school_year = array_add_or_select($_POST['school_year'], $_POST['new_school_year']);
$major = array_add_or_select($_POST['major'], $_POST['new_major']);
$minor = array_add_or_select($_POST['minor'], $_POST['new_minor']);
//set participant id
if (isset($_POST['id']) && $_POST['id'] != ''){
    $participant_id_sqlsafe = mysqli_real_escape_string($cnnTRP, $_POST['id']);
}
else{


//participant does not exist yet, so we must create him/her

$add_participant_query_sqlsafe = "INSERT INTO Participants
     (First_Name,
     Last_Name,
     Address_Street_Name,
     Address_Street_Num,
     Address_Street_Direction,
     Address_Street_Type,
     Address_City,
     Address_State,
     Address_Zipcode,
     Phone,
     Email,
     Gender,
     DOB)
VALUES (
'" . mysqli_real_escape_string($cnnTRP, $_POST['name']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['surname']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['address_name']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['address_num']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['address_dir']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['address_type']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['city']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['state']) . "',
 '" . mysqli_real_escape_string($cnnTRP, $_POST['zip']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['phone']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['email']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['gender']) . "',
'" . $DOB_sqlsafe . "')";
mysqli_query($cnnTRP, $add_participant_query_sqlsafe);
$participant_id_sqlsafe = mysqli_insert_id($cnnTRP);
    
}

//set insertion queries here, for reuse below

$add_to_lc_program = "INSERT INTO Participants_Programs (Participant_ID, Program_ID) VALUES ($participant_id_sqlsafe, $la_casa_id)"; 

$insert_emergency_contact_sqlsafe = "INSERT INTO Emergency_Contacts ( 
    Participant_ID, First_Name, Last_Name, Phone, Relationship) VALUES (
 '" . $participant_id_sqlsafe . "', 
 '" . mysqli_real_escape_string($cnnTRP, $_POST['ec_first_name']) . "', 
 '" . mysqli_real_escape_string($cnnTRP, $_POST['ec_last_name']) . "', 
 '". mysqli_real_escape_string($cnnTRP, $_POST['ec_phone']) . "', 
 '" . mysqli_real_escape_string($cnnTRP, $_POST['ec_relationship']) . "')";


$add_college_data_sqlsafe = "INSERT INTO LC_Terms
       (Participant_ID,  College_ID, Term_Type, Term,
       School_Year, Credits, Major, Minor, Expected_Match,
       Actual_Match, College_GPA, Internship_Status, Intern_Hours, Dropped_Classes, Dropped_Credits) 
       VALUES
       ( '" . $participant_id_sqlsafe . "', '" .
    $college_id_sqlsafe . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['term_type']) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['term_id']) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $school_year) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['credits']) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $major) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $minor) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['expected_match']) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['actual_match']) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['gpa']) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['internship_status']) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['internship_hours']) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['dropped_classes']) . "', '" . 
    mysqli_real_escape_string($cnnTRP, $_POST['dropped_credits']) . "')";

$insert_constant_data_sqlsafe = "INSERT INTO LC_Basics (
Cohort,
Status,
Handbook,
Floor,
Pod,
Room_Number,
Key_Card_Number,
Transcript_Submitted,
Service_Hours_Submitted,
LCRC_Username,
LCRC_Password,
LCRC_Print_Code,
Application_Received,
Application_Completed,
Household_Size,
Parent1_AGI,
Parent2_AGI,
Student_AGI,
Act_Score,
High_School_Gpa,
HS_GPA_Weighted,
Expected_Graduation_Year,
College_Grade_Level,
Reason_Leave,
Reason_Stay,
Father_Highest_Level_Education,
Mother_Highest_Level_Education,
Student_Aspiration,
First_Generation_College_Student,
Persistence_Graduation,
Student_High_School,
AMI,
Move_In_Season,
Move_In_Year,
Move_Out_Season,
Move_Out_Year,
Mid_Twenties,
Masters_Degree,
Married,
Military,
Has_Children,
Homeless,
Self_Sustaining,
Tax_Exemptions,
Tuition,
Mandatory_Fees,
College_Cost,
Savings,
Family_Help,
LC_Scholarship,
Application_Source,
Notes,
Email_Pack,
Email_Orientation,
Email_Roommate,
Move_In_Time,
Move_In_Registration,
Move_In_Address,
Move_In_Note,
Orientation_Date,
Orientation_Time,
Work_Study,
Other_Costs,
LC_Rent,
Participant_ID
) VALUES (
'" . mysqli_real_escape_string($cnnTRP, $cohort) . "',
'" . mysqli_real_escape_string($cnnTRP, $status) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['handbook']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['floor']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['pod']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['room_number']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['key_card_number']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['transcript_submitted']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['service_hours_submitted']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['lcrc_username']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['lcrc_password']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['lcrc_print_code']) . "',
'" . format_escape_date($_POST['application_received']) . "',
'" . format_escape_date($_POST['application_completed']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['household_size']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['parent1_agi']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['parent2_agi']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['student_agi']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['act_score']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['high_school_gpa']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['hs_gpa_weighted']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['expected_graduation_year']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['college_grade_level']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['reason_leave']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['reason_stay']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['father_highest_level_education']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['mother_highest_level_education']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['student_aspiration']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['first_generation_college_student']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['persistence_graduation']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['student_high_school']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['ami']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_season']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_year']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_out_season']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_out_year']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['mid_twenties']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['masters_degree']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['married']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['military']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['has_children']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['homeless']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['self_sustaining']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['tax_exemptions']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['tuition']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['mandatory_fees']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['college_cost']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['savings']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['family_help']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['lc_scholarship']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['application_source']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['notes']) . "',
'" . format_escape_date($_POST['email_pack']) . "',
'" . format_escape_date($_POST['email_orientation']) . "',
'" . format_escape_date($_POST['email_roommate']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_time']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_registration']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_address']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_note']) . "',
'" . format_escape_date($_POST['orientation_date']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['orientation_time']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['work_study']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['other_costs']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['lc_rent']) . "',
'" . $participant_id_sqlsafe . "')";


if ($_POST['action']=='edit' && $_POST['subject'] == 'college'){
   $edit_college_data_sqlsafe = "UPDATE LC_Terms SET 
         College_ID = '" . $college_id_sqlsafe . "',
         Term_Type  = '" . mysqli_real_escape_string($cnnTRP, $_POST['term_type']) . "',
         Term  = '" . mysqli_real_escape_string($cnnTRP, $_POST['term_id']) . "',
         School_Year  = '" . mysqli_real_escape_string($cnnTRP, $school_year) . "',
         Credits = '" . mysqli_real_escape_string($cnnTRP, $_POST['credits']) . "',
         Major  = '" . mysqli_real_escape_string($cnnTRP, $major) . "',
         Minor  = '" . mysqli_real_escape_string($cnnTRP, $minor) . "',
         College_GPA = '" . mysqli_real_escape_string($cnnTRP, $_POST['gpa']) . "',
         Actual_Match = '" . mysqli_real_escape_string($cnnTRP, $_POST['actual_match']) . "',
         Expected_Match = '" . mysqli_real_escape_string($cnnTRP, $_POST['expected_match']) . "',
         Internship_Status =  '" . mysqli_real_escape_string($cnnTRP, $_POST['internship_status']) . "',
         Intern_Hours =   '" . mysqli_real_escape_string($cnnTRP, $_POST['intern_hours']) . "',
         Dropped_Classes = '" . mysqli_real_escape_string($cnnTRP, $_POST['dropped_classes']) . "',
         Dropped_Credits = '" . mysqli_real_escape_string($cnnTRP, $_POST['dropped_credits']) . "'
             WHERE Term_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
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
    mysqli_query($cnnTRP, $add_college_data_sqlsafe);
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
    $check_for_existing_row_sqlsafe = "SELECT * FROM LC_Basics WHERE Participant_ID =  '" . $participant_id_sqlsafe . "'";
    $num_rows_result = mysqli_query($cnnTRP, $check_for_existing_row_sqlsafe);
    $num_rows = mysqli_num_rows($num_rows_result);
    if ($num_rows < 1){
        mysqli_query($cnnTRP, $insert_constant_data_sqlsafe);
    }
    else{
        $edit_constant_data_sqlsafe = "UPDATE LC_Basics SET 
Cohort = '" . mysqli_real_escape_string($cnnTRP, $cohort) . "',
Status = '" . mysqli_real_escape_string($cnnTRP, $status) . "',
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
Application_Received = '" . format_escape_date($_POST['application_received']) . "',
Application_Completed = '" . format_escape_date($_POST['application_completed']) . "',
Household_Size = '" . mysqli_real_escape_string($cnnTRP, $_POST['household_size']) . "',
Parent1_AGI = '" . mysqli_real_escape_string($cnnTRP, $_POST['parent1_agi']) . "',
Parent2_AGI = '" . mysqli_real_escape_string($cnnTRP, $_POST['parent2_agi']) . "',
Student_AGI = '" . mysqli_real_escape_string($cnnTRP, $_POST['student_agi']) . "',
Act_Score = '" . mysqli_real_escape_string($cnnTRP, $_POST['act_score']) . "',
High_School_Gpa = '" . mysqli_real_escape_string($cnnTRP, $_POST['high_school_gpa']) . "',
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
AMI = '" . mysqli_real_escape_string($cnnTRP, $_POST['ami']) . "',
Move_In_Season = '" . format_escape_date($_POST['move_in_season']) . "',
Move_In_Year = '" . format_escape_date($_POST['move_in_year']) . "',
Move_Out_Season = '" . format_escape_date($_POST['move_out_season']) . "',
Move_Out_Year = '" . format_escape_date($_POST['move_out_year']) . "',
Mid_Twenties = '" . mysqli_real_escape_string($cnnTRP, $_POST['mid_twenties']) . "',
Masters_Degree = '" . mysqli_real_escape_string($cnnTRP, $_POST['masters_degree']) . "',
Married = '" . mysqli_real_escape_string($cnnTRP, $_POST['married']) . "',
Military = '" . mysqli_real_escape_string($cnnTRP, $_POST['military']) . "',
Has_Children = '" . mysqli_real_escape_string($cnnTRP, $_POST['has_children']) . "',
Homeless = '" . mysqli_real_escape_string($cnnTRP, $_POST['homeless']) . "',
Self_Sustaining = '" . mysqli_real_escape_string($cnnTRP, $_POST['self_sustaining']) . "',
Tax_Exemptions = '" . mysqli_real_escape_string($cnnTRP, $_POST['tax_exemptions']) . "',
Tuition = '" . mysqli_real_escape_string($cnnTRP, $_POST['tuition']) . "',
Mandatory_Fees = '" . mysqli_real_escape_string($cnnTRP, $_POST['mandatory_fees']) . "',
College_Cost = '" . mysqli_real_escape_string($cnnTRP, $_POST['college_cost']) . "',
Savings = '" . mysqli_real_escape_string($cnnTRP, $_POST['savings']) . "',
Family_Help = '" . mysqli_real_escape_string($cnnTRP, $_POST['family_help']) . "',
LC_Scholarship = '" . mysqli_real_escape_string($cnnTRP, $_POST['lc_scholarship']) . "',
Application_Source = '" . mysqli_real_escape_string($cnnTRP, $_POST['application_source']) . "',
Notes = '" . mysqli_real_escape_string($cnnTRP, $_POST['notes']) . "',
Email_Pack = '" . format_escape_date($_POST['email_pack']) . "',
Email_Orientation = '" . format_escape_date($_POST['email_orientation']) . "',
Email_Roommate = '" . format_escape_date($_POST['email_roommate']) . "',
Move_In_Time = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_time']) . "',
Move_In_Registration = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_registration']) . "',
Move_In_Address = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_address']) . "',
Move_In_Note = '" . mysqli_real_escape_string($cnnTRP, $_POST['move_in_note']) . "',
Orientation_Date = '" . format_escape_date($_POST['orientation_date']) . "',
Orientation_Time = '" . mysqli_real_escape_string($cnnTRP, $_POST['orientation_time']) . "',
Work_Study = '" . mysqli_real_escape_string($cnnTRP, $_POST['work_study']) . "',
Other_Costs = '" . mysqli_real_escape_string($cnnTRP, $_POST['other_costs']) . "',
LC_Rent = '" . mysqli_real_escape_string($cnnTRP, $_POST['lc_rent']) . "'
WHERE Participant_ID = '" . $participant_id_sqlsafe . "'";
        mysqli_query($cnnTRP, $edit_constant_data_sqlsafe);
    }
}
elseif ($_POST['action'] == 'new' && $_POST['subject'] == 'la_casa'){
    mysqli_query($cnnTRP, $add_to_lc_program);
    mysqli_query($cnnTRP, $insert_constant_data_sqlsafe);
    mysqli_query($cnnTRP, $add_college_data_sqlsafe);
    mysqli_query($cnnTRP, $insert_emergency_contact_sqlsafe);
    ?>
    <span>Thank you for adding <?php echo $_POST['name'] . " " . $_POST['surname']; ?> to the database!  <a href="../participants/lc_profile.php?id=<?php echo $participant_id_sqlsafe; ?>">View their profile here</a></span>
<?php
}

?>