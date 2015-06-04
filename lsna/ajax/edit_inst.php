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

user_enforce_has_access($LSNA_id, $DataEntryAccess);

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
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $edit_inst);
include "../include/dbconnclose.php";
?>
