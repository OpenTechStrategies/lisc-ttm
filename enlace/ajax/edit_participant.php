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

/*when editing participant, if the address changes then the block group must change too*/
        include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
        include "../include/dbconnopen.php";
        $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
        
	$format_dob = explode('/', $_POST['dob']);
        if ($format_dob[1]!='' && $format_dob[2]!=''){
	$dob_sqlsafe = $format_dob[2] . '-' . $format_dob[0] . '-' . $format_dob[1];}
        else{
            $dob_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['dob']);
        }
        $get_existing_address="SELECT Address_Num, Address_Dir, Address_Street, Address_Street_Type, Address_City, Address_State, Address_ZIP, Block_Group
            FROM Participants
            WHERE Participant_ID='" . $id_sqlsafe . "'";
        $existing_address=mysqli_query($cnnEnlace, $get_existing_address);
        $address_now=mysqli_fetch_row($existing_address);
        include "../include/dbconnclose.php";
        /*check for address changes*/
        if ($address_now[0]!=$_POST['address_num'] || $address_now[1]!=$_POST['address_dir'] || $address_now[2]!=$_POST['address_name'] ||
                $address_now[3]!=$_POST['address_type'] || $address_now[4]!=$_POST['city'] || $address_now[5]!=$_POST['state'] || 
                $address_now[6]!=$_POST['zip']){
        $this_address=$_POST['address_num'] . " " .$_POST['address_dir'] . " " .$_POST['address_name'] . " " .$_POST['address_type'] . 
                " " .$_POST['city'] . " " .$_POST['state'] . " " .$_POST['zip'];
        $block_group=do_it_all($this_address, $map);
        }
        else{$block_group=$address_now[7]; }
        	
	include "../include/dbconnopen.php";
        $name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['name']);
        $surname_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['surname']);
        $address_num_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_num']);
        $address_dir_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_dir']);
        $address_name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_name']);
        $address_type_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_type']);
        $city_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['city']);
        $state_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['state']);
        $zip_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['zip']);
        $age_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['age']);
        $gender_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['gender']);
        $role_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['role']);
        $grade_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['grade']);
        $grade_entered_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['grade_entered']);
        $school_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['school']);
        $recruitment_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['recruitment']);
        $youth_behavioral_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['youth_behavioral']);
        
	$edit_info = "UPDATE Participants SET 
					First_Name='" . $name_sqlsafe . "',
					Last_Name='" . $surname_sqlsafe . "',
					Address_Num='" .$address_num_sqlsafe . "',
					Address_Dir='" .$address_dir_sqlsafe . "',
					Address_Street='" .$address_name_sqlsafe . "',
					Address_Street_Type='" .$address_type_sqlsafe . "',
					Address_City='" .$city_sqlsafe . "',
					Address_State='" .$state_sqlsafe . "',
					Address_ZIP='" .$zip_sqlsafe . "',
                                            Block_Group='$block_group',
					DOB='" . $dob_sqlsafe . "',
					Age='" . $age_sqlsafe . "',
					Gender='" . $gender_sqlsafe . "',
					Recruitment='" . $recruitment_sqlsafe . "',
					Youth_Behavioral='" . $youth_behavioral_sqlsafe . "',
					Role='" . $role_sqlsafe . "',
                                            Grade='" . $grade_sqlsafe . "',
                                            Grade_Entered='".$grade_entered_sqlsafe."',
                                            School='" . $school_sqlsafe . "'
					WHERE Participant_ID='" . $id_sqlsafe . "'";			
	mysqli_query($cnnEnlace, $edit_info);
	include "../include/dbconnclose.php";
?>
