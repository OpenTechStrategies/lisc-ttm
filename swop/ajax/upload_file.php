<?include "../../header.php";
include "../header.php";?>

<!-- Save a file to the database. -->

<div align="center" style="font-weight:bold; font-size: 24;">Thank you for uploading a file!</div> <br>
<?php
//print_r($_POST);
echo "Upload: " . $_FILES["file"]["name"] . "<br />";
echo "Type: " . $_FILES["file"]["type"] . "<br />";
echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";

/* only allowed types of files: */
$allowedExts = array("pdf", "doc", "docx");
$extension = end(explode(".", $_FILES["file"]["name"]));

if (($_FILES["file"]["size"] < 1000000)
        && in_array($extension, $allowedExts)) { 
    /* if file isn't too big and is of a correct type: */
    include ("../include/dbconnopen.php");
    
    if (isset($_POST['event_id'])) {
        $fileName = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];

        /* read file content into a variable. */
        $file_open_temp = fopen($tmpName, 'r');
        $file_content = fread($file_open_temp, filesize($tmpName));
        $file_content = mysqli_real_escape_string($cnnSWOP, $file_content);
        fclose($file_open_temp);

        /* escape special characters: */
        
        $fileName = mysqli_real_escape_string($cnnSWOP, $fileName);
            
        
        
        $query = "INSERT INTO Property_Files (Property_ID, File_Name, File_Size, File_Type, File_Content) VALUES 
            ('".$_POST['event_id']."', '$fileName', '$fileSize', '$fileType', '$file_content')";
        
        mysqli_query($cnnSWOP, $query) or die('Error, query failed'); 
        include ("../include/dbconnclose.php");

        echo "<br>File $fileName uploaded<br>";
    } else {
        echo "<br>Please select an event.";
    }
} 
else {
    echo "<div align='center' style='font-weight:bold; font-size: 24;'>Invalid File: This file is either too large or not an approved type.</div>";
}
?>
<br>
<a href="/swop/properties/profile.php">Click here to return to the property profile.</a>