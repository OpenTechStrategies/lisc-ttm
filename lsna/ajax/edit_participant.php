<?php
/* make participant changes: */
/* if any address element has changed, then recalculate the block group: */
include ($_SERVER['DOCUMENT_ROOT'] . "/include/block_group_finder.php");
$get_existing_address = "SELECT Address_Street_Num, Address_Street_Direction,
                        Address_Street_Name, Address_Street_Type, Address_city,
                        Address_State, Address_Zip, Block_Group
                        FROM Participants
                        WHERE Participant_ID='" . $_POST['id'] . "'";
include "../include/dbconnopen.php";
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
if (($_POST['age'] != '') && ($_POST['age'] != 0)) {
    $age = $_POST['age'];
} else {
    $dob = explode('-', $_POST['dob']);
    $new_dob = $dob[0] . '/' . $dob[1] . '/' . $dob[2];
    $birthdate = new DateTime($new_dob);
    $today = new DateTime('today');
    $age_in_years = date_diff($birthdate, $today);
    // echo $age_in_years->format('%y years');
    $age = $age_in_years->format('%y');
}
$date_reformat = explode('-', $_POST['dob']);
$save_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
//  echo $age;

/* make edits: */
$edit_participant_query = "UPDATE Participants SET
                Name_First='" . $_POST['first_name'] . "',
                Name_Last='" . $_POST['last_name'] . "',
                Address_Street_Name='" . $_POST['address_name'] . "',
                Address_Street_Num='" . $_POST['address_num'] . "',
                Address_Street_Direction='" . $_POST['address_dir'] . "',
                Address_Street_Type='" . $_POST['address_type'] . "',
                Address_City='" . $_POST['city'] . "',
                Address_State='" . $_POST['state'] . "',
                Address_Zip='" . $_POST['zip'] . "',
                Block_Group='$block_group',
                Ward='" . $_POST['ward'] . "',
                Phone_Day='" . $_POST['day_phone'] . "',
                Phone_Evening='" . $_POST['evening_phone'] . "',
                Education_Level='" . $_POST['education_level'] . "',
                Email='" . $_POST['email'] . "',
                Age='" . $age . "',
                Consent_2013_14='" . $_POST['consent_2013_14'] . "',
                Consent_2014_15='" . $_POST['consent_2014_15'] . "',
                Consent_2015_16='" . $_POST['consent_2015_16'] . "',
                Gender='" . $_POST['gender'] . "',
                Date_of_Birth='" . $save_date . "',
                Grade_Level='" . $_POST['grade_level'] . "',
                Is_PM = '" . $_POST['pm'] . "',
                Is_Child='" . $_POST['child'] . "'
                WHERE Participant_ID='" . $_POST['id'] . "'";

include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $edit_participant_query);
include "../include/dbconnclose.php";

/* add any new roles: */
if ($_POST['role'] != '') {
    $add_role = "INSERT INTO Participants_Roles (Participant_ID, Role_ID) VALUES ('" . $_POST['id'] . "', '" . $_POST['role'] . "')";
//echo $add_role;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_role);
    include "../include/dbconnclose.php";
}

/* add any new languages: */
if ($_POST['lang'] != '') {
    if ($_POST['lang'] == 'both') {
        $add_lang = "INSERT INTO Participants_Languages (Participant_ID, Language_ID) VALUES 
            ('" . $_POST['id'] . "', '1'),
             ('" . $_POST['id'] . "', '2')";
    } else {
        $add_lang = "INSERT INTO Participants_Languages (Participant_ID, Language_ID) VALUES ('" . $_POST['id'] . "', '" . $_POST['lang'] . "')";
    }
    echo $add_lang;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_lang);
    include "../include/dbconnclose.php";
}
?>
