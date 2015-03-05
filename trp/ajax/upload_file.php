<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

 include "../../header.php";
include "../header.php";
?>
<!-- File that saves a file in the DB: -->
<div align="center" style="font-weight:bold; font-size: 24;">Thank you for uploading a file!</div> <br>
<?php
echo "Upload: " . $_FILES["file"]["name"] . "<br />";
echo "Type: " . $_FILES["file"]["type"] . "<br />";
echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";

/* allowed file types: */
$allowedExts = array("pdf", "doc", "docx", "zip", "tiff", "tif", "csv");
$extension = end(explode(".", $_FILES["file"]["name"]));

/* if the file isn't too big and is of the correct type: */
if (($_FILES["file"]["size"] < 1000000)
        && in_array($extension, $allowedExts)) { 
    
    include ("../include/dbconnopen.php");
    /* if the event or person is set, then this file can be associated with the correct ID: */
    if (isset($_POST['event_id']) || isset($_POST['person_id'])) {
        $fileName_sqlsafe = mysqli_real_escape_string($cnnTRP, $_FILES['file']['name']);
        $tmpName = $_FILES['file']['tmp_name'];
        $fileSize_sqlsafe = mysqli_real_escape_string($cnnTRP, $_FILES['file']['size']);
        $fileType_sqlsafe = mysqli_real_escape_string($cnnTRP, $_FILES['file']['type']);

        $file_open_temp = fopen($tmpName, 'r');
        $file_content = fread($file_open_temp, filesize($tmpName));
        $file_content_sqlsafe = mysqli_real_escape_string($cnnTRP, $cnnTRP, $file_content);
        fclose($file_open_temp);

        if (isset($_POST['person_id'])){
        $query_sqlsafe = "INSERT INTO Programs_Uploads (File_Name, File_Size, File_Type, File_Content, Program_ID, Participant_ID, Year) VALUES 
        ('$fileName_sqlsafe', '$fileSize_sqlsafe', '$fileType_sqlsafe', '$file_content_sqlsafe', '" . mysqli_real_escape_string($cnnTRP, $_POST['event_id']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['person_id']) . "', '" . mysqli_real_escape_string($cnnTRP, $_POST['year']) . "')";
        }
        else{
            $query_sqlsafe = "INSERT INTO Programs_Uploads (File_Name, File_Size, File_Type, File_Content, Program_ID, Year) VALUES 
        ('$fileName_sqlsafe', '$fileSize_sqlsafe', '$fileType_sqlsafe', '$file_content_sqlsafe', '" . mysqli_real_escape_string($cnnTRP, $_POST['event_id']) . "',  '" . mysqli_real_escape_string($cnnTRP, $_POST['year']) . "')";
        }
       // echo $query_sqlsafe;
        mysqli_query($cnnTRP, $query_sqlsafe) or die('Error, query failed'); 
        
        include ("../include/dbconnclose.php");

        echo "<br>File $fileName_sqlsafe uploaded<br>";
    } else {
        /* If the event or person isn't set, then the file can't be saved. */
        echo "<br>Please select an event or person.";
    }
} 
else {
    echo "<div align='center' style='font-weight:bold; font-size: 24;'>Invalid File: This file is either too large or not an approved type.</div>";
}
?>
<br>
<?if ($_POST['event_id']!=''){?>
<a href="/trp/programs/profile.php?id=<?echo $_POST['event_id']?>">Click here to return to the program profile.</a>
<?}
elseif($_POST['person_id']!=''){
    ?>
        <a href="/trp/participants/profile.php?id=<?echo $_POST['person_id']?>">Click here to return to the participant profile.</a>
        <?
}
?>
