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

user_enforce_has_access($Enlace_id, $DataEntryAccess);


/*editing institution*/

/*if address has changed, then the block group must change too*/
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
include "../include/dbconnopen.php";
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
