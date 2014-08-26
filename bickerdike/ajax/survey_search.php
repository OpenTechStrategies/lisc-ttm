<?php
/* if the person has chosen search terms, then include those in the query: */
include "../include/dbconnopen.php";

$type_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$program_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['program']);
$year_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['year']);
$time_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['time']);

if ($_POST['type']==''){$type="";}else{$type= " AND Pre_Responses.Participant_Type='".$_POST['type'] ."' ";}
if ($_POST['program']==''){$program="";}else{$program=" AND Pre_Responses.Program_ID='".$_POST['program']."' ";}
if ($_POST['year']==''){$year="";}else{$year=" AND YEAR(Pre_Responses.Date_Survey_Administered)='".$_POST['year']."' ";}

/* timing changes the nature of the query, because if they search for post, then they want both
 * pre and post results (and the same for followups). */
if ($_POST['time']==''){$timing="";
    $survey_query="SELECT First_Name, Last_Name, Pre_Responses.* FROM Participant_Survey_Responses AS Pre_Responses
        INNER JOIN Users ON Users.User_ID=Pre_Responses.User_ID
        WHERE Participant_Survey_ID IS NOT NULL " . $timing . $type . $program . $year;
}
elseif ($_POST['time']==1){$timing=" AND Pre_Post_Late='".$time_sqlsafe."' ";
    $survey_query="SELECT First_Name, Last_Name, Pre_Responses.* FROM Participant_Survey_Responses AS Pre_Responses
        INNER JOIN Users ON Users.User_ID=Pre_Responses.User_ID
    WHERE Participant_Survey_ID IS NOT NULL " . $timing . $type . $program . $year;
}
elseif($_POST['time']==2){
    $survey_query="SELECT First_Name, Last_Name, Pre_Responses.*, Mid_Responses.*
        FROM Participant_Survey_Responses AS Pre_Responses 
        INNER JOIN Users ON Users.User_ID=Pre_Responses.User_ID
        LEFT JOIN Participant_Survey_Responses AS Mid_Responses ON Pre_Responses.User_ID=Mid_Responses.User_ID    
            WHERE Pre_Responses.Pre_Post_Late=1
            AND Mid_Responses.Pre_Post_Late=2 " . $type . $program . $year;
}
elseif($_POST['time']==3){
    $survey_query="SELECT First_Name, Last_Name, Pre_Responses.*, Mid_Responses.*, Post_Responses.*
        FROM Participant_Survey_Responses AS Pre_Responses 
            INNER JOIN Users ON Users.User_ID=Pre_Responses.User_ID
            LEFT JOIN Participant_Survey_Responses AS Mid_Responses ON Pre_Responses.User_ID=Mid_Responses.User_ID
            LEFT JOIN Participant_Survey_Responses AS Post_Responses ON Pre_Responses.User_ID=Post_Responses.User_ID
            WHERE Pre_Responses.Pre_Post_Late=1
            AND Mid_Responses.Pre_Post_Late=2 
            AND Post_Responses.Pre_Post_Late=3 " . $type . $program . $year;
}

//echo $survey_query;


//echo $survey_query . "<br>";
date_default_timezone_set('America/Chicago');
$infile="../data/downloads/search_surveys_" . date('M-d-Y') . ".csv";
//echo $infile;
$fp=fopen($infile, "w") or die('can\'t open file');
/*get column names for the relevant table: */
$get_col_names="SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='ttm-bickerdike' AND `TABLE_NAME`='Participant_Survey_Responses'";
//echo $get_col_names;
$cols=mysqli_query($cnnBickerdike, $get_col_names);
/*use column names as the headings for the results file: */
$columns=array("First Name", "Last Name");
for ($i=0; $i<$_POST['time']; $i++){
   // echo $i . "<br>";
$cols=mysqli_query($cnnBickerdike, $get_col_names);
while ($col=mysqli_fetch_row($cols)){
    $columns[]=$col[0];
}
}
//print_r($columns);
fputcsv($fp, $columns);
include "../include/dbconnopen.php";
$results=mysqli_query($cnnBickerdike, $survey_query);
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
