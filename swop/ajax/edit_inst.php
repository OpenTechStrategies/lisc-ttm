<?php
/* make edits to institutions: */

/* IF address has changed, THEN change the block group.  otherwise don't. */
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
include "../include/dbconnopen.php";
$get_existing_address_sqlsafe="SELECT Street_Num, Street_Direction, Street_Name, Street_Type, Block_Group
            FROM Institutions
            WHERE Institution_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";
        $existing_address=mysqli_query($cnnSWOP, $get_existing_address_sqlsafe);
        $address_now=mysqli_fetch_row($existing_address);
        include "../include/dbconnclose.php";
         if ($address_now[0]!=$_POST['num'] || $address_now[1]!=$_POST['dir'] || $address_now[2]!=$_POST['street'] ||
                $address_now[3]!=$_POST['st_type']){
        $this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['street'] . " " .$_POST['st_type'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);
        echo $block_group;
        }
        else{$block_group=$address_now[4]; echo "Same block group";}
        $block_group_sqlsafe=mysqli_real_escape_string($cnnSWOP, $block_group);
        
        /*implement edits.*/
	$edit_inst_sqlsafe = "UPDATE Institutions SET 
					Institution_Name='".mysqli_real_escape_string($cnnSWOP, $_POST['name'])."',
					Street_Num='".mysqli_real_escape_string($cnnSWOP, $_POST['num'])."',
					Street_Direction='".mysqli_real_escape_string($cnnSWOP, $_POST['dir'])."',
					Street_Name='".mysqli_real_escape_string($cnnSWOP, $_POST['street'])."',
					Street_Type='".mysqli_real_escape_string($cnnSWOP, $_POST['st_type'])."',
                                            Block_Group='$block_group_sqlsafe',
					Institution_Type='".mysqli_real_escape_string($cnnSWOP, $_POST['type'])."',
					Phone='".mysqli_real_escape_string($cnnSWOP, $_POST['phone'])."',
					Contact_Person='".mysqli_real_escape_string($cnnSWOP, $_POST['contact'])."'
				WHERE Institution_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";
	include "../include/dbconnopen.php";
	mysqli_query($cnnSWOP, $edit_inst_sqlsafe);
	include "../include/dbconnclose.php";
?>
