<?php
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
