<?php
//create random 3-digit ID to link all activity dates

include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['name']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$org_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['org']);
$type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$new_org_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['new_org']);
$new_type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['new_type']);

if (isset($new_org_sqlsafe) && isset($new_type_sqlsafe) && $new_org_sqlsafe !='' && $new_type_sqlsafe!=''){
    $make_org="INSERT INTO Org_Partners (Partner_Name) VALUES ('" . $new_org_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_org);
    $org_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $make_type="INSERT INTO Program_Types (Program_Type_Name) VALUES ('" . $new_type_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_type);
    $type_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
$new_activity_query = "INSERT INTO User_Established_Activities (
                        Activity_Name,
                        Activity_Date,
                        Activity_Type,
                        Activity_Org) VALUES (
                        '". $name_sqlsafe."',
                        '". $date_sqlsafe."',
                        '". $type_id ."',
                        '". $org_id."')";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $new_activity_query);
include "../include/dbconnclose.php";
}

elseif (isset($new_org_sqlsafe) && $new_org_sqlsafe!=''){
    $make_org="INSERT INTO Org_Partners (Partner_Name) VALUES ('" . $new_org_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_org);
    $org_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $new_activity_query = "INSERT INTO User_Established_Activities (
                        Activity_Name,
                        Activity_Date,
                        Activity_Type,
                        Activity_Org) VALUES (
                        '". $name_sqlsafe."',
                        '". $date_sqlsafe."',
                        '". $type_sqlsafe ."',
                        '". $org_id."')";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $new_activity_query);
include "../include/dbconnclose.php";
}

elseif (isset($new_type_sqlsafe) && $new_type_sqlsafe!=''){
    $make_type="INSERT INTO Program_Types (Program_Type_Name) VALUES ('" . $new_type_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_type);
    $type_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $new_activity_query = "INSERT INTO User_Established_Activities (
                            Activity_Name,
                            Activity_Date,
                            Activity_Type,
                            Activity_Org) VALUES (
                            '". $name_sqlsafe."',
                            '". $date_sqlsafe."',
                            '". $type_id ."',
                            '". $org_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $new_activity_query);
    include "../include/dbconnclose.php";
}

else{
    $new_activity_query = "INSERT INTO User_Established_Activities (
                            Activity_Name,
                            Activity_Date,
                            Activity_Type,
                            Activity_Org) VALUES (
                            '". $name_sqlsafe."',
                            '". $date_sqlsafe."',
                            '". $type_sqlsafe ."',
                            '". $org_sqlsafe ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $new_activity_query);
    include "../include/dbconnclose.php";
}
?>
