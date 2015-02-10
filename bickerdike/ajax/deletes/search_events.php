<?php
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['name']);
$org_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['org']);
$type_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
$start_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['start']);
$end_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['end']);
if ($_POST['name']==''){$first_sqlsafe='';}else{$first_sqlsafe=' AND Activity_Name LIKE "%' . $name_sqlsafe . '%"';};
if ($_POST['org']==''){$last_sqlsafe='';}else{$last_sqlsafe=" AND Activity_Org='" . $org_sqlsafe . "'";}
if ($_POST['type']==''){$type_sqlsafe='';}else{$type_sqlsafe=" AND Activity_Type='" .$type_sqlsafe . "'";}
if ($_POST['start']==''){$start_sqlsafe='';}else{$start_sqlsafe=" AND Activity_Date>='" . $start_sqlsafe . "'";}
if ($_POST['end']==''){$end_sqlsafe='';}else{$end_sqlsafe=" AND Activity_Date<='" .$end_sqlsafe . "'";}


$uncertain_search_query_sqlsafe = "SELECT * FROM User_Established_Activities WHERE User_Established_Activities_ID!='' " . $first_sqlsafe . $last_sqlsafe .  $type_sqlsafe . $start_sqlsafe . $end_sqlsafe;
//echo $uncertain_search_query_sqlsafe;

$results =mysqli_query($cnnBickerdike, $uncertain_search_query_sqlsafe);
?>
    <table class="program_table">
        <tr><th colspan="5">Search Results</th></tr>
    <tr>
        <th>Name</th>
        <th>Organization</th>
        <th>Date</th>
    </tr>
    <?
while ($activity=mysqli_fetch_array($results)){
    ?>
    <tr>
        <td class="all_projects"><a href="activity_profile.php?activity=<?echo $activity['User_Established_Activities_ID'];?>">
            <?echo $activity['Activity_Name'];?></a></td>
        <td class="all_projects"><?echo $activity['Activity_Org'];?></td>
        <td class="all_projects"><?echo $activity['Activity_Date'];?></td>
    </tr>
        <?
}
include "../include/dbconnclose.php";
?>