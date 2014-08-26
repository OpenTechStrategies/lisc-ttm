<?php
/*edit block group if institution address has changed.*/
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
include "../include/dbconnopen.php";
$inst_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['inst_id']);
$get_existing_address="SELECT Street_Num, Street_Direction, Street_Name, Street_Type, Block_Group
            FROM Institutions
            WHERE Institution_ID='" . $inst_id_sqlsafe . "'";
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
$name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['name']);
$type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['type']);
$str_num_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['str_num']);
$str_dir_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['str_dir']);
$str_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['str_name']);
$str_type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['str_type']);
$edit_inst = "UPDATE Institutions SET
				Institution_Name = '" . $name_sqlsafe . "',
				Institution_Type = '" . $type_sqlsafe . "',
				Street_Num = '" . $str_num_sqlsafe . "',
				Street_Direction = '" . $str_dir_sqlsafe . "',
				Street_Name = '" . $str_name_sqlsafe . "',
				Street_Type = '" . $str_type_sqlsafe . "',
                                    Block_Group='$block_group'
                WHERE Institution_ID='" . $inst_id_sqlsafe . "'";
echo $edit_inst;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $edit_inst);
include "../include/dbconnclose.php";
?>
