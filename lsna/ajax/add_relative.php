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

include "../include/dbconnopen.php";
$parent_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['parent']);
$child_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['child']);
$person_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['person']);
$spouse_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['spouse']);

if (isset($_POST['parent'])){
/*add parent-child link between two people who are already in the database. */

$add_relative = "INSERT INTO Parent_Mentor_Children (Parent_ID, Child_ID)
    VALUES ('" . $parent_sqlsafe . "', '" . $child_sqlsafe . "')";
}
else{
    $add_relative = "INSERT INTO Parent_Mentor_Children (Parent_ID, Spouse_ID) VALUES ('" . $person_sqlsafe . "', '" . $spouse_sqlsafe . "')";
}
mysqli_query($cnnLSNA, $add_relative);
include "../include/dbconnclose.php";

?>
