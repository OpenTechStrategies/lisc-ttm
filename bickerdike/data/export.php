<?php
include "../../header.php";
include "../header.php";

//include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");

/*
 * Export everything, divided into identified and de-identified.
 */


/*Download all events - identified and deidentified are identical.
 * Not sure why this is not shown on the page.
 */
$infile="downloads/events.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("ID", "Event Name", "Event Date", "Event Created Date", "Event Type", 
        "Event Organization", "Event ID (obsolete)", "Notes");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM User_Established_Activities";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_row($money_info)){
    fputcsv ($fp, $money);
}
include "../include/dbconnclose.php";
fclose($fp);
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#data_selector').addClass('selected');
	});
</script>

<h3>Downloads</h3><hr/><br/>
<div id="download_list">
<table class="inner_table">
    <tr><th>Identified</th><th>De-identified</th></tr>
    
    <!--All aldermanic records.  Nothing to deidentify.-->
    
    <tr><td>
<?php
$title_array = array("ID", "Environmental_Improvement_Money", "Date");
$title_array_postable=serialize($title_array);

?>
            <a href="/include/generalized_download_script.php?download_name=aldermans_records">
                Download the CSV file of Aldermanic Records.</a>
</td>
        <td><br>
            <a href="/include/generalized_download_script.php?download_name=aldermans_records">
                Download</a></td></tr>
    
    
        <!--All bike trail records.  Nothing to deidentify.-->
    
<tr><td>

<a href="/include/generalized_download_script.php?download_name=bike_trail_records">Download the CSV file of bike trail records.</a><br></td>
    <td><a href="/include/generalized_download_script.php?download_name=bike_trail_records">Download.</a></td></tr>
    
    
        <!--All community wellness baseline records.  Nothing to deidentify.-->
    

<tr><td>
        <a href="/include/generalized_download_script.php?download_name=cws_baseline">Download the CSV file of Community Wellness Survey baselines.</a><br></td>
    <td><a href="/include/generalized_download_script.php?download_name=cws_baseline">Download.</a></td></tr>

    
    
        <!--All bike trail records.  Store IDs only in the de-id'd version.-->
    
<tr><td>
        <a href="/include/generalized_download_script.php?download_name=corner_stores">Download the CSV file of Corner Store Assessments.</a><br></td>
    <td>
<a href="include/generalized_download_script.php?download_name=corner_stores_deid">Download (no store names).</a></td></tr>
    
    
        <!--All healthy food sales records.-->
    

<tr><td>
<a href="/include/generalized_download_script.php?download_name=store_sales">Download the CSV file of store sales records.</a><br></td>
    <td><a href="/include/generalized_download_script.php?download_name=store_sales">Download.</a></td></tr>
    
    
        <!--All partner organizations.  Nothing to deidentify.-->
    

<tr><td>
<a href="/include/generalized_download_script.php?download_name=partner_orgs">Download the CSV file of organizational partners.</a><br></td>
    <td><a href="/include/generalized_download_script.php?download_name=partner_orgs">Download.</a></td></tr>
    
    
        <!--All surveys (attitude, behavior, knowledge about obesity).
        Person, the program they participated in, the organization that sponsored that program,
        their survey responses.
        -->
    

<tr><td>
        <a href="/include/generalized_download_script.php?download_name=all_surveys_bickerdike">
            Download the CSV file of participant surveys (all).</a><span class="helptext">
	    Does not include linked children.  If no program is selected, the survey will not show up in this export.
        </span></td>
            
    
        <!--All surveys (attitude, behavior, knowledge about obesity).
        No names.
        -->
    

    <td>
	<a href="/include/generalized_download_script.php?download_name=all_surveys_bickerdike_deid">Download (all).</a>
        
    </td></tr>
    
    
        <!--All adult surveys (attitude, behavior, knowledge about obesity).
        Person, the program they participated in, the organization that sponsored that program,
        their survey responses.
        -->
    

        <tr><td>
     
	<a href="/include/generalized_download_script.php?download_name=adult_surveys_bickerdike">Download the CSV file of participant surveys (adults only).</a><br><p></p></td>
            <td>
          
	<a href="/include/generalized_download_script.php?download_name=adult_surveys_bickerdike_deid">Download (adults).</a>
                
            </td></tr>
            
    
        <!--All parent surveys (attitude, behavior, knowledge about obesity).
        Person, the program they participated in, the organization that sponsored that program,
        their survey responses.
        
        Different from the download with linked children because some parents may
        not have their child linked.
        -->
    

       <tr><td> 
	<a href="/include/generalized_download_script.php?download_name=parent_surveys_bickerdike">Download the CSV file of participant surveys (parents only).</a><br><p></p></td>
           <td>
            
	<a href="/include/generalized_download_script.php?download_name=parent_surveys_bickerdike_deid">Download (parents).</a>
               
           </td></tr>
          
    
        <!--All youth surveys (attitude, behavior, knowledge about obesity).
        Person, the program they participated in, the organization that sponsored that program,
        their survey responses.
        -->
    
  
        <tr><td>
        <a href="/include/generalized_download_script.php?download_name=youth_surveys_bickerdike">Download (youth).</a><br><p></p></td>
            <td>
        
	<a href="/include/generalized_download_script.php?download_name=youth_surveys_bickerdike_deid">Download (youth).</a>
                
            </td></tr>
           
    
        <!--All parent surveys (attitude, behavior, knowledge about obesity).
        Person, information about the child described in the survey,
        the program the child participated in, the organization that sponsored that program,
        the parent's survey responses.
        -->
    

        <tr><td>
<?
$infile="downloads/surveys.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("User ID", "Gender", "Age", "Address Number", "Street Direction", "Street Name", "Street Type", 
    "Zipcode", "Race/Ethnicity", "Question 2 -- (1) Very important to (4) Not at all important", "3", "4a",
     "4b", "5a","5b", "Question 6", "7", "8",
     "9a -- (1) Strongly Agree to (4) Strongly Disagree", "9b -- (1) Strongly Agree to (4) Strongly Disagree",
    "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", "13 -- (0) No to (1) Yes",
     "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
    "Program Name", "Program Organization", "Participant Type", "Child ID",  "Child First Name", "Child Last Name", "Child Gender",
    "Child's Age", "Child DOB", "Child Race", "Parent First Name", "Parent Last Name");

fputcsv($fp, $title_array);
$get_money="SELECT parent_table.*, child_table.User_ID as child_id, child_table.First_Name as child_first, child_table.Last_Name as child_last,
    child_table.DOB as child_dob, child_table.Gender as child_gender,
    child_table.Age as child_age, child_table.Race as child_race,
    Participant_Survey_Responses.* FROM Users as parent_table, Users as child_table, 
    Participant_Survey_Responses WHERE parent_table.User_ID = Participant_Survey_Responses.User_ID AND child_table.User_ID=Participant_Survey_Responses.Child_ID;";
$get_money="SELECT parent_table.*, child_table.User_ID as child_id, child_table.First_Name as child_first, child_table.Last_Name as child_last,
    child_table.DOB as child_dob, child_table.Gender as child_gender,
    child_table.Age as child_age, child_table.Race as child_race,
    Participant_Survey_Responses.*, Programs.Program_ID, Programs.Program_Name, 
    Org_Partners.Partner_Name
    FROM Users as parent_table, Users as child_table, 
    Participant_Survey_Responses, Programs, Org_Partners     
    WHERE parent_table.User_ID = Participant_Survey_Responses.User_ID 
    AND child_table.User_ID=Participant_Survey_Responses.Child_ID
    AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
    AND Programs.Program_Organization=Org_Partners.Partner_ID;";
//echo $get_money . "<br>";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_array($money_info)){
    
    if ($money['Race']=='b') {
            $race="African-American";
    } else if ($money['Race']=='l') {
            $race="Latino";
    } else if ($money['Race']=='a') {
            $race="Asian-American";
    } else if ($money['Race']=='w') {
            $race="White";
    } else if ($money['Race']=='o') {
            $race="Other";
    } else{
        $race='';
    }
    if ($money['child_race']=='b') {
            $child_race="African-American";
    } else if ($money['child_race']=='l') {
            $child_race="Latino";
    } else if ($money['child_race']=='a') {
            $child_race="Asian-American";
    } else if ($money['child_race']=='w') {
            $child_race="White";
    } else if ($money['child_race']=='o') {
            $child_race="Other";
    } else{
        $child_race='';
    }
    $enter_array = array($money['User_ID'], $money['Gender'], $money['Age'],
        $money['Address_Number'], $money['Address_Street_Direction'], $money['Address_Street_Name'], 
        $money['Address_Street_Type'], $money['Zipcode'], $race,
        $money['Question_2'],  $money['Question_3'], $money['Question_4_A'], $money['Question_4_B'], $money['Question_5_A'],
         $money['Question_5_B'],  $money['Question_6'], $money['Question_7'], $money['Question_8'], $money['Question_9_A'],
         $money['Question_9_B'], $money['Question_11'], $money['Question_12'], $money['Question_13'], $money['Question_14'],
         $money['Date_Survey_Administered'], $money['Pre_Post_Late'], $money['Program_ID'],  $money['Program_Name'], $money['Partner_Name'],
        $money['Participant_Type'], $money['Child_ID'], $money['child_first'], $money['child_last'],
        $money['child_gender'], $money['child_age'], $money['child_dob'], $child_race, $money['First_Name'], $money['Last_Name']);
    fputcsv ($fp, $enter_array);
}

include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/surveys.csv">Download the CSV file of parent participant surveys with linked children.</a><span class="helptext">
    Includes the child's information.  If no program is selected, the survey will not show up in this export.
</span> <br><p></p></td>
            
            
            <td>
                
                <?
$infile="downloads/deid_surveys.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("User ID", "Gender", "Age", 
    "Zipcode", "Race/Ethnicity", "Question 2 -- (1) Very important to (4) Not at all important", "3", "4a",
     "4b", "5a","5b", "Question 6", "7", "8",
     "9a -- (1) Strongly Agree to (4) Strongly Disagree", "9b -- (1) Strongly Agree to (4) Strongly Disagree",
    "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", "13 -- (0) No to (1) Yes",
     "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
    "Program Name", "Program Organization", "Participant Type", "Child ID",   "Child Gender",
    "Child's Age",  "Child Race", );

fputcsv($fp, $title_array);
$get_money="SELECT parent_table.*, child_table.User_ID as child_id, child_table.First_Name as child_first, child_table.Last_Name as child_last,
    child_table.DOB as child_dob, child_table.Gender as child_gender,
    child_table.Age as child_age, child_table.Race as child_race,
    Participant_Survey_Responses.* FROM Users as parent_table, Users as child_table, 
    Participant_Survey_Responses WHERE parent_table.User_ID = Participant_Survey_Responses.User_ID AND child_table.User_ID=Participant_Survey_Responses.Child_ID;";
$get_money="SELECT parent_table.*, child_table.User_ID as child_id, child_table.First_Name as child_first, child_table.Last_Name as child_last,
    child_table.DOB as child_dob, child_table.Gender as child_gender,
    child_table.Age as child_age, child_table.Race as child_race,
    Participant_Survey_Responses.*, Programs.Program_ID, Programs.Program_Name, 
    Org_Partners.Partner_Name
    FROM Users as parent_table, Users as child_table, 
    Participant_Survey_Responses, Programs, Org_Partners     
    WHERE parent_table.User_ID = Participant_Survey_Responses.User_ID 
    AND child_table.User_ID=Participant_Survey_Responses.Child_ID
    AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
    AND Programs.Program_Organization=Org_Partners.Partner_ID;";
//echo $get_money . "<br>";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_array($money_info)){
    
    if ($money['Race']=='b') {
            $race="African-American";
    } else if ($money['Race']=='l') {
            $race="Latino";
    } else if ($money['Race']=='a') {
            $race="Asian-American";
    } else if ($money['Race']=='w') {
            $race="White";
    } else if ($money['Race']=='o') {
            $race="Other";
    } else{
        $race='';
    }
    if ($money['child_race']=='b') {
            $child_race="African-American";
    } else if ($money['child_race']=='l') {
            $child_race="Latino";
    } else if ($money['child_race']=='a') {
            $child_race="Asian-American";
    } else if ($money['child_race']=='w') {
            $child_race="White";
    } else if ($money['child_race']=='o') {
            $child_race="Other";
    } else{
        $child_race='';
    }
    $enter_array = array($money['User_ID'], $money['Gender'], $money['Age'],  $money['Zipcode'], $race,
        $money['Question_2'],  $money['Question_3'], $money['Question_4_A'], $money['Question_4_B'], $money['Question_5_A'],
         $money['Question_5_B'],  $money['Question_6'], $money['Question_7'], $money['Question_8'], $money['Question_9_A'],
         $money['Question_9_B'], $money['Question_11'], $money['Question_12'], $money['Question_13'], $money['Question_14'],
         $money['Date_Survey_Administered'], $money['Pre_Post_Late'], $money['Program_ID'],  $money['Program_Name'], $money['Partner_Name'],
        $money['Participant_Type'], $money['Child_ID'], 
        $money['child_gender'], $money['child_age'], $child_race);
    fputcsv ($fp, $enter_array);
}

include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/deid_surveys.csv">Download (parents and children).</a>
                
                
            </td></tr>
    
    
        <!--All program dates.  Date linked to program.
        -->
    

        <tr><td>
<?$infile="downloads/program_dates.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("ID", "Program ID", "Program Name", "Date");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM Program_Dates INNER JOIN Programs ON Program_Dates.Program_ID=Programs.Program_ID";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_array($money_info)){
    $enter_array=array($money['Program_Date_ID'], $money['Program_ID'], $money['Program_Name'], $money['Program_Date']);
    fputcsv ($fp, $enter_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/program_dates.csv">Download the CSV file of all program dates.</a><br></td>
            <td><a href="downloads/program_dates.csv">Download.</a></td></tr>
    
    
        <!--All program attendance.  Program, linked to date, linked to people
        who attended on that day.
        -->
    

        <tr><td>
<?$infile="downloads/program_attendance.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("ID", "Program Date ID", "User ID", "Program ID", "Program Date", "Program Name", 
    "Participant First Name" , "Participant Last Name", "Gender", "Age",
        "Address Number", "Street Direction", "Street Name", "Street Type", "Participant Type");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM Program_Dates_Users LEFT JOIN (Program_Dates, Programs, Users)
       ON (Program_Dates_Users.Program_Date_ID=Program_Dates.Program_Date_ID
       AND Programs.Program_ID=Program_Dates.Program_ID
       AND Program_Dates_Users.User_ID=Users.User_ID)";
//echo $get_money;
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_array($money_info)){
    if ($money['Adult']==1){
        $type='Adult';
    }elseif($money['Parent']==1){
        $type='Parent';
    }elseif($money['Child']==1){
        $type='Child/Youth';
    }
    $enter_array=array($money['Program_Dates_Users_ID'], $money['Program_Date_ID'], $money['User_ID'], $money['Program_ID'], $money['Program_Date'], 
        $money['Program_Name'], $money['First_Name'], $money['Last_Name'], $money['Gender'], $money['Age'], $money['Address_Number'], 
        $money['Address_Street_Direction'], $money['Address_Street_Name'], $money['Address_Street_Type'], $type);
    fputcsv ($fp, $enter_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/program_attendance.csv">Download the CSV file of all program attendance.</a><br></td>
            <td><?$infile="downloads/deid_program_attendance.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("ID", "Program Date ID", "User ID", "Program ID", "Program Date", "Program Name", 
     "Gender", "Age",
        "Participant Type");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM Program_Dates_Users LEFT JOIN (Program_Dates, Programs, Users)
       ON (Program_Dates_Users.Program_Date_ID=Program_Dates.Program_Date_ID
       AND Programs.Program_ID=Program_Dates.Program_ID
       AND Program_Dates_Users.User_ID=Users.User_ID)";
//echo $get_money;
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_array($money_info)){
    if ($money['Adult']==1){
        $type='Adult';
    }elseif($money['Parent']==1){
        $type='Parent';
    }elseif($money['Child']==1){
        $type='Child/Youth';
    }
    $enter_array=array($money['Program_Dates_Users_ID'], $money['Program_Date_ID'], $money['User_ID'], $money['Program_ID'], $money['Program_Date'], 
        $money['Program_Name'], $money['Gender'], $money['Age'], $type);
    fputcsv ($fp, $enter_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/deid_program_attendance.csv">Download (no names).</a></td></tr>
            
    
        <!--All programs. (nothing to deidentify)
        -->
    

<tr><td>
<?$infile="downloads/programs.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("ID", "Program Name", "Organization", "Type", "Program Created Date", "Notes");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM Programs";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_row($money_info)){
    fputcsv ($fp, $money);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/programs.csv">Download the CSV file of all programs.</a><br></td>
    <td><a href="downloads/programs.csv">Download.</a> </td></tr>
    
    
        <!--All people participating in programs, along with the program they are in.
        -->
    

<tr><td>
<?$infile="downloads/participants.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Program ID", "User ID", "Program Name", "Gender", "Age",
        "Address Number", "Street Direction", "Street Name", "Street Type");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM Programs_Users INNER JOIN (Programs, Users)
    ON (Programs_Users.Program_ID=Programs.Program_ID
    AND Programs_Users.User_ID=Users.User_ID)";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_array($money_info)){
    $enter_array=array($money['Program_ID'], $money['User_ID'], $money['Program_Name'], $money['Gender'], $money['Age'],
        $money['Address_Number'], $money['Address_Street_Direction'], $money['Address_Street_Name'], $money['Address_Street_Type']);
    fputcsv ($fp, $enter_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/participants.csv">Download the CSV file of all program participants.</a><br></td>
    <td><?$infile="downloads/deid_participants.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Program ID", "User ID", "Program Name", "Gender", "Age");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM Programs_Users INNER JOIN (Programs, Users)
    ON (Programs_Users.Program_ID=Programs.Program_ID
    AND Programs_Users.User_ID=Users.User_ID)";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_array($money_info)){
    $enter_array=array($money['Program_ID'], $money['User_ID'], $money['Program_Name'], $money['Gender'], $money['Age']);
    fputcsv ($fp, $enter_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/deid_participants.csv">Download.</a></td></tr>
    
    
        <!--All health data over time for the people in the DB.
        -->
    

<tr><td>
<?$infile="downloads/health_data.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("User ID", "Height in Feet", "Remaining Height in Inches", "Weight", "BMI", "Date", "Gender", "Age", "Address");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM User_Health_Data INNER JOIN Users ON Users.User_ID=User_Health_Data.User_ID;";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_array($money_info)){
    $enter_array=array($money['User_ID'], $money['Height_Feet'], $money['Height_Inches'],
        $money['Weight'], $money['BMI'], $money['Date'], $money['Gender'], $money['Age'], $money['Address_Number'], 
        $money['Address_Street_Direction'], $money['Address_Street_Name'], $money['Address_Street_Type']);
    fputcsv ($fp, $enter_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/health_data.csv">Download the CSV file of all participant health data.</a><br></td>
    <td>
        <?$infile="downloads/deid_health_data.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("User ID", "Height in Feet", "Remaining Height in Inches", "Weight", "BMI", "Date", "Gender", "Age");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM User_Health_Data INNER JOIN Users ON Users.User_ID=User_Health_Data.User_ID;";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_array($money_info)){
    $enter_array=array($money['User_ID'], $money['Height_Feet'], $money['Height_Inches'],
        $money['Weight'], $money['BMI'], $money['Date'], $money['Gender'], $money['Age']);
    fputcsv ($fp, $enter_array);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/health_data.csv">Download (no address).</a></td></tr>
    
    
        <!--All the people in the database.
        -->
    

<tr><td>
<?$infile="downloads/users.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("User ID", "First Name", "Last Name", "Zipcode", "Date of Birth", "Gender", "Age", "Race", "Street Address", "Adult?",
        "Parent?", "Youth?", "Email", "Notes", "Street Number", "Street Direction", "Street Type", "Phone Number");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM Users";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_row($money_info)){
    fputcsv ($fp, $money);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/users.csv"> Download the CSV file of all participants.</a><br></td>
    <td>
        <?$infile="downloads/deid_users.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("User ID", "Zipcode", "Gender", "Age", "Race", "Adult?",
        "Parent?", "Youth?", "Block Group");
fputcsv($fp, $title_array);
$get_money = "SELECT User_ID, Zipcode, Gender, Age, Race, Adult, Parent, Child, Block_Group FROM Users";
//echo $get_money;
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_row($money_info)){
   // $this_address=$money[8]." " . $money[9] . " " . $money[10] ." ". $money[11] ;
   //$block_group=do_it_all($this_address, $map);
   // array_splice($money, -4);
   // array_push($money, $block_group);
    fputcsv ($fp, $money);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/deid_users.csv"> Download.</a>
    </td></tr>
    
    
        <!--Results from all walkability assessments (nothing to deidentify)
        -->
    

<tr><td>
<?$infile="downloads/walkability.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("ID", "Date", "Do Cars Stop?", "Intersection Assessed", "Speed Limit Obeyed?", "Gaps in Sidewalk?", "Crosswalk Painted?");
fputcsv($fp, $title_array);
$get_money = "SELECT * FROM Walkability_Assessment";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_row($money_info)){
    fputcsv ($fp, $money);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/walkability.csv"> Download the CSV file of all walkability assessments.</a><br></td>
    <td><a href="downloads/walkability.csv"> Download.</a></td></tr>

    
    
        <!--All participant addresses (why do they want this separate?).
        -->
    


<tr><td>
<?$infile="downloads/addresses.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("User ID", "Address Number", "Street Direction", "Street Name", "Street Type", "Zipcode", "Gender", "Age");
fputcsv($fp, $title_array);
$get_money = "SELECT User_ID, Address_Number, Address_Street_Direction, 
Address_Street_Name, Address_Street_Type, Zipcode, Gender, Age
FROM Users;";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_row($money_info)){
    fputcsv ($fp, $money);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/addresses.csv"> Download the CSV file of all participant home addresses.</a><br></td>
    <td>
        <?$infile="downloads/deid_addresses.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("User ID", "Block Group", "Zipcode", "Gender", "Age");
fputcsv($fp, $title_array);
$get_money = "SELECT User_ID, Block_Group, Zipcode, Gender, Age
FROM Users;";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $get_money);
while ($money = mysqli_fetch_row($money_info)){
  /*  $this_address=$money[1]." " . $money[2] . " " . $money[3] ." ". $money[4] ;
    echo $this_address;
   $block_group=do_it_all($this_address, $map);
   echo $block_group . "<br>";
   // array_splice($money, -4);
   // array_push($money, $block_group);
   $new_array=array($money[0], $block_group, $money[5], $money[6], $money[7]);*/
    fputcsv ($fp, $money);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/deid_addresses.csv"> Download zipcodes/block groups.</a>
    </td>
</tr>

<tr>
    <td>
        
        
         <?$infile="downloads/grouped_surveys.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("First Name", "Last Name", "Pre Survey ID Number", "User ID", "Question 2 -- (1) Very important to (4) Not at all important", "3", "4a",
	     "4b", "5a","5b", "Question 6", "7", "8",
	     "9a -- (1) Strongly Agree to (4) Strongly Disagree", "9b -- (1) Strongly Agree to (4) Strongly Disagree",
	    "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", "13 -- (0) No to (1) Yes",
	     "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
	    "Participant Type", "Child ID",
    "Post Survey ID Number", "User ID", "Question 2 -- (1) Very important to (4) Not at all important", "3", "4a",
	     "4b", "5a","5b", "Question 6", "7", "8",
	     "9a -- (1) Strongly Agree to (4) Strongly Disagree", "9b -- (1) Strongly Agree to (4) Strongly Disagree",
	    "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", "13 -- (0) No to (1) Yes",
	     "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
	    "Participant Type", "Child ID",
    "Followup Survey ID Number", "User ID", "Question 2 -- (1) Very important to (4) Not at all important", "3", "4a",
	     "4b", "5a","5b", "Question 6", "7", "8",
	     "9a -- (1) Strongly Agree to (4) Strongly Disagree", "9b -- (1) Strongly Agree to (4) Strongly Disagree",
	    "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", "13 -- (0) No to (1) Yes",
	     "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
	    "Participant Type", "Child ID");
fputcsv($fp, $title_array);
$this_query="SELECT First_Name, Last_Name, Pre_Responses.*,
Mid_Responses.*,
Post_Responses.*
FROM Participant_Survey_Responses AS Pre_Responses
LEFT JOIN Participant_Survey_Responses AS Mid_Responses
    ON Pre_Responses.User_ID=Mid_Responses.User_ID
LEFT JOIN Participant_Survey_Responses AS Post_Responses
    ON Pre_Responses.User_ID=Post_Responses.User_ID
LEFT JOIN Users ON Pre_Responses.User_ID=Users.User_ID
    WHERE Pre_Responses.Participant_Survey_ID!=Mid_Responses.Participant_Survey_ID
    AND Pre_Responses.Pre_Post_Late=1
    AND Mid_Responses.Pre_Post_Late=2
    AND Post_Responses.Pre_Post_Late=3";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $this_query);
while ($money = mysqli_fetch_row($money_info)){
    fputcsv ($fp, $money);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/grouped_surveys.csv"> Download surveys, grouped by participant.</a>
        
    </td>
    <td>
        
         <?$infile="downloads/deid_surveys_grouped.csv";
$fp=fopen($infile, "w") or die('can\'t open file');
$title_array = array("Pre Survey ID Number", "User ID", "Question 2 -- (1) Very important to (4) Not at all important", "3", "4a",
	     "4b", "5a","5b", "Question 6", "7", "8",
	     "9a -- (1) Strongly Agree to (4) Strongly Disagree", "9b -- (1) Strongly Agree to (4) Strongly Disagree",
	    "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", "13 -- (0) No to (1) Yes",
	     "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
	    "Participant Type", "Child ID",
    "Post Survey ID Number", "User ID", "Question 2 -- (1) Very important to (4) Not at all important", "3", "4a",
	     "4b", "5a","5b", "Question 6", "7", "8",
	     "9a -- (1) Strongly Agree to (4) Strongly Disagree", "9b -- (1) Strongly Agree to (4) Strongly Disagree",
	    "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", "13 -- (0) No to (1) Yes",
	     "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
	    "Participant Type", "Child ID",
    "Followup Survey ID Number", "User ID", "Question 2 -- (1) Very important to (4) Not at all important", "3", "4a",
	     "4b", "5a","5b", "Question 6", "7", "8",
	     "9a -- (1) Strongly Agree to (4) Strongly Disagree", "9b -- (1) Strongly Agree to (4) Strongly Disagree",
	    "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", "13 -- (0) No to (1) Yes",
	     "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
	    "Participant Type", "Child ID");
fputcsv($fp, $title_array);
$this_query="SELECT Pre_Responses.*,
Mid_Responses.*,
Post_Responses.*
FROM Participant_Survey_Responses AS Pre_Responses
LEFT JOIN Participant_Survey_Responses AS Mid_Responses
    ON Pre_Responses.User_ID=Mid_Responses.User_ID
LEFT JOIN Participant_Survey_Responses AS Post_Responses
    ON Pre_Responses.User_ID=Post_Responses.User_ID
    
    WHERE Pre_Responses.Participant_Survey_ID!=Mid_Responses.Participant_Survey_ID
    AND Pre_Responses.Pre_Post_Late=1
    AND Mid_Responses.Pre_Post_Late=2
    AND Post_Responses.Pre_Post_Late=3";
include "../include/dbconnopen.php";
$money_info = mysqli_query($cnnBickerdike, $this_query);
while ($money = mysqli_fetch_row($money_info)){
    fputcsv ($fp, $money);
}
include "../include/dbconnclose.php";
fclose($fp);
?>
<a href="downloads/deid_surveys_grouped.csv"> Download surveys, deidentified, grouped by participant.</a>
    </td>
</tr>

</table>
</div>
<br/><br/>

<? include "../../footer.php"; ?>
