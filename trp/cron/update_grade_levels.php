<?php
require_once("../siteconfig.php");
?>
<?php
//This updates the Grade_Level (to [Grade_Level + 1]) of the Academic_Info
//table that are not NULL. This should run on July 1 of every year.
//The log file (./update_grade_levels.log) keeps track of the last year it
//was run.
date_default_timezone_set('America/Chicago');
$today = getdate();

//read the first line of the log file
$f = fopen("./update_grade_levels.log", 'r');
$first_line = fgets($f);
echo "Last Run In: " . $first_line . "<br /><br />";
fclose($f);

//if the first line is the same year, 
if ($today['year'] == $first_line) {
    echo "This can only be run once per year.";
    return;
} else {
    if ($_GET['update'] == "grade_levels") {
        $today = getdate();
        //if today is July 1, then run the query
        if (($today['mon'] == 1) && ($today['mday'] == 2)) {
            $update_grade_level_sqlsafe = "UPDATE Academic_Info
                                    SET Grade_Level = (Grade_Level - 1)
                                    WHERE Grade_Level > 0 AND
                                        Grade_Level IS NOT NULL";
            include "../include/dbconnopen.php";
            if (mysqli_query($cnnTRP, $update_grade_level_sqlsafe)) {
                echo "Success: Updated all grade levels.";
                
                //update log file
                $f = fopen("./update_grade_levels.log", 'w');
                fwrite($f, $today['year']);
                fclose($f);
            } else {
                echo "Failed: Grade levels not updated.";
            }
            include "../include/dbconnclose.php";
        } else {
            echo "Today is not the correct date to run this. This should only be "
                . "run on July 1 of every year.";
        }
    } else {
        echo "Incorrect query string. <br /><br />To go forward and actually update"
            . " all grade levels, add '?update=grade_levels' to the URL.";
    }
}
?>