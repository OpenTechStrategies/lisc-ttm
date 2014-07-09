<?php
function convert_string($string) {
    //converts smart quotes / dashes to normal quotes / dashes.
    $search = array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(152));
    $replace = array("'", "'", '"', '"', '-', '-', '-');
    return str_replace($search, $replace, $string);
}
include "../../header.php";
include '../header.php';
  include "../reports/report_menu.php";
  
  /* place for TRP users to import CPS data from Lauren */
  
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#reports_selector').addClass('selected');
	});
</script>

<h3>Import CPS Data</h3>
<span style="text-align:center; color:#C11B17; font-weight:bold;">Use only the Chapin Hall-provided CPS Data file in this import.
Using incorrect files may result in malfunctions.</span><br/><br/>
<span class="helptext">Before running the import, make sure you have the correct type of file.  If you're working in
an Excel file, follow these simple steps to convert it to a .csv file:</span>
<list>
<li>Open the file.</li>
<li>Go to the File menu and choose "Save As."</li>
<li>Choose the folder and file name you'd like.</li>
<li>At the bottom of the Save As window, underneath the File name box, find the "Save as type:" dropdown.</li>
<li>Scroll through that dropdown until you find "CSV (Comma delimited)(*.csv).  Choose this type.</li>
<li>Click Save.</li>
<li>Excel may warn you that not all the properties of the file will be maintained in the new format.  Click ok.</li>
<li>Check to be sure that the file name (at the top of the Excel window) ends in .csv.  If it does, then congrats, you're done!  Otherwise, follow these steps again.</li>
</list>

<?php
if (!isset($_POST['posted'])) {
    ?>
    <br />
    Choose your CPS data file and then click on the submit button.

    <form action="import_cps.php" method="post" enctype="multipart/form-data">
        1. <input type="file" name="first_file" /><br /><br />
            <input type="hidden" name="posted" />
        2. <input type="submit" value="Submit" />
    </form>

    <hr />
    <br />
    



    
    



   



 <?php
}
else{
    //if there is a file posted:
    $handle = fopen($_FILES['first_file']['tmp_name'], "r");
    
    
   
    while ($line = fgetcsv($handle, '1000', "\r")){
        
        
        include "../include/dbconnopen.php";
        foreach ($line as $cell){
            $break=explode("\t", $cell);
           // print_r($break);
            echo "<br>";
            //now, here we enter the student as a participant and save their information in the MS_to_HS_over_time table
            //check first whether they are already a participant
                $check_existing_sqlsafe="SELECT * FROM Participants WHERE CPS_ID='" . mysql_real_escape_string($break[0]) . "'";
             //   echo $check_existing . "<br>";
                $exists=mysqli_query($cnnTRP, $check_existing_sqlsafe);
                if (mysqli_num_rows($exists)>0){
                    //participant already exists
                    $db_id=mysqli_fetch_row($exists);
                    $id=$db_id[0];
                }
                else{
                    $new_participant_sqlsafe = "INSERT INTO Participants (CPS_ID) VALUES (" . mysqli_real_escape_string($break[0]) . ")";
                    mysqli_query($cnnTRP, $new_participant_sqlsafe);
                    echo "New participant added! <br>";
                    $id=mysqli_insert_id($cnnTRP);
                }
            //now, save their absences and whatnot
                $insert_info_sqlsafe="INSERT INTO MS_to_HS_Over_Time (Participant_ID, School_Tardies, School_Absences_Unexcused, 
                    In_School_Suspensions, Out_School_Suspensions) VALUES ($id, "
                    . "'" . mysqli_real_escape_string($break[3]) . "', "
                    . "'" . mysqli_real_escape_string($break[2]) . "', "
                    . "'" . mysqli_real_escape_string($break[7]) . "', "
                    . "'" . mysqli_real_escape_string($break[6]) . "')";
               // echo $insert_info . "<br>";
                $insert_grade_sqlsafe="INSERT INTO Academic_Info (Participant_ID, Lang_Grade) VALUES ($id, '"
                              . mysqli_reql_escape_string($break[5]) . "')";
                $add_to_program_sqlsafe="INSERT INTO Participants_Programs (Participant_ID, Program_ID) VALUES ($id, 2)";
               // echo $insert_grade . "<br>";
                mysqli_query($cnnTRP, $insert_info_sqlsafe);
                echo "Attendance and discipline data entered. <br>";
                mysqli_query($cnnTRP, $insert_grade_sqlsafe);
                mysqli_query($cnnTRP, $add_to_program_sqlsafe);
                echo "Grade data entered. <br>";
        }
        include "../include/dbconnclose.php";
     }
    //}
    fclose($handle);
    
    
}
?>


<br/><br/>

<?
	include "../../footer.php";
?>