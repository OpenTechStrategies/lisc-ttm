<?php
if ($_POST['action']=='search'){
    include "../include/dbconnopen.php";
    $issue_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue']);
    $issue_month_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue_month']);
    $issue_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue_year']);
    if ($_POST['issue']!=''){ $issue=" AND Issue_Attendance.Issue_ID='".$_POST['issue']."'";}
    if ($_POST['issue_month']!=''){ $month=" AND Month='".$_POST['issue_month']."'";}
    if ($_POST['issue_year']!=''){ $year=" AND Year='".$_POST['issue_year']."'";}
    
    $query="SELECT Name_First, Name_Last, Phone_Day, Phone_Evening, 
            Month, Year, Issue_Area FROM Issue_Attendance 
            LEFT JOIN Issue_Areas ON Issue_Attendance.Issue_ID=Issue_Areas.Issue_ID
            LEFT JOIN Participants ON Issue_Attendance.Participant_ID=Participants.Participant_ID
            WHERE Issue_Attendance.Participant_ID IS NOT NULL ". $issue . $month . $year;
   // echo $query;
    $response=mysqli_query($cnnLSNA, $query);
    ?>
<p></p>
<table class="all_projects"><tr><th>Person Attending</th><th>Contact Info</th><th>Service</th><th>Month</th><th>Year</th></tr>
        <?php
        date_default_timezone_set('America/Chicago');
$infile = "export_data/services_rendered_result_" . date('M-d-Y') . ".csv";
//echo $infile;
$fp = fopen($infile, "w") or die('can\'t open file');
$columns = array( 'First Name', 'Last Name', 'Contact Phone', 'Contact Phone 2',  'Month', 'Year', 'Service Rendered');
        fputcsv($fp, $columns);
    while ($resp=mysqli_fetch_row($response)){
        ?>
    <tr>
        <td class='all_projects'><?php echo $resp[0] ." ". $resp[1]; ?></td>
        <td class='all_projects'><?php echo $resp[2] ."<br>". $resp[3]; ?></td>
        <td class='all_projects'><?php echo $resp[6]; ?></td>
        <td class='all_projects'><?php if ($resp[4]==1){ echo "January"; }
                if ($resp[4]==2){ echo "February"; }
                if ($resp[4]==3){ echo "March"; }
                if ($resp[4]==4){ echo "April"; }
                if ($resp[4]==5){ echo "May"; }
                if ($resp[4]==6){ echo "June"; }
                if ($resp[4]==7){ echo "July"; }
                if ($resp[4]==8){ echo "August"; }
                if ($resp[4]==9){ echo "September"; }
                if ($resp[4]==10){ echo "October"; }
                if ($resp[4]==11){ echo "November"; }
                if ($resp[4]==12){ echo "December"; }
                
                ?></td>
        <td class='all_projects'><?php echo $resp[5]; ?></td>
    </tr>
            <?php
            fputcsv($fp, $resp);
    }
    fclose($fp);
    include "../include/dbconnclose.php";
    ?> <a href="<?php echo $infile; ?>">Download Results</a><br>
    <span>Total number of people: <?php echo mysqli_num_rows($response);?></span>
        <?php
    
}
elseif($_POST['action']=='filter'){
    include "../include/dbconnopen.php";
    $issue_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue']);
    $issue_month_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue_month']);
    $issue_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue_year']);
    if ($_POST['issue_year']!=''){$year_query=" AND Year='".$issue_year_sqlsafe."' ";}
    if ($_POST['issue_month']!=''){$month_query=" AND Month='".$issue_month_sqlsafe."' ";}
     $ytd_num="SELECT * FROM Issue_Attendance WHERE Issue_ID='".$issue_sqlsafe."' " . $year_query . $month_query;
    // echo $ytd_num;
     $ytd_num_call=mysqli_query($cnnLSNA, $ytd_num);
     echo "<br>". mysqli_num_rows($ytd_num_call);
     include "../include/dbconnclose.php";
}
elseif($_POST['action']=='new_service'){
    include "../include/dbconnopen.php";
    $service_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['service_name']);
    $query="INSERT INTO Issue_Areas (Issue_Area) VALUES ('".$service_name_sqlsafe."')";
    echo $query;
    mysqli_query($cnnLSNA, $query);
    include "../include/dbconnclose.php";
}
elseif( isset($_POST['save_number'])){
    include "../include/dbconnopen.php";
    $num_served_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['num_served']);
    $save_number_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['save_number']);
    $issue_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['issue']);
    $month_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['month_served']);
    $year_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['year_served']);    
    $query="INSERT INTO Issue_Service (Number_Served, Issue_ID, Month, Year) VALUES ('" . $num_served_sqlsafe . "', '" . $issue_sqlsafe . "', '" . $month_sqlsafe . "', '" . $year_sqlsafe . "')";
    echo $query;
    mysqli_query($cnnLSNA, $query);
    include "../include/dbconnclose.php";
}
else{
include "../include/dbconnopen.php";
$issue_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue']);
$issue_month_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue_month']);
$issue_year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue_year']);
$issue_person_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['issue_person']);
$issue_query="INSERT INTO Issue_Attendance (Issue_ID, Month, Year, Participant_ID) VALUES ('".$issue_sqlsafe."',"
        . "'".$issue_month_sqlsafe."', '".$issue_year_sqlsafe."', '".$issue_person_sqlsafe."')";
echo $issue_query;
mysqli_query($cnnLSNA, $issue_query);
include "../include/dbconnclose.php";
}
?>
