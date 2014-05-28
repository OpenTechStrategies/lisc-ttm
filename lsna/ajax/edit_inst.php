<?php
/*edit block group if institution address has changed.*/
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
$get_existing_address="SELECT Street_Num, Street_Direction, Street_Name, Street_Type, Block_Group
            FROM Institutions
            WHERE Institution_ID='" . $_POST['inst_id'] . "'";
        include "../include/dbconnopen.php";
        $existing_address=mysqli_query($cnnLSNA, $get_existing_address);
        $address_now=mysqli_fetch_row($existing_address);
        include "../include/dbconnclose.php";
         if ($address_now[0]!=$_POST['address_num'] || $address_now[1]!=$_POST['address_dir'] || $address_now[2]!=$_POST['address_name'] ||
                $address_now[3]!=$_POST['address_type'] || $address_now[4]!=$_POST['city'] || $address_now[5]!=$_POST['state'] || 
                $address_now[6]!=$_POST['zip']){
        $this_address=$_POST['address_num'] . " " .$_POST['address_dir'] . " " .$_POST['address_name'] . " " .$_POST['address_type'] . 
                " " .$_POST['city'] . " " .$_POST['state'] . " " .$_POST['zip'];
        $block_group=do_it_all($this_address, $map);
        echo $block_group;
        }
        else{$block_group=$address_now[4]; echo "Same block group";}
        
        /*any institution edits are saved here: */
$edit_inst = "UPDATE Institutions SET
				Institution_Name = '" . $_POST['name'] . "',
				Institution_Type = '" . $_POST['type'] . "',
				Street_Num = '" . $_POST['str_num'] . "',
				Street_Direction = '" . $_POST['str_dir'] . "',
				Street_Name = '" . $_POST['str_name'] . "',
				Street_Type = '" . $_POST['str_type'] . "',
                                    Block_Group='$block_group'
                WHERE Institution_ID='" . $_POST['inst_id'] . "'";
echo $edit_inst;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $edit_inst);
include "../include/dbconnclose.php";
?>
