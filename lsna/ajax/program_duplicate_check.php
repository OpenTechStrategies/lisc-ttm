<?php
/*check for duplicate program/campaign names: */

/* prevent or warn about events/sessions scheduled on the same date for the same program/campaign: */
if (isset($_POST['date'])){
    //reset date format;
    $reformat_date=explode('-', $_POST['date']);
    $new_date_format=$reformat_date[2] . '-' . $reformat_date[0] . '-' . $reformat_date[1];
    $get_duplicate_dates = "SELECT COUNT(Wright_College_Program_Date_ID) FROM Subcategory_Dates 
        WHERE Subcategory_ID='".$_POST['subcategory']."' AND Date='".$new_date_format."'";
    //echo $get_duplicate_dates;
    include "../include/dbconnopen.php";
$is_duplicate = mysqli_query($cnnLSNA, $get_duplicate_dates);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'This program/campaign already has an event or session on this date.  Are you sure you want to enter this event on this date?';
}
include "../include/dbconnclose.php";
}
/* warn about a person with the same name already in the DB: */
elseif(isset($_POST['person'])){
    $get_duplicate_dates = "SELECT * FROM Participants 
        WHERE Name_First='".$_POST['first_name']."' AND Name_Last='".$_POST['last_name']."'";
    include "../include/dbconnopen.php";
$is_duplicate = mysqli_query($cnnLSNA, $get_duplicate_dates);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'A person named '. $_POST['first_name']. ' '. $_POST['last_name'].' is already in the database.
        Are you sure you want to enter this participant?';
}
include "../include/dbconnclose.php";
}
/*check program/campaign name before creating a new program/campaign: */
else{
$get_duplicate_programs = "SELECT COUNT(Subcategory_Name) FROM Subcategories
    WHERE Subcategory_Name='" . $_POST['name'] . "'";
//echo $get_duplicate_programs;
include "../include/dbconnopen.php";
$is_duplicate = mysqli_query($cnnLSNA, $get_duplicate_programs);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'A program named ' .  $_POST['name'] . ' is already in the database.  Are you sure you want to enter this program?';
}
include "../include/dbconnclose.php";
}
?>
