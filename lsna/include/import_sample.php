<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
/* file that allows LSNA to import Cityspan info (only very specific): 
 * used the CDD import file as a template.
 */

function convert_string($string) {
    //converts smart quotes / dashes to normal quotes / dashes.
    $search = array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(152));
    $replace = array("'", "'", '"', '"', '-', '-', '-');
    return str_replace($search, $replace, $string);
}
include "../../header.php";
include '../header.php';
?>
<script>
    $(document).ready(function() {
        $('#reports_selector').addClass('selected');
		document.getElementsByName('search_criteria')[1].focus();
    });
</script>

<h3>Import:</h3>    <hr />
    <br />

<span class="helptext">Before running the import, make sure you have the correct type of file.  If the Cityspan file you've downloaded is 
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
/*before the file has been submitted: */
if (!isset($_POST['posted'])) {
    ?>

    <br />
    Choose your Cityspan file and then click on the submit button.

    <form action="import_sample.php" method="post" enctype="multipart/form-data">
        1. <input type="file" name="first_file" /><br /><br />
            <input type="hidden" name="posted" />
        2. <input type="submit" value="Submit" />
    </form>


    



    
    



    <?php
} 
/* after the file has been submitted: */
else {
    if (isset($_FILES['first_file'])) {
       
        //open uploaded file
        $handle = fopen($_FILES['first_file']['tmp_name'], "r");

        //all imported elements
        $dbs = array();
        $tables = array();
        $variables = array();

        $parent = "";

        //parentheses
        $parentheses = 0;

        //$count = 500;
        echo "<pre>";
        //scroll through and parse
        //
        //
        //
        while((!feof($handle))) {
            

            //get the line
            $line = fgets($handle);
            //echo  $line . "<br />";
            
           // echo "1";

            //open table info
            if ($line == "(\r\n") {
                //echo "1aaa";
                $parentheses++;
                //$parentheses
                continue;
            }

            //echo "2";
            //close table info
            if ($line == ")\r\n") {
                //echo "2aaa";
                $parentheses--;
                continue;
            }

            
            //if outside parentheses
            if ($parentheses == 0) {
                    //switch string to array of elements:
                    $exploded_line = explode(',', $line);
                    
                    
                    $explosion_length=count($exploded_line);
                    $counter=0;
                    $new_line='';
                    //test exploded_line[0] for program name - does program already exist?  if not, it should be added
                    //only do this if the first element is in fact a program name
                    
                    /*the first several lines from the file should be ignored: */
                    if ($exploded_line[1]=='' || $exploded_line[1]===0 || $exploded_line[0]=='Program(s):' 
                             ||$exploded_line[0]=='Agency:' 
                            || $exploded_line[1]=='Program Category' ||$exploded_line[1]=='Program Name' || 
                            strpos($exploded_line[0], 'Total Activity Records')==3
                            || strpos($exploded_line[0], 'Average Daily Attendance')==3
                            || strpos($exploded_line[0], 'Average Weekly Attendance')==3
                            || strpos($exploded_line[0], '# of Weeks')==3
                            || strpos($exploded_line[0], '11 % Attendance')==1
                            || strpos($exploded_line[0], 'Creation Date')==1){
                       
                        //do nothing.
                    }
                    /* use the school name from above to fill in information below: */
                    elseif( $exploded_line[0]=='School:'){
                        $school=$exploded_line[1];
                    }
                    /* same for report period: */
                    elseif($exploded_line[0]=='Report Period:'){
                        $month=$exploded_line[1];
                    }
                    else{
                        //find whether this program is already in the database:
                        include "../include/dbconnopen.php";
                        $exploded_line_sqlsafe=mysqli_real_escape_string($cnnLSNA, $exploded_line[0]);
                        $get_program_name = "SELECT * FROM Subcategories WHERE Subcategory_Name='".$exploded_line_sqlsafe."'";
                        $program_name=mysqli_query($cnnLSNA, $get_program_name);
                        //test whether the program already exists or not
                        if (mysqli_num_rows($program_name)>0){
                            $program=mysqli_fetch_row($program_name);
                            $program_id=$program[0];
                        }
                        else{
                            //if the program doesn't exist yet, then insert it
                            $add_program="INSERT INTO Subcategories (Subcategory_Name, Campaign_or_Program) VALUES ('".$exploded_line_sqlsafe."', 'Program')";
                            mysqli_query($cnnLSNA, $add_program);
                            $program_id=  mysqli_insert_id($cnnLSNA);
                            $add_category="INSERT INTO Category_Subcategory_Links (Category_ID, Subcategory_ID) VALUES ('2', '".$program_id."')";
                            mysqli_query($cnnLSNA, $add_category);
                        }
                        include "../include/dbconnclose.php";
                        $exploded_line[0]=$program_id;
                        
                        //create the reformatted line for import
                        foreach ($exploded_line as $explosions){
                            //if I'm added month and school I can get rid of this if/else pair, since all the explosions would need commas afterward
//                            if ($counter==($explosion_length-1)){
//                                $new_line.=$explosions;
//                            }
//                            else{
                                $new_line.=$explosions . "', '";
                            //}
                            $counter++;
                        }
                        //need to make sure there are enough arguments here
                        //should be 18, counting the two below, so we need 15 commas
                        $num_args=substr_count($new_line, ',');
                        if ($num_args<15){
                            $add_commas=15-$num_args;
                            for ($i=0; $i<$add_commas+1; $i++){
                                $new_line.="', '";
                            }
                        }
                       // echo $new_line . "<br>";
                        //then I would add the month and school to $new_line here
                        $new_line.=$month . "', '";
                        $new_line.=$school;
                        
                       // echo "6";
                        if (!in_array(ltrim($new_line), $dbs)) {
                            array_push($dbs, ltrim($new_line));
                        }
                      //  echo "8";
                        //set parent
                        $parent = str_replace("\r\n", "", $line);
                        
                    }
                  
              //  }
            } 
        }
        echo "</pre>";

        fclose($handle);
        //summary
        echo "Lines: <br /><pre>";
        foreach ($dbs as $key => $val) {
            //open DB
            include 'dbconnopen.php';
            $val_sqlsafe=mysqli_real_escape_string($cnnLSNA, $val);
            $import_query= "Call Import__Activity_Status_Report('" . $val_sqlsafe . "')";
            //echo $import_query . "<br>";
            $imported_record = mysqli_query($cnnLSNA, $import_query);

            if (is_object($imported_record)) {
                echo "IMPORTED!\r\n";
            } else {
                echo "NOT IMPORTED... this line: ".$val.".\r\n";
            }

            //close DB
            include 'dbconnclose.php';
        }
        //print_r($dbs);

        echo "<a href=\"import_sample.php\">Import Another</a>";

        


    }
    
    }?>
<br/><br/>
<?
	include "../../footer.php";
?>