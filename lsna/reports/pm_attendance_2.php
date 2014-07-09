<!--
Not currently linked on LSNA live site.  Not sure if they want it or not.
-->

<div id="pm_attendance">
  <?        $month_array=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
?>
    <!--Display depends on whether the results have already been sorted or not.  If they have, then the title will show the time
    and school for which the results are being reported: -->
    <h4>Parent Mentor Attendance <?if (isset($_POST['month'])){echo ": " . $month_array[$_POST['month']-1] . " " .$_POST['year'];
    if ($_POST['school'] !=''){
        include "../include/dbconnopen.php";
        $school_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['school']);
        $get_school_name="SELECT Institution_Name FROM Institutions WHERE Institution_ID='".$school_sqlsafe."'";
            $roles = mysqli_query($cnnLSNA, $get_school_name);
            while ($school = mysqli_fetch_row($roles)) {
                   echo ": " .$school[0];
            }
            include "../include/dbconnclose.php";
    }
    }?></h4>
    <!--Can choose month, year, and school for which to show PM attendance results: -->
    <form action="reports.php" method="post">
    <select name="month">
        <option value="">-----</option>
        <?
        for ($i=1; $i<13; $i++){
            ?><option value="<?echo $i?>"><?echo $month_array[$i-1];?></option><?
        }
        ?>
    </select><br>
    <select name="year">
        <option value="">-----</option>
        <option>2010</option>
        <option>2011</option>
        <option>2012</option>
        <option>2013</option>
        <option>2014</option>
        <option>2015</option>
    </select><br>
    <select name="school">
        <option value="">-----</option>
        <?
        $get_schools="SELECT * FROM Institutions WHERE Institution_Type=1;";
        include "../include/dbconnopen.php";
            $roles = mysqli_query($cnnLSNA, $get_schools);
            while ($role = mysqli_fetch_array($roles)) {
            ?>
                    <option value="<? echo $role['Institution_ID']; ?>"><? echo $role['Institution_Name']; ?></option>
            <?}
            include "../include/dbconnclose.php";
        ?>
    </select>
    <input type="submit" value="Sort">
    </form>
    
    <!--Display results.  If not sorted, then shows aggregate results for all the PM attendance entered in the system: -->
    <table class="all_projects">
        <tr><th>Month</th>
            <th>Year</th>
            <th>Days Possible</th>
            <th>Days Attended</th>
        </tr>
    <?
    //assemble query
    //do it for months that have entered time:
    if (isset($_POST['month'])){
        $get_months_query="SELECT Month, Year, 
            Max_Days_Possible FROM PM_Possible_Attendance
            INNER JOIN PM_Actual_Attendance 
            ON PM_Possible_Attendance.PM_Possible_Attendance_ID= 
            PM_Actual_Attendance.Possible_Attendance_ID 
            LEFT JOIN Institutions_Participants 
            ON PM_Actual_Attendance.Parent_Mentor_ID=Institutions_Participants.Participant_ID 
            WHERE Institution_ID='2' GROUP BY Month, Year;";
    }
    else{
        $get_months_query="SELECT  Month, Year, Max_Days_Possible 
            FROM PM_Possible_Attendance INNER JOIN PM_Actual_Attendance 
            ON PM_Possible_Attendance.PM_Possible_Attendance_ID=PM_Actual_Attendance.Possible_Attendance_ID 
            GROUP BY Month, Year;";
    }
    include "../include/dbconnopen.php";
    $get_months = mysqli_query($cnnLSNA, $get_months_query);
    /*show results by month: */
    while ($months=mysqli_fetch_row($get_months)){
        ?>
        <tr>
        <td class="all_projects"><?echo $months[0];?></td>
        <td class="all_projects"><?echo $months[1];?></td>
        <td class="all_projects"><?echo $months[2];?></td>
        <td class="all_projects">
            <?if (isset($_POST['month'])){
                $get_percentages_query="SELECT Num_Days_Attended, COUNT(Num_Days_Attended) as count
FROM PM_Possible_Attendance INNER JOIN PM_Actual_Attendance 
ON PM_Possible_Attendance.PM_Possible_Attendance_ID= PM_Actual_Attendance.Possible_Attendance_ID 
LEFT JOIN Institutions_Participants 
ON PM_Actual_Attendance.Parent_Mentor_ID=Institutions_Participants.Participant_ID 
WHERE Institution_ID='2' AND Month='".$months[0]."' AND Year='".$months[1]."' GROUP BY Num_Days_Attended;";
            }
            else{
                $get_percentages_query="SELECT Num_Days_Attended, COUNT(Num_Days_Attended) as count
FROM PM_Possible_Attendance INNER JOIN PM_Actual_Attendance
    ON PM_Possible_Attendance.PM_Possible_Attendance_ID=PM_Actual_Attendance.Possible_Attendance_ID
    WHERE Month='".$months[0]."' AND Year='".$months[1]."'
        GROUP BY Num_Days_Attended;";
            }
            //echo $get_percentages_query;
            $get_total = mysqli_query($cnnLSNA, $get_percentages_query);
            $total_people=0;
            while ($total = mysqli_fetch_row($get_total)){
                $total_people+=$total[1];
            }
            $get_percentages=mysqli_query($cnnLSNA, $get_percentages_query);
            while ($percent = mysqli_fetch_row($get_percentages)){
                echo $percent[0] . " days: " . round(($percent[1]/$total_people)*100, 1) . "%<br>";
            }
?>
            
        </td>
        </tr>
            <?
    }
    include "../include/dbconnclose.php";
    ?>
    </table>
</div>
