<?php
/*editing institution*/

/*if address has changed, then the block group must change too*/
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
$get_existing_address="SELECT Address_Num, Address_Dir, Address_Street, Address_Street_Type, Block_Group
            FROM Institutions
            WHERE Inst_ID='".$_POST['inst_id']."'";
        include "../include/dbconnopen.php";
        $existing_address=mysqli_query($cnnEnlace, $get_existing_address);
        $address_now=mysqli_fetch_row($existing_address);
        include "../include/dbconnclose.php";
        if ($address_now[0]!=$_POST['address_num'] || $address_now[1]!=$_POST['address_dir'] || $address_now[2]!=$_POST['address_name'] ||
                $address_now[3]!=$_POST['address_type']){
        $this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['street'] . " " .$_POST['suffix'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);
        echo $block_group;
        }
        else{$block_group=$address_now[7]; echo "Same block group";}

        /*either way, the inst gets updated: */
$edit_institution="UPDATE Institutions SET 
    Institution_Type='".$_POST['type']."',
    Address_Num='".$_POST['num']."',
    Address_Dir='".$_POST['dir']."',
    Address_Street='".$_POST['street']."',
    Address_Street_Type='".$_POST['suffix']."',
        Block_Group='$block_group',
    Point_Person='".$_POST['point']."',
    Phone='".$_POST['phone']."',
    Email='".$_POST['email']."'
        WHERE Inst_ID='".$_POST['inst_id']."'";
echo $edit_institution;
include "../include/dbconnopen.php";
mysqli_query($cnnEnlace, $edit_institution);
include "../include/dbconnclose.php";
?>
