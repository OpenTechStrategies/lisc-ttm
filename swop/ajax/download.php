<?php
if(isset($_GET['id'])) 
{
// if id is set then get the file with the id from database
/*download the file.*/
include ("../include/dbconnopen.php");
$id=$_GET['id'];
$query = "SELECT File_Name, File_Type, File_Size, File_Content FROM Property_Files WHERE File_ID = '$id'";

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
