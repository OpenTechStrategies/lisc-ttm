<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);

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
