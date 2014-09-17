<?php
/* several participant actions */

/* add a participant to the attendees at an event */
if ($_POST['action'] == 'link_event') {
    include "../include/dbconnopen.php";
    $participant_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['participant']);
    $event_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['event']);
    $role_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['role']);
    $new_event = "INSERT INTO Participants_Events (Participant_ID, Event_ID, Role_Type)
        VALUES ('" . $participant_sqlsafe . "', '" . $event_sqlsafe . "', '" . $role_sqlsafe . "')";
    mysqli_query($cnnEnlace, $new_event);
    include "../include/dbconnclose.php";

    
    /* change the role of a participant at an event */
}
    elseif ($_POST['action'] == 'update_role') {
    include "../include/dbconnopen.php";
    $role_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['role']);
    $link_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['link']);
    $update_role = "UPDATE Participants_Events SET Role_Type='" . $role_sqlsafe . "' WHERE Participants_Events_ID='" . $link_sqlsafe . "'";
    mysqli_query($cnnEnlace, $update_role);
    include "../include/dbconnclose.php";

    /* or just create a new participant altogether */
} else {
    include "../include/dbconnopen.php";
    $first_name_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['first_name']);
    $last_name_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['last_name']);
    $day_phone_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['day_phone']);
    $evening_phone_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['evening_phone']);
    $dob_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['dob']);
    $age_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['age']);
    $gender_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['gender']);
    $grade_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['grade']);
    $school_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['school']);
    $role_sqlsafe=  mysqli_real_escape_string($cnnEnlace, $_POST['role']);
    
    $add_participant = "INSERT INTO Participants (
		First_Name,
		Last_Name,
		Day_Phone,
		Evening_Phone,
		DOB,
		Age,
		Gender,
		Grade,
		School,
		Role
	) VALUES (
		'" . $first_name_sqlsafe . "',
		'" . $last_name_sqlsafe . "',
		'" . $day_phone_sqlsafe . "',
		'" . $evening_phone_sqlsafe . "',
		'" . $dob_sqlsafe . "',
		'" . $age_sqlsafe . "',
		'" . $gender_sqlsafe . "',
		'" . $grade_sqlsafe . "',
		'" . $school_sqlsafe . "',
		'" . $role_sqlsafe . "'	
	)";
    mysqli_query($cnnEnlace, $add_participant);
    $id = mysqli_insert_id($cnnEnlace);
    include "../include/dbconnclose.php";
    if ($_POST['action'] == 'link_child') {
        $parent_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['parent']);
        $add_relative = "INSERT INTO Child_Parent (Parent_ID, Child_ID)
                VALUES ('" . $parent_sqlsafe . "', '" . $id . "')";
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $add_relative);
        include "../include/dbconnclose.php";
    }
    if ($_POST['action'] == 'link_parent') {
        $child_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['child']);
        $add_relative = "INSERT INTO Child_Parent (Parent_ID, Child_ID)
                VALUES ('" . $id . "', '" . $child_sqlsafe . "')";
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $add_relative);
        include "../include/dbconnclose.php";
    }
        /* add a participant to the people in a program */
    if($_POST['action']=='add_program'){
            include "../include/dbconnopen.php";
            $program_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program_id']);
            $add_person_to_program = "INSERT INTO Participants_Programs (Participant_ID, Program_ID) VALUES (
            '" . $id . "', '" . $program_id_sqlsafe . "')";
            mysqli_query($cnnEnlace, $add_person_to_program);
            include "../include/dbconnclose.php";
    }
    
    ?>
    <br/><br/>
    <span style="color:#990000; font-weight:bold;">Thank you for adding <?php echo $_POST['first_name'] . " " . $_POST['last_name']; ?> to the database.</span><br/>
    <?php if($_POST['action']=='add_program'){
        ?> <a href="../participants/participant_profile.php?id=<?php echo $id; ?>">View profile</a><?php
    } else{?>
    <a href="participant_profile.php?id=<?php echo $id; ?>">View profile</a>
    <?php }?>
    <br/>
    <?php
}
?>
