<?php
require_once("../siteconfig.php");
?>
<?php
/*check for duplicate campaigns (warn before creating two campaigns with the same name)*/

include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['name']);
$get_duplicate_campaigns = "SELECT COUNT(Campaign_Name) FROM Campaigns
    WHERE Campaign_Name='" . $name_sqlsafe . "'";
//echo $get_duplicate_campaigns;
$is_duplicate = mysqli_query($cnnEnlace, $get_duplicate_campaigns);
$duplicate = mysqli_fetch_row($is_duplicate);
if ($duplicate[0]>0){
    echo 'A campaign named ' .  $_POST['name'] . ' is already in the database.  Are you sure you want to enter this campaign?';
}
include "../include/dbconnclose.php";

?>
