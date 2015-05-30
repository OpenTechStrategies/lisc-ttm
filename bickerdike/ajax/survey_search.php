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

/* if the person has chosen search terms, then include those in the query: */
include "../include/dbconnopen.php";

$type_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$program_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['program']);
$year_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['year']);
$time_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['time']);

if ($_POST['type']==''){$type_sqlsafe="";}else{$type_sqlsafe= " AND Pre_Responses.Participant_Type='" . $type_sqlsafe . "' ";}
if ($_POST['program']==''){$program_sqlsafe="";}else{$program_sqlsafe=" AND Pre_Responses.Program_ID='" . $program_sqlsafe . "' ";}
if ($_POST['year']==''){$year_sqlsafe="";}else{$year_sqlsafe=" AND YEAR(Pre_Responses.Date_Survey_Administered)='" . $year_sqlsafe . "' ";}

/* timing changes the nature of the query, because if they search for post, then they want both
 * pre and post results (and the same for followups). */
if ($_POST['time']==''){$timing_sqlsafe="";
    $survey_query_sqlsafe="SELECT First_Name, Last_Name, Pre_Responses.* FROM Participant_Survey_Responses AS Pre_Responses
        INNER JOIN Users ON Users.User_ID=Pre_Responses.User_ID
        WHERE Participant_Survey_ID IS NOT NULL " . $timing_sqlsafe . $type_sqlsafe . $program_sqlsafe . $year_sqlsafe;
}
elseif ($_POST['time']==1){$timing_sqlsafe=" AND Pre_Post_Late='".$time_sqlsafe."' ";
    $survey_query_sqlsafe="SELECT First_Name, Last_Name, Pre_Responses.* FROM Participant_Survey_Responses AS Pre_Responses
        INNER JOIN Users ON Users.User_ID=Pre_Responses.User_ID
    WHERE Participant_Survey_ID IS NOT NULL " . $timing_sqlsafe . $type_sqlsafe . $program_sqlsafe . $year_sqlsafe;
}
elseif($_POST['time']==2){
    $survey_query_sqlsafe="SELECT First_Name, Last_Name, Pre_Responses.*, Mid_Responses.*
        FROM Participant_Survey_Responses AS Pre_Responses 
        INNER JOIN Users ON Users.User_ID=Pre_Responses.User_ID
        LEFT JOIN Participant_Survey_Responses AS Mid_Responses ON Pre_Responses.User_ID=Mid_Responses.User_ID    
            WHERE Pre_Responses.Pre_Post_Late=1
            AND Mid_Responses.Pre_Post_Late=2 " . $type_sqlsafe . $program_sqlsafe . $year_sqlsafe;
}
elseif($_POST['time']==3){
    $survey_query_sqlsafe="SELECT First_Name, Last_Name, Pre_Responses.*, Mid_Responses.*, Post_Responses.*
        FROM Participant_Survey_Responses AS Pre_Responses 
            INNER JOIN Users ON Users.User_ID=Pre_Responses.User_ID
            LEFT JOIN Participant_Survey_Responses AS Mid_Responses ON Pre_Responses.User_ID=Mid_Responses.User_ID
            LEFT JOIN Participant_Survey_Responses AS Post_Responses ON Pre_Responses.User_ID=Post_Responses.User_ID
            WHERE Pre_Responses.Pre_Post_Late=1
            AND Mid_Responses.Pre_Post_Late=2 
            AND Post_Responses.Pre_Post_Late=3 " . $type_sqlsafe . $program_sqlsafe . $year_sqlsafe;
}
date_default_timezone_set('America/Chicago');
$infile="../data/downloads/search_surveys_" . date('M-d-Y') . ".csv";

$fp=fopen($infile, "w") or die('can\'t open file');
/*get column names for the relevant table: */
$get_col_names_sqlsafe="SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='ttm-bickerdike' AND `TABLE_NAME`='Participant_Survey_Responses'";
//echo $get_col_names;
$cols=mysqli_query($cnnBickerdike, $get_col_names_sqlsafe);

/*use column names as the headings for the results file: */
$columns=array("First Name", "Last Name");
for ($i=0; $i<$_POST['time']; $i++){
$cols=mysqli_query($cnnBickerdike, $get_col_names_sqlsafe);
while ($col=mysqli_fetch_row($cols)){
    $columns[]=$col[0];
}
}
fputcsv($fp, $columns);
include "../include/dbconnopen.php";
$results=mysqli_query($cnnBickerdike, $survey_query_sqlsafe);
$num_results=mysqli_num_rows($results);
echo $num_results . " surveys found.<br>";
while ($survey=mysqli_fetch_row($results)){
     fputcsv ($fp, $survey);
}
fclose($fp);
include "../include/dbconnclose.php";

?>
<!--//show number of surveys found
//download results-->

<a href="<?echo $infile;?>">Download Results</a>
