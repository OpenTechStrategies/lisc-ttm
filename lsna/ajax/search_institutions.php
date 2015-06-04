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

user_enforce_has_access($LSNA_id);

/* searching institutions: */

include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['name']);
$type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['type']);
if ($_POST['name'] == '') {
    $name = '';
} else {
    $name = ' AND Institution_Name LIKE "%' . $name_sqlsafe . '%"';
};
if ($_POST['type'] == '') {
    $type = '';
} else {
    $type = " AND Institution_Type LIKE '%" . $type_sqlsafe . "%'";
}

$inst_search_query = "SELECT * FROM Institutions WHERE Institution_ID!='' " . $name . $type
                    . " ORDER BY Institution_Name";
$inst_results = mysqli_query($cnnLSNA, $inst_search_query);
include "../include/dbconnclose.php";
?>
<!--Table of institution results: -->
<h4>Search Results</h4>
<table class="program_table">
    <tr><th>Institution Name</th></tr>
               <?php
               while ($inst = mysqli_fetch_array($inst_results)) {
                   ?><tr><td><a href="javascript:;"
                   onclick="
                               $('#institution_search_div').hide();
                               $('#new_institution_div').hide();
                               $('#institution_profile_div').show();
                               $.post(
                                       '/lsna/ajax/set_institution_id.php',
                                       {
                                           page: 'profile',
                                           id: '<?php echo $inst['Institution_ID']; ?>'
                                       },
                               function(response) {
                                   if (response != '1') {
                                       document.getElementById('show_error').innerHTML = response;
                                   }
                                   document.write(response);
                                   window.location = '/lsna/institutions/institution_profile.php';
                               }
                               );"
                   ><?php echo $inst['Institution_Name']; ?></a></td>
<?php
                     if ($USER->has_site_access($LSNA_id, $AdminAccess)){
?>
            <td >
                <!--option to delete institutions if necessary: -->
                <input type="button" value="Delete This Institution" onclick="
                        var double_check = confirm('Are you sure you want to delete this institution from the database?  This action cannot be undone.');
                        if (double_check) {
                            $.post(
                                    '../ajax/delete_elements.php',
                                    {
                                        action: 'institution',
                                        id: '<?php echo $inst['Institution_ID']; ?>'
                                    },
                            function(response) {
                                //document.write(response);
                                alert('This institution has been successfully deleted.');
                            }
                            );
                        }
                       ">
            </td>
<?php
                     } //end access check
?></tr><?php
               }
               ?>
</table><br/>
