<?php
/* save elev8 aggregate data.  The "Element" is the 
 * piece of data that is being saved. */

/* or, delete elements: */
if ($_POST['action']=='delete'){
    $query="DELETE FROM Elev8_Data WHERE Elev8_ID='".$_POST['id']."'";
echo $query;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $query);
include "../include/dbconnclose.php";
}
else{
$query="INSERT INTO Elev8_Data (Month, Year, Element, Value) VALUES ('".$_POST['month']."',
    '".$_POST['year']."',
        '".$_POST['element']."',
            '".$_POST['value']."' )";
echo $query;
include "../include/dbconnopen.php";
mysqli_query($cnnTRP, $query);
include "../include/dbconnclose.php";
}
?>
