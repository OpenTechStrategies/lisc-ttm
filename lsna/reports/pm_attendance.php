<!--This isn't currently included on the live site.
A more current version is at pm_attendance_2.php.
-->

<div id="pm_attendance">
  <?        $month_array=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

  ?>
    <h4>Parent Mentor Attendance <?if (isset($_POST['month'])){echo ": " . $month_array[$_POST['month']-1] . " " .$_POST['year'];
    if ($_POST['school'] !=''){
        include "../include/dbconnopen.php";
        $school_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['school']);
        $month_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['month']);
        $year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['year']);
        $get_school_name="SELECT Institution_Name FROM Institutions WHERE Institution_ID='".$school_sqlsafe."'";
        $roles = mysqli_query($cnnLSNA, $get_school_name);
            while ($school = mysqli_fetch_row($roles)) {
                   echo ": " .$school[0];
            }
            include "../include/dbconnclose.php";
    }
    }?></h4>
	<div style="text-align:center;">
	<?
		if ($_POST['school'] !='') {
		$get_school_name="SELECT Institution_Name FROM Institutions WHERE Institution_ID='".$school_sqlsafe."'";
        include "../include/dbconnopen.php";
		$school=mysqli_query($cnnLSNA, $get_school_name);
		$school_name=mysqli_fetch_array($school);
		
	?>
		<span class="helptext">Total number of Parent Mentors with entered attendance at <?echo $school_name['Institution_Name'];?>:
                <?
                $get_PMs = "SELECT DISTINCT Parent_Mentor_ID, Institutions_Participants.* FROM PM_Actual_Attendance
                        INNER JOIN Institutions_Participants ON Participant_ID=Parent_Mentor_ID
                        WHERE Is_PM=1 AND Institutions_Participants.Institution_ID='" . $school_sqlsafe . "'";
                //echo $get_PMs;
                $PMs = mysqli_query($cnnLSNA, $get_PMs);
                $num_pms_total=mysqli_num_rows($PMs);
                echo $num_pms_total;
                ?></span>
	<?
		} else {
		$get_all_pms="SELECT DISTINCT Participant_ID FROM Participants_Subcategories WHERE Subcategory_ID=19";
		include "../include/dbconnopen.php";
		$all_pms=mysqli_query($cnnLSNA, $get_all_pms);
		$num_pms=mysqli_num_rows($all_pms);
	?>
		<span class="helptext">Total number of Parent Mentors:</span>
	<?
		echo $num_pms;
		include "../include/dbconnclose.php";
		}
	?>
	</div>
    <form action="reports.php" method="post" style="margin-left:auto;margin-right:auto;width:50%;">
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
    <table class="all_projects">
        <tr><th>Month</th>
            <th>Year</th>
            <th>Days Possible</th>
            <th>Days Attended</th>
        </tr>
        
        <?
    //assemble query
    //do it for months that have entered time:
    if ($_POST['school']!=''){$school=" AND Institution_ID='".$school_sqlsafe."'";}else{$school="";}
    if ($_POST['month']!=''){$mo=" AND Month='".$month_sqlsafe."'";}else{$mo="";}
    if ($_POST['year']!=''){$year=" AND Year='".$year_sqlsafe."'";}else{$year="";}
        
        
    if (isset($_POST['month']) && $_POST['school']!=''){
        
        $get_months_query="SELECT Month, Year, 
            Max_Days_Possible FROM PM_Possible_Attendance
            INNER JOIN PM_Actual_Attendance 
            ON PM_Possible_Attendance.PM_Possible_Attendance_ID= 
            PM_Actual_Attendance.Possible_Attendance_ID 
            LEFT JOIN Institutions_Participants 
            ON PM_Actual_Attendance.Parent_Mentor_ID=Institutions_Participants.Participant_ID 
            WHERE PM_Possible_Attendance_ID IS NOT NULL " .$school.$mo.$year. " AND Is_PM=1 GROUP BY Month, Year;";
    }
    else{
        $get_months_query="SELECT  Month, Year, Max_Days_Possible 
            FROM PM_Possible_Attendance INNER JOIN PM_Actual_Attendance 
            ON PM_Possible_Attendance.PM_Possible_Attendance_ID=PM_Actual_Attendance.Possible_Attendance_ID 
            WHERE PM_Possible_Attendance_ID IS NOT NULL " .$mo.$year.
            "   GROUP BY Month, Year;";
    }
   // echo $get_months_query;
    include "../include/dbconnopen.php";
    $get_months = mysqli_query($cnnLSNA, $get_months_query);
    while ($months=mysqli_fetch_row($get_months)){
        ?>
        <tr>
        <td class="all_projects"><?echo $months[0];?></td>
        <td class="all_projects"><?echo $months[1];?></td>
        <td class="all_projects"><?echo $months[2];?></td>
        <td class="all_projects">
            <?if (isset($_POST['month']) && $_POST['school']!=''){
                $get_percentages_query="SELECT Num_Days_Attended, COUNT(Num_Days_Attended) as count
FROM PM_Possible_Attendance INNER JOIN PM_Actual_Attendance 
ON PM_Possible_Attendance.PM_Possible_Attendance_ID= PM_Actual_Attendance.Possible_Attendance_ID 
LEFT JOIN Institutions_Participants 
ON PM_Actual_Attendance.Parent_Mentor_ID=Institutions_Participants.Participant_ID 
WHERE Institution_ID='".$school_sqlsafe."' AND Month='".$months[0]."' AND Year='".$months[1]."' AND Is_PM=1 GROUP BY Num_Days_Attended;";
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
