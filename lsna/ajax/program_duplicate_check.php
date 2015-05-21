<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
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

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/*check for duplicate program/campaign names: */
include "../include/dbconnopen.php";
$subcategory_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['subcategory']);
$first_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['first_name']);
$last_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['last_name']);
$name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['name']);

/* prevent or warn about events/sessions scheduled on the same date for the same program/campaign: */
if (isset($_POST['date'])){
    //reset date format;
    $reformat_date=explode('-', $_POST['date']);
    $new_date_format=$reformat_date[2] . '-' . $reformat_date[0] . '-' . $reformat_date[1];
    $get_duplicate_dates = "SELECT COUNT(Wright_College_Program_Date_ID) FROM Subcategory_Dates 
        WHERE Subcategory_ID='".$subcategory_sqlsafe."' AND Date='".$new_date_format."'";
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
        WHERE Name_First='".$first_name_sqlsafe."' AND Name_Last='".$last_name_sqlsafe."'";
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
    WHERE Subcategory_Name='" . $name_sqlsafe . "'";
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
