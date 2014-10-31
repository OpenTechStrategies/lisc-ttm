<?php
require_once("../siteconfig.php");
?>
<?php
/*download a previously uploaded file.*/
if(isset($_GET['id'])) 
{
// if id is set then get the file with the id from database

include ("../include/dbconnopen.php");
$id=$_GET['id'];
$id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $id);
$query = "SELECT Note_File_Name, Note_File_Type, Note_File_Size, Note_File_Content FROM Campaigns_Events WHERE Campaign_Event_ID = '$id_sqlsafe'";

$result = mysqli_query($cnnEnlace, $query) or die('Error, query failed');
list($name, $type, $size, $content)= mysqli_fetch_array($result);

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $content;

include ("../include/dbconnclose.php"); 
exit;
}

?>
