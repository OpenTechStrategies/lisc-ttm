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
if ($_POST['action']=='new' && $_POST['subject'] == 'la_casa'){
    $reformat_date = explode('/', $_POST['dob_add']);
$dob_format = $reformat_date[2] . '-' . $reformat_date[0] . '-' . $reformat_date[1];
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
               '" . mysqli_real_escape_string($cnnTRP, $dob_format) . "',
               '" . mysqli_real_escape_string($cnnTRP, $_POST['race_add']) . "')";
    mysqli_query($cnnTRP, $create_new_participant_lc);
    $new_id=mysqli_insert_id($cnnTRP); //returns the new participant ID
    
    $connect_to_program="INSERT INTO Participants_Programs (Participant_ID,"
            . "Program_ID) VALUES ('" . $new_id . "', '" . $_POST['program'] . 
            "')";
    mysqli_query($cnnTRP, $connect_to_program);

    //insert new college, if one created
    if ($_POST['college_name'] != ''){
        $insert_new_college = "INSERT INTO Colleges (College_Name, College_Type) VALUES ('" . mysqli_real_escape_string($cnnTRP, $_POST['college_name']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['college_type']) . "')";
        mysqli_query($cnnTRP, $insert_new_college);
        $college_id_sqlsafe = mysqli_insert_id($cnnTRP);
    }
    else{
        $college_id_sqlsafe = mysqli_real_escape_string($cnnTRP, $_POST['college_id']);
    }
    $reformat_date = explode('/', $_POST['move_in_date']);
$movein_format = $reformat_date[2] . '-' . $reformat_date[0] . '-' . $reformat_date[1];    
    $reformat_date = explode('/', $_POST['move_out_date']);
$moveout_format = $reformat_date[2] . '-' . $reformat_date[0] . '-' . $reformat_date[1];    

    $insert_la_casa_basics = "INSERT INTO LC_Basics (Participant_ID_Students,
Household_Size, Parent1_AGI, Parent2_AGI, Student_AGI, Scholarship_Apps, Scholarship_Num, Scholarship_Volume, Scholarships_Received, Household_Income, AMI, Move_In_Date, Move_Out_Date, Mid_Twenties, Masters_Degree, Married, Has_Children, Homeless, Self_Sustaining, Dependency_Status)
       VALUES
       ( '" . $new_id . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['household_size']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['parent1_agi']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['parent2_agi']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['student_agi']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['scholarship_apps']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['scholarship_num']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['scholarship_volume']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['scholarships_received']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['household_income']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['AMI']) . "',
'" . mysqli_real_escape_string($cnnTRP, $movein_format) . "',
'" . mysqli_real_escape_string($cnnTRP, $moveout_format) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['mid_twenties']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['masters_degree']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['married']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['has_children']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['homeless']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['self_sustaining']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['dependency_status']) . "'
)";
    mysqli_query($cnnTRP, $insert_la_casa_basics);

    $insert_lc_by_term = "INSERT INTO LC_Terms (Participant_ID, College_ID, Term_Type, Term, School_Year, Credits, Loan_Applications, Loan_Volume, Loans_Received, Internship_Status, Intern_Hours) VALUES ('" 
 . $new_id . "',
'". $college_id_sqlsafe . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['term_type']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['term_id']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['credits']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['loan_apps']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['loan_volume']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['loans_received']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['internship_status']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['intern_hours']) . "'
)";
    mysqli_query($cnnTRP, $insert_lc_by_term);

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
