<?php

/* not being used for TRP right now (obsolete). */

function convert_string($string) {
    //converts smart quotes / dashes to normal quotes / dashes.
    $search = array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(152));
    $replace = array("'", "'", '"', '"', '-', '-', '-');
    return str_replace($search, $replace, $string);
}
include "../../header.php";
include '../header.php';
  include "../reports/report_menu.php";
?>
<script>
    $(document).ready(function() {
        document.getElementsByName('search_criteria')[1].focus();
    });
</script>

<h3>Import:</h3>

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
<!--    Sample Files: <a href="/CSR_Meta.txt">CSR_Meta.txt</a> - <a href="/NSR_TBLS.txt">NSR_TBLS.txt</a><br />-->
    <br />
    Choose your demographics file and then click on the submit button.

    <form action="import_demographics.php" method="post" enctype="multipart/form-data">
        1. <input type="file" name="first_file" /><br /><br />
            <input type="hidden" name="posted" />
        2. <input type="submit" value="Submit" />
    </form>

    <hr />
    <br />
    



    
    



    <?php
} else {
    if (isset($_FILES['first_file'])) {
        ?>
        <?php // var_dump($_POST, $_FILES); ?>
        <?php
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
        while((!feof($handle))) {// && ($count > 0)) {
            //$count--;

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

                    $exploded_line = explode(',', $line);
                    
                    

                    $explosion_length=count($exploded_line);
                    $counter=0;
                    $new_line='';
                    
                    //only do this if the first element is in fact a program name (not a title row)
                    if ($exploded_line[1]=="Name"){
                         echo 'problem: ' . $exploded_line[1] . '<br>';
                    }
                    else{
                        //I'm going to assume (yikes!) that they'll write names as last name comma first name.  We shall see.
                        //
                        //print_r($exploded_line);
                        //
                        //split up names (in case they just enter them as first space last)
//                        $names=explode(' ',$exploded_line[1]);
//                        $name_first=$names[0];
//                        $surname=$names[1];
                        $get_program_name = "SELECT * FROM Participants WHERE First_Name='$exploded_line[2]' AND Last_Name='$exploded_line[1]'";
                        include "../include/dbconnopen.php";
                        $program_name=mysqli_query($cnnTRP, $get_program_name);
                        //test whether the program already exists or not
                        if (mysqli_num_rows($program_name)>0){
                            $program=mysqli_fetch_row($program_name);
                            $program_id=$program[0];
                            echo "This person, " .$exploded_line[2] . " " . $exploded_line[1] . ", appears to already be in the database. <br>";
                        }
                        else{
                            //if it doesn't exist yet, then insert it
                            $add_program="INSERT INTO Participants (First_Name, Last_Name, Eval_ID, Race, Gender, DOB, Neighborhood, 
                            Address_Zipcode)
                             VALUES ('$exploded_line[2]', '$exploded_line[1]', '$exploded_line[3]', '$exploded_line[4]', '$exploded_line[5]', 
                            '$exploded_line[6]', '$exploded_line[9]', '$exploded_line[10]')";
                            echo $add_program . "<br>";
                            mysqli_query($cnnTRP, $add_program);
                            $program_id=  mysqli_insert_id($cnnTRP);
//                            
                        }
                        include "../include/dbconnclose.php";
                        
                        
                    }
                  
            } 
        }
        echo "</pre>";

        fclose($handle);



        echo "<a href=\"import_demographics.php\">Import Another</a>";

        


    }
    
    }