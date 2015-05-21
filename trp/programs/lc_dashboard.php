<?php
include "../../header.php";
include "../header.php";
include "../include/dbconnopen.php";
include "../participants/construction_functions.php";
?>
<head>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
</head>
<body>
    <h3>La Casa Program Profile</h3>
<table class="profile_table">
<tr>
<td width="100%">
    <table class="inner_table" style="border: 2px solid #696969;">
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

    <td><strong>Phone Number: </strong></td>
    <td>
    <span class="basic_info_show"><?php echo $participant->phone; ?></span>
<input class="basic_info_edit" id="phone_edit" value="<?php echo $participant->phone; ?>"/>
    </td>
</tr>
<tr>
    <td><strong>E-mail Address: </strong></td>
    <td>
    <span class="basic_info_show"><?php echo $participant->email; ?></span>
<input class="basic_info_edit" id="email_edit" value="<?php echo $participant->email; ?>"/>
    </td>

    <td><strong>Date of Birth: </strong></td>
    <td>
    <span class="basic_info_show"><?php echo $DOB; ?></span>
<input class="basic_info_edit hasDatepickers" id="dob_edit" value="<?php echo $DOB; ?>"/>
    <span class="basic_info_edit helptext">(MM/DD/YYYY)</span>
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
        <td>College Name</td>            <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_selector($college_array, 
            $term_array['college_id'], 
            'edit_college_new', 
            $this_row_class); 
        ?>
        </span>
        </td>

        <td>School Year/<br /> Term Type/ <br /> Term</td>
        <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_selector($school_year_array, 
            $term_array['school_year'], 
            'edit_year_new', 
            $this_row_class); 
        echo la_casa_edit_data_gen_selector($term_type_array,
            $term_array['term_type'],
            'edit_term_new',
            $this_row_class); 
        echo la_casa_edit_data_gen_selector($season_array,
            $term_array['term'],
            'edit_season_new',
            $this_row_class); 
        ?>
        </span>
        </td>
        <td>Credits</td>
        <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_input($term_array['credits'],
            'edit_credits_new',
            $this_row_class); 
        ?>
        </span>

        </td>
</tr>
<tr>
        <td>Major/ <br/ > Minor</td>
        <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_selector($major_array,
            $term_array['major'],
            'edit_major_new',
            $this_row_class); 
        echo la_casa_edit_data_gen_selector($minor_array,
            $term_array['minor'],
            'edit_minor_new',
            $this_row_class); 
        ?>
        </span>
        </td>
        <td>Expected Match/ <br /> Actual Match</td>
<td></td>
        <td>College GPA</td>
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
        <td>Internship Status/ <br /> Intern Hours</td>
        <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_selector($yn_array,
            $term_array['internship_status'],
            'edit_internship_new',
            $this_row_class); 
        echo "<br />";
        echo la_casa_edit_data_gen_input($term_array['intern_hours'],
            'edit_intern_hours_new',
            $this_row_class); 
        ?>
        </span>
        </td>
        <td>Dropped Classes/ <br /> Dropped Credits</td>

        <td>
        <span class="<?php echo $edit_class;?>">
        <?php
        echo la_casa_edit_data_gen_selector($yn_array,
            $term_array['dropped_classes'],
            'edit_dropped_new',
            $this_row_class); 
        echo "<br />";
        echo la_casa_edit_data_gen_input($term_array['dropped_credits'],
            'edit_dropped_credits_new',
            $this_row_class); 
        ?>
        </span>
        </td>
</tr>
<tr>
        <th><strong>Name </strong></th>
    <td><?php
            echo la_casa_edit_data_gen_input($contact['first_name'], 'ec_first_name_edit_'. $contact['contact_id'], $edit_class);
            echo la_casa_edit_data_gen_input($contact['last_name'], 'ec_last_name_edit_'. $contact['contact_id'], $edit_class);
        ?>
        </td>
    <th><strong>Phone </strong></th>
        <td><?php
            echo la_casa_edit_data_gen_input($contact['phone'], 'ec_phone_edit_' . $contact['contact_id'], $edit_class);
        ?> </td>
    <th><strong>Relationship </strong></th>
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
    <td><strong>Handbook </strong></td>
    <td> <?php echo  $participant->handbook;
    echo la_casa_edit_data_gen_input($participant->handbook, 'handbook_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Floor </strong></td>
    <td> <?php echo  $participant->floor;
    echo la_casa_edit_data_gen_input($participant->floor, 'floor_edit', 'edit_term'); ?></td>
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
    echo la_casa_edit_data_gen_input($participant->transcript_submitted, 'transcript_submitted_edit', 'edit_term'); ?></td>
    <td><strong>Service Hours Submitted </strong></td>
    <td> <?php echo  $participant->service_hours_submitted;
echo la_casa_edit_data_gen_selector($yn_array, $participant->service_hours_submitted, 'service_hours_submitted_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Lcrc Username </strong></td>
    <td> <?php echo  $participant->lcrc_username;
    echo la_casa_edit_data_gen_input($participant->lcrc_username, 'lcrc_username_edit', 'edit_term'); ?></td>
    <td><strong>Lcrc Password </strong></td>
    <td> <?php echo  $participant->lcrc_password;
    echo la_casa_edit_data_gen_input($participant->lcrc_password, 'lcrc_password_edit', 'edit_term'); ?></td>
    <td><strong>Lcrc Print Code </strong></td>
    <td> <?php echo  $participant->lcrc_print_code;
    echo la_casa_edit_data_gen_input($participant->lcrc_print_code, 'lcrc_print_code_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Roommate </strong></td>
    <td> <?php echo  $participant->roommate;
echo la_casa_edit_data_gen_selector($participant_array, $participant->roommate, 'roommate_edit', 'edit_term'); ?></td>
    <td><strong>Application Received </strong></td>
    <td> <?php echo  $participant->application_received;
echo la_casa_edit_data_gen_selector($yn_array, $participant->application_received, 'application_received_edit', 'edit_term'); ?></td>
    <td><strong>Application Completed </strong></td>
    <td> <?php echo  $participant->application_completed;
echo la_casa_edit_data_gen_selector($yn_array, $participant->application_completed, 'application_completed_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Household Size </strong></td>
    <td> <?php echo  $participant->household_size;
    echo la_casa_edit_data_gen_input($participant->household_size, 'household_size_edit', 'edit_term'); ?></td>

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

    <td><strong>High School GPA </strong></td>
    <td> <?php echo  $participant->high_school_gpa;
    echo la_casa_edit_data_gen_input($participant->high_school_gpa, 'high_school_gpa_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Dependency Status </strong></td>
    <td> <?php echo  $participant->dependency_status;
echo la_casa_edit_data_gen_selector($yn_status, $participant->dependency_status, 'dependency_status_edit', 'edit_term'); ?></td>
    <td><strong>HS GPA Weighted </strong></td>
    <td> <?php echo  $participant->hs_gpa_weighted;
    echo la_casa_edit_data_gen_input($participant->hs_gpa_weighted, 'hs_gpa_weighted_edit', 'edit_term'); ?></td>

    <td><strong>Expected Graduation Year </strong></td>
    <td> <?php echo  $participant->expected_graduation_year;
    echo la_casa_edit_data_gen_input($participant->expected_graduation_year, 'expected_graduation_year_edit', 'edit_term'); ?></td>
    </tr>
    <tr>

    <td><strong>College Grade Level </strong></td>
    <td> <?php echo  $participant->college_grade_level;
echo la_casa_edit_data_gen_selector($grade_array, $participant->college_grade_level, 'college_grade_level_edit', 'edit_term'); ?></td>
    <td><strong>Reason Leave </strong></td>
    <td> <?php echo  $participant->reason_leave;
    echo la_casa_edit_data_gen_input($participant->reason_leave, 'reason_leave_edit', 'edit_term'); ?></td>

    <td><strong>Reason Stay </strong></td>
    <td> <?php echo  $participant->reason_stay;
    echo la_casa_edit_data_gen_input($participant->reason_stay, 'reason_stay_edit', 'edit_term'); ?></td>
    </tr>
    <tr>

    <td><strong>Father Highest Level Education </strong></td>
    <td> <?php echo  $participant->father_highest_level_education;
echo la_casa_edit_data_gen_selector($education_levels_array, $participant->father_highest_level_education, 'father_highest_level_education_edit', 'edit_term'); ?></td>
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

    <td><strong>Persistence_graduation </strong></td>
    <td> <?php echo  $participant->persistence_graduation;
    echo la_casa_edit_data_gen_input($participant->persistence_graduation, 'persistence_graduation_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Student_high_school </strong></td>
    <td> <?php echo  $participant->student_high_school;
    echo la_casa_edit_data_gen_input($participant->student_high_school, 'student_high_school_edit', 'edit_term'); ?></td>

    <td><strong>AMI </strong></td>
    <td> <?php echo  $participant->ami;
    echo la_casa_edit_data_gen_input($participant->ami, 'ami_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Move_in_date </strong></td>
    <td> <?php echo  $participant->move_in_date;
    echo la_casa_edit_data_gen_input($participant->move_in_date, 'move_in_date_edit', 'edit_term'); ?></td>
    <td><strong>Move_out_date </strong></td>
    <td> <?php echo  $participant->move_out_date;
    echo la_casa_edit_data_gen_input($participant->move_out_date, 'move_out_date_edit', 'edit_term'); ?></td>

    <td><strong>Mid_twenties </strong></td>
    <td> <?php echo  $participant->mid_twenties;
echo la_casa_edit_data_gen_selector($yn_array, $participant->mid_twenties, 'mid_twenties_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Masters_degree </strong></td>
    <td> <?php echo  $participant->masters_degree;
echo la_casa_edit_data_gen_selector($yn_array, $participant->masters_degree, 'masters_degree_edit', 'edit_term'); ?></td>

    <td><strong>Married </strong></td>
    <td> <?php echo  $participant->married;
echo la_casa_edit_data_gen_selector($yn_array, $participant->married, 'married_edit', 'edit_term'); ?></td>

    <td><strong>Military </strong></td>
    <td> <?php echo  $participant->military;
echo la_casa_edit_data_gen_selector($yn_array, $participant->military, 'military_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Has_children </strong></td>
    <td> <?php echo  $participant->has_children;
echo la_casa_edit_data_gen_selector($yn_array, $participant->has_children, 'has_children_edit', 'edit_term'); ?></td>

    <td><strong>Homeless </strong></td>
    <td> <?php echo  $participant->homeless;
echo la_casa_edit_data_gen_selector($yn_array, $participant->homeless, 'homeless_edit', 'edit_term'); ?></td>

    <td><strong>Self_sustaining </strong></td>
    <td> <?php echo  $participant->self_sustaining;
echo la_casa_edit_data_gen_selector($yn_array, $participant->self_sustaining, 'self_sustaining_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Tax_exemptions </strong></td>
    <td> <?php echo  $participant->tax_exemptions;
    echo la_casa_edit_data_gen_input($participant->tax_exemptions, 'tax_exemptions_edit', 'edit_term'); ?></td>

    <td><strong>Household_size_trp </strong></td>
    <td> <?php echo  $participant->household_size_trp;
    echo la_casa_edit_data_gen_input($participant->household_size_trp, 'household_size_trp_edit', 'edit_term'); ?></td>

    <td><strong>Tuition </strong></td>
    <td> <?php echo  $participant->tuition;
    echo la_casa_edit_data_gen_input($participant->tuition, 'tuition_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Mandatory_fees </strong></td>
    <td> <?php echo  $participant->mandatory_fees;
    echo la_casa_edit_data_gen_input($participant->mandatory_fees, 'mandatory_fees_edit', 'edit_term'); ?></td>
    <td><strong>College_cost </strong></td>
    <td> <?php echo  $participant->college_cost;
    echo la_casa_edit_data_gen_input($participant->college_cost, 'college_cost_edit', 'edit_term'); ?></td>
    <td><strong>Savings </strong></td>
    <td> <?php echo  $participant->savings;
    echo la_casa_edit_data_gen_input($participant->savings, 'savings_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Family_help </strong></td>
    <td> <?php echo  $participant->family_help;
    echo la_casa_edit_data_gen_input($participant->family_help, 'family_help_edit', 'edit_term'); ?></td>

    <td><strong>Lc_scholarship </strong></td>
    <td> <?php echo  $participant->lc_scholarship;
    echo la_casa_edit_data_gen_input($participant->lc_scholarship, 'lc_scholarship_edit', 'edit_term'); ?></td>

    <td><strong>Application_source </strong></td>
    <td> <?php echo  $participant->application_source;
    echo la_casa_edit_data_gen_input($participant->application_source, 'application_source_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Notes </strong></td>
    <td> <?php echo  $participant->notes;
    echo la_casa_edit_data_gen_input($participant->notes, 'notes_edit', 'edit_term'); ?></td>

    <td><strong>Email_pack </strong></td>
    <td> <?php echo  $participant->email_pack;
echo la_casa_edit_data_gen_selector($yn_array, $participant->email_pack, 'email_pack_edit', 'edit_term'); ?></td>

    <td><strong>Email_orientation </strong></td>
    <td> <?php echo  $participant->email_orientation;
echo la_casa_edit_data_gen_selector($yn_array, $participant->email_orientation, 'email_orientation_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Email_roommate </strong></td>
    <td> <?php echo  $participant->email_roommate;
echo la_casa_edit_data_gen_selector($yn_array, $participant->email_roommate, 'email_roommate_edit', 'edit_term'); ?></td>

    <td><strong>Move_in_time </strong></td>
    <td> <?php echo  $participant->move_in_time;
    echo la_casa_edit_data_gen_input($participant->move_in_time, 'move_in_time_edit', 'edit_term'); ?></td>

    <td><strong>Move_in_registration </strong></td>
    <td> <?php echo  $participant->move_in_registration;
    echo la_casa_edit_data_gen_input($participant->move_in_registration, 'move_in_registration_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Move_in_address </strong></td>
    <td> <?php echo  $participant->move_in_address;
    echo la_casa_edit_data_gen_input($participant->move_in_address, 'move_in_address_edit', 'edit_term'); ?></td>

    <td><strong>Move_in_note </strong></td>
    <td> <?php echo  $participant->move_in_note;
    echo la_casa_edit_data_gen_input($participant->move_in_note, 'move_in_note_edit', 'edit_term'); ?></td>

    <td><strong>Orientation_date </strong></td>
    <td> <?php echo  $participant->orientation_date;
    echo la_casa_edit_data_gen_input($participant->orientation_date, 'orientation_date_edit', 'edit_term'); ?></td>
    </tr>
    <tr>
    <td><strong>Orientation_time </strong></td>
    <td> <?php echo  $participant->orientation_time;
    echo la_casa_edit_data_gen_input($participant->orientation_time, 'orientation_time_edit', 'edit_term'); ?></td>
    </tr>        </table>
</td>
</tr>
</table>
</body>