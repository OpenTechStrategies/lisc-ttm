<?php
/* PM_Years is the new way to track where and when people are active parent mentors
 *  saves the year and school for new (and old) parent mentors.
 */
include "../include/dbconnopen.php";
$school_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['school']);
$year_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['year']);
$id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);
$reset_affiliation="UPDATE PM_Years SET School='".$school_sqlsafe."',
    Year='".$year_sqlsafe."'
        WHERE PM_Year_ID='".$id_sqlsafe."'";
mysqli_query($cnnLSNA, $reset_affiliation);
include "../include/dbconnclose.php";

/*else{
$update_inst_link = "UPDATE Institutions_Participants SET Year_" . $_POST['year'] . "=1,
    Is_PM=1
    WHERE Institutions_Participants_ID='" . $_POST['link_id'] . "'";
echo $update_inst_link;

include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $update_inst_link);
include "../include/dbconnclose.php";}*/
?>
