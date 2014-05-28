<?php
if ($_POST['name']==''){$first='';}else{$first=' AND Activity_Name LIKE "%' . $_POST['name'] . '%"';};
if ($_POST['org']==''){$last='';}else{$last=" AND Activity_Org='" . $_POST['org'] . "'";}
if ($_POST['type']==''){$type='';}else{$type=" AND Activity_Type='" .$_POST['type'] . "'";}
if ($_POST['start']==''){$start='';}else{$start=" AND Activity_Date>='" . $_POST['start'] . "'";}
if ($_POST['end']==''){$end='';}else{$end=" AND Activity_Date<='" .$_POST['end'] . "'";}


$uncertain_search_query = "SELECT * FROM User_Established_Activities WHERE User_Established_Activities_ID!='' " . $first . $last .  $type . $start . $end;
//echo $uncertain_search_query;

include "../include/dbconnopen.php";
$results =mysqli_query($cnnBickerdike, $uncertain_search_query);
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