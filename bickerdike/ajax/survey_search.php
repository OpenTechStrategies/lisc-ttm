<?php
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

//echo $survey_query_sqlsafe;


//echo $survey_query_sqlsafe . "<br>";
date_default_timezone_set('America/Chicago');
$infile="../data/downloads/search_surveys_" . date('M-d-Y') . ".csv";
//echo $infile;
$fp=fopen($infile, "w") or die('can\'t open file');
/*get column names for the relevant table: */
$get_col_names_sqlsafe="SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='lisc-bickerdike.chapinhall.org' AND `TABLE_NAME`='Participant_Survey_Responses'";
/*production:*/
  $get_col_names_sqlsafe="SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='liscttm-bickerdike.chapinhall.org' AND `TABLE_NAME`='Participant_Survey_Responses'";

//echo $get_col_names_sqlsafe;
$cols=mysqli_query($cnnBickerdike, $get_col_names_sqlsafe);
/*use column names as the headings for the results file: */
$columns=array("First Name", "Last Name");
for ($i=0; $i<$_POST['time']; $i++){
   // echo $i . "<br>";
$cols=mysqli_query($cnnBickerdike, $get_col_names_sqlsafe);
while ($col=mysqli_fetch_row($cols)){
    $columns[]=$col[0];
}
}
//print_r($columns);
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
