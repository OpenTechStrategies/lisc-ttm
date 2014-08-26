<?php
/*edits to people in the DB*/


//format date of birth
//$reformat = explode("/", $_POST['dob']);
//$dob = $reformat[2]."-".$reformat[0]."-".$reformat[1];
if ($_POST['action']=='edit_via_event') {
    include "../include/dbconnopen.php";
        /* edits (either more info or changed info) from an events page/sign-in sheet */
	$participant_changes_sqlsafe = "UPDATE Participants SET
							Phone_Day='" .mysqli_real_escape_string($cnnSWOP, $_POST['day_phone']) . "',
							Phone_Evening='" .mysqli_real_escape_string($cnnSWOP, $_POST['evening_phone']) . "',
							Email='" .mysqli_real_escape_string($cnnSWOP, $_POST['email']) . "'
							WHERE Participant_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['participant'])."'";
	$set_event_role_sqlsafe = "UPDATE Participants_Events SET
							Role_Type='".mysqli_real_escape_string($cnnSWOP, $_POST['role'])."',
                                                            Exceptional='".mysqli_real_escape_string($cnnSWOP, $_POST['ex'])."'
							WHERE Participants_Events_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['participant_event'])."'";
	/* check to see whether the person is already linked to the institution selected as their primary institution. */
    $check_already_connected_sqlsafe="SELECT * FROM Institutions_Participants WHERE Institution_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['inst']) . "'
        AND Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['participant']) . "'";
    echo 'already connected? ' . $check_already_connected_sqlsafe . "<br>";
    
    $add_connection_sqlsafe="INSERT INTO Institutions_Participants (Institution_ID, Participant_Id, Is_Primary, Activity_Type)
        VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['inst']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['participant']) . "',  '1', 6)";
    echo $add_connection_sqlsafe;
mysqli_query($cnnSWOP, $participant_changes_sqlsafe);
mysqli_query($cnnSWOP, $set_event_role_sqlsafe);

/* if they are not already connected, then connect them.  
 * Either way, set this institution to their primary and clear other institutions that had
 * been linked as their primary. */
$check_conn=mysqli_query($cnnSWOP, $check_already_connected_sqlsafe);
$conn_num=  mysqli_num_rows($check_conn);
echo 'number of connections: ' . $conn_num;
if ($conn_num<=0){
    echo ' <br>now connected';
    $clear_other_primaries_sqlsafe="UPDATE Institutions_Participants SET Is_Primary=0 WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['participant']) . "'";
    mysqli_query($cnnSWOP, $clear_other_primaries_sqlsafe);
    mysqli_query($cnnSWOP, $add_connection_sqlsafe);
    $id = mysqli_insert_id($cnnSWOP);}
else{
    echo '<br>already were connected ';
    $id_conn=mysqli_fetch_row($check_conn);
    $id=$id_conn[0];
    $clear_other_primaries_sqlsafe="UPDATE Institutions_Participants SET Is_Primary=0 WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['participant']) . "'";
    mysqli_query($cnnSWOP, $clear_other_primaries_sqlsafe);
    $make_primary_sqlsafe="UPDATE Institutions_Participants SET Is_Primary=1 WHERE Institutions_Participants_ID=$id";
    mysqli_query($cnnSWOP, $make_primary_sqlsafe);
}

include "../include/dbconnclose.php";
	
}
/* edit basic info about person */
else if ($_POST['action']=='basic_info'){
    $edit_basic_sqlsafe = "UPDATE Participants SET 
            Name_First='" . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . "',
            Name_Last='" . mysqli_real_escape_string($cnnSWOP, $_POST['surname']) . "',
            Phone_Day='" . mysqli_real_escape_string($cnnSWOP, $_POST['day_phone']) . "',
            Phone_Evening='" . mysqli_real_escape_string($cnnSWOP, $_POST['evening_phone']) . "',
            Email='" . mysqli_real_escape_string($cnnSWOP, $_POST['email']) . "',
            Gender='" . mysqli_real_escape_string($cnnSWOP, $_POST['gender']) . "',
            Date_of_Birth='" . mysqli_real_escape_string($cnnSWOP, $_POST['dob']) . "',
            Lang_Eng='" . mysqli_real_escape_string($cnnSWOP, $_POST['english']) . "',
            Lang_Span='" . mysqli_real_escape_string($cnnSWOP, $_POST['spanish'])."',
            Lang_Other='" . mysqli_real_escape_string($cnnSWOP, $_POST['other'])."',
            ITIN='" . mysqli_real_escape_string($cnnSWOP, $_POST['code'])."',
            Other_Lang_Specify='" . mysqli_real_escape_string($cnnSWOP, $_POST['other_specify'])."',
            Notes='" . mysqli_real_escape_string($cnnSWOP, $_POST['notes'])."',
            Next_Notes='" . mysqli_real_escape_string($cnnSWOP, $_POST['next_notes'])."',
            Ward='" . mysqli_real_escape_string($cnnSWOP, $_POST['ward'])."',
            Primary_Organizer='" . mysqli_real_escape_string($cnnSWOP, $_POST['primary_org']) ."'
        WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";

    echo $edit_basic_sqlsafe . "<br>";

include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $edit_basic_sqlsafe);


/* edit pool type if it has changed: */
$find_pool_type_sqlsafe = "SELECT Member_Type FROM Pool_Status_Changes INNER JOIN Pool_Member_Types ON Pool_Status_Changes.Member_Type=
            Pool_Member_Types.Type_ID 
            INNER JOIN (SELECT max(Date_Changed) as lastdate FROM Pool_Status_Changes
        WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "' AND Pool_Status_Changes.Active=1) laststatus
        ON Pool_Status_Changes.Date_Changed=laststatus.lastdate 
            WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "' AND Pool_Status_Changes.Active=1";
$current_type = mysqli_query($cnnSWOP, $find_pool_type_sqlsafe);
$old_type = mysqli_fetch_array($current_type);
   if ($old_type['Member_Type'] != $_POST['type']){
        $edit_pool_type_sqlsafe="INSERT INTO Pool_Status_Changes (Active, Participant_ID, Activity_Type, Member_Type) VALUES (1, '" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "', 5, '" . mysqli_real_escape_string($cnnSWOP, $_POST['type']) . "')";
        echo $edit_pool_type_sqlsafe;
        mysqli_query($cnnSWOP, $edit_pool_type_sqlsafe);

    }
include "../include/dbconnclose.php";
	}
?>
