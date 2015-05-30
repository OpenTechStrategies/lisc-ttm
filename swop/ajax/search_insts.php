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

/* search institutions by name and type. */
include "../include/dbconnopen.php";
if ($_POST['name']==''){$name_sqlsafe='';}else{$name_sqlsafe=' AND Institution_Name LIKE "%' . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . '%"';};
if ($_POST['type']==''){$type_sqlsafe='';}else{$type_sqlsafe=" AND Institution_Type LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['type']) . "%'";}

$uncertain_search_query_sqlsafe = "SELECT * FROM Institutions WHERE Institution_ID!='' " . $name_sqlsafe . $type_sqlsafe;
//echo $uncertain_search_query;

$results =mysqli_query($cnnSWOP, $uncertain_search_query_sqlsafe);
?>
<br/><h4>Search Results</h4>
    <table class="program_table" width="70%">
    <tr>
        <th>Matching Institutions</th>
    </tr>
    <?
while ($prop=mysqli_fetch_array($results)){
    ?>
    <tr>
        <td class="all_projects" style="text-align:left;"><a href="javascript:;" onclick="$.post(
            '../ajax/set_institution_id.php',
            {
                id: '<?echo $prop['Institution_ID'];?>'
            },
            function (response){
            window.location='inst_profile.php';})">
            <?echo $prop['Institution_Name'];?></a></td>
       
    </tr>
	
        <?
}
include "../include/dbconnclose.php";
?>

