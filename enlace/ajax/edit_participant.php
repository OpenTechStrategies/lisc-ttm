<?
/*when editing participant, if the address changes then the block group must change too*/
        include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
	$format_dob = explode('/', $_POST['dob']);
        if ($format_dob[1]!='' && $format_dob[2]!=''){
	$dob = $format_dob[2] . '-' . $format_dob[0] . '-' . $format_dob[1];}
        else{$dob=$_POST['dob'];}
        $get_existing_address="SELECT Address_Num, Address_Dir, Address_Street, Address_Street_Type, Address_City, Address_State, Address_ZIP, Block_Group
            FROM Participants
            WHERE Participant_ID='" . $_POST['id'] . "'";
        include "../include/dbconnopen.php";
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
        echo $block_group;
        }
        else{$block_group=$address_now[7]; echo "Same block group";}
        
	$edit_info = "UPDATE Participants SET 
					First_Name='" . $_POST['name'] . "',
					Last_Name='" . $_POST['surname'] . "',
					Address_Num='" .$_POST['address_num'] . "',
					Address_Dir='" .$_POST['address_dir'] . "',
					Address_Street='" .$_POST['address_name'] . "',
					Address_Street_Type='" .$_POST['address_type'] . "',
					Address_City='" .$_POST['city'] . "',
					Address_State='" .$_POST['state'] . "',
					Address_ZIP='" .$_POST['zip'] . "',
                                            Block_Group='$block_group',
					Day_Phone='" . $_POST['day_phone'] . "',
					Evening_Phone='" . $_POST['eve_phone'] . "',
					Email='" . $_POST['email'] . "',
					DOB='" . $dob . "',
					Age='" . $_POST['age'] . "',
					Gender='" . $_POST['gender'] . "',
					Role='" . $_POST['role'] . "',
                                            Grade='" . $_POST['grade'] . "',
                                            Grade_Entered='".$_POST['grade_entered']."',
                                            School='" . $_POST['school'] . "',
                                            Early_Warning_Absences='" . $_POST['warning_absent'] . "',
                                            Early_Warning_Failed='" . $_POST['warning_failed'] . "',
                                            Early_Warning_Discipline='" . $_POST['warning_discipline'] . "',
                                            Referring_Teacher='" . $_POST['teacher'] . "'
					WHERE Participant_ID='" . $_POST['id'] . "'";
	echo $edit_info;				
	include "../include/dbconnopen.php";
	mysqli_query($cnnEnlace, $edit_info);
	include "../include/dbconnclose.php";
?>