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
<a href="/include/generalized_download_script.php?download_name=corner_stores_deid">Download (no store names).</a></td></tr>
    
    
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


                <a href="/include/generalized_download_script.php?download_name=parent_children_surveys_bickerdike">Download the CSV file of parent participant surveys with linked children.</a><span class="helptext">
    Includes the child's information.  If no program is selected, the survey will not show up in this export.
</span> <br><p></p></td>
            
            
            <td>

<a href="/include/generalized_download_script.php?download_name=parent_children_surveys_bickerdike_deid">Download (parents and children).</a>
                
                
            </td></tr>
    
    
        <!--All program dates.  Date linked to program.
        -->
    

        <tr><td>

<a href="/include/generalized_download_script.php?download_name=program_dates_bickerdike">Download the CSV file of all program dates.</a><br></td>
            <td><a href="/include/generalized_download_script.php?download_name=program_dates_bickerdike">Download.</a></td></tr>
    
    
        <!--All program attendance.  Program, linked to date, linked to people
        who attended on that day.
        -->
    

        <tr><td>
<a href="/include/generalized_download_script.php?download_name=program_attendance_bickerdike">Download the CSV file of all program attendance.</a><br></td>
            <td>
<a href="/include/generalized_download_script.php?download_name=program_attendance_bickerdike_deid">Download (no names).</a></td></tr>
            
    
        <!--All programs. (nothing to deidentify)
        -->
    

<tr><td>
<a href="/include/generalized_download_script.php?download_name=programs_bickerdike">Download the CSV file of all programs.</a><br></td>
    <td><a href="/include/generalized_download_script.php?download_name=programs_bickerdike">Download.</a> </td></tr>
    
    
        <!--All people participating in programs, along with the program they are in.
        -->
    

<tr><td>
        <a href="/include/generalized_download_script.php?download_name=program_participants_bickerdike">
            Download the CSV file of all program participants.</a><br></td>
    <td>
<a href="/include/generalized_download_script.php?download_name=program_participants_bickerdike_deid">Download.</a></td></tr>
    
    
        <!--All health data over time for the people in the DB.
        -->
    

<tr><td>
        <a href="/include/generalized_download_script.php?download_name=health_data_bickerdike">Download the CSV file of all participant health data.</a><br></td>
    <td>
<a href="/include/generalized_download_script.php?download_name=health_data_bickerdike_deid">Download (no address).</a></td></tr>
    
    
        <!--All the people in the database.
        -->
    

<tr><td>

        <a href="/include/generalized_download_script.php?download_name=all_participants_bickerdike"> Download the CSV file of all participants.</a><br></td>
    <td>
<a href="/include/generalized_download_script.php?download_name=all_participants_bickerdike_deid"> Download.</a>
    </td></tr>
    
    
        <!--Results from all walkability assessments (nothing to deidentify)
        -->
    

<tr><td>
        <a href="/include/generalized_download_script.php?download_name=walkability_bickerdike"> Download the CSV file of all walkability assessments.</a><br></td>
    <td><a href="/include/generalized_download_script.php?download_name=walkability_bickerdike"> Download.</a></td></tr>

    
    
        <!--All participant addresses (why do they want this separate?).
        -->
    


<tr><td>

<a href="/include/generalized_download_script.php?download_name=addresses_bickerdike"> Download the CSV file of all participant home addresses.</a><br></td>
    <td>

<a href="/include/generalized_download_script.php?download_name=addresses_bickerdike_deid"> Download zipcodes/block groups.</a>
    </td>
</tr>

<tr>
    <td>
<a href="/include/generalized_download_script.php?download_name=grouped_surveys_bickerdike"> Download surveys, grouped by participant.</a>
        
    </td>
    <td>
<a href="/include/generalized_download_script.php?download_name=grouped_surveys_bickerdike_deid"> Download surveys, deidentified, grouped by participant.</a>
    </td>
</tr>

</table>
</div>
<br/><br/>

<? include "../../footer.php"; ?>
