<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

/* create a new profile for a person.  get their block group and save it according to their address. */
include ($_SERVER['DOCUMENT_ROOT'] . "/include/block_group_finder.php");
$this_address = $_POST['address_num'] . " " . $_POST['address_dir'] . " " . $_POST['address_name'] . " " . $_POST['address_type'] .
        " " . $_POST['city'] . " " . $_POST['state'] . " " . $_POST['zip'];
// We don't have to SQL-sanitize the inputs to do_it_all() because
// it's just calling the Google Maps geocoder and returning us the
// result.  If there's a problem with the inputs, that's Google's
// problem, not ours (from a security point of view, at least).
$block_group_sqlsafe = do_it_all($this_address, $map);

include "../include/dbconnopen.php";

if ($_POST['action']=='add_to_program'){
    include "../include/dbconnopen.php";
    $create_new_participant_lc="INSERT INTO Participants (
               First_Name,
               Last_Name,
               Address_City,
               Address_State,
               Address_Zipcode,
               Phone,
               Email,
               Mobile_Phone,
               Email_2,
               Gender,
               DOB,
               Race) VALUES
               (
               '" . mysqli_real_escape_string($cnnTRP, $_POST['first_add']) . "', 
               '" . mysqli_real_escape_string($cnnTRP, $_POST['last_add']) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['city_add']) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['state_add']) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['zip_add']) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['phone_add']) . "', 
               '" . mysqli_real_escape_string($cnnTRP, $_POST['email1']) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['mobile_add']) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['email2_add']) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['gender_add']) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['dob_add']) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['race_add']) . "')";
    mysqli_query($cnnTRP, $create_new_participant_lc);
    $new_id=mysqli_insert_id($cnnTRP); //returns the new participant ID
    
    $connect_to_program="INSERT INTO Participants_Programs (Participant_ID,"
            . "Program_ID) VALUES ('" . $new_id . "', '" . $_POST['program'] . 
            "')";
    mysqli_query($cnnTRP, $connect_to_program);
    
    $insert_as_resident="INSERT INTO La_Casa_Residents (
            Participant_ID_Residents,
            Group,
            Handbook,
            Status,
            Floor,
            Pod,
            Room_Number,
            Key_Card,
            App_Received,
            App_Completed,
            Roommate,
            Rmmate_Move_In,
            LC_Username,
            LC_Password,
            LC_Print_Code,
            HS_ID,
            ACT,
            HS_GPA_raw,
            HS_GPA_weight,
            Mother_Education,
            Father_Education,
            First_Gen,
            24_older,
            Master_plus,
            Married,
            Military,
            Has_Children,
            Homeless,
            Self_Sustaining,
            Tax_Exemptions,
            Household_size,
            Household_Income,
            Parent1_AGI,
            Parent2_AGI,
            Student_AGI,
            AMI,
            App_Source,
            Notes,
            Packing_Email,
            Orientation_Email,
            Roommate_Email,
            Move_In,
            Move_In_Registration,
            Move_In_Address,
            Move_In_Note,
            Orientation,
            EC1_First_Name,
            EC1_Last_Name,
            EC1_Phone,
            EC1_Relationship,
            EC2_First_Name,
            EC2_Last_Name,
            EC2_Phone,
            EC2_Relationship,
            Scholarship)
            VALUES (
            '" . $new_id . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['group_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['handbook_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['status_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['floor_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['pod_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['rmnum_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['keynum_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['apprec_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['appcom_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['rmmate_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['rmmate_date_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['username_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['pword_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['print_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['hs_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['act_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['gpaun_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['gpaweight_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['mother_ed_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['father_ed_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['firstgen_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['age_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['masters_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['married_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['military_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['children_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['homeless_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['selfsust_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['taxex_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['household_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['par1agi_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['par2agi_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['stdtagi_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['ami_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['appsource_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['notes_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['pack_email_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['orient_email_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['rmmate_email_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['move_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['registration_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['move_note_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['orient_date_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['orient_time_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['ec1first_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['ec1last_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['ec1phone_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['ec1rel_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['ec2first_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['ec2last_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['ec2phone_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['ec2rel_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['lcschol_add']) . "')";
    
    mysqli_query($cnnTRP, $insert_as_resident);
    
    $insert_as_student="INSERT INTO La_Casa_Students (
            Participant_ID_Students,
            College_Grade_Level,
            Major,
            Minor,
            Comm_College,
            Four_yr_College,
            Selectivity,
            Expected_Match,
            Actual_Match,
            Credits_Fall,
            Credits_Spring,
            Spring_GPA,
            Summer_GPA,
            Fall_GPA,
            School_Year,
            Goal_Ed,
            Tuition,
            Fees,
            Other_Costs,
            La_Casa_Rent,
            College_Stated_Cost,
            Pell_Grant,
            MAP_Grant,
            Scholarships,
            Federal_Sub_Loan,
            Federal_Unsub_Loan,
            Self_Help,
            Savings,
            La_Casa_Scholarship,
            Family_Help,
            College_ID,
            HS_ID,
            HS_Grad_Date,
            HS_GPA,
            Academic_Advisor,
            Advisor_Phone)
            VALUES (
            '" . $new_id . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['grade_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['major_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['minor_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['commcol_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['fourcol_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['selectivity_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['matchexp_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['matchact_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['fall_credits_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['spring_credits_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['spring_gpa_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['summer_gpa_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['fall_gpa_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['schoolyear_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['goaled_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['tuition_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['fees_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['othercosts_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['rent_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['colcost_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['pell_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['map_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['uschol_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['subloan_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['unsubloan_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['selfhelp_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['savings_add']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['moneyhelp_add']) . "')";
    mysqli_query($cnnTRP, $insert_as_student);
}
else{
//format date of birth (DOB)
$dob_formatted = explode('/', $_POST['dob']);
$dob_formatted_sqlsafe = mysqli_real_escape_string($cnnTRP, $dob_formatted[2]) . "-" . mysqli_real_escape_string($cnnTRP, $dob_formatted[0]) . "-" . mysqli_real_escape_string($cnnTRP, $dob_formatted[1]);

$create_new_participant_query_sqlsafe = "INSERT INTO Participants (
                                    First_Name,
                                    Last_Name,
                                    Address_Street_Name,
                                    Address_Street_Num,
                                    Address_Street_Direction,
                                    Address_Street_Type,
                                    Address_City,
                                    Address_State,
                                    Address_Zipcode,
                                    Block_Group,
                                    Phone,
                                    Email,
                                    Gender,
                                    DOB,
                                    Race,
                                    Grade_Level,
                                    Classroom,
                                    Lunch_Price
                                ) VALUES (
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['first_name']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['last_name']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['address_name']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['address_num']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['address_dir']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['address_type']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['city']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['state']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['zip']) . "',
                                        '$block_group_sqlsafe',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['day_phone']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['email']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['gender']) . "',
                                    '" . $dob_formatted_sqlsafe . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['race']) . "',    
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['grade']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['classroom']) . "',
                                    '" . mysqli_real_escape_string($cnnTRP, $_POST['lunch']) . "')";

//echo $create_new_participant_query_sqlsafe;
mysqli_query($cnnTRP, $create_new_participant_query_sqlsafe);
$id = mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>

<span style="color:#990000; font-weight:bold;font-size:.9em;margin-left:auto;margin-right:auto;">Thank you for adding <?php echo $_POST['first_name'] . " " . $_POST['last_name'];?> to the database.</span><br/>
<a href="profile.php?id=<?php echo $id;?>" >View profile</a>
<br/>

<?php
}
?>
