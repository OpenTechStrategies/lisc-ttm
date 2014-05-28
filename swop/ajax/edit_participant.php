<?php
/*edits to people in the DB*/


//format date of birth
//$reformat = explode("/", $_POST['dob']);
//$dob = $reformat[2]."-".$reformat[0]."-".$reformat[1];
if ($_POST['action']=='edit_via_event') {
        /* edits (either more info or changed info) from an events page/sign-in sheet */
	$participant_changes = "UPDATE Participants SET
							Phone_Day='" .$_POST['day_phone'] . "',
							Phone_Evening='" .$_POST['evening_phone'] . "',
							Email='" .$_POST['email'] . "'
							WHERE Participant_ID='".$_POST['participant']."'";
	$set_event_role = "UPDATE Participants_Events SET
							Role_Type='".$_POST['role']."',
                                                            Exceptional='".$_POST['ex']."'
							WHERE Participants_Events_ID='".$_POST['participant_event']."'";
	/* check to see whether the person is already linked to the institution selected as their primary institution. */
    $check_already_connected="SELECT * FROM Institutions_Participants WHERE Institution_ID='" . $_POST['inst'] . "'
        AND Participant_ID='" . $_POST['participant'] . "'";
    echo 'already connected? ' . $check_already_connected . "<br>";
    
    $add_connection="INSERT INTO Institutions_Participants (Institution_ID, Participant_Id, Is_Primary, Activity_Type)
        VALUES ('" . $_POST['inst'] . "', '" . $_POST['participant'] . "',  '1', 6)";
    echo $add_connection;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $participant_changes);
mysqli_query($cnnSWOP, $set_event_role);

/* if they are not already connected, then connect them.  
 * Either way, set this institution to their primary and clear other institutions that had
 * been linked as their primary. */
$check_conn=mysqli_query($cnnSWOP, $check_already_connected);
$conn_num=  mysqli_num_rows($check_conn);
echo 'number of connections: ' . $conn_num;
if ($conn_num<=0){
    echo ' <br>now connected';
    $clear_other_primaries="UPDATE Institutions_Participants SET Is_Primary=0 WHERE Participant_ID='" . $_POST['participant'] . "'";
    mysqli_query($cnnSWOP, $clear_other_primaries);
    mysqli_query($cnnSWOP, $add_connection);
    $id = mysqli_insert_id($cnnSWOP);}
else{
    echo '<br>already were connected ';
    $id_conn=mysqli_fetch_row($check_conn);
    $id=$id_conn[0];
    $clear_other_primaries="UPDATE Institutions_Participants SET Is_Primary=0 WHERE Participant_ID='" . $_POST['participant'] . "'";
    mysqli_query($cnnSWOP, $clear_other_primaries);
    $make_primary="UPDATE Institutions_Participants SET Is_Primary=1 WHERE Institutions_Participants_ID=$id";
    mysqli_query($cnnSWOP, $make_primary);
}

include "../include/dbconnclose.php";
	
}
/* edit basic info about person */
else if ($_POST['action']=='basic_info'){
    $edit_basic = "UPDATE Participants SET 
            Name_First='" .$_POST['name'] . "',
            Name_Last='" .$_POST['surname'] . "',
            Phone_Day='" .$_POST['day_phone'] . "',
            Phone_Evening='" .$_POST['evening_phone'] . "',
            Email='" .$_POST['email'] . "',
            Gender='" .$_POST['gender'] . "',
            Date_of_Birth='" .$_POST['dob'] . "',
            Lang_Eng='" . $_POST['english'] . "',
            Lang_Span='".$_POST['spanish']."',
            Lang_Other='".$_POST['other']."',
            ITIN='".$_POST['code']."',
            Other_Lang_Specify='".$_POST['other_specify']."',
            Notes='".$_POST['notes']."',
            Next_Notes='".$_POST['next_notes']."',
            Ward='".$_POST['ward']."',
            Primary_Organizer='" . $_POST['primary_org'] ."'
        WHERE Participant_ID='" . $_POST['id'] . "'";
    /*ignore this, obsolete since addresses are now saved as properties */
    $add_property="INSERT INTO Participants_Addresses (
        Participant_ID,
        Address_Num,
        Address_Dir,
        Address_Street,
        Street_Type,
        Address_City,
        Address_State,
        Address_Zip) VALUES (
            '".$_POST['id']."',
            '" .$_POST['address_num'] . "',
            '" .$_POST['address_dir'] . "',
            '" .$_POST['address_name'] . "',
            '" .$_POST['address_type'] . "',
            '" .$_POST['city'] . "',
            '" .$_POST['state'] . "',
            '" .$_POST['zip'] . "')";
    echo $edit_basic . "<br>";
    echo $add_property;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $edit_basic);
//mysqli_query($cnnSWOP, $add_property);

/* edit pool type if it has changed: */
$find_pool_type = "SELECT Member_Type FROM Pool_Status_Changes INNER JOIN Pool_Member_Types ON Pool_Status_Changes.Member_Type=
            Pool_Member_Types.Type_ID 
            INNER JOIN (SELECT max(Date_Changed) as lastdate FROM Pool_Status_Changes
        WHERE Participant_ID='" . $_POST['id'] . "' AND Pool_Status_Changes.Active=1) laststatus
        ON Pool_Status_Changes.Date_Changed=laststatus.lastdate 
            WHERE Participant_ID='" . $_POST['id'] . "' AND Pool_Status_Changes.Active=1";
$current_type = mysqli_query($cnnSWOP, $find_pool_type);
$old_type = mysqli_fetch_array($current_type);
   if ($old_type['Member_Type'] != $_POST['type']){
        $edit_pool_type="INSERT INTO Pool_Status_Changes (Active, Participant_ID, Activity_Type, Member_Type) VALUES (1, '".$_POST['id']."', 5, '".$_POST['type']."')";
        echo $edit_pool_type;
        mysqli_query($cnnSWOP, $edit_pool_type);

    }
include "../include/dbconnclose.php";
	}
?>
