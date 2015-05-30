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

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

/*
 * Allows them to save new baseline data from the Community Wellness Survey, 
 * administered by CLOCC.  This has not been used, but it allows them to track
 * the baseline over time in the same place that they track their own data over time.
 */

include "../include/dbconnopen.php";

$date_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date']);
$fifteen_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['fifteen']);
$twenty_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['twenty']);
$twenty_one_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['twenty_one']);
$twenty_four_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['twenty_four']);
$twenty_nine_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['twenty_nine']);
$thirty_one_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['thirty_one']);
$thirty_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['thirty']);
$thirty_two_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['thirty_two']);
$sixty_nine_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['sixty_nine']);
$seventy_two_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['seventy_two']);
$ninety_one_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['ninety_one']);
$forty_one_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['forty_one_a']);
$forty_one_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['forty_one_b']);
$forty_four_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['forty_four']);

$cws_query_sqlsafe = "INSERT INTO Community_Wellness_Survey_Aggregates(
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
                '" . $date_sqlsafe ."',
                '" . $fifteen_sqlsafe ."',
                '" . $twenty_sqlsafe ."',
                '" . $twenty_one_sqlsafe ."',
                '" . $twenty_four_sqlsafe ."',
                '" . $twenty_nine_sqlsafe ."',
                '" . $thirty_one_sqlsafe ."',
                '" . $thirty_sqlsafe ."',
                '" . $thirty_two_sqlsafe ."',
                '" . $sixty_nine_sqlsafe ."',
                '" . $seventy_two_sqlsafe ."',
                '" . $ninety_one_sqlsafe ."',
                '" . $forty_one_a_sqlsafe ."',
                '" . $forty_one_b_sqlsafe ."',
                '" . $forty_four_sqlsafe ."')";
echo $cws_query_sqlsafe;
mysqli_query($cnnBickerdike, $cws_query_sqlsafe);
include "../include/dbconnclose.php";
?>
