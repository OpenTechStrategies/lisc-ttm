<?php
//create random 3-digit ID to link all activity dates



if (isset($_POST['new_org']) && isset($_POST['new_type']) && $_POST['new_org']!='' && $_POST['new_type']!=''){
    $make_org="INSERT INTO Org_Partners (Partner_Name) VALUES ('" . $_POST['new_org'] ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_org);
    $org_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $make_type="INSERT INTO Program_Types (Program_Type_Name) VALUES ('" . $_POST['new_type'] ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_type);
    $type_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
$new_activity_query = "INSERT INTO User_Established_Activities (
                        Activity_Name,
                        Activity_Date,
                        Activity_Type,
                        Activity_Org) VALUES (
                        '". $_POST['name']."',
                        '". $_POST['date']."',
                        '". $type_id ."',
                        '". $org_id."')";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $new_activity_query);
include "../include/dbconnclose.php";
}

elseif (isset($_POST['new_org']) && $_POST['new_org']!=''){
    $make_org="INSERT INTO Org_Partners (Partner_Name) VALUES ('" . $_POST['new_org'] ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_org);
    $org_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $new_activity_query = "INSERT INTO User_Established_Activities (
                        Activity_Name,
                        Activity_Date,
                        Activity_Type,
                        Activity_Org) VALUES (
                        '". $_POST['name']."',
                        '". $_POST['date']."',
                        '". $_POST['type'] ."',
                        '". $org_id."')";
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $new_activity_query);
include "../include/dbconnclose.php";
}

elseif (isset($_POST['new_type']) && $_POST['new_type']!=''){
    $make_type="INSERT INTO Program_Types (Program_Type_Name) VALUES ('" . $_POST['new_type'] ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $make_type);
    $type_id= mysqli_insert_id($cnnBickerdike);
    include "../include/dbconnclose.php";
    $new_activity_query = "INSERT INTO User_Established_Activities (
                            Activity_Name,
                            Activity_Date,
                            Activity_Type,
                            Activity_Org) VALUES (
                            '". $_POST['name']."',
                            '". $_POST['date']."',
                            '". $type_id ."',
                            '". $_POST['org'] ."')";
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
                            '". $_POST['name']."',
                            '". $_POST['date']."',
                            '". $_POST['type'] ."',
                            '". $_POST['org'] ."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $new_activity_query);
    include "../include/dbconnclose.php";
}
?>
