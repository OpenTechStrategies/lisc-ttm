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

user_enforce_has_access($TRP_id);

?>
<?php

class Participant {

    public $participant_id; //contact id.

    public function __construct() {
        
    }

    /* get basic information about a participant */

    public function get_basic_info($participant_id) {
        include "../include/dbconnopen.php";
        $participant_id_sqlsafe=mysqli_real_escape_string($cnnTRP, $participant_id);
        $this->participant_id = $participant_id_sqlsafe;
        $get_participant_info = "SELECT * FROM Participants WHERE Participant_ID='$participant_id_sqlsafe'";
        $participant_info = mysqli_query($cnnTRP, $get_participant_info);
        $temp_participant = mysqli_fetch_array($participant_info);
        
        $this->first_name = $temp_participant['First_Name'];
        $this->last_name = $temp_participant['Last_Name'];
        $this->address_street_name = $temp_participant['Address_Street_Name'];
        $this->address_street_num = $temp_participant['Address_Street_Num'];
        $this->address_street_direction = $temp_participant['Address_Street_Direction'];
        $this->address_street_type = $temp_participant['Address_Street_Type'];
        $this->address_state = $temp_participant['Address_State'];
        $this->address_city = $temp_participant['Address_City'];
        $this->address_zipcode = $temp_participant['Address_Zipcode'];
        $this->block_group = $temp_participant['Block_Group'];
        $this->phone = $temp_participant['Phone'];
        $this->email = $temp_participant['Email'];
        $this->gender = $temp_participant['Gender'];
        $this->dob = $temp_participant['DOB'];
        $this->race = $temp_participant['Race'];
        $this->email_2 = $temp_participant['Email_2'];
        $this->mobile_phone = $temp_participant['Mobile_Phone'];
        
    }


    public function get_constant_info($participant_id) {
        include "../include/dbconnopen.php";
        $participant_id_sqlsafe=mysqli_real_escape_string($cnnTRP, $participant_id);
        $this->participant_id = $participant_id_sqlsafe;
        $get_participant_info = "SELECT * FROM LC_Basics WHERE Participant_ID='$participant_id_sqlsafe'";
        $participant_info = mysqli_query($cnnTRP, $get_participant_info);
        $temp_participant = mysqli_fetch_array($participant_info);
        
        $this->cohort = $temp_participant['Cohort'];
        $this->status = $temp_participant['Status'];
        $this->handbook = $temp_participant['Handbook'];
        $this->floor = $temp_participant['Floor'];
        $this->pod = $temp_participant['Pod'];
        $this->room_number = $temp_participant['Room_Number'];
        $this->key_card_number = $temp_participant['Key_Card_Number'];
        $this->transcript_submitted = $temp_participant['Transcript_Submitted'];
        $this->service_hours_submitted = $temp_participant['Service_Hours_Submitted'];
        $this->lcrc_username = $temp_participant['LCRC_Username'];
        $this->lcrc_password = $temp_participant['LCRC_Password'];
        $this->lcrc_print_code = $temp_participant['LCRC_Print_Code'];
        $this->roommate = $temp_participant['Roommate'];
        $this->application_received = $temp_participant['Application_Received'];
        $this->application_completed = $temp_participant['Application_Completed'];
        $this->household_size = $temp_participant['Household_Size'];
        $this->parent1_agi = $temp_participant['Parent1_AGI'];
        $this->parent2_agi = $temp_participant['Parent2_AGI'];
        $this->student_agi = $temp_participant['Student_AGI'];
        $this->act_score = $temp_participant['ACT_Score'];
        $this->high_school_gpa = $temp_participant['High_School_GPA'];
        $this->dependency_status = $temp_participant['Dependency_Status'];
        $this->hs_gpa_weighted = $temp_participant['HS_GPA_Weighted'];
        $this->expected_graduation_year = $temp_participant['Expected_Graduation_Year'];
        $this->college_grade_level = $temp_participant['College_Grade_Level'];
        $this->reason_leave = $temp_participant['Reason_Leave'];
        $this->reason_stay = $temp_participant['Reason_Stay'];
        $this->father_highest_level_education = $temp_participant['Father_Highest_Level_Education'];
        $this->mother_highest_level_education = $temp_participant['Mother_Highest_Level_Education'];
        $this->student_aspiration = $temp_participant['Student_Aspiration'];
        $this->first_generation_college_student = $temp_participant['First_Generation_College_Student'];
        $this->persistence_graduation = $temp_participant['Persistence_Graduation'];
        $this->student_high_school = $temp_participant['Student_High_School'];
        $this->pell_grant = $temp_participant['Pell_Grant'];
        $this->map_grant = $temp_participant['MAP_Grant'];
        $this->university_scholarship = $temp_participant['University_Scholarship'];
        $this->ami = $temp_participant['AMI'];
        $this->move_in_date = $temp_participant['Move_In_Date'];
        $this->move_out_date = $temp_participant['Move_Out_Date'];
        $this->mid_twenties = $temp_participant['Mid_Twenties'];
        $this->masters_degree = $temp_participant['Masters_Degree'];
        $this->married = $temp_participant['Married'];
        $this->military = $temp_participant['Military'];
        $this->has_children = $temp_participant['Has_Children'];
        $this->homeless = $temp_participant['Homeless'];
        $this->self_sustaining = $temp_participant['Self_Sustaining'];
        $this->tax_exemptions = $temp_participant['Tax_Exemptions'];
        $this->household_size_trp = $temp_participant['Household_Size_TRP'];
        $this->tuition = $temp_participant['Tuition'];
        $this->mandatory_fees = $temp_participant['Mandatory_Fees'];
        $this->college_cost = $temp_participant['College_Cost'];
        $this->savings = $temp_participant['Savings'];
        $this->family_help = $temp_participant['Family_Help'];
        $this->lc_scholarship = $temp_participant['LC_Scholarship'];
        $this->application_source = $temp_participant['Application_Source'];
        $this->notes = $temp_participant['Notes'];
        $this->email_pack = $temp_participant['Email_Pack'];
        $this->email_orientation = $temp_participant['Email_Orientation'];
        $this->email_roommate = $temp_participant['Email_Roommate'];
        $this->move_in_time = $temp_participant['Move_In_Time'];
        $this->move_in_registration = $temp_participant['Move_In_Registration'];
        $this->move_in_address = $temp_participant['Move_In_Address'];
        $this->move_in_note = $temp_participant['Move_In_Note'];
        $this->orientation_date = $temp_participant['Orientation_Date'];
        $this->orientation_time = $temp_participant['Orientation_Time'];
        $this->work_study = $temp_participant['Work_Study'];
        $this->other_costs = $temp_participant['Other_Costs'];
        $this->lc_rent = $temp_participant['LC_Rent'];
        $this->graduation_month = $temp_participant['Graduation_Month'];

        $get_participant_info = "SELECT Subsidized_Loan, Unsubsidized_Loan FROM LC_Terms WHERE Participant_ID='$participant_id_sqlsafe' ORDER BY School_Year DESC";
        $participant_info = mysqli_query($cnnTRP, $get_participant_info);
        $temp_participant = mysqli_fetch_array($participant_info);

        $this->subsidized_loan = $temp_participant['Subsidized_Loan'];
        $this->unsubsidized_loan = $temp_participant['Unsubsidized_Loan'];
    }

    public function get_college_info($participant_id) {
        include "../include/dbconnopen.php";
        $participant_id_sqlsafe=mysqli_real_escape_string($cnnTRP, $participant_id);
        $this->participant_id = $participant_id_sqlsafe;
        $get_participant_info = "SELECT * FROM LC_Terms LEFT JOIN Colleges on LC_Terms.College_ID = Colleges.College_ID WHERE Participant_ID='$participant_id_sqlsafe'";
        $participant_info = mysqli_query($cnnTRP, $get_participant_info);

        $college_info_array = array();
        while ($temp_participant = mysqli_fetch_array($participant_info)){
            $term_array = array();
            $term_array['term_id'] =  $temp_participant['Term_ID'];
            $term_array['college_id'] = $temp_participant['College_ID'];
            $term_array['college_name'] = $temp_participant['College_Name'];
            $term_array['term_type'] = $temp_participant['Term_Type'];
            $term_array['term'] = $temp_participant['Term'];
            $term_array['school_year'] = $temp_participant['School_Year'];
            $term_array['credits'] = $temp_participant['Credits'];
            $term_array['major'] = $temp_participant['Major'];
            $term_array['minor'] = $temp_participant['Minor'];
            $term_array['expected_match'] = $temp_participant['Expected_Match'];
            $term_array['actual_match'] = $temp_participant['Actual_Match'];
            $term_array['college_gpa'] = $temp_participant['College_GPA'];
            $term_array['internship_status'] = $temp_participant['Internship_Status'];
            $term_array['intern_hours'] = $temp_participant['Intern_Hours'];
            $term_array['dropped_classes'] = $temp_participant['Dropped_Classes'];
            $term_array['dropped_credits'] = $temp_participant['Dropped_Credits'];
            $college_info_array[] = $term_array;
        }
        
        return $college_info_array;
    }

    public function get_loans_info($participant_id) {
        include "../include/dbconnopen.php";
        $participant_id_sqlsafe=mysqli_real_escape_string($cnnTRP, $participant_id);
        $this->participant_id = $participant_id_sqlsafe;
        $get_participant_info = "SELECT Pell_Grant, Map_Grant, University_Scholarship, Subsidized_Loan, Unsubsidized_Loan, School_Year, Term FROM LC_Basics LEFT JOIN LC_Terms ON LC_Basics.Participant_ID = LC_Terms.Participant_ID WHERE LC_Basics.Participant_ID='$participant_id_sqlsafe'";
        $participant_info = mysqli_query($cnnTRP, $get_participant_info);
        $loan_info_array = array();
        while ($temp_participant = mysqli_fetch_array($participant_info)){
            $individual_loan = array();
            if ($temp_participant['Pell_Grant'] != "" &&  $temp_participant['Pell_Grant'] !=0){
                $individual_loan['type'] = 'Pell Grant';
                $individual_loan['amount'] = $temp_participant['Pell_Grant'];
                $individual_loan['term'] =  $temp_participant['Term'] . " " . $temp_participant['School_Year'] ;
                $loan_info_array[] = $individual_loan;
            }
            if ($temp_participant['Map_Grant'] != "" &&  $temp_participant['Map_Grant'] !=0){
                $individual_loan['type'] = 'Map Grant';
                $individual_loan['amount'] = $temp_participant['Map_Grant'];
                $individual_loan['term'] =  $temp_participant['Term'] . " " . $temp_participant['School_Year'] ;
                $loan_info_array[] = $individual_loan;
            }
            if ($temp_participant['University_Scholarship'] != "" &&  $temp_participant['University_Scholarship'] !=0){
                $individual_loan['type'] = 'University Scholarship';
                $individual_loan['amount'] = $temp_participant['University_Scholarship'];
                $individual_loan['term'] =  $temp_participant['Term'] . " " . $temp_participant['School_Year'] ;
                $loan_info_array[] = $individual_loan;
            }
            if ($temp_participant['Subsidized_Loan'] != "" &&  $temp_participant['Subsidized_Loan'] !=0){
                $individual_loan['type'] = 'Subsidized Loan';
                $individual_loan['amount'] = $temp_participant['Subsidized_Loan'];
                $individual_loan['term'] =  $temp_participant['Term'] . " " . $temp_participant['School_Year'] ;
                $loan_info_array[] = $individual_loan;
            }
            if ($temp_participant['Unsubsidized_Loan'] != "" &&  $temp_participant['Unsubsidized_Loan'] !=0){
                $individual_loan['type'] = 'Unsubsidized Loan';
                $individual_loan['amount'] = $temp_participant['Unsubsidized_Loan'];
                $individual_loan['term'] =  $temp_participant['Term'] . " " . $temp_participant['School_Year'] ;
                $loan_info_array[] = $individual_loan;
            }
        }
        return $loan_info_array;
        
    }

    public function get_emergency_contacts($participant_id) {
        include "../include/dbconnopen.php";
        $participant_id_sqlsafe=mysqli_real_escape_string($cnnTRP, $participant_id);
        $this->participant_id = $participant_id_sqlsafe;
        $get_participant_info = "SELECT * FROM Emergency_Contacts WHERE Participant_ID='$participant_id_sqlsafe'";
        $participant_info = mysqli_query($cnnTRP, $get_participant_info);
        
        $emergency_contact_array = array();
        while ( $temp_participant =  mysqli_fetch_array($participant_info)){
            $ec = array();
            $ec['contact_id'] = $temp_participant['Emergency_Contact_ID'];
            $ec['first_name'] = $temp_participant['First_Name'];
            $ec['last_name'] =  $temp_participant['Last_Name'];
            $ec['phone'] = $temp_participant['Phone'];
            $ec['relationship'] = $temp_participant['Relationship'];
            $emergency_contact_array[] = $ec;
        }
        return ($emergency_contact_array);
    }


}

?>