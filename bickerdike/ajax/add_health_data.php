<?php

/*
 * Add new personal health record.
 */

/*
 * Users have the option to enter BMI (as in the case of children, where the calculation is different)
 * or have the BMI calculated.  This determines whether the BMI has been entered (!='')
 * or needs to be calculated, then calculates it if necessary.
 */
if ($_POST['bmi']==''){
$bmi = round((($_POST['weight'])/(($_POST['height'])*($_POST['height'])))*703, 1);}
else{
    $bmi = $_POST['bmi'];
}

/*
 * Since height is entered in all inches and saved as inches and feet separately (not sure
 * why), this calculates the feet and inches pieces of the entered height.
 */

$height_feet = (int) ($_POST['height']/12);
//echo $height_feet;
$height_inches = ($_POST['height'])%12;
//echo $height_inches;

/*
 * 
 * Add new health data to the database.
 */
 

$user_count = "SELECT * FROM User_Health_Data WHERE User_ID='" . $_POST['user'] ."'";
echo $user_count;
include "../include/dbconnopen.php";
$num_times_user_measured = mysqli_query($cnnBickerdike, $user_count);
$count = mysqli_num_rows($num_times_user_measured);
include "../include/dbconnclose.php";

$added_count = $count+1;
/*
 * $added_count seems to be keeping track of the number of times a user has been weighed/measured
 * and added into the system, but I have no idea why.
 */

$add_health = "INSERT INTO User_Health_Data (
                User_ID,
                Height_Feet,
                Height_Inches,
                Weight,
                BMI,
                Date,
                User_Count) VALUES (
                '" . $_POST['user'] ."',
                '" . $height_feet ."',
                '" . $height_inches ."',
                '" . $_POST['weight'] ."',
                '" . $bmi ."',
                '" . $_POST['date'] ."',
                    $added_count
                )";

include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $add_health);
include "../include/dbconnclose.php";
?>
