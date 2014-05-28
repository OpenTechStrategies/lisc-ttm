<?php
include "../../header.php";
include "../header.php";
//include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
?>
<!--Export everything, with or without identifiers.  This will change once Taryn gets me her new requirements,
so I'm not going to put too many comments in now.  It's fairly self-explanatory.  Each table (sometimes
joined) gets put into a file, which can be downloaded.
-->
<script type="text/javascript">
	$(document).ready(function() {
		$('#reports_selector').addClass('selected');
	});
</script>

<h3>Export All Database Contents</h3><hr/><br/>

<table class="all_projects">
<tr><th width="50%"></th><th>De-identified (if applicable)</th></tr>
<tr><td class="all_projects">
<?php $infile="export_data/institutions.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Institution ID", "Institution Name", "Street Number", "Street Direction", "Street Name", 
        "Street Type", "Institution Type");
fputcsv($fp, $title_array);
$get_insts = "SELECT * FROM Institutions INNER JOIN Institution_Types ON 
Institutions.Institution_Type=Institution_Types.Institution_Type_ID;";
include "../include/dbconnopen.php";
$inst_info = mysqli_query($cnnLSNA, $get_insts);
while ($inst = mysqli_fetch_array($inst_info)){
    $inst_array=array($inst['Institution_ID'], $inst['Institution_Name'], $inst['Street_Num'], $inst['Street_Direction'],
        $inst['Street_Name'], $inst['Street_Type'], $inst['Institution_Type_Name']);
    fputcsv ($fp, $inst_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?><br/>
<strong>All Institutions</strong><br/>
<a href="<?echo $infile?>">Download the CSV file of all institutions.</a><br/><br/></td>
<td class="all_projects">
<?php $infile="export_data/deid_institutions.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Institution ID", "Institution Name", "Institution Type");/*"Block Group", */
fputcsv($fp, $title_array);
$get_insts = "SELECT Institution_ID, Institution_Name,
    Institution_Type_Name FROM Institutions INNER JOIN Institution_Types ON 
    Institutions.Institution_Type=Institution_Types.Institution_Type_ID;";  /* Block_Group,*/
//echo $get_insts;
include "../include/dbconnopen.php";
$inst_info = mysqli_query($cnnLSNA, $get_insts);
while ($inst = mysqli_fetch_row($inst_info)){
   // $this_address=$inst[2]." " . $inst[3] . " " . $inst[4] ." ". $inst[5] ;
   // $block_group=do_it_all($this_address, $map);
    $all_array=array($inst[0], $inst[1], /*$block_group,*/ $inst[6]);
    fputcsv ($fp, $inst);
}
include "../include/dbconnclose.php";
fclose($fp);
?><br/>
<strong>De-identified Institutions</strong><br/>
<a href="<?echo $infile?>">Download the CSV file of all institutions.</a><br/><br/>
</td></tr>



<tr><td class="all_projects"><br/>
<strong>All Parent Mentor Attendance</strong> 

<?php $infile="export_data/pm_attendance.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Parent Mentor ID", "Number of Days Attended", "Month", "Year", "Maximum Days Possible", 
        "Institution Name");
fputcsv($fp, $title_array);
$get_insts = "SELECT Parent_Mentor_ID, Num_Days_Attended, Month, Year, Max_Days_Possible, Institution_Name
FROM PM_Actual_Attendance INNER JOIN PM_Possible_Attendance 
ON PM_Actual_Attendance.Possible_Attendance_ID=PM_Possible_Attendance.PM_Possible_Attendance_ID
LEFT JOIN Institutions_Participants ON PM_Actual_Attendance.Parent_Mentor_ID=
Institutions_Participants.Participant_ID
LEFT JOIN Institutions ON Institutions_Participants.Institution_ID=Institutions.Institution_ID
WHERE Is_PM=1;";
//echo $get_insts;
include "../include/dbconnopen.php";
$inst_info = mysqli_query($cnnLSNA, $get_insts);
while ($inst = mysqli_fetch_row($inst_info)){
    fputcsv ($fp, $inst);
}
include "../include/dbconnclose.php";
fclose($fp);
?><br/>
<a href="<?echo $infile?>">Download the CSV file of all parent mentor attendance.</a><span class="helptext">  Does not currently include personal
    information on individual parent mentors.</span><br/><br/>
    </td><td class="all_projects">---------</td></tr>
<tr><td class="all_projects"><br/>
<strong>All Parent Mentor Children Information</strong> 

<?php $infile="export_data/pm_children.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Child ID", "Quarter", "Reading Grade", "Math Grade", "Number of Suspensions", 
        "Number of Office Referrals", "Days Absent", "Child First Name", "Child Last Name", "Child Age", "Child Gender", "Child Date of Birth",
    "Child Grade Level", "Parent First Name", "Parent Last Name", "Spouse First Name", "Spouse Last Name");
fputcsv($fp, $title_array);
$get_kids = "SELECT  child_table.*, parent_table.Participant_ID as parent_id, parent_table.Name_First as parent_name, parent_table.Name_Last as parent_surname,
    spouse_table.Name_First as spouse_name, spouse_table.Name_Last as spouse_surname, PM_Children_Info.* 
FROM Parent_Mentor_Children 
LEFT JOIN Participants as child_table ON Parent_Mentor_Children.Child_ID=child_table.Participant_ID
LEFT JOIN PM_Children_Info ON Parent_Mentor_Children.Child_ID=PM_Children_Info.Child_ID 
LEFT JOIN Participants as parent_table ON Parent_Mentor_Children.Parent_ID=parent_table.Participant_ID
LEFT JOIN Participants as spouse_table ON Parent_Mentor_Children.Spouse_ID=spouse_table.Participant_ID;";
//echo $get_kids;
include "../include/dbconnopen.php";
$child_info = mysqli_query($cnnLSNA, $get_kids);
while ($child = mysqli_fetch_array($child_info)){
    $child_array=array($child['Child_ID'], $child['Quarter'], $child['Reading_Grade'], $child['Math_Grade'],
        $child['Num_Suspensions'], $child['Num_Office_Referrals'], $child['Days_Absent'], $child['Name_First'], $child['Name_Last'],
        $child['Age'], $child['Gender'], $child['Date_of_Birth'], $child['Grade_Level'], $child['parent_name'], $child['parent_surname'],
        $child['spouse_name'], $child['spouse_surname']);
    fputcsv ($fp, $child_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?><br/>
<a href="<?echo $infile?>">Download the CSV file of all parent mentor children.</a><br/><span class="helptext">  Includes grades and disciplinary records.</span><br>
<br>
    </td><td class="all_projects"><br/>
<strong>De-identified Parent Mentor Children Information</strong><br/>
<?php $infile="export_data/pm_children_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Child ID",/* "Block Group",*/ "Ward", "Age", "Gender", "Grade Level", "Parent ID", "Link ID", "Child ID (repeat)", "Quarter", "Reading Grade", "Math Grade", "Number of Suspensions", 
        "Number of Office Referrals", "Days Absent", "School Year");
fputcsv($fp, $title_array);
$get_kids = "SELECT  child_table.Participant_ID,  child_table.Ward, child_table.Age, child_table.Gender, child_table.Grade_Level,
    parent_table.Participant_ID as parent_id, PM_Children_Info.* 
FROM Parent_Mentor_Children LEFT JOIN Participants as child_table ON Parent_Mentor_Children.Child_ID=child_table.Participant_ID
 LEFT JOIN PM_Children_Info ON Parent_Mentor_Children.Child_ID=PM_Children_Info.Child_ID 
LEFT JOIN Participants as parent_table ON Parent_Mentor_Children.Parent_ID=parent_table.Participant_ID;"; //child_table.Block_Group,
include "../include/dbconnopen.php";
$child_info = mysqli_query($cnnLSNA, $get_kids);
while ($child = mysqli_fetch_row($child_info)){
    /*$child_array=array($child['Child_ID'], $child['Quarter'], $child['Reading_Grade'], $child['Math_Grade'],
        $child['Num_Suspensions'], $child['Num_Office_Referrals'], $child['Days_Absent'], 
        $child['Age'], $child['Gender'], $child['Grade_Level'], $child['parent_id']);*/
    fputcsv ($fp, $child);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of Parent Mentor's children.</a><br/><span class="helptext">  Includes grades and disciplinary records.</span><br>
<br>
    </td></tr>

<tr><td class="all_projects">

<br/><strong>All Teacher Pre-Surveys </strong><br/>

<?$infile="export_data/teacher_pre_surveys.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Teacher Survey ID", "School ID", "Teacher Name", "Grade", "Classroom Language", "Years in PM Program", "Languages", 
        "Years as a Teacher", "Years at School", "Number of Students", "Number of English Language Learners" , "Number of IEP Students",
    "Number of students below grade level", "PM Activities Training", "Teacher Activities Training", "grade papers",
"tutor students one on one",
"lead part of the class in an activity",
"take children to the washroom etc",
"help with discipline/disruptions",
"check homework",
"work with small groups of students",
"lead the whole class in an activity",
"help organize the classroom",
"other",
    "Task Text",
        'A. Have another teacher or paraprofessional working with you in your classroom?', 
        'B.Have a parent volunteer or parent mentor in your classroom working with students?',
        'C.Talk with at least one school parent face-to-face?',
        'D.Have a conversation with a school parent about something besides their child\'s progress or behavior?', 
        'E.Have time for YOU to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'F.Have another adult (volunteer or staff) to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'G.Have time for YOU to work with 4 or more of your struggling students one-on-one for 10 minutes or more?', 
        'H.Have another adult (volunteer or staff) to work with 4 or more of your struggling students one-on-one for 10 minutes or more?',
        'I.Learn something new about the community in which your school is located?',
        'J.Ask a school parent for advice?', 'K.How many school parents did you greet by name?',
        'L.How many school parents do you have phone numbers or emails for besides a school directory?',
    "Parent Mentor ID", "Date Survey Entered", "Parent Mentor First Name", "Parent Mentor Last Name", "School Name");
fputcsv($fp, $title_array);
$legend_array=array('', '', '', '', '1=Bilingual; 2=Regular; 3=Other', '', '1=English; 2=Spanish; 3=Other; 4=Both English and Spanish',
        '', '', '', '', '', '', '', '', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', 
        '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 
        'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', '', '', '', '', '');
fputcsv($fp, $legend_array);
$get_pre_surveys = "SELECT PM_Teacher_Survey.*, Participants.Name_First, Participants.Name_Last, Institutions.Institution_Name 
    FROM PM_Teacher_Survey INNER JOIN Participants 
    ON PM_Teacher_Survey.Parent_Mentor_ID=Participants.Participant_ID
    LEFT JOIN Institutions ON Institutions.Institution_ID=PM_Teacher_Survey.School_Name;";
//echo $get_pre_surveys;
include "../include/dbconnopen.php";
$pre_surveys = mysqli_query($cnnLSNA, $get_pre_surveys);
while ($pre = mysqli_fetch_row($pre_surveys)){
    fputcsv ($fp, $pre);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of all teacher pre-surveys.</a><br>
<br>
    </td><td class="all_projects">
<br/>
<strong>De-identified Teacher Pre-Surveys</strong><br/>

<?$infile="export_data/teacher_pre_surveys_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Teacher Survey ID", "School ID", "Teacher ID", "Grade", "Classroom Language", "Years in PM Program", "Languages", 
        "Years as a Teacher", "Years at School", "Number of Students", "Number of English Language Learners" , "Number of IEP Students",
    "Number of students below grade level", "PM Activities Training", "Teacher Activities Training", "grade papers",
"tutor students one on one",
"lead part of the class in an activity",
"take children to the washroom etc",
"help with discipline/disruptions",
"check homework",
"work with small groups of students",
"lead the whole class in an activity",
"help organize the classroom",
"other",
    "Task Text",
        'A. Have another teacher or paraprofessional working with you in your classroom?', 
        'B.Have a parent volunteer or parent mentor in your classroom working with students?',
        'C.Talk with at least one school parent face-to-face?',
        'D.Have a conversation with a school parent about something besides their child\'s progress or behavior?', 
        'E.Have time for YOU to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'F.Have another adult (volunteer or staff) to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'G.Have time for YOU to work with 4 or more of your struggling students one-on-one for 10 minutes or more?', 
        'H.Have another adult (volunteer or staff) to work with 4 or more of your struggling students one-on-one for 10 minutes or more?',
        'I.Learn something new about the community in which your school is located?',
        'J.Ask a school parent for advice?', 'K.How many school parents did you greet by name?',
        'L.How many school parents do you have phone numbers or emails for besides a school directory?',
    "Parent Mentor ID", "Date Survey Entered",  "School Name");
fputcsv($fp, $title_array);
$legend_array=array('', '', '', '', '1=Bilingual; 2=Regular; 3=Other', '', '1=English; 2=Spanish; 3=Other; 4=Both English and Spanish',
        '', '', '', '', '', '', '', '', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', 
        '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 
        'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', '', '', '', '', '');
fputcsv($fp, $legend_array);
$get_pre_surveys = "SELECT PM_Teacher_Survey.*, Institutions.Institution_Name 
    FROM PM_Teacher_Survey INNER JOIN Participants 
    ON PM_Teacher_Survey.Parent_Mentor_ID=Participants.Participant_ID
    LEFT JOIN Institutions ON Institutions.Institution_ID=PM_Teacher_Survey.School_Name;";
//echo $get_pre_surveys;
include "../include/dbconnopen.php";
$pre_surveys = mysqli_query($cnnLSNA, $get_pre_surveys);
while ($pre = mysqli_fetch_row($pre_surveys)){
    fputcsv ($fp, $pre);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of teacher pre-surveys.</a> <br>
<br>
    </td></tr>

<tr><td class="all_projects"><br/>
<strong>All Teacher Post-Surveys </strong>

<?$infile="export_data/teacher_post_surveys.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Teacher Survey ID", "School ID", "Teacher Name", "Grade", "Classroom Language", "Attendance", "grade papers",
"tutor students one on one",
"lead part of the class in an activity",
"take children to the washroom etc",
"help with discipline/disruptions",
"check homework",
"work with small groups of students",
"lead the whole class in an activity",
"help organize the classroom",
"other",
    "Task Text",
    "Majority Task",
    "Having the support of a Parent Mentor helps me achieve or maintain good classroom management.",
    " Having the support of a Parent Mentor helps me improve homework completion and helps me maintain a high expectatin for homework in my classroom.",
    "Having the support of a Parent Mentor helps me improve students in reading and/or math.",
    "Having a Parent Mentor strengthens my understanding of or connection to the community.",
    "Having a Parent Mentor strengthens student social-emotional development.",
    "The Parent Mentor Program helps our school create a welcoming and communicative environment for all parents.",
    "The Parent Mentor Program helps our school build parent-teacher trust.",
    "The Parent Mentor Program helps teachers and parents to think of each other as partners in educating.",
    "PM Activities Training", "Teacher Activities Training", 
    "Comments",
        'A. Have another teacher or paraprofessional working with you in your classroom?', 
        'B.Have a parent volunteer or parent mentor in your classroom working with students?',
        'C.Talk with at least one school parent face-to-face?',
        'D.Have a conversation with a school parent about something besides their child\'s progress or behavior?', 
        'E.Have time for YOU to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'F.Have another adult (volunteer or staff) to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'G.Have time for YOU to work with 4 or more of your struggling students one-on-one for 10 minutes or more?', 
        'H.Have another adult (volunteer or staff) to work with 4 or more of your struggling students one-on-one for 10 minutes or more?',
        'I.Learn something new about the community in which your school is located?',
        'J.Ask a school parent for advice?', 'K.How many school parents did you greet by name?',
        'L.How many school parents do you have phone numbers or emails for besides a school directory?',
    "Parent Mentor ID", "Date Survey Entered", "Explanation for 8", "Explanation for 9", "Explanation for 10",
    "Explanation for 11", "Explanation for 12", "Explanation for 13", "Explanation for 14", "Explanation for 15", "Parent Mentor First Name", "Parent Mentor Last Name", "School Name");
fputcsv($fp, $title_array);
$legend_array=array('', '', '', '', '1=Bilingual; 2=Regular; 3=Other', 
    '1=Never missed a day of work; 2=Missed occasionally but always communicated; 3=Missed occasionally without notice; 4=Had irregular attendance and couldn\'t be counted on; 5=Left mid-semester without notice', 
    '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', 
        '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '', '', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer',
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '', '', '',
    'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 
        'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 
    'Number of parents', 'Number of parents', '', '', '', '', '');
fputcsv($fp, $legend_array);
$get_pre_surveys = "SELECT PM_Teacher_Survey_Post.*, Participants.Name_First, Participants.Name_Last, Institutions.Institution_Name 
    FROM PM_Teacher_Survey_Post INNER JOIN Participants 
    ON PM_Teacher_Survey_Post.Parent_Mentor_ID=Participants.Participant_ID
    LEFT JOIN Institutions ON Institutions.Institution_ID=PM_Teacher_Survey_Post.School_Name;";
//echo $get_pre_surveys;
include "../include/dbconnopen.php";
$pre_surveys = mysqli_query($cnnLSNA, $get_pre_surveys);
while ($pre = mysqli_fetch_row($pre_surveys)){
    fputcsv ($fp, $pre);
}
include "../include/dbconnclose.php";
fclose($fp);
?><br/>
<a href="<?echo $infile?>">Download the CSV file of all teacher post-surveys.</a><br>
<br>
    </td><td class="all_projects"><strong>De-identified Teacher Post-Surveys</strong><br/>

<?$infile="export_data/teacher_post_surveys_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Teacher Survey ID", "School ID", "Teacher ID", "Grade", "Classroom Language", "Attendance", "grade papers",
"tutor students one on one",
"lead part of the class in an activity",
"take children to the washroom etc",
"help with discipline/disruptions",
"check homework",
"work with small groups of students",
"lead the whole class in an activity",
"help organize the classroom",
"other",
    "Task Text",
    "Majority Task",
    "Having the support of a Parent Mentor helps me achieve or maintain good classroom management.",
    " Having the support of a Parent Mentor helps me improve homework completion and helps me maintain a high expectatin for homework in my classroom.",
    "Having the support of a Parent Mentor helps me improve students in reading and/or math.",
    "Having a Parent Mentor strengthens my understanding of or connection to the community.",
    "Having a Parent Mentor strengthens student social-emotional development.",
    "The Parent Mentor Program helps our school create a welcoming and communicative environment for all parents.",
    "The Parent Mentor Program helps our school build parent-teacher trust.",
    "The Parent Mentor Program helps teachers and parents to think of each other as partners in educating.",
    "PM Activities Training", "Teacher Activities Training", 
    "Comments",
        'A. Have another teacher or paraprofessional working with you in your classroom?', 
        'B.Have a parent volunteer or parent mentor in your classroom working with students?',
        'C.Talk with at least one school parent face-to-face?',
        'D.Have a conversation with a school parent about something besides their child\'s progress or behavior?', 
        'E.Have time for YOU to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'F.Have another adult (volunteer or staff) to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'G.Have time for YOU to work with 4 or more of your struggling students one-on-one for 10 minutes or more?', 
        'H.Have another adult (volunteer or staff) to work with 4 or more of your struggling students one-on-one for 10 minutes or more?',
        'I.Learn something new about the community in which your school is located?',
        'J.Ask a school parent for advice?', 'K.How many school parents did you greet by name?',
        'L.How many school parents do you have phone numbers or emails for besides a school directory?',
    "Parent Mentor ID", "Date Survey Entered", "Explanation for 8", "Explanation for 9", "Explanation for 10",
    "Explanation for 11", "Explanation for 12", "Explanation for 13", "Explanation for 14", "Explanation for 15", "School Name");
fputcsv($fp, $title_array);
$legend_array=array('', '', '', '', '1=Bilingual; 2=Regular; 3=Other', 
    '1=Never missed a day of work; 2=Missed occasionally but always communicated; 3=Missed occasionally without notice; 4=Had irregular attendance and couldn\'t be counted on; 5=Left mid-semester without notice', 
    '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', 
        '1=Yes; 0=No', '1=Yes; 0=No', '1=Yes; 0=No', '', '', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer',
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '', '', '',
    'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 
        'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 
    'Number of parents', 'Number of parents', '', '', '', '', '');
fputcsv($fp, $legend_array);
$get_pre_surveys = "SELECT PM_Teacher_Survey_Post.*, Institutions.Institution_Name 
    FROM PM_Teacher_Survey_Post INNER JOIN Participants 
    ON PM_Teacher_Survey_Post.Parent_Mentor_ID=Participants.Participant_ID
    LEFT JOIN Institutions ON Institutions.Institution_ID=PM_Teacher_Survey_Post.School_Name;";
//echo $get_pre_surveys;
include "../include/dbconnopen.php";
$pre_surveys = mysqli_query($cnnLSNA, $get_pre_surveys);
while ($pre = mysqli_fetch_row($pre_surveys)){
    fputcsv ($fp, $pre);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of teacher post-surveys.</a>
<br></td></tr>

<tr><td class="all_projects">
<br/>
<strong>All Parent Mentor Surveys </strong>
<?$infile="export_data/pm_surveys.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Survey ID", "Participant ID", "Date", "School ID", "Grade", "Room Number", "First Year Parent Mentor", "Number of Children",
    "Marital Status", "Place of Birth", "Years in IL", "Classes Currently Enrolled In", "Currently Working", "Current Job", "Monthly Income", "On Food Stamps",
    "Rent or Own", "Rent Payment",        'A.Ask your child about school?', 'B.Talk with your child’s teacher?', 'C.Talk with the school principal?',
        'D. Talk with other parents from the school?', 'E.Spend time inside the school building?', 'F.Spend time inside a classroom?',
        'G.Help your child with schoolwork at home?', 'H.Read with your child at home?', 'I.How many other parents from the school did you greet by name?',
        'J.How many teachers in the school did you greet by name?', 'K.How many school parents do you have phone numbers or emails for?',
        'L.How many teachers do you have phone numbers or emails for?', 'M.Attend parent committee meetings?', 'N.Help lead a school committee?',
        'O.Help plan school events activities or initiatives?', 'P.Attend a meeting or get involved in a community activity outside of the school?',
        'Q.Share information about the school or the community with other parents in the neighborhood?', 'R.Attend a class for yourself?',
    'Pre or Post?',
        'Q. I will be able to achieve most of the goals that I have set for myself.', 'R. When facing difficult task I am certain that I will accomplish them.',
        'S. In general I think that I can obtain outcomes that are important to me.', 'T. I believe I can succeed at most any endeavor to which I set my mind.',
        'U. I will be able to successfully overcome many challenges.', 'V. I am confident that I can perform effectively on many different tasks.',
        'W. Compared to other people I can do most tasks very well.', 'X. Even when things are tough I can perform quite well.', "PM First Name", "PM Last Name",
    "School Name");
fputcsv($fp, $title_array);
$legend_array=array('', '', '', '', '', '', '1=Yes; 0=No', '', '', '', '', '', '1=Yes; 0=No', '', '', '1=Yes; 0=No', 
    '', '', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 
    'Number of parents/teachers', 'Number of parents/teachers', 'Number of parents/teachers', 'Number of parents/teachers', 
    'Days per month', 'Days per month', 'Days per month', 'Days per month', 'Days per month', 'Days per month', '1=Pre; 2=Mid; 3=Post',
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
     '', '', '');
fputcsv($fp, $legend_array);
$get_pm_surveys = "SELECT Parent_Mentor_Survey.*, Participants.Name_First, Participants.Name_Last, Institutions.Institution_Name 
    FROM Parent_Mentor_Survey INNER JOIN Participants 
    ON Parent_Mentor_Survey.Participant_ID=Participants.Participant_ID
    LEFT JOIN Institutions ON Institutions.Institution_ID=Parent_Mentor_Survey.School;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?><br/>
<a href="<?echo $infile?>">Download the CSV file of all parent mentor surveys.</a><br><br/>
    </td>
<td class="all_projects">
<br/><strong>De-identified Parent Mentor Surveys</strong><br/>
<?$infile="export_data/pm_surveys_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Survey ID", "PM ID", "Date", "School ID", "Grade", "Room Number", "First Year Parent Mentor", "Number of Children",
    "Marital Status", "Place of Birth", "Years in IL", "Classes Currently Enrolled In", "Currently Working", "Current Job", "Monthly Income", "On Food Stamps",
    "Rent or Own", "Rent Payment",        'A.Ask your child about school?', 'B.Talk with your child’s teacher?', 'C.Talk with the school principal?',
        'D. Talk with other parents from the school?', 'E.Spend time inside the school building?', 'F.Spend time inside a classroom?',
        'G.Help your child with schoolwork at home?', 'H.Read with your child at home?', 'I.How many other parents from the school did you greet by name?',
        'J.How many teachers in the school did you greet by name?', 'K.How many school parents do you have phone numbers or emails for?',
        'L.How many teachers do you have phone numbers or emails for?', 'M.Attend parent committee meetings?', 'N.Help lead a school committee?',
        'O.Help plan school events activities or initiatives?', 'P.Attend a meeting or get involved in a community activity outside of the school?',
        'Q.Share information about the school or the community with other parents in the neighborhood?', 'R.Attend a class for yourself?',
        'Q. I will be able to achieve most of the goals that I have set for myself.', 'R. When facing difficult task I am certain that I will accomplish them.',
        'S. In general I think that I can obtain outcomes that are important to me.', 'T. I believe I can succeed at most any endeavor to which I set my mind.',
        'U. I will be able to successfully overcome many challenges.', 'V. I am confident that I can perform effectively on many different tasks.',
        'W. Compared to other people I can do most tasks very well.', 'X. Even when things are tough I can perform quite well.', 
    "School Name");
fputcsv($fp, $title_array);
$legend_array=array('', '', '', '', '', '', '1=Yes; 0=No', '', '', '', '', '', '1=Yes; 0=No', '', '', '1=Yes; 0=No', 
    '', '', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 'Days per week', 
    'Number of parents/teachers', 'Number of parents/teachers', 'Number of parents/teachers', 'Number of parents/teachers', 
    'Days per month', 'Days per month', 'Days per month', 'Days per month', 'Days per month', 'Days per month', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
    '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', '5=Strongly agree; 4=Agree; 3=Neutral; 2=Disagree; 1=Strongly disagree; 0=No answer', 
     '', '', '');
fputcsv($fp, $legend_array);
$get_pm_surveys = "SELECT Parent_Mentor_Survey.*, Institutions.Institution_Name 
    FROM Parent_Mentor_Survey INNER JOIN Participants 
    ON Parent_Mentor_Survey.Participant_ID=Participants.Participant_ID
    LEFT JOIN Institutions ON Institutions.Institution_ID=Parent_Mentor_Survey.School;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of parent mentor surveys.</a><br>
<br>
</td></tr>

<tr>
    <td class="all_projects">
<br/>
<strong>Parent Mentors by year</strong>
<br/>
<?$infile="export_data/pms_over_time.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("ID", "Participant ID", "School ID", "Parent Mentor First Name", "Parent Mentor Last Name", "School Name", "School Year");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT PM_Year_ID, PM_Years.Participant, PM_Years.School,
Name_First, Name_Last, Institution_Name, Year FROM PM_Years 
INNER JOIN Participants ON Participant=Participant_ID
INNER JOIN Institutions ON School=Institution_ID ORDER BY Name_Last;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of parent mentors by year and school.</a><br><br/>
    </td>
       <td class="all_projects">
<br/>
<strong>De-identified Parent Mentors by year</strong>
<br/>
<?$infile="export_data/deid_pms_over_time.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("ID", "Participant ID", "School ID", "School Name", "School Year");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT PM_Year_ID, PM_Years.Participant, PM_Years.School,
 Institution_Name, Year FROM PM_Years 
INNER JOIN Participants ON Participant=Participant_ID
INNER JOIN Institutions ON School=Institution_ID ORDER BY Name_Last;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of parent mentors by year and school.</a><br><br/>
    </td>
    
</tr>

<tr><td class="all_projects">
<br/>
<strong>All Participants</strong>
<br/>
<?$infile="export_data/all_participants.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Participant_ID", "First Name", "Middle Name", "Last Name", "Address Street Name", "Address Street Number", 
        "Address Street Direction", "Address Street Type", "City", "State", "Zipcode", "Daytime Phone", "Evening Phone", "Education Level",
    "Email", "Age", "Gender", "Date of Birth", "Grade Level", "Is Parent Mentor?", "Is a child?", "Notes");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT * FROM Participants";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of all participants.</a><br><br/>
    </td><td class="all_projects">

<br/><strong>De-identified Participant Information</strong><br/>

<?php $infile="export_data/all_participants_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Participant_ID", /*"Block Group",*/ "Education Level", 
    "Age", "Gender", "Grade Level", "Is Parent Mentor?", "Child=1; Youth=2; Adult=3 (or blank)");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT Participant_ID, Education_Level, 
    Age, Gender, Grade_Level,
    Is_PM, Is_Child FROM Participants"; //Block_Group,
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
   // $this_address=$survey[2]." " . $survey[3] . " " . $survey[4] ." ". $survey[5] ;
   // $block_group=do_it_all($this_address, $map);
   // $all_array=array($survey[0], $survey[1], $survey[6], $survey[7], $survey[8], $survey[9], $survey[10]);
   // $all_array=array($survey[0], $block_group, $survey[1], $survey[6], $survey[7], $survey[8], $survey[9], $survey[10]);
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of participants.</a><br>
<br>
    </td></tr>
<tr><td class="all_projects">
<br/>
<strong>All Programs and Campaigns</strong>


<?$infile="export_data/all_subcategories.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Subcategory_ID", "Subcategory_Name", "Campaign_or_Program", "Category_Name");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT Subcategories.Subcategory_ID, Subcategory_Name, Campaign_or_Program, Category_Name FROM Subcategories INNER JOIN (Category_Subcategory_Links, Categories) ON
(Subcategories.Subcategory_ID=Category_Subcategory_Links.Subcategory_ID AND Category_Subcategory_Links.Category_ID=Categories.Category_ID);";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?><br/>
<a href="<?echo $infile?>">Download the CSV file of all programs and campaigns.</a><br>
<br>
    </td><td class="all_projects">---------</td></tr>
<tr><td class="all_projects"><br/>
<strong>All Satisfaction Surveys (3rd grade and younger)</strong>

<?$infile="export_data/satisfaction_surveys_3.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Survey ID", "Participant ID", "Program ID", "Question 1", "Question 2",
        "Question 3", "Question 4", "Question 5", "Question 6", "Question 7", "Question 8", "Question 9", "Question 10", "Question 11", 
    "Ignore this column", "Date", "Version", "First Name", "Last Name", "Age", "Gender", "Program Name");
fputcsv($fp, $title_array);
$legend_array=array('','','', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', 
        '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;',
        '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;',
        '', '', '3=3rd Grade and Younger; 4=4th grade and up;', '', '', '', '', '');
fputcsv($fp, $legend_array);
$get_pm_surveys = "SELECT Satisfaction_Surveys.*, Name_First, Name_Last, Age, Gender, Subcategory_Name FROM Satisfaction_Surveys INNER JOIN (Subcategories, Participants)
ON (Satisfaction_Surveys.Program_ID=Subcategories.Subcategory_ID AND Satisfaction_Surveys.Participant_ID=Participants.Participant_ID) WHERE Version=3;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?><br/>
<a href="<?echo $infile?>">Download the CSV file of all satisfaction surveys (3rd grade and younger).</a><br><br/>
    </td><td class="all_projects">

<br/><strong>De-identified Satisfaction Surveys (3rd grade and younger)</strong><br/>

<?$infile="export_data/satisfaction_surveys_3_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Survey ID", "Participant ID", "Program ID", "Question 1", "Question 2",
        "Question 3", "Question 4", "Question 5", "Question 6", "Question 7", "Question 8", "Question 9", "Question 10", "Question 11", 
    "Ignore this column", "Date", "Version", "Age", "Gender", "Program Name");
fputcsv($fp, $title_array);
$legend_array=array('','','', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', 
        '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;',
        '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;',
        '', '', '3=3rd Grade and Younger; 4=4th grade and up;', '', '', '', '', '');
fputcsv($fp, $legend_array);
$get_pm_surveys = "SELECT Satisfaction_Surveys.*, Age, Gender, Subcategory_Name FROM Satisfaction_Surveys INNER JOIN (Subcategories, Participants)
ON (Satisfaction_Surveys.Program_ID=Subcategories.Subcategory_ID AND Satisfaction_Surveys.Participant_ID=Participants.Participant_ID) WHERE Version=3;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of satisfaction surveys (3rd grade and younger).</a><br><br/>
    </td></tr>
<tr><td class="all_projects">

<br/>

<strong>All Satisfaction Surveys (4th grade and older) </strong>
<br/>
<?$infile="export_data/satisfaction_surveys_4.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Survey ID", "Participant ID", "Program ID", "Question 1", "Question 2",
        "Question 3", "Question 4", "Question 5", "Question 6", "Question 7", "Question 8", "Question 9", "Question 10", "Question 11", 
    "Question 12", "Date", "Version", "First Name", "Last Name", "Age", "Gender", "Program Name");
fputcsv($fp, $title_array);
$legend_array=array('','','', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', 
        '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;',
        '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;',
        '', '', '3=3rd Grade and Younger; 4=4th grade and up;', '', '', '', '', '');
fputcsv($fp, $legend_array);
$get_pm_surveys = "SELECT Satisfaction_Surveys.*, Name_First, Name_Last, Age, Gender, Subcategory_Name FROM Satisfaction_Surveys INNER JOIN (Subcategories, Participants)
ON (Satisfaction_Surveys.Program_ID=Subcategories.Subcategory_ID AND Satisfaction_Surveys.Participant_ID=Participants.Participant_ID) WHERE Version=4;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of all satisfaction surveys (4th grade and older).</a><br><br/>
    </td><td class="all_projects">
<br/><strong>De-identified Satisfaction Surveys (4th grade and older)</strong><br/>

<?$infile="export_data/satisfaction_surveys_4_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Survey ID", "Participant ID", "Program ID", "Question 1", "Question 2",
        "Question 3", "Question 4", "Question 5", "Question 6", "Question 7", "Question 8", "Question 9", "Question 10", "Question 11", 
    "Question 12", "Date", "Version", "Age", "Gender", "Program Name");
fputcsv($fp, $title_array);
$legend_array=array('','','', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', 
        '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;',
        '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;', '1=Yes; 2=Maybe; 3=No; 0=No Answer;',
        '', '', '3=3rd Grade and Younger; 4=4th grade and up;', '', '', '', '', '');
fputcsv($fp, $legend_array);
$get_pm_surveys = "SELECT Satisfaction_Surveys.*, Age, Gender, Subcategory_Name FROM Satisfaction_Surveys INNER JOIN (Subcategories, Participants)
ON (Satisfaction_Surveys.Program_ID=Subcategories.Subcategory_ID AND Satisfaction_Surveys.Participant_ID=Participants.Participant_ID) WHERE Version=4;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of satisfaction surveys (4th grade and older).</a><br><br/>
    </td></tr>
<tr>
<tr><td class="all_projects">
<br/>
<strong>All Program/Campaign Attendance</strong>
<br/>
<?$infile="export_data/attendance.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Participant ID", "Type of Participation", "Date", "Activity Name",
    "Activity Type", "Program/Campaign Name", "Campaign or Program",  "First Name", "Last Name");
fputcsv($fp, $title_array);
$get_attendance = "SELECT Subcategory_Attendance.Participant_ID, Type_of_Participation, Date, Activity_Name, Activity_Type,
Subcategory_Name, Campaign_or_Program, Name_First, Name_Last FROM Subcategory_Attendance INNER JOIN (Subcategory_Dates, Subcategories, Participants) ON 
    (Subcategory_Attendance.Subcategory_Date=Subcategory_Dates.Wright_College_Program_Date_ID
    AND Subcategory_Dates.Subcategory_ID=Subcategories.Subcategory_ID
    AND Subcategory_Attendance.Participant_ID=Participants.Participant_ID );";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_attendance);
while ($survey= mysqli_fetch_row($survey_info)){
    //indicate participation type in words:
    if ($survey[1]==1){ $participation_type='Attendee';}
    elseif ($survey[1]==2){ $participation_type='Speaker';}
    elseif ($survey[1]==3){ $participation_type='Chairperson';}
    elseif ($survey[1]==4){ $participation_type='Prep work';}
    //indicate event type in words:
    if ($survey[4]==1){ $event_type='Leadership Meeting';}
    elseif ($survey[4]==2){ $event_type='Board Meeting';}
    elseif ($survey[4]==3){ $event_type='Rally/March';}
    elseif ($survey[4]==4){ $event_type='Press Conference';}
    elseif ($survey[4]==5){ $event_type='Doorknocking';}
    elseif ($survey[4]==6){ $event_type='Aldermanic Meeting';}
    elseif ($survey[4]==7){ $event_type='City Council Meeting';}
    elseif ($survey[4]==8){ $event_type='Legislative Meeting';}
    elseif ($survey[4]==9){ $event_type='Petitions/Postcards';}
    elseif ($survey[4]==10){ $event_type='Other';}
    
    $enter_array=array($survey[0],$participation_type, $survey[2], $survey[3], $event_type, $survey[5], $survey[6], $survey[7], $survey[8]);
    fputcsv ($fp, $enter_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of all program and campaign attendance.</a><br><br/>
</td><td class="all_projects">
<br/>
<strong>De-identified Program/Campaign Attendance</strong><br/>
<?$infile="export_data/attendance_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Participant ID", "Type of Participation", "Date", "Activity Name",
    "Activity Type", "Program/Campaign Name", "Campaign or Program");
fputcsv($fp, $title_array);
$get_attendance = "SELECT Subcategory_Attendance.Participant_ID, Type_of_Participation, Date, Activity_Name, Activity_Type,
Subcategory_Name, Campaign_or_Program  FROM Subcategory_Attendance INNER JOIN (Subcategory_Dates, Subcategories, Participants) ON 
    (Subcategory_Attendance.Subcategory_Date=Subcategory_Dates.Wright_College_Program_Date_ID
    AND Subcategory_Dates.Subcategory_ID=Subcategories.Subcategory_ID
    AND Subcategory_Attendance.Participant_ID=Participants.Participant_ID );";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_attendance);
while ($survey= mysqli_fetch_row($survey_info)){
    //indicate participation type in words:
    if ($survey[1]==1){ $participation_type='Attendee';}
    elseif ($survey[1]==2){ $participation_type='Speaker';}
    elseif ($survey[1]==3){ $participation_type='Chairperson';}
    elseif ($survey[1]==4){ $participation_type='Prep work';}
    //indicate event type in words:
    if ($survey[4]==1){ $event_type='Leadership Meeting';}
    elseif ($survey[4]==2){ $event_type='Board Meeting';}
    elseif ($survey[4]==3){ $event_type='Rally/March';}
    elseif ($survey[4]==4){ $event_type='Press Conference';}
    elseif ($survey[4]==5){ $event_type='Doorknocking';}
    elseif ($survey[4]==6){ $event_type='Aldermanic Meeting';}
    elseif ($survey[4]==7){ $event_type='City Council Meeting';}
    elseif ($survey[4]==8){ $event_type='Legislative Meeting';}
    elseif ($survey[4]==9){ $event_type='Petitions/Postcards';}
    elseif ($survey[4]==10){ $event_type='Other';}
    
    $enter_array=array($survey[0],$participation_type, $survey[2], $survey[3], $event_type, $survey[5], $survey[6], $survey[7], $survey[8]);
    fputcsv ($fp, $enter_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of program and campaign attendance.</a><br><br/>
</td></tr>
<tr><td class="all_projects">

<br/>
<strong>All Campaign Events</strong>
<br/>
<?$infile="export_data/events.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Date", "Event Name", "Event Type", "Campaign Name");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT Date, Activity_Name, Activity_Type,
Subcategory_Name FROM Subcategory_Dates INNER JOIN (Subcategories) ON 
    Subcategory_Dates.Subcategory_ID=Subcategories.Subcategory_ID WHERE Campaign_or_Program='Campaign';";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    if ($survey[2]==1){ $survey[2]='Leadership Meeting';}
    elseif ($survey[2]==2){ $survey[2]='Board Meeting';}
    elseif ($survey[2]==3){ $survey[2]='Rally/March';}
    elseif ($survey[2]==4){ $survey[2]='Press Conference';}
    elseif ($survey[2]==5){ $survey[2]='Doorknocking';}
    elseif ($survey[2]==6){ $survey[2]='Aldermanic Meeting';}
    elseif ($survey[2]==7){ $survey[2]='City Council Meeting';}
    elseif ($survey[2]==8){ $survey[2]='Legislative Meeting';}
    elseif ($survey[2]==9){ $survey[2]='Petitions/Postcards';}
    elseif ($survey[2]==10){ $survey[2]='Other';}
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of all campaign events.</a><br><br/>
    </td><td class="all_projects">---------</td></tr>
<tr><td class="all_projects">
<br/><strong>All School Records</strong>
<br/>
<?php $infile="export_data/scholastic_records.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Information ID", "Child ID", "Quarter", "Reading Grade", "Math Grade", "Number of Suspensions", "Number of Office Referrals",
        "Days Absent", "School Year", "First Name", "Last Name", "Gender", "Age", "Grade Level");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT PM_Children_Info.*, Name_First, Name_Last, Gender, Age, 
    Grade_Level FROM PM_Children_Info INNER JOIN Participants ON Participants.Participant_ID=PM_Children_Info.Child_ID;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of all school records.</a><br><br/>
    </td><td class="all_projects">

<br/><strong>De-identified School Records</strong><br/>

<?$infile="export_data/scholastic_records_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Information ID", "Child ID", "Quarter", "Reading Grade", "Math Grade", "Number of Suspensions", "Number of Office Referrals",
        "Days Absent", "School Year", "Gender", "Age", "Grade Level");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT PM_Children_Info.*, Gender, Age, 
    Grade_Level FROM PM_Children_Info INNER JOIN Participants ON Participants.Participant_ID=PM_Children_Info.Child_ID;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of school records.</a><br><br/>
    </td></tr>

<tr><td class="all_projects">
<br/><strong>All Issue Event Attendance</strong>
<br/>
<?php $infile="export_data/issue_events.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Information ID", "Person Name", "", "Person Contact", "", "Month", "Year", "Issue Area Event Type");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT Issue_Attendance_ID, Name_First, Name_Last, Phone_Day, Phone_Evening, Month, Year, Issue_Area FROM Issue_Attendance 
LEFT JOIN Issue_Areas ON Issue_Attendance.Issue_ID=Issue_Areas.Issue_ID
LEFT JOIN Participants ON Issue_Attendance.Participant_ID=Participants.Participant_ID;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?echo $infile?>">Download the CSV file of all specific issue event attendees.</a><br><br/>
    </td><td class="all_projects">

<br/><strong>De-identified School Records</strong><br/>

<?php $infile="export_data/issue_events_deidentified.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Information ID", "Person ID", "Month", "Year", "Issue Area Event Type");
fputcsv($fp, $title_array);
$get_pm_surveys = "SELECT Issue_Attendance_ID, Participant_ID, Month, Year, Issue_Area FROM Issue_Attendance 
LEFT JOIN Issue_Areas ON Issue_Attendance.Issue_ID=Issue_Areas.Issue_ID;";
include "../include/dbconnopen.php";
$survey_info = mysqli_query($cnnLSNA, $get_pm_surveys);
while ($survey= mysqli_fetch_row($survey_info)){
    fputcsv ($fp, $survey);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="<?php echo $infile; ?>">Download the CSV file of all specific issue event attendees (deidentified).</a><br><br/>
    </td>
</tr>

</table>
<br/><br/>
<?include "../../footer.php";?>
