<?php
require_once("../siteconfig.php");
?>
<?php
/* change participant information. */

/* check whether the address changed, and update the block group if it did */
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
include "../include/dbconnopen.php";
$get_existing_address_sqlsafe="SELECT Address_Street_Num, Address_Street_Direction, Address_Street_Name, Address_Street_Type, Address_city, 
    Address_State, Address_Zipcode, Block_Group
            FROM Participants
           WHERE Participant_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
        $existing_address=mysqli_query($cnnTRP, $get_existing_address_sqlsafe);
        $address_now=mysqli_fetch_row($existing_address);
         if ($address_now[0]!=$_POST['address_num'] || $address_now[1]!=$_POST['address_dir'] || $address_now[2]!=$_POST['address_name'] ||
                $address_now[3]!=$_POST['address_type'] || $address_now[4]!=$_POST['city'] || $address_now[5]!=$_POST['state'] || 
                $address_now[6]!=$_POST['zip']){
        $this_address=$_POST['address_num'] . " " .$_POST['address_dir'] . " " .$_POST['address_name'] . " " .$_POST['address_type'] . 
                " " .$_POST['city'] . " " .$_POST['state'] . " " .$_POST['zip'];
        $block_group_sqlsafe=do_it_all($this_address, $map); // result of do_it_all() is automatically SQL-safe.
        echo $block_group_sqlsafe;
        }
        else{$block_group_sqlsafe=$address_now[7]; echo "Same block group";}
$date_formatted=explode('/', $_POST['dob']);
$DOB_sqlsafe = mysqli_real_escape_string($cnnTRP, $date_formatted[2]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[0]) . "-" . mysqli_real_escape_string($cnnTRP, $date_formatted[1]);

/* save the updated info. */
$edit_participant_query_sqlsafe = "UPDATE Participants SET
                                    First_Name='" . mysqli_real_escape_string($cnnTRP, $_POST['name']) . "',
                                    Last_Name='" . mysqli_real_escape_string($cnnTRP, $_POST['surname']) . "',
                                    Address_Street_Name='" . mysqli_real_escape_string($cnnTRP, $_POST['address_name']) . "',
                                    Address_Street_Num='" . mysqli_real_escape_string($cnnTRP, $_POST['address_num']) . "',
                                    Address_Street_Direction='" . mysqli_real_escape_string($cnnTRP, $_POST['address_dir']) . "',
                                    Address_Street_Type='" . mysqli_real_escape_string($cnnTRP, $_POST['address_type']) . "',
                                    Address_City='" . mysqli_real_escape_string($cnnTRP, $_POST['city']) . "',
                                    Address_State='" . mysqli_real_escape_string($cnnTRP, $_POST['state']) . "',
                                    Address_Zipcode= '" . mysqli_real_escape_string($cnnTRP, $_POST['zip']) . "',
                                        Block_Group='$block_group_sqlsafe',
                                    Phone='" . mysqli_real_escape_string($cnnTRP, $_POST['phone']) . "',
                                    Email='" . mysqli_real_escape_string($cnnTRP, $_POST['email']) . "',
                                    Gender='" . mysqli_real_escape_string($cnnTRP, $_POST['gender']) . "',
                                    DOB='" . $DOB_sqlsafe . "',
									CPS_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['cps_id']) . "'
                                        WHERE Participant_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
echo $edit_participant_query_sqlsafe;
mysqli_query($cnnTRP, $edit_participant_query_sqlsafe);
//$id = mysqli_insert_id($cnnTRP);
include "../include/dbconnclose.php";
?>
