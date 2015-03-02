<?php
include "../include/dbconnopen.php";
$first_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['first_name']);
$last_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['last_name']);
$parent_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['parent']);
$child_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['child']);
$person_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['person']);

if ($_POST['add_to_parent'] == 1) {
    /* adding a parent/child link where the initializing participant is the parent and the child needs to be added
     * to the database.
     * Give the child the parent's contact information.
     */
    
    $insert_person = "INSERT INTO Participants (Name_First, Name_Last,  Address_Street_Name, Address_Street_Num, Address_Street_Direction, Address_Street_Type, Address_City, Address_State, Address_Zip, Block_Group, Ward, Phone_Day, Phone_Evening )  SELECT '" . $first_name_sqlsafe . "', '" . $last_name_sqlsafe . "', Address_Street_Name, Address_Street_Num, Address_Street_Direction, Address_Street_Type, Address_City, Address_State, Address_Zip, Block_Group, Ward, Phone_Day, Phone_Evening FROM Participants WHERE Participant_ID = $parent_sqlsafe";
    echo $insert_person;
    mysqli_query($cnnLSNA, $insert_person);
    $id = mysqli_insert_id($cnnLSNA);
    $add_family = "INSERT INTO Parent_Mentor_Children (Parent_ID, Child_ID) VALUES ('" . $parent_sqlsafe . "', '" . $id . "')";
    echo $add_family;
    mysqli_query($cnnLSNA, $add_family);
    include "../include/dbconnclose.php";
} else if ($_POST['add_to_child'] == 1) {
    /* adding a parent/child link where the initializing participant is the child and the parent needs to be added
     * to the database.
     */
    include "../include/dbconnopen.php";
    $insert_person = "INSERT INTO Participants (Name_First, Name_Last) VALUES ('" . $first_name_sqlsafe . "', '" . $last_name_sqlsafe . "')";
    mysqli_query($cnnLSNA, $insert_person);
    $id = mysqli_insert_id($cnnLSNA);
    $add_family = "INSERT INTO Parent_Mentor_Children (Parent_ID, Child_ID) VALUES ('" . $id . "', '" . $child_sqlsafe . "')";
    mysqli_query($cnnLSNA, $add_family);
    include "../include/dbconnclose.php";
} else if ($_POST['add_to_spouse'] == 1) {
    /* adding a person/spouse link where spouse is not yet in 
     * the database.
     */
    include "../include/dbconnopen.php";
    $insert_person = "INSERT INTO Participants (Name_First, Name_Last) VALUES ('" . $first_name_sqlsafe . "', '" . $last_name_sqlsafe . "')";
    mysqli_query($cnnLSNA, $insert_person);
    $id = mysqli_insert_id($cnnLSNA);
    $add_family = "INSERT INTO Parent_Mentor_Children (Parent_ID, Spouse_ID) VALUES ('" .$person_sqlsafe  . "', '" . $id . "')";
    echo $add_family;
    mysqli_query($cnnLSNA, $add_family);
    include "../include/dbconnclose.php";
} else {
    /* general adding a new participant: */

    if ($_POST['action'] != 'teacher') {
        /* get date of birth and age into correct formats */
        date_default_timezone_set('America/Chicago');
        if ($_POST['dob'] != '') {
            $date_reformat = explode('-', $_POST['dob']);
            $save_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
        } else {
            $save_date = '';
        }
        if ($_POST['age'] != '') {
            $age = $_POST['age'];
        } else {
            if ($_POST['dob'] != '') {
                $birthdate = new DateTime($save_date);
                $today = new DateTime('today');
                $age_in_years = date_diff($birthdate, $today);
                // echo $age_in_years->format('%y years');
                $age = $age_in_years->format('%y');
            } else {
                $age = '';
            }
        }
    }
    //echo $age;
    /* get block group from the person's address:  

    include ($_SERVER['DOCUMENT_ROOT'] . "/include/block_group_finder.php");
    $this_address = $_POST['address_num'] . " " . $_POST['address_dir'] . " " . $_POST['address_name'] . " " . $_POST['address_type'] .
            " " . $_POST['city'] . " " . $_POST['state'] . " " . $_POST['zip'];
    $block_group = do_it_all($this_address, $map);*/
include "../include/dbconnopen.php";
$first_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['first_name']);
$last_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['last_name']);
$address_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['address_name']);
$address_num_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['address_num']);
$address_dir_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['address_dir']);
$address_type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['address_type']);
$city_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['city']);
$state_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['state']);
$zip_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['zip']);
$day_phone_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['day_phone']);
$evening_phone_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['evening_phone']);
$email_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['email']);
$gender_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['gender']);
$grade_level_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['grade_level']);
$ward_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['ward']);
$child_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['child']);
$lang_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['lang']);

    $create_new_participant_query = "INSERT INTO Participants (
                        Name_First,
                        Name_Last,
                        Address_Street_Name,
                        Address_Street_Num,
                        Address_Street_Direction,
                        Address_Street_Type,
                        Address_City,
                        Address_State,
                        Address_Zip,
                        Block_Group,
                        Phone_Day,
                        Phone_Evening,
                        Education_Level,
                        Email,
                        Age,
                        Gender,
                        Date_of_Birth,
                        Grade_Level,
                        Ward,
                        Is_Child
        ) VALUES (
                        '" . $first_name_sqlsafe . "',
                        '" . $last_name_sqlsafe . "',
                        '" . $address_name_sqlsafe . "',
                        '" . $address_num_sqlsafe . "',
                        '" . $address_dir_sqlsafe . "',
                        '" . $address_type_sqlsafe . "',
                        '" . $city_sqlsafe . "',
                        '" . $state_sqlsafe . "',
                        '" . $zip_sqlsafe . "',
                            '$block_group',
                        '" . $day_phone_sqlsafe . "',
                        '" . $evening_phone_sqlsafe . "',
                        '" . $education_level_sqlsafe . "',
                        '" . $email_sqlsafe . "',
                        '" . $age . "',
                        '" . $gender_sqlsafe . "',
                        '" . $save_date . "',
                        '" . $grade_level_sqlsafe . "',
                        '". $ward_sqlsafe ."',
                        '" . $child_sqlsafe . "')";
    mysqli_query($cnnLSNA, $create_new_participant_query);
    $id = mysqli_insert_id($cnnLSNA);
    include "../include/dbconnclose.php";


    /* if they entered a language or multiple languages for this person: */
    if ($_POST['lang'] != '') {
        /* save the languages in the Participants_Languages, which saves multiple languages per person (many-to-many) */
        if ($_POST['lang'] == 'both') {
            $two_languages = "INSERT INTO Participants_Languages (Participant_ID, Language_ID)
            VALUES ($id, '1'), ($id, '2')";
            include "../include/dbconnopen.php";
            mysqli_query($cnnLSNA, $two_languages);
            include "../include/dbconnclose.php";
        } else {
            $one_language = "INSERT INTO Participants_Languages (Participant_ID, Language_ID)
            VALUES ($id, '" . $lang_sqlsafe . "')";
            include "../include/dbconnopen.php";
            mysqli_query($cnnLSNA, $one_language);
            include "../include/dbconnclose.php";
        }
    }

    /* saving roles for new participants: */
    include "../include/dbconnopen.php";
    for ($i = 0; $i < count($_POST['role']); $i++) {
        if ($_POST['role'][$i] != 'undefined') {
            $role_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['role'][$i]);
            $add_role = "INSERT INTO Participants_Roles (Participant_ID, Role_ID) VALUES ('" . $id . "', '" . $role_sqlsafe . "')";
            // echo $add_role . "<br>";
            mysqli_query($cnnLSNA, $add_role);
        }
    }
    include "../include/dbconnclose.php";

    /* adding institution(s) to new participants: */
    include "../include/dbconnopen.php";
    for ($i = 0; $i < count($_POST['insts']); $i++) {
        if ($_POST['insts'][$i] != 'undefined') {
            $insts_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['insts'][$i]);
            $add_role = "INSERT INTO Institutions_Participants (Institution_ID, Participant_ID) VALUES ('" . $insts_sqlsafe . "', '" . $id . "')";
            //echo $add_role . "<br>";
            mysqli_query($cnnLSNA, $add_role);
        }
    }
    include "../include/dbconnclose.php";
    ?>
    <?php if ($_POST['action'] != 'teacher') { ?>
        <span style="color:#990000; font-weight:bold;">Thank you for adding  <?php echo $_POST['first_name'] . " " . $_POST['last_name']; ?> to the database.</span><br/>
        <a href="javascript:;" onclick="
                $.post(
                        '../ajax/set_participant_id.php',
                        {
                            page: 'profile',
                            participant_id: '<?php echo $id; ?>'
                        },
                function(response) {
                    if (response != '1') {
                        document.getElementById('show_error').innerHTML = response;
                    }
                    window.location = '../participants/participant_profile.php';
                }
                );
           ">View profile</a>
        <br/>
        <?php
    } elseif ($_POST['action'] == 'teacher') {
        /* only relevant on the survey(s?) */
        ?> <input type="text" id="new_teacher_name" style="display:none;" value="<?php echo $id; ?>"><?php
    }
}
?>