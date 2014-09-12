<?php

include "../../header.php";
include "../header.php";
include "report_menu.php";
//include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
?>

<!-- as with all the other exports, this will be changing once Taryn lets us know her requirements. -->

<script type="text/javascript">
	$(document).ready(function(){
		$('#reports_selector').addClass('selected');
	});
</script>
<h3>Export Everything</h3>
<span class="helptext">Some tables have no identifying information, and will always be in the far right column.  Others include identifying information,
which has been removed for the use of researchers and partners in the version in the far right column.</span>
<table class="all_projects">
    <tr><th>Export Tables</th><th>Including names and more</th><th>Excluding all potentially identifiable information</th></tr>
    <tr><td class="all_projects">Export Academic Info</td>
        <td class="all_projects">
            <a
	    href="/include/generalized_download_script.php?download_name=trp_academic_info">With
	    identifying information</a>  
        </td>
        <td class="all_projects">
            <a
            href="/include/generalized_download_script.php?download_name=trp_academic_info_deid">  
            Without identifying information</a>
        </td></tr> 
    
        <tr><td class="all_projects">Export Events</td><td
            class="all_projects"></td><td class="all_projects"> 
            <a
            href="/include/generalized_download_script.php?download_name=trp_events_deid">Without
            identifying information</a>
        </td></tr> 
        
            <tr><td class="all_projects">Export Event Attendees</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_event_attendance">
                     With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_event_attendance_deid">
                    Without identifying information</a>
                </td></tr>
            <tr><td class="all_projects">School Records, Non-Academic</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_school_records">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_school_records_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Explore and ISAT Scores</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_explore_scores">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_explore_scores_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Community Engagement Outcomes by Month</td>
                <td class="all_projects">
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_community_outcomes">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Parent-Child Relationships</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_families">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_families_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">All Participants</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_participants">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_participants_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Participants by Program</td>
                <td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_participants_programs">
                    With identifying information</a>
                </td><td class="all_projects">
                <a href="/include/generalized_download_script.php?download_name=trp_participants_programs_deid">
                    Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">All Programs</td>
                <td class="all_projects">
                     
                </td><td class="all_projects">
                <a
                href="/include/generalized_download_script.php?download_name=trp_programs">
                    Without identifying information</a></td></tr> 
            
            <tr><td class="all_projects">GOLD Scores</td>
                <td class="all_projects">
include "../include/dbconnclose.php";
$get_y2_scores = "SELECT Gold_Score_Pre.Participant, First_Name, Last_Name, Gold_Score_Pre.Social_Emotional, Gold_Score_Mid.Social_Emotional, Gold_Score_Post.Social_Emotional, "
        . "Gold_Score_Pre.Physical, Gold_Score_Mid.Physical, Gold_Score_Post.Physical, "
        . "Gold_Score_Pre.Language, Gold_Score_Mid.Language, Gold_Score_Post.Language, "
        . "Gold_Score_Pre.Cognitive, Gold_Score_Mid.Cognitive, Gold_Score_Post.Cognitive, "
        . "Gold_Score_Pre.Literacy, Gold_Score_Mid.Literacy, Gold_Score_Post.Literacy, "
        . "Gold_Score_Pre.Mathematics, Gold_Score_Mid.Mathematics, Gold_Score_Post.Mathematics, "
        . "Gold_Score_Pre.Science_Tech, Gold_Score_Mid.Science_Tech, Gold_Score_Post.Science_Tech, "
        . "Gold_Score_Pre.Social_Studies, Gold_Score_Mid.Social_Studies, Gold_Score_Post.Social_Studies, "
        . "Gold_Score_Pre.Creative_Arts, Gold_Score_Mid.Creative_Arts, Gold_Score_Post.Creative_Arts, "
        . "Gold_Score_Pre.English, Gold_Score_Mid.English, Gold_Score_Post.English, "
        . " Gold_Score_Pre.Year, Address_Street_Num, Address_Street_Direction, Address_Street_Name, Address_Street_Type, Address_City,"
        . "Address_State, Address_Zipcode, Phone, Email, DOB, Gender, CPS_ID FROM Gold_Score_Totals "
        . "LEFT JOIN Participants ON Gold_Score_Totals.Participant=Participants.Participant_ID "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre ON Gold_Score_Totals.Participant=Gold_Score_Pre.Participant AND Gold_Score_Pre.Test_Time=1 AND Gold_Score_Pre.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid ON Gold_Score_Totals.Participant=Gold_Score_Mid.Participant AND Gold_Score_Mid.Test_Time=2 AND Gold_Score_Mid.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Post ON Gold_Score_Totals.Participant=Gold_Score_Post.Participant AND Gold_Score_Post.Test_Time=3 AND Gold_Score_Post.Year=Gold_Score_Totals.Year "
        . "WHERE Gold_Score_Totals.Year=2 GROUP BY Gold_Score_Totals.Participant ";
//echo $get_y1_scores;
include "../include/dbconnopen.php";
$score_info = mysqli_query($cnnTRP, $get_y2_scores);
while ($score_array = mysqli_fetch_row($score_info)){
    fputcsv ($fp, $score_array);
}
include "../include/dbconnclose.php";
$get_y3_scores = "SELECT Gold_Score_Pre.Participant, First_Name, Last_Name, Gold_Score_Pre.Social_Emotional, Gold_Score_Mid.Social_Emotional, Gold_Score_Post.Social_Emotional, "
        . "Gold_Score_Pre.Physical, Gold_Score_Mid.Physical, Gold_Score_Post.Physical, "
        . "Gold_Score_Pre.Language, Gold_Score_Mid.Language, Gold_Score_Post.Language, "
        . "Gold_Score_Pre.Cognitive, Gold_Score_Mid.Cognitive, Gold_Score_Post.Cognitive, "
        . "Gold_Score_Pre.Literacy, Gold_Score_Mid.Literacy, Gold_Score_Post.Literacy, "
        . "Gold_Score_Pre.Mathematics, Gold_Score_Mid.Mathematics, Gold_Score_Post.Mathematics, "
        . "Gold_Score_Pre.Science_Tech, Gold_Score_Mid.Science_Tech, Gold_Score_Post.Science_Tech, "
        . "Gold_Score_Pre.Social_Studies, Gold_Score_Mid.Social_Studies, Gold_Score_Post.Social_Studies, "
        . "Gold_Score_Pre.Creative_Arts, Gold_Score_Mid.Creative_Arts, Gold_Score_Post.Creative_Arts, "
        . "Gold_Score_Pre.English, Gold_Score_Mid.English, Gold_Score_Post.English, "
        . " Gold_Score_Pre.Year, Address_Street_Num, Address_Street_Direction, Address_Street_Name, Address_Street_Type, Address_City,"
        . "Address_State, Address_Zipcode, Phone, Email, DOB, Gender, CPS_ID FROM Gold_Score_Totals "
        . "LEFT JOIN Participants ON Gold_Score_Totals.Participant=Participants.Participant_ID "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre ON Gold_Score_Totals.Participant=Gold_Score_Pre.Participant AND Gold_Score_Pre.Test_Time=1 AND Gold_Score_Pre.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid ON Gold_Score_Totals.Participant=Gold_Score_Mid.Participant AND Gold_Score_Mid.Test_Time=2 AND Gold_Score_Mid.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Post ON Gold_Score_Totals.Participant=Gold_Score_Post.Participant AND Gold_Score_Post.Test_Time=3 AND Gold_Score_Post.Year=Gold_Score_Totals.Year "
        . "WHERE Gold_Score_Totals.Year=3 GROUP BY Gold_Score_Totals.Participant ";
//echo $get_y1_scores;
include "../include/dbconnopen.php";
$score_info = mysqli_query($cnnTRP, $get_y3_scores);
while ($score_array = mysqli_fetch_row($score_info)){
    fputcsv ($fp, $score_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>   <a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?php $infile="data/deid_gold_scores.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array( "Participant ID", "Social Emotional - Pre", "Social Emotional - Mid", "Social Emotional - Post", 
    "Physical - Pre", "Physical - Mid", "Physical - Post", "Language - Pre", "Language - Mid", "Language - Post", 
    "Cognitive - Pre", "Cognitive - Mid", "Cognitive - Post", "Literacy - Pre", "Literacy - Mid", "Literacy - Post", 
    "Mathematics - Pre", "Mathematics - Mid", "Mathematics - Post", "Science and Technology - Pre", "Science and Technology - Mid", "Science and Technology - Post", 
    "Social Studies - Pre", "Social Studies - Mid", "Social Studies - Post", "Creative Arts - Pre", "Creative Arts - Mid", "Creative Arts - Post", 
    "English - Pre", "English - Mid", "English - Post", "First, Second, or Third Year", 
     "City", "State", "Zipcode", "Gender", "CPS ID");
$legend_array=array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", 
    "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation",
    "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation","1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation",
     "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation",
    "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation");
fputcsv($fp, $title_array);
fputcsv($fp, $legend_array);
$get_y1_scores = "SELECT Gold_Score_Pre.Participant, Gold_Score_Pre.Social_Emotional, Gold_Score_Mid.Social_Emotional, Gold_Score_Post.Social_Emotional, "
        . "Gold_Score_Pre.Physical, Gold_Score_Mid.Physical, Gold_Score_Post.Physical, "
        . "Gold_Score_Pre.Language, Gold_Score_Mid.Language, Gold_Score_Post.Language, "
        . "Gold_Score_Pre.Cognitive, Gold_Score_Mid.Cognitive, Gold_Score_Post.Cognitive, "
        . "Gold_Score_Pre.Literacy, Gold_Score_Mid.Literacy, Gold_Score_Post.Literacy, "
        . "Gold_Score_Pre.Mathematics, Gold_Score_Mid.Mathematics, Gold_Score_Post.Mathematics, "
        . "Gold_Score_Pre.Science_Tech, Gold_Score_Mid.Science_Tech, Gold_Score_Post.Science_Tech, "
        . "Gold_Score_Pre.Social_Studies, Gold_Score_Mid.Social_Studies, Gold_Score_Post.Social_Studies, "
        . "Gold_Score_Pre.Creative_Arts, Gold_Score_Mid.Creative_Arts, Gold_Score_Post.Creative_Arts, "
        . "Gold_Score_Pre.English, Gold_Score_Mid.English, Gold_Score_Post.English, "
        . " Gold_Score_Pre.Year, Address_City,"
        . "Address_State, Address_Zipcode, Gender, CPS_ID FROM Gold_Score_Totals "
        . "LEFT JOIN Participants ON Gold_Score_Totals.Participant=Participants.Participant_ID "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre ON Gold_Score_Totals.Participant=Gold_Score_Pre.Participant AND Gold_Score_Pre.Test_Time=1 AND Gold_Score_Pre.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid ON Gold_Score_Totals.Participant=Gold_Score_Mid.Participant AND Gold_Score_Mid.Test_Time=2 AND Gold_Score_Mid.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Post ON Gold_Score_Totals.Participant=Gold_Score_Post.Participant AND Gold_Score_Post.Test_Time=3 AND Gold_Score_Post.Year=Gold_Score_Totals.Year "
        . "WHERE Gold_Score_Totals.Year=1 GROUP BY Gold_Score_Totals.Participant ";
//echo $get_y1_scores;
include "../include/dbconnopen.php";
$score_info = mysqli_query($cnnTRP, $get_y1_scores);
while ($score_array = mysqli_fetch_row($score_info)){
    fputcsv ($fp, $score_array);
}
include "../include/dbconnclose.php";
$get_y2_scores = "SELECT Gold_Score_Pre.Participant, Gold_Score_Pre.Social_Emotional, Gold_Score_Mid.Social_Emotional, Gold_Score_Post.Social_Emotional, "
        . "Gold_Score_Pre.Physical, Gold_Score_Mid.Physical, Gold_Score_Post.Physical, "
        . "Gold_Score_Pre.Language, Gold_Score_Mid.Language, Gold_Score_Post.Language, "
        . "Gold_Score_Pre.Cognitive, Gold_Score_Mid.Cognitive, Gold_Score_Post.Cognitive, "
        . "Gold_Score_Pre.Literacy, Gold_Score_Mid.Literacy, Gold_Score_Post.Literacy, "
        . "Gold_Score_Pre.Mathematics, Gold_Score_Mid.Mathematics, Gold_Score_Post.Mathematics, "
        . "Gold_Score_Pre.Science_Tech, Gold_Score_Mid.Science_Tech, Gold_Score_Post.Science_Tech, "
        . "Gold_Score_Pre.Social_Studies, Gold_Score_Mid.Social_Studies, Gold_Score_Post.Social_Studies, "
        . "Gold_Score_Pre.Creative_Arts, Gold_Score_Mid.Creative_Arts, Gold_Score_Post.Creative_Arts, "
        . "Gold_Score_Pre.English, Gold_Score_Mid.English, Gold_Score_Post.English, "
        . " Gold_Score_Pre.Year, Address_City,"
        . "Address_State, Address_Zipcode, Gender, CPS_ID FROM Gold_Score_Totals "
        . "LEFT JOIN Participants ON Gold_Score_Totals.Participant=Participants.Participant_ID "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre ON Gold_Score_Totals.Participant=Gold_Score_Pre.Participant AND Gold_Score_Pre.Test_Time=1 AND Gold_Score_Pre.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid ON Gold_Score_Totals.Participant=Gold_Score_Mid.Participant AND Gold_Score_Mid.Test_Time=2 AND Gold_Score_Mid.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Post ON Gold_Score_Totals.Participant=Gold_Score_Post.Participant AND Gold_Score_Post.Test_Time=3 AND Gold_Score_Post.Year=Gold_Score_Totals.Year "
        . "WHERE Gold_Score_Totals.Year=2 GROUP BY Gold_Score_Totals.Participant ";
//echo $get_y1_scores;
include "../include/dbconnopen.php";
$score_info = mysqli_query($cnnTRP, $get_y2_scores);
while ($score_array = mysqli_fetch_row($score_info)){
    fputcsv ($fp, $score_array);
}
include "../include/dbconnclose.php";

$get_y3_scores = "SELECT Gold_Score_Pre.Participant, Gold_Score_Pre.Social_Emotional, Gold_Score_Mid.Social_Emotional, Gold_Score_Post.Social_Emotional, "
        . "Gold_Score_Pre.Physical, Gold_Score_Mid.Physical, Gold_Score_Post.Physical, "
        . "Gold_Score_Pre.Language, Gold_Score_Mid.Language, Gold_Score_Post.Language, "
        . "Gold_Score_Pre.Cognitive, Gold_Score_Mid.Cognitive, Gold_Score_Post.Cognitive, "
        . "Gold_Score_Pre.Literacy, Gold_Score_Mid.Literacy, Gold_Score_Post.Literacy, "
        . "Gold_Score_Pre.Mathematics, Gold_Score_Mid.Mathematics, Gold_Score_Post.Mathematics, "
        . "Gold_Score_Pre.Science_Tech, Gold_Score_Mid.Science_Tech, Gold_Score_Post.Science_Tech, "
        . "Gold_Score_Pre.Social_Studies, Gold_Score_Mid.Social_Studies, Gold_Score_Post.Social_Studies, "
        . "Gold_Score_Pre.Creative_Arts, Gold_Score_Mid.Creative_Arts, Gold_Score_Post.Creative_Arts, "
        . "Gold_Score_Pre.English, Gold_Score_Mid.English, Gold_Score_Post.English, "
        . " Gold_Score_Pre.Year, Address_City,"
        . "Address_State, Address_Zipcode, Gender, CPS_ID FROM Gold_Score_Totals "
        . "LEFT JOIN Participants ON Gold_Score_Totals.Participant=Participants.Participant_ID "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre ON Gold_Score_Totals.Participant=Gold_Score_Pre.Participant AND Gold_Score_Pre.Test_Time=1 AND Gold_Score_Pre.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid ON Gold_Score_Totals.Participant=Gold_Score_Mid.Participant AND Gold_Score_Mid.Test_Time=2 AND Gold_Score_Mid.Year=Gold_Score_Totals.Year "
        . "LEFT JOIN Gold_Score_Totals AS Gold_Score_Post ON Gold_Score_Totals.Participant=Gold_Score_Post.Participant AND Gold_Score_Post.Test_Time=3 AND Gold_Score_Post.Year=Gold_Score_Totals.Year "
        . "WHERE Gold_Score_Totals.Year=3 GROUP BY Gold_Score_Totals.Participant ";
//echo $get_y1_scores;
include "../include/dbconnopen.php";
$score_info = mysqli_query($cnnTRP, $get_y3_scores);
while ($score_array = mysqli_fetch_row($score_info)){
    fputcsv ($fp, $score_array);
}
include "../include/dbconnclose.php";

fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
             <tr><td class="all_projects">Teacher Exchange Classrooms</td>
                <td class="all_projects">
                 <a
                href="/include/generalized_download_script.php?download_name=trp_teacher_exchange">
                    With identifying information</a>
                </td><td class="all_projects">
                <a
                href="/include/generalized_download_script.php?download_name=trp_teacher_exchange_deid">
                    Without identifying information</a></td></tr>
    
            
</table><br/></br>

<?
	include "../../footer.php";
?>
