<?php
/* obsolete. we now use progress activity. */

if ($_POST['marker']=='vacant') {
	$marker_field = "Is_Vacant";
}


/*$add_new_marker = "INSERT INTO Property_Markers (Is_Vacant,
    Is_Secured_Boarded,
    Is_Unsecured,
    Is_Open,
    Code_Violations,
    For_Sale,
    Price,
    Owner_Occupied,
    Absentee_Landlord,
    Property_Condition,
    Financial_Institution,
    Second_Mortgage,
    Owner,
    Type,
    Property_ID) VALUES (
    '". $_POST['vacant'] ."',
    '". $_POST['secured'] ."',
    '". $_POST['unsecured'] ."',
    '". $_POST['open'] ."',
    '". $_POST['code'] ."',
    '". $_POST['sale'] ."',
    '". $_POST['price'] ."',
    '". $_POST['owner_occ'] ."',
    '". $_POST['absentee'] ."',
   '". $_POST['condition'] ."',
   '". $_POST['bank'] ."',
   '". $_POST['second'] ."',
   '". $_POST['owner'] ."',
   '". $_POST['type'] ."',
   '". $_POST['id'] ."'
    )";
echo $add_new_marker;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $add_new_marker);
include "../include/dbconnclose.php";*/
?>
