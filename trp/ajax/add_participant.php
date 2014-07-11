<?php
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
