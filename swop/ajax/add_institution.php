<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);

/* calculate institution block group from the address: */
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
$this_address=$_POST['address_num'] . " " .$_POST['address_dir'] . " " .$_POST['address_name'] . " " .$_POST['address_type'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);

include "../include/dbconnopen.php";
$create_new_institution_query_sqlsafe = "INSERT INTO Institutions (
                                    Institution_Name,
                                    Street_Name,
                                    Street_Num,
                                    Street_Direction,
                                    Street_Type,
                                    Block_Group,
                                    Institution_Type,
                                    Phone,
                                    Contact_Person
                                ) VALUES (
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['name']). "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['address_name']). "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['address_num']). "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['address_dir']). "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['address_type']). "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $block_group). "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['type']). "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['phone']). "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['contact']) . "')";
//echo $create_new_institution_query_sqlsafe;

mysqli_query($cnnSWOP, $create_new_institution_query_sqlsafe);
$id = mysqli_insert_id($cnnSWOP);

//connect contact to institution automatically
if ($_POST['contact']!=''){
    $contact_query_sqlsafe="INSERT INTO Institutions_Participants (Institution_ID, Participant_ID) VALUES ($id, '".mysqli_real_escape_string($cnnSWOP, $_POST['contact'])."')";
    mysqli_query($cnnSWOP, $contact_query_sqlsafe);
}

include "../include/dbconnclose.php";

?>

<span style="color:#990000; font-weight:bold;">Thank you for adding  <?echo $_POST['name'] ;?> to the database.</span><br/>
<a href="javascript:;" onclick="
	$.post(
                        '../ajax/set_institution_id.php',
                        {
                            page: 'profile',
                            id:'<?echo $id;?>'
                        },
                        function (response){
//                            if (response!='1'){
//                                document.getElementById('show_error').innerHTML = response;
//                            }
                            window.location='../institutions/inst_profile.php';
                       }
           );
">View profile</a>
<br/>
