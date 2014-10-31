<?php
require_once("../siteconfig.php");
?>
<?include "../../header.php";
include "../header.php";?>

<div align="center" style="font-weight:bold; font-size: 24;">Thank you for uploading a file!</div> <br>
<?php
/*add a file to the database.*/

//print_r($_POST);
echo "Upload: " . $_FILES["file"]["name"] . "<br />";
echo "Type: " . $_FILES["file"]["type"] . "<br />";
echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";

/*make sure the filetype is allowed.*/
$allowedExts = array("pdf", "doc", "docx", "zip", "xls", "xlsx");
$extension = end(explode(".", $_FILES["file"]["name"]));
//echo $_FILES['file']['size'];
//print_r($allowedExts);
if (($_FILES["file"]["size"] < 1000000)
        && in_array($extension, $allowedExts)) { //(($_FILES["file"]["type"] == "application/pdf")|| ($_FILES["file"]["type"] == "application/msword")) && 
   // echo "<Br> got into the db condition <br>";
    include ("../include/dbconnopen.php");
//  if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
//{
    
    /*if id is set correctly, then run the query.*/
    if (isset($_POST['event_id'])) {
        $fileName = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];

        $file_open_temp = fopen($tmpName, 'r');
        $file_content = fread($file_open_temp, filesize($tmpName));
        //echo $file_content . "<br><br>";
        $file_content = mysqli_real_escape_string($cnnEnlace, $file_content);
        fclose($file_open_temp);

        /*not sure what this is about, but I suspect it prevents errors with slashes and other
         * special characters.
         */
        
        $fileName = mysqli_real_escape_string($cnnEnlace, $fileName);
          //  echo 'escaped';
        
        //echo $fileName . "<br>";
//echo "INSERT INTO Uploaded_Files (Observation_ID, File_Name, File_Size, File_Type, File_Content ) VALUES (" . $_COOKIE['session_id'] . ", '$fileName', '$fileSize', '$fileType', 'content')";
        
        /*add file to db.*/
        $query = "UPDATE Campaigns_Events SET Note_File_Name= '$fileName',
        Note_File_Size='$fileSize',
        Note_File_Type='$fileType',
        Note_File_Content='$file_content'
               WHERE Campaign_Event_ID='".$_POST['event_id']."'";
        //echo "<br>";
        //echo $query . "<br/>";
        mysqli_query($cnnEnlace, $query) or die('Error, query failed'); 
        //echo "<br>" . "error";
        //printf("Errormessage: %s\n", mysqli_error($cnnEnlace));
        include ("../include/dbconnclose.php");

        echo "<br>File $fileName uploaded<br>";
    } else {
        echo "<br>Please select an observation.";
    }
} 
else {
    echo "<div align='center' style='font-weight:bold; font-size: 24;'>Invalid File: This file is either too large or not an approved type.</div>";
}
?>
<br>
<a href="/enlace/campaigns/campaign_profile.php">Click here to return to the campaign profile.</a>