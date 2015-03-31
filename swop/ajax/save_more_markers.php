<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);

/* save property benchmarks. */
include "../include/dbconnopen.php";

$save_markers_sqlsafe="INSERT INTO Property_Progress (Marker, Addtl_Info_1, Addtl_Info_2, Addtl_Info_3, Property_ID) VALUES ('".mysqli_real_escape_string($cnnSWOP, $_POST['marker'])."',
    '" .mysqli_real_escape_string($cnnSWOP, $_POST['value']) . "', '".mysqli_real_escape_string($cnnSWOP, $_POST['add_2'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['add_3'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."')";
echo $save_markers_sqlsafe;

if ($_POST['marker']==8 && $_POST['value']=='Vacant'){
$update_current_status_sqlsafe = "UPDATE Properties SET Is_Vacant=1 WHERE Property_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."'";}
elseif ($_POST['marker']==8 && $_POST['value']=='Not vacant'){
$update_current_status_sqlsafe = "UPDATE Properties SET Is_Vacant=0 WHERE Property_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."'";}
elseif ($_POST['marker']==9 && $_POST['add_2']!=''){
$update_current_status_sqlsafe = "UPDATE Properties SET Sale_Price='".mysqli_real_escape_string($cnnSWOP, $_POST['add_2'])."' WHERE Property_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['property'])."'";}


mysqli_query($cnnSWOP, $save_markers_sqlsafe);
if ($update_current_status_sqlsafe!=''){
mysqli_query($cnnSWOP, $update_current_status_sqlsafe);}
include "../include/dbconnclose.php";
?>
