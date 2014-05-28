<?php
/* create a new profile for a person.  get their block group and save it according to their address. */
include ($_SERVER['DOCUMENT_ROOT'] . "/include/block_group_finder.php");
$this_address = $_POST['address_num'] . " " . $_POST['address_dir'] . " " . $_POST['address_name'] . " " . $_POST['address_type'] .
        " " . $_POST['city'] . " " . $_POST['state'] . " " . $_POST['zip'];
$block_group = do_it_all($this_address, $map);

//format date of birth (DOB)
$dob_formatted = explode('/', $_POST['dob']);
$dob_formatted = $dob_formatted[2] . "-" . $dob_formatted[0] . "-" . $dob_formatted[1];

$create_new_participant_query = "INSERT INTO Participants (
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
                                    '" . $_POST['email'] . "',
                                    '" . $_POST['gender'] . "',
                                    '" . $dob_formatted . "',
                                    '" . $_POST['race'] . "',    
                                    '" . $_POST['grade'] . "',
                                    '" . $_POST['classroom'] . "',
                                    '" . $_POST['lunch'] . "')";

//echo $create_new_participant_query;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $create_new_participant_query);
$id = mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>

<span style="color:#990000; font-weight:bold;font-size:.9em;margin-left:auto;margin-right:auto;">Thank you for adding <?php echo $_POST['first_name'] . " " . $_POST['last_name'];?> to the database.</span><br/>
<a href="profile.php?id=<?php echo $id;?>" >View profile</a>
<br/>
