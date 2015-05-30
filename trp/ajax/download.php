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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

/* download a saved file from the database.  In TRP, these are generally program notes uploads. */
if(isset($_GET['id'])) 
{
// if id is set then get the file with the id from database

include ("../include/dbconnopen.php");
$id_sqlsafe=mysqli_real_escape_string($cnnTRP, $_GET['id']);
$query_sqlsafe = "SELECT File_Name, File_Type, File_Size, File_Content FROM Programs_Uploads WHERE Upload_ID = '$id_sqlsafe'";
//echo $query_sqlsafe;
$result = mysqli_query($cnnTRP, $query_sqlsafe) or die('Error, query failed');
list($name, $type, $size, $content)= mysqli_fetch_array($result);

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $content;

include ("../include/dbconnclose.php"); 
exit;
}

?>
