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
             <?$infile="data/academic_info.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Participant First Name", "Last Name", "Academic Information ID", "Participant ID",  "Program ID", "School Year", "Quarter", "GPA", "ISAT Math Score", "ISAT Reading Score",
        "ISAT Total Score", "Grade in School", "Math Grade", "Language Arts Grade", "Date Information Logged", "School ID (6=No School Selected)",
    "School Name");
fputcsv($fp, $title_array);
$get_peoples = "SELECT First_Name, Last_Name, Academic_Info.*, School_Name FROM Academic_Info
    LEFT JOIN Schools ON School=School_ID
    LEFT JOIN Participants ON Academic_Info.Participant_ID=Participants.Participant_ID";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
            <a href="<?echo $infile?>">With identifying information</a>
        </td>
        <td class="all_projects">
            <?$infile="data/db_academic_info.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Academic Information ID", "Participant ID", "Program ID", "School Year", "Quarter", "GPA", "ISAT Math Score", "ISAT Reading Score",
        "ISAT Total Score", "Grade in School", "Math Grade", "Language Arts Grade", "Date Information Logged", "School ID (6=No School Selected)");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM Academic_Info";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>

<a href="<?echo $infile?>">Without identifying information</a></td></tr>
    
        <tr><td class="all_projects">Export Events</td><td class="all_projects"></td><td class="all_projects">
            <?$infile="data/db_events.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Event ID", "Event Name", "Event Goal Attendance", "Event Actual Attendance", "Event Date", "Active[1]/Inactive[0]");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM Events";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>

<a href="<?echo $infile?>">Without identifying information</a></td></tr>
        
            <tr><td class="all_projects">Export Event Attendees</td>
                <td class="all_projects"><?$infile="data/db_events_participants.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Event Name", "Event Date", "Attendee First Name", " Attendee Last Name");
fputcsv($fp, $title_array);
$get_peoples = "SELECT Event_Name, Event_Date, First_Name, Last_Name FROM Events_Participants INNER JOIN Events ON Events_Participants.Event_ID=
Events.Event_ID INNER JOIN Participants ON Events_Participants.Participant_ID=Participants.Participant_ID;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?><a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?$infile="data/db_events_participants_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Link ID", "Event ID", "Participant ID");
fputcsv($fp, $title_array);
$get_peoples = "SELECT Event_Name, Event_Date, Participant_ID FROM Events_Participants INNER JOIN Events ON Events_Participants.Event_ID=
Events.Event_ID";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>    
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">School Records, Non-Academic</td>
                <td class="all_projects">
                    <?php $infile="data/ms_hs_absences_etc.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("First Name", "Last Name", "Link ID", "Participant ID", "Number of Tardies", "Number of Excused Absences", "Number of Unexcused Absences", 
        "Number of In-school Suspensions", "Number of out of school suspensions", "Office Referrals", "Quarter", "Grade in School",
    "School Year", "Program ID", "School ID", "School Name");
fputcsv($fp, $title_array);
$get_peoples = "SELECT First_Name, Last_Name, MS_to_HS_Over_Time.*, School_Name FROM MS_to_HS_Over_Time
    LEFT JOIN Participants ON Participants.Participant_ID=MS_to_HS_Over_Time.Participant_ID
    LEFT JOIN Schools ON Schools.School_ID=MS_to_HS_Over_Time.School_ID;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?><a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?$infile="data/db_ms_hs_absences_etc.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Link ID", "Participant ID", "Number of Tardies", "Number of Excused Absences", "Number of Unexcused Absences", 
        "Number of In-school Suspensions", "Number of out of school suspensions", "Office Referrals", "Quarter", "Grade in School");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM MS_to_HS_Over_Time;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Explore and ISAT Scores</td>
                <td class="all_projects"><?php $infile="data/explore_scores.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("First Name", "Last Name", "Link ID", "Participant ID", "Explore Score Pre", "Explore Score Mid", "Explore Score Post", 
        "Explore Score Fall of 9th Grade", "Reading ISAT", "Math ISAT", "CPS Consent", "Program ID", "School ID", "School Year", "School Name");
fputcsv($fp, $title_array);
$get_peoples = "SELECT First_Name, Last_Name, Explore_Scores.*, School_Name FROM Explore_Scores
    LEFT JOIN Participants on Explore_Scores.Participant_ID=Participants.Participant_ID
    LEFT JOIN Schools ON School=School_ID;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?$infile="data/db_ms_hs_scores.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Link ID", "Participant ID", "Explore Score Pre", "Explore Score Mid", "Explore Score Post", 
        "Explore Score Fall of 9th Grade", "Reading ISAT", "Math ISAT", "CPS Consent", "Program ID", "School ID", "School Year");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM Explore_Scores;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">NMMA Identity Survey</td>
                <td class="all_projects">
                     <?$infile="data/nmma_identity.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("First Name", "Last Name", "Survey ID", "Participant ID", "Question 1",
        "Question 2",
    "Question 3", "Question 4", "Question 5", "Question 6", "Question 7", "Question 8", 
    "Question 9", "Question 10", "Question 11", "Pre or Post", "Date Logged");
fputcsv($fp, $title_array);
$get_peoples = "SELECT First_Name, Last_Name, NMMA_Identity_Survey.* FROM NMMA_Identity_Survey
    INNER JOIN Participants ON NMMA_Identity_Survey.Participant_ID=Participants.Participant_ID;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?$infile="data/db_nmma_identity.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Survey ID", "Participant ID", "Question 1",
        "Question 2",
    "Question 3", "Question 4", "Question 5", "Question 6", "Question 7", "Question 8", 
    "Question 9", "Question 10", "Question 11", "Pre or Post", "Date Logged");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM NMMA_Identity_Survey;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">NMMA Traditions Survey</td>
                <td class="all_projects"><?$infile="data/nmma_traditions.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("First Name", "Last Name", "Survey ID", "Participant ID", "Question 1",
        "Question 2",
    "Question 3", "Question 4", "Question 5", "Question 6", "Question 7", "Question 8", 
   "Pre or Post", "Date Logged");
fputcsv($fp, $title_array);
$get_peoples = "SELECT First_Name, Last_Name, NMMA_Traditions_Survey.* FROM NMMA_Traditions_Survey
    LEFT JOIN Participants ON NMMA_Traditions_Survey.Participant_Id=Participants.Participant_ID;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?$infile="data/db_nmma_traditions.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Survey ID", "Participant ID", "Question 1",
        "Question 2",
    "Question 3", "Question 4", "Question 5", "Question 6", "Question 7", "Question 8", 
   "Pre or Post", "Date Logged");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM NMMA_Traditions_Survey;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Community Engagement Outcomes by Month</td>
                <td class="all_projects">
</td><td class="all_projects">
        <?$infile="data/db_outcomes.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Outcome", "Month", "Goal", "Actual Result");
fputcsv($fp, $title_array);
$get_peoples = "SELECT Outcome_Name, Month, Goal_Outcome, Actual_Outcome
FROM Outcomes_Months INNER JOIN Outcomes ON Outcomes_Months.Outcome_ID=Outcomes.Outcome_ID;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Parent-Child Relationships</td>
                <td class="all_projects">
                     <?$infile="data/db_families.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Child First Name", "Child Last Name", "Parent First Name", "Parent Last Name");
fputcsv($fp, $title_array);
$get_peoples = "SELECT Children.First_Name, Children.Last_Name, Parents.First_Name, Parents.Last_Name
FROM Parents_Children INNER JOIN Participants as Parents ON 
Parents.Participant_ID=Parent_ID
INNER JOIN Participants AS Children ON
Children.Participant_ID=Child_ID;";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?><a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?$infile="data/db_families_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Linking ID", "Parent ID", "Child ID");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM Parents_Children";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">All Participants</td>
                <td class="all_projects">
                     <?$infile="data/db_participants.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Participant ID", "First Name", "Last Name", "Address Street Name", "Address Street Number", "Street Direction",
        "Street Type", "State", "City", "Zipcode", "Phone", "Email", "Gender", "Date of Birth", "Race", "Grade Level", "Classroom", 
    "Lunch Price  (0=No Answer; 1=Free; 2=Reduced Price; 3=None)",
        "Neighborhood", "Eval ID", "CPS ID");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM Participants";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?><a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?$infile="data/db_people_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Participant_ID", "Block Group", "Gender", "Grade_Level", "Classroom", 
    "Lunch_Price (0=No Answer; 1=Free; 2=Reduced Price; 3=None)", "Neighborhood");
fputcsv($fp, $title_array);
$get_peoples = "SELECT Participant_ID, Block_Group, 
    Gender, Grade_Level, Classroom, Lunch_Price, Neighborhood FROM Participants";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
   /* $this_address=$people_array[1]." " . $people_array[2] . " " . $people_array[3] ." ". $people_array[4] ;
   $block_group=do_it_all($this_address, $map);
    $all_array=array($people_array[0], $block_group, $people_array[5], $people_array[6], $people_array[7], $people_array[8], $people_array[9]);*/
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">Participants by Program</td>
                <td class="all_projects">
                     <?php $infile="data/db_participants_programs.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array( "First Name", "Last Name", "Program Name");
fputcsv($fp, $title_array);
$get_peoples = "SELECT First_Name, Last_Name, Program_Name FROM Participants_Programs INNER JOIN Participants ON Participants.Participant_ID=Participants_Programs.Participant_ID
    INNER JOIN Programs ON Participants_Programs.Program_ID=Programs.Program_ID";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?><a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?php $infile="data/db_participants_programs_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Linking ID", "Participant ID", "Program ID");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM Participants_Programs";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">All Programs</td>
                <td class="all_projects">
                     
</td><td class="all_projects">
        <?php $infile="data/db_programs.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Program ID", "Program Name", "Program Organization");
fputcsv($fp, $title_array);
$get_peoples = "SELECT * FROM Programs";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_peoples);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
            
            <tr><td class="all_projects">GOLD Scores</td>
                <td class="all_projects">
                  <?php $infile="data/db_gold_scores.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array( "Participant ID", "Participant First Name", "Participant Last Name", "Social Emotional - Pre", "Social Emotional - Mid", "Social Emotional - Post", 
    "Physical - Pre", "Physical - Mid", "Physical - Post", "Language - Pre", "Language - Mid", "Language - Post", 
    "Cognitive - Pre", "Cognitive - Mid", "Cognitive - Post", "Literacy - Pre", "Literacy - Mid", "Literacy - Post", 
    "Mathematics - Pre", "Mathematics - Mid", "Mathematics - Post", "Science and Technology - Pre", "Science and Technology - Mid", "Science and Technology - Post", 
    "Social Studies - Pre", "Social Studies - Mid", "Social Studies - Post", "Creative Arts - Pre", "Creative Arts - Mid", "Creative Arts - Post", 
    "English - Pre", "English - Mid", "English - Post", "First, Second, or Third Year", 
     "Address Street Number", "Address Street Direction", "Address Street Name", "Address Street Type", "City", "State", "Zipcode", "Phone", "Email", "DOB", "Gender", "CPS ID");
$legend_array=array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", 
    "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation",
    "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation","1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation",
     "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation",
    "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation");
fputcsv($fp, $title_array);
fputcsv($fp, $legend_array);
$get_y1_scores = "SELECT Gold_Score_Pre.Participant, First_Name, Last_Name, Gold_Score_Pre.Social_Emotional, Gold_Score_Mid.Social_Emotional, Gold_Score_Post.Social_Emotional, "
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
        . "WHERE Gold_Score_Totals.Year=1 GROUP BY Gold_Score_Totals.Participant ";
//echo $get_y1_scores;
include "../include/dbconnopen.php";
$score_info = mysqli_query($cnnTRP, $get_y1_scores);
while ($score_array = mysqli_fetch_row($score_info)){
    fputcsv ($fp, $score_array);
}
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
                  <?php $infile="data/db_classrooms.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Teacher Exchange ID", "Participant ID", "Classroom", "Home Teacher", "Exchange Teacher", "Participant First Name", "Participant Last Name");
fputcsv($fp, $title_array);
$get_scores = "SELECT Teacher_Exchange_Rooms.*, First_Name, Last_Name FROM Teacher_Exchange_Rooms LEFT JOIN Participants ON Teacher_Exchange_Rooms.Participant_ID=Participants.Participant_ID";
//echo $get_scores;
include "../include/dbconnopen.php";
$score_info = mysqli_query($cnnTRP, $get_scores);
while ($score_array = mysqli_fetch_row($score_info)){
    fputcsv ($fp, $score_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>   <a href="<?echo $infile?>">With identifying information</a>
</td><td class="all_projects">
        <?php $infile="data/deid_classrooms.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Teacher Exchange ID", "Participant ID", "Classroom", "Home Teacher", "Exchange Teacher");
fputcsv($fp, $title_array);
$get_scores = "SELECT Teacher_Exchange_Rooms.* FROM Teacher_Exchange_Rooms";
include "../include/dbconnopen.php";
$people_info = mysqli_query($cnnTRP, $get_scores);
while ($people_array = mysqli_fetch_row($people_info)){
    fputcsv ($fp, $people_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Without identifying information</a></td></tr>
    
            
</table><br/></br>

<?
	include "../../footer.php";
?>
