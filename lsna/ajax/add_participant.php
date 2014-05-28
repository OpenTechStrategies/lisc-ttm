<?php
if ($_POST['add_to_parent'] == 1) {
    /* adding a parent/child link where the initializing participant is the parent and the child needs to be added
     * to the database.
     */
    include "../include/dbconnopen.php";
    $insert_person = "INSERT INTO Participants (Name_First, Name_Last) VALUES ('" . $_POST['first_name'] . "', '" . $_POST['last_name'] . "')";
    echo $insert_person;
    mysqli_query($cnnLSNA, $insert_person);
    $id = mysqli_insert_id($cnnLSNA);
    $add_family = "INSERT INTO Parent_Mentor_Children (Parent_ID, Child_ID) VALUES ('" . $_POST['parent'] . "', '" . $id . "')";
    echo $add_family;
    mysqli_query($cnnLSNA, $add_family);
    include "../include/dbconnclose.php";
} else if ($_POST['add_to_child'] == 1) {
    /* adding a parent/child link where the initializing participant is the child and the parent needs to be added
     * to the database.
     */
    include "../include/dbconnopen.php";
    $insert_person = "INSERT INTO Participants (Name_First, Name_Last) VALUES ('" . $_POST['first_name'] . "', '" . $_POST['last_name'] . "')";
    mysqli_query($cnnLSNA, $insert_person);
    $id = mysqli_insert_id($cnnLSNA);
    $add_family = "INSERT INTO Parent_Mentor_Children (Parent_ID, Child_ID) VALUES ('" . $id . "', '" . $_POST['child'] . "')";
    mysqli_query($cnnLSNA, $add_family);
    include "../include/dbconnclose.php";
} else if ($_POST['add_to_spouse'] == 1) {
    /* adding a person/spouse link where spouse is not yet in 
     * the database.
     */
    include "../include/dbconnopen.php";
    $insert_person = "INSERT INTO Participants (Name_First, Name_Last) VALUES ('" . $_POST['first_name'] . "', '" . $_POST['last_name'] . "')";
    mysqli_query($cnnLSNA, $insert_person);
    $id = mysqli_insert_id($cnnLSNA);
    $add_family = "INSERT INTO Parent_Mentor_Children (Parent_ID, Spouse_ID) VALUES ('" .$_POST['person']  . "', '" . $id . "')";
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
                        '" . $_POST['first_name'] . "',
                        '" . $_POST['last_name'] . "',
                        '" . $_POST['address_name'] . "',
                        '" . $_POST['address_num'] . "',
                        '" . $_POST['address_dir'] . "',
                        '" . $_POST['address_type'] . "',
                        '" . $_POST['city'] . "',
                        '" . $_POST['state'] . "',
                        '" . $_POST['zip'] . "',
                            '$block_group',
                        '" . $_POST['day_phone'] . "',
                        '" . $_POST['evening_phone'] . "',
                        '" . $_POST['education_level'] . "',
                        '" . $_POST['email'] . "',
                        '" . $age . "',
                        '" . $_POST['gender'] . "',
                        '" . $save_date . "',
                        '" . $_POST['grade_level'] . "',
                        '". $_POST['ward'] ."',
                        '" . $_POST['child'] . "')";
    include "../include/dbconnopen.php";
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
            VALUES ($id, '" . $_POST['lang'] . "')";
            include "../include/dbconnopen.php";
            mysqli_query($cnnLSNA, $one_language);
            include "../include/dbconnclose.php";
        }
    }

    /* saving roles for new participants: */
    include "../include/dbconnopen.php";
    for ($i = 0; $i < count($_POST['role']); $i++) {
        if ($_POST['role'][$i] != 'undefined') {
            $add_role = "INSERT INTO Participants_Roles (Participant_ID, Role_ID) VALUES ('" . $id . "', '" . $_POST['role'][$i] . "')";
            // echo $add_role . "<br>";
            mysqli_query($cnnLSNA, $add_role);
        }
    }
    include "../include/dbconnclose.php";

    /* adding institution(s) to new participants: */
    include "../include/dbconnopen.php";
    for ($i = 0; $i < count($_POST['insts']); $i++) {
        if ($_POST['insts'][$i] != 'undefined') {
            $add_role = "INSERT INTO Institutions_Participants (Institution_ID, Participant_ID) VALUES ('" . $_POST['insts'][$i] . "', '" . $id . "')";
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