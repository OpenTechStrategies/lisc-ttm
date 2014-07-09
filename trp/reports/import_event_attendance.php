<?php
function convert_string($string) {
    //converts smart quotes / dashes to normal quotes / dashes.
    $search = array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(152));
    $replace = array("'", "'", '"', '"', '-', '-', '-');
    return str_replace($search, $replace, $string);
}

include "../../header.php";
include "../header.php";
include "../reports/report_menu.php";
?>
<script type="text/javascript">
    $(document).ready(function() {
        var element = document.getElementsByName('search_criteria')[1];
        if ((typeof (element) != 'undefined') && (element != null)) {
            document.getElementsByName('search_criteria')[1].focus();
        }
        $('#reports_selector').addClass('selected');
    });
</script>

<!-- This is likely not relevant.  It was built for TRP's use before the DB went live.  Maggie made an Excel template
for them to record event attendance.  This import script pulls in that template.
-->

<h3>Import Event Attendance:</h3>
<span style="text-align:center; color:#C11B17; font-weight:bold;">Alert: This import will only work if you are using the event attendance template provided by Chapin Hall.  The columns should be 
    Event Name, Event Date, First Name, Last Name, Email Address, Date of Birth, Address Number, Direction, Street, Street Type, City,
    and State.  If you are not using this template, the import will not work and may cause malfunctions.</span><br><br/>
<span style="text-align:center; color:#C11B17; font-weight:bold;">Dates should be entered in mm/dd/yyyy format.
</span><br/><br/>
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

    <form action="import_event_attendance.php" method="post" enctype="multipart/form-data">
        1. <input type="file" name="first_file" /><br /><br />
        <input type="hidden" name="posted" />
        2. <input type="submit" value="Submit" />
    </form>

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
        while ((!feof($handle))) {// && ($count > 0)) {
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



                $explosion_length = count($exploded_line);
                $counter = 0;
                $new_line = '';

                //only do this if the first element is in fact a program name (not a title row)
                if ($exploded_line[0] == '"LISC TTM Data Center - The Resurrection Project' ||
                        $exploded_line[0] == 'Event Attendance Data Entry Template"' ||
                        $exploded_line[0] == '"Please enter attendance data for TRP events into this template while your database is under construction.' ||
                        $exploded_line[0] == "The first four fields are required" ||
                        $exploded_line[0] == "Event Information" ||
                        $exploded_line[0] == "Event Name" ||
                        $exploded_line[1] === null) {
                    echo 'problem: ' . $exploded_line[0] . '<br>';
                } else {
                    //print_r($exploded_line);
                    //first enter or find the event that's listed
                    //in order to do so, change date from excel format to mysql format:
                    $date_pieces = explode('/', $exploded_line[1]);
                    $new_date = $date_pieces[2] . '-' . $date_pieces[0] . '-' . $date_pieces[1];

                    $get_event_name = "SELECT * FROM Events WHERE Event_Name='$exploded_line[0]' AND Event_Date='$new_date'";
                    //echo $get_event_name;
                    include "../include/dbconnopen.php";
                    $event_name = mysqli_query($cnnTRP, $get_event_name);
                    //test whether the event already exists or not
                    if (mysqli_num_rows($event_name) > 0) {
                        $event = mysqli_fetch_row($event_name);
                        $event_id = $event[0];
                    } else {
                        //if it doesn't exist yet, then insert it
                        $add_event = "INSERT INTO Events (Event_Name, Event_Date, Active)
                             VALUES ('$exploded_line[0]', '$new_date', 1)";
                        //echo $add_event . "<br>";
                        mysqli_query($cnnTRP, $add_event);
                        $event_id = mysqli_insert_id($cnnTRP);
                    }

                    //next, find or enter the attendee
                    //I'm going to assume (yikes!) that they'll write names as last name comma first name.  We shall see.

                    $find_person = "SELECT * FROM Participants WHERE First_Name='" . addslashes($exploded_line[2]) . "' AND 
                            Last_Name='" . addslashes($exploded_line[3]) . "'";
                    // echo $find_person;
                    include "../include/dbconnopen.php";
                    $person_name = mysqli_query($cnnTRP, $find_person);
                    //test whether the person already exists or not
                    if (mysqli_num_rows($person_name) > 0) {
                        $person = mysqli_fetch_row($person_name);
                        $person_id = $person[0];
                    } else {
                        //if it doesn't exist yet, then insert it
                        $add_person = "INSERT INTO Participants (First_Name, Last_Name)
                             VALUES ('" . addslashes($exploded_line[2]) . "', '" . addslashes($exploded_line[3]) . "')";
                        // echo $add_person . "<br>";
                        mysqli_query($cnnTRP, $add_person);
                        $person_id = mysqli_insert_id($cnnTRP);
                    }

                    //finally, put them together in the Events_Participants table
                    $add_attendee = "INSERT INTO Events_Participants (Event_ID, Participant_ID) VALUES ($event_id, $person_id)";
                    mysqli_query($cnnTRP, $add_attendee);

                    include "../include/dbconnclose.php";
                }
            }
        }
        echo "</pre>";
        fclose($handle);

        echo "<a href=\"import_event_attendance.php\">Import Another</a>";
    }
}
?>
<br/><br/>

<?php include "../../footer.php"; ?>