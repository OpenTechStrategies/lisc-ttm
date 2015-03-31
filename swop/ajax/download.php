<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);

if(isset($_GET['id'])) 
{
// if id is set then get the file with the id from database
/*download the file.*/
include ("../include/dbconnopen.php");
$id_sqlsafe=mysqli_real_escape_string($cnnSWOP, $_GET['id']);
$query = "SELECT File_Name, File_Type, File_Size, File_Content FROM Property_Files WHERE File_ID = '$id_sqlsafe'";

$result = mysqli_query($cnnSWOP, $query) or die('Error, query failed');
list($name, $type, $size, $content)= mysqli_fetch_array($result);

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $content;

include ("../include/dbconnclose.php"); 
exit;
}

?>
