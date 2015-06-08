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

user_enforce_has_access($LSNA_id, $DataEntryAccess);

/*Create new institutions.*/

/*get the block group with the new institution's address: */
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
$this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['street_name'] . " " .$_POST['type'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);
        
include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['name']);
$inst_type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['inst_type']);
$num_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['num']);
$dir_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['dir']);
$street_name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['street_name']);
$type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['type']);
$new_inst_query = "INSERT INTO Institutions (
    Institution_Name,
	Institution_Type,
    Street_Num,
    Street_Direction,
    Street_Name,
    Street_Type) VALUES (
    '" . $name_sqlsafe . "',
	'" . $inst_type_sqlsafe . "',
    '" . $num_sqlsafe . "',
    '" . $dir_sqlsafe . "',
    '" . $street_name_sqlsafe . "',
    '" . $type_sqlsafe . "'
    )";
mysqli_query($cnnLSNA, $new_inst_query);
$id = mysqli_insert_id($cnnLSNA);
include "../include/dbconnclose.php";
?>

<!--success message, with link to institution profile: -->
<span style="font-color:#006600; font-weight:bold">Thank you for adding <?echo $_POST['name'];?> to the database. </span> <a href="javascript:;" onclick="
		$('#institution_search_div').hide();
        $('#new_institution_div').hide();
        $('#institution_profile_div').show();
                   $.post(
                        '/lsna/ajax/set_institution_id.php',
                        {
                            page: 'profile',
                            id: '<?php echo $id; ?>'
                        },
                        function (response){
                            if (response!='1'){
                                document.getElementById('show_error').innerHTML = response;
                            }
                            window.location='/lsna/institutions/institution_profile.php';
                       }
           );
"><em>View profile</em></a>
