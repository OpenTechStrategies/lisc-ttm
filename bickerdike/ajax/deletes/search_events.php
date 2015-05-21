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
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id, $DataEntryAccess);

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