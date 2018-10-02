<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *   Copyright (C) 2018 Open Tech Strategies, LLC
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

/*create a new institution*/
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
$this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['street'] . " " .$_POST['suff'] . 
                " Chicago IL";

include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['name']);
$type_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['type']);
$num_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['num']);
$dir_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['dir']);
$street_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['street']);
$suff_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['suff']);
$person_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['person']);
$phone_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['phone']);
$email_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['email']);

/*also get its block group, so that we can add it to the DB*/
        $block_group=do_it_all($this_address, $map);
$new_inst="INSERT INTO Institutions (Institution_Name, Institution_Type, Address_Num, Address_Dir, Address_Street,
    Address_Street_Type, Block_Group, Point_Person, Phone, Email) VALUES 
    ('".$name_sqlsafe."',
    '".$type_sqlsafe."',
    '".$num_sqlsafe."',
    '".$dir_sqlsafe."',
    '".$street_sqlsafe."',
    '".$suff_sqlsafe."',
        '$block_group',
    '".$person_sqlsafe."',
    '".$phone_sqlsafe."',
    '".$email_sqlsafe."'
    )";
mysqli_query($cnnEnlace, $new_inst);
$id=mysqli_insert_id($cnnEnlace);
include "../include/dbconnclose.php";
?>
<span style="color:#990000; font-weight:bold;">Thank you for adding  <?php echo $_POST['name'];?> to the database.</span><br/>
<a href="inst_profile.php?inst=<?php echo $id;?>">View profile</a>
