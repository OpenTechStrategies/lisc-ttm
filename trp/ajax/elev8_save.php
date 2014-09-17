<?php
/* save elev8 aggregate data.  The "Element" is the 
 * piece of data that is being saved. */

/* or, delete elements: */
if ($_POST['action']=='delete'){
include "../include/dbconnopen.php";
  $query_sqlsafe="DELETE FROM Elev8_Data WHERE Elev8_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
mysqli_query($cnnTRP, $query_sqlsafe);
include "../include/dbconnclose.php";
}
else{
include "../include/dbconnopen.php";
  $query_sqlsafe="INSERT INTO Elev8_Data (Month, Year, Element, Value) VALUES ('" . mysqli_real_escape_string($cnnTRP, $_POST['month']) . "',
    '" . mysqli_real_escape_string($cnnTRP, $_POST['year']) . "',
        '" . mysqli_real_escape_string($cnnTRP, $_POST['element']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['value']) . "' )";
mysqli_query($cnnTRP, $query_sqlsafe);
include "../include/dbconnclose.php";
}
?>
