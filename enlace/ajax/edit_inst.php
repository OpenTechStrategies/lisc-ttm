<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, $DataEntryAccess);


/*editing institution*/

/*if address has changed, then the block group must change too*/
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
include "../include/dbconnclose.php";
$inst_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['inst_id']);        
$get_existing_address="SELECT Address_Num, Address_Dir, Address_Street, Address_Street_Type, Block_Group
            FROM Institutions
            WHERE Inst_ID='".$inst_id_sqlsafe."'";
        include "../include/dbconnopen.php";
        $existing_address=mysqli_query($cnnEnlace, $get_existing_address);
        $address_now=mysqli_fetch_row($existing_address);
        if ($address_now[0]!=$_POST['address_num'] || $address_now[1]!=$_POST['address_dir'] || $address_now[2]!=$_POST['address_name'] ||
                $address_now[3]!=$_POST['address_type']){
        $this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['street'] . " " .$_POST['suffix'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);
        echo $block_group;
        }
        else{$block_group=$address_now[7]; echo "Same block group";}

        /*either way, the inst gets updated: */
$type_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['type']);
$num_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['num']);
$dir_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['dir']);
$street_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['street']);
$suffix_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['suffix']);
$point_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['point']);
$phone_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['phone']);
$email_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['email']);

$edit_institution="UPDATE Institutions SET 
    Institution_Type='".$type_sqlsafe."',
    Address_Num='".$num_sqlsafe."',
    Address_Dir='".$dir_sqlsafe."',
    Address_Street='".$street_sqlsafe."',
    Address_Street_Type='".$suffix_sqlsafe."',
        Block_Group='$block_group',
    Point_Person='".$point_sqlsafe."',
    Phone='".$phone_sqlsafe."',
    Email='".$email_sqlsafe."'
        WHERE Inst_ID='".$inst_id_sqlsafe."'";
echo $edit_institution;
include "../include/dbconnopen.php";
mysqli_query($cnnEnlace, $edit_institution);
include "../include/dbconnclose.php";
?>
