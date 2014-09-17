<?
/*when editing participant, if the address changes then the block group must change too*/
        include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
        $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
        
	$format_dob = explode('/', $_POST['dob']);
        include "../include/dbconnopen.php";
        if ($format_dob[1]!='' && $format_dob[2]!=''){
	$dob_sqlsafe = $format_dob[2] . '-' . $format_dob[0] . '-' . $format_dob[1];}
        else{$dob_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['dob']);}
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
        else{$block_group=$address_now[7]; echo "Same block group";}
        	
	include "../include/dbconnopen.php";
        $_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['name']);
        $surname_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['surname']);
        $address_num_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_num']);
        $address_dir_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_dir']);
        $address_name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_name']);
        $address_type_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['address_type']);
        $city_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['city']);
        $state_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['state']);
        $zip_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['zip']);
        $day_phone_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['day_phone']);
        $eve_phone_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['eve_phone']);
        $email_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['email']);
        $age_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['age']);
        $gender_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['gender']);
        $role_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['role']);
        $grade_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['grade']);
        $grade_entered_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['grade_entered']);
        $school_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['school']);
        $warning_absent_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['warning_absent']);
        $warning_failed_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['warning_failed']);
        $warning_discipline_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['warning_discipline']);
        $teacher_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['teacher']);
        
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
					Day_Phone='" . $day_phone_sqlsafe . "',
					Evening_Phone='" . $eve_phone_sqlsafe . "',
					Email='" . $email_sqlsafe . "',
					DOB='" . $dob . "',
					Age='" . $age_sqlsafe . "',
					Gender='" . $gender_sqlsafe . "',
					Role='" . $role_sqlsafe . "',
                                            Grade='" . $grade_sqlsafe . "',
                                            Grade_Entered='".$grade_entered_sqlsafe."',
                                            School='" . $school_sqlsafe . "',
                                            Early_Warning_Absences='" . $warning_absent_sqlsafe . "',
                                            Early_Warning_Failed='" . $warning_failed_sqlsafe . "',
                                            Early_Warning_Discipline='" . $warning_discipline_sqlsafe . "',
                                            Referring_Teacher='" . $teacher_sqlsafe . "'
					WHERE Participant_ID='" . $id_sqlsafe . "'";			
	mysqli_query($cnnEnlace, $edit_info);
	include "../include/dbconnclose.php";
?>
