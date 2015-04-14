<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

/*
 * Add new personal health record.
 */

/*
 * Users have the option to enter BMI (as in the case of children, where the calculation is different)
 * or have the BMI calculated.  This determines whether the BMI has been entered (!='')
 * or needs to be calculated, then calculates it if necessary.
 */
include "../include/dbconnopen.php";
if ($_POST['bmi']==''){
$bmi_sqlsafe = round((intval($_POST['weight'])/(intval($_POST['height'])*intval($_POST['height'])))*703, 1);}
else{
    $bmi = $_POST['bmi'];
    $bmi_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['bmi']);
}
/*
 * Since height is entered in all inches and saved as inches and feet separately (not sure
 * why), this calculates the feet and inches pieces of the entered height.
 */

$height_feet_sqlsafe = (int) ($_POST['height']/12);
$height_inches_sqlsafe = (int)(($_POST['height'])%12);

/*
 * 
 * Add new health data to the database.
 */
 
$user_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['user']);
$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$weight_sqlsafe=intval($_POST['weight']);
$user_count_sqlsafe = "SELECT * FROM User_Health_Data WHERE User_ID='" . $user_sqlsafe ."'";
$num_times_user_measured = mysqli_query($cnnBickerdike, $user_count_sqlsafe);
$count = mysqli_num_rows($num_times_user_measured);

$added_count_sqlsafe = $count+1;
/*
 * $added_count_sqlsafe seems to be keeping track of the number of times a user has been weighed/measured
 * and added into the system, but I have no idea why.
 */

$add_health_sqlsafe = "INSERT INTO User_Health_Data (
                User_ID,
                Height_Feet,
                Height_Inches,
                Weight,
                BMI,
                Date,
                User_Count) VALUES (
                '" . $user_sqlsafe ."',
                '" . $height_feet_sqlsafe ."',
                '" . $height_inches_sqlsafe ."',
                '" . $weight_sqlsafe ."',
                '" . $bmi_sqlsafe ."',
                '" . $date_sqlsafe ."',
                    $added_count_sqlsafe
                )";
mysqli_query($cnnBickerdike, $add_health_sqlsafe);
include "../include/dbconnclose.php";
?>
