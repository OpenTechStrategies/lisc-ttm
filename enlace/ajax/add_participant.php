<?php
/* several participant actions */

/* add a participant to the attendees at an event */
if ($_POST['action'] == 'link_event') {
    $new_event = "INSERT INTO Participants_Events (Participant_ID, Event_ID, Role_Type)
        VALUES ('" . $_POST['participant'] . "', '" . $_POST['event'] . "', '" . $_POST['role'] . "')";
    echo $new_event;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $new_event);
    include "../include/dbconnclose.php";

    
    /* change the role of a participant at an event */
}
    elseif ($_POST['action'] == 'update_role') {
    $update_role = "UPDATE Participants_Events SET Role_Type='" . $_POST['role'] . "' WHERE Participants_Events_ID='" . $_POST['link'] . "'";
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $update_role);
    include "../include/dbconnclose.php";

    /* or just create a new participant altogether */
} else {
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
		'" . $_POST['first_name'] . "',
		'" . $_POST['last_name'] . "',
		'" . $_POST['day_phone'] . "',
		'" . $_POST['evening_phone'] . "',
		'" . $_POST['dob'] . "',
		'" . $_POST['age'] . "',
		'" . $_POST['gender'] . "',
		'" . $_POST['grade'] . "',
		'" . $_POST['school'] . "',
		'" . $_POST['role'] . "'	
	)";
    //echo $add_participant;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $add_participant);
    $id = mysqli_insert_id($cnnEnlace);
    include "../include/dbconnclose.php";
    if ($_POST['action'] == 'link_child') {
        $add_relative = "INSERT INTO Child_Parent (Parent_ID, Child_ID)
                VALUES ('" . $_POST['parent'] . "', '" . $id . "')";
        echo $add_relative;
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $add_relative);
        include "../include/dbconnclose.php";
    }
    if ($_POST['action'] == 'link_parent') {
        $add_relative = "INSERT INTO Child_Parent (Parent_ID, Child_ID)
                VALUES ('" . $id . "', '" . $_POST['child'] . "')";
        echo $add_relative;
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $add_relative);
        include "../include/dbconnclose.php";
    }
        /* add a participant to the people in a program */
    if($_POST['action']=='add_program'){
            $add_person_to_program = "INSERT INTO Participants_Programs (Participant_ID, Program_ID) VALUES (
            '" . $id . "', '" . $_POST['program_id'] . "')";
           // echo $add_person_to_program;
            include "../include/dbconnopen.php";
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
