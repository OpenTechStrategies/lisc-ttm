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

user_enforce_has_access($Enlace_id, $DataEntryAccess);

/*delete a survey.  somewhat complicated because all the pieces must be deleted.
 * 
 */

include "../include/dbconnopen.php";
if ($_POST['action']=='personal')
{
    $assessment_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['assessment']);
    $get_surveys="SELECT * FROM Assessments WHERE Assessment_ID='".$assessment_sqlsafe."'";
    $surveys=mysqli_query($cnnEnlace, $get_surveys);
    $surv=mysqli_fetch_row($surveys);
    $delete_caring="DELETE FROM Participants_Caring_Adults WHERE Caring_Adults_Id=$surv[3]";
    $delete_baseline="DELETE FROM Participants_Baseline_Assessments WHERE Baseline_Assessment_ID=$surv[2]";
    $delete_future="DELETE FROM Participants_Future_Expectations WHERE Future_Expectations_ID=$surv[4]";
    $delete_violence="DELETE FROM Participants_Interpersonal_Violence WHERE Interpersonal_Violence_ID=$surv[5]";
    $delete_query="DELETE FROM Assessments WHERE Assessment_ID='" . $assessment_sqlsafe . "'"; 
    mysqli_query($cnnEnlace, $delete_caring);
    mysqli_query($cnnEnlace, $delete_baseline);
    mysqli_query($cnnEnlace, $delete_future);
    mysqli_query($cnnEnlace, $delete_violence);
    mysqli_query($cnnEnlace, $delete_query);
}
/*not complicated to delete a program survey: */
else
{
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['id']);
    $delete_query="DELETE FROM Program_Surveys WHERE Program_Survey_ID='" . $id_sqlsafe . "'";
    mysqli_query($cnnEnlace, $delete_query);
}
include "../include/dbconnclose.php";
?>
