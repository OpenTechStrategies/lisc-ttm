<?php
/*
 * Allows them to save new baseline data from the Community Wellness Survey, 
 * administered by CLOCC.  This has not been used, but it allows them to track
 * the baseline over time in the same place that they track their own data over time.
 */

$cws_query = "INSERT INTO Community_Wellness_Survey_Aggregates(
                Date_Administered,
                Question_15_CWS,
                Question_20_CWS,
                Question_21_CWS,
                Question_24_CWS,
                Question_29_CWS,
                Question_31_CWS,
                Question_30_CWS,
                Question_32_CWS,
                Question_69_CWS,
                Question_72_CWS,
                Question_91_CWS,
                Question_41_a_CWS,
                Question_41_b_CWS,
                Question_44_CWS)
                VALUES (
                '" . $_POST['date'] ."',
                '" . $_POST['fifteen'] ."',
                '" . $_POST['twenty'] ."',
                '" . $_POST['twenty_one'] ."',
                '" . $_POST['twenty_four'] ."',
                '" . $_POST['twenty_nine'] ."',
                '" . $_POST['thirty_one'] ."',
                '" . $_POST['thirty'] ."',
                '" . $_POST['thirty_two'] ."',
                '" . $_POST['sixty_nine'] ."',
                '" . $_POST['seventy_two'] ."',
                '" . $_POST['ninety_one'] ."',
                '" . $_POST['forty_one_a'] ."',
                '" . $_POST['forty_one_b'] ."',
                '" . $_POST['forty_four'] ."')";
echo $cws_query;
include "../include/dbconnopen.php";
mysqli_query($cnnBickerdike, $cws_query);
include "../include/dbconnclose.php";
?>
