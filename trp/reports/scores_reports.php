<?include "../../header.php";
include "../header.php";
include "report_menu.php";

/* shows GPA and explore scores by year and program. */
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#reports_selector').addClass('selected');
	});
</script>
<h3>GPA By Year and Program</h3>

<table style="font-size: .8em;
				padding: 7px;
				border: 2px solid #696969;
				border-collapse: collapse;
				width:100%;">
    <tr><th>School Year</th><th>Program</th><th>GPA Quarter 1</th><th>GPA Quarter 2</th><th>GPA Quarter 3</th><th>GPA Quarter 4</th></tr>
    <?
    /* get average GPA sorted by year, quarter, and program */
    $somehow_someway_query="SELECT AVG(GPA), 
    Participants_Programs.Program_ID, Quarter, School_Year, Program_Name
FROM Participants_Programs INNER JOIN Academic_Info 
ON Participants_Programs.Participant_ID=Academic_Info.Participant_ID 
INNER JOIN Programs ON Participants_Programs.Program_ID=Programs.Program_ID
WHERE School_Year IS NOT NULL AND School_Year !=''
GROUP BY Participants_Programs.Program_ID,  Quarter;";
   // echo $somehow_someway_query;
    include "../include/dbconnopen.php";
    $gpa_avg=mysqli_query($cnnTRP, $somehow_someway_query);
    $current_year="";
    $current_program=0;
    while ($gpa=mysqli_fetch_row($gpa_avg)){
        if ($current_year!=$gpa[3] || $current_program!=$gpa[1]){
            /* if year or program has changed, set them to the correct year and program. */
            $i=1;
            $current_year=$gpa[3];
            $current_program=$gpa[1];
            ?></tr><tr>
                <td><?echo $current_year;?></td><td><?echo $gpa[4];?></td>
            <?
        }
        /* make sure that the GPA shows up in the correct td.  If no GPA is available for quarter 1, then add an empty td.
         * and so on and so forth. */
        if ($i==1){
            if ($gpa[2]==1){
                ?><td><?echo number_format($gpa[0], 2);?></td><?
            }
            elseif($gpa[2]==2){$i=2;?><td>N/A</td><td><?echo number_format($gpa[0], 2);?></td><?}
            elseif($gpa[2]==3){$i=3;?><td>N/A</td><td>N/A</td><td><?echo number_format($gpa[0], 2);?></td><?}
            elseif($gpa[2]==4){$i=4;?><td>N/A</td><td>N/A</td><td>N/A</td><td><?echo number_format($gpa[0], 2);?></td><?}
        }
        if ($i==2){
            if ($gpa[2]==2){?><td><?echo number_format($gpa[0], 2);?></td><?}
            elseif($gpa[2]==3){ $i=3;?><td>N/A</td><td><?echo number_format($gpa[0], 2);?></td><?}
            elseif($gpa[2]==4){ $i=4;?><td>N/A</td><td>N/A</td><td><?echo number_format($gpa[0], 2);?></td><?}
        }
        if ($i==3){
            if ($gpa[2]==3){?><td><?echo number_format($gpa[0], 2);?></td><?}
            elseif($gpa[2]==4){ $i=4;?><td>N/A</td><td><?echo number_format($gpa[0], 2);?></td><?}
        }
        if ($i==4){
            if ($gpa[2]==4){
                ?><td><?echo number_format($gpa[0], 2);?></td><?
            }
            else{?><td>N/A</td><?}
        }
        
        
        $i++;
    }
    include "../include/dbconnopen.php";
    
    
    ?>
</table>

<p></p>
<h3>Explore Scores By Program</h3>

<!-- much the same system as GPA, but simpler. -->
<table style="font-size: .8em;
				padding: 7px;
				border: 2px solid #696969;
				border-collapse: collapse;
				width:100%;">
    <tr><th>School Year</th><th>Program</th><th>Pre-Explore</th><th>Mid-Explore</th><th>Post-Explore</th><th>Fall-Explore</th></tr>
    <?
    /* pull average explore scores, sorted by year and program. */
    $somehow_someway_query="SELECT School_Year, Program_Name, AVG(Explore_Score_Pre) AS pre, AVG(Explore_Score_Mid) AS mid, 
AVG(Explore_Score_Post) AS post, AVG(Explore_Score_Fall) AS fall FROM Explore_Scores 
INNER JOIN Programs ON Programs.Program_ID=Explore_Scores.Program_ID
GROUP BY School_Year, Explore_Scores.Program_ID";
   // echo $somehow_someway_query;
    include "../include/dbconnopen.php";
    $gpa_avg=mysqli_query($cnnTRP, $somehow_someway_query);
    $current_year="";
    $current_program=0;
    while ($gpa=mysqli_fetch_row($gpa_avg)){
        ?>
    <tr><td><?$show_year=str_split($gpa[0], 2);
        echo '20' . $show_year[0] . '-20' . $show_year[1];?></td>
        <td><?echo $gpa[1];?></td>
        <td><?echo number_format($gpa[2]);?></td>
        <td><?echo number_format($gpa[3]);?></td>
        <td><?echo number_format($gpa[4]);?></td>
        <td><?echo number_format($gpa[5]);?></td>
    </tr>
            <?
    }
    include "../include/dbconnopen.php";
    
    
    ?>
</table>
<br/><br/>

<?
	include "../../footer.php";
?>