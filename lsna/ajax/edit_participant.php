<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/* make participant changes: */
/* if any address element has changed, then recalculate the block group: */
include "../include/dbconnopen.php";
$id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);
include ($_SERVER['DOCUMENT_ROOT'] . "/include/block_group_finder.php");
$get_existing_address = "SELECT Address_Street_Num, Address_Street_Direction,
                        Address_Street_Name, Address_Street_Type, Address_city,
                        Address_State, Address_Zip, Block_Group
                        FROM Participants
                        WHERE Participant_ID='" . $id_sqlsafe . "'";

$existing_address = mysqli_query($cnnLSNA, $get_existing_address);
$address_now = mysqli_fetch_row($existing_address);

include "../include/dbconnclose.php";
if ($address_now[0] != $_POST['address_num'] ||
        $address_now[1] != $_POST['address_dir'] ||
        $address_now[2] != $_POST['address_name'] ||
        $address_now[3] != $_POST['address_type'] ||
        $address_now[4] != $_POST['city'] ||
        $address_now[5] != $_POST['state'] ||
        $address_now[6] != $_POST['zip'])
{
    $this_address = $_POST['address_num'] . " " . $_POST['address_dir'] . " "
            . $_POST['address_name'] . " " . $_POST['address_type'] . " "
            . $_POST['city'] . " " . $_POST['state'] . " " . $_POST['zip'];
    $block_group = do_it_all($this_address, $map);
    echo $block_group;
} else {
    $block_group = $address_now[7];
    echo "Same block group";
}

/* reformat DOB and calculate age: */
date_default_timezone_set('America/Chicago');
include "../include/dbconnopen.php";
$age_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['age']);
$dob_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['dob']);
$first_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['first_name']);
$last_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['last_name']);
$address_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['address_name']);
$address_num_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['address_num']);
$address_dir_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['address_dir']);
$address_type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['address_type']);
$city_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['city']);
$state_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['state']);
$zip_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['zip']);
$ward_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['ward']);
$day_phone_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['day_phone']);
$evening_phone_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['evening_phone']);
$education_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['education_level']);
$email_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['email']);
$consent_2013_14_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['consent_2013_14']);
$consent_2014_15_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['consent_2014_15']);
$consent_2015_16_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['consent_2015_16']);
$gender_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['gender']);
$grade_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['grade_level']);
$pm_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['pm']);
$child_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['child']);
$role_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['role']);
$lang_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['lang']);

if (($_POST['age'] != '') && ($_POST['age'] != 0)) {
    $age = $_POST['age'];
} else {
    $dob = explode('-', $dob_sqlsafe);
    $new_dob = $dob[0] . '/' . $dob[1] . '/' . $dob[2];
    $birthdate = new DateTime($new_dob);
    $today = new DateTime('today');
    $age_in_years = date_diff($birthdate, $today);
    // echo $age_in_years->format('%y years');
    $age = $age_in_years->format('%y');
}
$date_reformat = explode('-', $dob_sqlsafe);
$save_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
//  echo $age;

/* make edits: */
$edit_participant_query = "UPDATE Participants SET
                Name_First='" . $first_name_sqlsafe . "',
                Name_Last='" . $last_name_sqlsafe . "',
                Address_Street_Name='" . $address_name_sqlsafe . "',
                Address_Street_Num='" . $address_num_sqlsafe . "',
                Address_Street_Direction='" . $address_dir_sqlsafe . "',
                Address_Street_Type='" . $address_type_sqlsafe . "',
                Address_City='" . $city_sqlsafe . "',
                Address_State='" . $state_sqlsafe . "',
                Address_Zip='" . $zip_sqlsafe . "',
                Block_Group='$block_group',
                Ward='" . $ward_sqlsafe . "',
                Phone_Day='" . $day_phone_sqlsafe . "',
                Phone_Evening='" . $evening_phone_sqlsafe . "',
                Education_Level='" . $education_level_sqlsafe . "',
                Email='" . $email_sqlsafe . "',
                Age='" . $age . "',
                Consent_2013_14='" . $consent_2013_14_sqlsafe . "',
                Consent_2014_15='" . $consent_2014_15_sqlsafe . "',
                Consent_2015_16='" . $consent_2015_16_sqlsafe . "',
                Gender='" . $gender_sqlsafe . "',
                Date_of_Birth='" . $save_date . "',
                Grade_Level='" . $grade_level_sqlsafe . "',
                Is_PM = '" . $pm_sqlsafe . "',
                Is_Child='" . $child_sqlsafe . "'
                WHERE Participant_ID='" . $id_sqlsafe . "'";

include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $edit_participant_query);
include "../include/dbconnclose.php";

/* add any new roles: */
if ($_POST['role'] != '') {
    $add_role = "INSERT INTO Participants_Roles (Participant_ID, Role_ID) VALUES ('" . $id_sqlsafe . "', '" . $role_sqlsafe . "')";
//echo $add_role;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_role);
    include "../include/dbconnclose.php";
}

/* add any new languages: */
if ($_POST['lang'] != '') {
    if ($_POST['lang'] == 'both') {
        $add_lang = "INSERT INTO Participants_Languages (Participant_ID, Language_ID) VALUES 
            ('" . $id_sqlsafe . "', '1'),
             ('" . $id_sqlsafe . "', '2')";
    } else {
        $add_lang = "INSERT INTO Participants_Languages (Participant_ID, Language_ID) VALUES ('" . $id_sqlsafe . "', '" . $lang_sqlsafe . "')";
    }
    echo $add_lang;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_lang);
    include "../include/dbconnclose.php";
}
?>
