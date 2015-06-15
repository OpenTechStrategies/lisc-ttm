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
include "../../header.php";
include "../header.php";
include "../include/dbconnopen.php";
include "../include/datepicker_simple.php";
include "../participants/construction_functions.php";
?>
<head>
<script type="text/javascript">
    $(document).ready(function() {
        $('#new_la_casa_table').hide();
        $('#residents_div').toggle();
    });
</script>
</head>
<body>
    <h3>La Casa Program Profile</h3>
<table class="profile_table">
<tr>
<td width="100%">
<a href = "javascript:;" onclick="$('#new_la_casa_table').toggle();" ><h5> Add a new person </h5></a>
    <table class="inner_table" style="border: 2px solid #696969;" id="new_la_casa_table">
<tr>
<td><strong>Name: </strong></td>
<td>
<input class="basic_info_edit" id="first_name_edit" value="<?php echo $participant->first_name; ?>" style="width:100px;"/>&nbsp;
<input class="basic_info_edit" id="last_name_edit" value="<?php echo $participant->last_name; ?>" style="width:100px;"/>
    </td>
    <td><strong>Address: </strong></td>
    <td>
    <input id="st_num_edit" value="<?php echo $participant->address_street_num; ?>" style="width:40px;"/> <input id="st_dir_edit" value="<?php echo $participant->address_street_direction; ?>" style="width:20px;"/> <input id="st_name_edit" value="<?php echo $participant->address_street_name; ?>" style="width:100px;"/> <input id="st_type_edit" value="<?php echo $participant->address_street_type; ?>" style="width:35px;"/> <br/>
    <input id="city_edit" value="<?php echo $participant->address_city; ?>" style="width:100px;"/> <input id="state_edit" value="<?php echo $participant->address_state; ?>" style="width:20px;"/> <input id="zip_edit" value="<?php echo $participant->address_zipcode; ?>" style="width:40px;"/> <br/>
    <span class="helptext">e.g. 1818 S Paulina St<br/>Chicago, IL 60608</span>
    </td>
    </tr>
    <tr>
    <td><strong>Phone Number: </strong></td>
    <td>
    <span class="basic_info_show"><?php echo $participant->phone; ?></span>
<input class="basic_info_edit" id="phone_edit" value="<?php echo $participant->phone; ?>"/>
    </td>
    <td><strong>E-mail Address: </strong></td>
    <td>
    <span class="basic_info_show"><?php echo $participant->email; ?></span>
<input class="basic_info_edit" id="email_edit" value="<?php echo $participant->email; ?>"/>
    </td>
    </tr>
    <tr>

    <td><strong>Date of Birth: </strong></td>
    <td>
    <span class="basic_info_show"><?php echo $DOB; ?></span>
<input class="basic_info_edit date_popout" id="dob_edit" value="<?php echo display_date($DOB); ?>"/>
    <span class="basic_info_edit helptext">(mm/dd/yyyy)</span>
    </td>

    <td><strong>Gender: </strong></td>
    <td>
                            <span class="basic_info_show"><?php
if ($participant->gender == 'm') {
    echo "Male";
} else if ($participant->gender == 'f') {
    echo "Female";
};
?></span>
                            <select class="basic_info_edit" id="gender_edit"/>
                    <option value="">-------</option>
                    <option value="m" <?php echo($participant->gender == 'm' ? 'selected="selected"' : null); ?>>Male</option>
                    <option value="f" <?php echo($participant->gender == 'f' ? 'selected="selected"' : null); ?>>Female</option>
                    </select>
    </td>
    </tr>
    <tr>
    <td><strong>College Name:</strong></td>            
    <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_selector($college_array, 
            $term_array['college_id'], 
            'edit_college_new', 
            $this_row_class); 
        ?>
        </span>
        </td>

<td><strong>School Year:</strong></td> 
        <td>
        <?php
        echo la_casa_edit_data_gen_selector($school_year_array, 
            $term_array['school_year'], 
            'edit_year_new', 
            $this_row_class);
?>
</td> 
</tr>
<tr>
<td><strong>Term Type:</strong></td><td>
<?php
        echo la_casa_edit_data_gen_selector($term_type_array,
            $term_array['term_type'],
            'edit_term_new',
            $this_row_class); 
?>
</td>
<td><strong>Term:</strong></td><td>
<?php
        echo la_casa_edit_data_gen_selector($season_array,
            $term_array['term'],
            'edit_season_new',
            $this_row_class); 
        ?>
        </td>
    </tr>
    <tr>
<td><strong>Credits:</strong></td>
        <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_input($term_array['credits'],
            'edit_credits_new',
            $this_row_class); 
        ?>
        </span>

        </td>
<td><strong>Major:</strong></td>
<td>
   <?php
        echo la_casa_edit_data_gen_selector($major_array,
            $term_array['major'],
            'edit_major_new',
            $this_row_class); 
     ?>
</td>
    </tr>
    <tr>
<td><strong>Minor</strong></td>
        <td>
<?php
        echo la_casa_edit_data_gen_selector($minor_array,
            $term_array['minor'],
            'edit_minor_new',
            $this_row_class); 
        ?>
        </span>
        </td>
        <td><strong>College GPA</strong></td>
        <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_input($term_array['college_gpa'],
            'edit_gpa_new',
            $this_row_class); 
        ?>
        </span>
        </td>
    </tr>
    <tr>
<td><strong>Expected Match</strong></td>
<td></td>
<td><strong>Actual Match</strong></td>
<td></td>
    </tr>
    <tr>
<td><strong>Internship Status</strong></td>
<td>
<span class="<?php echo $edit_class;?>">
<?php
    echo la_casa_edit_data_gen_selector($yn_array,
        $term_array['internship_status'],
    'edit_internship_new',
    $this_row_class); 
?>
</td>
<td><strong> Intern Hours</strong></td>
<td><?php
        echo la_casa_edit_data_gen_input($term_array['intern_hours'],
            'edit_intern_hours_new',
            $this_row_class); 
        ?>
            </td>
    </tr>
    <tr>
        <td><strong>Dropped Classes</strong></td>

        <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_selector($yn_array,
            $term_array['dropped_classes'],
            'edit_dropped_new',
            $this_row_class); 
?>
</td>
<td><strong> Dropped Credits</strong></td>
<td>
<?php
        echo la_casa_edit_data_gen_input($term_array['dropped_credits'],
            'edit_dropped_credits_new',
            $this_row_class); 
        ?>
        </span>
        </td>
    </tr>
    <tr>
        <th><strong>Emergency Contact Name </strong></th>
    <td><?php
            echo la_casa_edit_data_gen_input($contact['first_name'], 'ec_first_name_edit_'. $contact['contact_id'], $edit_class);
            echo la_casa_edit_data_gen_input($contact['last_name'], 'ec_last_name_edit_'. $contact['contact_id'], $edit_class);
        ?>
        </td>
    <th><strong>Emergency Contact Phone </strong></th>
        <td><?php
            echo la_casa_edit_data_gen_input($contact['phone'], 'ec_phone_edit_' . $contact['contact_id'], $edit_class);
        ?> </td>
    </tr>
    <tr>
    <th><strong>Emergency Contact Relationship </strong></th>
        <td><?php
            echo la_casa_edit_data_gen_input($contact['relationship'], 'ec_relationship_edit_' . $contact['contact_id'], $edit_class);
        ?> </td>
</tr>
    <tr>
    <td><strong>Cohort </strong></td>
    <td> <?php echo $participant->cohort; 
    echo la_casa_edit_data_gen_selector($cohort_array, $participant->cohort, 'edit_cohort', 'edit_term');
    ?>
    </td>
    <td><strong>Status </strong></td>
    <td> <?php echo $participant->status;
echo la_casa_edit_data_gen_selector($status_array, $participant->status, 'status_edit', 'edit_term'); ?> </td>
    </tr>
    <tr>
    <td><strong>Handbook </strong></td>
    <td> <?php echo  $participant->handbook;
echo la_casa_edit_data_gen_selector($yn_array, $participant->handbook, 'handbook_edit', 'edit_term'); ?></td>
    <td><strong>Floor </strong></td>
    <td> <?php echo  $participant->floor;
    echo la_casa_edit_data_gen_input($participant->floor, 'floor_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Pod </strong></td>
    <td> <?php echo  $participant->pod;
    echo la_casa_edit_data_gen_input($participant->pod, 'pod_edit', 'edit_term'); ?></td>
    <td><strong>Room Number </strong></td>
    <td> <?php echo  $participant->room_number;
    echo la_casa_edit_data_gen_input($participant->room_number, 'room_number_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Key Card Number </strong></td>
    <td> <?php echo  $participant->key_card_number;
    echo la_casa_edit_data_gen_input($participant->key_card_number, 'key_card_number_edit', 'edit_term'); ?></td>
    <td><strong>Transcript Submitted </strong></td>
    <td> <?php echo  $participant->transcript_submitted;
echo la_casa_edit_data_gen_selector($yn_array, $participant->transcript_submitted, 'transcript_submitted_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Service Hours Submitted </strong></td>
    <td> <?php echo  $participant->service_hours_submitted;
echo la_casa_edit_data_gen_selector($yn_array, $participant->service_hours_submitted, 'service_hours_submitted_edit', 'edit_term'); ?></td>
    <td><strong>LCRC Username </strong></td>
    <td> <?php echo  $participant->lcrc_username;
    echo la_casa_edit_data_gen_input($participant->lcrc_username, 'lcrc_username_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>LCRC Password </strong></td>
    <td> <?php echo  $participant->lcrc_password;
    echo la_casa_edit_data_gen_input($participant->lcrc_password, 'lcrc_password_edit', 'edit_term'); ?></td>
    <td><strong>LCRC Print Code </strong></td>
    <td> <?php echo  $participant->lcrc_print_code;
    echo la_casa_edit_data_gen_input($participant->lcrc_print_code, 'lcrc_print_code_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Application Received </strong></td>
<td> <?php echo  display_date($participant->application_received);
echo la_casa_edit_data_gen_input($participant->application_received, 'application_received_edit', 'edit_term date_popout', '(mm/dd/yyyy)'); ?></td>
    </tr>
    <tr>
    <td><strong>Application Completed </strong></td>
<td> <?php echo  display_date($participant->application_completed);
echo la_casa_edit_data_gen_input($participant->application_completed, 'application_completed_edit', 'edit_term date_popout', '(mm/dd/yyyy)'); ?></td>
    <td><strong>Household Size </strong></td>
    <td> <?php echo  $participant->household_size;
    echo la_casa_edit_data_gen_input($participant->household_size, 'household_size_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Parent1 AGI </strong></td>
    <td> <?php echo  $participant->parent1_agi;
    echo la_casa_edit_data_gen_input($participant->parent1_agi, 'parent1_agi_edit', 'edit_term'); ?></td>

    <td><strong>Parent2 AGI </strong></td>
    <td> <?php echo  $participant->parent2_agi;
    echo la_casa_edit_data_gen_input($participant->parent2_agi, 'parent2_agi_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Student AGI </strong></td>
    <td> <?php echo  $participant->student_agi;
    echo la_casa_edit_data_gen_input($participant->student_agi, 'student_agi_edit', 'edit_term'); ?></td>
    <td><strong>Act Score </strong></td>
    <td> <?php echo  $participant->act_score;
    echo la_casa_edit_data_gen_input($participant->act_score, 'act_score_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>High School GPA </strong></td>
    <td> <?php echo  $participant->high_school_gpa;
    echo la_casa_edit_data_gen_input($participant->high_school_gpa, 'high_school_gpa_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Dependency Status </strong></td>
    <td> <?php echo  $participant->dependency_status;
echo la_casa_edit_data_gen_selector($yn_array, $participant->dependency_status, 'dependency_status_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>HS GPA Weighted </strong></td>
    <td> <?php echo  $participant->hs_gpa_weighted;
    echo la_casa_edit_data_gen_input($participant->hs_gpa_weighted, 'hs_gpa_weighted_edit', 'edit_term'); ?></td>

    <td><strong>Expected Graduation Year </strong></td>
    <td> <?php echo  $participant->expected_graduation_year;
    echo la_casa_edit_data_gen_input($participant->expected_graduation_year, 'expected_graduation_year_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Expected Graduation Month </strong></td>
    <td> <?php echo  $participant->graduation_month;
    echo la_casa_edit_data_gen_input($participant->graduation_month, 'graduation_month_edit', 'edit_term constant'); ?></td>
    </tr>
    <tr>
    <td><strong>College Grade Level </strong></td>
    <td> <?php echo  $participant->college_grade_level;
echo la_casa_edit_data_gen_selector($grade_array, $participant->college_grade_level, 'college_grade_level_edit', 'edit_term'); ?></td>
    <td><strong>Reason to Leave La Casa </strong></td>
    <td> <?php echo  $participant->reason_leave;
    echo la_casa_edit_data_gen_input($participant->reason_leave, 'reason_leave_edit', 'edit_term'); ?></td>
    </tr>
    <tr>

    <td><strong>Reason to Stay at La Casa </strong></td>
    <td> <?php echo  $participant->reason_stay;
    echo la_casa_edit_data_gen_input($participant->reason_stay, 'reason_stay_edit', 'edit_term'); ?></td>

    <td><strong>Father Highest Level Education </strong></td>
    <td> <?php echo  $participant->father_highest_level_education;
echo la_casa_edit_data_gen_selector($education_levels_array, $participant->father_highest_level_education, 'father_highest_level_education_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Mother Highest Level Education </strong></td>
    <td> <?php echo  $participant->mother_highest_level_education;
    echo la_casa_edit_data_gen_selector($education_levels_array, $participant->mother_highest_level_education, 'mother_highest_level_education_edit', 'edit_term'); ?></td>

    <td><strong>Student Aspiration </strong></td>
    <td> <?php echo  $participant->student_aspiration;
    echo la_casa_edit_data_gen_selector($education_levels_array, $participant->student_aspiration, 'student_aspiration_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>First Generation College Student </strong></td>
    <td> <?php echo  $participant->first_generation_college_student;
echo la_casa_edit_data_gen_selector($yn_array, $participant->first_generation_college_student, 'first_generation_college_student_edit', 'edit_term'); ?></td>

    </tr>
    <tr>
    <td><strong>Student High School </strong></td>
    <td> <?php echo  $participant->student_high_school;
    echo la_casa_edit_data_gen_input($participant->student_high_school, 'student_high_school_edit', 'edit_term'); ?></td>

    <td><strong>AMI </strong></td>
    <td> <?php echo  $participant->ami;
    echo la_casa_edit_data_gen_input($participant->ami, 'ami_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Move In Date </strong></td>
<td> <?php echo  display_date($participant->move_in_date);
echo la_casa_edit_data_gen_input($participant->move_in_date, 'move_in_date_edit', 'edit_term date_popout', '(mm/dd/yyyy)'); ?></td>
    <td><strong>Move Out Date </strong></td>
<td> <?php echo  display_date($participant->move_out_date);
echo la_casa_edit_data_gen_input($participant->move_out_date, 'move_out_date_edit', 'edit_term date_popout', '(mm/dd/yyyy)'); ?></td>
    </tr>
    <tr>

    <td><strong>Mid Twenties </strong></td>
    <td> <?php echo  $participant->mid_twenties;
echo la_casa_edit_data_gen_selector($yn_array, $participant->mid_twenties, 'mid_twenties_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Masters Degree </strong></td>
    <td> <?php echo  $participant->masters_degree;
echo la_casa_edit_data_gen_selector($yn_array, $participant->masters_degree, 'masters_degree_edit', 'edit_term'); ?></td>

    <td><strong>Married </strong></td>
    <td> <?php echo  $participant->married;
echo la_casa_edit_data_gen_selector($yn_array, $participant->married, 'married_edit', 'edit_term'); ?></td>
    </tr>
    <tr>

    <td><strong>Military </strong></td>
    <td> <?php echo  $participant->military;
echo la_casa_edit_data_gen_selector($yn_array, $participant->military, 'military_edit', 'edit_term'); ?></td>
    <td><strong>Has Children </strong></td>
    <td> <?php echo  $participant->has_children;
echo la_casa_edit_data_gen_selector($yn_array, $participant->has_children, 'has_children_edit', 'edit_term'); ?></td>
    </tr>
    <tr>

    <td><strong>Homeless </strong></td>
    <td> <?php echo  $participant->homeless;
echo la_casa_edit_data_gen_selector($yn_array, $participant->homeless, 'homeless_edit', 'edit_term'); ?></td>

    <td><strong>Self Sustaining </strong></td>
    <td> <?php echo  $participant->self_sustaining;
echo la_casa_edit_data_gen_selector($yn_array, $participant->self_sustaining, 'self_sustaining_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Tax Exemptions </strong></td>
    <td> <?php echo  $participant->tax_exemptions;
    echo la_casa_edit_data_gen_input($participant->tax_exemptions, 'tax_exemptions_edit', 'edit_term'); ?></td>

    <td><strong>Household Size TRP </strong></td>
    <td> <?php echo  $participant->household_size_trp;
    echo la_casa_edit_data_gen_input($participant->household_size_trp, 'household_size_trp_edit', 'edit_term'); ?></td>

    </tr>
    <td><strong>Work Study/Self Help</strong></td>
    <td> <?php
    echo la_casa_edit_data_gen_input(null, 'work_study_edit', 'edit_term'); ?></td>
    <td><strong>Food, Transportation, and Other Costs</strong></td>
    <td><?php echo la_casa_edit_data_gen_input(null, 'other_costs_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>La Casa Rent</strong></td>
    <td> <?php
    echo la_casa_edit_data_gen_input(null, 'lc_rent_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Tuition </strong></td>
    <td> <?php echo  $participant->tuition;
    echo la_casa_edit_data_gen_input($participant->tuition, 'tuition_edit', 'edit_term'); ?></td>
    <td><strong>Mandatory Fees </strong></td>
    <td> <?php echo  $participant->mandatory_fees;
    echo la_casa_edit_data_gen_input($participant->mandatory_fees, 'mandatory_fees_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>College Cost </strong></td>
    <td> <?php echo  $participant->college_cost;
    echo la_casa_edit_data_gen_input($participant->college_cost, 'college_cost_edit', 'edit_term'); ?></td>
    <td><strong>Savings </Strong></td>
    <td> <?php echo  $participant->savings;
    echo la_casa_edit_data_gen_input($participant->savings, 'savings_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Family Help </strong></td>
    <td> <?php echo  $participant->family_help;
    echo la_casa_edit_data_gen_input($participant->family_help, 'family_help_edit', 'edit_term'); ?></td>

    <td><strong>La Casa Scholarship </strong></td>
    <td> <?php echo  $participant->lc_scholarship;
    echo la_casa_edit_data_gen_input($participant->lc_scholarship, 'lc_scholarship_edit', 'edit_term'); ?></td>
    </tr>
    <tr>

    <td><strong>Application Source </strong></td>
    <td> <?php echo  $participant->application_source;
    echo la_casa_edit_data_gen_input($participant->application_source, 'application_source_edit', 'edit_term'); ?></td>
    <td><strong>Notes </Strong></td>
    <td> <?php echo  $participant->notes;
    echo la_casa_edit_data_gen_input($participant->notes, 'notes_edit', 'edit_term'); ?></td>
    </tr>
    <tr>

    <td><strong>Email Pack </strong></td>
<td> <?php echo  display_date($participant->email_pack);
echo la_casa_edit_data_gen_input($participant->email_pack, 'email_pack_edit', 'edit_term date_popout date_popout', '(mm/dd/yyyy)'); ?></td>

    <td><strong>Email Orientation </strong></td>
<td> <?php echo  display_date($participant->email_orientation);
echo la_casa_edit_data_gen_input($participant->email_orientation, 'email_orientation_edit', 'edit_term date_popout date_popout', '(mm/dd/yyyy)'); ?></td>
    </tr>
    <tr>
    <td><strong>Email Roommate </strong></td>
<td> <?php echo  display_date($participant->email_roommate);
echo la_casa_edit_data_gen_input($participant->email_roommate, 'email_roommate_edit', 'edit_term date_popout date_popout', '(mm/dd/yyyy)'); ?></td>

    <td><strong>Move In Time </strong></td>
    <td> <?php echo  $participant->move_in_time;
    echo la_casa_edit_data_gen_input($participant->move_in_time, 'move_in_time_edit', 'edit_term'); ?></td>
    </tr>
    <tr>

    <td><strong>Move In Registration </strong></td>
    <td> <?php echo  $participant->move_in_registration;
    echo la_casa_edit_data_gen_input($participant->move_in_registration, 'move_in_registration_edit', 'edit_term'); ?></td>
    <td><strong>Move In Address </strong></td>
    <td> <?php echo  $participant->move_in_address;
    echo la_casa_edit_data_gen_input($participant->move_in_address, 'move_in_address_edit', 'edit_term'); ?></td>
    </tr>
    <tr>

    <td><strong>Move In Note </strong></td>
    <td> <?php echo  $participant->move_in_note;
    echo la_casa_edit_data_gen_input($participant->move_in_note, 'move_in_note_edit', 'edit_term'); ?></td>

    <td><strong>Orientation Date </strong></td>
<td> <?php echo  display_date($participant->orientation_date);
echo la_casa_edit_data_gen_input($participant->orientation_date, 'orientation_date_edit', 'edit_term date_popout', '(mm/dd/yyyy)'); ?></td>
    </tr>
    <tr>
    <td><strong>Orientation Time </strong></td>
    <td> <?php echo  $participant->orientation_time;
    echo la_casa_edit_data_gen_input($participant->orientation_time, 'orientation_time_edit', 'edit_term'); ?></td>
    </tr>        
    <tr>
    <td>
    <input type="button" value="Edit" onclick="$('.edit_term').toggle()">
    <input type="button" value="Save" onclick="
        $.post(
            '../ajax/save_la_casa_info.php',
            {
                action: 'new',
                subject: 'la_casa',
                name: document.getElementById('first_name_edit').value,
                surname: document.getElementById('last_name_edit').value,
                address_num: document.getElementById('st_num_edit').value,
                address_dir: document.getElementById('st_dir_edit').value,
                address_name: document.getElementById('st_name_edit').value,
                address_type: document.getElementById('st_type_edit').value,
                city: document.getElementById('city_edit').value,
                state: document.getElementById('state_edit').value,
                zip: document.getElementById('zip_edit').value,
                phone: document.getElementById('phone_edit').value,
                email: document.getElementById('email_edit').value,
                dob: document.getElementById('dob_edit').value,
                gender: document.getElementById('gender_edit').value,
                cohort: document.getElementById('edit_cohort').value,
                status: document.getElementById('status_edit').value,
                handbook: document.getElementById('handbook_edit').value,
                floor: document.getElementById('floor_edit').value,
                pod: document.getElementById('pod_edit').value,
                room_number: document.getElementById('room_number_edit').value,
                key_card_number: document.getElementById('key_card_number_edit').value,
                transcript_submitted: document.getElementById('transcript_submitted_edit').value,
                service_hours_submitted: document.getElementById('service_hours_submitted_edit').value,
                lcrc_username: document.getElementById('lcrc_username_edit').value,
                lcrc_password: document.getElementById('lcrc_password_edit').value,
                lcrc_print_code: document.getElementById('lcrc_print_code_edit').value,
                application_received: document.getElementById('application_received_edit').value,
                application_completed: document.getElementById('application_completed_edit').value,
                household_size: document.getElementById('household_size_edit').value,
                parent1_agi: document.getElementById('parent1_agi_edit').value,
                parent2_agi: document.getElementById('parent2_agi_edit').value,
                student_agi: document.getElementById('student_agi_edit').value,
                act_score: document.getElementById('act_score_edit').value,
                high_school_gpa: document.getElementById('high_school_gpa_edit').value,
                dependency_status: document.getElementById('dependency_status_edit').value,
                hs_gpa_weighted: document.getElementById('hs_gpa_weighted_edit').value,
                graduation_month: document.getElementById('graduation_month_edit').value,
                expected_graduation_year: document.getElementById('expected_graduation_year_edit').value,
                college_grade_level: document.getElementById('college_grade_level_edit').value,
                reason_leave: document.getElementById('reason_leave_edit').value,
                reason_stay: document.getElementById('reason_stay_edit').value,
                father_highest_level_education: document.getElementById('father_highest_level_education_edit').value,
                mother_highest_level_education: document.getElementById('mother_highest_level_education_edit').value,
                student_aspiration: document.getElementById('student_aspiration_edit').value,
                first_generation_college_student: document.getElementById('first_generation_college_student_edit').value,
                student_high_school: document.getElementById('student_high_school_edit').value,
                ami: document.getElementById('ami_edit').value,
                move_in_date: document.getElementById('move_in_date_edit').value,
                move_out_date: document.getElementById('move_out_date_edit').value,
                mid_twenties: document.getElementById('mid_twenties_edit').value,
                masters_degree: document.getElementById('masters_degree_edit').value,
                married: document.getElementById('married_edit').value,
                military: document.getElementById('military_edit').value,
                has_children: document.getElementById('has_children_edit').value,
                homeless: document.getElementById('homeless_edit').value,
                self_sustaining: document.getElementById('self_sustaining_edit').value,
                tax_exemptions: document.getElementById('tax_exemptions_edit').value,
                household_size_trp: document.getElementById('household_size_trp_edit').value,
                tuition: document.getElementById('tuition_edit').value,
                mandatory_fees: document.getElementById('mandatory_fees_edit').value,
                college_cost: document.getElementById('college_cost_edit').value,
                savings: document.getElementById('savings_edit').value,
                family_help: document.getElementById('family_help_edit').value,
                lc_scholarship: document.getElementById('lc_scholarship_edit').value,
                application_source: document.getElementById('application_source_edit').value,
                notes: document.getElementById('notes_edit').value,
                email_pack: document.getElementById('email_pack_edit').value,
                email_orientation: document.getElementById('email_orientation_edit').value,
                email_roommate: document.getElementById('email_roommate_edit').value,
                move_in_time: document.getElementById('move_in_time_edit').value,
                move_in_registration: document.getElementById('move_in_registration_edit').value,
                move_in_address: document.getElementById('move_in_address_edit').value,
                move_in_note: document.getElementById('move_in_note_edit').value,
                ec_first_name: document.getElementById('ec_first_name_edit_').value,
                ec_last_name: document.getElementById('ec_last_name_edit_').value,
                ec_phone: document.getElementById('ec_phone_edit_' ).value,
                ec_relationship: document.getElementById('ec_relationship_edit_' ).value,
                orientation_date: document.getElementById('orientation_date_edit').value,
                orientation_time: document.getElementById('orientation_time_edit').value,
                college_id: document.getElementById('edit_college_new').value,
                term_type: document.getElementById('edit_season_new').value,
                term_id: document.getElementById('edit_term_new').value,
                school_year: document.getElementById('edit_year_new').value,
                credits: document.getElementById('edit_credits_new').value,
                major: document.getElementById('edit_major_new').value,
                minor: document.getElementById('edit_minor_new').value,
                expected_match: '',
                actual_match: '',
                gpa: document.getElementById('edit_gpa_new').value,
                internship_status: document.getElementById('edit_internship_new').value,
                intern_hours: document.getElementById('edit_intern_hours_new').value,
                dropped_classes: document.getElementById('edit_dropped_new').value,
                dropped_credits: document.getElementById('edit_dropped_credits_new').value,
                work_study: document.getElementById('work_study_edit').value,
                other_costs: document.getElementById('other_costs_edit').value,
                lc_rent: document.getElementById('lc_rent_edit').value

            },
            function (response){
                document.getElementById('show_response').innerHTML = response;
            }
);
">
    </td>
    </tr>
        
    </table>
<div id="show_response"></div>
        <a href="/include/generalized_download_script.php?download_name=trp_lc_xls_emulator">  
        <h5> Export All </h5>
        </a>
        <a href="javascript:;" onclick="$('#residents_div').toggle();">
        <h5> View Current Residents and Applicants </h5>
        </a>
<div id="residents_div">
<?php
        $find_current_residents_and_applicants = "SELECT Participants.Participant_ID, First_Name, Last_Name FROM Participants_Programs LEFT JOIN Participants ON Participants.Participant_ID = Participants_Programs.Participant_ID WHERE Program_ID = 6";
$current_residents = mysqli_query($cnnTRP, $find_current_residents_and_applicants);
while ($resident = mysqli_fetch_row($current_residents)){
    ?>
    <a href="../participants/lc_profile.php?id=<?php echo $resident[0]; ?>">
<?php echo $resident[1] . " " . $resident[2]; ?>
    </a><br />
<?php
}
?>
</div>
</td>
</tr>
<?php
if ( isset($_POST['filter_submit']) ) {
    include "../include/dbconnopen.php";
    $term_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['term_filter']);
    $year_filter_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['year_filter']);
    if ($term_sqlsafe = 'Fall'){
        $move_in_date = $_POST['year_filter'] . '-08-01';
        $move_out_date = $_POST['year_filter'] . '-12-31';
    }
    elseif ($term_sqlsafe = 'Winter'){
        $move_in_date = $_POST['year_filter'] . '-01-01';
        $move_out_date = $_POST['year_filter'] . '-03-31';
    }
    elseif ($term_sqlsafe = 'Spring'){
        $move_in_date = $_POST['year_filter'] . '-04-01';
        $move_out_date = $_POST['year_filter'] . '-06-30';
    }
    elseif ($term_sqlsafe = 'Summer'){
        $move_in_date =  $_POST['year_filter'] . '-07-01';
        $move_out_date =  $_POST['year_filter'] . '-07-31';
    }
    
    $lc_terms_string = " WHERE Term = '$term_sqlsafe' AND School_Year = '" . $_POST['year_filter'] . "'";
    $basics_string = " WHERE Move_In_Date <= $move_in_date AND Move_Out_Date >= $move_out_date ";
    echo "<h3> Results for " . $term_sqlsafe . " " . $_POST['year_filter'] . "</h3>";
}



//choose a year for reports:
        $year = '2014';
        $bachelors_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'Bachelors'";
        $bachelors = mysqli_query($cnnTRP, $bachelors_id_sqlsafe);
        $bachelor = mysqli_fetch_row($bachelors);
        $bachelors_id = $bachelor[0];
        $high_schools_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'High School Diploma'";
        $high_schools = mysqli_query($cnnTRP, $high_schools_id_sqlsafe);
        $high_school = mysqli_fetch_row($high_schools);
        $high_school_id = $high_school[0];
        $la_casa_count_sqlsafe = "SELECT * FROM Participants_Programs WHERE Program_ID = 6;";
        include "../include/dbconnopen.php";
        $lc_count = mysqli_query($cnnTRP, $la_casa_count_sqlsafe);
        $students_denominator = mysqli_num_rows($lc_count);
        $lc_terms_count_sqlsafe = "SELECT * FROM LC_Terms " . $lc_terms_string;
        $lc_terms_count = mysqli_query($cnnTRP, $lc_terms_count_sqlsafe);
        $lc_terms_denominator = mysqli_num_rows($lc_terms_count);
/*
Inputs: CURSOR = result of mysqli_query() 
        REPORT_SUBJECT is the string that will be printed in the
              highest/lowest explanation rows.
        VAL_DENOMINATOR is the denominator for the percentages.
              Usually this is $students_denominator, calculated above.  It
              is the number of people linked to the La Casa program (note
              that not all of these people have information in the
              La_Casa_Basics table).
        IS_INCOME is a flag that determines whether this is the
        household income report.  By default it is set to false, but in the
        income call to the function it is set to true.
        COUNTINDEX is the index of the count in the cursor.
        DESCRIPTION_INDEX is the index of the result (e.g., "African-American")
              in the cursor.
        
Outputs: The result is a string that is a set of html table rows (see below).

Call this to provide rows to be inserted into a La Casa table,
including a highest row, lowest row, and average row.  For example:

    Race                      | Percent | Count
    Hispanic or Latino        | 25%     | 2
    Black or African-American | 25%     | 2
    Asian or Asian-American   | 13%     | 1
    Lowest <Race>                       | Asian or Asian-American
    Highest <Race>                      | Hispanic or Latino
    Average <Race>                      | (this example fails here)


This function returns the rows of information from "Hispanic or
Latino" to ...fails here).

Reports that display the highest/lowest value and average are: Race/Ethnicity (not average),
 Household Size, Household Income,
Credit Accrual, College GPA, ACT Score, High School GPA.
Other than Race/Ethnicity, all of these reports also include an average row.
 */
        function la_casa_report_high_low_gen_html($cursor, $report_subject, $val_denominator, $is_income = false, $countindex = 0, $description_index = 1)
{
    $lowest_val = null;
    $highest_val = null;
    $result = "";
    $reporting_number = 0;
    $avg_numerator = 0;
    $null_count = 0;
    if ($is_income){
        $below15 = 0;
        $below25 = 0;
        $below50 = 0;
    }
    while ($val = mysqli_fetch_row($cursor)) {
        $reporting_number += $val[$countindex];
        if ($lowest_val == null) {
            $lowest_val = $val[$description_index];
        }
        elseif ($val[$description_index] < $lowest_val){
            $lowest_val = $val[$description_index];
        }
        if ($highest_val == null) {
            $highest_val = $val[$description_index];
        }
        elseif ($val[$description_index] > $highest_val){
            $highest_val = $val[$description_index];
        }
        if ($val[$description_index] != null){
            if ($is_income) {
                if ($val[$description_index] < 50000){
                    $below50 += $val[$countindex];
                }
                if ($val[$description_index] < 25000){
                    $below25 += $val[$countindex];
                }
                if ($val[$description_index] < 15000){
                    $below15 += $val[$countindex];
                }
            }
            $result .= "<tr>
        <td>". $val[$description_index] . "</td>
        <td>" . number_format($val[$countindex]/$val_denominator*100) . "%</td>
        <td>" . $val[$countindex] . "</td>
        </tr>";
            $avg_numerator += ($val[$description_index] * $val[$countindex]);
        }
        else{
            $null_count += $val[$countindex];
        }
    }
    $result .= "<tr>
<td> Unknown </td>
<td>" . number_format((($val_denominator + $null_count) - $reporting_number)/$val_denominator * 100 ) .  "%</td>
<td> " . (($val_denominator + $null_count) - $reporting_number) . "</td>
</tr>";
    $result .= "<tr>
        <td colspan = 2><strong> Lowest " . $report_subject
    . " </strong></td>
        <td> " . $lowest_val . "</td></tr>";
    $result .= "<tr>
        <td colspan = 2><strong> Highest " . $report_subject
    . " </strong></td>
    <td> " . $highest_val . "</td></tr>";
    $result .= "<tr><td colspan = 2><strong> Average " . $report_subject . " </strong></td>
<td> " . round($avg_numerator/$val_denominator, 2) . " </td></tr>";
    if ($is_income){
        $result .= "<tr>
        <td colspan = 2><strong> Below $50,000 Annual Income 
</strong></td><td> " . number_format($below50/$val_denominator * 100) . "%</td></tr>";
        $result .= "<tr>
        <td colspan = 2><strong> Below $25,000 Annual Income 
</strong></td><td> " . number_format($below25/$val_denominator * 100) . "%</td></tr>";
        $result .= "<tr>
        <td colspan = 2><strong> Below $15,000 Annual Income 
</strong></td><td> " . number_format($below15/$val_denominator * 100) . "%</td></tr>";

    }
    return $result;
}
/*
Inputs: CURSOR = result of mysqli_query() 
        VAL_DENOMINATOR is the denominator for the percentages.
              Usually this is $students_denominator, calculated above.  It
              is the number of people linked to the La Casa program (note
              that not all of these people have information in the
              La_Casa_Basics table).
        ED_ACHIEVEMENT is a flag marking whether this call is from an
        educational achievement report.
        COUNTINDEX is the index of the count in the cursor.
        DESCRIPTION_INDEX is the column number of the result (e.g., the race)
              in CURSOR.  It is always 1.
        EDUCATION_INDEX is the column number of the education type in CURSOR.
              It is always 2. 
Outputs: The result is a string that is a set of html table rows (see below).

Call this to provide rows to be inserted into a La Casa table.  For example:

    Race                      | Percent | Count
    Hispanic or Latino        | 25%     | 2
    Black or African-American | 25%     | 2
    Asian or Asian-American   | 13%     | 1

This function returns the rows of information from "Hispanic or Latino" to the final "1."

Reports that display a list include: Race/Ethnicity, Major, College, Hometown
 */
function la_casa_report_list_gen_html($cursor, $val_denominator, $ed_achievement = false, $ed_aspiration = false, $countindex = 0, $description_index = 1, $education_index = 2)
{
    $result = "";
    $reporting_number = 0;
    $null_count = 0;
    $count_distinct_results = 0;
    include "../include/dbconnopen.php";
    $hs_diploma_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'High School Diploma'";
    $hs_diploma_id = mysqli_query($cnnTRP, $hs_diploma_id_sqlsafe);
    $diploma_id = mysqli_fetch_row($hs_disploma_id);
    $hs_diploma = $diploma_id[0];
    $bachelors_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'Bachelors Degree'";
    $bachelors_id = mysqli_query($cnnTRP, $bachelors_id_sqlsafe);
    $bach_id = mysqli_fetch_row($bachelors_id);
    $bachelors = $bach_id[0];
    $masters_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'Masters Degree'";
    $masters_id = mysqli_query($cnnTRP, $masters_id_sqlsafe);
    $mas_id = mysqli_fetch_row($masters_id);
    $masters = $mas_id[0];
    $bachelors_plus = 0;
    $hs_less = 0;
    $masters_plus = 0;

    $race_array = array("0" => "N/A", "1" => "African-American", "2" => "Asian-American", "3" => "Latin@", "4" => "White", "5" => "Other");
    $gender_array = array("f" => "Female", "m" => "Male");
    $yn_array = array(1 => "Yes", 2 => "No");
    $match_array = array(1 => "Above Match", 2 => "Match", 3 => "Below Match");
    while ($val = mysqli_fetch_array($cursor)) {
        $reporting_number += $val[$countindex];
        if ($val[$description_index] != null){
            if ($ed_achievement){
                if ($val[$education_index] < $hs_diploma){
                    $hs_less += $val[$countindex];
                }
                if ($val[$education_index] >= $bachelors){
                    $bachelors_plus += $val[$countindex];
                }
            }
            if ($ed_aspiration){
                if ($val[$education_index] >= $masters){
                    $masters_plus += $val[$countindex];
                }
            }

            $count_distinct_results++;
            $result .= "<tr> <td>";
            if ( array_key_exists('Race', $val)){
                $result .= $race_array[$val[$description_index]];
            }
            elseif ( array_key_exists('Gender', $val)){
                $result .= $gender_array[$val[$description_index]];
            }
            elseif ( array_key_exists('Dependency_Status', $val) || array_key_exists('First_Generation_College_Student', $val)){
                $result .= $yn_array[$val[$description_index]];
            }
            elseif ( array_key_exists('College_Match', $val)){
                $result .= $match_array[$val[$description_index]];
            }
            else{
                $result .= $val[$description_index];
            }
                $result .= "</td>
        <td>" . number_format($val[$countindex]/$val_denominator*100) . "%</td>
        <td>" . $val[$countindex] . "</td>
        </tr>";
        }
        else{
            $null_count += $val[$countindex];
        }
    }
    $result .= "<tr>
<td> Unknown </td>
<td>" . number_format((($val_denominator + $null_count) - $reporting_number)/$val_denominator * 100 ) .  "%</td>
<td> " . (($val_denominator + $null_count) - $reporting_number) . "</td>
</tr>
<tr><td colspan = 2><strong> Unique results </strong></td>
<td>" . $count_distinct_results . "</td>";
    if ($ed_achievement){
        $result .= "<tr><td> Percent who have earned a bachelor's or above </td>
<td> " . number_format($bachelors_plus/$val_denominator * 100) . "% </td></tr>";
        $result .= "<tr><td> Percent who have earned less than a high school diploma </td>
<td> " . number_format($hs_less/$val_denominator * 100) . "% </td></tr>";
    }
    if ($ed_aspiration){
        $result .= "<tr><td> Percent who aspire to a Master's degree or more </td>
<td> " . number_format($masters_plus/$val_denominator * 100) . "% </td></tr>";
    }
    return $result;
}
        
    ?>
        <tr><td>
<table align = "left">
        <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=6"; ?>" method="post" name="termFilter">
<tr><th>Term: 
        <select name = "term_filter">
            <option value = "">-----</option>
            <option > Fall</option>
            <option > Winter</option>
            <option > Spring</option>
            <option > Summer</option>
        </select>
</tr>
<tr>
    </th><th>Year: 
        <select name = "year_filter">
            <option value = "">-----</option>
            <option> 2013</option>
            <option> 2014</option>
            <option> 2015</option>
            <option> 2016</option>
            <option> 2017</option>
        </select>
    </th>
</tr>
<tr>
    <th>
        <input type = "submit" value = "Filter" name="filter_submit">
    </th>
        </form>
</tr>
</table>
<p></p>
<?php
if ( isset($_POST['filter_submit']) ) {
    include "../include/dbconnopen.php";
    $term_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['term_filter']);
    $year_filter_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['year_filter']);
    if ($term_sqlsafe = 'Fall'){
        $move_in_date = $_POST['year_filter'] . '-08-01';
        $move_out_date = $_POST['year_filter'] . '-12-31';
    }
    elseif ($term_sqlsafe = 'Winter'){
        $move_in_date = $_POST['year_filter'] . '-01-01';
        $move_out_date = $_POST['year_filter'] . '-03-31';
    }
    elseif ($term_sqlsafe = 'Spring'){
        $move_in_date = $_POST['year_filter'] . '-04-01';
        $move_out_date = $_POST['year_filter'] . '-06-30';
    }
    elseif ($term_sqlsafe = 'Summer'){
        $move_in_date =  $_POST['year_filter'] . '-07-01';
        $move_out_date =  $_POST['year_filter'] . '-07-31';
    }
    
    $lc_terms_string = " WHERE Term = '$term_sqlsafe' AND School_Year = '" . $_POST['year_filter'] . "'";
    $basics_string = " WHERE Move_In_Date <= $move_in_date AND Move_Out_Date >= $move_out_date ";
    echo "<h3> Results for " . $term_sqlsafe . " " . $_POST['year_filter'] . "</h3>";
}

?>
 
<table class = "inner_table">
        <caption> Race and Ethnicity </caption>
<tr><th>Description</th><th>Percent</th><th>Count</th></tr>
<?php
//get the total number of people at La Casa (unique participants in
//the La Casa Basics table), the number of people of each
//race/ethnicity, and calculate the percentages.

        $lc_race_join_sqlsafe = "SELECT COUNT(*), Race FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID WHERE Participants_Programs.Program_ID = 6 GROUP BY Race;";
        $race_counts = mysqli_query($cnnTRP, $lc_race_join_sqlsafe);
        echo la_casa_report_list_gen_html($race_counts, $students_denominator);
?>
</table>
<p></p>
<table class = "inner_table">
<caption> Household Size </caption>
<tr><th>Household Size</th><th>Percent</th><th>Count</th></tr>
<?php 
        $get_household_sizes_sqlsafe = "SELECT Count(*), Household_Size FROM La_Casa_Basics  $basics_string GROUP BY Household_Size;";
        $household_sizes = mysqli_query($cnnTRP, $get_household_sizes_sqlsafe);
        echo la_casa_report_high_low_gen_html($household_sizes, "Household Size", $students_denominator);
?>
</table>

<p></p>

<table class = "inner_table">
<caption> Household Income </caption>
<tr><th>Income</th><th>Percent</th><th>Count</th></tr>

<?php 
$income_sum_sqlsafe = "SELECT COUNT(*), Parent1_AGI + Parent2_AGI +  Student_AGI AS Sum_AGI FROM La_Casa_Basics $basics_string GROUP BY Sum_AGI;";
$income_counts = mysqli_query($cnnTRP, $income_sum_sqlsafe);
$incomeflag = true;
echo la_casa_report_high_low_gen_html($income_counts, "Household Income", $students_denominator, $incomeflag);
?>
</table>

<table class = "inner_table">
<caption> Major/Program of Study </caption>
<tr><th> Major </th><th>Percent</th><th>Count</th></tr>
<?php 
$get_majors_sqlsafe = "SELECT Count(*), Major FROM LC_Terms $lc_terms_string GROUP BY Major;";
$majors = mysqli_query($cnnTRP, $get_majors_sqlsafe);
echo la_casa_report_list_gen_html($majors, $lc_terms_denominator);
?>
</table>
<p></p>
<table class = "inner_table">
<caption> College </caption>
<tr><th> College Name </th><th>Percent</th><th>Count</th></tr>
<?php
$num_linked_colleges_sqlsafe = "SELECT COUNT(*), College_Name FROM LC_Terms LEFT JOIN Colleges ON Colleges.College_ID = LC_Terms.College_ID $lc_terms_string GROUP BY College_Name;";
$num_colleges = mysqli_query($cnnTRP, $num_linked_colleges_sqlsafe);
echo la_casa_report_list_gen_html($num_colleges, $lc_terms_denominator);
?>
</table>
<p></p>
<table class = "inner_table">
<caption> Total Credit Accrual To Date </caption>
<tr><th> Credits Completed </th><th>Percent</th><th>Count</th></tr>
<?php
$sum_of_credits_sqlsafe = "SELECT Count(*), Credit_Range FROM LC_Terms INNER JOIN (SELECT  Participant_ID, SUM(Credits) AS Credit_Range FROM LC_Terms GROUP BY Participant_ID) Result_Table ON Result_Table.Participant_ID = LC_Terms.Participant_ID $lc_terms_string GROUP BY Credit_Range;";
$sum_credits = mysqli_query($cnnTRP, $sum_of_credits_sqlsafe);
echo la_casa_report_high_low_gen_html($sum_credits, "Credit Accrual", $lc_terms_denominator);
?>
</table>
<table class = "inner_table">
<caption> College GPA </caption>
<tr><th>College GPA</th><th>Percent</th><th>Count</th></tr>
<?php
$college_gpa_sqlsafe = "SELECT Count(*), College_GPA FROM LC_Terms $lc_terms_string GROUP BY College_GPA;";
$college_gpa = mysqli_query($cnnTRP, $college_gpa_sqlsafe);
echo la_casa_report_high_low_gen_html($college_gpa, "College GPA", $lc_terms_denominator);
?>
</table>
<table class = "inner_table">
<caption> ACT Score </caption>
<tr><th>Score</th><th>Percent</th><th>Count</th></tr>
<?php
$act_score_sqlsafe = "SELECT  Count(*), ACT_Score FROM La_Casa_Basics $basics_string GROUP BY ACT_Score;";
$act_score = mysqli_query($cnnTRP, $act_score_sqlsafe);
echo la_casa_report_high_low_gen_html($act_score, "ACT Score", $students_denominator);

?>
</table>
<table class = "inner_table">
<caption> High School GPA </caption>
<tr><th>High School GPA</th><th>Percent</th><th>Count</th></tr>
<?php
$high_school_gpa_sqlsafe = "SELECT Count(*), High_School_GPA FROM La_Casa_Basics $basics_string GROUP BY High_School_GPA;";
$high_school_gpa = mysqli_query($cnnTRP, $high_school_gpa_sqlsafe);
echo la_casa_report_high_low_gen_html($high_school_gpa, "High School GPA", $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> Dependency Status </caption>
<tr><th>Status</th><th>Percent</th><th>Count</th></tr>
<?php
$dependency_status_sqlsafe = "SELECT Count(*), Dependency_Status FROM La_Casa_Basics $basics_string GROUP BY Dependency_Status;";
$dependency_status = mysqli_query($cnnTRP, $dependency_status_sqlsafe);
echo la_casa_report_list_gen_html($dependency_status, $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> Gender </caption>
<tr><th>Gender</th><th>Percent</th><th>Count</th></tr>
<?php
$gender_sqlsafe = "SELECT Count(*), Gender FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID WHERE Program_ID = 6 GROUP BY Gender;";
$gender = mysqli_query($cnnTRP, $gender_sqlsafe);
echo la_casa_report_list_gen_html($gender, $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> Father\'s Highest Level of Education </caption>
<tr><th>Description</th><th>Percent</th><th>Count</th></tr>
<?php
$lc_father_ed_join_sqlsafe = "SELECT COUNT(*), Education_Level_Name, Education_ID FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID LEFT JOIN La_Casa_Basics ON Participants.Participant_ID = La_Casa_Basics.Participant_ID_Students LEFT JOIN Educational_Levels ON La_Casa_Basics.Father_Highest_Level_Education = Education_ID WHERE Participants_Programs.Program_ID = 6 GROUP BY Father_Highest_Level_Education;";
$father_ed_counts = mysqli_query($cnnTRP, $lc_father_ed_join_sqlsafe);
$educational_achievement_flag = true;
echo la_casa_report_list_gen_html($father_ed_counts, $students_denominator, $educational_achievement_flag);
?>
</table>
<table class = "inner_table">
<caption> Mother\'s Highest Level of Education</caption>
<tr><th>Description</th><th>Percent</th><th>Count</th></tr>
<?php
$lc_mother_ed_join_sqlsafe = "SELECT COUNT(*), Education_Level_Name, Education_ID FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID LEFT JOIN La_Casa_Basics ON Participants.Participant_ID = La_Casa_Basics.Participant_ID_Students LEFT JOIN Educational_Levels ON La_Casa_Basics.Mother_Highest_Level_Education = Education_ID WHERE Participants_Programs.Program_ID = 6 GROUP BY Mother_Highest_Level_Education;";
$mother_ed_counts = mysqli_query($cnnTRP, $lc_mother_ed_join_sqlsafe);
$educational_achievement_flag = true;
echo la_casa_report_list_gen_html($mother_ed_counts, $students_denominator, $educational_achievement_flag);
?>
</table>
<table class = "inner_table">
<caption>  Student\'s Aspiration </caption>
<tr><th>Description</th><th>Percent</th><th>Count</th></tr>
<?php
$lc_student_aspiration_join_sqlsafe = "SELECT COUNT(*), Education_Level_Name, Education_ID FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID LEFT JOIN La_Casa_Basics ON Participants.Participant_ID = La_Casa_Basics.Participant_ID_Students LEFT JOIN Educational_Levels ON La_Casa_Basics.Student_Aspiration = Education_ID WHERE Participants_Programs.Program_ID = 6 GROUP BY Student_Aspiration;";
$student_aspiration_counts = mysqli_query($cnnTRP, $lc_student_aspiration_join_sqlsafe);
$education_aspiration_flag = true;
$educational_achivement_flag = false;
echo la_casa_report_list_gen_html($student_aspiration_counts, $students_denominator, $educational_achivement_flag, $education_aspiration_flag);
?>
</table>
<table class = "inner_table">
<caption> First Generation College Student </caption>
<tr><th>Yes/No</th><th>Percent</th><th>Count</th></tr>
<?php
$first_generation_check_sqlsafe = "SELECT COUNT(*), First_Generation_College_Student FROM La_Casa_Basics $basics_string GROUP BY First_Generation_College_Student";
$first_gen = mysqli_query($cnnTRP, $first_generation_check_sqlsafe);
echo la_casa_report_list_gen_html($first_gen, $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> College Match </caption>
<tr><th> College Match  </th><th>Percent</th><th>Count</th></tr>
<?php
$college_match_list_sqlsafe = "SELECT COUNT(*), College_Match FROM LC_Terms $lc_terms_string GROUP BY College_Match";
$college_match = mysqli_query($cnnTRP, $college_match_list_sqlsafe);
echo la_casa_report_list_gen_html($college_match, $lc_terms_denominator);
?>

</table>
<table class = "inner_table">
<caption> Persistence and Graduation </caption>
</table>
<table class = "inner_table">
<caption> Student Hometowns </caption>
<tr><th> Hometown </th><th>Percent</th><th>Count</th></tr>
<?php 
$get_hometowns_sqlsafe = "SELECT COUNT(*), Address_City FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID WHERE Program_ID = 6 GROUP BY Address_City";
$hometowns = mysqli_query($cnnTRP, $get_hometowns_sqlsafe);
echo la_casa_report_list_gen_html($hometowns, $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> Student High Schools </caption>
<tr><th> High School </th><th>Percent</th><th>Count</th></tr>
<?php 
$get_high_schools_sqlsafe = "SELECT Count(*), Student_High_School FROM La_Casa_Basics $basics_string GROUP BY Student_High_School;";
$high_schools = mysqli_query($cnnTRP, $get_high_schools_sqlsafe);
echo la_casa_report_list_gen_html($high_schools, $students_denominator);
?>
</table>

</td></tr>


</table>
</body>