<?php
/* this page isn't actually used.  I have it in here as an example/template taken from the City Data Dictionary project.  */


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
    Choose your Cityspan file and then click on the submit button.

    <form action="import_grades.php" method="post" enctype="multipart/form-data">
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

            //open table info
            if ($line == "(\r\n") {
                $parentheses++;
                //$parentheses
                continue;
            }

            //close table info
            if ($line == ")\r\n") {
                $parentheses--;
                continue;
            }

            //if outside parentheses
            if ($parentheses == 0) {

                    $exploded_line = explode(',', $line);
                    
                    

                    $explosion_length=count($exploded_line);
                    $counter=0;
                    $new_line='';
                    //test exploded_line[0] for program name - does program already exist?  if not, it should be added
                    //only do this if the first element is in fact a program name
                    if ($exploded_line[0]=='"Codes: T = Tardy' || $exploded_line[1]=="Participant's Name"){
                         echo 'problem: ' . $exploded_line[1] . '<br>';
                    }
                    else{
                        //print_r($exploded_line);
                        //split up names
                        $names=explode(' ',$exploded_line[1]);
                        include "../include/dbconnopen.php";
                        $name_first_sqlsafe=mysqli_real_escape_string($cnnTRP, $names[0]);
                        $surname_sqlsafe=mysqli_real_escape_string($cnnTRP, $names[1]);
                        $get_program_name_sqlsafe = "SELECT * FROM Participants WHERE First_Name='$name_first_sqlsafe' AND Last_Name='$surname_sqlsafe'";
                        $program_name=mysqli_query($cnnTRP, $get_program_name_sqlsafe);
                        //test whether the program already exists or not
                        if (mysqli_num_rows($program_name)>0){
                            $program=mysqli_fetch_row($program_name);
                            $program_id=$program[0];
                        }
                        else{
                            //if it doesn't exist yet, then insert it
                            $add_program_sqlsafe="INSERT INTO Participants (First_Name, Last_Name) VALUES ('$name_first_sqlsafe', '$surname_sqlsafe')";
                            mysqli_query($cnnTRP, $add_program_sqlsafe);
                            $program_id=  mysqli_insert_id($cnnTRP);
//                            $add_category_sqlsafe="INSERT INTO Category_Subcategory_Links (Category_ID, Subcategory_ID) VALUES ('2', '".$program_id."')";
//                            mysqli_query($cnnTRP, $add_category_sqlsafe);
                        }
                        include "../include/dbconnclose.php";
                        
                        //test whether we want to update or insert:
                        include "../include/dbconnopen.php";
                        $aca_qtr_1_sqlsafe="SELECT * FROM Academic_Info WHERE Participant_ID=$program_id AND Quarter=1";
                        $qtr_1_aca=mysqli_query($cnnTRP, $aca_qtr_1_sqlsafe);
                        $aca_qtr_1_count=mysqli_num_rows($qtr_1_aca);
                        $aca_qtr_2_sqlsafe="SELECT * FROM Academic_Info WHERE Participant_ID=$program_id AND Quarter=2";
                        $qtr_2_aca=mysqli_query($cnnTRP, $aca_qtr_2_sqlsafe);
                        $aca_qtr_2_count=mysqli_num_rows($qtr_2_aca);
                        $aca_qtr_3_sqlsafe="SELECT * FROM Academic_Info WHERE Participant_ID=$program_id AND Quarter=3";
                        $qtr_3_aca=mysqli_query($cnnTRP, $aca_qtr_3_sqlsafe);
                        $aca_qtr_3_count=mysqli_num_rows($qtr_3_aca);
                        $aca_qtr_4_sqlsafe="SELECT * FROM Academic_Info WHERE Participant_ID=$program_id AND Quarter=4";
                        $qtr_4_aca=mysqli_query($cnnTRP, $aca_qtr_4_sqlsafe);
                        $aca_qtr_4_count=mysqli_num_rows($qtr_4_aca);
                        
                        $mshs_qtr_1_sqlsafe="SELECT * FROM MS_to_HS_Over_Time WHERE Participant_ID=$program_id AND Quarter=1";
                        $qtr_1_mshs=mysqli_query($cnnTRP, $mshs_qtr_1_sqlsafe);
                        $mshs_qtr_1_count=mysqli_num_rows($qtr_1_mshs);
                        $mshs_qtr_2_sqlsafe="SELECT * FROM MS_to_HS_Over_Time WHERE Participant_ID=$program_id AND Quarter=2";
                        $qtr_2_mshs=mysqli_query($cnnTRP, $mshs_qtr_2_sqlsafe);
                        $mshs_qtr_2_count=mysqli_num_rows($qtr_2_mshs);
                        $mshs_qtr_3_sqlsafe="SELECT * FROM MS_to_HS_Over_Time WHERE Participant_ID=$program_id AND Quarter=3";
                        $qtr_3_mshs=mysqli_query($cnnTRP, $mshs_qtr_3_sqlsafe);
                        $mshs_qtr_3_count=mysqli_num_rows($qtr_3_mshs);
                        $mshs_qtr_4_sqlsafe="SELECT * FROM MS_to_HS_Over_Time WHERE Participant_ID=$program_id AND Quarter=4";
                        $qtr_4_mshs=mysqli_query($cnnTRP, $mshs_qtr_4_sqlsafe);
                        $mshs_qtr_4_count=mysqli_num_rows($qtr_4_mshs);
                        
                        //save the GPA and grade
                        if ($aca_qtr_1_count>0){
                        $first_gpa_sqlsafe="UPDATE Academic_Info SET GPA=" . mysqli_real_escape_string($cnnTRP, $exploded_line[4]) . " WHERE
                            Participant_ID=$program_id AND Quarter=1";
                        }else{$first_gpa_sqlsafe="INSERT INTO Academic_Info (Participant_ID, Quarter, GPA) VALUES ($program_id, 1, " . mysqli_real_escape_string($cnnTRP, $exploded_line[4]) . ")";}
                        if ($aca_qtr_2_count>0){
                        $second_gpa_sqlsafe="UPDATE Academic_Info SET GPA=" . mysqli_real_escape_string($cnnTRP, $exploded_line[8]) . " WHERE
                            Participant_ID=$program_id AND Quarter=2";
                        }else{$second_gpa_sqlsafe="INSERT INTO Academic_Info (Participant_ID, Quarter, GPA) VALUES ($program_id, 2, " . mysqli_real_escape_string($cnnTRP, $exploded_line[8]) . ")";}
                        if ($aca_qtr_3_count>0){
                        $third_gpa_sqlsafe="UPDATE Academic_Info SET GPA=" . mysqli_real_escape_string($cnnTRP, $exploded_line[13]) . " WHERE
                            Participant_ID=$program_id AND Quarter=3";
                        }else{$third_gpa_sqlsafe="INSERT INTO Academic_Info (Participant_ID, Quarter, GPA) VALUES ($program_id, 3, " . mysqli_real_escape_string($cnnTRP, $exploded_line[13]) . ")";}
                        if ($aca_qtr_4_count>0){
                        $fourth_gpa_sqlsafe="UPDATE Academic_Info SET GPA=" . mysqli_real_escape_string($cnnTRP, $exploded_line[18]) . " WHERE
                            Participant_ID=$program_id AND Quarter=4";
                        }else{$fourth_gpa_sqlsafe="INSERT INTO Academic_Info (Participant_ID, Quarter, GPA) VALUES ($program_id, 4, " . mysqli_real_escape_string($cnnTRP, $exploded_line[18]) . ")";}
                        
                        
                        //save tardies and absences
                        if ($mshs_qtr_1_count>0){
                            $first_attends_sqlsafe="UPDATE MS_to_HS_Over_Time SET
                            School_Tardies=" . mysqli_real_escape_string($cnnTRP, $exploded_line[5]) . ", School_Absences_Excused=" . mysqli_real_escape_string($cnnTRP, $exploded_line[7]) . ", School_Absences_Unexcused=" . mysqli_real_escape_string($cnnTRP, $exploded_line[6]) . ", 
                            WHERE Quarter=1 AND Participant_ID=$program_id";
                        }else{$first_attends_sqlsafe="INSERT INTO MS_to_HS_Over_Time (Participant_ID, School_Tardies, School_Absences_Excused, School_Absences_Unexcused,
                            Quarter) VALUES ('$program_id', " . mysqli_real_escape_string($cnnTRP, $exploded_line[5]) . ", " . mysqli_real_escape_string($cnnTRP, $exploded_line[7]) . ", " . mysqli_real_escape_string($cnnTRP, $exploded_line[6]) . ", 1)";}
                        if ($mshs_qtr_2_count>0){
                            $second_attends_sqlsafe="UPDATE MS_to_HS_Over_Time SET
                            School_Tardies=" . mysqli_real_escape_string($cnnTRP, $exploded_line[10]) . ", School_Absences_Excused=" . mysqli_real_escape_string($cnnTRP, $exploded_line[12]) . ", School_Absences_Unexcused=" . mysqli_real_escape_string($cnnTRP, $exploded_line[11]) . ", 
                            WHERE Quarter=2 AND Participant_ID=$program_id";
                        }else{$second_attends_sqlsafe="INSERT INTO MS_to_HS_Over_Time (Participant_ID, School_Tardies, School_Absences_Excused, School_Absences_Unexcused,
                            Quarter) VALUES ('$program_id', " . mysqli_real_escape_string($cnnTRP, $exploded_line[10]) . ", " . mysqli_real_escape_string($cnnTRP, $exploded_line[12]) . ", " . mysqli_real_escape_string($cnnTRP, $exploded_line[11]) . ", 2)";}
                            
                        if ($mshs_qtr_3_count>0){
                            $third_attends_sqlsafe="UPDATE MS_to_HS_Over_Time SET
                            School_Tardies=" . mysqli_real_escape_string($cnnTRP, $exploded_line[15]) . ", School_Absences_Excused=" . mysqli_real_escape_string($cnnTRP, $exploded_line[17]) . ", School_Absences_Unexcused=" . mysqli_real_escape_string($cnnTRP, $exploded_line[16]) . ", 
                            WHERE Quarter=3 AND Participant_ID=$program_id";
                        }else{$third_attends_sqlsafe="INSERT INTO MS_to_HS_Over_Time (Participant_ID, School_Tardies, School_Absences_Excused, School_Absences_Unexcused,
                            Quarter) VALUES ('$program_id', " . mysqli_real_escape_string($cnnTRP, $exploded_line[15]) . ", " . mysqli_real_escape_string($cnnTRP, $exploded_line[17]) . ", " . mysqli_real_escape_string($cnnTRP, $exploded_line[16]) . ", 3)";}
                        if ($mshs_qtr_4_count>0){
                            $fourth_attends_sqlsafe="UPDATE MS_to_HS_Over_Time SET
                            School_Tardies=" . mysqli_real_escape_string($cnnTRP, $exploded_line[20]) . ", School_Absences_Excused=" . mysqli_real_escape_string($cnnTRP, $exploded_line[22]) . ", School_Absences_Unexcused=" . mysqli_real_escape_string($cnnTRP, $exploded_line[21]) . ", 
                            WHERE Quarter=4 AND Participant_ID=$program_id";
                        }else{$fourth_attends_sqlsafe="INSERT INTO MS_to_HS_Over_Time (Participant_ID, School_Tardies, School_Absences_Excused, School_Absences_Unexcused,
                            Quarter) VALUES ('$program_id', " . mysqli_real_escape_string($cnnTRP, $exploded_line[20]) . ", " . mysqli_real_escape_string($cnnTRP, $exploded_line[22]) . ", " . mysqli_real_escape_string($cnnTRP, $exploded_line[21]) . ", 4)";}
                        
                        
                        //do the actual importing:
                       
                        if ($exploded_line[4]!=null){
                             echo $first_gpa_sqlsafe . "<br>";
                            $imported_record=mysqli_query($cnnTRP, $first_gpa_sqlsafe);
                            if (is_object($imported_record)) { 
                                echo "IMPORTED!\r\n";
                            } else {
                                echo "NOT IMPORTED... Already exists.\r\n";
                            }
                        }
                        mysqli_query($cnnTRP, $second_gpa_sqlsafe);
                        mysqli_query($cnnTRP, $third_gpa_sqlsafe);
                        mysqli_query($cnnTRP, $fourth_gpa_sqlsafe);
                        mysqli_query($cnnTRP, $first_attends_sqlsafe);
                        mysqli_query($cnnTRP, $second_attends_sqlsafe);
                        mysqli_query($cnnTRP, $third_attends_sqlsafe);
                        mysqli_query($cnnTRP, $fourth_attends_sqlsafe);
                        include "../include/dbconnclose.php";
                        
                            //create the reformatted line for import
//                        foreach ($exploded_line as $explosions){
//
//                            if ($counter==($explosion_length-1)){
//                                $new_line.=$explosions;
//                            }
//                            else{
//                                $new_line.=$explosions . "', '";
//                            }
//                            $counter++;
//                        }
//                        
//                       // echo "6";
//                        if (!in_array(ltrim($new_line), $dbs)) {
//                            array_push($dbs, ltrim($new_line));
//                        }
//                      //  echo "8";
//                        //set parent
//                        $parent = str_replace("\r\n", "", $line);
                        
                    }
                  //  else{
                        //this is for all the lines that are not actually programs, but rather other clutter
                       
                   // }
                    
//                   // echo $new_line;
//                    //insert into DB array
//                    echo "6";
//                    if (!in_array(ltrim($new_line), $dbs)) {
//                        array_push($dbs, ltrim($new_line));
//                    }

//                    echo "7";
//                    //insert into Table array
//                    if (!in_array($line, $tables)) {
//                        array_push($tables,
//                                    array(ltrim($line), str_replace("\r\n", "", $line)));
//                    }

                    
              //  }
            } 
        }
        echo "</pre>";

        fclose($handle);

        //summary
//        echo "DBs: <br /><pre>";
//        foreach ($dbs as $key => $val) {
//            print "$key = $val\n";
//
//            //open DB
//            include 'dbconnopen.php';
//            $import_query_sqlsafe= "Call Import__Activity_Status_Report('" . mysqli_real_escape_string($cnnTRP, $val) . "')";
//           // echo $import_query;
//            $imported_record = mysqli_query($cnnTRP, $import_query_sqlsafe);
//
//            if (is_object($imported_record)) { //->num_rows > 0) {
//                echo "IMPORTED!\r\n";
//            } else {
//                echo "NOT IMPORTED... Already exists.\r\n";
//            }
//
//            //close DB
//            include 'dbconnclose.php';
//        }
        //print_r($dbs);

        echo "<a href=\"import_grades.php\">Import Another</a>";

        


    }
    
    }
