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
user_enforce_has_access($SWOP_id);

/* search campaigns, though really just on name.  Not much to see here. */
if ($_POST['name']==''){$name_sqlsafe='';}else{$name_sqlsafe='  AND Campaign_Name LIKE "%' . mysqli_real_escape_string($cnnSWOP, $_POST['name']) .'%"';};

$search_campaigns_sqlsafe="SELECT * FROM Campaigns WHERE Campaign_ID!=''" . $name_sqlsafe;

include "../include/dbconnopen.php";
$results = mysqli_query($cnnSWOP, $search_campaigns_sqlsafe);

?>
<br/><h4>Search Results</h4>
    <table class="program_table" width="70%">
    <tr>
        <th>Matching Campaigns</th>
    </tr>
    <?
while ($prop=mysqli_fetch_array($results)){
    ?>
    <tr>
        <td class="all_projects" style="text-align:left;"><a href="javascript:;" onclick="$.post(
            '../ajax/set_campaign_id.php',
            {
                id: '<?echo $prop['Campaign_ID'];?>'
            },
            function (response){
            window.location='campaign_profile.php';})">
            <?echo $prop['Campaign_Name'];?></a></td>
       
    </tr>
	
        <?
}
include "../include/dbconnclose.php";
?>