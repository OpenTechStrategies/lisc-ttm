<?php
/* save property benchmarks. */

$save_markers="INSERT INTO Property_Progress (Marker, Addtl_Info_1, Addtl_Info_2, Addtl_Info_3, Property_ID) VALUES ('".$_POST['marker']."',
    '" .$_POST['value'] . "', '".$_POST['add_2']."', '".$_POST['add_3']."', '".$_POST['property']."')";
echo $save_markers;

if ($_POST['marker']==8 && $_POST['value']=='Vacant'){
$update_current_status = "UPDATE Properties SET Is_Vacant=1 WHERE Property_ID='".$_POST['property']."'";}
elseif ($_POST['marker']==8 && $_POST['value']=='Not vacant'){
$update_current_status = "UPDATE Properties SET Is_Vacant=0 WHERE Property_ID='".$_POST['property']."'";}
elseif ($_POST['marker']==9 && $_POST['add_2']!=''){
$update_current_status = "UPDATE Properties SET Sale_Price='".$_POST['add_2']."' WHERE Property_ID='".$_POST['property']."'";}


include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $save_markers);
if ($update_current_status!=''){
mysqli_query($cnnSWOP, $update_current_status);}
include "../include/dbconnclose.php";
?>
